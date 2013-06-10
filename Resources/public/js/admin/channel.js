$(document).ready(function() {
		
	var channel = function() {
		
 		function _updateVideoList(){
			
			var splitResult = g_variables.lang_url.split("/");
			var lang = splitResult[1];
			
			$("#select_channel_id").change(function () {
					var channelId = $("#select_channel_id").val();
					var labelId = 0;
					
					$.post(g_variables.lang_url + "/admin/ajax/getvideobychannellabel", 
							{'id_channel':channelId, 'id_label':labelId, lang:lang},
							function(data){
								 $("#div_sort").html(data);
								 $(".btnGenericSquare").button();
								 video.sortVideo();
							}, 
							"html"
					);
			});
			
			$("#select_label_id").change(function () {
					var channelId = $("#select_channel_id").val();
					var labelId = $("#select_label_id").val();
										
					$.post(g_variables.lang_url + "/admin/ajax/getvideobychannellabel", 
							{'id_channel':channelId, 'id_label':labelId, lang:lang},
							function(data){
								 $("#div_sort").html(data);
								 $(".btnGenericSquare").button();
								 video.sortVideo();
							}, 
							"html"
					);
			});
		}
		
		

		function _updateLabelCombo(){
			$("#select_channel_id").change(function () {
					var id_channel = $(this).val();
					
					var splitResult = g_variables.lang_url.split("/");
					var lang = splitResult[1];
					
					$.post(g_variables.lang_url + "/admin/ajax/getchannellabel", 
							{id_channel:id_channel, lang:lang},
							function(data){
								 $("#select_label_id").html(data);
							}, 
							"html"
					);
			});	
		}

			
		function _add_label(){
			$("#add_label_id").click(function () {
				$('#error_label_div').html('');
				var name_label= $("#add_label_field_id" ).val();	
				if(name_label!=""){
					var already_add = $("#selected_label_div ul").html();
					
					$("#selected_label_div ul").html( already_add+"<li class='element_sort' rel=''><div class='thematic_name'><input type='text' value='"+name_label+"' name='libel_linked[]' class='hidden_id'></div><div class='item ui-state-default ui-corner-all'><span class='btnSort ui-icon ui-icon-arrow-4'>&nbsp;</span><input type='hidden' value='new' name='libel_linked_id[]' class='hidden_id'> </div> <button class='btnSupprimer manage_label btnNewClose' rel=''>X</button> <div class='clear'></div></li>");
					$(".btnNewClose").button({icons: { primary: "ui-icon-close" }, text: false});
					var obj = $("#selected_label_div ul");
					$(obj).find("li").each(function(){
						index = parseInt($(this).index()+1);
						$(this).find(".manage_label").attr("rel",index);
						$(this).attr("id","label_"+index);
						$(this).find(".manage_label").removeClass("btnNewClose");
					});
					channel.deleteLabel();
					$("#add_label_field_id" ).val("");					
				} else {					
					$.post(g_variables.lang_url + "/admin/ajax/translate", 
						{lang_key: 'MESSAGE_SELECT_THEMATIC'},
						function(data){
							$('#error_label_div').html(data);
						}, "html"
					);					
					//$('#error_label_div').html('Entrez le nom thématiques');
				}
				return false;
			});		
		}

		function _add_label_video() {
			$("#ajouter_channel_button").bind('click', function(){
				var id_channel = $("#select_channel_id").val();
				var id_label = $("#select_label_id").val();
							
				if(id_channel == 0) {
					$.post(g_variables.lang_url + "/admin/ajax/translate", 
						{lang_key: 'SELECT_CHANNEL'},
						function(data){
							$('#error_label_div').html(data);
						}, "html"
					);					
					//$('#error_label_div').html('Choisir une chaîne');
				}
				
				if(id_channel != 0) {
					$('#error_label_div').html('');
					
					var splitResult = g_variables.lang_url.split("/");
					var lang = splitResult[1];

					$.post(g_variables.lang_url + "/admin/ajax/addlabel", 
							{id_channel:id_channel, id_label:id_label, lang:lang},
							function(data){
								if( $("#channel_"+id_channel+"_parent_"+id_label).length ){ }else{
									if( $("#channel_"+id_label+"_parent_"+id_channel).length ){ }else{
										 var previous_selected_item = $("#selected_channel_label").html();
										 $("#selected_channel_label").html(previous_selected_item+data);
										 $("#select_channel_id").val("0");
										 
										 
										 $.post(g_variables.lang_url + "/admin/ajax/translate", 
											{lang_key: 'SELECT_THEMATIC'},
											function(data){
												$('#select_label_id').html("<option value='0'> "+data+" </option>");
											}, "html"
										 );	
										 //$("#select_label_id").html("<option value='0'> Choisir une thématique </option>");										 
										channel.deleteChannelLabel();
									}
									$(".btnNewClose").button({icons: { primary: "ui-icon-close" }, text: false});
									$(".btnNewClose").removeClass('btnNewClose');
								}
							}, 
							"html"
					);
				}
				return false;
			});
		}

		function _deleteChannelLabel(){
			$(".delete_label_channel").click(function () {
				var aTemp=$(this).attr('rel').split("_");
				var id_channel = aTemp[0];
				var id_parent = aTemp[1];
				$("#channel_"+id_channel+"_parent_"+id_parent).remove();
			});	
		}


		function _sortable(){
			var obj = $("#selected_label_div ul");
			$(obj).sortable({
				axis: "y", // Le sortable ne s'applique que sur l'axe vertical
				containment: "#selected_label_div", // Le drag ne peut sortir de l'élément qui contient la liste
				handle: ".item", // Le drag ne peut se faire que sur l'élément .item (le texte)
				distance: 10, // Le drag ne commence qu'à partir de 10px de distance de l'élément
				// Evenement appelé lorsque l'élément est relaché
				stop: function(event, ui){
					// Pour chaque item de liste
					$(obj).find("li").each(function(){
						// On actualise sa position
						index = parseInt($(this).index()+1);
						// On la met à jour dans la page
						$(this).find(".count").text(index);
					});
				}
			});
		}	
		
		function _deleteLabel(){
			if($("#channel_box_video .delete_categorie_label").attr("rel")){
				$("#channel_box_video .delete_categorie_label").click(function () {
					var aTemp=$(this).attr('rel').split("_");
					var label=aTemp[0];
					var channel=aTemp[1];
					$("#label_"+label+"_channel_"+channel).remove();	
				});	
			}	
			
			if($(".manage_label").attr("rel")){
				$(".manage_label").click(function () {
					var label=$(this).attr("rel");
					$("#label_"+label).remove();
					var obj = $("#selected_label_div ul");
					$(obj).find("li").each(function(){
						index = parseInt($(this).index()+1);
						//$(this).find(".count").text(index);
						$(this).find(".manage_label").attr("rel",index);
						$(this).attr("id","label_"+index);
					});
					return false;
				});	
			}
		}
		
		function _colorpicker(){
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
		
		function _add_button(){
			$("#save_button").click(function () {
				$('#error_button_div').html('');
				var name_button 					= $('#txt_name').val();	
				var background_color_over_start 	= $('input[name="background_color_over_start"]').val();	
				var background_color_over_end 		= $('input[name="background_color_over_end"]').val();	
				var background_border_color_over 	= $('input[name="background_border_color_over"]').val();	
				var background_color_out_start 		= $('input[name="background_color_out_start"]').val();	
				var background_color_out_end 		= $('input[name="background_color_out_end"]').val();	
				var background_border_color_out 	= $('input[name="background_border_color_out"]').val();	
				var font_color_over 				= $('input[name="font_color_over"]').val();	
				var font_color_out 					= $('input[name="font_color_out"]').val();	
				
				if(name_button != ""){
					
					$.post(g_variables.lang_url + "/admin/ajax/savebutton", 
							{
								'button_name'					:name_button, 
								'background_color_over_start'	:background_color_over_start, 
								'background_color_over_end'		:background_color_over_end, 
								'background_border_color_over'	:background_border_color_over, 
								'background_color_out_start'	:background_color_out_start, 
								'background_color_out_end'		:background_color_out_end, 
								'background_border_color_out'	:background_border_color_out, 
								'font_color_over'				:font_color_over, 
								'font_color_out'				:font_color_out, 
								'lang'							:g_variables.lang
							},
							function(data){
								 $("#error_button_div").html(data);
							}, 
							"html"
					);
				} else {					
					$.post(g_variables.lang_url + "/admin/ajax/translate", 
						{lang_key: 'MESSAGE_ENTER_NAME'},
						function(data){
							$('#error_button_div').html(data);
						}, "html"
					);					
				}
				return false;
			});		
		}
		
		function _get_button(){
			$("#select_button").change(function () {
				var button_id = $("#select_button").val();
				
				if(button_id > 0){
					
					$.post(g_variables.lang_url + "/admin/ajax/getbutton", 
							{'button_id':button_id, 'lang':g_variables.lang},
							function(data){
								 $("#div_button").html(data);
								 channel.colorpicker();
							}, 
							"html"
					);
				}
				return false;
			});		
		}
		
		return {
			updateVideoList		: _updateVideoList,
			add_label			: _add_label, 
			sortable			: _sortable, 
			deleteLabel			: _deleteLabel, 
			updateLabelCombo	: _updateLabelCombo, 
			addlabelvideo		: _add_label_video, 
			deleteChannelLabel	: _deleteChannelLabel, 
			colorpicker			: _colorpicker, 
			add_button			: _add_button, 
			get_button			: _get_button
		}
		
	}();
	
	channel.updateVideoList();
	channel.add_label();
	channel.sortable();
	channel.deleteLabel();
	channel.updateLabelCombo();
	channel.addlabelvideo();
	channel.deleteChannelLabel();
	channel.colorpicker();
	channel.add_button();
	channel.get_button();
	
});

function removeChannel(id) {	
	$.post(g_variables.lang_url + "/admin/ajax/translate", 
    {lang_key: 'MESSAGE_REMOVE_CHANNEL'},
		function(data){
			jConfirm(data, 'Confirmation Dialog', function(r) {
				if(r){		
					var id_channel = $('#'+id).attr('rel');
					
					$.post(g_variables.lang_url + "/admin/ajax/deletechannel", 
							{id_channel:id_channel},
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
}
//