<?php
/**
 * @module		mod_latestjoeart
 * @author-name Jose Felipe Herrera Rodríguez
 * @adapted by FHILIP
 * @copyright	Copyright (C) 2016
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access
defined ( '_JEXEC' ) or die ();
class ModjfhrLatestNewsHelper {
	public static function getLatestNews($params, $number_news, $order_date) {
		// Obtain a database connection
		$dba = JFactory::getDbo ();
		// Retrieve the shout

		// Access filter - obtiene el id del usuario logeado
		$user = JFactory::getUser ()->get ( 'id' );
		jimport ( 'joomla.access.access' );
		// Access filter - obtiene el grupo al que pertenece el usuario logeado
		$groups = JAccess::getGroupsByUser ( $user, false );

		foreach ( $groups as $group ) {
			$accessgroup = $group;
		}

		// Query Access label -- obtiene el id de acceso del grupo del usuario logeado para despues permitir o no su visualización
		$queryaccess = $dba->getQuery ( true )->select ( $dba->quoteName ( 'id' ) )->from ( $dba->quoteName ( '#__viewlevels' ) )->where ( "rules LIKE '%" . $accessgroup . "%'" );
		$dba->setQuery ( $queryaccess );
		$access = $dba->loadResult ();

		// Query multiple -- detecta si se esta ocupanto el módulo access manager para niveles de acceso multiple en artículos de Joomla
		$querymultiple = $dba->getQuery ( true )->select ( $dba->quoteName ( 'extension_id' ) )->from ( $dba->quoteName ( '#__extensions' ) )->where ( 'element = "com_accessmanager"' );
		$dba->setQuery ( $querymultiple );
		$querymultiplecount = $dba->loadResult ();

		if ($querymultiplecount = ! "") {
			// modo multiple
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true )->select ( $db->quoteName ( array (
					'c.title',
					'c.introtext',
					'c.id',
					'c.created',
					'c.images',
					'c.urls'
			) ) )->from ( $db->quoteName ( '#__content', 'c' ) )->join ( 'INNER', $db->quoteName ( '#__accessmanager_rights', 'am' ) . ' ON (' . $db->quoteName ( 'c.id' ) . ' = ' . $db->quoteName ( 'am.item' ) . ')' )->where ( 'c.catid = ' . $db->Quote ( $params ) )->where ( '(am.group = ' . $accessgroup . ' OR am.group = "1")', 'AND' )->where ( 'c.state = ' . 1 )->order ( 'c.publish_up ' . $order_date . '' )->setLimit ( $number_news );
			// Prepare the query
			$db->setQuery ( $query );
			// Load the row.
			$results = $db->loadRowList ();
			// Return the Hello
			return $results;
		} else {
			// modo normal
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true )->select ( $db->quoteName ( array (
					'title',
					'introtext',
					'id',
					'created',
					'images',
					'urls'
			) ) )->from ( $db->quoteName ( '#__content' ) )->where ( 'catid = ' . $db->Quote ( $params ) )->where ( '(access = ' . $access . ' OR access = "1")', 'AND' )->
			// ->where('access = '. $access.' OR access = 1')
			where ( 'state = ' . 1 )->order ( 'c.publish_up ' . $order_date . '' )->setLimit ( $number_news );
			// Prepare the query
			$db->setQuery ( $query );
			// Load the row.
			$results = $db->loadRowList ();
			// Return the Hello
			return $results;
		}
	}
	public static function getDataJoeExtras($id_article) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true )->select ( $db->quoteName ( array (
				'data'
		) ) )->from ( $db->quoteName ( '#__content_jfhr_extras' ) )->where ( 'article_id = ' . $id_article );
		$db->setQuery ( $query );
		$result = $db->loadResult ();
		return $result;
	}
	public static function getDataItem($id_img) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true )->select ( $db->quoteName ( array (
				'filename'
		) ) )->from ( $db->quoteName ( '#__phocagallery' ) )->where ( 'id = ' . $id_img );
		$db->setQuery ( $query );
		$result = $db->loadResult ();
		return $result;
	}
	/* JOOMDLE */
	public static function getUserContry($username = "") {
		require_once (JPATH_SITE . '/components/com_joomdle/helpers/content.php');

		$userContry = JoomdleHelperContent::getUserContry ( $username );

		return $userContry;
	}
}
