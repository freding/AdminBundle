var yourbreath = function() {
	
	function _add_question(){
	
		$("#add_question_button").click(function () {
			if($("#select_question").val()=="0" ){
				$.post(g_variables.lang_url + "/admin/ajax/translate", 
					{lang_key: 'ERROR_SELECT_QUESTION'},
					function(data){
						$("#error_question_div").html(data); 
					}, "html"
				);
				
			}else{
				$("#error_question_div").html("");
				
				var isQuestionExist = false;	
				$(".delete_question").each(function(){
					if( $(this).attr("rel") == $("#select_question").val() ){
						isQuestionExist = true;
					}	
				});
				if(isQuestionExist == false){
					var question_id = $("#select_question").val();
					var question_text = $("#select_question option:selected").text();
					var str_html = $('#selected_question_div ul').html();
					str_html += "<li class='element_sort' rel=''><div id='question_"+ question_id + "'>";
					str_html += "<div class='question_name'><strong>" + question_text + "</strong><input type='hidden' value='"+ question_id +"' name='quiz[]'></div>&nbsp;";
					str_html += "<div class='item ui-state-default ui-corner-all'><span class='btnSort ui-icon ui-icon-arrow-4'>&nbsp;</span></div>&nbsp;";
					str_html += "<a rel='"+ question_id +"' class='delete_question' style='float:none; cursor:pointer;'><button class='btnSupprimer btnNewClose'>&nbsp;</button></a>";
					str_html += "<div class='clear'></div>";
					str_html += "</div></li>";
					$('#selected_question_div ul').html(str_html);
					$(".btnNewClose").button({icons: { primary: "ui-icon-close" }, text: false});
					$(".btnNewClose").removeClass('btnNewClose');
					yourbreath.delete_question();
					
				}else{
					$.post(g_variables.lang_url + "/admin/ajax/translate", 
						{lang_key: 'ERROR_QUESTION_ADDED'},
						function(data){
							$("#error_question_div").html(data);
						}, "html"
					);
				}	         
	
			}
			return false;
		});
	}
	
	function _delete_question(){
		$(".delete_question").click(function () {
			var id_question =$(this).attr('rel');
			$("#question_"+id_question).remove();
			return false;
		});	
	}
	
	function _sort_question(){
        var obj = $("#selected_question_div ul");
		$(obj).sortable({
			axis: "y", // Le sortable ne s'applique que sur l'axe vertical
			containment: "#selected_question_div", // Le drag ne peut sortir de l'¨¦l¨¦ment qui contient la liste
			handle: ".item", // Le drag ne peut se faire que sur l'¨¦l¨¦ment .item (le texte)
			distance: 10, // Le drag ne commence qu'¨¤ partir de 10px de distance de l'¨¦l¨¦ment
			// Evenement appel¨¦ lorsque l'¨¦l¨¦ment est relach¨¦
			stop: function(event, ui){
				// Pour chaque item de liste
				$(obj).find("li").each(function(){
					// On actualise sa position
					index = parseInt($(this).index()+1);
					// On la met ¨¤ jour dans la page
					$(this).find(".count").text(index);
				});
			}
		});
    }
	
	function _add_result(){
		$("#add_result").click(function () {
			
			var clone_object = $('#div_result_clone .element_sort').clone();
			var count = parseInt($("#div_result .element_sort").length) + 1;
			var name_result = 'result[]';
			var name_point = 'point[]';
			
			clone_object.find('textarea.result').attr('name', name_result);
			clone_object.find('input.point').attr('name', name_point);
			clone_object.hide().appendTo($("#div_result ul")).fadeIn('slow');
			yourbreath.remove_result();
			yourbreath.sort_result();
			return false;
		});		
	}
		
	function _remove_result(){
		$(".remove_result").each(function(){
			$(this).click(function () {
				$(this).parent().parent().parent().fadeOut('slow', function() { $(this).remove(); });
				return false;
			});
		});
	}
		
	function _sort_result(){
		var obj = $("#div_result ul");
		$(obj).sortable({
			axis: "y", // Le sortable ne s'applique que sur l'axe vertical
			containment: "#div_result", // Le drag ne peut sortir de l'¨¦l¨¦ment qui contient la liste
			handle: ".item", // Le drag ne peut se faire que sur l'¨¦l¨¦ment .item (le texte)
			distance: 10, // Le drag ne commence qu'¨¤ partir de 10px de distance de l'¨¦l¨¦ment
			// Evenement appel¨¦ lorsque l'¨¦l¨¦ment est relach¨¦
			stop: function(event, ui){
				// Pour chaque item de liste
				$(obj).find("li").each(function(){
					// On actualise sa position
					index = parseInt($(this).index()+1);
					// On la met ¨¤ jour dans la page
					$(this).find(".count").text(index);
				});
			}
		});
	}
	
	return { 
		add_question:_add_question, delete_question:_delete_question, sort_question:_sort_question, 
		add_result:_add_result, remove_result:_remove_result, sort_result:_sort_result
	}
}();

$(function() {
	yourbreath.add_question();
	yourbreath.delete_question();
	yourbreath.sort_question();
	yourbreath.add_result();
	yourbreath.remove_result();
	yourbreath.sort_result();
});
