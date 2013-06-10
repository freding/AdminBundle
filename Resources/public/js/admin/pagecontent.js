$(document).ready(function() {
		
	var pagecontent = function() {
			
		function _add_content(){
			$("#add_content").click(function () {
				
				var clone_object = $('#div_content_clone .content').clone();
				var count = parseInt($("#div_content .content").length) + 1;
				var id = 'texte_' + count;
				var name = 'texte[' + count + ']';
				var name_next = 'next[' + count + ']';
				var name_previous = 'previous[' + count + ']';
				
				clone_object.find('textarea').attr('id', id);
				clone_object.find('textarea').attr('name', name);
				clone_object.find('input.next').attr('name', name_next);
				clone_object.find('input.previous').attr('name', name_previous);
				clone_object.hide().appendTo($("#div_content")).fadeIn('slow');
				load_tinymce(id);
				pagecontent.remove_content();
				return false;
			});		
		}
		
		function _remove_content(){
			$(".remove_content").each(function(){
				$(this).click(function () {
					$(this).parent().parent().fadeOut('slow', function() { $(this).remove(); });
					return false;
				});
			});
		}
		
		return {add_content : _add_content, remove_content : _remove_content}
		
	}();

	pagecontent.add_content();
	pagecontent.remove_content();	
});

function load_tinymce(id){
	// Initialize TinyMCE with the new plugin and menu button

	tinyMCE.init({
		plugins : '-example', // - tells TinyMCE to skip the loading of the plugin
		mode : "exact",
		elements : id,
		language: g_variables.lang,
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink",
		theme_advanced_buttons2 : "link,unlink,image,cleanup,code,|,forecolor,backcolor,fontselect,fontsizeselect",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		file_browser_callback : "ajaxfilemanager"
	});
}