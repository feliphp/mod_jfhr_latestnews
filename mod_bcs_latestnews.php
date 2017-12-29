<?php
/**
 * @module		mod_jfhr_latestnews
 * @author-name Jose Felipe Herrera Rodríguez
 * @adapted by FHILIP
 * @copyright	Copyright (C) 2016 GNU
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined ( '_JEXEC' ) or die ();

require_once dirname ( __FILE__ ) . '/helper.php';

// Joomdle //
// $user_id = JUserHelper::getUserId($username);
// $userCountryMoodle = modjfhrLatestNewsHelper::getUserContry($user_id);
// var_dump($userCountryMoodle);
// End Joomdle //

$category = $params->get ( 'title', '1' );
$manage_image = $params->get ( 'source', 'article' );
$number_news = $params->get ( 'number_news', '4' );
$show_thumbnail = $params->get ( 'show_thumbnail', '0' );
$show_title = $params->get ( 'show_title', '1' );
$limit_title = $params->get ( 'limit_title', '50' );
$show_intro = $params->get ( 'show_intro', '1' );
$limit_intro = $params->get ( 'limit_intro', '50' );

$width = $params->get ( 'width_latest', '60%' );
$color_title = $params->get ( 'code_color_title', '#000000' );
$color_intro = $params->get ( 'code_color_intro', '#C0C0C0' );
$color_date = $params->get ( 'code_color_date', '#122F75' );
$color_fondo = $params->get ( 'code_color_background', '#FFF' );
$font_size = $params->get ( 'font_size_latest', '12px' );
$show_date = $params->get ( 'show_date', '1' );

$order_date = $params->get ( 'order_date', 'DESC' );
$target_url = $params->get ( 'target_url', '_blank' );
$url_source = $params->get ( 'url_source', 'article' );

$latestNews = modjfhrLatestNewsHelper::getLatestNews ( $category, $number_news, $order_date );

require JModuleHelper::getLayoutPath ( 'mod_jfhr_latestnews' );
