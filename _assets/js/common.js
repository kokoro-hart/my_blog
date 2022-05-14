/**
 * @modules : node_modulesフォルダまでの絶対パスのエイリアス
 * webpack.config.jsにて定義している
 */

//デバイス幅360px以下はリサイズして表示
!(function () {
  const viewport = document.querySelector('meta[name="viewport"]');
  function switchViewport() {
    const value =
      window.outerWidth > 360
        ? 'width=device-width,initial-scale=1'
        : 'width=360';
    if (viewport.getAttribute('content') !== value) {
      viewport.setAttribute('content', value);
    }
  }
  addEventListener('resize', switchViewport, false);
  switchViewport();
})();

const urlHash = location.hash;

window.addEventListener('DOMContentLoaded', () => {
  // スムーススクロール
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  const anchorLinksArr = Array.prototype.slice.call(anchorLinks);

  anchorLinksArr.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const targetId = link.hash;
      const targetElement = document.querySelector(targetId);
      const targetOffsetTop = window.pageYOffset + targetElement.getBoundingClientRect().top - document.documentElement.clientHeight / 2.5 ;

      window.scrollTo({
        top: targetOffsetTop,
        behavior: "smooth"
      });
    });
  });
  
  // サイドバーの目次の高さを動的に
  const toc = document.querySelector('.p-toc-sidebar__inner');
  const tocHeight = toc.offsetHeight;
  
  // 高さ90vh以上の場合以外は生成された目次の高さに調整
  if (tocHeight >= (document.documentElement.clientHeight * 0.9)) {
    toc.style.maxHeight = 90 + 'vh';
  } else {
    toc.style.maxHeight = `${tocHeight}px`;
  }
});

// 表示中コンテンツに合わせて目次にfocusを当てる
const wpContentHeading = document.querySelectorAll('.js-heading');
const options = {
  root: null,
  rootMargin: '-50% 0px',
  threshold: 0
};
const observer = new IntersectionObserver(followContents, options);
wpContentHeading.forEach(img => {
  observer.observe(img);
});
function followContents(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const newActiveIndex = document.querySelector(`[data-id='#${entry.target.id}']`);
      newActiveIndex.focus();
    }
  });
}