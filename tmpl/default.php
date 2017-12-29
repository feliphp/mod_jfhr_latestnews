<?php
/**
 * @module		mod_jfhr_latestnews
 * @author-name Jose Felipe Herrera Rodríguez
 * @adapted by FHILIP
 * @copyright	Copyright (C) 2016 
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined ( '_JEXEC' ) or die ();
$document = JFactory::getDocument ();
$cssurl = JURI::root () . 'modules/mod_jfhr_latestnews/themes/default/css/jfhr_latestnews.css';
$document->addStyleSheet ( $cssurl );
?>
<style>
.latest-joe-img {
	height: 80px;
	/*max-width:<?php echo $width;?> !important;
		height:<?php echo $height;?>;*/
}

#latest-joe {
	background: <?php echo$color_fondo; ?> none repeat scroll 0 0;
	padding-top: 23px;
	margin-left: -10px;
	width: <?php echo$width; ?>;
	height: 500px;
	position: relative;
	overflow-x: hidden;
}

.latest-joe-title {
	font-family: SourceSansPro-Bold, Helvetica, Sans-Serif !important;
	font-size: <?php echo$font_size; ?>;
	color: <?php

echo $color_title;
	?>
	!
	important;
}

.latest-joe-date {
	font-family: SourceSansPro-Semibold, Helvetica, Sans-Serif;
	font-size: <?php echo $font_size; ?>;
	color: <?php echo $color_date; ?>;
}

.latest-joe-intro {
	display: block;
	height: 90px;
	width: 220px;
	margin-left: 80px;
	font-family: SourceSansPro, Helvetica, Sans-Serif;
	font-size: <?php echo $font_size; ?>;
	color: <?php echo $color_intro; ?>;
}

#titulo-contigo {
	width: <?php echo$width; ?>;
	padding-top: -10px;
	background-color: #FA6F28;
	height: 32px;
	margin-top: -6px;
	margin-left: -10px;
	z-index: 45;
}
</style>
<?php
echo " <div id='titulo-contigo'><img src='" . JURI::root () . "/modules/mod_jfhr_latestnews/assets/icon_canal_contigo.png' height='19px' width='19px'><div id='tit-con'> " . $module->title . " </div></div>";
echo " <div id='latest-joe'>";
foreach ( $latestNews as $new ) {
	// limpieza
	$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	$cadena = utf8_decode ( $new [1] );
	$cadena = strtr ( $cadena, utf8_decode ( $originales ), $modificadas );
	$cadena = strtolower ( $cadena );
	preg_match ( "/<img\s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>/i", $cadena, $m );
	// end limpieza
	$sx = simplexml_load_string ( $m [0] );
	$img = json_decode ( $new [4] );
	$img_small = $img->image_intro;
	// url mysqli_get_metadata
	$url_meta = json_decode ( $new [5] );
	$urlm = $url_meta->urla;
	$imgdef = JURI::root () . "administrator/templates/hathor/images/header/icon-48-article.png";
	if ($sx ['src'] == "") {
		$sx ['src'] = $imgdef;
	}
	echo "<div class='latest-joe-img'>";
	if ($show_thumbnail == 1) {
		if ($manage_image == 'article') {
			if ($url_source == 'article') {
				echo "<a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . $sx ['src'] . "' height='50px' width='90px'></a>";
			} else {
				if ($urlm == false) {
					echo "<a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . $sx ['src'] . "' height='50px' width='90px'></a>";
				} else {
					echo "<a href='" . $urlm . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . $sx ['src'] . "' height='50px' width='90px'></a>";
				}
			}
		} else if ($manage_image == 'metadata') {
			if ($url_source == 'article') {
				echo "<a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . $img_small . "' height='50px' width='90px'></a>";
			} else {
				if ($urlm == false) {
					echo "<a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . $img_small . "' height='50px' width='90px'></a>";
				} else {
					echo "<a href='" . $urlm . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . $img_small . "' height='50px' width='90px'></a>";
				}
			}
		} else if ($manage_image == 'type') {
			$id_art = $new [2];
			// Tipo de Archivo en data Extras
			$data = modjfhrLatestNewsHelper::getDataJoeExtras ( $id_art );
			$da = json_decode ( $data );
			$im_at = substr ( $da, 19, - 2 );
			// obtener imagen
			$imagen_cat = modjfhrLatestNewsHelper::getDataItem ( $im_at );
			if ($url_source == 'article') {
				echo "<a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' target='" . $target_url . "'><img src='" . JURI::root () . "modules/mod_jfhr_latestnews/assets/" . $imagen_cat . "'' height='43px' width='43px'></a>";
			} else {
				if ($urlm == false) {
					echo "<a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . JURI::root () . "modules/mod_jfhr_latestnews/assets/" . $imagen_cat . "'' height='43px' width='43px'></a>";
				} else {
					echo "<a href='" . $urlm . "' class='latest-joe-title' target='" . $target_url . "'><img src='" . JURI::root () . "modules/mod_jfhr_latestnews/assets/" . $imagen_cat . "'' height='43px' width='43px'></a>";
				}
			}
		} else {
		}
	}
	if ($show_title == 1) {
		// Primero eliminamos las etiquetas html y luego cortamos el string
		// $stringTitle = substr(strip_tags($new[0]), 0, $limit_title);
		$stringTitle = mb_substr ( strip_tags ( $new [0] ), 0, $limit_title, 'UTF-8' );
		// Si el texto es mayor que la longitud se agrega puntos suspensivos
		if (strlen ( strip_tags ( $new [0] ) ) > $limit_title) {
			$stringTitle .= ' ...';
		}
		if ($url_source == 'article') {
			echo "<div class='latest-joe-title'><strong><a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'>" . $stringTitle . "</a></strong></div>";
		} else {
			if ($urlm == false) {
				echo "<div class='latest-joe-title'><strong><a href='" . JURI::root () . "index.php?option=com_content&view=article&id=" . $new [2] . "&Itemid=114" . "' class='latest-joe-title' target='" . $target_url . "'>" . $stringTitle . "</a></strong></div>";
			} else {
				echo "<div class='latest-joe-title'><strong><a href='" . $urlm . "' class='latest-joe-title' target='" . $target_url . "'>" . $stringTitle . "</a></strong></div>";
			}
		}
	}
	if ($show_date == 1) {
		setlocale ( LC_TIME, "es_ES" );
		$fec = date_create ( $new [3] );

		$datte2 = strftime ( "%d de %B", strtotime ( $new [3] ) );
		echo "<div class='latest-joe-date'><i>" . $datte2 . "</i></div>";
	}
	if ($show_intro == 1) {
		// Primero eliminamos las etiquetas html y luego cortamos el string
		// $stringIntro = substr(strip_tags($new[1]), 0, $limit_intro);
		$stringIntro = mb_substr ( strip_tags ( $new [1] ), 0, $limit_intro, 'UTF-8' );
		// Si el texto es mayor que la longitud se agrega puntos suspensivos
		if (strlen ( strip_tags ( $new [1] ) ) > $limit_intro) {
			$stringIntro .= ' ...';
		}
		echo "<div class='latest-joe-intro'>" . $stringIntro . "<br><br>";
	}

	echo "</div><hr>";
}
echo "</div>";
?>
