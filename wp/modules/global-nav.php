<nav class="p-global-nav">
  <div class="p-global-nav__inner l-container">
    <ul class="p-global-nav__list">
      <li class="p-global-nav__item">
        <?php if(is_front_page()) : ?>
          <a class="p-global-nav__link is-current">
            記事一覧
          </a>
        <?php else : ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="p-global-nav__link">
            記事一覧
          </a>
        <?php endif; ?>
      </li>
      <li class="p-global-nav__item">
        <?php if(is_page('about')) : ?>
          <a class="p-global-nav__link is-current">
            このサイトについて
          </a>
        <?php else : ?>
          <a href="<?php echo esc_url(home_url('/about')); ?>" class="p-global-nav__link">
            このサイトについて
          </a>
        <?php endif; ?>
      </li>
      <li class="p-global-nav__item">
        <?php if(is_page('contact')) : ?>
        <a class="p-global-nav__link is-current">
          お問い合わせ
        </a>
        <?php else : ?>
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="p-global-nav__link">
            お問い合わせ
          </a>
        <?php endif ; ?>
      </li>
    </ul>
  </div>
</nav>