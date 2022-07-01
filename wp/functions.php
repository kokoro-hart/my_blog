<?php


/*------------------------------------------------------------------*/
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


/*------------------------------------------------------------------*/
// WordPress同梱のjQueryを読み込ませない
function new_deregister_script() {
  if ( !is_admin() ) {
    wp_deregister_script('jquery');
  }
}
add_action('init', 'new_deregister_script');


/*------------------------------------------------------------------*/
// タイトルの区切り
function change_title_separator( $sep ){
  $sep = ' | ';
  return $sep;
}
add_filter( 'document_title_separator', 'change_title_separator' );


/*------------------------------------------------------------------*/
// css jsの読み込み
function my_script_init()
{
  wp_enqueue_style('my', get_template_directory_uri() . '/css/style.css', array(), '1.0.0', 'all');
  wp_enqueue_script('my', get_template_directory_uri() . '/js/bundle.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_script_init');


/*------------------------------------------------------------------*/
// フォーム設置ページのみContactForm7のcss、jsを読み込み
add_action( 'wp', function() 
{
  if ( is_page( 'contact' )) return;
  add_filter( 'wpcf7_load_js', '__return_false' );
  add_filter( 'wpcf7_load_css', '__return_false' );
});


/*------------------------------------------------------------------*/
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


/*------------------------------------------------------------------*/
// scriptタグにdefer属性を追加
function scriptLoader($script, $handle, $src) {
	if (is_admin()) {
		return $script;
	}
	$script = sprintf('<script src="%s" type="text/javascript" defer=""></script>' . "\n", $src);
	return $script;
}
add_filter('script_loader_tag', 'scriptLoader', 10, 5);


/*------------------------------------------------------------------*/
//プロフィール項目追加
function my_user_meta($wb)
{
//項目の追加例
$wb['twitter'] = 'Twitter';
$wb['github'] = 'GitHub';
$wb['linkedin'] = 'portfolio';

return $wb;
}
add_filter('user_contactmethods', 'my_user_meta', 10, 1);


/*------------------------------------------------------------------*/
// シンタックスハイライトのショートコード
function highlight_shortcode($class, $content = '')
{    //引数として$classと$contentを定義。
  return 
  '<code  class = "' . $class['class'] . '">' . 
    $content . 
  '</code>';    //引数で渡された$classと$contentが代入される。
}
add_shortcode('highlight', 'highlight_shortcode');


/*------------------------------------------------------------------*/
// 目次の生成
function my_add_content( $content ) {
  if ( is_single() ) {
    // h2～h5までを検索
    $pattern = '/<h[2-3]>(.*?)<\/h[2-3]>/i';
    preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );
		
    // ページ内のh2・h3要素が1つ以上の場合に目次を出力
    if( count( $matches ) > 1 ){ 
      global $toc2;
      $toc = '<div class="p-toc u-hidden-lg-up"><div class="p-toc__title-wrapper"><h2 class="p-toc__title">目次</h2></div><nav class="p-toc__body"><ul>';// 本文中の目次コード
      $toc2 = '<section class="p-toc-sidebar p-sidebar__sticky u-hidden-lg-down"><div class="p-toc-sidebar__inner"><h2 class="p-toc-sidebar__title">目次</h2><nav class="p-toc-sidebar__body"><ul>';// サイドバーの目次コード
      
      // 目次の階層の判断に使用する変数
      $hierarchy = NULL;
      // ループ回数を数える変数
      $i = 0;
			
      // 本文内のh2・h3要素を上から順番にループで処理
      foreach( $matches as $element ){ 
        $i++;
        $id = 'chapter-' . $i;
        $chapter = preg_replace( '/<(.+?)>(.+?)<\/(.+?)>/',  '<$1 id ="' . $id . '" class="js-heading">$2</$3>', $element[0] );
        $content = preg_replace( $pattern, $chapter, $content, 1);
				
        if( strpos( $element[0], '<h2' ) === 0 ){ 
          $level = 0;
        }elseif( strpos( $element[0], '<h3' ) === 0 ){ 
          $level = 1;
        }elseif( strpos( $element[0], '<h4' ) === 0 ){ 
          $level = 2;
        }else{        
          $level = 3;
        }
				
        // サイドバーの目次が長くなりすぎるのを避けるため、サイドバーはh2だけを目次として扱うように設定した
        // 現在の状態を判断する条件分岐
        if( $hierarchy === $level ){ // hxがそれぞれ連続する場合
          $toc .= '</li>';
          $toc2 .= '</li>';
        }elseif( $hierarchy < $level ){ // 次が小見出しとなる場合
          switch($level){
            case 1:
              $toc .= '<ul>';              
              $toc2 .= '<ul>';
              $hierarchy = 1;
              break;
            case 2:
              $toc .= '<ul>';              
              $toc2 .= '<ul>';
              $hierarchy = 2;
              break;
            case 3:
              $toc .= '<ul>';              
              $toc2 .= '<ul>';
              $hierarchy = 3;
              break;
          }
        }elseif( $hierarchy > $level ){ // 次が親見出しとなる場合
          switch($hierarchy){
            case 1:
              switch($level){
                case 0:
                  $toc .= '</li></ul></li>';                  
                  $toc2 .= '</li></ul></li>';
                  $hierarchy = 0;
                  break;
              }
              break;
            case 2:
              switch($level){
                case 0:
                  $toc .= '</li></ul></li></ul></li>';                  
                  $toc2 .= '</li></ul></li></ul></li>';
                  $hierarchy = 0;
                  break;
                case 1:
                  $toc .= '</li></ul></li>';                  
                  $toc2 .= '</li></ul></li>';
                  $hierarchy = 1;
                  break;
              }
              break;
            case 3:
              switch($level){
                case 0:
                  $toc .= '</li></ul></li></ul></li></ul></li>';
                  $toc2 .= '</li></ul></li></ul></li></ul></li>';
                  $hierarchy = 0;
                  break;
                case 1:
                  $toc .= '</li></ul></li></ul></li>';                  
                  $toc2 .= '</li></ul></li></ul></li>';
                  $hierarchy = 1;
                  break;
                case 2:
                  $toc .= '</li></ul></li>';                  
                  $toc2 .= '</li></ul></li>';
                  $hierarchy = 2;
                  break;
              }
              break;
          }
        }elseif( $i == 1 ){ // ループ1回目の場合
          $hierarchy = 0;
        }
				
        // 目次の項目で使用する要素を指定
        $title = $element[1]; 
        // 目次の項目を作成。※次のループで<li>の直下に<ol>タグを出力する場合ががあるので、ここでは<li>タグを閉じていません。
        if($hierarchy == 0){
          $toc .= '<li><a href="#' . $id . '">' . $title . '</a>';
          $toc2 .= '<li><a data-id="#' . $id . '" href="#' . $id . '">' . $title . '</a>';
        }else{
          $toc .= '<li><a href="#' . $id . '">' . $title . '</a>';
          $toc2 .= '<li><a data-id="#' . $id . '" href="#' . $id . '">' . $title . '</a>';
        }
      }
			
      // 目次の最後の項目をどの要素から作成したかによりタグの閉じ方を変更
      if( $level == 0 ){
        $toc .= '</li></ul>';
        $toc2 .= '</li></ul>';
      }elseif( $level == 1 ){
        $toc .= '</li></ul></li></ul>';
        $toc2 .= '</li></ul>';
      }elseif( $level == 2 ){
        $toc .= '</li></ul></li></ul></li></ul>';
        $toc2 .= '</li></ul>';
      }elseif( $level == 3 ){
        $toc .= '</li></ul></li></ul></li></ul></li></ul>';
        $toc2 .= '</li></ul>';
      }

      $toc .= '</nav></div>';
      $toc2 .= '</nav></section>';

      $ad1 = <<< EOF
      EOF;

      $ad2 = <<< EOF
      EOF;

      global $ad3;
      $ad3 = <<< EOF
      EOF;

      // 本文に目次を追加
      $h2 = '/^<h2.*?>.+?<\/h2>$/im';//H2見出しのパターン
      if ( preg_match_all( $h2, $content, $h2s )) {//H2見出しが本文中にあるかどうか
        if ( $h2s[0] ) {//チェックは不要と思うけど一応
          if ( $h2s[0][0] ) {//1番目のH2見出し手前に目次を挿入
            $content  = str_replace($h2s[0][0], $toc.$h2s[0][0], $content);
          }
        }
      }
    }
  }
  return $content;
}
add_filter('the_content','my_add_content');


function my_sidebar_echo(){
  global $toc2;
  if($toc2){
    echo $toc2;
  }
}
add_action('my_sidebar_action_hook', 'my_sidebar_echo', 11);