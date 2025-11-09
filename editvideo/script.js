
document.getElementById('toggleToolbar').addEventListener('click', () => {
  document.getElementById('featuresPanel').classList.toggle('hidden');
});
document.getElementById('themeSelect').addEventListener('change', (e) => {
  document.body.className = e.target.value;
});
document.getElementById('videoInput').addEventListener('change', (e) => {
  const file = e.target.files[0];
  const video = document.getElementById('videoPreview');
  video.src = URL.createObjectURL(file);
});
document.getElementById('cutBtn').addEventListener('click', () => {
  alert('Fitur potong video dijalankan (simulasi)');
});
document.getElementById('mergeBtn').addEventListener('click', () => {
  alert('Fitur gabung video dijalankan (simulasi)');
});
document.getElementById('undoBtn').addEventListener('click', () => {
  alert('Undo dijalankan');
});
document.getElementById('redoBtn').addEventListener('click', () => {
  alert('Redo dijalankan');
});
