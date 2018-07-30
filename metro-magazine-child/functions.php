<?php
//子テーマスタイル読み込み
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style')
);
}

// Customize YouTube oEmbed Code　ツベのURLを貼るだけでレスポンシブ
function custom_youtube_oembed($code){
  if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false){
    $html = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0", $code);
    $html = preg_replace('/ width="\d+"/', '', $html);
    $html = preg_replace('/ height="\d+"/', '', $html);
    $html = '<div class="youtube">' . $html . '</div>';

    return $html;
  }
  return $code;
}

add_filter('embed_handler_html', 'custom_youtube_oembed');
add_filter('embed_oembed_html', 'custom_youtube_oembed');

// セルフピンバック対策
function no_self_ping( &$links ) {
        $home = get_option( 'home' );
        foreach ( $links as $l => $link )
                if ( 0 === strpos( $link, $home ) )
                        unset($links[$l]);
}
 
add_action( 'pre_ping', 'no_self_ping' );


?>