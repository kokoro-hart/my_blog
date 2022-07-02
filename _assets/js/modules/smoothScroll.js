/**
 * スムーススクロール
 */
export default () => {
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  const anchorLinksArr = Array.prototype.slice.call(anchorLinks);

  anchorLinksArr.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const targetId = link.hash;
      const targetElement = document.querySelector(targetId);
      const targetOffsetTop = window.pageYOffset + targetElement.getBoundingClientRect().top - document.documentElement.clientHeight / 2.5;

      window.scrollTo({
        top: targetOffsetTop,
        behavior: "smooth"
      });
    });
  });
}
