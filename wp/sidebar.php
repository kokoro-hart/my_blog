<aside class="p-archive__sidebar p-sidebar">
  <section class="p-sidebar__content p-profile">
    <div class="p-profile__head">
      <?php $users = get_users(array(
        'orderby'=> 'ID',
        'order'=> 'DESC',
      )); ?>
      <?php foreach($users as $user) : $uid = $user->ID; ?>
      <?php
        echo get_avatar( $uid, $size = 110, $default="", $alt="プロフィール画像", array(
          'class' => 'p-profile__img',
        )); 
      ?>
      <div class="p-profile__info">
        <h3 class="p-profile__name">
          <?php echo $user->display_name ; ?>
        </h3>
        <ul class="p-profile__list">
          <?php if($user->github != ""): ?>
          <li class="p-profile__item">
            <a href="<?php echo $user->github ; ?>" class="p-profile__link" target="_blank" rel="noopener noreferrer">
              <svg class="c-svg p-profile__svg" width="20" height="20" aria-label="GitHubのアイコン">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/sprite.min.svg#icon-github" />
              </svg>
              <span class="u-hidden">(新しいウィンドウが開きます)</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if($user->twitter != ""): ?>
          <li class="p-profile__item">
            <a href="<?php echo $user->twitter ; ?>" class="p-profile__link" target="_blank" rel="noopener noreferrer">
              <svg class="c-svg p-profile__svg" width="20" height="20" aria-label="Twitterのアイコン">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/sprite.min.svg#icon-twitter" />
              </svg>
              <span class="u-hidden">(新しいウィンドウが開きます)</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if($user->linkedin != ""): ?>
          <li class="p-profile__item">
            <a href="<?php echo $user->linkedin ; ?>" class="p-profile__link" target="_blank" rel="noopener noreferrer">
              <svg class="c-svg p-profile__svg" width="20" height="20" aria-label="サイトリンクのアイコン">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/svg/sprite.min.svg#icon-site" />
              </svg>
              <span class="u-hidden">(新しいウィンドウが開きます)</span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
      <?php endforeach ; ?>
      <p class="p-profile__text">
        <?php echo $user->user_description ; ?>
      </p>
    </div>
  </section>
  <section class="p-sidebar__content">
    <h2 class="p-sidebar__heading">
      カテゴリ
    </h2>
    <ul class="p-sidebar__list">
      <?php wp_list_categories('title_li=&show_count=1'); ?>
    </ul>
  </section>
  <?php do_action( 'my_sidebar_action_hook' ); ?>
</aside>