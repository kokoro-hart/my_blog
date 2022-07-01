// テーマ切り替え
const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
const usersMode = window.sessionStorage.getItem('user');
const el = document.documentElement;
const changeModeButton = document.getElementById("js-change-mode");

if (usersMode) {
  el.setAttribute('theme', usersMode);
  changeModeButton.setAttribute('data-theme', usersMode);
} else {
  if (isDarkMode == true) {
    el.setAttribute('theme', 'dark');
    changeModeButton.setAttribute('data-theme', 'dark');
  } else {
    el.setAttribute('theme', 'light');
    changeModeButton.setAttribute('data-theme', 'light');
  }
}

changeModeButton.onclick = function () {
  let nowMode = el.getAttribute('theme');

  if (nowMode == 'dark') {
    el.setAttribute('theme', 'light');
    this.setAttribute('data-theme', 'light');
    window.sessionStorage.setItem('user', 'light');
  } else {
    el.setAttribute('theme', 'dark');
    this.setAttribute('data-theme', 'dark');
    window.sessionStorage.setItem('user', 'dark');
  }
};
