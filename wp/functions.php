<?php

// セットアップ
function my_setup()
{
  add_theme_support('post-thumbnails'); // アイキャッチ画像を有効化
  add_theme_support('automatic-feed-links'); // 投稿とコメントのRSSフィードのリンクを有効化
  add_theme_support('title-tag'); // タイトルタグ自動生成
  add_theme_support(
    'html5',
    array( 
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}
add_action('after_setup_theme', 'my_setup');

//WordPress同梱のjQueryを読み込ませない
function new_deregister_script() {
  if ( !is_admin() ) {
    wp_deregister_script('jquery');
  }
}
add_action('init', 'new_deregister_script');

//タイトルの区切り
function change_title_separator( $sep ){
  $sep = ' | ';
  return $sep;
}
add_filter( 'document_title_separator', 'change_title_separator' );

//css jsの読み込み
function my_script_init()
{
  wp_enqueue_style('my', get_template_directory_uri() . '/css/style.css', array(), '1.0.0', 'all');
  wp_enqueue_script('my', get_template_directory_uri() . '/js/bundle.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_script_init');

//フォーム設置ページのみContactForm7のcss、jsを読み込み
add_action( 'wp', function() 
{
  if ( is_page( 'contact' )) return;
  add_filter( 'wpcf7_load_js', '__return_false' );
  add_filter( 'wpcf7_load_css', '__return_false' );
});

//記事一覧のページネーション
function my_pagination()
{
  if(paginate_links()) {
    echo 
    '<div class="p-archive__pagination c-pagination">' .
    paginate_links(array(
      'end_size' => 1,
      'mid_size' => 1,
      'prev_next' => true,
      'next_text' => '&gt;',
      'prev_text' => '&lt',
    ))
    .'</div>';
  }
}

//scriptタグにdefer属性を追加
function scriptLoader($script, $handle, $src) {
	if (is_admin()) {
		return $script;
	}
	$script = sprintf('<script src="%s" type="text/javascript" defer=""></script>' . "\n", $src);
	return $script;
}
add_filter('script_loader_tag', 'scriptLoader', 10, 5);

//プロフィール項目追加
function my_user_meta($wb)
{
//項目の追加例
$wb['twitter'] = 'Twitter';
$wb['github'] = 'GitHub';
$wb['linkedin'] = 'LinkedIn';

return $wb;
}
add_filter('user_contactmethods', 'my_user_meta', 10, 1);

//シンタックスハイライトのショートコード
function highlight_shortcode($class, $content = '')
{    //引数として$classと$contentを定義。
  return 
  '<code  class = "' . $class['class'] . '">' . 
    $content . 
  '</code>';    //引数で渡された$classと$contentが代入される。
}
add_shortcode('highlight', 'highlight_shortcode');


//目次生成
function my_add_content($content) {
  if (is_single()) {
    $pattern = '/<h[2]>(.*?)<\/h[2]>/i';
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

    if (count($matches) >= 3) {
      $toc = '<div class="p-toc"><h3 class="p-toc__heading">目次</h3><ol class="p-toc__list">';
      $i = 0;

      foreach ($matches as $element) {
        $i++;
        $id = 'chapter-' . $i;
        $chapter = preg_replace('/<(.+?)>(.+?)<\/(.+?)>/',  '<$1 id ="' . $id . '">$2</$3>', $element[0]);
        $content = preg_replace($pattern, $chapter, $content, 1);
        $title = $element[1];
        $toc .= '<li class="p-toc__item"><a class="p-toc__link" href="#' . $id . '">' . $title . '</a></li>';
      }
      
      $toc .= '</ol></div>';
      $content = $toc . $content;
    }
  }
  return $content;
}
add_filter('the_content', 'my_add_content');