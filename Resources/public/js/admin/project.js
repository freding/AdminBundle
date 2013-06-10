	$(document).ready(function() {
		
		init_colorpicker();
		_deleteRecord();
		_sortRecord();
		_validatePayment();
		
		$("a.fancybox").each(function() {
			$(this).fancybox();
		});

		$('.aDate').each(function() {
			$(this).datetime({userLang	: g_variables.lang});
		});
		
		$(".btnGeneric").button();
		$(".btnGenericSquare").button();
		$(".btnSupprimer").button({icons: { primary: "ui-icon-close" }, text: false});
		
		// png class init
		$(document).pngFix();
		
		dynamic.select_parent();
		dynamic.load_children();
	});
	
	
	
	
	
	function _validatePayment() {

		$(".payment_validation_class").change(
			function(){	
				$(this).attr("disabled","disabled");
				$.post(g_variables.lang_url + "/admin/ajax/validatepayment", 
						{id_gift:$(this).attr("rel")},
						function(data){

							
						}, "html"
				);
				
				
			}	
		);

		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	function _sortRecord() {
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
				var i= 0;
				$(obj).find(".count").each(function(){
					ranking[i] = $(this).text();
					var aTemp =$(this).attr("id").split("_");
					record[i]=aTemp[1];	
					i++;
				});
				var str_ranking = ranking.join("_");
				var str_record = record.join("_"); 
				$.post(g_variables.lang_url + "/admin/ajax/sortrecord", 
						{ids_ranking:str_ranking,ids_record:str_record, class_name:class_name},
						function(data){}, "html"
				);
				
			}
		});
	}
	
	function _deleteRecord(){

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
				
		$('.deleterecord').each(function() {
			$(this).click(function () {
				var id = $(this).attr('id');
				var class_name = $("#div_sort").attr('rel');
				
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'MESSAGE_DELETE'},
					function(data){
						jConfirm(data, 'Confirmation Dialog', function(r) {
							if(r){
							
								$.post(g_variables.lang_url + "/admin/ajax/deleterecord", 
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

	function init_colorpicker(){
		$('.colorSelector').each(function() {
			var selector = $(this);
			var input = selector.prev().find(">:first-child");
			var color = input.val();
			
			$(selector).ColorPicker({
				color: color,
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					selector.find("div").css('backgroundColor', '#' + hex);
					input.val('#' + hex);
				}
			});
		});
		
		$('.color_container').each(function() {
			var input = $(this).find(">:first-child");
			var selector = $(this).next();
			
			input.keyup(function(){
				var color = input.val();
				selector.find("div").css('backgroundColor', color);
			});
		});
	}
	
	var dynamic = function() {
			
		function _select_parent(){
			$(".select_parent").each(function(){
				$(this).change(function () {
					dynamic.add_select($(this));
				});	
			});
		}
		
		function _add_select(object){
			var id_parent = object.val();
			var id = $('#data_id').val();
			var class_name = $('#select_box').attr('rel');
			
			object.parent().parent().nextAll().remove().fadeOut('slow');
			
			if(id_parent > 0){
				var splitResult = g_variables.lang_url.split("/");
				var lang = splitResult[1];
				
				$.post(g_variables.lang_url + "/admin/ajax/getchild", 
						{id_parent:id_parent, lang:lang, class_name:class_name},
						function(data){
							var clone_object = $('#div_child_clone .row').clone();
							clone_object.find('select').attr('name', 'parent_id[]');
							clone_object.find('select').html(data);
							clone_object.find('select').change(function () {
								dynamic.add_select($(this));
								_deleteRecord();
								_sortRecord();
							});
							clone_object.hide().appendTo($("#select_box")).fadeIn('slow');
							return false;
						}, 
						"html"
				);
			}
		}
		
		
		function _load_children(){
			$(".select_load_children").each(function(){
				$(this).change(function () {
					dynamic.add_select_list($(this));
				});	
			});
		}
		
		function _add_select_list(object){
			var id_parent = object.val();
			var type = $('#type').val();
			var class_name = $('#div_sort').attr('rel');
			var clone = true;
			
			object.parent().nextAll().remove().fadeOut('slow');
			
			if(id_parent == 0){
				clone = false
				if (object.parent().prev().length > 0) {
					id_parent = object.parent().prev().find('select').val();
				}
			}

			var splitResult = g_variables.lang_url.split("/");
			var lang = splitResult[1];
				
			if(clone){
				
				$.post(g_variables.lang_url + "/admin/ajax/getchild", 
						{id_parent:id_parent, lang:lang, class_name:class_name},
						function(data){
							var clone_object = $('#div_child_clone .column').clone();
							clone_object.find('select').html(data);
							clone_object.find('select').change(function () {
								dynamic.add_select_list($(this));
							});
							clone_object.hide().appendTo($("#select_box")).fadeIn('slow');
							return false;
						}, 
						"html"
				);
			}	
			
			$.post(g_variables.lang_url + "/admin/ajax/getchildlist", 
					{id_parent:id_parent, type:type, lang:lang, class_name:class_name},
					function(data){
						$('#div_sort').html(data);
						_deleteRecord();
						_sortRecord();
						$(".btnGenericSquare").button();
						return false;
					}, 
					"html"
			);
		}
		
		
		
		
		
		
		
		
		

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		return {select_parent : _select_parent, add_select : _add_select, load_children : _load_children, add_select_list : _add_select_list}
		
	}();