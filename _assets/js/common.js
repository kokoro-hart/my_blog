/**
 * @modules : node_modulesフォルダまでの絶対パスのエイリアス
 * webpack.config.jsにて定義している
 */
import $ from "@modules/jquery";
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
  var cfSelector = 'div.wpcf7 > form';
  var cfForms = $(next.container).find(cfSelector);
  if (cfForms.length) {
    $(cfSelector).each(function () {
      var $form = $(this);
      wpcf7.init($form[0]);
    });
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
const spinner = document.getElementById('js-loading');

function endLoading() {
  spinner.classList.add('loaded');
}
function initLoading() {
  spinner.classList.remove('loaded');
}

window.onload = endLoading();

//barba.init
barba.init({
  transitions: [{
    beforeLeave() {
      
    },
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
    endLoading();

  //ページ遷移後にAnalyticsにトラッキングを送信
  if (typeof ga === 'function') {
    ga('set', 'page', window.location.pathname);
    ga('send', 'pageview');
  }
});

