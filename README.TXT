If you find any bugs please post on the Xoops forums or send a comment from my website (http://www.optikool.com/modules/liaise/).

Gallery
Gallery module allows your to upload images directly or in sub folders to your website and generate the thumbnails for these images in the administration section. It's not necessary for you to resize the images but you should use a batch conversion program such as FastStone Image Viewer (free from download.com) to process the images for the web. Know one is going to sit and wait for a 1 megabyte image that you shot on your digital camera.

About lightbox effects
There are three different lightbox effects (Lightbox 2, Shadowbox, Weebox) that you can choose from. Currently only Shadowbox will resize images to fit the viewing screen. This may be a problem for users that have large images on their website and their audience's screen have smaller screen size. It is recommend you use the Shadowbox effect if you have different size images. If lightbox 2 and Weebox, or some other effect decide to use jquery I will update the two effects to take advantage of those effects.

About renaming the gallery folder
If you rename the gallery folder, you must also rename the $modversion['dirname'] value in xoops_version.php and also "Module Directory" in the admin menu.

About Categories and Collections
This is a very simple module in that categories are considered empty folders and collections are considered folders with images. In order to create a category you must create a folder and put your collection folders that belong in that category inside the empty category folder. The module will then find the empty category folders and display them so you can add in the admin section. You could then go in and modify this category. When you go to the new collection tab you will see all of the collections and when you click the add button they will be added to the database and will be assigned to the category based on the folder the collection is in on the server. You can at a later time go in and modify the category for this collection.

But here is an example of what the folder structure could look like on your server...

gallery (folder of the root for your gallery)
  |_ Animals (category if folder has no images)
    |_ Cats (collection if images are in this folder)
    |_ Dogs (collection if images are in this folder)
  |_ Trees (category if folder has no images)
    |_ Winter Trees (collection if images are in this folder)
    |_ Summer Trees (collection if images are in this folder)
    |_ Trees in the Spring (collection if images are in this folder)
  |_ Me (collection if images are in this folder)

About JS files
If you do not have jQuery currently in your template you can add the following code to make it easier to insure this service is available.
<script type="text/javascript" src="<{$xoops_url}>/modules/gallery/js/jquery.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/gallery/js/jquery.json-1.3.js"></script>

About cache folder
This is where your thumbnails will be created. This directory must be set to 777 or 666 so that the thumbnails can be created if you create these directories yourself. This folder will be created when you install the module and will be deleted when you uninstall.

About Banners folder
This is where your banners are located. This directory must be set to 777 or 666 so that the thumbnails can be created if you create these directories yourself. This folder will be created when you install the module and will be deleted when you uninstall.

Updating
Replace the contents of your gallery folder except for the cache folder and run the update.


 

