/**
 * @modules : node_modulesフォルダまでの絶対パスのエイリアス
 * webpack.config.jsにて定義している
 */
import barba from '@modules/@barba/core';
import Prism from './lib/prism';
import './modules/theme';

Prism.highlightAll();

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

// スムーススクロール
const urlHash = location.hash;
function initSmoothScroll() {
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

// サイドバーの目次の高さを動的に
function tuningSidebar() {
  const toc = document.querySelector('.p-toc-sidebar__inner');
  let tocHeight;
  // 高さ90vh以上の場合以外は生成された目次の高さに調整
  if (toc != null) {
    tocHeight = toc.offsetHeight;

    if (tocHeight >= (document.documentElement.clientHeight * 0.9)) {
      toc.style.maxHeight = 90 + 'vh';
    } else {
      toc.style.maxHeight = `${tocHeight}px`;
    }
  }
}

// 表示中コンテンツに合わせて目次にfocusを当てる
function followTocContents() {
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
}

initSmoothScroll();
followTocContents();
tuningSidebar();

// Contact Form 7を正常動作させるための関数
function contactForm7Run(next) {
  let cfForms = next.container.document.querySelector('.wpcf7 form');
  for (var i = 0; i < cfForms.length; i++) {
    let form = cfForms[i];
    wpcf7.init(form[0]);
  }
}

//barba遷移時のheadタグの書き換え
const replaceHead = (data) => {
  const head = document.head;
  const newPageRawHead = data.next.html.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0];
  const newPageHead = document.createElement('head');
  newPageHead.innerHTML = newPageRawHead;

  const removeHeadTags = [
    "meta[name='keywords']"
    , "meta[name='description']"
    , "meta[property^='og']"
    , "meta[name^='twitter']"
    , "meta[itemprop]"
    , "link[itemprop]"
    , "link[rel='prev']"
    , "link[rel='next']"
    , "link[rel='canonical']"
  ].join(',');

  const headTags = head.querySelectorAll(removeHeadTags)

  for (let i = 0; i < headTags.length; i++) {
    head.removeChild(headTags[i]);
  }

  const newHeadTags = newPageHead.querySelectorAll(removeHeadTags)

  for (let i = 0; i < newHeadTags.length; i++) {
    head.appendChild(newHeadTags[i]);
  }
}

// ローダー
const spinner = document.getElementById('js-loading');
function endLoading() {
  document.body.classList.remove('is-fixed');
  spinner.classList.add('is-loaded');
}
function initLoading() {
  document.body.classList.add('is-fixed');
  spinner.classList.remove('is-loaded');
}

window.onload = endLoading();

//barba.init
barba.init({
  transitions: [{
    beforeEnter({ next }) {
      contactForm7Run(next);
    },
  }],

  views: [
    {
      namespace: 'single',
      beforeEnter(data) {
        followTocContents();
      }
    },
  ],

  prevent: function (e) {
    if (e.el.classList.contains('ab-item')) {
      return true;
    }
  }
});

barba.hooks.before((data) => {
  initLoading();
});

barba.hooks.beforeEnter((data) => {
  initSmoothScroll();
  Prism.highlightAll();
  replaceHead(data);
});

barba.hooks.afterEnter(() => {
  window.scrollTo(0, 0);
});

barba.hooks.after((data) => {
  tuningSidebar();
  endLoading();
  //ページ遷移後にAnalyticsにトラッキングを送信
  if (typeof gtag === 'function') {
    gtag('config', window.GA_MEASUREMENT_ID, {
      page_path: window.location.pathname
    });
  }
});