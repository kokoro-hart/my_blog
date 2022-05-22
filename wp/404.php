<?php get_header(); ?>

<div class="l-content" data-barba="container" data-barba-namespace="about">
  <?php get_template_part('./modules/global-nav') ?>
  <main id="main" class="p-error l-container">
    <div class="p-error__inner">
      <h2 class="p-error__heading">
        404
      </h2>
      <p class="p-error__text">
        お探しのページが見つかりませんでした。
      </p>
      <div class="p-error__link-wrapper">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="c-button-primary">記事一覧へ</a>
      </div>
    </div>
  </main>
</div>

<?php get_footer(); ?>