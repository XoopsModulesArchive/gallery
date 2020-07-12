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
$blockDirname =  basename( dirname( dirname( __FILE__ ) ) );
include(XOOPS_ROOT_PATH."/mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$blockDirname."/include/functions.php");

function b_categories_gallery_show($options) {
	global $xoopsModuleConfig, $xoopsModule, $xoopsDB; 
	$blockDirname =  basename( dirname( dirname( __FILE__ ) ) );
	$modhandler = &xoops_gethandler('module');
	$xoopsModule = &$modhandler->getByDirname($blockDirname);
	$block = array();
	$gallery = array();
	
	
	if (is_object($xoopsModule) && $xoopsModule->getVar('dirname')) {
		$gallery['name'] = _MB_GALLERY_MAIN;
		$gallery['url'] = "/modules/".$xoopsModule->getVar('dirname')."/viewcat.php?id=0";
		$block['gallery'][] = $gallery;
		
		$sql = "SELECT cat_id, cat_name FROM ".$xoopsDB->prefix('gallery_category')." ORDER BY cat_name";
		$result = $xoopsDB->query($sql);
		if($xoopsDB->getRowsNum($result) != 0) {
			while(list($cat_id, $cat_name) = $xoopsDB->fetchRow($result)) {
				if (checkBlockPermissions($cat_id, $xoopsModule)) {
					$gallery['name'] = $cat_name;
					$gallery['url'] = "/modules/".$xoopsModule->getVar('dirname')."/viewcat.php?id=".$cat_id;
					$block['gallery'][] = $gallery;
				}
			}
		} 
	}

	return $block;	
}

function checkBlockPermissions($perm_itemid, $xoopsModule) {
	global $xoopsUser, $xoopsDB, $xoopsModuleConfig;
	
	// Specify the permission we are going to check for. 
	$perm_name = 'Gallery Main Category Permission';
	// The unique id of an item to check permissions for.
	
	// Get group ids that the current user belongs to.
	if ($xoopsUser) {
    	$groups = $xoopsUser->getGroups();
	} else {
    	$groups = XOOPS_GROUP_ANONYMOUS;

	}
	// Get the current module ID.
	$module_id = $xoopsModule->getVar('mid');

	// Get the group permission handler.
	$gperm_handler =& xoops_gethandler('groupperm');

	// Check if the current user has access to the category.
	if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id) ) {
		return true;
	} else {
		return false;
    }
}	
	
?>
