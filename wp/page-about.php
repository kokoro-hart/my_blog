<?php get_header(); ?>

<div class="p-archive">
  <div class="p-archive__inner l-container">
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