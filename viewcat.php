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

include "../../mainfile.php";
$xoopsOption['template_main'] = "gallery_viewcat.html";
include XOOPS_ROOT_PATH."/header.php";

if($xoopsModuleConfig['enable_error_reporting'] == 1) {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

$xoopsTpl->assign('lb_box', $xoopsModuleConfig['thumb_effect']);
$xoopsTpl->assign('load_jquery', $xoopsModuleConfig['load_jquery']);
$xoopsTpl->assign('latest_col', _MI_GALLERY_LATESTTXT);
$xoopsTpl->assign('f_cols', $xoopsModuleConfig['f_cols']);
$xoopsTpl->assign('show_hits', $xoopsModuleConfig['show_hits']);
$xoopsTpl->assign('lang_hits', _MD_GALLERY_SHOWHITS);

$id = (int)$_REQUEST['id'];
$num = isset($_REQUEST['num']) ? (int)$_REQUEST['num'] : 0;

if($xoopsModuleConfig['enable_rss'] == 1) {
	$alink = '<a href="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/gallery_rss.php?id='.$id.'">';
	$link = '<img src="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/images/rss.gif"/></a>';
	$feed_link = $alink.$link."</a>";					
	$xoopsTpl->assign('lang_rss_feed', $feed_link);
} else {
	$xoopsTpl->assign('lang_rss_feed', '');
}

$colls_db = array();

if (!checkPermissions($id)) {
	redirect_header("index.php", 2, _MD_UNATHORIZED);
}

if($xoopsModuleConfig['show_all'] == 1 && $id == 0) {
	$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_hits FROM " .$xoopsDB->prefix('gallery_collection')." ORDER BY coll_date, coll_name";
} else {
	$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_hits FROM " .$xoopsDB->prefix('gallery_collection')." WHERE coll_lid='".$id."' ORDER BY coll_date, coll_name";
}
$result = $xoopsDB->query($sql);

if($xoopsDB->getRowsNum($result) != 0) {
		
	$count = 0;
	while(list($coll_id, $coll_lid, $coll_name, $coll_thumb, $coll_hits) = $xoopsDB->fetchRow($result)) {
		if(checkPermissions($coll_lid)) {
			$colls_db[$count] = array('coll_id'=>$coll_id, 
									'coll_name'=>$coll_name, 
									'coll_thumb'=>XOOPS_URL . $xoopsModuleConfig['thumbnail_location'].'/'.$coll_thumb, 
									'coll_hits'=>$coll_hits,
									'coll_count'=>$count); 
			$count++;
		}
	}
	
	$count_imgs = count($colls_db);	
	$max_img_left = $count_imgs - $num;
	
	$page_nums = buildPageNumbers($count_imgs, $xoopsModuleConfig['images_per_page'], $id, 'cat', $num);
	$xoopsTpl->assign('page_numbers', $page_nums);

	if ($xoopsModuleConfig['images_per_page'] < $max_img_left) {
		$max_thumbs = $num + $xoopsModuleConfig['images_per_page'];
	} else {
		$max_thumbs = $num + $max_img_left;
	}
	
	$count2 = 0;
	for($i = $num; $i < $max_thumbs; $i++) {
		$xoopsTpl->append('collections', array ('coll_id'=>$colls_db[$i]['coll_id'], 
												'coll_name'=>$colls_db[$i]['coll_name'], 
												'coll_thumb'=>$colls_db[$i]['coll_thumb'], 
												'coll_hits'=>$colls_db[$i]['coll_hits'],
												'coll_count'=>$count2));
    
		$count2++;
	}
	
	$sql = "SELECT cat_name, cat_link, cat_description, cat_banner FROM ".$xoopsDB->prefix('gallery_category')." WHERE cat_id='".$id."'";
	$result = $xoopsDB->query($sql);
	list($cat_name, $cat_link, $cat_description, $cat_banner) = $xoopsDB->fetchRow($result);
	if(($cat_banner != '' || $cat_banner != null) && ($xoopsModuleConfig['show_banners'] == 1)) {
		$sql2 = 'SELECT ban_image, ban_link FROM '.$xoopsDB->prefix('gallery_banners').' WHERE ban_id="'.$cat_banner.'" LIMIT 1';
		$result2 = $xoopsDB->query($sql2);
		list($ban_image, $ban_link) = $xoopsDB->fetchRow($result2);
		$banner = '<a href="'.$ban_link.'" target="_blank"><img src="'.XOOPS_URL.$xoopsModuleConfig['gallery_banner_location'].'/'.$ban_image.'" width="'.$xoopsModuleConfig['banner_width'].'px" /></a>';
	} else {
		$banner = '';
	}
	
	if($id == 0) {
		$cat_name = _MI_GALLERY_BNAMEALL;
	}
	
	$xoopsTpl->assign('banner', $banner);
	$xoopsTpl->assign('description', $cat_description);
	$newNavigation = createNavigation($cat_link, $cat_name);
	$xoopsTpl->assign('navigation', $newNavigation);
}

include(XOOPS_ROOT_PATH."/footer.php");
?>