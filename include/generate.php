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
//if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') die(header("Location: /")); 
$myOverwrite = (int) $_REQUEST['ow'];
$myPath = $_REQUEST['rpath'];
$mySearch = $_REQUEST['spath'];
$myThumbWidth = $_REQUEST['width'];
$myThumbHeight = $_REQUEST['height'];
$myThumbLocation = $_REQUEST['tpath'];

$imgprocc = 0;

createCacheThumbs();

// Scan gallery directory for images
function createCacheThumbs() {
	global $myOverwrite, $myPath, $mySearch, $myThumbWidth, $myThumbHeight, $imgprocc;
	$fileList = array();
	$thisPath = stripslashes($myPath);
	$path = $mySearch . "/" .$thisPath;
	if(($files = array_diff( scandir($path, 1), array('.', '..'))) !== false) {
		foreach($files as $file) {
			stripslashes($file);
			$fullPath = $path . "/" . $file;
			if (exif_imagetype("{$fullPath}") == IMAGETYPE_GIF) {
    			array_push($fileList, $file);
				generateThumbImg("{$fullPath}", "thumb", $myThumbWidth, $myThumbHeight, $myOverwrite);
			} else if (exif_imagetype("{$fullPath}") == IMAGETYPE_JPEG) {
    			array_push($fileList, $file);
				generateThumbImg("{$fullPath}", "thumb", $myThumbWidth, $myThumbHeight, $myOverwrite);
			} else if (exif_imagetype($path."/".$file) == IMAGETYPE_PNG) {
    			array_push($fileList, $file);
				generateThumbImg("{$fullPath}", "thumb", $myThumbWidth, $myThumbHeight, $myOverwrite);
			}		
		}
	}
	sort($fileList);	

	$json = '{"coll":[{"proc":"'.$imgprocc.'"}, {"file":"'.addslashes($myPath).'"}]}';

$response = $json;
 echo $response;
}

// Generate thumbnails for image gallery.
function generateThumbImg($img, $thumb, $w, $h, $myOverwrite) {
	global $myThumbLocation, $imgprocc;

	try {
		$width = $w;
		$height = $h;	
		$cachePath = $myThumbLocation;
		$path = pathinfo($img);
		$dirPaths = split("/", $path['dirname']);
		$lastDir = count($dirPaths) - 1;
		$fileThumbPath = $cachePath . "/th_" . strtolower($dirPaths[$lastDir]) . "_" . strtolower($path['basename']);
		$currtype = exif_imagetype($img);

		if(!file_exists($fileThumbPath)) {	
			
			switch($currtype){
				case 2:
					$img=imagecreatefromjpeg($img);
					break;
				case 1:
					$img=imagecreatefromgif($img);
					break;
				case 3:
					$img=imagecreatefrompng($img);
					break;
				default:
					break;			
			}
			$xratio = $width/(imagesx($img));
			$yratio = $height/(imagesy($img));

			if($xratio < 1 || $yratio < 1) {
				if($xratio < $yratio) {
					$resized = imagecreatetruecolor($width,floor(imagesy($img)*$xratio));
				} else {
					$resized = imagecreatetruecolor(floor(imagesx($img)*$yratio), $height);
				}
		
				imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized)+1,imagesy($resized)+1,imagesx($img),imagesy($img));

				switch($currtype){
					case 2:			
						imagejpeg($resized, $fileThumbPath, 80);
						break;
					case 1:			
						imagegif($resized, $fileThumbPath, 80);
						break;
					case 3:			
						imagepng($resized, $fileThumbPath, 80);
						break;
					default:
						return false;
						break;			
				}

				imagedestroy($resized);
				$imgprocc++;	
			}
		} else {
			if($myOverwrite == 1) {
				switch($currtype){
					case 2:
						$img=imagecreatefromjpeg($img);
						break;
					case 1:
						$img=imagecreatefromgif($img);
						break;
					case 3:
						$img=imagecreatefrompng($img);
						break;
					default:
						break;			
				}
				$xratio = $width/(imagesx($img));
				$yratio = $height/(imagesy($img));

				if($xratio < 1 || $yratio < 1) {
					if($xratio < $yratio) {
						$resized = imagecreatetruecolor($width,floor(imagesy($img)*$xratio));
					} else {
						$resized = imagecreatetruecolor(floor(imagesx($img)*$yratio), $height);
					}
		
					imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized)+1,imagesy($resized)+1,imagesx($img),imagesy($img));

					switch($currtype){
						case 2:			
							imagejpeg($resized, $fileThumbPath, 80);
							break;
						case 1:			
							imagegif($resized, $fileThumbPath, 80);
							break;
						case 3:			
							imagepng($resized, $fileThumbPath, 80);
							break;
						default:
							return false;
							break;			
					}
					imagedestroy($resized);		
				}
				$imgprocc++;
			}
		}
			
	} catch(Exception $e) {
    	redirect_header("index.php?op=updatethumbs", 10, _AM_GALLERYUPDATEERROR);
	}	
}
?>