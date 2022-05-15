<?php get_header(); ?>

<div class="l-content" data-barba="container" data-barba-namespace="about">
  <?php get_template_part('./modules/global-nav') ?>
  <div class="p-archive l-container">
    <main id="main" class="p-archive__main p-single">
      <div class="p-single__inner">
        <div class="p-single__head">
          <h2 class="p-single__heading">
            このサイトについて
          </h2>
          <span class="p-single__category">
            self
          </span>
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