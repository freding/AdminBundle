$(document).ready(function() {
	// Creates a new plugin class and a custom listbox
	tinyMCE.create('tinymce.plugins.ExamplePlugin', {});
	/*
	// Creates a new plugin class and a custom listbox
	tinyMCE.create('tinymce.plugins.AniflashPlugin', {
		createControl: function(n, cm) {
			switch (n) {
				case 'aniflashmenu':
					var c = cm.createMenuButton('aniflashmenu', {
						title : 'Animations Flash',
						image : '/js/tiny_mce/plugins/aniflash/img/aniflash_marker_sm.gif',
						icons : false
					});
	
					c.onRenderMenu.add(function(c, m) {
						
						m.add({title : 'Select Animations Flash', onclick : function() {
							//tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[Ani Flash]');
							tinyMCE.activeEditor.execCommand('mceAniflash');
						}});
					});
	
					// Return the new menu button instance
					return c;
			}
	
			return null;
		}
	});*/

	// Register plugin with a short name
	tinyMCE.PluginManager.add('example', tinymce.plugins.ExamplePlugin);
	//tinyMCE.PluginManager.add('aniflash', tinymce.plugins.AniflashPlugin);

	// Initialize TinyMCE with the new plugin and menu button

	tinyMCE.init({
		plugins : '-example,aniflash, inlinepopups, paste', // - tells TinyMCE to skip the loading of the plugin
		mode : "textareas",
		language: "fr",
		editor_selector : "mceSelect",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,bullist,numlist,undo,redo,link,unlink",
		theme_advanced_buttons2 : "pastetext,pasteword,|,link,unlink,image,cleanup,code,|,forecolor,backcolor,fontselect,fontsizeselect",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		//file_browser_callback : "ajaxfilemanager",
		relative_urls : false

	});
});

function ajaxfilemanager(field_name, url, type, win) {
	var ajaxfilemanagerurl = "/js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
	switch (type) {
		case "image":
			break;
		case "media":
			break;
		case "flash": 
			break;
		case "file":
			break;
		default:
			return false;
	}
	tinyMCE.activeEditor.windowManager.open({
		url: "/js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?language=fr",
		width: 900,
		height: 440,
		inline : "yes",
		close_previous : "no"
	},{
		window : win,
		input : field_name
	});     
}