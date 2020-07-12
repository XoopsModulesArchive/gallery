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

include(XOOPS_ROOT_PATH."/mainfile.php");
$blockDirname =  basename( dirname( dirname( __FILE__ ) ) );
include_once(XOOPS_ROOT_PATH."/modules/".$blockDirname."/include/functions.php");

function b_randomimage_gallery_show($options) {
	global $xoopsModuleConfig, $xoopsConfig, $xoopsOption, $xoopsDB, $xoopsModule;
	
	$blockDirname =  basename( dirname( dirname( __FILE__ ) ) );
	$sql = "SELECT side FROM ".$xoopsDB->prefix('newblocks')." WHERE show_func='b_randomimage_gallery_show'";
	$result = $xoopsDB->query($sql);
	list($galLocation) = $xoopsDB->fetchRow($result);
	
	$thumbwidth = getModuleOptionGal('thumbwidth');
	$thumbheight = getModuleOptionGal('thumbheight');	
	$galleryDir = getModuleOptionGal('gallery_location');
	$show_hits = getModuleOptionGal('show_hits');
	
	$modhandler = &xoops_gethandler('module');
	$xoopsModule = &$modhandler->getByDirname($blockDirname);
	
	$block = array();
	$blkrand = array();
	
	$blkrand['dirname'] = $blockDirname;
	$blkrand['showname'] = $options[1];
	$blkrand['showhits'] = $options[2];
	$block['randinfo'] = $blkrand;

	$count = 1;
	$indx_count = 0;
	$ulLink = array();
	$blocks = array();
	$cat_array = array();
	
	if($options[0] == 0) {
		$sql = "SELECT cat_id FROM " .$xoopsDB->prefix('gallery_category');
		$result = $xoopsDB->query($sql);
		
		if($xoopsDB->getRowsNum($result) != 0) {
			while(list($cat_id) = $xoopsDB->fetchRow($result)) {
				if (checkRandomImageBlockPermissions($cat_id, $xoopsModule)) {
					array_push($cat_array, $cat_id);
				}
			}
		}
		
		$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_link, coll_hits FROM " .$xoopsDB->prefix('gallery_collection')." ORDER BY coll_date";
		$result = $xoopsDB->query($sql);
		$rc_count = 0;

		if($xoopsDB->getRowsNum($result) != 0) {
			$coll_list = array();
			$myShowDir = "";
			while(list($coll_id, $coll_lid, $coll_name, $coll_thumb, $coll_link, $coll_hits) = $xoopsDB->fetchRow($result)) {
				if(in_array($coll_lid, $cat_array)) {
					$coll_list[$rc_count]['collid'] = $coll_id;
					$coll_list[$rc_count]['colllid'] = $coll_lid;
					$coll_list[$rc_count]['collname'] = $coll_name;
					$coll_list[$rc_count]['imagepath'] = XOOPS_ROOT_PATH.'/'.$galleryDir.'/'.$coll_link;
					$coll_list[$rc_count]['imageurl'] = XOOPS_URL.getModuleOptionGal('thumbnail_location').'/';
					$coll_list[$rc_count]['imageanchor'] = '<a href="'.XOOPS_URL."/modules/".$blockDirname.'/viewcoll.php?id='.$coll_id.'" class="linkopacity">';
					$coll_list[$rc_count]['imagename'] = $coll_name;
					$coll_list[$rc_count]['hits'] = _MB_GALLERY_SHOWHITS . " " . $coll_hits;

					$rc_count++;
				}
			}
			
			$rand_key = array_rand($coll_list, 1);
			$path = $coll_list[$rand_key]['imagepath'];
			
			if(($files = array_diff( scandir($path, 1), array('.', '..'))) !== false) {
				$image_list = array();
				foreach($files as $file) {
					$full_path = $path ."/".$file;
					if (exif_imagetype("{$full_path}") == IMAGETYPE_GIF) {
    					array_push($image_list, $file);
					} else if (exif_imagetype("{$full_path}") == IMAGETYPE_JPEG) {
    					array_push($image_list, $file);
					} else if (exif_imagetype("{$full_path}") == IMAGETYPE_PNG) {
    					array_push($image_list, $file);
					}
				}
				$rand_key_f = array_rand($image_list, 1);
				$thumbImage = "th_".strtolower(htmlentities($coll_list[$rand_key]['collname'], ENT_QUOTES))."_".strtolower(htmlentities($image_list[$rand_key_f], ENT_QUOTES));
				$coll_list[$rand_key]['imageurl'] .= $thumbImage;
				$coll_list[$rand_key]['imageanchor'] .= "<img src='".$coll_list[$rand_key]['imageurl']."' /></a>";
			}
			
			$block['randimg'] = $coll_list[$rand_key];
		}
	} else {
		$coll_lid = (int)$options[0];		
		$coll_list = array();
		if (checkRandomImageBlockPermissions($coll_lid, $xoopsModule)) {
			$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_link, coll_hits FROM " .$xoopsDB->prefix('gallery_collection')." WHERE coll_lid='{$coll_lid}'";
			$result = $xoopsDB->query($sql);
			$rc_count = 0;
			
			while(list($coll_id, $coll_lid, $coll_name, $coll_thumb, $coll_link, $coll_hits) = $xoopsDB->fetchRow($result)) {
				$coll_list[$rc_count]['collid'] = $coll_id;
				$coll_list[$rc_count]['colllid'] = $coll_lid;
				$coll_list[$rc_count]['collname'] = $coll_name;
				$coll_list[$rc_count]['imagepath'] = XOOPS_ROOT_PATH.'/'.$galleryDir.'/'.$coll_link;
				$coll_list[$rc_count]['imageurl'] = XOOPS_URL.getModuleOptionGal('thumbnail_location').'/';
				$coll_list[$rc_count]['imageanchor'] = '<a href="'.XOOPS_URL."/modules/".$blockDirname.'/viewcoll.php?id='.$coll_id.'" class="linkopacity">';
				$coll_list[$rc_count]['imagename'] = $coll_name;
				$coll_list[$rc_count]['hits'] = _MB_GALLERY_SHOWHITS . " " . $coll_hits;
				$rc_count++;
			}
			
			$rand_key = array_rand($coll_list, 1);
			$path = $coll_list[$rand_key]['imagepath'];
			
			if(($files = array_diff( scandir($path, 1), array('.', '..'))) !== false) {
				$image_list = array();
				foreach($files as $file) {
					$full_path = $path ."/".$file;
					if (exif_imagetype("{$full_path}") == IMAGETYPE_GIF) {
    					array_push($image_list, $file);
					} else if (exif_imagetype("{$full_path}") == IMAGETYPE_JPEG) {
    					array_push($image_list, $file);
					} else if (exif_imagetype("{$full_path}") == IMAGETYPE_PNG) {
    					array_push($image_list, $file);
					}
				}
				$rand_key_f = array_rand($image_list, 1);
				$thumbImage = "th_".strtolower(htmlentities($coll_list[$rand_key]['collname'], ENT_QUOTES))."_".strtolower(htmlentities($image_list[$rand_key_f], ENT_QUOTES));
				$coll_list[$rand_key]['imageurl'] .= $thumbImage;
				$coll_list[$rand_key]['imageanchor'] .= "<img src='".$coll_list[$rand_key]['imageurl']."' /></a>";
			}
		}
		
		
			
		
			
		$block['randimg'] = $coll_list[$rand_key];
		
	}
		 
   	return $block;
}
	
function gallery_randomimage_num_edit($options) {
	
	$options[0] = empty($options[0]) ? "0" : $options[0];
	$options[1] = empty($options[1]) ? "yes" : $options[1];
	$options[2] = empty($options[2]) ? "yes" : $options[2];
	$options[3] = empty( $options[3] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[3] ;
		
	$form = "";
	$form .= "<table>";
	$form .= "<tr><td>" . _MB_GALLERY_CATEGORY . "&nbsp;";
	$form .= "<input type='text' name='options[]' value='" . $options[0] . "' /></td></tr>";
	
	$form .= "<tr><td>" . _MB_GALLERY_SHOWRANDNAME . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	
		if ( $options[1] == "yes" ) {
        	$form .= "<option value='yes' selected='selected'>Yes</option>";
			$form .= "<option value='no'>No</option>";
    	} else {
			$form .= "<option value='no' selected='selected'>No</option>";
			$form .= "<option value='yes'>Yes</option>";
		}
    $form .= "</select></td></tr>";
    
    $form .= "<tr><td>" . _MB_GALLERY_SHOWRANDHITS . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	
		if ( $options[2] == "yes" ) {
        	$form .= "<option value='yes' selected='selected'>Yes</option>";
			$form .= "<option value='no'>No</option>";
    	} else {
			$form .= "<option value='no' selected='selected'>No</option>";
			$form .= "<option value='yes'>Yes</option>";
		}
    $form .= "</select></td></tr>";
    
	$form .= "<tr><td><input type='hidden' name='options[]' value='". $options[3] . "' /></td></tr>\n" ;
	$form .= "</table>";
		
	return $form;
}

function checkRandomImageBlockPermissions($perm_itemid, $xoopsModule) {
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
