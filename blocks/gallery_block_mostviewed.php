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

function b_mostviewed_gallery_show($options) {
	global $xoopsModuleConfig, $xoopsConfig, $xoopsOption, $xoopsDB, $xoopsModule;
	$block = array();
	$blkAnime = array();
	$blockDirname =  basename( dirname( dirname( __FILE__ ) ) );
	$thumbwidth = getModuleOptionGal('thumbwidth');
	$thumbheight = getModuleOptionGal('thumbheight');	
	$galleryDir = getModuleOptionGal('gallery_location');
	$show_hits = getModuleOptionGal('show_hits');
	$load_jq = getModuleOptionGal('load_jquery');
	
	$modhandler = &xoops_gethandler('module');
	$xoopsModule = &$modhandler->getByDirname($blockDirname);
	
	$blkAnime['enableffect'] = $options[0];
	$blkAnime['loadfader'] = $options[1];
	$blkAnime['animetype'] = $options[2];
	$blkAnime['speed'] = $options[3];
	$blkAnime['timeout'] = $options[4];
	$blkAnime['type'] = $options[5];
	$blkAnime['height'] = $options[6];
	$blkAnime['dirname'] = $blockDirname;
	$block['mvanime'][] = $blkAnime;
	
	$sql = "SELECT cat_id FROM " .$xoopsDB->prefix('gallery_category');
	$result = $xoopsDB->query($sql);
	$cat_array = array();
	$indx_count = 0;
	if($xoopsDB->getRowsNum($result) != 0) {
		array_push($cat_array, 0);
		while(list($cat_id) = $xoopsDB->fetchRow($result)) {
			if (checkMostViewedBlockPermissions($cat_id, $xoopsModule)) {
				array_push($cat_array, $cat_id);
			}
		}
	}

	$sql = "SELECT coll_id, coll_lid, coll_name, coll_thumb, coll_hits FROM " .$xoopsDB->prefix('gallery_collection')." ORDER BY coll_hits DESC LIMIT ".$options[7];
	$result = $xoopsDB->query($sql);
	
	$count = 0;
	
	if($xoopsDB->getRowsNum($result) != 0) {
	
		while(list($coll_id, $coll_lid, $coll_name, $coll_thumb, $coll_hits) = $xoopsDB->fetchRow($result)) {

			if(in_array($coll_lid, $cat_array) && $count < $options[7]) {
				$myShowDir = "";
				$myShowDir .= "<div>";
				
				$imagePath = "";
				$imagePath = XOOPS_URL.getModuleOptionGal('thumbnail_location').'/'.$coll_thumb;
				$myShowDir .=  '<a href="'.XOOPS_URL."/modules/".$blockDirname.'/viewcoll.php?id='.$coll_id.'" class="linkopacity"><img src="'.$imagePath.'"><br /> '.$coll_name.' </a><div class="rightBlockHits">'._MB_GALLERY_SHOWHITS.' '.$coll_hits.'</div>';
		
				$myShowDir .= "</div>";

				$mvLink['mvlink'] = $myShowDir;		
				$block['mvImg'][] = $mvLink;
    
				$count++;
			}
		}
	}
	
	return $block;
}

function gallery_mostviewed_num_edit($options) {
	$options[0] = empty($options[0]) ? "yes" : $options[0];
	$options[1] = empty($options[1]) ? "yes" : $options[1];
	$options[2] = empty($options[2]) ? "fade" : $options[2];
	$options[3] = empty($options[3]) ? "slow" : $options[3];
	$options[4] = empty($options[4]) ? 8000 : $options[4];
	$options[5] = empty($options[5]) ? "sequence" : $options[5];
	$options[6] = empty($options[6]) ? 150 : $options[6];
    $options[7] = empty($options[7]) ? 5 : $options[7];
	$options[8] = empty( $options[8] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[8] ;
		
	$form = "";
	$form .= "<table>";
	$form .= "<tr><td>" . _MB_GALLERY_ENABLEEFFECT . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	
		if ( $options[0] == "yes" ) {
        	$form .= "<option value='yes' selected='selected'>Yes</option>";
			$form .= "<option value='no'>No</option>";
    	} else {
			$form .= "<option value='no' selected='selected'>No</option>";
			$form .= "<option value='yes'>Yes</option>";
		}
    $form .= "</select></td></tr>";

	$form .= "<tr><td>" . _MB_GALLERY_DISPINFADEJS . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	
		if ( $options[1] == "yes" ) {
        	$form .= "<option value='yes' selected='selected'>Yes</option>";
			$form .= "<option value='no'>No</option>";
    	} else {
			$form .= "<option value='no' selected='selected'>No</option>";
			$form .= "<option value='yes'>Yes</option>";
		}
    $form .= "</select></td></tr>";
	
	$form .= "<tr><td>" . _MB_GALLERY_ANIMATETYPE . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	if ( $options[2] == "fade" ) {
        	$form .= "<option value='fade' selected='selected'>Fade</option>";
			$form .= "<option value='slide'>Slide</option>";
    	} else {
			$form .= "<option value='fade'>Fade</option>";
			$form .= "<option value='slide' selected='selected'>Slide</option>";
		}
    $form .= "</select></td></tr>";
	
	$form .= "<tr><td>" . _MB_GALLERY_EFFECTSPEED . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	if ( $options[3] == "slow" ) {
        	$form .= "<option value='slow' selected='selected'>Slow</option>";
			$form .= "<option value='normal'>Normal</option>";
			$form .= "<option value='fast'>Fast</option>";
    	} elseif  ( $options[3] == "normal" ) {
			$form .= "<option value='slow'>Slow</option>";
			$form .= "<option value='normal' selected='selected'>Normal</option>";
			$form .= "<option value='fast'>Fast</option>";
		} else {
			$form .= "<option value='slow'>Slow</option>";
			$form .= "<option value='normal'>Normal</option>";
			$form .= "<option value='fast' selected='selected'>Fast</option>";
		}
    $form .= "</select></td></tr>";

	$form .= "<tr><td>" . _MB_GALLERY_EFFECTTIMOUT . "&nbsp;";
	$form .= "<input type='text' name='options[]' value='" . $options[4] . "' /></td></tr>";

	$form .= "<tr><td>" . _MB_GALLERY_EFFECTTYPE . "&nbsp;";
	$form .= "<select id='options[]' name='options[]'>";
    	if ( $options[5] == "sequence" ) {
        	$form .= "<option value='sequence' selected='selected'>Sequence</option>";
			$form .= "<option value='random'>Normal</option>";
			$form .= "<option value='random_start'>Random Start</option>";
    	} elseif  ( $options[5] == "random" ) {
			$form .= "<option value='sequence'>Sequence</option>";
			$form .= "<option value='random' selected='selected'>Random</option>";
			$form .= "<option value='random_start'>Random Start</option>";
		} else {
			$form .= "<option value='sequence'>Sequence</option>";
			$form .= "<option value='random'>Random</option>";
			$form .= "<option value='random_start' selected='selected'>Random Start</option>";
		}
    $form .= "</select></td></tr>";

	$form .= "<tr><td>" . _MB_GALLERY_EFFECTHEIGHT . "&nbsp;";
	$form .= "<input type='text' name='options[]' value='" . $options[6] . "' /></td></tr>";

        $form .= "<tr><td>" . _MB_GALLERY_NUMIMGSHOW . "&nbsp;";
	$form .= "<input type='text' name='options[]' value='" . $options[7] . "' /></td></tr>";

	$form .= "<tr><td><input type='hidden' name='options[]' value='". $options[8] . "' /></td></tr>\n" ;
	$form .= "</table>";
		
	return $form;
}

function checkMostViewedBlockPermissions($perm_itemid, $xoopsModule) {
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