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

define("_MI_GALLERY_NAME","Gallery");
define("_MI_GALLERY_DESC","Photo gallery for XOOPS sites");
define("_MI_GALLERY_RDESC","Shows five latest galleries");
define('_MI_GALLERY_BNAME1','Gallery');
define('_MI_GALLERY_BNAME2','Recent Collections');
define('_MI_GALLERY_BNAME3','Most Viewed Collections');
define('_MI_GALLERY_BNAME4','Random Image');
define('_MI_GALLERY_BREADCRUMB', "Breadcrumb Separator");
define('_MI_GALLERY_BREADCRUMB_DESC', "Separator for the breadcrumbs. It's best to use html entities.");
define('_MI_GALLERY_CATEGORIES', 'Block to show Gallery categories.');
define('_MI_GALLERY_RIMAGES', 'Block to show random collections.');
define('_MI_GALLERY_MOSTVIEWED', 'Block to show Most viewed collections.');
define('_MI_GALLERY_RANDOMIMAGE', 'Block to show a random collection image.');
define('_MI_GALLERY_COLLNOTFOUND', 'Collection not found.');
define('_MI_GALLERY_COLLEMPTY', 'Collection is empty.');
define('_MI_GALLERY_GAL_ADD','Gallery Directory');
define('_MI_GALLERY_GAL_ADD_DESC','Your gallery folder (this is where your pictures and picture folders are located)');
define("_MI_GALLERY_MODDIR","Module Directory");
define("_MI_GALLERY_MODDIR_DESC","Directory containing Gallery module. Default is gallery.");
define("_MI_GALLERY_RECTOTAL","Recent Display");
define("_MI_GALLERY_RECTOTAL_DESC","Number of recent image collections to display.");
define("_MI_GALLERY_EXCL_FOLD","Folders to exclude");
define("_MI_GALLERY_EXCL_FOLD_DESC","Folders you wish to exclude seperated by comma. (ex. folder1,folder2,folder3");
define("_MI_GALLERY_IMG_PER_PAGE","Image Thumbnails per page");
define("_MI_GALLERY_IMG_PER_PAGE_DESC","Number of thumbnails to display per page.");
define("_MI_GALLERY_PICTWTH","Picture Width");
define("_MI_GALLERY_PICTWTH_DESC","The width of the picture to display.");
define("_MI_GALLERY_PICTHI","Picture Height");
define("_MI_GALLERY_PICTHI_DESC","The height of the picture to display. Currently not used.");
define("_MI_GALLERY_LOADJQUERY", "Load Jquery");
define("_MI_GALLERY_LOADJQUERY_DESC", "If set to yes, will load jquery plugin. If your theme already loads jquery, set this to no.");
define("_MI_GALLERY_SHOWALL", "Show All Categories");
define("_MI_GALLERY_SHOWALL_DESC", "If set to yes, will generate page numbers to show all categories.");
define("_MI_GALLERY_PICTINFWTH","Picture Information Width");
define("_MI_GALLERY_PICTINFWTH_DESC","The width of the picture to displayed on the information page.");
define("_MI_GALLERY_PICINFTHI","Picture Information Height");
define("_MI_GALLERY_PICINFTHI_DESC","The height of the picture to displayed on the information page. Currently not used.");

define("_MI_GALLERY_THUMBWTH","Thumbnail Width");
define("_MI_GALLERY_THUMBWTH_DESC","The width of the thumbnails that are displayed.");
define("_MI_GALLERY_THUMBHI","Thumbnail Height");
define("_MI_GALLERY_THUMBHI_DESC","The width of the thumbnails that are displayed. Currently not used.");
define("_MI_GALLERY_F_COLS","Main Thumbnail Columns");
define("_MI_GALLERY_F_COLS_DESC","How many columns of thumbnails per row.");
define("_MI_GALLERY_THUMB_COLS","Collection Thumbnail Columns");
define("_MI_GALLERY_THUMB_COLS_DESC","How many columns of thumbnails per row.");
define("_MI_GALLERY_GENERALCONF","Preferences");
define("_MI_GALLERY_MARQUEE","Enable Marquee");
define("_MI_GALLERY_GENFILTER","Generator Filter");
define("_MI_GALLERY_GENFILTER_DESC","Filter for thumbnail generator. Seperate each filter with a | 'no space'");
define("_MI_GALLERY_MARQUEE_DESC","Enabled or Disabled Recent Images Marquee");
define("_MI_GALLERY_MARQUEE_DIRECTION","Marquee Direction");
define("_MI_GALLERY_MARQUEE_DIRECTION_DESC","Up, Down, Left, Right");
define("_MI_GALLERY_MARQUEE_WIDTH","Marquee Width");
define("_MI_GALLERY_MARQUEE_WIDTH_DESC","Set the width of the Marquee box");
define("_MI_GALLERY_MARQUEE_HEIGHT","Marquee Height");
define("_MI_GALLERY_MARQUEE_HEIGHT_DESC","Set the height of the Marquee box");
define("_MI_GALLERY_MARQUEE_SAMOUNT","Marquee Scroll Amount");
define("_MI_GALLERY_MARQUEE_SAMOUNT_DESC",'SCROLLAMOUNT sets the size in pixels of each jump. A higher value for SCROLLAMOUNT makes the marquee scroll faster. The default value is 6');
define("_MI_GALLERY_MARQUEE_SDELAY","Marquee Scroll Delay");
define("_MI_GALLERY_MARQUEE_SDELAY_DESC",'SCROLLDELAY sets the amount of delay in milliseconds (a millisecond is 1/1000th of a second). The default delay is 85');
define("_MI_GALLERY_DATEADDED","Show Date Added");
define("_MI_GALLERY_DATEADDED_DESC","If set to yes will show when a collection was added");
define("_MI_GALLERY_MARQUEE_UP","Up");
define("_MI_GALLERY_MARQUEE_DOWN","Down");
define("_MI_GALLERY_MARQUEE_LEFT","Left");
define("_MI_GALLERY_MARQUEE_RIGHT","Right");
define("_MI_GALLERY_WATERMARK","Show Watermark");
define("_MI_GALLERY_WATERMARK_DESC","If enabled a watermark will display on your image. Watermark will not show on Full Sized View or Thumbnails.");
define("_MI_GALLERY_TEXTWATERMARK","Watermark Text");
define("_MI_GALLERY_TEXTWATERMARK_DESC","Text that will appear as a watermark on your images.");
define("_MI_GALLERY_FULLVIEW","Show Full Sized");
define("_MI_GALLERY_FULLVIEW_DESC","If enabled the visitor will have the options to see a full size view of the image.");
define("_MI_GALLERY_WATERMARKSIZE","Watermark Font Size");
define("_MI_GALLERY_WATERMARKSIZE_DESC","Specify the font size for watermark text. (1 < 5)");
define("_MI_GALLERY_WATERMARKSIZE1","1");
define("_MI_GALLERY_WATERMARKSIZE2","2");
define("_MI_GALLERY_WATERMARKSIZE3","3");
define("_MI_GALLERY_WATERMARKSIZE4","4");
define("_MI_GALLERY_WATERMARKSIZE5","5");
define("_MI_GALLERY_SHOWHITS","Show Catalog Hits");
define("_MI_GALLERY_SHOWHITS_DESC","If enabled will show the number of time a particular catalog was accessed.");
define("_MI_GALLERY_LATESTTXT", "Latest Gallery Collections");
define("_MI_GALLERY_LATEST", "Show Latest Collection");
define("_MI_GALLERY_LATEST_DESC", "If set to yes, will show the latest collection in the gallery, else will show all the first level collections");
define("_MI_GALLERY_DIRFILEERROR", "Invalid folder or file");
define("_MI_GALLERY_TIMELIMIT", "Set Execution Time");
define("_MI_GALLERY_TIMELIMIT_DESC", "This temporarily sets the execution time for php in seconds (Default is 30sec). This is used for sites that have a lot of images where 30 seconds isn't enough to generate thumbnails. Set the number in seconds or 0 for unlimited. If php is in safe mode, this does not work.");
define("_MI_GALLERY_EFFECT", "Thumbnail Effect");
define("_MI_GALLERY_EFFECT_DESC", "Allows you to specify the effect to use on the thumbnails.");
define("_MI_GALLERY_EFFECT_SB", "ShadowBox");
define("_MI_GALLERY_EFFECT_LB", "LightBox 2");
define("_MI_GALLERY_EFFECT_WB", "WeeBox");
define("_MI_GALLERY_EFFECT_WIN", "LightWindow");
define("_MI_GALLERY_EFFECT_FACE", "FaceBox");
define("_MI_GALLERY_EFFECT_FANCY", "FancyBox");
define("_MI_GALLERY_EFFECT_PRETTY", "PrettyPhoto");
define("_MI_GALLERY_SHOWSUBMENU", "Show submenu");
define("_MI_GALLERY_SHOWSUBMENU_DESC", "If yes, will show a submenu of categories under main menu.");
define("_MI_GALLERY_THUMB_ADD", "Thumbnail Cache Path");
define("_MI_GALLERY_THUMB_ADD_DESC", "Directory where your thumbnails will be stored.");
define("_MI_GALLERY_BAN_THUMB", "Banner Directory Path");
define("_MI_GALLERY_BAN_THUMB_DESC", "Directory where your banners are stored.");
define("_MI_GALLERY_SHOWBANNERS", "Show Banners");
define("_MI_GALLERY_SHOWBANNERS_DESC", "If set to yes will show banners.");
define("_MI_GALLERY_CATBANNERS", "Show Banners from Categories");
define("_MI_GALLERY_CATBANNERS_DESC", "If set to yes will show use Category banners if Collection don't have banners");
define("_MI_GALLERY_BANNERWIDTH", "Banner Width");
define("_MI_GALLERY_BANNERWIDTH_DESC", "Width you want the banners displayed at");
define("_MI_GALLERY_ENABLEERRREP", "Enable Error Reporting");
define("_MI_GALLERY_ENABLEERRREPDSC", "If set to yes will print out errors and notices.");

// RSS Items
define('_MI_GALLERY_RSSENABLE', 'Enable RSS Feed');
define('_MI_GALLERY_RSSENABLEDSC', 'If set to yes will enable RSS feeds');
define('_MI_GALLERY_RSSLINKS', 'RSS New Links');
define('_MI_GALLERY_RSSLINKSDSC', 'Number of RSS Links to display in feed, maximum is 15 per rss 2.0 specification');
define('_MI_GALLERY_CHANNELCAT', 'Channel Category');
define('_MI_GALLERY_CHANNELCATDSC', 'Specify the category the channel belongs to. Only used when no cid is found, like on the index page.');
define('_MI_GALLERY_CHANNELDOCS', 'Channel Docs');
define('_MI_GALLERY_CHANNELDOCSDSC', 'A URL that points to the documentation for the format used in the RSS file.');

// Admin Variables
define("_AM_GALLERY_OPS", "Main");
define("_AM_GALLERY_LISTBANNADS", "Gallery Banners");
define("_AM_GALLERY_LISTSTATS","Gallery Hits");
define("_AM_GALLERY_RESETSTATS", "Reset Gallery Hits");
define("_AM_GALLERY_DELSTATS", "Delete Gallery Hits");
define("_AM_GALLERY_UPDATTHUMBS", "New Collections");
define("_AM_GALLERY_LISTCOLLECTION", "Collections");
define("_AM_GALCONFUPDATE", "Confirm Update");
define("_AM_GALLERY_UPDATE", "Update");
define("_AM_GALLERY_OVERWRITE", "Overwrite");
define("_AM_GALOVERWRITEEXIST", "Overwrite Existing Thumbnails");
define("_AM_GALUPDATED", "thumbnail(s) updated...");
define("_AM_GALLERY_SETPERM", "Permissions");
define("_AM_GALLERYPERM", "Gallery Permissions");
define("_AM_GALLERYPERMDEL", "Remove Permissions");
define("_AM_GALLERYPERMDESC", "Select the collections that each group is allowed to view");
define("_AM_GALLERY_GENERALSET", "Module Settings");
define("_AM_GALLERY_GOTOMOD", "Go To Module");
define("_AM_GALLERY_MODULEADMIN", "Module Admin");
define("_AM_GALLERY_HELP", "Help");
define("_AM_GALLERY_ABOUT", "About");
define("_AM_GALLERY_CAT_ID", "ID");
define("_AM_GALLERY_LSCATEGORIES", "Categories");
define("_AM_GALLERY_CAT_NAME", "Gallery Collection");
define("_AM_GALLERY_CAT_DEL", "Delete");
define("_AM_GALLERY_CAT_DELFAIL", "Error deleting permissions");
define("_AM_GALLERY_CAT_DELSUCC", "Permissions deleted successfully");
define("_AM_GALLERY_BY", "By");
define("_AM_GALLERY_AUTHOR_INFO", "Author Information");
define("_AM_GALLERY_AUTHOR_NAME", "Author");
define("_AM_GALLERY_AUTHOR_WEBSITE", "Author's website");
define("_AM_GALLERY_AUTHOR_EMAIL", "Author's email");
define("_AM_GALLERY_AUTHOR_CREDITS", "Credits");

define("_AM_GALLERY_HELPDESC", "<table width='100%' cellspacing='1' cellpadding='3' class='outer'>\n
  <tr class='bg3'>
    <td>Module Settings</td>
  </tr>
  <tr class='bg1'>
    <td><p>This is the configuration menu. This menu allows you to set the gallery location, thumbnail size and executions time.</p>
    <p>Note: Execution time is used only for generating the thumbnails and is only supported if php safe mode is disabled. </p></td>
  </tr>
  <tr class='bg3'>
    <td>Go To Module</td>
  </tr>
  <tr class='bg1'>
    <td>This will take you to the gallery link location.</td>
  </tr>
  <tr class='bg3'>
    <td>Main</td>
  </tr>
  <tr class='bg1'>
    <td>Main menu where you will find server settings.</td>
  </tr>
  <tr class='bg3'>
    <td>Categories</td>
  </tr>
  <tr class='bg1'>
    <td>This menu displays new and current categories in the database. You can modify and delete categories from here. You must add the category before you add the collections in the category else the collection will be assigned to root directory of your gallery.</td>
  </tr>
  <tr class='bg3'>
    <td>Modify Categories</td>
  </tr>
  <tr class='bg1'>
    <td>Here you can modify the Name, Parent, Thumbnail, Banner and description.</td>
  </tr>
  <tr class='bg3'>
    <td>New Collections</td>
  </tr>
  <tr class='bg1'>
    <td>Here you will fine new collections not in the database.</td>
  </tr>
  <tr class='bg3'>
    <td>Collections</td>
  </tr>
  <tr class='bg1'>
    <td>Current collection are found here. You can modify and delete collections on this page.</td>
  </tr>
  <tr class='bg3'>
    <td>Modify Collection</td>
  </tr>
  <tr class='bg1'>
    <td>Here you can modify the Name, Hits, Parent, Banner and Description.</td>
  </tr>
  <tr class='bg3'>
    <td>List Gallery Hits</td>
  </tr>
  <tr class='bg1'>
    <td>This section list the number of hits each section gets. You have the option of deleting these hits or resetting them back to 0.</td>
  </tr>
  <tr class='bg3'>
    <td>Gallery Banners</td>
  </tr>
  <tr class='bg1'>
    <td>This is where the banners are located.</td>
  </tr>
  <tr class='bg3'>
    <td>Modify Banner</td>
  </tr>
  <tr class='bg1'>
    <td>Here you can modify the Name and Link.</td>
  </tr>
  <tr class='bg3'>
    <td>Permissions</td>
  </tr>
  <tr class='bg1'>
    <td>This section allows you to set permissions for the first level collections. Anything inside the first level collections will inherit these permissions.</td>
  </tr>
  <tr class='bg3'>
    <td>Remove Permissions</td>
  </tr>
  <tr class='bg1'>
    <td>This section is used to remove the permissions of first level collections if you delete them from your gallery root directory. If you have hits for first level collections you will also need to go to the List Gallery Hits section and delete these stats. This is by design for people that want to keep their stats for a particular collection.</td>
  </tr>
  <tr class='bg3'>
    <td>Help</td>
  </tr>
  <tr class='bg1'>
    <td>The help page is this page.</td>
  </tr>
  <tr class='bg3'>
    <td>About</td>
  </tr>
  <tr class='bg1'>
    <td>About the author and this module</td>
  </tr>
</table>");
define("_AM_GALLERY_ABOUTDESC", "");
define("_MB_GALLERY_RIMAGES","Shows latest gallery collection");

?>
