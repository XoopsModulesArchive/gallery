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
   
include '../../../include/cp_header.php';
$qstring = array();
//parse_str($_SERVER['QUERY_STRING'], $qstring);
$updated = 0;
$myFilter = $xoopsModuleConfig['gen_filter'];
$myFilters = explode('|', $myFilter);

foreach($_POST as $coll) {
	$name = $link = $parent = $coll;
	$thumb = '';	
	$pid = 0;
	$date = time();
	$cachePath =  XOOPS_ROOT_PATH . $xoopsModuleConfig['thumbnail_location'];
	$findme = '/';
	$first = 0;
	$pos = strpos($link, $findme);
	
	
	
	if($pos !== false) {
		$path_array = array();
		$path_array = split($findme, $coll);
		$count = count($path_array);
		$count--;
		$name = mysql_escape_string($path_array[$count]);
		$link = $coll;
		$count--;
		$parent = mysql_escape_string($path_array[$count]);
		
		$sql = 'SELECT cat_id FROM '.$xoopsDB->prefix('gallery_category'). ' WHERE cat_name="'.$parent.'" LIMIT 1';
		$result = $xoopsDB->query($sql);	
		$rowCount = $xoopsDB->getRowsNum($result);
		if($rowCount > 0) {
			list($cat_id) = $xoopsDB->fetchRow($result);
			$pid = $cat_id;
		}
	} 
	
	$fullpath = XOOPS_ROOT_PATH ."/". $xoopsModuleConfig['gallery_location'] . "/" . $link;
	if(($files = array_diff( scandir($fullpath, 1), array('.', '..'))) !== false) {
		sort($files);
		$file = '';
		$p_count = count($files);
		for($i = 0; $i < $p_count; $i++) {
			if (exif_imagetype($fullpath."/".$files[$i]) == IMAGETYPE_GIF) {
    			$file = $files[$i];
				$i = $p_count;
			} else if (exif_imagetype($fullpath."/".$files[$i]) == IMAGETYPE_JPEG) {
    			$file = $files[$i];
				$i = $p_count;
			} else if (exif_imagetype($fullpath."/".$files[$i]) == IMAGETYPE_PNG) {
    			$file = $files[$i];
				$i = $p_count;
			}
			
		}

		$thumb = "th_" . strtolower($name) . "_" . strtolower($file);
	}
	$thumb = mysql_escape_string($thumb);
	$link = mysql_escape_string($link);
	
	$sql = 'INSERT INTO '.$xoopsDB->prefix('gallery_collection'). ' (coll_lid, coll_name, coll_thumb, coll_link, coll_date) VALUES ("'.$pid.'", "'.$name.'", "'.$thumb.'", "'.$link.'", "'.$date.'")';
	
	if($result = $xoopsDB->queryF($sql)) {
		//redirect_header("index.php", 2, _MD_ERRORDB);
		$updated++;
	} 
} 
$updated = $updated . " collections added";
echo '{"update":[{"updated":"'.$updated.'"}]}';
?>