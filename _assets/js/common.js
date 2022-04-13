/**
 * @modules : node_modulesフォルダまでの絶対パスのエイリアス
 * webpack.config.jsにて定義している
 */

//jQueryを使うとき
//import $ from "@modules/jquery";
//slickを使うとき
// import '@modules/slick-carousel';


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

//シンタックスハイライトプラグイン heighlight.js init
hljs.initHighlightingOnLoad();