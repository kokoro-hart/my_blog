/**
 *  表示中コンテンツに合わせて目次にfocusを当てる
 */
export default () => {
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