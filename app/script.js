const WEB_URL = "https://kangmoek.gt.tc";
const webview = document.getElementById("webview");
const splash = document.getElementById("splash");
const offline = document.getElementById("offline");

// cek koneksi
function isOnline() {
  return navigator.onLine;
}

// reload
function reloadPage() {
  location.reload();
}

// muat webview
window.addEventListener("load", () => {
  if (isOnline()) {
    webview.src = WEB_URL;
    webview.onload = () => {
      splash.style.display = "none";
      webview.style.display = "block";
    };
  } else {
    splash.style.display = "none";
    offline.style.display = "flex";
  }
});

// deteksi koneksi berubah
window.addEventListener("offline", () => {
  webview.style.display = "none";
  offline.style.display = "flex";
});

window.addEventListener("online", () => {
  offline.style.display = "none";
  webview.style.display = "block";
  webview.src = WEB_URL;
});