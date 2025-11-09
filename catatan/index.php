<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notion-like Notes & To-Do App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/atom-one-dark.min.css">
    <style>
        :root {
            --primary-color: #37352f;
            --secondary-color: #ffffff;
            --accent-color: #4285f4;
            --sidebar-bg: #f7f6f3;
            --card-bg: #ffffff;
            --border-color: #e1e1e1;
            --hover-color: #f0f0f0;
            --completed-color: #888888;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            padding: 20px;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .logo i {
            color: var(--accent-color);
        }

        .nav-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-title {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .nav-item:hover {
            background-color: var(--hover-color);
        }

        .nav-item.active {
            background-color: var(--accent-color);
            color: white;
        }

        .nav-item i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: var(--sidebar-bg);
            padding: 8px 15px;
            border-radius: 6px;
            width: 300px;
        }

        .search-bar input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            margin-left: 10px;
        }

        .content-area {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .add-btn {
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .todo-item, .note-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .todo-item:last-child, .note-item:last-child {
            border-bottom: none;
        }

        .todo-checkbox {
            margin-top: 3px;
        }

        .todo-content, .note-content {
            flex: 1;
        }

        .todo-text {
            font-size: 15px;
        }

        .todo-text.completed {
            text-decoration: line-through;
            color: var(--completed-color);
        }

        .todo-date {
            font-size: 12px;
            color: #888;
            margin-top: 3px;
        }

        .note-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .note-text {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        .code-block {
            background-color: #282c34;
            border-radius: 6px;
            overflow: hidden;
            margin: 15px 0;
        }

        .code-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 15px;
            background-color: #1e2227;
            color: #abb2bf;
            font-size: 13px;
        }

        .code-language {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .code-actions {
            display: flex;
            gap: 10px;
        }

        .code-actions i {
            cursor: pointer;
        }

        .code-content {
            padding: 15px;
            overflow-x: auto;
        }

        .code-content pre {
            margin: 0;
            font-family: 'Fira Code', monospace;
            font-size: 14px;
        }

        .add-block-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background-color: var(--sidebar-bg);
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
            border: 1px dashed var(--border-color);
        }

        .add-block-btn:hover {
            background-color: var(--hover-color);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #888;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            border: none;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-secondary {
            background-color: var(--sidebar-bg);
            color: var(--primary-color);
        }

        .block-options {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            z-index: 10;
            width: 200px;
        }

        .block-option {
            padding: 8px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .block-option:hover {
            background-color: var(--hover-color);
        }

        .block-option i {
            width: 20px;
            text-align: center;
            color: #666;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #888;
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #ccc;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-sticky-note"></i>
            <span>NotionClone</span>
        </div>
        
        <div class="nav-section">
            <div class="nav-title">Halaman</div>
            <div class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-tasks"></i>
                <span>Tugas Saya</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-sticky-note"></i>
                <span>Catatan</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-code"></i>
                <span>Snippets</span>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-title">Ruang Kerja</div>
            <div class="nav-item">
                <i class="fas fa-briefcase"></i>
                <span>Proyek A</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-briefcase"></i>
                <span>Proyek B</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-plus"></i>
                <span>Ruang Kerja Baru</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="page-title">Beranda</div>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari...">
            </div>
        </div>
        
        <div class="content-area">
            <!-- To-Do Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">To-Do List</div>
                    <button class="add-btn" id="addTodoBtn">
                        <i class="fas fa-plus"></i>
                        <span>Tambah</span>
                    </button>
                </div>
                
                <div id="todoList">
                    <div class="todo-item">
                        <input type="checkbox" class="todo-checkbox">
                        <div class="todo-content">
                            <div class="todo-text">Membuat aplikasi web to-do dan catatan</div>
                            <div class="todo-date">Hari ini</div>
                        </div>
                    </div>
                    
                    <div class="todo-item">
                        <input type="checkbox" class="todo-checkbox" checked>
                        <div class="todo-content">
                            <div class="todo-text completed">Belajar tentang sintaks highlighting</div>
                            <div class="todo-date">Kemarin</div>
                        </div>
                    </div>
                    
                    <div class="todo-item">
                        <input type="checkbox" class="todo-checkbox">
                        <div class="todo-content">
                            <div class="todo-text">Mendesain UI yang clean dan modern</div>
                            <div class="todo-date">Besok</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notes Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Catatan</div>
                    <button class="add-btn" id="addNoteBtn">
                        <i class="fas fa-plus"></i>
                        <span>Tambah</span>
                    </button>
                </div>
                
                <div id="notesList">
                    <div class="note-item">
                        <div class="note-content">
                            <div class="note-title">Ide untuk Proyek Baru</div>
                            <div class="note-text">
                                Membuat aplikasi web yang menggabungkan to-do list, catatan, dan editor kode dengan sintaks highlighting.
                                <div class="code-block">
                                    <div class="code-header">
                                        <div class="code-language">
                                            <i class="fab fa-html5"></i>
                                            <span>HTML</span>
                                        </div>
                                        <div class="code-actions">
                                            <i class="fas fa-copy"></i>
                                        </div>
                                    </div>
                                    <div class="code-content">
                                        <pre><code class="language-html">&lt;div class="container"&gt;
    &lt;h1&gt;Hello World&lt;/h1&gt;
    &lt;p&gt;Ini adalah contoh kode HTML&lt;/p&gt;
&lt;/div&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="note-item">
                        <div class="note-content">
                            <div class="note-title">Fitur yang Perlu Ditambahkan</div>
                            <div class="note-text">
                                - Pencarian catatan dan to-do
                                - Kategori dan tag
                                - Berbagi catatan
                                - Mode gelap
                                - Sinkronisasi cloud
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="add-block-btn" id="addBlockBtn">
                    <i class="fas fa-plus"></i>
                    <span>Tambah blok</span>
                </div>
                
                <div class="block-options" id="blockOptions">
                    <div class="block-option" data-type="text">
                        <i class="fas fa-font"></i>
                        <span>Teks</span>
                    </div>
                    <div class="block-option" data-type="heading">
                        <i class="fas fa-heading"></i>
                        <span>Heading</span>
                    </div>
                    <div class="block-option" data-type="code">
                        <i class="fas fa-code"></i>
                        <span>Kode</span>
                    </div>
                    <div class="block-option" data-type="todo">
                        <i class="fas fa-check-square"></i>
                        <span>To-Do</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah To-Do -->
    <div class="modal" id="todoModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Tambah To-Do Baru</div>
                <button class="close-btn" id="closeTodoModal">&times;</button>
            </div>
            <div class="form-group">
                <label for="todoText">Tugas</label>
                <input type="text" id="todoText" class="form-control" placeholder="Apa yang perlu dilakukan?">
            </div>
            <div class="form-group">
                <label for="todoDate">Tanggal</label>
                <input type="date" id="todoDate" class="form-control">
            </div>
            <div class="form-actions">
                <button class="btn btn-secondary" id="cancelTodo">Batal</button>
                <button class="btn btn-primary" id="saveTodo">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah Catatan -->
    <div class="modal" id="noteModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Tambah Catatan Baru</div>
                <button class="close-btn" id="closeNoteModal">&times;</button>
            </div>
            <div class="form-group">
                <label for="noteTitle">Judul</label>
                <input type="text" id="noteTitle" class="form-control" placeholder="Judul catatan">
            </div>
            <div class="form-group">
                <label for="noteContent">Konten</label>
                <textarea id="noteContent" class="form-control" placeholder="Isi catatan"></textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-secondary" id="cancelNote">Batal</button>
                <button class="btn btn-primary" id="saveNote">Simpan</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script>
        // Inisialisasi highlight.js
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                hljs.highlightElement(el);
            });
        });

        // Modal To-Do
        const addTodoBtn = document.getElementById('addTodoBtn');
        const todoModal = document.getElementById('todoModal');
        const closeTodoModal = document.getElementById('closeTodoModal');
        const cancelTodo = document.getElementById('cancelTodo');
        const saveTodo = document.getElementById('saveTodo');
        const todoList = document.getElementById('todoList');

        addTodoBtn.addEventListener('click', () => {
            todoModal.style.display = 'flex';
        });

        closeTodoModal.addEventListener('click', () => {
            todoModal.style.display = 'none';
        });

        cancelTodo.addEventListener('click', () => {
            todoModal.style.display = 'none';
        });

        saveTodo.addEventListener('click', () => {
            const todoText = document.getElementById('todoText').value;
            const todoDate = document.getElementById('todoDate').value;
            
            if (todoText.trim() !== '') {
                const todoItem = document.createElement('div');
                todoItem.className = 'todo-item';
                
                const dateText = todoDate ? new Date(todoDate).toLocaleDateString('id-ID') : 'Tanpa tanggal';
                
                todoItem.innerHTML = `
                    <input type="checkbox" class="todo-checkbox">
                    <div class="todo-content">
                        <div class="todo-text">${todoText}</div>
                        <div class="todo-date">${dateText}</div>
                    </div>
                `;
                
                todoList.appendChild(todoItem);
                
                // Reset form
                document.getElementById('todoText').value = '';
                document.getElementById('todoDate').value = '';
                
                todoModal.style.display = 'none';
                
                // Tambahkan event listener untuk checkbox baru
                addCheckboxListener(todoItem.querySelector('.todo-checkbox'));
            }
        });

        // Modal Catatan
        const addNoteBtn = document.getElementById('addNoteBtn');
        const noteModal = document.getElementById('noteModal');
        const closeNoteModal = document.getElementById('closeNoteModal');
        const cancelNote = document.getElementById('cancelNote');
        const saveNote = document.getElementById('saveNote');
        const notesList = document.getElementById('notesList');

        addNoteBtn.addEventListener('click', () => {
            noteModal.style.display = 'flex';
        });

        closeNoteModal.addEventListener('click', () => {
            noteModal.style.display = 'none';
        });

        cancelNote.addEventListener('click', () => {
            noteModal.style.display = 'none';
        });

        saveNote.addEventListener('click', () => {
            const noteTitle = document.getElementById('noteTitle').value;
            const noteContent = document.getElementById('noteContent').value;
            
            if (noteTitle.trim() !== '' && noteContent.trim() !== '') {
                const noteItem = document.createElement('div');
                noteItem.className = 'note-item';
                
                noteItem.innerHTML = `
                    <div class="note-content">
                        <div class="note-title">${noteTitle}</div>
                        <div class="note-text">${noteContent}</div>
                    </div>
                `;
                
                notesList.appendChild(noteItem);
                
                // Reset form
                document.getElementById('noteTitle').value = '';
                document.getElementById('noteContent').value = '';
                
                noteModal.style.display = 'none';
            }
        });

        // Blok Options
        const addBlockBtn = document.getElementById('addBlockBtn');
        const blockOptions = document.getElementById('blockOptions');

        addBlockBtn.addEventListener('click', (e) => {
            const rect = addBlockBtn.getBoundingClientRect();
            blockOptions.style.display = 'block';
            blockOptions.style.top = `${rect.bottom + 5}px`;
            blockOptions.style.left = `${rect.left}px`;
        });

        document.addEventListener('click', (e) => {
            if (!addBlockBtn.contains(e.target) && !blockOptions.contains(e.target)) {
                blockOptions.style.display = 'none';
            }
        });

        // Fungsi untuk menangani checkbox to-do
        function addCheckboxListener(checkbox) {
            checkbox.addEventListener('change', function() {
                const todoText = this.parentElement.querySelector('.todo-text');
                if (this.checked) {
                    todoText.classList.add('completed');
                } else {
                    todoText.classList.remove('completed');
                }
            });
        }

        // Tambahkan event listener untuk checkbox yang sudah ada
        document.querySelectorAll('.todo-checkbox').forEach(checkbox => {
            addCheckboxListener(checkbox);
        });

        // Fungsi untuk menyalin kode
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-copy')) {
                const codeBlock = e.target.closest('.code-block');
                const codeContent = codeBlock.querySelector('code').textContent;
                
                navigator.clipboard.writeText(codeContent).then(() => {
                    // Tampilkan feedback bahwa kode telah disalin
                    const originalIcon = e.target.className;
                    e.target.className = 'fas fa-check';
                    
                    setTimeout(() => {
                        e.target.className = originalIcon;
                    }, 2000);
                });
            }
        });
    </script>
</body>
</html>