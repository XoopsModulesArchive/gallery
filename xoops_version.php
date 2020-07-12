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

global $xoopsDB, $xoopsUser, $xoopsModuleConfig, $xoopsModule;
require_once("include/functions.php");
$mydirname = basename( dirname( __FILE__ ) ) ;
// Main Info
$modversion['name'] = _MI_GALLERY_NAME;
$modversion['version'] = 2.1;
$modversion['description'] = _MI_GALLERY_DESC;
$modversion['credits'] = "Optikool<br>(http://www.optikool.com)";
$modversion['author'] = "Dana Harris";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = "gallery";
$modversion['status_version'] = "2.1";
$modversion['author_website_name'] = "Optikool";
$modversion['author_website_url'] = "http://www.optikool.com";
$modversion['author_email'] = "optikool@yahoo.com";
$modversion['credits'] = "Gallery developed by Dana Harris (optikool).";

// onInstall, onUninstall and onUpdate
$modversion['onInstall'] = 'install_funcs.php';
$modversion['onUninstall'] = 'install_funcs.php';
$modversion['onUpdate'] = 'install_funcs.php';

// SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['onUpdate'] = 'sql/on_update_inc.php';

// SQL Tables
$modversion['tables'][0] = "gallery_collection";
$modversion['tables'][1] = "gallery_category";
$modversion['tables'][2] = "gallery_banners";

// Admin 
// Display in the admin nav bar
$modversion['hasAdmin'] = 1;
// Admin index
$modversion['adminindex'] = "admin/index.php";
// Popup menu for admin menu icon
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Menu Sub
if($xoopsModuleConfig['show_submenu']) {
	if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
		$sql = "SELECT cat_id, cat_name FROM ".$xoopsDB->prefix('gallery_category')." ORDER BY cat_name";
		$result = $xoopsDB->query($sql);
		
		if($xoopsDB->getRowsNum($result) != 0) {
			$xpv_count = 0;
			
			if($xoopsModuleConfig['show_all']) {
				$modversion['sub'][$xpv_count]['name'] = _MI_GALLERY_BNAMEALL;
				$modversion['sub'][$xpv_count]['url'] = "viewcat.php?id=0";
				$xpv_count++;
			}
		
			while(list($cat_id, $cat_name) = $xoopsDB->fetchRow($result)) {
				if (checkPermissions($cat_id)) {
					$modversion['sub'][$xpv_count]['name'] = $cat_name;
					$modversion['sub'][$xpv_count]['url'] = "viewcat.php?id=".$cat_id;
					$xpv_count++;
				}
			}
		}
	}
}

// Template Files
$t = 1;
$modversion['templates'][$t]['file'] = 'gallery_index.html';
$modversion['templates'][$t]['description'] = '';
$t++;
$modversion['templates'][$t]['file'] = 'gallery_viewcat.html';
$modversion['templates'][$t]['description'] = '';
$t++;
$modversion['templates'][$t]['file'] = 'gallery_viewcoll.html';
$modversion['templates'][$t]['description'] = '';
$t++;
$modversion['templates'][$t]['file'] = 'gallery_rss.html';
$modversion['templates'][$t]['description'] = '';

// Blocks
$b = 1;
$modversion['blocks'][$b]['file'] = "gallery_block_categories.php";
$modversion['blocks'][$b]['name'] = _MI_GALLERY_BNAME1;
$modversion['blocks'][$b]['description'] = _MI_GALLERY_CATEGORIES;
$modversion['blocks'][$b]['show_func'] = "b_categories_gallery_show";
$modversion['blocks'][$b]['template'] = "gallery_block_categories.html";
//$modversion['blocks'][$b]['edit_func'] = "gallery_categories_num_edit";
//$modversion['blocks'][$b]['options'] = $galCatOptions;

$b++;
$modversion['blocks'][$b]['file'] = "gallery_block_recent.php";
$modversion['blocks'][$b]['name'] = _MI_GALLERY_BNAME2;
$modversion['blocks'][$b]['description'] = _MI_GALLERY_RIMAGES;
$modversion['blocks'][$b]['show_func'] = "b_recent_gallery_show";
$modversion['blocks'][$b]['template'] = "gallery_block_recent.html";
$modversion['blocks'][$b]['edit_func'] = "gallery_recent_num_edit";
$modversion['blocks'][$b]['options'] = "yes|yes|fade|slow|8000|sequence|150|5|4|{$mydirname}";

$b++;
$modversion['blocks'][$b]['file'] = "gallery_block_mostviewed.php";
$modversion['blocks'][$b]['name'] = _MI_GALLERY_BNAME3;
$modversion['blocks'][$b]['description'] = _MI_GALLERY_MOSTVIEWED;
$modversion['blocks'][$b]['show_func'] = "b_mostviewed_gallery_show";
$modversion['blocks'][$b]['template'] = "gallery_block_mostviewed.html";
$modversion['blocks'][$b]['edit_func'] = "gallery_mostviewed_num_edit";
$modversion['blocks'][$b]['options'] = "yes|yes|fade|slow|8000|sequence|150|5|{$mydirname}";

$b++;
$modversion['blocks'][$b]['file'] = "gallery_block_randomimage.php";
$modversion['blocks'][$b]['name'] = _MI_GALLERY_BNAME4;
$modversion['blocks'][$b]['description'] = _MI_GALLERY_RANDOMIMAGE;
$modversion['blocks'][$b]['show_func'] = "b_randomimage_gallery_show";
$modversion['blocks'][$b]['template'] = "gallery_block_randomimage.html";
$modversion['blocks'][$b]['edit_func'] = "gallery_randomimage_num_edit";
$modversion['blocks'][$b]['options'] = "0|yes|yes|{$mydirname}";
 



// Configuration items

// name of config option for accessing its specified value. i.e. $xoopsModuleConfig['storyhome']

// title of this config option displayed in config settings form

// description of this config option displayed under title

// form element type used in config form for this option. can be one of either textbox, textarea, select, select_multi, yesno, group, group_multi

// value type of this config option. can be one of either int, text, float, array, or other
// form type of 'group_multi', 'select_multi' must always be 'array'
// form type of 'yesno', 'group' must be always be 'int'

// the default value for this option
// ignore it if no default
// 'yesno' formtype must be either 0(no) or 1(yes)
//$modversion['config'][1]['default'] = 100;
// options to be displayed in selection box
// required and valid for 'select' or 'select_multi' formtype option only
// language constants can be used for both array keys and values
//$modversion['config'][1]['options'] = array('5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000);


$c = 1;
$modversion['config'][$c]['name'] = 'gallery_location';
$modversion['config'][$c]['title'] = '_MI_GALLERY_GAL_ADD';
$modversion['config'][$c]['description'] = '_MI_GALLERY_GAL_ADD_DESC';
$modversion['config'][$c]['formtype'] = 'texbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = 'gal';

$c++;
$modversion['config'][$c]['name'] = 'thumbnail_location';
$modversion['config'][$c]['title'] = '_MI_GALLERY_THUMB_ADD';
$modversion['config'][$c]['description'] = '_MI_GALLERY_THUMB_ADD_DESC';
$modversion['config'][$c]['formtype'] = 'texbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = '/uploads/gallery/cache';

$c++;
$modversion['config'][$c]['name'] = 'gallery_banner_location';
$modversion['config'][$c]['title'] = '_MI_GALLERY_BAN_THUMB';
$modversion['config'][$c]['description'] = '_MI_GALLERY_BAN_THUMB_DESC';
$modversion['config'][$c]['formtype'] = 'texbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = '/uploads/gallery/banners';

$c++;
$modversion['config'][$c]['name'] = 'gallery_breadcrumb';
$modversion['config'][$c]['title'] = '_MI_GALLERY_BREADCRUMB';
$modversion['config'][$c]['description'] = '_MI_GALLERY_BREADCRUMB_DESC';
$modversion['config'][$c]['formtype'] = 'texbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = '&raquo;';

/*
$c++;
$modversion['config'][$c]['name'] = 'gen_filter';
$modversion['config'][$c]['title'] = '_MI_GALLERY_GENFILTER';
$modversion['config'][$c]['description'] = '_MI_GALLERY_GENFILTER_DESC';
$modversion['config'][$c]['formtype'] = 'texbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = '.|..|thumbs.db';
*/

$c++;
$modversion['config'][$c]['name'] = 'images_per_page';
$modversion['config'][$c]['title'] = '_MI_GALLERY_IMG_PER_PAGE';
$modversion['config'][$c]['description'] = '_MI_GALLERY_IMG_PER_PAGE_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 20;

$c++;
$modversion['config'][$c]['name'] = 'thumbwidth';
$modversion['config'][$c]['title'] = '_MI_GALLERY_THUMBWTH';
$modversion['config'][$c]['description'] = '_MI_GALLERY_THUMBWTH_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 100;

$c++;
$modversion['config'][$c]['name'] = 'thumbheight';
$modversion['config'][$c]['title'] = '_MI_GALLERY_THUMBHI';
$modversion['config'][$c]['description'] = '_MI_GALLERY_THUMBHI_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 100;

$c++;
$modversion['config'][$c]['name'] = 'thumb_effect';
$modversion['config'][$c]['title'] = '_MI_GALLERY_EFFECT';
$modversion['config'][$c]['description'] = '_MI_GALLERY_EFFECT_DESC';
$modversion['config'][$c]['formtype'] = 'select';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['options'] = array('_MI_GALLERY_EFFECT_SB' => 'shadowbox', '_MI_GALLERY_EFFECT_LB' => 'lightbox', '_MI_GALLERY_EFFECT_WB' => 'wbox', '_MI_GALLERY_EFFECT_WIN' => 'lightwindow', '_MI_GALLERY_EFFECT_FACE' => 'facebox', '_MI_GALLERY_EFFECT_FANCY' => 'fancybox', '_MI_GALLERY_EFFECT_PRETTY' => 'prettyPhoto');
$modversion['config'][$c]['default'] = 'shadowbox';

$c++;
$modversion['config'][$c]['name'] = 'show_submenu';
$modversion['config'][$c]['title'] = '_MI_GALLERY_SHOWSUBMENU';
$modversion['config'][$c]['description'] = '_MI_GALLERY_SHOWSUBMENU_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'show_latest_main';
$modversion['config'][$c]['title'] = '_MI_GALLERY_LATEST';
$modversion['config'][$c]['description'] = '_MI_GALLERY_LATEST_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'show_all';
$modversion['config'][$c]['title'] = '_MI_GALLERY_SHOWALL';
$modversion['config'][$c]['description'] = '_MI_GALLERY_SHOWALL_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'show_date_added';
$modversion['config'][$c]['title'] = '_MI_GALLERY_DATEADDED';
$modversion['config'][$c]['description'] = '_MI_GALLERY_DATEADDED_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'show_banners';
$modversion['config'][$c]['title'] = '_MI_GALLERY_SHOWBANNERS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_SHOWBANNERS_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'use_cat_banners';
$modversion['config'][$c]['title'] = '_MI_GALLERY_CATBANNERS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_CATBANNERS_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'banner_width';
$modversion['config'][$c]['title'] = '_MI_GALLERY_BANNERWIDTH';
$modversion['config'][$c]['description'] = '_MI_GALLERY_BANNERWIDTH_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 200;

$c++;
$modversion['config'][$c]['name'] = 'load_jquery';
$modversion['config'][$c]['title'] = '_MI_GALLERY_LOADJQUERY';
$modversion['config'][$c]['description'] = '_MI_GALLERY_LOADJQUERY_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'recentTotal';
$modversion['config'][$c]['title'] = '_MI_GALLERY_RECTOTAL';
$modversion['config'][$c]['description'] = '_MI_GALLERY_RECTOTAL_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 4;

$c++;
$modversion['config'][$c]['name'] = 'f_cols';
$modversion['config'][$c]['title'] = '_MI_GALLERY_F_COLS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_F_COLS_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 4;

$c++;
$modversion['config'][$c]['name'] = 'thumbnail_cols';
$modversion['config'][$c]['title'] = '_MI_GALLERY_THUMB_COLS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_THUMB_COLS_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 5;

$c++;
$modversion['config'][$c]['name'] = 'show_hits';
$modversion['config'][$c]['title'] = '_MI_GALLERY_SHOWHITS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_SHOWHITS_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 1;

$c++;
$modversion['config'][$c]['name'] = 'enable_rss';
$modversion['config'][$c]['title'] = '_MI_GALLERY_RSSENABLE';
$modversion['config'][$c]['description'] = '_MI_GALLERY_RSSENABLEDSC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 0;
$modversion['config'][$c]['options'] = array();

$c++;
$modversion['config'][$c]['name'] = 'newlinksrss';
$modversion['config'][$c]['title'] = '_MI_GALLERY_RSSLINKS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_RSSLINKSDSC';
$modversion['config'][$c]['formtype'] = 'select';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 5;
$modversion['config'][$c]['options'] = array('5' => 5, '10' => 10, '15' => 15);

$c++;
$modversion['config'][$c]['name'] = 'channel_category';
$modversion['config'][$c]['title'] = '_MI_GALLERY_CHANNELCAT';
$modversion['config'][$c]['description'] = '_MI_GALLERY_CHANNELCATDSC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = 'Gallery';
$modversion['config'][$c]['options'] = array();

$c++;
$modversion['config'][$c]['name'] = 'channel_docs';
$modversion['config'][$c]['title'] = '_MI_GALLERY_CHANNELDOCS';
$modversion['config'][$c]['description'] = '_MI_GALLERY_CHANNELDOCSDSC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = 'http://backend.userland.com/rss/';
$modversion['config'][$c]['options'] = array();

$c++;
$modversion['config'][$c]['name'] = 'enable_error_reporting';
$modversion['config'][$c]['title'] = '_MI_GALLERY_ENABLEERRREP';
$modversion['config'][$c]['description'] = '_MI_GALLERY_ENABLEERRREPDSC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 0;
$modversion['config'][$c]['options'] = array();

/*
$c++;
$modversion['config'][$c]['name'] = 'show_watermark';
$modversion['config'][$c]['title'] = '_MI_GALLERY_WATERMARK';
$modversion['config'][$c]['description'] = '_MI_GALLERY_WATERMARK_DESC';
$modversion['config'][$c]['formtype'] = 'yesno';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['default'] = 0;

$c++;
$modversion['config'][$c]['name'] = 'text_watermark';
$modversion['config'][$c]['title'] = '_MI_GALLERY_TEXTWATERMARK';
$modversion['config'][$c]['description'] = '_MI_GALLERY_TEXTWATERMARK_DESC';
$modversion['config'][$c]['formtype'] = 'textbox';
$modversion['config'][$c]['valuetype'] = 'text';
$modversion['config'][$c]['default'] = 'My Website.com';

$c++;
$modversion['config'][$c]['name'] = 'watermark_size';
$modversion['config'][$c]['title'] = '_MI_GALLERY_WATERMARKSIZE';
$modversion['config'][$c]['description'] = '_MI_GALLERY_WATERMARKSIZE_DESC';
$modversion['config'][$c]['formtype'] = 'select';
$modversion['config'][$c]['valuetype'] = 'int';
$modversion['config'][$c]['options'] = array('_MI_GALLERY_WATERMARKSIZE1' => 1, '_MI_GALLERY_WATERMARKSIZE2' => 2, '_MI_GALLERY_WATERMARKSIZE3' => 3, '_MI_GALLERY_WATERMARKSIZE4' => 4, '_MI_GALLERY_WATERMARKSIZE5' => 5);
$modversion['config'][$c]['default'] = 3;
*/
?>