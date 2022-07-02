/**
 *  Contact Form 7を正常動作させるための関数
 */

export default (next) => {
  let cfForms = next.container.document.querySelector('.wpcf7 form');
  for (var i = 0; i < cfForms.length; i++) {
    let form = cfForms[i];
    wpcf7.init(form[0]);
  }
}