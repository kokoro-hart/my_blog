
<?php get_header(); ?>

<div class="l-content" data-barba="container" data-barba-namespace="single">
  <?php get_template_part('./modules/global-nav') ?>
  <div class="p-archive l-container">
    <main id="main" class="p-archive__main p-single">
      <div class="p-single__inner">
        <div class="p-single__head">
          <time class="p-single__date" datetime="<?php the_time('Y/m/d H:i:s'); ?>">
            公開日 : <?php the_time('Y/m/d'); ?>
          </time>
          <time class="p-single__date" datetime="<?php the_modified_date('Y/m/d H:i:s'); ?>">
            更新日 : <?php the_modified_date('Y/m/d') ?>
          </time>
          <h2 class="p-single__heading">
            <?php the_title(); ?>
          </h2>
          <?php 
            $category = get_the_category(); 
            if($category[0]) : 
          ?>
          <a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>" class="p-single__category">
            <?php echo $category[0]->cat_name; ?>
          </a>
          <?php endif; ?>
        </div>
        <div class="p-single__thumbnail">
          <?php
            $post_title = get_the_title();
            if(has_post_thumbnail()) {
              the_post_thumbnail('full', array(
                'alt' => $post_title,
                'class' => 'p-single__img'
              ));
            } else {
              echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/common/og-image.png" alt="サムネイル画像" class="p-single__img">';
            }
          ?>
        </div>
        <article class="p-single__contents">
          <?php the_content(); ?>
          <div class="p-single__sns">
            <span class="u-hidden">SNSでシェアする</span>
            <a href="https://twitter.com/share?url=<?php echo get_the_permalink();?>&text=<?php echo get_the_title();?>" class="p-single__sns-link" target="_blank" rel="nofollow noopener">
              <span class="u-hidden">Twitterでシェア</span>
              <svg class="c-svg p-single__sns-svg" width="28" height="28" aria-label="Twitterのアイコン">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/sprite.min.svg#icon-twitter" />
              </svg>
            </a>
            <a href="http://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" class="p-single__sns-link" target="_blank" rel="nofollow noopener">
              <span class="u-hidden">Facebookでシェア</span>
              <svg class="c-svg p-single__sns-svg" width="28" height="28" aria-label="Facebookのアイコン">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/sprite.min.svg#icon-facebook" />
              </svg>
            </a>
          </div>
        </article>
      </div>
    </main>
    <?php get_sidebar(); ?>
  </div>
  
  <div class="p-related l-container">
    <h2 class="p-related__heading">
      関連記事
    </h2>
    <div class="p-related__cards">
      <?php 
        if(has_category()) {
          $post_cats = get_the_category();
          $cat_ids = array();
          foreach($post_cats as $cat) {
            $cat_ids[] = $cat->term_id;
          }
        } 

        $related_posts = get_posts(array( 
          'post_type' => 'post',//投稿タイプを表示
          'posts_per_page' => '4',
          'post__not_in' => array($post->ID),//表示中の投稿を除外($post = 投稿情報)
          'category__in' => $cat_ids,//この投稿と同じカテゴリーの中から
          'orderby' => 'rand',//ランダムで表示
        ));
        if($related_posts) : 
        foreach($related_posts as $post) : setup_postdata($post);
        ?>
      <article class="p-related__card">
        <a href="<?php the_permalink(); ?>" class="p-card">
          <?php if($post_cats[0]) : ?>
            <span class="p-card__category">
              <?php echo $post_cats[0]->cat_name; ?>
            </span>
          <?php endif; ?>
          <div class="p-card__thumbnail">
            <?php
              if(has_post_thumbnail()) {
                the_post_thumbnail('full', array(
                  'class' => 'p-card__img'
                ));
              } else {
                echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/common/og-image.png" alt="サムネイル画像" class="p-card__img">';
              }
            ?>
          </div>
          <div class="p-card__body">
            <h3 class="p-card__title">
              <?php the_title(); ?>
            </h3>
            <time class="p-card__date" datetime="<?php the_time('c'); ?>">
              <?php the_time('Y/m/d'); ?>
            </time>
          </div>
        </a>
      </article>
      <?php
        endforeach; wp_reset_postdata();
        endif;
      ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>