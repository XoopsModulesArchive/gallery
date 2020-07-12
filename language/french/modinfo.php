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

define("_MI_GALLERY_NAME","Galerie");
define("_MI_GALLERY_DESC","Galeries de photos pour Xoops");
define("_MI_GALLERY_RDESC","Afficher les cinq dernières galeries");
define("_MI_GALLERY_BNAME1","Galerie");
define("_MI_GALLERY_BNAME2","Collections récentes");
define("_MI_GALLERY_BNAME3","Collections les plus vues");
define("_MI_GALLERY_BREADCRUMB", "Séparateur des liens dans le fil d'Ariane");
define("_MI_GALLERY_BREADCRUMB_DESC", "Il est recommandé d'utiliser une entité html.");
define("_MI_GALLERY_CATEGORIES", "Bloc affichant les Catégories.");
define("_MI_GALLERY_RIMAGES", "Bloc affichant les collections au hasard.");
define("_MI_GALLERY_MOSTVIEWED", "Bloc affichant les collections les plus consultées.");
define("_MI_GALLERY_COLLNOTFOUND", "Collection non trouvée.");
define("_MI_GALLERY_COLLEMPTY", "Collection vide.");
define("_MI_GALLERY_GAL_ADD","Répertoire de galeries");
define("_MI_GALLERY_GAL_ADD_DESC","Dossier des galleries (emplacement des images et des dossiers d'images)");
define("_MI_GALLERY_MODDIR","Dossier du module");
define("_MI_GALLERY_MODDIR_DESC","Répertoire contenant le module. Par défaut il s'agit de <b>gallery</b>.");
define("_MI_GALLERY_RECTOTAL","Affichages récents");
define("_MI_GALLERY_RECTOTAL_DESC","Nombre d'images des collections récentes à afficher.");
define("_MI_GALLERY_EXCL_FOLD","Dossier à exclure");
define("_MI_GALLERY_EXCL_FOLD_DESC","Les dossiers que vous souhaitez exclure sont à séparer par une virgule (ex. dossier1,dossier2,dossier3");
define("_MI_GALLERY_IMG_PER_PAGE","Nombre de vignettes à afficher sur chaque page");
define("_MI_GALLERY_IMG_PER_PAGE_DESC","");
define("_MI_GALLERY_PICTWTH","Largeur");
define("_MI_GALLERY_PICTWTH_DESC","Largeur en pixels de l'image exprimée en pixels.");
define("_MI_GALLERY_PICTHI","Hauteur");
define("_MI_GALLERY_PICTHI_DESC","Hauteur de l'image exprimée en pixels (paramètre non utilisé pour le moment).");
define("_MI_GALLERY_LOADJQUERY", "Charger Jquery");
define("_MI_GALLERY_LOADJQUERY_DESC", "Si vous indiquez Oui, la librairie JQuery sera chargée par le module. Si votre thème emploie déjà JQquery, indiquez Non.");
define("_MI_GALLERY_SHOWALL", "Afficher toutes les Catégories");
define("_MI_GALLERY_SHOWALL_DESC", "Si vous indiquez Oui, le module génèrera automatiquement une pagination pour accéder à l'ensemble des Catégories.");
define("_MI_GALLERY_PICTINFWTH","Information Largeur de l'image");
define("_MI_GALLERY_PICTINFWTH_DESC","La largeur de l'image à afficher sur la page d'information.");
define("_MI_GALLERY_PICINFTHI","Information Hauteur de l'image");
define("_MI_GALLERY_PICINFTHI_DESC","La hauteur de l'image à afficher sur la page d'information (paramètre non utilisé pour le moment).");

define("_MI_GALLERY_THUMBWTH","Largeur de la vignette");
define("_MI_GALLERY_THUMBWTH_DESC","Largeur de la vignette exprimée en pixels.");
define("_MI_GALLERY_THUMBHI","Hauteur de la vignette");
define("_MI_GALLERY_THUMBHI_DESC","Hauteur de la vignette exprimée en pixels (paramètre non utilisé pour le moment).");
define("_MI_GALLERY_F_COLS","Alignement vertical des vignettes");
define("_MI_GALLERY_F_COLS_DESC","Indiquez le nombre de colonnes devant composer le tableau des vignettes.");
define("_MI_GALLERY_THUMB_COLS","Alignement vertical des Collections");
define("_MI_GALLERY_THUMB_COLS_DESC","Indiquez le nombre de colonnes devant composer le tableau des Collections.");
define("_MI_GALLERY_GENERALCONF","Préférences");
define("_MI_GALLERY_MARQUEE","Activer les marquee");
define("_MI_GALLERY_GENFILTER","Générateur de filtres");
define("_MI_GALLERY_GENFILTER_DESC","Filtres utilisé par le générateur de vignettes. Séparer chaque filtre avec un caractère pipe | et sans espace");
define("_MI_GALLERY_MARQUEE_DESC","Activer ou désactiver la fonction de défilement (marquee) pour les images récentes");
define("_MI_GALLERY_MARQUEE_DIRECTION","Direction du défilement");
define("_MI_GALLERY_MARQUEE_DIRECTION_DESC","Haut, Bas, Gauche, Droite");
define("_MI_GALLERY_MARQUEE_WIDTH","Largeur du cadre de défilement");
define("_MI_GALLERY_MARQUEE_WIDTH_DESC","Indiquez la largeur du cadre de défilement, exprimée en pixels");
define("_MI_GALLERY_MARQUEE_HEIGHT","Hauteur du cadre de défilement");
define("_MI_GALLERY_MARQUEE_HEIGHT_DESC","Indiquez la hauteur du cadre de défilement, exprimée en pixels");
define("_MI_GALLERY_MARQUEE_SAMOUNT","Encombrement du défilement");
define("_MI_GALLERY_MARQUEE_SAMOUNT_DESC","Indiquez l'encombrement des zones défilant à l'intérieur du cadre. Si cette dimension excède celle du cadre, le défilement sera accéléré. La valeur par défaut est 6");
define("_MI_GALLERY_MARQUEE_SDELAY","Vitesse du défilement");
define("_MI_GALLERY_MARQUEE_SDELAY_DESC","Exprimée en miliseconde (0.0001 = 1 seconde). La valeur par défaut est 85");
define("_MI_GALLERY_DATEADDED","Afficher la date d'ajout");
define("_MI_GALLERY_DATEADDED_DESC","Si vous indiquez oui, la date de création de la Collection sera affichée");
define("_MI_GALLERY_MARQUEE_UP","Haut");
define("_MI_GALLERY_MARQUEE_DOWN","Bas");
define("_MI_GALLERY_MARQUEE_LEFT","Gauche");
define("_MI_GALLERY_MARQUEE_RIGHT","Droite");
define("_MI_GALLERY_WATERMARK","Affiche un filigrane");
define("_MI_GALLERY_WATERMARK_DESC","Si vous avctivez la fonction filigrane, celui-ci sera présent sur les images mais absent des miniatures et des images grand format.");
define("_MI_GALLERY_TEXTWATERMARK","Texte du filigrane");
define("_MI_GALLERY_TEXTWATERMARK_DESC","Saisir le texte du filigrane.");
define("_MI_GALLERY_FULLVIEW","Afficher les Grands formats");
define("_MI_GALLERY_FULLVIEW_DESC","Si vous indiquez Oui, les visiteurs auront la possibilité de visualiser les images en grand format.");
define("_MI_GALLERY_WATERMARKSIZE","Taille du filigrane");
define("_MI_GALLERY_WATERMARKSIZE_DESC","Indiquez la taille des caractères du filigrane (5 est la plus grande dimension)");
define("_MI_GALLERY_WATERMARKSIZE1","1");
define("_MI_GALLERY_WATERMARKSIZE2","2");
define("_MI_GALLERY_WATERMARKSIZE3","3");
define("_MI_GALLERY_WATERMARKSIZE4","4");
define("_MI_GALLERY_WATERMARKSIZE5","5");
define("_MI_GALLERY_SHOWHITS","Afficher le compteur des catalogues");
define("_MI_GALLERY_SHOWHITS_DESC","Si vous indiquez Oui, vous disposerez d'un décompte des accès aux différents Catalogues.");
define("_MI_GALLERY_LATESTTXT", "Dernières Collections");
define("_MI_GALLERY_LATEST", "Afficher les dernières Collections");
define("_MI_GALLERY_LATEST_DESC", "Si vous indiquez Oui, les dernières collections seront affichées. Dans le cas contraire, les Collections de premier niveau seront affichées.");
define("_MI_GALLERY_DIRFILEERROR", "Dossier ou fichier invalide");
define("_MI_GALLERY_TIMELIMIT", "Définir le temps d'exécution");
define("_MI_GALLERY_TIMELIMIT_DESC", "Cette option permet d'agir sur le délais d'exécution de PHP (par défaut 30 secondes). Cette option est à utiliser pour les sites disposant d'un nombre très important d'images et pour lesquels un délais de 30 secondes s'avère insuffisant pour générer l'ensemble des vignettes. Indiquez une valeur précises ou bien 0 pour exécuter la requête sans limitation de délais. Cette option est inefficiente si PHP est configuré en SAFE MODE.");
define("_MI_GALLERY_EFFECT", "Effet des vignettes");
define("_MI_GALLERY_EFFECT_DESC", "Cette option vous permet de choisir l'effet à appliquer sur les vignettes.");
define("_MI_GALLERY_EFFECT_SB", "ShadowBox");
define("_MI_GALLERY_EFFECT_LB", "LightBox 2");
define("_MI_GALLERY_EFFECT_WB", "WeeBox");
define("_MI_GALLERY_EFFECT_WIN", "LightWindow");
define("_MI_GALLERY_EFFECT_FACE", "FaceBox");
define("_MI_GALLERY_EFFECT_FANCY", "FancyBox");
define("_MI_GALLERY_EFFECT_PRETTY", "PrettyPhoto");
define("_MI_GALLERY_SHOWSUBMENU", "Afficher le sous-menu");
define("_MI_GALLERY_SHOWSUBMENU_DESC", "Si vous indiquez Oui, les sous-catégories apparaîtront sous le menu principal.");
define("_MI_GALLERY_THUMB_ADD", "Chemin d'accès au cache des vignettes");
define("_MI_GALLERY_THUMB_ADD_DESC", "Chemin d'accès au dossier collectant les fichiers de cache des vignettes.");
define("_MI_GALLERY_BAN_THUMB", "Chemin d'accès au dossier des bannières");
define("_MI_GALLERY_BAN_THUMB_DESC", "Chemin d'accès au dossier contenant les bannières.");
define("_MI_GALLERY_SHOWBANNERS", "Afficher les bannières");
define("_MI_GALLERY_SHOWBANNERS_DESC", "Si vous indiquez Oui, les bannières seront affichées.");
define("_MI_GALLERY_CATBANNERS", "Show Banners from Categories");
define("_MI_GALLERY_CATBANNERS_DESC", "Si vous indiquez Oui, les bannières provenant des Catégories seront affichées si les Collections en sont dépourvues.");
define("_MI_GALLERY_BANNERWIDTH", "Largeur de la bannière");
define("_MI_GALLERY_BANNERWIDTH_DESC", "Largeur de la bannière exprimée en pixels");

// RSS Items
define("_MI_GALLERY_RSSENABLE", "Activer le fil d'information");
define("_MI_GALLERY_RSSENABLEDSC", "");
define("_MI_GALLERY_RSSLINKS", "Nouveau liens RSS");
define("_MI_GALLERY_RSSLINKSDSC", "Nombre maximum de liens RSS à afficher dans le flux. Le maximum recommandé est 15 pour RSS 2.0");
define("_MI_GALLERY_CHANNELCAT", "Canal de la Catégorie");
define("_MI_GALLERY_CHANNELCATDSC", "Indiquez le canal d'appartenance de la Catégorie. Cette option doit uniquement être utilisée si l'indetifiant (cid) de la Catégorie ne peut être trouvé automatiquement (par exemple sur la page d'accueil).");
define("_MI_GALLERY_CHANNELDOCS", "Documentation du canal");
define("_MI_GALLERY_CHANNELDOCSDSC", "Indiquer une URL pointant sur la documentation relative au format du flux.");

// Admin Variables
define("_AM_GALLERY_OPS", "Index");
define("_AM_GALLERY_LISTBANNADS", "Galerie des bannières");
define("_AM_GALLERY_LISTSTATS","Compteur des galeries");
define("_AM_GALLERY_RESETSTATS", "Réinitialiser le compteur");
define("_AM_GALLERY_DELSTATS", "Effacer le décompte");
define("_AM_GALLERY_UPDATTHUMBS", "Nouvelles collections");
define("_AM_GALLERY_LISTCOLLECTION", "Collections");
define("_AM_GALCONFUPDATE", "Confirmer la mise à jour");
define("_AM_GALLERY_UPDATE", "Mise à jour");
define("_AM_GALLERY_OVERWRITE", "Ecraser");
define("_AM_GALOVERWRITEEXIST", "Ecraser les vignettes existantes");
define("_AM_GALUPDATED", "vignettes mises à jour...");
define("_AM_GALLERY_SETPERM", "Permissions");
define("_AM_GALLERYPERM", "Permissions des Galeries");
define("_AM_GALLERYPERMDEL", "Effacer les permissions");
define("_AM_GALLERYPERMDESC", "Sélectionner les Collections auxquelles chaque Groupe aura accès");
define("_AM_GALLERY_GENERALSET", "Paramètres du module");
define("_AM_GALLERY_GOTOMOD", "Accès au module");
define("_AM_GALLERY_MODULEADMIN", "Administration du module");
define("_AM_GALLERY_HELP", "Aide");
define("_AM_GALLERY_ABOUT", "A propos");
define("_AM_GALLERY_CAT_ID", "ID");
define("_AM_GALLERY_LSCATEGORIES", "Catégories");
define("_AM_GALLERY_CAT_NAME", "Collection de galerie");
define("_AM_GALLERY_CAT_DEL", "Effacer");
define("_AM_GALLERY_CAT_DELFAIL", "Erreur durant la suppression des permissions");
define("_AM_GALLERY_CAT_DELSUCC", "Permissions effacées");
define("_AM_GALLERY_BY", "Par");
define("_AM_GALLERY_AUTHOR_INFO", "Informations à propos de l'auteur");
define("_AM_GALLERY_AUTHOR_NAME", "Auteurr");
define("_AM_GALLERY_AUTHOR_WEBSITE", "Site de l'auteur");
define("_AM_GALLERY_AUTHOR_EMAIL", "Email de l'auteur");
define("_AM_GALLERY_AUTHOR_CREDITS", "Crédits");




define("_AM_GALLERY_ABOUTDESC", "");
define("_MB_GALLERY_RIMAGES","Shows latest gallery collection");

?>