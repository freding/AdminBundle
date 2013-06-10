$(document).ready(function() {
	$("#various1").fancybox({
		 'scrolling'			: 'no',
		 'width'				: 580,
		 'height'				: 161,
		 'padding'				: 0,
		 'onClosed'				: function() {
		 $("#email").hide();
		 $("#insert_email").show();
		}
	});

	$("#various2").fancybox({
		 'scrolling'		: 'no'
	});

	$("#email_form").bind("submit", function() {
		 $("#insert_email").hide();
		 $("#email").show();
		 return false;
	});	

	$("#buttontoclick").click(function() {
		$('<a id="various2" href="#inline2">login action</a>').fancybox({ 
			overlayShow: true 
		}).click(); 
		return false;
	}); 
	
	// png class init
	$(document).pngFix();
});