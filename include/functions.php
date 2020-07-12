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

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

// Globals - Do not tamper with these
global $gallery_root, $gallery_address, $file, $excluded_folders, $thumbwidth, $thumbheight;
global $gallery_width, $images_per_page, $thumbnail_cols, $xoopsModuleConfig, $xoopsDB, $gallery_address;

// Admin functions start here

/*
 * Gather a listing of all directories that do not contain images
 */
function showCategories() {
    global $xoopsModule, $xoopsModuleConfig, $xoopsDB, $thumbDisplay;
	
	// Path to gallery location
	$galleryPath = XOOPS_ROOT_PATH."/".$xoopsModuleConfig['gallery_location'];
	// Iterator to traverse the subdirectories in the gallery
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($galleryPath), RecursiveIteratorIterator::SELF_FIRST);
	$collections = array();
	$class = "even";
	// Iterate through the directory paths
	foreach($iterator as $path) {
		if($path->isDir()) {			
        	if(($files = array_diff( scandir($path, 1), Array(".", ".."))) !== false) {
            	$check = checkImageType($path->getPathname(), $files);
				
				if($check) {					
			
					list($rootPath, $folderPath) = split('/'.$xoopsModuleConfig['gallery_location'].'/', $path->getPathname());
					$sql = 'SELECT cat_id, cat_name FROM '.$xoopsDB->prefix('gallery_category').' WHERE `cat_link` = "'.mysql_escape_string($folderPath).'" LIMIT 1';
					$result = $xoopsDB->query($sql);
					echo '<tr class="'.$class.'">'."\n";    				
					if($xoopsDB->getRowsNum($result) == 0) {
						echo '<td style="text-align:left; width:35px;">&nbsp;</td>'."\n";
						echo '<td style="text-align:left;"><span style="color:red;">New</span>: '.$folderPath.'</td>';
						echo '<td style="text-align:right;"><a href="index.php?op=addcategory&path='.$folderPath.'">'._AM_ADDCAT.'</a></td>';
					} else {
						list($cat_id, $cat_name) = $xoopsDB->fetchRow($result);
						echo '<td style="text-align:left; width:35px;">'.$cat_id.'</td>';
						echo '<td style="text-align:left;">'.$cat_name.'</td>';
						echo '<td style="text-align:right;"><a href="index.php?op=modifycategory&id='.$cat_id.'">'._AM_MODCAT.'</a> | <a href="index.php?op=deletecategory&id='.$cat_id.'">'._AM_DELETE.'</a></td>';						
					}
					  
    				echo '</tr>'."\n";
					if($class == "even") {
						$class = "odd";
					} else {
						$class = "even";
					}
				} 
        	}        		
		}
	}
}

/*
 * function buildPageNumbers
 * 
 * var imgPages			- Number of pages to create (total_images / images_per_page)
 * var images_per_page	- Number of images per page
 * var id				- Cagetory ID
 * var type				- Cagetory or Collection
 * var imgNum			- Current image number. Determines which page your on
 * 
 * Description: Builds the page numbers and selects the current page.
 */
function buildPageNumbers($img_total, $images_per_page, $id, $type, $imgNum) {
	global $xoopsModule;
	$myShowThumbs = "";
	$curImgNum = 0;
	$imgPages = ceil($img_total / $images_per_page);		
	// If there are more then one page, build the menu
	if ($imgPages > 1) {
		//$myShowThumbs .=  "<p />\n";
		for ($count1 = 1; $count1 < ($imgPages + 1); $count1++) {
			if ($imgNum == $curImgNum) {
				// Marks the current page
				$myShowThumbs .= '&nbsp;<span id="pageNumber">'.$count1.'</span>&nbsp;'."\n";
				$curImgNum = $curImgNum + $images_per_page;
			} else {
				if ($type == 'cat') {
					$myShowThumbs .= '&nbsp;<a href="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/viewcat.php?num='.$curImgNum.'&id='.$id.'">'.$count1.'</a>&nbsp;'."\n";
					$curImgNum = $curImgNum + $images_per_page;
				} else {
					$myShowThumbs .= '&nbsp;<a href="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/viewcoll.php?num='.$curImgNum.'&id='.$id.'">'.$count1.'</a>&nbsp;'."\n";
					$curImgNum = $curImgNum + $images_per_page;
				}
				
			}
		}
	}
	return $myShowThumbs;
}

/*
 * Checks the image type
 */
function checkImageType($path, $images) {
	foreach($images as $image) {
		$fullPath = $path ."/".$image;
		if(is_file("{$fullPath}")) {
			if (exif_imagetype("{$fullPath}") == IMAGETYPE_GIF) {
				return false;
			} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_JPEG) {
				return false;
			} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_PNG) {
				return false;
			} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_BMP) {
				return false;
			}
		}			
	}	
	return true;
}

function checkForCatalog($path, $images) {
	foreach($images as $image) {
		$fullPath = $path . "/" . $image;
		if(is_file("{$fullPath}")) {
			if (exif_imagetype("{$fullPath}") == IMAGETYPE_GIF) {
				return true;
			} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_JPEG) {
				return true;
			} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_PNG) {
				return true;
			} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_BMP) {
				return true;
			}			
			return false;
		}
	}
}

function checkBannerType($path, $image) {
	$fullPath = $path . "/" . $image;
	if(is_file("{$fullPath}")) {
		if (exif_imagetype("{$fullPath}") == IMAGETYPE_GIF) {
			return true;
		} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_JPEG) {
			return true;
		} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_PNG) {
			return true;
		} elseif (exif_imagetype("{$fullPath}") == IMAGETYPE_BMP) {
			return true;
		}			
		return false;
	}
}

function searchPaths($search, $sub, $fileList = array()) {
		
	if ($sub) {
		if(ereg("\/$", $search)) {
			$mySearch = $search.$sub;
		} else {
			$mySearch = $search.'/'.$sub;
		}
	} else {
		$mySearch = $search;
	}
	
	$handle = opendir($mySearch);
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			if (is_dir($mySearch.'/'.$file)) {
				$fileList = searchPaths($search, $file, $fileList);
			}
			if(eregi(".*(\.jpg|\.gif|\.png|\.jpeg)", $file)) {				
				array_push($fileList, $mySearch.'/'.$file);					
			}	 		
		}			
	}

	sort($fileList);
	for($n = 0; $n < count($fileList); $n++) {
	}
	
	return $fileList;
}

function checkPermissions($perm_itemid) {
	global $xoopsUser, $xoopsDB, $xoopsModule, $xoopsModuleConfig;

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

// Creat the menu navigation
function createNavigation($link_path, $c_name) {
    global $xoopsModuleConfig, $xoopsModule, $xoopsDB;
	$myCreateNavigation = "";
	$nav = array();
	$nav_sort = array();
    
	$myCreateNavigation .= "<a href=\"".XOOPS_URL."/\">"._MB_SYSTEM_HOME."</a>";
	$myCreateNavigation .= " ".$xoopsModuleConfig['gallery_breadcrumb']." <a href=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/\">"._MD_GALLERY_MAIN."</a>";
	
	if(ereg('/', $link_path)) {
		$nav = explode('/', $link_path);
		$last = array_pop($nav);
	} 
	
	$count = count($nav);

	if($count > 0) {
		for($i = 0; $i < $count; $i++) {
			$nav_string = implode('/', $nav);
			array_pop($nav);
			$sql = 'SELECT cat_id, cat_name FROM '.$xoopsDB->prefix('gallery_category').' WHERE cat_link="'.mysql_escape_string($nav_string).'" LIMIT 1';
			$result = $xoopsDB->query($sql);
			list($cat_id, $cat_name) = $xoopsDB->fetchRow($result);
			array_push($nav_sort, ' '.$xoopsModuleConfig['gallery_breadcrumb'].' <a href="'.XOOPS_URL."/modules/".$xoopsModule->getVar('dirname').'/viewcat.php?id='.$cat_id.'">'.htmlentities($cat_name).'</a> ');
		}		
	}

	$nav_rev = array_reverse($nav_sort);

	$myCreateNavigation .= implode($nav_rev);
	$myCreateNavigation .=  ' '.$xoopsModuleConfig['gallery_breadcrumb'].' '. htmlentities($c_name);

	return $myCreateNavigation;
}

/*
 * function getModuleOptionGal
 */
function getModuleOptionGal($option, $repmodule='gallery') {
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval=false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}

/*
 * Admin gallery menu tab
 */
function galleryadminmenu($currentoption = 0, $breadcrumb = '') {
	global $xoopsModule, $xoopsConfig;
	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:12px; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/bg.png') repeat-x left bottom; font-size:12px; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";

	$tblColors = Array();
	$tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = '';
	$tblColors[$currentoption] = 'current';

	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	echo "<td style=\"width: 60%; font-size: 12px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."\">" . _AM_GALLERY_GENERALSET . "</a> | <a href=\"../index.php\">" . _AM_GALLERY_GOTOMOD . "</a> | <a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=help'>" . _AM_GALLERY_HELP . "</a> | <a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=about'>" . _AM_GALLERY_ABOUT . "</a></td>";
	echo "<td style=\"width: 40%; font-size: 12px; text-align: right; font-weight:bold; color: #2F5376; padding: 0 6px; line-height: 18px;\">" . $xoopsModule->name() . " " . _AM_GALLERY_MODULEADMIN . ": " . $breadcrumb . "</td>";
	echo "</tr></table>";
	echo "</div>";
	$tblc = 0;
	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=options'><span>"._AM_GALLERY_MAIN."</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=listcategories'><span>"._AM_GALLERY_LSCATEGORIES."</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=newcollections'><span>"._AM_GALLERY_NEWCOLLECT."</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=listcollections'><span>"._AM_GALLERY_COLLECT."</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=liststats'><span>" . _AM_GALLERY_LISTSTATS . "</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=listbannerads'><span>" . _AM_GALBANNERADD . "</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=setpermissions'><span>" . _AM_GALLERY_SETPERM . "</span></a></li>";
	$tblc++;
	echo "<li id='" . $tblColors[$tblc] . "'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/index.php?op=delperm'><span>" . _AM_GALLERYPERMDEL . "</span></a></li>";
	echo "</ul></div>";
	echo "<br /><br /><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre>";
}
?>