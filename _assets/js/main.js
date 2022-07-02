/**
 * @modules : node_modulesフォルダまでの絶対パスのエイリアス
 * webpack.config.jsにて定義している
 */

import barba from '@modules/@barba/core';
import Prism from './lib/prism';

import changeTheme from './modules/theme';
import resizeViewport from './modules/resize';
import smoothScroll from './modules/smoothScroll';
import tuningSidebar from './modules/tuningSidebar';
import followTocContents from './modules/followTocContents';
import contactForm7Run from './modules/contactForm7Run';
import replaceHead from './modules/replaceHead';
import { initLoading, endLoading } from './modules/loading'


Prism.highlightAll();
changeTheme();
resizeViewport();
smoothScroll();
followTocContents();
tuningSidebar();

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
  smoothScroll();
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