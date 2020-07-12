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

include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/class/template.php';
if(!@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/modinfo.php")){
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/modinfo.php");
}

if (!$xoopsModuleConfig['enable_rss'])
	redirect_header("index.php", 3, _NOPERM);

if (function_exists('mb_http_output'))
	mb_http_output('pass');

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

//$myts = & MyTextSanitizer :: getInstance(); // MyTextSanitizer object
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(3600);

if (!$tpl->is_cached('db:gallery_rss.html')) {

	$charset = 'utf-8';
	//$myts =& MyTextSanitizer::getInstance();
	$sitename = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES);
	$email = checkEmail($xoopsConfig['adminmail'],false);
	$slogan = htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES);
	$module = $xoopsModule->getVar('name');
	$channel_link = XOOPS_URL.'/';
	$channel_desc = xoops_utf8_encode($slogan);
	$channel_lastbuild = formatTimestamp(time(), 'rss');
	$channel_webmaster = xoops_utf8_encode($email);
	$channel_editor = xoops_utf8_encode($email);
	$channel_category = xoops_utf8_encode($xoopsModuleConfig['channel_category']);
	$channel_generator = xoops_utf8_encode(htmlspecialchars($module, ENT_QUOTES));
	$channel_language = _LANGCODE;
	$image_url = XOOPS_URL.'/images/logo.gif';
	$dimention = ( ini_get('allow_url_fopen') ) ? getimagesize($image_url) : getimagesize(XOOPS_ROOT_PATH.'/images/logo.gif');

	if (empty($dimention[0])) {
		$width = 88;
	} else {
		$width = ($dimention[0] > 144) ? 144 : $dimention[0];
	}
	
	if (empty($dimention[1])) {
		$height = 31;
	} else {
		$height = ($dimention[1] > 400) ? 400 : $dimention[1];
	}
	
	if($id == 0) {
		$cat_name = _MI_GALLERY_NAME;
	} else {
		$sql = 'SELECT cat_name FROM '.$xoopsDB->prefix('gallery_category').' WHERE cat_id='.$id.' LIMIT 1';
		$result = $xoopsDB->query($sql);
		if($xoopsDB->getRowsNum($result) == 0) {
			$cat_name = _MI_GALLERY_NAME;
		} else {
			list($cat_name) = $xoopsDB->fetchRow($result);
			$cat_name = _MI_GALLERY_NAME . ' - ' . $cat_name;
		}
		
	}
	
	$title = $sitename.' - '.$cat_name;
	$channel_title = xoops_utf8_encode(htmlspecialchars($title, ENT_QUOTES));

	// Channel
	$tpl->assign('channel_title', $channel_title);
	$tpl->assign('channel_link', $channel_link);
	$tpl->assign('channel_desc', $channel_desc);
	$tpl->assign('channel_lastbuild', $channel_lastbuild);
	$tpl->assign('channel_category', $channel_category);
	$tpl->assign('channel_editor', $channel_editor, true);
	$tpl->assign('channel_docs', $xoopsModuleConfig['channel_docs']);
	$tpl->assign('channel_webmaster', $channel_webmaster, true);
	$tpl->assign('channel_language', $channel_language);

	// Image
	$tpl->assign('image_url', $image_url);
	$tpl->assign('image_width', $width);
	$tpl->assign('image_height', $height);

	// Item
	$item = array();
	if($id == 0) {
		$sql = "SELECT coll_id, coll_name, coll_thumb, coll_description, coll_date FROM " .$xoopsDB->prefix('gallery_collection')." ORDER BY coll_date DESC";
	} else {
		$sql = "SELECT coll_id, coll_name, coll_thumb, coll_description, coll_date FROM " .$xoopsDB->prefix('gallery_collection')." WHERE coll_lid=".$id." ORDER BY coll_date DESC";
	}

	$result = $xoopsDB->query($sql, $xoopsModuleConfig['newlinksrss'], 0);

	while(list($coll_id, $coll_name, $coll_thumb, $coll_description, $coll_date) = $xoopsDB->fetchRow($result)) {

		$title = $coll_name;

		$title = htmlspecialchars($title, ENT_QUOTES);
		$title = xoops_utf8_encode($title);
		$item['title'] = $title;
		$thumb = XOOPS_URL . $xoopsModuleConfig['thumbnail_location'].'/'.$coll_thumb;
		$img = '<img src="'.$thumb.'" width="'.$xoopsModuleConfig['thumbwidth'] .'" /><br />';

		$description = $coll_description;

		$description = xoops_utf8_encode($description);
		$item['description'] = "<![CDATA[". $img . $description ."]]>";
		$link = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/viewcoll.php?id='.$coll_id;
		$item['link'] = $link;
		
		$item['guid'] = $link;
		
		$pubdate = formatTimestamp($coll_date, 'rss');
		$item['pubdate'] = $pubdate;
	
		$tpl->append('items', $item);
	}
}

$tpl->display('db:gallery_rss.html');
?>
