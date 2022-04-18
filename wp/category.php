
<?php get_header(); ?>

<div class="p-archive">
  <div class="p-archive__inner l-container">
    <main id="main" class="p-archive__main">
      <?php $category = get_the_category(); ?>
      <h2 class="p-archive__heading">
        <?php echo $category[0]->cat_name; ?>
      </h2>
      <div class="p-archive__cards">
        <?php
          if(have_posts()) :
          while(have_posts()) : the_post();
        ?>
        <article class="p-archive__card">
          <a href="<?php the_permalink(); ?>" class="p-card">
            <?php if($category[0]) : ?>
            <span class="p-card__category">
              <?php echo $category[0]->cat_name; ?>
            </span>
            <?php endif; ?>
            <div class="p-card__thumbnail">
              <?php
                $post_title = get_the_title();
                if(has_post_thumbnail()) {
                  the_post_thumbnail('full', array(
                    'alt' => $post_title,
                    'class' => 'p-card__img'
                  ));
                } else {
                  echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/common/og-image.png" alt="" class="p-card__img">';
                }
              ?>
            </div>
            <div class="p-card__body">
              <h3 class="p-card__title">
                <?php the_title(); ?>
              </h3>
              <time class="p-card__date" datetime="<?php the_time('c'); ?>">
                <?php the_time('Y/m/d') ?>
              </time>
            </div>
          </a>
        </article>
        <?php
          endwhile;
          endif;
        ?>
      </div>
      <?php my_pagination() ?>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>

<?php get_footer(); ?>