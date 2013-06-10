$(document).ready(function() {
	
	$('input[name="type"]').each(function() {
		$(this).bind('click', function(){
			var type = $(this).val();
			if( type == 'color'){
				$('#divColor').show();
				$('#divImage').hide();
			} else if(type == "image"){
				$('#divColor').hide();
				$('#divImage').show();
			}
		});
	});
	
	$('input[name="home_type"]').each(function() {
		$(this).bind('click', function(){
			var type = $(this).val();
			if( type == 'color'){
				$('#divHomeColor').show();
				$('#divHomeImage').hide();
			} else if(type == "image"){
				$('#divHomeColor').hide();
				$('#divHomeImage').show();
			}
		});
	});

});