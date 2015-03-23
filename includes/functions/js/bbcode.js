
(function($) {

	$.fn.youtubeFind = function() {
		var pattern = /\[youtube=(https?:\/\/)?www\.youtube\.com\/watch\?v=([a-zA-Z0-9])(.*)\]/g;
		var matched = $(this).html().match(pattern);
		var currElementID = "#"+$(this).attr("id");
		//console.log(matched.length);
		//console.log(matched[0]);
		$.each(matched, function(index, value) {
			$.fn.youtubeReplace(value, currElementID);
		});
	}
	
	$.fn.youtubeReplace = function(tag, elementID) {
	    //console.log(tag);
        //console.log(elementID);
        // find values
	    var pattern = /v=[a-zA-Z0-9]+/;
	    var youtubeFile = tag.match(pattern);
	    pattern = /w=[0-9]+/;
	    var width = tag.match(pattern);
	    pattern = /h=[0-9]+/;
	    var height = tag.match(pattern);
	    // assign proper values
	    youtubeFile = youtubeFile[0].replace("v=","");
		if (width) {
			width = parseInt(width[0].replace("w=",""));
			if (height)
				height = parseInt(height[0].replace("h=",""));
			else
				height = Math.ceil(width * 9/16);
		}
		else if (height) {
			height = parseInt(height[0].replace("h=",""), 10)
			if (width)
				width = parseInt(width[0].replace("w=",""), 10);
				else
					width = Math.ceil(height * 16/9);
		}
		else {
			height = 360;
			width = 640;
		}
		// insert youtube frame
		var extraParams = "?version=3&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1&wmode=transparent";
		var frameSrc = "http://www.youtube.com/embed/"+youtubeFile+extraParams;
		var iframeCode = "<iframe width="+width+" height="+height+" src="+frameSrc+" frameborder=0 allowfullscreen></iframe>";
		var htmlCode = $(elementID).html().replace(tag, iframeCode);
		$(elementID).html(htmlCode);
		
		//console.log($(elementID).html());
	    //console.log(youtubeFile);
	    //console.log(width);
	    //console.log(height);
	    //console.log(frameSrc);
	    //console.log(iframeCode);
	}
})(jQuery);



(function($) {

	$.fn.youtubeFind2 = function(haystack) {
		var pattern = /\[youtube=(https?:\/\/)?www\.youtube\.com\/watch\?v=([a-zA-Z0-9])(.*)\]/g;
		var matched = haystack.match(pattern);
		//console.log(matched.length);
		//console.log(matched[0]);
		$.each(matched, function(index, value) {
			return $.fn.youtubeReplace(value, haystack);
		});
	}
	
	$.fn.youtubeReplace2 = function(tag, haystack) {
	    //console.log(tag);
        //console.log(elementID);
        // find values
	    var pattern = /v=[a-zA-Z0-9]+/;
	    var youtubeFile = tag.match(pattern);
	    pattern = /w=[0-9]+/;
	    var width = tag.match(pattern);
	    pattern = /h=[0-9]+/;
	    var height = tag.match(pattern);
	    // assign proper values
	    youtubeFile = youtubeFile[0].replace("v=","");
		if (width) {
			width = parseInt(width[0].replace("w=",""));
			if (height)
				height = parseInt(height[0].replace("h=",""));
			else
				height = Math.ceil(width * 9/16);
		}
		else if (height) {
			height = parseInt(height[0].replace("h=",""), 10)
			if (width)
				width = parseInt(width[0].replace("w=",""), 10);
				else
					width = Math.ceil(height * 16/9);
		}
		else {
			height = 360;
			width = 640;
		}
		// insert youtube frame
		var extraParams = "?version=3&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1&wmode=transparent";
		var frameSrc = "http://www.youtube.com/embed/"+youtubeFile+extraParams;
		var iframeCode = "<iframe width="+width+" height="+height+" src="+frameSrc+" frameborder=0 allowfullscreen></iframe>";
		var htmlCode = haystack.replace(tag, iframeCode);
		return htmlCode;
		//$(elementID).html(htmlCode);
		
		//console.log($(elementID).html());
	    //console.log(youtubeFile);
	    //console.log(width);
	    //console.log(height);
	    //console.log(frameSrc);
	    //console.log(iframeCode);
	}
})(jQuery);