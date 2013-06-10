	$(document).ready(function() {
		
		_load_news();
		_deleteNews();
		_deleteDepartment();
		_sortDepartRecords();
	});

	function _load_news(){
		$(".sel_department").each(function(){
			$(this).change(function () {
				_load_news_list($(this));
			});	
		});
	}
	
	function _load_news_list(object){
		try {
			var id_department = object.val();
			var class_name = $('#div_sort').attr('rel');
			
			object.parent().nextAll().remove().fadeOut('slow');
			
			var splitResult = g_variables.lang_url.split("/");
			var lang = splitResult[1];
			
			$.post(g_variables.lang_url + "/admin/ajax/getdepartmentnews", 
					{id_department:id_department, class_name:class_name},
					function(data){
						$('#div_sort').html(data);
						return false;
					}, 
					"html"
			);
		} catch(err) {}
	}
	
	function _deleteNews() {
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
				
		$('.deletenews').each(function() {
			$(this).click(function () {
				var id = $(this).attr('id');
				var class_name = $("#div_sort").attr('rel');
				
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'MESSAGE_DELETE'},
					function(data){
						jConfirm(data, 'Confirmation Dialog - Department News', function(r) {
							if(r){
							
								$.post(g_variables.lang_url + "/admin/ajax/deletenews", 
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
	
	function _deleteDepartment() {
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
				
		$('.deletedepartment').each(function() {
			$(this).click(function () {
				var id = $(this).attr('id');
				var class_name = $("#div_sort").attr('rel');
				
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'MESSAGE_DELETE'},
					function(data){
						jConfirm(data, 'Confirmation Dialog - Department News', function(r) {
							if(r){
							
								$.post(g_variables.lang_url + "/admin/ajax/deletedepartment", 
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
	
	function _sortDepartRecords() {
		var obj = $("#div_sort tbody");
		var current_page = parseInt($("#hid_current_page").val());
		var item_count_per_page = parseInt($("#hid_item_count_per_page").val());
		var page_index = parseInt((current_page - 1) * item_count_per_page);
		
		$(obj).sortable({
			axis: "y",
			containment: "#tbl_sort",
			handle: ".item",
			distance: 10,
			stop: function(event, ui){
				$(obj).find("tr").each(function(){
					index = parseInt($(this).index()+1+page_index);
					$(this).find(".count").text(index);
				});
				var ranking = new Array();
				var record = new Array();
				var class_name = $("#div_sort").attr('rel');
				var type = $("#type").val();
				var i= 0;
				$(obj).find(".count").each(function(){					
					ranking[i] = $(this).text();
					var aTemp =$(this).attr("id").split("_");
					record[i]=aTemp[1];	
					i++;
				});
				var str_ranking = ranking.join("_");
				var str_record = record.join("_"); 
				$.post(g_variables.lang_url + "/admin/ajax/sortdepartmentrecord", 
						{ids_ranking:str_ranking, type:type, ids_record:str_record, class_name:class_name},
						function(data){}, "html"
				);
				
			}
		});
	}
