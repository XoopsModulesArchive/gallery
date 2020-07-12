WBoxOptions = Object.extend({    
    loadingImage: "images/loader.gif",
	dataBackColor:"#666666",
	overlayColor: "#000000",
	borderColor: "#FFFFFF",
	overlayOpacity: 0.5,
    resizeSpeed: 5, 
    borderSize: 2, 
	dataHeight: 30,
	enableSlidey: true,
	slideyDelay: 3000,
	dataDisplay: "top" // top or bottom
}, window.WBoxOptions || {});

var WBox = Class.create();

WBox.prototype = {

	imageArray: [],
	sliding: false,
	doSlidey: false,
	slideInt: null,
	

	initialize: function() 
	{
		this.updateImageList();		
		if (WBoxOptions.resizeSpeed > 10) WBoxOptions.resizeSpeed = 10;
        if (WBoxOptions.resizeSpeed < 1)  WBoxOptions.resizeSpeed = 1;
	    this.resizeDuration = (11 - WBoxOptions.resizeSpeed) * 0.15;
	    this.overlayDuration = 0.2;				
		var objBody = $$("body")[0];
		objBody.appendChild(Builder.node("div",{id:"overlay"}));		
		objBody.appendChild(Builder.node("div",{id:"wbox_wrapper"}));				
			
		if (WBoxOptions.dataDisplay == "top")
		{			
			$("wbox_wrapper").appendChild(Builder.node("div",{id:"wbox_data"},[
				Builder.node("div",{id:"data_wrapper" },[
					Builder.node("div",{id:"controls" },[					
						Builder.node("a",{id:"slideLink", href: "javascript:void(0);", title: "Slidey!" }),
						Builder.node("a",{id:"prevLink", href: "javascript:void(0);", title: "Previous!" }),						
						Builder.node("a",{id:"nextLink", href: "javascript:void(0);", title: "Next!" }),
						Builder.node("a",{id:"closeLink", href: "javascript:void(0);", title: "close!" })
					]),
					Builder.node("div",{id:"info" })
				])
			]));
		}	
		
		$("wbox_wrapper").appendChild(Builder.node("div",{id:"wbox"},[
			Builder.node("div",{id:"wbox_content"},[
				 Builder.node("img",{id:"wboxImage"})
			]), 
			Builder.node("div",{id:"loading"}, 
				Builder.node("img", {src: WBoxOptions.loadingImage})
			)
		]));
		
		if (WBoxOptions.dataDisplay == "bottom")
		{
			$("wbox_wrapper").appendChild(Builder.node("div",{id:"wbox_data"},[
				Builder.node("div",{id:"data_wrapper" },[
					Builder.node("div",{id:"controls" },[					
						Builder.node("a",{id:"slideLink", href: "javascript:void(0);", title: "Slidey!" }),
						Builder.node("a",{id:"prevLink", href: "javascript:void(0);", title: "Previous!" }),						
						Builder.node("a",{id:"nextLink", href: "javascript:void(0);", title: "Next!" }),
						Builder.node("a",{id:"closeLink", href: "javascript:void(0);", title: "close!" })
					]),
					Builder.node("div",{id:"info" })
				])
			]));
		}		
		
		$("overlay").setStyle({ backgroundColor: WBoxOptions.overlayColor });		
		$("overlay").hide().observe("click", (function() { this.end(); }).bind(this));			
		$("wbox_wrapper").hide().observe("click", (function(event) { if (event.element().id == "wbox_wrapper") this.end(); }).bind(this));
		$("wbox").hide().observe("click", (function(event) { this.end(); }).bind(this));
		
		$("closeLink").hide().observe("click", (function(event) { this.end(); }).bind(this));
		
		if (WBoxOptions.enableSlidey == true)
			$("slideLink").hide().observe("click", (function(event) { 
				--this.activeImage;
				this.slidey(); 
			}).bind(this));
		else
			$("slideLink").hide();
			
		$("wbox_data").hide();	
	
		$("wbox_content").setStyle({padding:WBoxOptions.borderSize + "px"});		
		$("prevLink").observe("click", (function(event) { event.stop(); this.changeImage(this.activeImage - 1); }).bindAsEventListener(this));
		$("nextLink").observe("click", (function(event) { event.stop(); this.changeImage(this.activeImage + 1); }).bindAsEventListener(this));	
	
		$("wbox").setStyle({ backgroundColor: WBoxOptions.borderColor });
		
		iHeight = WBoxOptions.dataHeight - WBoxOptions.borderSize;
		$("info").setStyle({ lineHeight: iHeight + "px" });	
		if (WBoxOptions.dataDisplay == "top")
			$("controls").setStyle({ top: WBoxOptions.borderSize + "px", right: WBoxOptions.borderSize + "px" });		
		else
			$("controls").setStyle({ top: "0px", right: WBoxOptions.borderSize + "px" });	
	},
	
	updateImageList: function() {   
        this.updateImageList = Prototype.emptyFunction;
        document.observe("click", (function(event){
            var target = event.findElement("a[rel^=wbox]") || event.findElement("area[rel^=wbox]");
            if (target) {
                event.stop();
                this.begin(target);
            }
			var target = event.findElement("a[rel^=slidey]") || event.findElement("area[rel^=slidey]");
			if (target) {
                event.stop();
                this.beginSlidey(target);
            }
        }).bind(this));
    },
	
	beginSlidey: function(imageLink)
	{
		this.sliding = true;
		this.begin(imageLink);
	},
	
	begin: function(imageLink) 
	{
		$$("select", "object", "embed").each(function(node){ node.style.visibility = "hidden" });		
		
		$("wbox").setStyle({ width: "32px", height: "32px"});
		$("wbox_data").setStyle({ width: "32px", height: "32px"});
		
		var arrayPageSize = this.getPageSize();
        $("overlay").setStyle({ width: arrayPageSize[0] + "px", height: arrayPageSize[1] + "px" });				
		this.imageArray = [];
        var imageNum = 0;   
        if ((imageLink.rel == "lightbox")){
            this.imageArray.push([imageLink.href, imageLink.title]);         
        } else {
            this.imageArray = 
                $$(imageLink.tagName + "[href][rel=\"" + imageLink.rel + "\"]").
                collect(function(anchor){ return [anchor.href, anchor.title]; }).uniq();            
            while (this.imageArray[imageNum][0] != imageLink.href) { imageNum++; }
        }		
		var arrayPageScroll = document.viewport.getScrollOffsets();
        var wboxTop = arrayPageScroll[1] + (document.viewport.getHeight() / 10);
        var wboxLeft = arrayPageScroll[0];		
		new Effect.Appear("overlay", { duration: this.overlayDuration, from: 0.0, to: WBoxOptions.overlayOpacity, afterFinish: function(){
			$("wbox_data").setStyle({ top: wboxTop + "px", left: wboxLeft + "px" });			
			$("wbox").setStyle({ top: wboxTop + "px", left: wboxLeft + "px" }).show();
			$("wbox_wrapper").show();
			myWBox.changeImage(imageNum);
		}});		
	},
	
	slidey: function()
	{
		this.sliding = true;	
		++this.activeImage;		
		if (this.activeImage > (this.imageArray.length - 1)) this.activeImage = 0;		
		this.changeImage(this.activeImage);
	},
	
	endSlidey: function()
	{
		clearTimeout(this.slideInt);
		this.sliding = false;
		this.doSlidey = false;		
	},	
	
	changeImage: function(imageNum)
	{
		this.activeImage = imageNum;
		$("loading").show();
		$("wboxImage").hide();
		$("wbox_data").hide();
		$("controls").hide();
		$("prevLink").hide();
		$("nextLink").hide();		
		$("info").hide();
		$("slideLink").hide();		
		$("closeLink").show();	
		
		
		if (this.activeImage > 0) $("prevLink").show();	
		if (this.activeImage < (this.imageArray.length - 1)) $("nextLink").show();	
	
		if (this.imageArray.length > 1)
		{
			$("slideLink").show();
		}			
		var imgPreloader = new Image();        
        imgPreloader.onload = (function(){
            $("loading").hide();
			$("wboxImage").src = this.imageArray[this.activeImage][0];
            this.resizeImageContainer(imgPreloader.width, imgPreloader.height);

        }).bind(this);
        imgPreloader.src = this.imageArray[this.activeImage][0];
	},
	
    resizeImageContainer: function(imgWidth, imgHeight) {
        // get current width and height
        var widthCurrent  = $("wbox").getWidth();
        var heightCurrent = $("wbox").getHeight();
        // get new width and height
        var widthNew  = (imgWidth  + WBoxOptions.borderSize * 2);
        var heightNew = (imgHeight + WBoxOptions.borderSize * 2);
        // scalars based on change from old to new
        var xScale = (widthNew  / widthCurrent)  * 100;
        var yScale = (heightNew / heightCurrent) * 100;
        // calculate size difference between new and old image, and resize if necessary
        var wDiff = widthCurrent - widthNew;
        var hDiff = heightCurrent - heightNew;
        if (hDiff != 0) new Effect.Scale("wbox", yScale, {scaleX: false, duration: this.resizeDuration}); 
        if (wDiff != 0) new Effect.Scale("wbox", xScale, {scaleY: false, duration: this.resizeDuration}); 		
		var dataWidth = widthNew - WBoxOptions.borderSize * 2;	
		var dataH =WBoxOptions.dataHeight - WBoxOptions.borderSize;	
		$("wbox_data").setStyle({width: widthNew+"px",height:WBoxOptions.dataHeight+"px"});					
		$("data_wrapper").setStyle({width:dataWidth+"px",height:dataH+"px",backgroundColor:WBoxOptions.dataBackColor});
		if (WBoxOptions.dataDisplay == "top")
			$("data_wrapper").setStyle({borderLeft:WBoxOptions.borderSize + "px solid "+WBoxOptions.borderColor, borderRight:WBoxOptions.borderSize + "px solid "+WBoxOptions.borderColor,borderTop:WBoxOptions.borderSize + "px solid "+WBoxOptions.borderColor})
		else
			$("data_wrapper").setStyle({borderLeft:WBoxOptions.borderSize + "px solid "+WBoxOptions.borderColor,borderRight:WBoxOptions.borderSize + "px solid "+WBoxOptions.borderColor,borderBottom:WBoxOptions.borderSize + "px solid "+WBoxOptions.borderColor})
             
		this.showImage();		
    },
	
    showImage: function(){		
		this.doSlidey = (this.sliding && WBoxOptions.enableSlidey);		
        new Effect.Appear("wboxImage", { 
            duration: this.resizeDuration, 
            queue: "end",
			afterFinish: function()
			{				
				if (myWBox.doSlidey == true)
					myWBox.slideInt = setTimeout("myWBox.slidey()",WBoxOptions.slideyDelay);
				else
					myWBox.showData();
			}
        });
		this.preloadNeighborImages();
    },	
	
	showData: function()
	{
        if (this.imageArray[this.activeImage][1] != "")
            $("info").update(this.imageArray[this.activeImage][1]).show();	
		
		Effect.SlideDown("wbox_data",{ 
			afterFinish: function()
			{				
				$("info").appear();
				$("controls").appear();
			}
		});
	},
	
	preloadNeighborImages: function(){
        var preloadNextImage, preloadPrevImage;
        if (this.imageArray.length > this.activeImage + 1){
            preloadNextImage = new Image();
            preloadNextImage.src = this.imageArray[this.activeImage + 1][0];
        }
        if (this.activeImage > 0){
            preloadPrevImage = new Image();
            preloadPrevImage.src = this.imageArray[this.activeImage - 1][0];
        }
    
    },
	
	end: function()
	{
		this.endSlidey();
		new Effect.Fade("overlay", { duration: this.overlayDuration });
		new Effect.Fade("wbox_wrapper", { duration: this.overlayDuration });
		$$("select", "object", "embed").each(function(node){ node.style.visibility = "visible" });
	},
	
	getPageSize: function() {
	        
	    var xScroll, yScroll;
		
		if (window.innerHeight && window.scrollMaxY) {	
			xScroll = window.innerWidth + window.scrollMaxX;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}		
		var windowWidth, windowHeight;		
		if (self.innerHeight) {	// all except Explorer
			if(document.documentElement.clientWidth){
				windowWidth = document.documentElement.clientWidth; 
			} else {
				windowWidth = self.innerWidth;
			}
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}		
		// for small pages with total height less then height of the viewport
		if(yScroll < windowHeight){
			pageHeight = windowHeight;
		} else { 
			pageHeight = yScroll;
		}	
		// for small pages with total width less then width of the viewport
		if(xScroll < windowWidth){	
			pageWidth = xScroll;		
		} else {
			pageWidth = windowWidth;
		}
		return [pageWidth,pageHeight];
	}	
}

document.observe("dom:loaded", function () { myWBox = new WBox(); });