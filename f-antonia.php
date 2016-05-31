<?php

/*

Plugin Name: myfunction.php

Plugin URI: http://nevskiy.com.ua

Description: f-antonia

Version: 1.0

Author: Nevskiy

Author URI: http://nevskiy.com.ua



  Copyright 2016  Dmitro Nevskyi  (email: dmitriy.a.nevskiy@gmail.com)



  This program is free software; you can redistribute it and/or modify

  it under the terms of the GNU General Public License as published by

  the Free Software Foundation; either version 2 of the License, or

  (at your option) any later version.



  This program is distributed in the hope that it will be useful,

  but WITHOUT ANY WARRANTY; without even the implied warranty of

  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

  GNU General Public License for more details.



  You should have received a copy of the GNU General Public License

  along with this program; if not, write to the Free Software

  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



// *Clean <head> Убирает ненужные ссылки из секции <head>*

// Отключает поддержку Emoji

remove_action('wp_head','print_emoji_detection_script', 7 );

remove_action('wp_print_styles','print_emoji_styles' );

remove_action('admin_print_scripts','print_emoji_detection_script' );

remove_action('admin_print_styles','print_emoji_styles' );

// Удаляет meta generator

remove_action('wp_head','wp_generator');

// Отключает ленты RSS

remove_action('wp_head','feed_links_extra', 3 );

remove_action('wp_head','feed_links', 2 );

// Убирает ссылки на сайт wordpress.org из админ бара

//Запретите редактирование файлов через wp-config.php

//Запретите исполнение .php файлов в директории wp-content

// Прячет ошибки при входе на сайт

// Убирает возможность узнать логин администратора

remove_action('wp_head','rsd_link');

remove_action('wp_head','wlwmanifest_link');

remove_action('wp_head','index_rel_link' );

remove_action('wp_head','parent_post_rel_link', 10, 0 );

remove_action('wp_head','start_post_rel_link', 10, 0 );

remove_action('wp_head','adjacent_posts_rel_link', 10, 0 );

remove_action('wp_head','profile_link' );

remove_action('wp_head', 'previous_post_rel_link', 10, 0);

remove_action('wp_head', '_ak_framework_meta_tags');

remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Отключаем сам REST API

add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API

remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );

remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );

remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );

remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );

remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );

remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );

remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );

remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API

remove_action( 'init', 'rest_api_init' );

remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );

remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API

remove_action( 'rest_api_init', 'wp_oembed_register_route' );

remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

// *Ограничивает или выключает ревизии*

// 1.Ограничение количества редакций

function my_revisions_to_keep( $revisions ) {

    return 3;

}

add_filter( 'wp_revisions_to_keep', 'my_revisions_to_keep' );

// 2.Отключаем автосохранение

function disableAutoSave(){

wp_deregister_script('autosave');

}

add_action( 'wp_print_scripts', 'disableAutoSave' );

show_admin_bar(false);

// Убирает ссылку на X-Pingback и возможность спамить pingback'ами

function remove_x_pingback($headers) {

    unset($headers['X-Pingback']);

    return $headers;

}

add_filter('wp_headers', 'remove_x_pingback');



// ------------

function functionsphp_head_info(){

 

}

add_action('wp_head', 'functionsphp_head_info');



// Удаляет стили .recentcomments Remove Recent Comments

add_action( 'widgets_init', 'my_remove_recent_comments_style' );

function my_remove_recent_comments_style() {

  global $wp_widget_factory;

  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'  ) );

}



// HTTP-заголовок Last-Modified

// header('Expires: '.gmdate('D, d M Y H:i:s', time() + 7200).' GMT');

// header('Cache-Control: no-cache, must-revalidate');

// $mt = filemtime($file_name);

// $mt_str = gmdate("D, d M Y H:i:s ")."GMT";

// if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&

// strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $mt)

// {header('HTTP/1.1 304 Not Modified');

// die;

// }

header('Last-Modified: '.$mt_str);

echo $text;

header("Vary: Accept-Encoding");

header("Accept-Encoding:gzip,deflate,sdch");

// Create robots

add_filter('robots_txt', 'add_robotstxt');

function add_robotstxt($text){
$text .= "User-agent: Mediapartners-Google\n";
$text .= "Disallow:\n";
"\n";
$text .= "Disallow: /cgi-bin\n";
$text .= "Disallow: /wp-*\n";
$text .= "Disallow: /*?*=\n";
$text .= "Disallow: *&s=\n";
$text .= "Disallow: /category\n";
$text .= "Disallow: /author/\n";
$text .= "Disallow: */*/feed\n";
$text .= "Disallow: */feed\n";
$text .= "Disallow: /xmlrpc.php\n";
$text .= "Disallow: */page/\n";
$text .= "Disallow: /tag\n";
$text .= "Disallow: /trackback\n";
$text .= "Disallow: */trackback\n";
$text .= "Disallow: */*/trackback\n";
$text .= "Disallow: /20\n";
$text .= "Disallow: /page\n";

$text .= "Disallow: project.faberlic-line.com/?Large-Flared-Penis-Head\n";
$text .= "Disallow: project.faberlic-line.com/\n";

$text .= "Allow: /userfiles\n";
$text .= "Allow: /*/*.js\n";
$text .= "Allow: /*/*.css\n";
"\n";
$text .= "User-agent: Yandex\n";
$text .= "Disallow: /cgi-bin\n";
$text .= "Disallow: /wp-*\n";
$text .= "Disallow: /*?*=\n";
$text .= "Disallow: *&s=\n";
$text .= "Disallow: /category\n";
$text .= "Disallow: /author/\n";
$text .= "Disallow: */*/feed\n";
$text .= "Disallow: */feed\n";
$text .= "Disallow: /xmlrpc.php\n";
$text .= "Disallow: */page/\n";
$text .= "Disallow: /tag\n";
$text .= "Disallow: /trackback\n";
$text .= "Disallow: */trackback\n";
$text .= "Disallow: */*/trackback\n";
$text .= "Disallow: /20\n";
$text .= "Disallow: /page\n";

$text .= "Disallow: project.faberlic-line.com/?Large-Flared-Penis-Head\n";
$text .= "Disallow: project.faberlic-line.com/\n";

$text .= "Allow: /userfiles\n";
$text .= "Allow: /*/*.js\n";
$text .= "Allow: /*/*.css\n";
"\n";
$text .= "User-agent: Googlebot\n";
$text .= "Disallow: /cgi-bin\n";
$text .= "Disallow: /wp-*\n";
$text .= "Disallow: /*?*=\n";
$text .= "Disallow: *&s=\n";
$text .= "Disallow: /category\n";
$text .= "Disallow: /author/\n";
$text .= "Disallow: */*/feed\n";
$text .= "Disallow: */feed\n";
$text .= "Disallow: /xmlrpc.php\n";
$text .= "Disallow: */page/\n";
$text .= "Disallow: /tag\n";
$text .= "Disallow: /trackback\n";
$text .= "Disallow: */trackback\n";
$text .= "Disallow: */*/trackback\n";
$text .= "Disallow: /20\n";
$text .= "Disallow: /page\n";

$text .= "Disallow: project.faberlic-line.com/?Large-Flared-Penis-Head\n";
$text .= "Disallow: project.faberlic-line.com/\n";

$text .= "Allow: /userfiles\n";
$text .= "Allow: /*/*.js\n";
$text .= "Allow: /*/*.css\n";
"\n";
$text .= "Sitemap: http://faberlic-line.com/sitemap.xml\n";
$text .= "Sitemap: http://faberlic-line.com/sitemap.xml.gz\n";
"\n";
$text .= "Host: faberlic-line.com\n";
"\n";
$text .= "User-agent: Googlebot-Image\n";
$text .= "Allow: /userfiles\n";
"\n";
$text .= "User-agent: YandexImages\n";
$text .= "Allow: /userfiles\n";

  return $text;

}





// Кастомизация worpress adminki

// Удаляем логотип WordPress из Панели администратора

function remove_admin_bar_links() {

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('wp-logo');

    }

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// Удаляем Комментарии и Ссылки из Консоли WordPress

add_action( 'admin_init', 'my_remove_menu_pages' );

    function my_remove_menu_pages() {

        remove_menu_page('edit.php');

        remove_menu_page('edit-comments.php');

        //remove_menu_page('link-manager.php');

    }

//удаление из панели "комментариев" start

function wph_new_toolbar() {

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('comments');

    $wp_admin_bar->remove_menu('new-content');

}

add_action('wp_before_admin_bar_render', 'wph_new_toolbar');

// Отключение стандартных виджетов WordPress

function true_remove_default_widget() {

  unregister_widget('WP_Widget_Archives'); // Архивы

  unregister_widget('WP_Widget_Calendar'); // Календарь

  unregister_widget('WP_Widget_Categories'); // Рубрики

  unregister_widget('WP_Widget_Meta'); // Мета

  unregister_widget('WP_Widget_Pages'); // Страницы

  unregister_widget('WP_Widget_Recent_Comments'); // Свежие комментарии

  unregister_widget('WP_Widget_Recent_Posts'); // Свежие записи

  unregister_widget('WP_Widget_RSS'); // RSS

  unregister_widget('WP_Widget_Search'); // Поиск

  unregister_widget('WP_Widget_Tag_Cloud'); // Облако меток

  // unregister_widget('WP_Widget_Text'); // Текст

  unregister_widget('WP_Nav_Menu_Widget'); // Произвольное меню

}

 

add_action( 'widgets_init', 'true_remove_default_widget', 20 );

?>