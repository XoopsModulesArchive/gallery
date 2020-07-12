<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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
//include_once("header.php");
include_once "../../mainfile.php";
$xoopsOption['template_main'] = "gallery_index.html";
include_once XOOPS_ROOT_PATH."/header.php";
include_once "include/functions.php";

if($xoopsModuleConfig['enable_error_reporting'] == 1) {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

if ($xoopsModuleConfig['show_latest_main'] == 1) {
	
	
	$xoopsTpl->assign('lb_box', $xoopsModuleConfig['thumb_effect']);
	if($xoopsModuleConfig['enable_rss'] == 1) {
		$alink = '<a href="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/gallery_rss.php">';
		$link = '<img src="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/images/rss.gif"/></a>';
		$feed_link = $alink.$link."</a>";
		$xoopsTpl->assign('lang_rss_feed', $feed_link);
	} else {
		$xoopsTpl->assign('lang_rss_feed', '');
	}
	$xoopsTpl->assign('description', _MD_GALLERY_DESC);	
	$xoopsTpl->assign('load_jquery', $xoopsModuleConfig['load_jquery']);
	$xoopsTpl->assign('latest_col', _MI_GALLERY_LATESTTXT);
	$xoopsTpl->assign('f_cols', $xoopsModuleConfig['f_cols']);
	$xoopsTpl->assign('show_hits', $xoopsModuleConfig['show_hits']);
	$xoopsTpl->assign('lang_hits', _MD_GALLERY_SHOWHITS);
	$xoopsTpl->assign('show_date_added', $xoopsModuleConfig['show_date_added']);
	$xoopsTpl->assign('lang_date_added', _MD_GALLERY_DATEADDED);
	
	
	$sql = "SELECT cat_id FROM " .$xoopsDB->prefix('gallery_category');
	$result = $xoopsDB->query($sql);
	$cat_array = array();
	$indx_count = 0;
	array_push($cat_array, 0);
	if($xoopsDB->getRowsNum($result) != 0) {
		while(list($cat_id) = $xoopsDB->fetchRow($result)) {
			if (checkPermissions($cat_id)) {
				array_push($cat_array, $cat_id);
			}
		}
	}

	$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_hits, coll_date FROM " .$xoopsDB->prefix('gallery_collection')." ORDER BY coll_date DESC";
	$result = $xoopsDB->query($sql);
	
	if($xoopsDB->getRowsNum($result) == 0) {
		
	} else {
		$count = 0;
		while(list($coll_id, $coll_lid, $coll_name, $coll_thumb, $coll_hits, $coll_date) = $xoopsDB->fetchRow($result)) {
			if(in_array($coll_lid, $cat_array) && $count < $xoopsModuleConfig['images_per_page']) {
				$xoopsTpl->append('collections', array('coll_id'=>$coll_id, 
									'coll_name'=>$coll_name, 
									'coll_thumb'=>XOOPS_URL . $xoopsModuleConfig['thumbnail_location'].'/'.$coll_thumb, 
									'coll_hits'=>$coll_hits,
									'coll_date'=>date('m-d-Y', $coll_date),
									'coll_count'=>$count)); 
				$count++;
				$indx_count++;
			}
		}
	}

	$newNavigation = "<a href=\"".XOOPS_URL."/\">"._MB_SYSTEM_HOME."</a>";
	$newNavigation .= " ".$xoopsModuleConfig['gallery_breadcrumb']." "._MD_GALLERY_MAIN;
	
	$xoopsTpl->assign('navigation', $newNavigation);
	$xoopsOption['show_rblock'] = 0;	
} else {
	$xoopsTpl->assign('lb_box', $xoopsModuleConfig['thumb_effect']);
	if($xoopsModuleConfig['enable_rss'] == 1) {
		$alink = '<a href="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/gallery_rss.php">';
		$link = '<img src="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/images/rss.gif"/></a>';
		$feed_link = $alink.$link."</a>";					
		$xoopsTpl->assign('lang_rss_feed', $feed_link);
	} else {
		$xoopsTpl->assign('lang_rss_feed', '');
	}
	
	$xoopsTpl->assign('description', _MD_GALLERY_DESC);	
	$xoopsTpl->assign('load_jquery', $xoopsModuleConfig['load_jquery']);
	$xoopsTpl->assign('latest_col', _MI_GALLERY_LATESTTXT);
	$xoopsTpl->assign('f_cols', $xoopsModuleConfig['f_cols']);
	$xoopsTpl->assign('show_hits', $xoopsModuleConfig['show_hits']);
	$xoopsTpl->assign('lang_hits', _MD_GALLERY_SHOWHITS);
	$xoopsTpl->assign('show_date_added', $xoopsModuleConfig['show_date_added']);
	$xoopsTpl->assign('lang_date_added', _MD_GALLERY_DATEADDED);
	
	$sql = "SELECT cat_id FROM " .$xoopsDB->prefix('gallery_category');
	$result = $xoopsDB->query($sql);
	$cat_array = array();
	$indx_count = 0;
	array_push($cat_array, 0);
	if($xoopsDB->getRowsNum($result) != 0) {
		while(list($cat_id) = $xoopsDB->fetchRow($result)) {
			if (checkPermissions($cat_id)) {
				array_push($cat_array, $cat_id);
			}
		}
	}
	
	$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_hits, coll_date FROM " .$xoopsDB->prefix('gallery_collection')." ORDER BY RAND()";
	$result = $xoopsDB->query($sql);
	
	if($xoopsDB->getRowsNum($result) == 0) {
		
	} else {
		$count = 0;
		while(list($coll_id, $coll_lid, $coll_name, $coll_thumb, $coll_hits, $coll_date) = $xoopsDB->fetchRow($result)) {
			if(in_array($coll_lid, $cat_array) && $count < $xoopsModuleConfig['images_per_page']) {
				$xoopsTpl->append('collections', array('coll_id'=>$coll_id, 
									'coll_name'=>$coll_name, 
									'coll_thumb'=>XOOPS_URL . $xoopsModuleConfig['thumbnail_location'].'/'.$coll_thumb, 
									'coll_hits'=>$coll_hits,
									'coll_date'=>date('m-d-Y', $coll_date),
									'coll_count'=>$count)); 
				$count++;
				$indx_count++;
			}
		}
	}
}
include(XOOPS_ROOT_PATH."/footer.php");
?>
