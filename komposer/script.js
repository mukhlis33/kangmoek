class MusicComposer {
    constructor() {
        this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        this.currentInstrument = 'piano';
        this.volume = 0.7;
        this.bpm = 120;
        this.isPlaying = false;
        this.isRecording = false;
        this.recordedNotes = [];
        this.savedCompositions = JSON.parse(localStorage.getItem('compositions')) || [];
        this.currentStep = 0;
        this.sequencerInterval = null;
        
        this.initializeElements();
        this.createKeyboard();
        this.createSequencer();
        this.loadSavedCompositions();
        this.setupEventListeners();
    }

    initializeElements() {
        this.instrumentSelect = document.getElementById('instrument');
        this.volumeSlider = document.getElementById('volume');
        this.volumeValue = document.getElementById('volume-value');
        this.bpmSlider = document.getElementById('bpm');
        this.bpmValue = document.getElementById('bpm-value');
        this.playBtn = document.getElementById('play-btn');
        this.stopBtn = document.getElementById('stop-btn');
        this.clearBtn = document.getElementById('clear-btn');
        this.recordBtn = document.getElementById('record-btn');
        this.saveBtn = document.getElementById('save-btn');
        this.loadBtn = document.getElementById('load-btn');
        this.keyboard = document.getElementById('keyboard');
        this.sequencerTrack = document.getElementById('sequencer-track');
        this.savedCompositionsList = document.getElementById('saved-compositions');
    }

    createKeyboard() {
        const notes = [
            'C4', 'Db4', 'D4', 'Eb4', 'E4', 'F4', 'Gb4', 'G4', 'Ab4', 'A4', 'Bb4', 'B4',
            'C5', 'Db5', 'D5', 'Eb5', 'E5', 'F5', 'Gb5', 'G5', 'Ab5', 'A5', 'Bb5', 'B5'
        ];

        notes.forEach(note => {
            const key = document.createElement('div');
            const isBlack = note.includes('b');
            
            key.className = `key ${isBlack ? 'black' : 'white'}`;
            key.dataset.note = note;
            
            key.addEventListener('mousedown', () => this.playNote(note));
            key.addEventListener('touchstart', (e) => {
                e.preventDefault();
                this.playNote(note);
            });
            
            this.keyboard.appendChild(key);
        });
    }

    createSequencer() {
        this.sequencerTrack.innerHTML = '';
        for (let i = 0; i < 16; i++) {
            const step = document.createElement('div');
            step.className = 'step';
            step.dataset.step = i;
            
            step.addEventListener('click', () => {
                step.classList.toggle('active');
            });
            
            this.sequencerTrack.appendChild(step);
        }
    }

    setupEventListeners() {
        this.instrumentSelect.addEventListener('change', (e) => {
            this.currentInstrument = e.target.value;
        });

        this.volumeSlider.addEventListener('input', (e) => {
            this.volume = e.target.value / 100;
            this.volumeValue.textContent = `${e.target.value}%`;
        });

        this.bpmSlider.addEventListener('input', (e) => {
            this.bpm = parseInt(e.target.value);
            this.bpmValue.textContent = this.bpm;
            if (this.isPlaying) {
                this.stopSequencer();
                this.startSequencer();
            }
        });

        this.playBtn.addEventListener('click', () => this.startSequencer());
        this.stopBtn.addEventListener('click', () => this.stopSequencer());
        this.clearBtn.addEventListener('click', () => this.clearSequencer());
        
        this.recordBtn.addEventListener('click', () => this.toggleRecording());
        this.saveBtn.addEventListener('click', () => this.saveComposition());
        this.loadBtn.addEventListener('click', () => this.loadComposition());

        // Keyboard events
        document.addEventListener('keydown', (e) => {
            if (e.repeat) return;
            
            const keyMap = {
                'a': 'C4', 'w': 'Db4', 's': 'D4', 'e': 'Eb4', 'd': 'E4',
                'f': 'F4', 't': 'Gb4', 'g': 'G4', 'y': 'Ab4', 'h': 'A4',
                'u': 'Bb4', 'j': 'B4', 'k': 'C5', 'o': 'Db5', 'l': 'D5',
                'p': 'Eb5', ';': 'E5'
            };
            
            if (keyMap[e.key]) {
                this.playNote(keyMap[e.key]);
                this.highlightKey(keyMap[e.key]);
            }
        });
    }

    playNote(note, duration = 0.5) {
        if (this.isRecording) {
            this.recordedNotes.push({
                note,
                time: Date.now(),
                instrument: this.currentInstrument
            });
        }

        const oscillator = this.audioContext.createOscillator();
        const gainNode = this.audioContext.createGain();
        
        // Set waveform based on instrument
        switch(this.currentInstrument) {
            case 'piano':
                oscillator.type = 'sine';
                break;
            case 'guitar':
                oscillator.type = 'sawtooth';
                break;
            case 'flute':
                oscillator.type = 'sine';
                break;
            case 'violin':
                oscillator.type = 'sawtooth';
                break;
            case 'drums':
                oscillator.type = 'square';
                break;
        }

        // Calculate frequency from note
        const frequency = this.noteToFrequency(note);
        oscillator.frequency.setValueAtTime(frequency, this.audioContext.currentTime);
        
        // Apply volume
        gainNode.gain.setValueAtTime(this.volume, this.audioContext.currentTime);
        
        // Connect nodes
        oscillator.connect(gainNode);
        gainNode.connect(this.audioContext.destination);
        
        // Apply envelope
        const now = this.audioContext.currentTime;
        gainNode.gain.exponentialRampToValueAtTime(0.001, now + duration);
        
        oscillator.start();
        oscillator.stop(now + duration);
        
        this.highlightKey(note);
    }

    noteToFrequency(note) {
        const A4 = 440;
        const notes = ['C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B'];
        
        const noteName = note.slice(0, -1);
        const octave = parseInt(note.slice(-1));
        
        const noteIndex = notes.indexOf(noteName);
        const stepsFromA4 = (octave - 4) * 12 + (noteIndex - 9);
        
        return A4 * Math.pow(2, stepsFromA4 / 12);
    }

    highlightKey(note) {
        const key = document.querySelector(`[data-note="${note}"]`);
        if (key) {
            key.classList.add('active');
            setTimeout(() => key.classList.remove('active'), 200);
        }
    }

    startSequencer() {
        if (this.isPlaying) return;
        
        this.isPlaying = true;
        this.playBtn.disabled = true;
        this.stopBtn.disabled = false;
        
        const stepDuration = (60 / this.bpm) / 4; // 16th notes
        
        this.sequencerInterval = setInterval(() => {
            const steps = document.querySelectorAll('.step');
            
            // Remove current step highlight
            steps.forEach(step => step.classList.remove('current'));
            
            // Highlight current step
            if (steps[this.currentStep]) {
                steps[this.currentStep].classList.add('current');
                
                // Play note if step is active
                if (steps[this.currentStep].classList.contains('active')) {
                    const notes = ['C4', 'E4', 'G4', 'C5'];
                    const randomNote = notes[Math.floor(Math.random() * notes.length)];
                    this.playNote(randomNote, 0.3);
                }
            }
            
            this.currentStep = (this.currentStep + 1) % 16;
        }, stepDuration * 1000);
    }

    stopSequencer() {
        this.isPlaying = false;
        this.playBtn.disabled = false;
        this.stopBtn.disabled = true;
        this.currentStep = 0;
        
        if (this.sequencerInterval) {
            clearInterval(this.sequencerInterval);
            this.sequencerInterval = null;
        }
        
        // Remove all current step highlights
        document.querySelectorAll('.step').forEach(step => {
            step.classList.remove('current');
        });
    }

    clearSequencer() {
        document.querySelectorAll('.step').forEach(step => {
            step.classList.remove('active');
        });
        this.recordedNotes = [];
    }

    toggleRecording() {
        this.isRecording = !this.isRecording;
        this.recordBtn.textContent = this.isRecording ? '⏹ Rekam' : '● Rekam';
        this.recordBtn.classList.toggle('recording', this.isRecording);
        
        if (this.isRecording) {
            this.recordedNotes = [];
        }
    }

    saveComposition() {
        const composition = {
            id: Date.now(),
            name: `Komposisi ${new Date().toLocaleString()}`,
            notes: this.recordedNotes,
            bpm: this.bpm,
            instrument: this.currentInstrument,
            sequencer: Array.from(document.querySelectorAll('.step')).map(step => 
                step.classList.contains('active')
            )
        };
        
        this.savedCompositions.push(composition);
        localStorage.setItem('compositions', JSON.stringify(this.savedCompositions));
        this.loadSavedCompositions();
        
        alert('Komposisi disimpan!');
    }

    loadSavedCompositions() {
        this.savedCompositionsList.innerHTML = '';
        
        this.savedCompositions.forEach(comp => {
            const li = document.createElement('li');
            li.textContent = comp.name;
            li.addEventListener('click', () => this.loadComposition(comp));
            this.savedCompositionsList.appendChild(li);
        });
    }

    loadComposition(composition = null) {
        if (!composition) {
            // Implement file loading logic here
            alert('Pilih komposisi dari list di atas');
            return;
        }
        
        this.bpm = composition.bpm;
        this.bpmSlider.value = this.bpm;
        this.bpmValue.textContent = this.bpm;
        
        this.currentInstrument = composition.instrument;
        this.instrumentSelect.value = this.currentInstrument;
        
        // Load sequencer pattern
        const steps = document.querySelectorAll('.step');
        composition.sequencer.forEach((isActive, index) => {
            if (steps[index]) {
                steps[index].classList.toggle('active', isActive);
            }
        });
        
        this.recordedNotes = composition.notes;
        alert(`Komposisi "${composition.name}" dimuat!`);
    }
}

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MusicComposer();
});

// Service Worker for PWA capabilities (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered: ', registration);
            })
            .catch(registrationError => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}