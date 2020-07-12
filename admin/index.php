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
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
$module_id = $xoopsModule->getVar('mid');
include_once XOOPS_ROOT_PATH."/mainfile.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.php";
include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
include_once XOOPS_ROOT_PATH.'/class/module.errorhandler.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

// include the default language file for the admin interface
if ( !@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/main.php")){
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/main.php");
}

if ( !@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/admin.php")){
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/admin.php");
}

if ( !@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/modinfo.php")){
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/modinfo.php");
}

if ( !@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/blocks.php")){
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/blocks.php");
}

$myts = &MyTextSanitizer::getInstance();

$op = "";
$id = "";
$ow = "";
$img_name = "";
$ud = "";
$banner = "";
$bannerlink = "";

if (isset($_REQUEST)) {
    $op = isset($_REQUEST['op'])? $_REQUEST['op']:"options";
	$id = isset($_REQUEST['id_img'])? intval($_REQUEST['id_img']):0;
	$ow = isset($_REQUEST['ow'])?$_REQUEST['ow']:"";
	$img_name = isset($_REQUEST['p_img'])?$_REQUEST['p_img']:"";
	$ud = isset($_REQUEST['ud'])?$_REQUEST['ud']:"";
	$banner = isset($_REQUEST['bannerimg'])?$_REQUEST['bannerimg']:"";
	$bannerlink = isset($_REQUEST['bannerlink'])?$_REQUEST['bannerlink']:"";
} 

switch ($op) {
	case "options":
		listOptions();
		break;
	case "liststats":
		listStats();
		break;
	case "listcategories":
		listCategories();
		break;
	case "addcategory":
		addCategory();
		break;
	case "modifycategory":
		modifyCategory();
		break;
	case "modifycategorygo":
		modifyCategoryGo();
		break;
	case "deletecategory":
		modifyCategoryDel();
		break;
	case "newcollections":
		newCollections();
		break;
	case "listcollections":
		listCollections();
		break;
	case "modifycollection":
		modifyCollection();
		break;
	case "modifycollectiongo":
		modifyCollectionGo();
		break;
	case "delcollection":
		delCollection();
		break;
	case "setpermissions":
		setPermissions();
		break;
	case "delperm":
		delPermissions();
		break;
	case "delpermgo":
		delPermissionsGo();
		break;
	case "listbannerads":
		listBannerAds();
		break;
	case "addbannerad":
		addBannerAd();
		break;
	case "modifybannerads":
		modifyBannerAds();
		break;
	case "modifybanneradsgo":
		modifyBannerAdsGo();
		break;
	case "deletebannerad":
		modifyBanneradsDel();
		break;
	case "help":
		help();
		break;
	case "about":
		about();
		break;
	default:
		listOptions();
		break;
}

function listOptions() {
	global $xoopsModule, $xoopsModuleConfig;
    xoops_cp_header();
	galleryadminmenu(0, _AM_GALLERY_MAIN);
    OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERY_MAIN."</legend>";
    echo "<p/>";
	
	if(ini_get('safe_mode')) {
		echo "PHP SafeMode: <font color='green'>On</font><p>";
	} else {
		echo "PHP SafeMode: <font color='red'>Off</font><p>";
	}
	if(ini_get('register_globals')) {
		echo "PHP Register Globals: <font color='green'>On</font><p>";
	} else {
		echo "PHP Register Globals: <font color='red'>Off</font><p>";
	}
	$cacheDirectory = XOOPS_ROOT_PATH . $xoopsModuleConfig['thumbnail_location'];
	
	if (! is_dir($cacheDirectory)) {
		echo "Cache Path: ".$cacheDirectory ." <font color='red'>is not a directory.</font><p>";
	} else {
		if(is_writable($cacheDirectory)) {
			echo "Cache Path: ".$cacheDirectory ." <font color='green'>is writable.</font><p>";
		} else {
			echo "Cache Path: ".$cacheDirectory ." <font color='red'> is not writable.</font><p>";
		}
	}
	
	echo _MI_GALLERY_NAME." Path: ".XOOPS_ROOT_PATH ."/".$xoopsModuleConfig['gallery_location']."<p>";
	echo "</fieldset>";
    CloseTable();
    xoops_cp_footer();
    exit();
}

function listCategories() {
	xoops_cp_header();
	galleryadminmenu(1, _AM_GALLERY_CATEGORIES);
	OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERY_CATEGORIES."</legend>";
    echo "<p/>";
	
	echo '<form id="formupdate" name="formupdate" method="post" action="index.php?op=updateconfirm">'."\n";
  	echo "<table width='100%' cellpadding='2' cellspacing='1' align='left' class='outer'>\n";   
    echo "<tr><th style='text-align:left;'>"._AM_STATID."</th><th style='text-align:left;'>"._AM_STATCOLL."</th><th style='text-align:right;'>"._AM_STATACTION."</th></tr>\n";
	showCategories();    
  	echo '</table>'."\n";
	echo '</form>'."\n";
	echo "</fieldset>";
	CloseTable();
	xoops_cp_footer();
	exit();	
}

function addCategory() {
	global $xoopsDB, $xoopsModuleConfig;
	$name = '';
	$thumb = '';
	$link = '';
	$parent = '';
	$pid = 0;
	$hits = 0;
	$path = htmlentities($_REQUEST['path'], ENT_QUOTES, 'UTF-8');
	$fullpath = XOOPS_ROOT_PATH ."/". $xoopsModuleConfig['gallery_location'] . "/" . $path;
	$findme = '/';
	$first = 0;
	$pos = strpos($path, $findme);
	
	// Iterator to traverse the subdirectories in the gallery
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fullpath), RecursiveIteratorIterator::SELF_FIRST);
	
	foreach($iterator as $fpath) {
		if($fpath->isDir() && $first == 0) {
			$myFileList = array();
			$myFileList = searchPaths($fpath->getPathname(), "", $myFileList);
			list($rootPath, $folderPath) = split('/'.$xoopsModuleConfig['gallery_location'].'/', $myFileList[0]);
			$thumb = $folderPath;
			$first++;
		}
	}
	
	if($pos === false) {
		$name = $path;
		$link = $path;
		$parent = 0;
		$pid = $parent;
	} else {
		$path_array = array();
		$path_array = split($findme, $path);
		$count = count($path_array);
		$count--;
		$name = mysql_escape_string($path_array[$count]);
		$link = mysql_escape_string($path);
		$count--;
		$parent = mysql_escape_string($path_array[$count]);
		$pid = $parent;
	}
	
	$sql = 'SELECT cat_id FROM '.$xoopsDB->prefix('gallery_category'). ' WHERE cat_name="'.$parent.'" LIMIT 1';
	$result = $xoopsDB->query($sql);
	
	$rowCount = $xoopsDB->getRowsNum($result);
		
	if($rowCount > 0) {
		list($cat_id) = $xoopsDB->fetchRow($result);
		$pid = $cat_id;
	} else {
		$pid = 0;
	}
	
	$sql = 'INSERT INTO '.$xoopsDB->prefix('gallery_category'). ' (cat_pid, cat_name, cat_thumb, cat_link, cat_hits) VALUES ("'.$pid.'", "'.$name.'", "'.$thumb.'", "'.$link.'", "'.$hits.'")';
	if(!$result = $xoopsDB->queryF($sql)) {
		redirect_header("index.php", 2, _MD_ERRORDB);
	} else {
		redirect_header("index.php?op=listcategories", 2, _AM_GALCATSUCCESS);
	}
	//echo $sql."<br/>";
}

function modifyCategory() {
	global $xoopsDB, $_REQUEST, $xoopsModuleConfig;
	
	$cat_id = (int)$_REQUEST['id'];
	$sql = 'SELECT cat_pid, cat_name, cat_thumb, cat_banner, cat_description FROM '.$xoopsDB->prefix('gallery_category').' WHERE cat_id="'.$cat_id.'" LIMIT 1';
	$result = $xoopsDB->query($sql);
	list($cat_pid, $cat_name, $cat_thumb, $cat_banner, $cat_desc) = $xoopsDB->fetchRow($result);
	
	xoops_cp_header();
	galleryadminmenu(1, "_AM_GALLERY_MODIFYCAT");
	OpenTable();
	echo "<script type='text/javascript'>
<!--
//onChange banner image image
function changeImage(imgName,selObj)
{
	if (document.images) document.images[imgName].src = selObj.options[selObj.selectedIndex].value;
}
// -->
</script>";
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERY_MODIFYCAT."</legend>";
    echo "<p/>";
	$modcat = new XoopsThemeForm(_AM_GAL_CAT_MODIFY, 'modifycat', 'index.php', 'POST');
    $modcat->addElement( new XoopsFormLabel(_AM_STATID, $cat_id));

	$modcat->addElement( new XoopsFormText(_AM_GALCAT_NAME, 'cat_name', 50, 100, $cat_name));
	
	$selectcat = new XoopsFormSelect(_AM_GALCAT_PARENT, 'cat_pid', $cat_pid, 1, false);
	$sql = 'SELECT cat_id, cat_name FROM '.$xoopsDB->prefix('gallery_category').' WHERE cat_id != "'.$cat_id.'"'; 
	$result = $xoopsDB->query($sql);
	$selectcat->addOption(0, $xoopsModuleConfig['gallery_location']);
	while ( list ($cats_id, $cats_name) = $xoopsDB->fetchRow($result)) {
		$selectcat->addOption($cats_id, $cats_name);
	}
	
	$modcat->addElement($selectcat);
	$modcat->addElement( new XoopsFormText(_AM_GALCAT_THUMB, 'cat_thumb', 50, 100, $cat_thumb));
	$sql3 = 'SELECT ban_image FROM '.$xoopsDB->prefix('gallery_banners'). " WHERE ban_id='".$cat_banner."' LIMIT 1";
	$result3 = $xoopsDB->query($sql3);
	list($cur_banner) = $xoopsDB->fetchRow($result3);
	$cur_banner = XOOPS_URL.$xoopsModuleConfig['gallery_banner_location']."/".$cur_banner;
	$sql2 = 'SELECT ban_id, ban_name, ban_image FROM '.$xoopsDB->prefix('gallery_banners');
	$result2 = $xoopsDB->query($sql2);
	$selectban = new XoopsFormSelect(_AM_GALCAT_BANNER, 'cat_ban', $cur_banner, 1, false);
	$selectban->addOption('', "------");
	while ( list ($ban_id, $ban_name, $ban_image) = $xoopsDB->fetchRow($result2)) {
		$selectban->addOption(XOOPS_URL.$xoopsModuleConfig['gallery_banner_location']."/".$ban_image, $ban_name);
	}
	$selectban->setExtra('onchange="changeImage(\'bannimg\',this)"');
	$modcat->addElement($selectban);
	$bannerimage = "<img name='bannimg' src='".$cur_banner."' width='350px' />";
	$modcat->addElement( new XoopsFormLabel('', $bannerimage));

	$modcat->addElement( new XoopsFormDhtmlTextArea(_AM_GALCAT_DESC, "cat_desc", $cat_desc, 10, 8));
	$modcat->addElement( new XoopsFormHidden('cat_id', $cat_id));
    $modcat->addElement( new XoopsFormHidden('op', 'modifycategorygo'));
    $modcat->addElement( new XoopsFormButton('', 'submit', _AM_MODIFY, 'submit'));
    $modcat->display();
	echo "</fieldset>";
    CloseTable();
    echo "<p/>";
    xoops_cp_footer();
}

function modifyCategoryGo() {
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $_REQUEST;
	$cat_id = (int)$_REQUEST['cat_id'];
	$cat_name = mysql_real_escape_string($_REQUEST['cat_name']);
	$cat_thumb = mysql_real_escape_string($_REQUEST['cat_thumb']);
	$cat_pid = (int)$_REQUEST['cat_pid'];
	$cat_ban = $_REQUEST['cat_ban'];
	$cat_desc = mysql_real_escape_string($_REQUEST['cat_desc']);
	$bannerurl = pathinfo($cat_ban);

	$sql = "SELECT ban_id FROM ".$xoopsDB->prefix('gallery_banners')." WHERE ban_image='".$bannerurl['basename']."' LIMIT 1";
	$result = $xoopsDB->query($sql);
	list($ban_id) = $xoopsDB->fetchRow($result);
	$sql = "UPDATE ".$xoopsDB->prefix('gallery_category')." SET cat_name='".$cat_name."', cat_thumb='".$cat_thumb."', cat_pid='".$cat_pid."', cat_banner='".$ban_id."', cat_description='".$cat_desc."' WHERE cat_id='".$cat_id."' LIMIT 1";

	if(!($result = $xoopsDB->queryF($sql))) {			
		redirect_header("index.php", 2, _MD_ERRORDB);				
	} else {
		redirect_header("index.php?op=listcategories", 2, _AM_GALCATUPSUCCESS);
	}
}

function modifyCategoryDel() {
	global $xoopsDB;
	$cat_id = (int)$_REQUEST['id'];
	$affected = 0;
	
	$sql = 'SELECT * FROM '.$xoopsDB->prefix("gallery_category").' WHERE cat_pid="'.$cat_id.'"';
	
	$result = $xoopsDB->query($sql);
	$catcount = $xoopsDB->getAffectedRows($result);
	
	if($catcount > 0) {
		redirect_header("index.php?op=listcategories", 2, _AM_GALCATDEL_ERROR_SUB);
	}
	
	$sql = sprintf("DELETE FROM %s WHERE cat_id = %u", $xoopsDB->prefix("gallery_category"), $cat_id);
	
	$result = $xoopsDB->queryF($sql);
	$affected = $xoopsDB->getAffectedRows($result);
	if($affected > 0) {
		redirect_header("index.php?op=listcategories", 2, _AM_GALCATDEL_SUCCESS);
	} else {
		redirect_header("index.php?op=listcategories", 2, _AM_GALCATDEL_ERROR);
	}
}

function setPermissions() {
	global $xoopsDB, $op, $module_id;
	
	// A list of items that we will be setting permissions to.
	// In most cases, this should be retrieved from DB. We use a static array here just for exemplification.
	
	//$item_lists = getParentDirectories();
	//$sql = "SELECT cat_name FROM ".$xoopsDB->prefix('gallery_category')."";
	
	xoops_cp_header();
	galleryadminmenu("6", "Set Permissions");
	OpenTable();
		
	// The title of the group permission form
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERYPERM."</legend>";
    echo "<p/>";
	$title_of_form = "<font style='font-weight: bold; color: #900;'>"._AM_GALLERYPERM."</font>";
	// The name of permission which should be unique within the module
	$perm_name = 'Gallery Main Category Permission';
	// A short description of this permission
	$perm_desc = _AM_GALLERYPERMDESC;
	// Create and display the form
	$form = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc);
	
	$sql = "SELECT cat_name, cat_id FROM ".$xoopsDB->prefix('gallery_category')."";
	$result = $xoopsDB->query($sql);
	while(list($permName, $permId) = $xoopsDB->fetchRow($result)) {
    	$form->addItem($permId, $permName);
	}
	echo $form->render();
	echo "</fieldset>";
	CloseTable();
	xoops_cp_footer();	
}

function delPermissions() {
	global $xoopsDB;
	xoops_cp_header();
	galleryadminmenu("7", _AM_GALLERYPERMDEL);
	
	$sql = "SELECT cat_name, cat_id FROM ".$xoopsDB->prefix('gallery_category')."";
	
	if(!$result = $xoopsDB->query($sql)) {
		redirect_header("index.php", 2, _MD_ERRORDB);
	}
	
	
	OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERYPERMDEL."</legend>";
    echo "<p/>";
	echo "<table width='100%' cellspacing='1' cellpadding='2' class='outer'>\n
		<tr>
		<th align='center'>" . _AM_GALLERY_CAT_ID . "</th>
		<th align='center'>" . _AM_GALLERY_CAT_NAME . "</th>
		<th align='center'>" . _AM_GALLERY_CAT_DEL . "</th></tr>\n";
	$class = "even";			
	while(list($permName, $permId) = $xoopsDB->fetchRow($result)) {
    	echo "<tr class='{$class}'><td>" . $permId . "</td><td>" . $permName . "</td><td>";
		echo '<form id="delform" name="delform" method="post" action="index.php?op=delpermgo&n=">
		<input type="submit" name="n" id="n" value="' . _AM_GALLERY_CAT_DEL . '" />
		<input name="op" type="hidden" value="delpermgo" />
		<input name="n" type="hidden" value="' . $permId . '" /></form>';
		if($class == "even") {
			$class = "odd";
		} else {
			$class = "even";
		}
	}
	echo "</table>\n";
	echo "</fieldset>";
	CloseTable();
	xoops_cp_footer();
}

function delPermissionsGo() {
	global $xoopsUser, $xoopsDB, $xoopsModule, $_POST;
	$module_id = $xoopsModule->getVar('mid');
	$perm_name = 'Gallery Main Category Permission';
	$item_id = "";
	
	if(isset($_POST['n'])) {
		$item_id = $_POST['n'];
	} else {
		redirect_header("index.php?op=delperm", 2, _MD_ERRORDB);
	}
	
	$sql = "DELETE from " . $xoopsDB->prefix('gallery_category') . " WHERE cat_id='".$item_id."'";
	
	if (!$results = $xoopsDB->query($sql)) {
		redirect_header("index.php?op=delperm", 2, _MD_ERRORDB);
	}
	
	if (($rows = $xoopsDB->getAffectedRows()) == 0) {
		redirect_header("index.php?op=delperm", 2, _AM_GALLERY_CAT_DELFAIL);
	}
	
	if(xoops_groupperm_deletebymoditem($module_id, $perm_name, $item_id)) {
		redirect_header("index.php?op=delperm", 1, _AM_GALLERY_CAT_DELSUCC);
	} else {
		redirect_header("index.php?op=delperm", 2, _AM_GALLERY_CAT_DELFAIL);
	}
}

function listBannerAds() {
	global $xoopsModule, $xoopsModuleConfig, $xoopsDB;
	
	xoops_cp_header();
	galleryadminmenu("5", _AM_GALBANNERADD);
	OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALBANNERADD."</legend>";
    echo "<p/>";
	echo "<table width='100%' cellpadding='2' cellspacing='1' align='left' class='outer'>\n";
	echo "<tr class='bg3'><th>"._AM_GALCAT_BANNER."</th><th>"._AM_STATID."</th><th>"._AM_GALCAT_NAME."</th><th>"._AM_STATLINK."</th><th>"._AM_STATACTION."</th></tr>";
	$class = "even";
	$mySearch = XOOPS_ROOT_PATH.$xoopsModuleConfig['gallery_banner_location'];
	if(($files = array_diff( scandir($mySearch, 1), Array(".", ".."))) !== false) {
		foreach($files as $file) {
			$check = checkBannerType($mySearch, $file);				
			if($check) {					
			
				$sql = 'SELECT ban_id, ban_name, ban_image, ban_link FROM '.$xoopsDB->prefix('gallery_banners').' WHERE `ban_image` = "'.$file.'" LIMIT 1';
				$result = $xoopsDB->query($sql);
				echo '<tr class="'.$class.'">'."\n";    				
				if($xoopsDB->getRowsNum($result) == 0) {
					echo '<td style="text-align:left; width:400px;"><img src="'.XOOPS_URL.$xoopsModuleConfig['gallery_banner_location'].'/'.$file.'" width="350px"/></td>'."\n";
					echo '<td style="text-align:left;">&nbsp;</td>';
					echo '<td style="text-align:left;"><span style="color:red;">New</span>: '.$file.'</td>';
					echo '<td style="text-align:left;">&nbsp;</td>';
					echo '<td style="text-align:right;"><a href="index.php?op=addbannerad&banner='.$file.'">'._AM_ADDBANNER.'</a></td>';
				} else {
					list($ban_id, $ban_name, $ban_image, $ban_link) = $xoopsDB->fetchRow($result);
					echo '<td style="text-align:left; width:400px;"><img src="'.XOOPS_URL.$xoopsModuleConfig['gallery_banner_location'].'/'.$ban_image.'"  width="350px"/></td>'."\n";
					echo '<td style="text-align:left;">'.$ban_id.'</td>';
					echo '<td style="text-align:left;">'.$ban_name.'</td>';
					echo '<td style="text-align:left;">'.$ban_link.'</td>';
					echo '<td style="text-align:right;"><a href="index.php?op=modifybannerads&id='.$ban_id.'">'._AM_MODCAT.'</a> | <a href="index.php?op=deletebannerad&id='.$ban_id.'">'._AM_DELETE.'</a></td>';						
				}
					  
    			echo '</tr>'."\n";
				if($class == "even") {
					$class = "odd";
				} else {
					$class = "even";
				}
			}
		}
	} else {
		echo '<tr class="'.$class.'">'."\n";
		echo '<td colspan="5" style="text-align:center;">'._AM_GALCAT_NOBANNERS.'</td>';
		echo '</tr>';
	}
    echo "</table>";
	echo "</fieldset>";
    CloseTable();
    echo "<p/>";
    xoops_cp_footer();       	
}

function addBannerAd() {
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $_REQUEST;
	$image = $_REQUEST['banner'];
	$date = time();
	$sql = 'INSERT INTO '.$xoopsDB->prefix('gallery_banners'). ' (ban_name, ban_image, ban_date) VALUES ("'.$image.'", "'.$image.'", "'.$date.'")';
	if(!$result = $xoopsDB->queryF($sql)) {
		redirect_header("index.php", 2, _AM_GALCAT_BANNERERR);
	} else {
		redirect_header("index.php?op=listbannerads", 2, _AM_GALCAT_BANNERSUCC);
	}
}

function modifyBannerAds() {
	global $xoopsDB, $_REQUEST, $xoopsModuleConfig;
	
	$ban_id = (int)$_REQUEST['id'];
	$sql = 'SELECT ban_id, ban_name, ban_image, ban_link, ban_date FROM '.$xoopsDB->prefix('gallery_banners').' WHERE ban_id="'.$ban_id.'" LIMIT 1';
	$result = $xoopsDB->query($sql);
	list($ban_id, $ban_name, $ban_image, $ban_link, $ban_date) = $xoopsDB->fetchRow($result);
	$date = date("F j, Y, g:i a", $ban_date); 
	xoops_cp_header();
	galleryadminmenu("5", _AM_GALBANNERADD);
	OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALBANNERADD."</legend>";
    echo "<p/>";
	$modban = new XoopsThemeForm(_AM_GAL_BAN_MODIFY, 'modifyban', 'index.php', 'POST');
    $modban->addElement( new XoopsFormLabel(_AM_STATID, $ban_id));
	$modban->addElement( new XoopsFormText(_AM_GALCAT_NAME, 'ban_name', 50, 100, $ban_name));
	$modban->addElement( new XoopsFormText(_AM_GALBAN_LINK, 'ban_link', 50, 500, $ban_link));
	$modban->addElement( new XoopsFormLabel(_AM_GALBAN_DATEADDED, $date));
	$bannerimage = "<img src='".XOOPS_URL.$xoopsModuleConfig['gallery_banner_location']."/".$ban_image."' width='350px' />";
	$modban->addElement( new XoopsFormLabel(_AM_GALCAT_BANNER, $bannerimage));		
	$modban->addElement( new XoopsFormHidden('ban_id', $ban_id));
    $modban->addElement( new XoopsFormHidden('op', 'modifybanneradsgo'));
    $modban->addElement( new XoopsFormButton('', 'submit', _AM_MODIFY, 'submit'));
    $modban->display();
	echo "</fieldset>";
    CloseTable();
    echo "<p/>";
    xoops_cp_footer();
}

function modifyBannerAdsGo() {
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $_REQUEST;
	$ban_id = (int)$_REQUEST['ban_id'];
	$ban_name = mysql_real_escape_string($_REQUEST['ban_name']);
	$ban_link = mysql_real_escape_string($_REQUEST['ban_link']);
	
	$sql = "UPDATE ".$xoopsDB->prefix('gallery_banners')." SET ban_name='".$ban_name."', ban_link='".$ban_link."' WHERE ban_id='".$ban_id."' LIMIT 1";
	if(!($result = $xoopsDB->queryF($sql))) {			
		redirect_header("index.php", 2, _MD_ERRORDB);				
	} else {
		redirect_header("index.php?op=listbannerads", 2, _AM_GALBANNUPDATESUCCESS);
	}
}

function modifyBanneradsDel() {
	global $xoopsDB;
	$ban_id = (int)$_REQUEST['id'];
	$affected = 0;
	
	$sql = sprintf("DELETE FROM %s WHERE ban_id = %u", $xoopsDB->prefix("gallery_banners"), $ban_id);
	
	$result = $xoopsDB->queryF($sql);
	$affected = $xoopsDB->getAffectedRows($result);
	if($affected > 0) {
		redirect_header("index.php?op=listbannerads", 2, _AM_GALBANDEL_SUCCESS);
	} else {
		redirect_header("index.php?op=listbannerads", 2, _AM_GALBANDEL_ERROR);
	}
}

function help() {
	xoops_cp_header();
	galleryadminmenu("", "Help");
	OpenTable();
	echo "<h4 style='font-weight: bold; color: #900;'>" . _AM_GALLERY_HELP . "</h4><p>";
	echo _AM_GALLERY_HELPDESC;
	CloseTable();
	xoops_cp_footer();
	exit();

}

function about() {
	global $xoopsModule;
	
	$module_handler =& xoops_gethandler('module');
	$info =& $module_handler->get($xoopsModule->getVar('mid'));
	xoops_cp_header();
	galleryadminmenu("", "About");
	OpenTable();
	
	// Left headings...
	echo "<img src='" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/" . $info->getInfo('image') . "' alt='' hspace='0' vspace='0' align='left' style='margin-right: 10px;' /></a>";
	echo "<div style='margin-top: 10px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" . $info->getInfo('name') . " version " . $info->getInfo('version') . " (" . $info->getInfo('status_version') . ")</div>";
	
	if  ( $info->getInfo('author_realname') != '') {
		$author_name = $info->getInfo('author') . " (" . $info->getInfo('author_realname') . ")";
	} else {
		$author_name = $info->getInfo('author');
	}

	echo "<div style = 'line-height: 16px; font-weight: bold; display: block;'>" . _AM_GALLERY_BY . " " .$author_name;
	echo "</div>";
	echo "<div style = 'line-height: 16px; display: block;'>" . $info->getInfo('license') . "</div><br /><br /></>\n";
	
	// Author Information
echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
echo "<tr>";
echo "<td colspan='2' class='bg3' align='left'>" . _AM_GALLERY_AUTHOR_INFO . "</td>";
echo "</tr>";

if ( $info->getInfo('$author_name') != '' )
{
	echo "<tr>";
	echo "<td class='head' width='150px' align='left'>" ._AM_GALLERY_AUTHOR_NAME . "</td>";
	echo "<td class='even' align='left'>" . $author_name . "</td>";
	echo "</tr>";
}
if ( $info->getInfo('author_website_url') != '' )
{
	echo "<tr>";
	echo "<td class='head' width='150px' align='left'>" . _AM_GALLERY_AUTHOR_WEBSITE . "</td>";
	echo "<td class='even' align='left'><a href='" . $info->getInfo('author_website_url') . "' target='_blank'>" . $info->getInfo('author_website_name') . "</a></td>";
	echo "</tr>";
}
if ( $info->getInfo('author_email') != '' )
{
	echo "<tr>";
	echo "<td class='head' width='150px' align='left'>" . _AM_GALLERY_AUTHOR_EMAIL . "</td>";
	echo "<td class='even' align='left'><a href='mailto:" . $info->getInfo('author_email') . "'>" . $info->getInfo('author_email') . "</a></td>";
	echo "</tr>";
}
if ( $info->getInfo('credits') != '' )
{
	echo "<tr>";
	echo "<td class='head' width='150px' align='left'>" . _AM_GALLERY_AUTHOR_CREDITS . "</td>";
	echo "<td class='even' align='left'>" . $info->getInfo('credits') . "</td>";
	echo "</tr>";
}

echo "</table>";
echo "<br />\n";
CloseTable();
xoops_cp_footer();

}

function listStats() {
	global $xoopsDB, $op, $id;
	$sql = "SELECT coll_id, coll_name, coll_hits FROM ".$xoopsDB->prefix('gallery_collection')." ORDER BY coll_hits DESC";
	xoops_cp_header();
	galleryadminmenu(4, _AM_GALSTATSMENU);
	if (!($result = $xoopsDB->query($sql))) {
		xoops_cp_header();
    	echo _AM_ERRORRETSTATS;
     	xoops_cp_footer();
	} else {
		OpenTable();
		echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALSTATSMENU."</legend>";
    	echo "<p/>";
		echo "<table width='100%' cellpadding='2' cellspacing='1' class='outer'>";
		echo "<tr class='bg3'><th>"._AM_STATID."</th><th>"._AM_STATCOLL."</th><th>"._AM_STATHITS."</th><th>"._AM_STATACTION."</th></tr>";
		$class = "even";
		while(list($id, $name, $stat) = $xoopsDB->fetchRow($result)) {
			echo "<tr class='{$class}'>";
			echo "<td align='left'>".$id."</td>";
			echo "<td align='left'>".$name."</td>";
			echo "<td align='left'>".$stat."</td>";
        	echo "<td align='right'><a href='index.php?op=resetstats&amp;id_img=".$id."'>" ._AM_RESET."</a> | <a href='index.php?op=delstat&amp;id_img=".$id."'>"._AM_DELETE."</a></td>";
			echo "</tr>";
			if($class == "even") {
				$class = "odd";
			} else {
				$class = "even";
			}
		}
		echo "</table>";
		echo "</fieldset>";
		CloseTable();
	}
	xoops_cp_footer();
	exit();
}

function resetStats($statID) {
	global $xoopsDB;
	$sql = "UPDATE ".$xoopsDB->prefix('gallery_collection')." SET coll_hits='0' WHERE coll_id='".$statID."' LIMIT 1";
	//xoops_cp_header();
	if (!$xoopsDB->queryF($sql)) {
    	xoops_cp_header();
    	echo _AM_ERRORRESSTATS;
     	xoops_cp_footer();
    } else {
		redirect_header("index.php?op=liststats",1,_AM_GALRESSUCCESS);
	}
	//xoops_cp_footer();
}

function deleteStats($statID) {
	global $xoopsDB;
	$sql = "DELETE FROM ".$xoopsDB->prefix('gallery_collection')." WHERE coll_id='".$statID."' LIMIT 1";
	xoops_cp_header();
	if (!$xoopsDB->queryF($sql)) {
    	xoops_cp_header();
    	echo _AM_ERRORDELSTATS;
     	xoops_cp_footer();
    } else {
		redirect_header("index.php?op=liststats",1,_AM_GALDELSUCCESS);
	}
	xoops_cp_footer();
	exit();
}

function newCollections() {
	global $xoopsDB, $xoopsModuleConfig, $xoopsModule;
	$sql = 'SELECT cat_id, cat_name, cat_link FROM '.$xoopsDB->prefix('gallery_category');
	$result = $xoopsDB->query($sql);	
	$moddir = '/modules/'.$xoopsModule->getVar('dirname').'/';
	xoops_cp_header();
	galleryadminmenu(2, _AM_GALLERY_NEWCOLLECT);
	OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERY_NEWCOLLECT."</legend>";
    echo "<p/>";
	echo "<div style='width:100%; text-align:center;' id='currText'></div>";
	echo "<form name='newthumb' id='newthumb' action='' method='post' return false;'>";
	echo "<table width='100%' cellpadding='2' cellspacing='1' align='left' class='outer'>\n";
	echo "<tr><th style='text-align:left;'>"._AM_STATCOLL."</th><th style='text-align:right;'>"._AM_STATACTION."</th></tr>\n";
    $collections = array();
	$categories = array();
	
	
	// Path to collection location
	$galleryPath = XOOPS_ROOT_PATH."/".$xoopsModuleConfig['gallery_location'];// . "/" . $cat_link;
	// Iterator to traverse the subdirectories in the gallery
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($galleryPath), RecursiveIteratorIterator::SELF_FIRST);
	
	$class = "even";
	// Iterate through the directory paths
	foreach($iterator as $path) {
		if($path->isDir()) {			
        	if(($files = array_diff( scandir($path, 1), Array(".", ".."))) !== false) {
            	//echo "path: ".$path->getPathname()."<br/>";
				$check = checkForCatalog($path->getPathname(), $files);				
				if($check) {
					array_push($collections, $path->getPathname());
				}
			}
		}
	}
	
	$newcollections = array_unique($collections);
	sort($newcollections);
	$count = count($newcollections);
	$col = 0; 
	for($n = 0; $n < $count; $n++) {
		list($rootPath, $folderPath) = split('/'.$xoopsModuleConfig['gallery_location'].'/', $newcollections[$n]);
		$sql2 = 'SELECT coll_id, coll_name FROM '.$xoopsDB->prefix('gallery_collection').' WHERE `coll_link` = "'.$folderPath.'" LIMIT 1';
		$result2 = $xoopsDB->query($sql2);
						
		if($xoopsDB->getRowsNum($result2) == 0) {
			echo '<tr id="col'.$col.'" class="'.$class.'">'."\n"; 	
			echo '<td style="text-align:left;"><span style="color:red;">New</span>: '.$folderPath.'</td>';
			echo '<td style="text-align:right; width:100px;"><input type="checkbox" value="'.$folderPath.'" id="newcollections" name="newcollections[]" checked="checked"/></td>';
			echo '</tr>'."\n";
			if($class == "even") {
				$class = "odd";
			} else {
				$class = "even";
			}
			$col++;
		}     	
	}	
	echo "<tr><td colspan='3'style='text-align:left;'><input type='submit' title='"._AM_GALLCOLL_ADD."' value='"._AM_GALLCOLL_ADD."' id='collBtn' name='"._AM_GALLCOLL_ADD."' class='collButton'/></td></tr>";
  	echo '</table>'."\n";	
	echo "</form>";
	echo "<div style='width:100%; text-align:center;' id='respText'></div>";
	echo "</fieldset>";
    CloseTable();
	echo '<script type="text/javascript" src="'.$moddir.'js/jquery.js"></script>
		<script type="text/javascript" src="'.$moddir.'js/jquery.json-1.3.js"></script>
		<script type="text/javascript">
			var count = '.$count.'
		
		</script>		
		<script type="text/javascript" src="'.$moddir.'js/adminjs.js"></script>	
	';
    echo "<p/>";
    xoops_cp_footer();
}

function modifyCollection() {
	global $xoopsDB, $_REQUEST, $xoopsModuleConfig, $xoopsModule;
	
	$moddir = '/modules/'.$xoopsModule->getVar('dirname').'/';
	$coll_id = (int)$_REQUEST['id'];
	$sql = 'SELECT coll_lid, coll_name, coll_link, coll_thumb, coll_banner, coll_hits, coll_description FROM '.$xoopsDB->prefix('gallery_collection').' WHERE coll_id="'.$coll_id.'" LIMIT 1';
	$result = $xoopsDB->query($sql);
	list($coll_lid, $coll_name, $coll_link, $coll_thumb, $cur_banner, $coll_hits, $coll_desc) = $xoopsDB->fetchRow($result);
	
	xoops_cp_header();
	galleryadminmenu(3, _AM_GALLERY_MODIFYCOLLECT);
	OpenTable();
	echo '<script type="text/javascript" src="'.$moddir.'js/jquery.js"></script>
		<script type="text/javascript" src="'.$moddir.'js/jquery.json-1.3.js"></script>		
		<script type="text/javascript" src="'.$moddir.'js/adminjs.js"></script>	
	'; 
	echo "<script type='text/javascript'>
<!--
//onChange banner image image
function changeImage(imgName,selObj)
{
	if (document.images) document.images[imgName].src = selObj.options[selObj.selectedIndex].value;
}
// -->
</script>";
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERY_MODIFYCOLLECT."</legend>";
    echo "<p/>";
	$modcoll = new XoopsThemeForm(_AM_GALLERY_MODIFYCOLLECT, 'modifycoll', 'index.php', 'POST');
    $thumbn = XOOPS_URL.$xoopsModuleConfig['thumbnail_location']."/".$coll_thumb;
	$modcoll->addElement( new XoopsFormLabel(_AM_GALCAT_THUMB, "<img src='".$thumbn."' width='100px' />"));
	$modcoll->addElement( new XoopsFormLabel(_AM_STATID, $coll_id));
	$modcoll->addElement( new XoopsFormText(_AM_GALCAT_NAME, 'coll_name', 50, 100, $coll_name));
	$modcoll->addElement( new XoopsFormText(_AM_STATHITS, 'coll_hits', 50, 100, $coll_hits));
	
	$selectcoll = new XoopsFormSelect(_AM_GALCAT_PARENT, 'coll_lid', $coll_lid, 1, false);
	$sql = 'SELECT cat_id, cat_name FROM '.$xoopsDB->prefix('gallery_category'); 
	$result = $xoopsDB->query($sql);
	$selectcoll->addOption(0, $xoopsModuleConfig['gallery_location']);
	while ( list ($cats_id, $cats_name) = $xoopsDB->fetchRow($result)) {
		$selectcoll->addOption($cats_id, $cats_name);
	}
	
	$modcoll->addElement($selectcoll);
	//$modcat->addElement( new XoopsFormText(_AM_GALCAT_THUMB, 'cat_thumb', 50, 100, $cat_thumb));
	if($cur_banner != null) {
		$sql3 = 'SELECT ban_image FROM '.$xoopsDB->prefix('gallery_banners'). " WHERE ban_id='".$cur_banner."' LIMIT 1";
		$result3 = $xoopsDB->query($sql3);
		list($cur_banner) = $xoopsDB->fetchRow($result3);
		$cur_banner = XOOPS_URL.$xoopsModuleConfig['gallery_banner_location']."/".$cur_banner;
	} else {
		$cur_banner = "";
	}
		
	$sql2 = 'SELECT ban_id, ban_name, ban_image FROM '.$xoopsDB->prefix('gallery_banners');
	$result2 = $xoopsDB->query($sql2);
	$selectban = new XoopsFormSelect(_AM_GALCAT_BANNER, 'coll_banner', $cur_banner, 1, false);
	$selectban->addOption('', "------");
	while ( list ($ban_id, $ban_name, $ban_image) = $xoopsDB->fetchRow($result2)) {
		$selectban->addOption(XOOPS_URL.$xoopsModuleConfig['gallery_banner_location']."/".$ban_image, $ban_name);
	}
	$selectban->setExtra('onchange="changeImage(\'bannimg\',this)"');
	$modcoll->addElement($selectban);
	$bannerimage = "<img name='bannimg' src='".$cur_banner."' width='350px' />";
	$modcoll->addElement( new XoopsFormLabel('', $bannerimage));

	$modcoll->addElement( new XoopsFormDhtmlTextArea(_AM_GALCAT_DESC, "coll_desc", $coll_desc, 10, 8));
	$modcoll->addElement( new XoopsFormHidden('coll_id', $coll_id));
	$modcoll->addElement( new XoopsFormHidden('coll_link', $coll_link));
    $modcoll->addElement( new XoopsFormHidden('op', 'modifycollectiongo'));
    $modcoll->addElement( new XoopsFormButton('', 'submit', _AM_MODIFY, 'submit'));	
    $modcoll->display();	
	echo "</fieldset>";
	echo "<p/>";
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GENERATEREIMG."</legend>";
    echo "<p/>";
	$gencoll = new XoopsThemeForm(_AM_GENERATEIMG, 'gencoll', '', 'POST');
	$gencoll->addElement( new XoopsFormRadioYN(_AM_OVERWRITETHUMBS, 'genimgoverw', 0, _AM_YES, _AM_NO));
	$gencoll->addElement( new XoopsFormButton('', 'submit', _AM_GENERATE, 'submit'));
	$gencoll->display();
	echo "<div id='respText'></div>";
	echo "</fieldset>";
    CloseTable();
	echo "<p/>";
    xoops_cp_footer();
}

function modifyCollectionGo() {
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $_REQUEST;
	$coll_id = (int)$_REQUEST['coll_id'];
	$coll_lid = (int)$_REQUEST['coll_lid'];
	$coll_banner = $_REQUEST['coll_banner'];
	$coll_hits = (int)$_REQUEST['coll_hits'];
	$coll_name = mysql_real_escape_string($_REQUEST['coll_name']);
	$coll_desc = mysql_real_escape_string($_REQUEST['coll_desc']);
	
	$bannerurl = pathinfo($coll_banner);

	$sql = "SELECT ban_id FROM ".$xoopsDB->prefix('gallery_banners')." WHERE ban_image='".$bannerurl['basename']."' LIMIT 1";
	$result = $xoopsDB->query($sql);
	list($ban_id) = $xoopsDB->fetchRow($result);
	
	$sql = "UPDATE ".$xoopsDB->prefix('gallery_collection')." SET coll_lid='".$coll_lid."', coll_banner='".$ban_id."', coll_hits='".$coll_hits."', coll_name='".$coll_name."', coll_description='".$coll_desc."' WHERE coll_id='".$coll_id."' LIMIT 1";
	if(!($result = $xoopsDB->queryF($sql))) {			
		redirect_header("index.php?op=listcollections", 2, _MD_ERRORDB);				
	} else {
		redirect_header("index.php?op=listcollections", 2, _AM_GALCOLLMOD_SUCCESS);
	}
}

function listCollections() {
	global $xoopsDB;
	
	$sql = 'SELECT coll_id, coll_name FROM '.$xoopsDB->prefix('gallery_collection'). '';
	$result = $xoopsDB->query($sql);	
	$rowCount = $xoopsDB->getRowsNum($result);
	$class = "even";
	
	xoops_cp_header();
	galleryadminmenu(3, _AM_GALLERY_COLLECT);
	OpenTable();
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>"._AM_GALLERY_COLLECT."</legend>";
    echo "<p/>";
	echo "<table width='100%' cellpadding='2' cellspacing='1' align='left' class='outer'>\n";   
    echo "<tr><th style='text-align:left;'>"._AM_STATID."</th><th style='text-align:left;'>"._AM_STATCOLL."</th><th style='text-align:right;'>"._AM_STATACTION."</th></tr>\n";
	while(list($coll_id, $coll_name) = $xoopsDB->fetchRow($result)) {
		echo "<tr class='".$class."'><td style='text-align:left;'>".$coll_id."</td><td style='text-align:left;'>".$coll_name."</td>";
		echo '<td style="text-align:right;"><a href="index.php?op=modifycollection&id='.$coll_id.'">'._AM_MODCAT.'</a> | <a href="index.php?op=delcollection&id='.$coll_id.'">'._AM_DELETE.'</a></td></tr>';
		if($class == "even") {
			$class = "odd";
		} else {
			$class = "even";
		}
	}  
  	echo '</table>'."\n";
	echo "</fieldset>";
    CloseTable();
	echo "<p/>";
    xoops_cp_footer();
}

function delCollection() {
	global $xoopsDB;
	$coll_id = (int)$_REQUEST['id'];
	$affected = 0;
		
	$sql = sprintf("DELETE FROM %s WHERE coll_id = %u", $xoopsDB->prefix("gallery_collection"), $coll_id);
	
	$result = $xoopsDB->queryF($sql);
	$affected = $xoopsDB->getAffectedRows($result);
	if($affected > 0) {
		redirect_header("index.php?op=listcollections", 2, _AM_GALCOLLDEL_SUCCESS);
	} else {
		redirect_header("index.php?op=listcollections", 2, _AM_GALCOLLDEL_ERROR);
	}
}

?>
