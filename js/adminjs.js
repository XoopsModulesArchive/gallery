/**
 * @author optikool
 */
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

jQuery(document).ready(function() {
	jQuery("#newthumb").submit(function() {
		var checked = jQuery("input[id=newcollections]:checked").length;
		var collections = jQuery("input[id=newcollections]:checked");
		var params = new Array();
		//var spath = "";
		//var width = "";
		//var height = "";
		//var tlocal = "";
		jQuery("#respText").html('');
		var curl = "../include/generate.php";
		var proc = "";
		var proccessed = new Array();
		var pos = 0;
		var tr = "";
		var rtext = "";
		
		params = getParams();
				
		jQuery(collections).each(function() {
			overwrite = 0;
			var qstring = "ow=" + overwrite + "&rpath=" + this.value + "&spath=" + params[0] + "&width=" + params[1] + "&height=" + params[2] + "&filter=" + params[3] + "&tpath=" + params[4];
			tr = "#col" + pos;
			rtext = "Processing " + this.value + ".";
			jQuery("#currText").html(rtext);
			jQuery.ajax({
				type:"GET",
				dataType:"json",
				async: false,
				url: "../include/generate.php?" + qstring,
				success: function(data) {					
					jQuery(tr).hide();
					if (pos > 0) {
						proccessed += "&";
					}

					proccessed += pos + "=" + data.coll[1].file
					proc = data.coll[0].proc;
					rtext = "Processed " + proc + " image(s) in " + data.coll[1].file + ".<br />";
					jQuery("#respText").html(rtext);
					pos++;
				},
				error: function(data) {
					jQuery("#respText").html(data);
				}
			});						
		});
		
		
		//jQuery("#respText").html(proccessed);
		//alert(collections.toString());
		//processCollections();
		purl = "../include/proccess.php";
		jQuery.ajax({
			type:"POST",
			dataType:"json",
			data:proccessed,
			async: false,
			url: purl,
			success: function(data) {
				jQuery("#respText").html(data.update[0].updated);
				jQuery("#currText").html(data.update[0].updated);
			}
		});
		
		return false;
	});
	
	jQuery("#gencoll").submit(function() {
		jQuery("#respText").html("");
		params = getParams();
		var rpath = jQuery("input[name='coll_link']").val();
		var overwrite = jQuery('input[name="genimgoverw"]:checked').val();
		var qstring = "ow=" + overwrite + "&rpath=" + rpath + "&spath=" + params[0] + "&width=" + params[1] + "&height=" + params[2] + "&filter=" + params[3] + "&tpath=" + params[4];
			
		jQuery.ajax({
			type:"GET",
			dataType:"json",
			async: false,
			url: "../include/generate.php?" + qstring,
			success: function(data) {				
				proc = data.coll[0].proc;
				rtext = "Processed " + proc + " image(s) in " + data.coll[1].file + ".<br/>";
				jQuery("#respText").html(rtext);					
			},
			error: function(data) {
				jQuery("#respText").html(data);
			}
		});	
		return false;
	});
});	

function getParams() {
	var purl = "../include/getperams.php";
	var params = new Array();
	jQuery.ajax({
		type:"GET",
		dataType:"json",
		async: false,
		url: purl,
		success: function(data) {
			params[0] = data.params[0].rpath;
			params[1] = data.params[0].width;
			params[2] = data.params[0].height;
			params[3] = data.params[0].filter;
			params[4] = data.params[0].tlocal;
		}
	});
	return params;
}
