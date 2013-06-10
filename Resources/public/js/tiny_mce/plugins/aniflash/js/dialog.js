tinyMCEPopup.requireLangPack();

var AniflashDialog = {
	init : function() {
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		// f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
	},

	insert : function(sFlashFile, iWidth, iHeight, sLang) {
		// Insert the contents from the input into the document
		
		aniTitle  = tinyMCEPopup.getLang('aniflash.view_animation');
		sClose	  = tinyMCEPopup.getLang('aniflash.quit_animation');
		
		sFlashFileId = sFlashFile.replace('.', '_');
		
		//aniMarker = '<a style="text-decoration:underline;" class="aniflashlink" rel="' + sFlashFile + '|' + iWidth + '|' + iHeight + '|' + sLang + '" href="#' + sFlashFileId + '">' + aniTitle + '</a>';
		aniMarker = '<a style="text-decoration:underline;" class="aniflashlink" rel="' + sFlashFile + '|' + iWidth + '|' + iHeight + '|' + sLang + '|' + sClose + '" href="javascript:void(0);">' + aniTitle + '</a>';
		
		strFlashContent	= aniMarker;
		/*strFlashContent += '<div style="display:none;">';
		strFlashContent += '<div id="' + sFlashFileId + '">';
		strFlashContent += '<div id="flashPopupContent">';
		strFlashContent += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+iWidth+'" height="'+iHeight+'">';
		strFlashContent += '<param name="movie" value="/upload/animations_flash/' + sLang + '/'+sFlashFile+'" />';
		strFlashContent += '<param name="allowScriptAccess" value="always" />';
		strFlashContent += '<param name="quality" value="high" />';
		strFlashContent += '<param name="wmode" value="transparent" />';
		strFlashContent += '<embed src="/upload/animations_flash/' + sLang + '/'+sFlashFile+'" wmode="transparent" quality="high" allowScriptAccess="always" type="application/x-shockwave-flash" width="'+iWidth+'" height="'+iHeight+'"></embed>';
		strFlashContent += '</object>';
		strFlashContent += '</div>';
		strFlashContent += '<div id="flashPopupContent"></div>';
		strFlashContent += '</div>';
		strFlashContent += '</div>';*/
					
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, strFlashContent);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(AniflashDialog.init, AniflashDialog);
