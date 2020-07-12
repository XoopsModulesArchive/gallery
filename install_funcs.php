<?php
function xoops_module_install_gallery(&$module) {
	$path = XOOPS_ROOT_PATH."/uploads";
	mkdir($path."/gallery", 0777);
	mkdir($path."/gallery/cache", 0777);
	mkdir($path."/gallery/banners", 0777);
	return true;
}

function xoops_module_uninstall_gallery(&$module) {
	$path = XOOPS_ROOT_PATH."/uploads";
	
	if(($files = array_diff( scandir($path."/gallery/cache", 1), array('.', '..'))) !== false) {
		foreach($files as $file) {
			unlink($path."/gallery/cache/".$file);
		}	
	}
	
	if(($files = array_diff( scandir($path."/gallery/banners", 1), array('.', '..'))) !== false) {
		foreach($files as $file) {
			unlink($path."/gallery/banners/".$file);
		}	
	}
	
	rmdir($path."/gallery/cache");
	rmdir($path."/gallery/banners");
	rmdir($path."/gallery");
	
	return true;
}

function xoops_module_update_gallery(&$module, $oldversion) {
	global $xoopsDB;
	
	$result = $xoopsDB->query( "SELECT `ban_id` FROM ".$xoopsDB->prefix("gallery_banners")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->queryF( "CREATE TABLE IF NOT EXISTS ".$xoopsDB->prefix("gallery_banners")." (`ban_id` int(5) unsigned NOT NULL auto_increment, `ban_name` text NOT NULL, `ban_image` text, `ban_link` text, `ban_date` int(10) NOT NULL, PRIMARY KEY  (`ban_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8" ) ;
	}
	
	$xoopsDB->queryF( "CREATE TABLE ".$xoopsDB->prefix("gallery_banners")." (`ban_id` int(5) unsigned NOT NULL auto_increment, `ban_name` text NOT NULL, `ban_image` text, `ban_link` text, `ban_date` int(10) NOT NULL, PRIMARY KEY  (`ban_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8" ) ;
	
	
	$result = $xoopsDB->query( "SELECT `coll_lid` FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_lid` int(11) NOT NULL AFTER `coll_id` default '0'" ) ;
	}

	$result = $xoopsDB->query( "SELECT `coll_thumb` FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_thumb` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL NOT NULL AFTER `coll_name`" ) ;
	}

	$result = $xoopsDB->query( "SELECT `coll_link` FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_link` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL NOT NULL AFTER `coll_thumb`" ) ;
	}

	$result = $xoopsDB->query( "SELECT coll_date FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_date` DATE NOT NULL AFTER `coll_link`" ) ;
	}

	$result = $xoopsDB->query( "SELECT coll_banner FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_banner` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL" ) ;
	}

	$result = $xoopsDB->query( "SELECT coll_bannerlink FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_bannerlink` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL" ) ;
	}

	$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." CHANGE `coll_name` `coll_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL" );
	$xoopsDB->query( "CREATE TABLE IF NOT EXIST ".$xoopsDB->prefix("gallery_banners")." (`ban_id` int(5) unsigned NOT NULL auto_increment, `ban_name` text NOT NULL, `ban_image` text, `ban_link` text, `ban_date` int(10) NOT NULL, PRIMARY KEY  (`ban_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8" ) ;

	// Category table update
	$result = $xoopsDB->query( "SELECT `cat_pid` FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_pid` int(11) NOT NULL AFTER `cat_id` default '0'" ) ;
	}

	$result = $xoopsDB->query( "SELECT `cat_thumb` FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_thumb` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL NOT NULL AFTER `cat_name`" ) ;
	}

	$result = $xoopsDB->query( "SELECT `cat_link` FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_link` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL NOT NULL AFTER `cat_thumb`" ) ;
	}

	$result = $xoopsDB->query( "SELECT `cat_hits` FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_hits` INT( 11 ) NOT NULL DEFAULT '0'" ) ;
	}

	$result = $xoopsDB->query( "SELECT cat_date FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_date` DATE NOT NULL" ) ;
	}

	$result = $xoopsDB->query( "SELECT cat_banner FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_banner` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL" ) ;
	}

	$result = $xoopsDB->query( "SELECT cat_bannerlink FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_bannerlink` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL" ) ;
	}

	$result = $xoopsDB->query( "SELECT cat_description FROM ".$xoopsDB->prefix("gallery_category")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_category")." ADD `cat_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL" ) ;
	}
	
	$result = $xoopsDB->query( "SELECT coll_description FROM ".$xoopsDB->prefix("gallery_collection")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->query( "ALTER TABLE ".$xoopsDB->prefix("gallery_collection")." ADD `coll_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL" ) ;
	}
		
	return true;
}

function createTable($sql) {
	echo $sql."<br/>";	
}
