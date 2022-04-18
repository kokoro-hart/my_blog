<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <meta property="og:title" content="<?php bloginfo( 'name' ); ?>">
  <meta property="og:description" content="<?php bloginfo('description'); ?>">
  <meta property="og:url" content="<?php bloginfo('url'); ?>">
  <meta property="og:type" content="website ">
  <meta property="og:local" content="ja_JP">
  <?php if (has_post_thumbnail()) : ?>
  <meta property="og:image" content="<?php the_post_thumbnail_url(); ?>" />
  <?php else : ?>
  <meta property="og:image" content="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/og-image.png">
  <?php endif; ?>
  <meta property="og:site_name" content="<?php bloginfo('url'); ?>">

  <link rel="icon" href="<?php echo esc_url(get_template_directory_uri());  ?>/img/common/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri());  ?>/img/common/apple-touch-icon-180x180.png">

  <?php wp_head(); ?>
</head>

<body>
  <a class="skip-link" href="#main" tabindex="0">メインコンテンツにスキップ</a>
  <div class="site-wrapper">
    <header class="l-header p-header">
      <div class="p-header__inner l-container">
        <div class="p-header__head">
          <h1 class="p-header__logo">
            <?php if(is_front_page()) : ?>
              <a class="p-header__logo-link">
                <?php bloginfo( 'name' ); ?>
              </a>
            <?php else: ?>
              <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo-link">
                <?php bloginfo( 'name' ); ?>
              </a>
            <?php endif; ?>
          </h1>
          <button class="p-header__switch-button c-button-switch" aria-label="カラーテーマ切り替え">
            <input class="c-button-switch__input" id="js-switch-button" type="checkbox">
            <label class="c-button-switch__label" for="js-switch-button"></label>
          </button>
        </div>
        <p class="p-header__text">
          <?php bloginfo('description'); ?>
        </p>
        <div class="p-header__foot">
          <nav class="p-global-nav">
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
          </nav>
        </div>
      </div>
    </header>