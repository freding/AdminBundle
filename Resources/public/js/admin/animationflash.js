	$(document).ready(function() {
		
		_showFlash();
		_deleteFlash();
	});
	
	function _showFlash(){

		$("a.flashPopup").fancybox({
				
			onComplete: function(){

			}
		});
	}
	
	function _deleteFlash(){

		$.post(g_variables.lang_url + "/admin/ajax/translate", 
			{lang_key: 'BUTTON_OK'},
			function(data){
				$.alerts.okButton = "&nbsp;&nbsp;"+data+"&nbsp;&nbsp;"; 
			}, "html"
		);
		
		$.post(g_variables.lang_url + "/admin/ajax/translate", 
			{lang_key: 'BUTTON_CANCEL'},
			function(data){
				$.alerts.cancelButton = "&nbsp;&nbsp;"+data+"&nbsp;&nbsp;"; 
			}, "html"
		);
				
		$('.deleteflash').each(function() {
			$(this).click(function () {
				var id = $(this).attr('id');
				var class_name = $("#div_sort").attr('rel');
				
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'MESSAGE_DELETE'},
					function(data){
						jConfirm(data, 'Confirmation Dialog - Animations Flash', function(r) {
							if(r){
							
								$.post(g_variables.lang_url + "/admin/ajax/deleteflash", 
										{id:id, class_name:class_name},
										function(data){
											$('#r-' + data).fadeOut("slow");
											location.reload();
										}, 
										"html"
								);
							}
						});
					}, "html"
				);
				
			});
		});
	}