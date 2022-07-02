
<?php get_header(); ?>

<div class="l-content" data-barba="container" data-barba-namespace="home">
  <?php get_template_part('./modules/global-nav') ?>
  <div class="p-archive l-container l-container--sp-full-width">
    <main id="main" class="p-archive__main">
      <div class="p-archive__posts">
        <h2 class="p-archive__heading">
          新着記事
        </h2>
        <div class="p-archive__cards">
          <?php
            if(have_posts()) :
            while(have_posts()) : the_post();
            $category = get_the_category();
          ?>
          <article class="p-archive__card">
            <a href="<?php the_permalink(); ?>" class="p-card">
              <?php if($category[0]) : ?>
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
                    echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/common/og-image.png" alt="サムネイル画像" class="p-card__img">';
                  }
                ?>
              </div>
              <div class="p-card__body">
              <span class="p-card__category u-hidden-md-down">
                <?php echo $category[0]->cat_name; ?>
              </span>
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
      </div>
    </main>
    <?php get_sidebar(); ?>
  </div>
</div>

<?php get_footer(); ?>