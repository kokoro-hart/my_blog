    <footer class="l-footer p-footer">
      <div class="p-footer__inner l-container">
        <ul class="p-footer-nav">
          <li class="p-footer-nav__item">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="p-footer-nav__link">
              記事一覧
            </a>
          </li>
          <li class="p-footer-nav__item">
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="p-footer-nav__link">
              このサイトについて
            </a>
          </li>
          <li class="p-footer-nav__item">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="p-footer-nav__link">
              お問い合わせ
            </a>
          </li>
        </ul>
      </div>
      <p class="p-footer__copyright">
        <small lang="en">
          ©copyright 2022 KT MEDIA
        </small>
      </p>
    </footer>
  </div><!-- /wrapper -->

  <?php wp_footer(); ?>
<!--目次追加ここまで-->

</body>
</html>