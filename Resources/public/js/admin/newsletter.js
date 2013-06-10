function removeNewsletter(id) {
	
	$.post(g_variables.lang_url + "/admin/ajax/translate", 
    {lang_key: 'MESSAGE_DELETE'},
		function(data){
			jConfirm(data, 'Confirmation Dialog', function(r) {
				if(r){		
					var id_newsletter = $('#'+id).attr('rel');
					$.post(g_variables.lang_url + "/admin/ajax/deletenewsletter", 
							{id_newsletter:id_newsletter},
							function(data){
								$("#newsletter_row_"+data).fadeOut("slow");
								location.reload();
							}, 
							"html"
					);
				}
			});
		}, "html"
	);	
}