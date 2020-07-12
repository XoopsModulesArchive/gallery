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
$xoopsOption['template_main'] = "gallery_viewcoll.html";
include XOOPS_ROOT_PATH."/header.php";

if($xoopsModuleConfig['enable_error_reporting'] == 1) {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

$xoopsTpl->assign('lb_box', $xoopsModuleConfig['thumb_effect']);
$xoopsTpl->assign('main_title', _MD_GALLERY_MAINTITLE);
$xoopsTpl->assign('load_jquery', $xoopsModuleConfig['load_jquery']);
$xoopsTpl->assign('latest_col', _MI_GALLERY_LATESTTXT);
$xoopsTpl->assign('f_cols', $xoopsModuleConfig['thumbnail_cols']);
$xoopsTpl->assign('show_hits', $xoopsModuleConfig['show_hits']);
$xoopsTpl->assign('lang_hits', _MD_GALLERY_SHOWHITS);

$id = (int)$_REQUEST['id'];
$num = isset($_REQUEST['num']) ? (int)$_REQUEST['num'] : 0;

$sql = "SELECT coll_lid, coll_name, coll_link, coll_hits, coll_banner, coll_description FROM " .$xoopsDB->prefix('gallery_collection')." WHERE coll_id='".$id."' LIMIT 1";
$result = $xoopsDB->query($sql);

if($xoopsDB->getRowsNum($result) == 0) {
	redirect_header("index.php", 2, _MI_GALLERY_COLLNOTFOUND);
}

list($coll_lid, $coll_name, $coll_link, $coll_hits, $coll_banner, $coll_desc) = $xoopsDB->fetchRow($result);
$xoopsTpl->assign('description', $coll_desc);

if (!checkPermissions($coll_lid)) {
	redirect_header("index.php", 2, _MD_UNATHORIZED);
}

$newNavigation = createNavigation($coll_link, $coll_name);
$xoopsTpl->assign('navigation', $newNavigation);

$path = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['gallery_location'].'/'.$coll_link;
$fileList = array();
if(($files = array_diff( scandir($path, 1), Array(".", ".."))) !== false) {
	foreach($files as $file) {
		if(eregi(".*(\.jpg|\.gif|\.png|\.jpeg)", $file)) {
			array_push($fileList, $file);		
		}		
	}
} else {
	redirect_header("index.php", 2, _MI_GALLERY_COLLEMPTY);
}

if ($num == 0) {
	$coll_hits++;
	$sqlInsert = "UPDATE ".$xoopsDB->prefix('gallery_collection')." SET coll_hits='".$coll_hits."' WHERE coll_id='".$id."' LIMIT 1";
	$result2 = $xoopsDB->queryF($sqlInsert);	
}
sort($fileList);
$count_imgs = count($fileList);
$count = 0;

$page_nums = buildPageNumbers($count_imgs, $xoopsModuleConfig['images_per_page'], $id, 'coll', $num);
$xoopsTpl->assign('page_numbers', $page_nums);

$max_img_left = $count_imgs - $num;
if ($xoopsModuleConfig['images_per_page'] < $max_img_left) {
	$max_thumbs = $num + $xoopsModuleConfig['images_per_page'];
} else {
	$max_thumbs = $num + $max_img_left;
}

for($i = $num; $i < $max_thumbs; $i++) {
	$thumbImage = XOOPS_URL.$xoopsModuleConfig['thumbnail_location'].'/'."th_".strtolower(htmlentities($coll_name, ENT_QUOTES))."_".strtolower(htmlentities($fileList[$i], ENT_QUOTES));
	$thumbImage = "<img src='".$thumbImage."' />";
	if($xoopsModuleConfig['thumb_effect'] == 'lightwindow') {
		$linkImage = "<a href='".XOOPS_URL.'/'.$xoopsModuleConfig['gallery_location'].'/'.htmlentities($coll_link, ENT_QUOTES).'/'.htmlentities($fileList[$i], ENT_QUOTES)."' class='linkopacity lightwindow' rel='".$xoopsModuleConfig['thumb_effect']."[".htmlentities($coll_name, ENT_QUOTES)."]' title='".htmlentities($coll_name, ENT_QUOTES)."'>".$thumbImage."</a>";
	} else if ($xoopsModuleConfig['thumb_effect'] == 'fancybox') {
		$linkImage = "<a href='".XOOPS_URL.'/'.$xoopsModuleConfig['gallery_location'].'/'.htmlentities($coll_link, ENT_QUOTES).'/'.htmlentities($fileList[$i], ENT_QUOTES)."' class='linkopacity fancyb' rel='".$xoopsModuleConfig['thumb_effect']."' title='".htmlentities($coll_name, ENT_QUOTES)."'>".$thumbImage."</a>";
	} else {
		$linkImage = "<a href='".XOOPS_URL.'/'.$xoopsModuleConfig['gallery_location'].'/'.htmlentities($coll_link, ENT_QUOTES).'/'.htmlentities($fileList[$i], ENT_QUOTES)."' class='linkopacity' rel='".$xoopsModuleConfig['thumb_effect']."[".$xoopsModuleConfig['thumb_effect']."]' title='".htmlentities($coll_name, ENT_QUOTES)."'>".$thumbImage."</a>";
	}
	
	$xoopsTpl->append('collections', array ('coll_link'=>$linkImage, 'coll_count'=>$count));
    $count++;
}

$banner = '';
if($xoopsModuleConfig['show_banners'] == 1) {
	if(($coll_banner != '' || $coll_banner != null)) {
		$sql2 = 'SELECT ban_image, ban_link FROM '.$xoopsDB->prefix('gallery_banners').' WHERE ban_id="'.$coll_banner.'" LIMIT 1';
		$result2 = $xoopsDB->query($sql2);
		list($ban_image, $ban_link) = $xoopsDB->fetchRow($result2);
		$banner = '<a href="'.$ban_link.'" target="_blank"><img src="'.XOOPS_URL.$xoopsModuleConfig['gallery_banner_location'].'/'.$ban_image.'" width="'.$xoopsModuleConfig['banner_width'].'px" /></a>';
	} else if ($xoopsModuleConfig['use_cat_banners'] == 1){
		$sql3 = 'SELECT cat_banner FROM '.$xoopsDB->prefix('gallery_category').' WHERE cat_id="'.$coll_lid.'" LIMIT 1';
		$result3 = $xoopsDB->query($sql3);
		if($xoopsDB->getRowsNum($result3) == 0) {
			$banner = '';
		} else {
			list($b_id) = $xoopsDB->fetchRow($result3);
			$sql2 = 'SELECT ban_image, ban_link FROM '.$xoopsDB->prefix('gallery_banners').' WHERE ban_id="'.$b_id.'" LIMIT 1';
			$result2 = $xoopsDB->query($sql2);
			list($ban_image, $ban_link) = $xoopsDB->fetchRow($result2);
			$banner = '<a href="'.$ban_link.'" target="_blank"><img src="'.XOOPS_URL.$xoopsModuleConfig['gallery_banner_location'].'/'.$ban_image.'" width="'.$xoopsModuleConfig['banner_width'].'px" /></a>';
		}		
	} else {
		$banner = '';
	}
}
$xoopsTpl->assign('banner', $banner);
include(XOOPS_ROOT_PATH."/footer.php");
?>