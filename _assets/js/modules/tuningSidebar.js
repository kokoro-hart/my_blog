/**
 * サイドバーの目次の高さを動的に
 */

export default () => {
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