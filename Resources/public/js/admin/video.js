// JavaScript Document
$(document).ready(function() {
	video.sortVideo();
	$('#all_channels').click(function(){
		var type = $(this).val();
		if ($("#all_channels").is(":checked")){
			$('#div_select_channel').hide();
		} else {
			$('#div_select_channel').show();
		}
	});
});

var video = function() {
	
		function _sortVideo() {
			var obj = $("#div_sort tbody");
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
					$.post(g_variables.lang_url + "/admin/ajax/sortvideo", 
							{ids_ranking:str_ranking,ids_record:str_record, class_name:class_name},
							function(data){}, "html"
					);
					
				}
			});
		}
		return {sortVideo:_sortVideo}
		
	}();
	
function removeVideo(id) {
	$.post(g_variables.lang_url + "/admin/ajax/translate", 
    {lang_key: 'MESSAGE_DELETE'},
		function(data){
			jConfirm(data, 'Confirmation Dialog', function(r) {
				if(r){		
					var id_video = $('#'+id).attr('rel');
					
					var splitResult = g_variables.lang_url.split("/");
					var lang = splitResult[1];
					
					$.post(g_variables.lang_url + "/admin/ajax/deletevideo", 
							{id_video:id_video,lang:lang},
							function(data){
								$("#video_row_"+data).fadeOut("slow");
								location.reload();
							}, 
							"html"
					);
				}
			});
		}, "html"
	);	
}