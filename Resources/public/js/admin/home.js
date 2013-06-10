var home = function() {
	
	function _add_channel_list(){
	
		$("#add_channel_list_button").click(function () {
			if($("#select_channel_id").val()=="0" ){
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'ERROR_SELECT_CHANNEL',language: g_variables.lang},
					function(data){
						$("#error_channel_list_div").html(data); 
					}, "html"
				);
				
			}else{
				$("#error_channel_list_div").html("");
				if($(".count:last").html() >= 15){
					$.post(g_variables.lang_url + "/admin/ajax/translate", 
						{lang_key: 'ERROR_MAX_CHANNEL_EXCEED', argument_1: 15},
						function(data){
							$("#error_channel_list_div").html(data); 
						}, "html"
					);
				}else{
					var isChannelList = false;	
					$(".delete_channel_list").each(function(){
						if( $(this).attr("rel") == $("#select_channel_id").val() ){
							isChannelList = true;
						}	
					});
					if(isChannelList == false){
						// ajouter une chaîne à la une.
						var tr_exist = $("#div_channel_list tbody").html();
						var str_tr ="";
						
						$.post(g_variables.lang_url + "/admin/ajax/translate", 
							{lang_key: 'DELETE'},
							function(data){							
								str_tr += "<tr class='alt' id='r-"+$("#select_channel_id").val()+"'>";
								str_tr += "<td class='item'><div class='item ui-state-default ui-corner-all'><span class='btnSort ui-icon ui-icon-arrow-4'>&nbsp;</span></div></td>";
								str_tr += "<td align='center'><span class='count' id='record_"+$("#select_channel_id").val()+"'></span></td>";
								str_tr += "<td>"+$("#select_channel_id option:selected" ).text ();+"</td>";
								str_tr += "<td>";
								str_tr += "<a id='delete_"+$("#select_channel_id").val()+"' rel='"+$("#select_channel_id").val()+"' class='delete_channel_list'>";
								str_tr += "<div class='btnBin'>"+data+"</div>";
								str_tr += "</a>";
								str_tr += "</td>";
								str_tr += "</tr>";
								
								$("#div_channel_list tbody").html(tr_exist+str_tr);
								var obj = $("#div_channel_list tbody");
								$(obj).find("tr").each(function(){
									index = parseInt($(this).index()+1);
									$(this).find(".count").text(index);
								});
								$.post(g_variables.lang_url + "/admin/ajax/addchannellist", 
										{channel_id:$("#select_channel_id").val(),channel_list:$(".count:last").text() },
										function(data){ }, "html"
								);
								$("#select_channel_id").val("0");
								home.deleteChannelList();
						
							}, "html"
						);
						
						
					}else{
						$.post(g_variables.lang_url + "/admin/ajax/translate", 
							{lang_key: 'ERROR_CHANNEL_ADDED'},
							function(data){
								$("#error_channel_list_div").html(data); 
							}, "html"
						);
					}	         
				}	
			}	
		});
	}
	
	function _delete_channel_list(){
		$(".delete_channel_list").click(function () {
			$("#r-"+$(this).attr("rel") ).remove();
			var obj = $("#div_channel_list tbody");
			$(obj).find("tr").each(function(){
				index = parseInt($(this).index()+1);
				$(this).find(".count").text(index);
			});
			$.post(g_variables.lang_url + "/admin/ajax/deletechannellist", 
					{channel_id:$(this).attr("rel")},
					function(data){ }, "html"
			);  
		});	
	}
	
	function _sort_channel_list(){
        var obj = $("#div_channel_list tbody");
		$(obj).sortable({
			axis: "y",
			containment: "#tbl_sort",
			handle: ".item",
			distance: 10,
			stop: function(event, ui){
				$(obj).find("tr").each(function(){
					index = parseInt($(this).index()+1);
					$(this).find(".count").text(index);
				});
				var list = new Array();
				var channel = new Array();
				var i= 0;
				$(obj).find(".count").each(function(){
					list[i] = $(this).text();
					var aTemp =$(this).attr("id").split("_");
					channel[i]=aTemp[1];	
					i++;
				});
				var str_list = list.join("_");
				var str_channel = channel.join("_"); 
				$.post(g_variables.lang_url + "/admin/ajax/sortchannellist", 
						{ids_list:str_list,ids_channel:str_channel},
						function(data){}, "html"
				);
				
			}
		});
    }
	
	function _add_channel_highlight(){
		$("#add_channel_highlight_button").click(function () {
			if($("#select_channel_id").val()=="0" ){
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'ERROR_SELECT_CHANNEL',language: g_variables.lang},
					function(data){
						$("#error_channel_highlight_div").html(data); 
					}, "html"
				);
			}else if($(".file_name_image img").length == 0){
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'ERROR_UPLOAD_IMAGE',language: g_variables.lang},
					function(data){
						$("#error_channel_highlight_div").html(data); 
					}, "html"
				);
			}else{
				$("#error_channel_highlight_div").html("");
				if($(".count:last").html() >= 4){
					$.post(g_variables.lang_url + "/admin/ajax/translate", 
						{lang_key: 'ERROR_MAX_CHANNEL_EXCEED', argument_1: 4},
						function(data){
							$("#error_channel_highlight_div").html(data); 
						}, "html"
					);
				}else{
					var isChannelHighlight = false;	
					$(".delete_channel_highlight").each(function(){
						if( $(this).attr("rel") == $("#select_channel_id").val() ){
							isChannelHighlight = true;
						}	
					});
					if(isChannelHighlight == false){
						// ajouter une chaîne à la une.
						var tr_exist = $("#div_channel_highlight tbody").html();
						var str_tr ="";
						$.post(g_variables.lang_url + "/admin/ajax/translate", 
							{lang_key: 'DELETE'},
							function(data){	
								str_tr += "<tr class='alt' id='r-"+$("#select_channel_id").val()+"'>";
								str_tr += "<td class='item'><div class='item ui-state-default ui-corner-all'><span class='btnSort ui-icon ui-icon-arrow-4'>&nbsp;</span></div></td>";
								str_tr += "<td align='center'><span class='count' id='record_"+$("#select_channel_id").val()+"'></span></td>";
								str_tr += "<td>"+$("#select_channel_id option:selected" ).text ();+"</td>";
								str_tr += "<td>"+$(".file_name_image").html()+"</td>";
								str_tr += "<td>";
								str_tr += "<a id='delete_"+$("#select_channel_id").val()+"' rel='"+$("#select_channel_id").val()+"' class='delete_channel_highlight'>";
								str_tr += "<div class='btnBin'>"+data+"</div>";
								str_tr += "</a>";
								str_tr += "</td>";
								str_tr += "</tr>";
								
								$("#div_channel_highlight tbody").html(tr_exist+str_tr);
								var obj = $("#div_channel_highlight tbody");
								$(obj).find("tr").each(function(){
									index = parseInt($(this).index()+1);
									$(this).find(".count").text(index);
								});
								
								$.post(g_variables.lang_url + "/admin/ajax/addchannelhighlight", 
										{channel_id:$("#select_channel_id").val(),channel_highlight:$(".count:last").text(), channel_image: $(".file_name_image img").attr('name'), language: g_variables.lang},
										function(data){ }, "html"
								);
								
								$("#select_channel_id").val("0");
								$(".file_name_image").html("");
								home.deleteChannelHighlight();
							}, "html"
						);
					}else{
						$.post(g_variables.lang_url + "/admin/ajax/translate", 
							{lang_key: 'ERROR_CHANNEL_ADDED'},
							function(data){
								$("#error_channel_highlight_div").html(data); 
							}, "html"
						);
					}	         
				}	
			}	
		});
	}
	
	function _delete_channel_highlight(){
		$(".delete_channel_highlight").click(function () {
			$("#r-"+$(this).attr("rel") ).remove();
			var obj = $("#div_channel_highlight tbody");
			$(obj).find("tr").each(function(){
				index = parseInt($(this).index()+1);
				$(this).find(".count").text(index);
			});
			$.post(g_variables.lang_url + "/admin/ajax/deletechannelhighlight", 
					{channel_id:$(this).attr("rel"), language: g_variables.lang},
					function(data){ }, "html"
			);  
		});	
	}
	
	function _sort_channel_highlight(){
        var obj = $("#div_channel_highlight tbody");
		$(obj).sortable({
			axis: "y",
			containment: "#tbl_sort",
			handle: ".item",
			distance: 10,
			stop: function(event, ui){
				$(obj).find("tr").each(function(){
					index = parseInt($(this).index()+1);
					$(this).find(".count").text(index);
				});
				var highlight = new Array();
				var channel = new Array();
				var i= 0;
				$(obj).find(".count").each(function(){
					highlight[i] = $(this).text();
					var aTemp =$(this).attr("id").split("_");
					channel[i]=aTemp[1];	
					i++;
				});
				var str_highlight = highlight.join("_");
				var str_channel = channel.join("_"); 
				$.post(g_variables.lang_url + "/admin/ajax/sortchannelhighlight", 
						{ids_highlight:str_highlight,ids_channel:str_channel,language: g_variables.lang},
						function(data){}, "html"
				);
				
			}
		});
    }
	
	function _upload_image(){

		$('#uploadImage').uploadify({
			'uploader': '/js/uploadify/uploadify.swf',
			'script': g_variables.lang_url + '/admin/ajax/uploadimage',
			'folder': '/upload/'+g_variables.lang_url,
			'buttonImg': '/image/'+g_variables.lang+'/btn_browse.png',
			'width': '78',
			'height': '20',
			'auto'  : true,
			'scriptData': {'PHPSESSID': $(".upload_key").attr("id")}
			,onSelect: function() {
				$("#id_url_image").val("");
			}
			,onComplete: function(event, queueID, fileObj, response, data) {
				$(".file_name_image").html(response);
			}
		});
   } 

	return { addChannelList:_add_channel_list, deleteChannelList:_delete_channel_list, sortChannelList:_sort_channel_list, deleteChannelHighlight:_delete_channel_highlight, addChannelHighlight:_add_channel_highlight, sortChannelHighlight:_sort_channel_highlight, uploadImage:_upload_image}
}();

$(function() {
	home.addChannelList();
	home.deleteChannelList();
	home.sortChannelList();
	home.addChannelHighlight();
	home.deleteChannelHighlight();
	home.sortChannelHighlight();
	home.uploadImage();
});
