const spinner = document.getElementById('js-loading');

/**
 * ローディング開始
 */
export function initLoading() {
  document.body.classList.add('is-fixed');
  spinner.classList.remove('is-loaded');
}

/**
 * ローディング終了
 */
export function endLoading() {
  document.body.classList.remove('is-fixed');
  spinner.classList.add('is-loaded');
}