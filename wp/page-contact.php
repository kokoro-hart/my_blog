
<?php get_header(); ?>

<div class="l-content" data-barba="container" data-barba-namespace="contact">
  <?php get_template_part('./modules/global-nav') ?>
  <div class="p-archive l-container">
    <main id="main" class="p-archive__main p-single">
      <div class="p-single__inner">
        <div class="p-single__head">
          <h2 class="p-single__heading">
            お問い合わせ
          </h2>
        </div>
        <div class="p-single__contents">
          <?php the_content(); ?>
        </div>
      </div>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>

<?php get_footer(); ?>