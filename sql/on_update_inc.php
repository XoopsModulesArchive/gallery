<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

/* Collection table update */
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

/* Category table update */
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

/* Banner table update */






?>