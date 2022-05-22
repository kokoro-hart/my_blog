<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <meta property="og:title" content="<?php the_title(); ?> - <?php bloginfo( 'name' ); ?>">
  <meta property="og:description" content="<?php bloginfo('description'); ?>">
  <meta property="og:url" content="<?php bloginfo('url'); ?>">
  <?php if(is_front_page()) : ?>
  <meta property="og:type" content="website">
  <?php else: ?>
  <meta property="og:type" content="article">
  <?php endif; ?>
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

<body data-barba="wrapper">
  <a class="skip-link" href="#main" tabindex="0">メインコンテンツにスキップ</a>
  <div id="js-loading" class="p-loader">
    <div class="p-loader__part"></div>
  </div>
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
          <button class="p-header__switch-button c-button-switch" id="js-change-mode" data-theme="" aria-label="カラーテーマ切り替え">
          </button>
        </div>
        <p class="p-header__text">
          <?php bloginfo('description'); ?>
        </p>
      </div>
    </header>