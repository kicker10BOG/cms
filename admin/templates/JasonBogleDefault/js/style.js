// JavaScript Document

(function($) {
	$.fn.SetMargins = function() {
		if ($.trim($("#leftbar").html()) == ""){
			$("#maincontent").css("margin-left", "0");
			//$("#leftbar").width(0);
			//$("#leftbar").height(0);
		}
		if ($.trim($("#rightbar").html()) == ""){
			$("#maincontent").css("margin-right", "0");
			//$("#rightbar").width(0);
			//$("#rightbar").height(0);
		}
		/*
		console.log($.trim($("#leftbar").html()));
		console.log($("#maincontent").css("margin-left"));
		console.log($("#rightbar").width());
		console.log($("#maincontent").css("margin-right"));
		//*/
	}
})(jQuery);