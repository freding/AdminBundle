	$(document).ready(function() {		
		bannerdynamic.load_banners();
	});
	
	var bannerdynamic = function() {
			
		function _load_banners(){
			$(".select_load_section").each(function(){
				$(this).change(function () {
					bannerdynamic.redirect($(this));
				});
			});
		}
		
		function _redirect(object){
			var sSection 			= object.val();
			window.location.href 	= g_variables.lang_url + '/admin/banner/edit/section/' + sSection;
		}
		
		return {load_banners : _load_banners, redirect : _redirect,}
		
	}();