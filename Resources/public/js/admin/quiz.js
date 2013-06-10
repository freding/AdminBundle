$(document).ready(function() {
		
	var quiz = function() {
			
		function _add_answer(){
			$("#add_answer").click(function () {
				
				var clone_object = $('#div_answer_clone .element_sort').clone();
				var count = parseInt($("#div_answer .element_sort").length) + 1;
				var name_answer = 'answer[]';
				var name_point = 'point[]';
				
				clone_object.find('input.answer').attr('name', name_answer);
				clone_object.find('input.point').attr('name', name_point);
				clone_object.hide().appendTo($("#div_answer ul")).fadeIn('slow');
				quiz.remove_answer();
				quiz.sortable();
				return false;
			});		
		}
		
		function _remove_answer(){
			$(".remove_answer").each(function(){
				$(this).click(function () {
					$(this).parent().parent().parent().fadeOut('slow', function() { $(this).remove(); });
					return false;
				});
			});
		}
		
		function _sortable(){
			var obj = $("#div_answer ul");
			$(obj).sortable({
				axis: "y", // Le sortable ne s'applique que sur l'axe vertical
				containment: "#div_answer", // Le drag ne peut sortir de l'¨¦l¨¦ment qui contient la liste
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
		
		return {add_answer : _add_answer, remove_answer : _remove_answer, sortable : _sortable}
		
	}();

	quiz.add_answer();
	quiz.remove_answer();	
	quiz.sortable();
});