<?
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

include_once XOOPS_ROOT_PATH."/mainfile.php";
$adm = 0;
$adminmenu[$adm]['title'] = _AM_GALLERY_OPS;
$adminmenu[$adm]['link'] = "admin/index.php?op=options";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_LSCATEGORIES;
$adminmenu[$adm]['link'] = "admin/index.php?op=listcategories";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_UPDATTHUMBS;
$adminmenu[$adm]['link'] = "admin/index.php?op=newcollections";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_LISTCOLLECTION;
$adminmenu[$adm]['link'] = "admin/index.php?op=listcollections";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_LISTSTATS;
$adminmenu[$adm]['link'] = "admin/index.php?op=liststats";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_LISTBANNADS;
$adminmenu[$adm]['link'] = "admin/index.php?op=listbannerads";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_SETPERM;
$adminmenu[$adm]['link'] = "admin/index.php?op=setpermissions";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERYPERMDEL;
$adminmenu[$adm]['link'] = "admin/index.php?op=delperm";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_HELP;
$adminmenu[$adm]['link'] = "admin/index.php?op=help";
$adm++;
$adminmenu[$adm]['title'] = _AM_GALLERY_ABOUT;
$adminmenu[$adm]['link'] = "admin/index.php?op=about";
?>
