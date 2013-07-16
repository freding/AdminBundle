
	var item = function() {





		function _changeDesignerForProduct(){
			$("#change-designer-for-product").change(
                            
                            
                        );
		}


			
		function _addLinkItemToList(){
			var path_add_link_item = $("#path_select_item_for_list").val();
			$(".select_item_for_list_id").change(
                            function(){
				$.post(path_add_link_item, {datas:$(this).attr("rel"),id_item:$(this).val()}, 
                                    function(data){
					location.reload();
                                    }
                                , "html")	
                            }
                        );
		}

		function _removeItemFromFullList(){
			var path_delete = $("#path_ajax_delete_list_all").val();
			
			$(".item_delete").click(
                        
                        
                        
                        
                          
                        



                                    function(){
                                        if (confirm("Vous désirez vraiment supprimer?")) {                                   
                                            $.post(path_delete, {id_item:$(this).attr("rel"),class_name:$("#div_sort").attr('rel')}, 
                                                function(data){
                                                    location.reload();
                                                }
                                            , "html")
                                        }
                                        
                                    }
                                

                            
                            
                        );
							
		}




                function _sortRecord() { 
                        var obj = $("#div_sort tbody");
                        var current_page = parseInt($("#hid_current_page").val());
                        var item_count_per_page = parseInt($("#hid_item_count_per_page").val());
                        var page_index = parseInt((current_page - 1) * item_count_per_page);
			var path_sort = $("#path_ajax_sort_list_all").val();			

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
                                        $.post(path_sort, 
                                                        {ids_ranking:str_ranking,ids_record:str_record, class_name:class_name,rubric:$("#id_rubric").val(), datasVideosEntity:$("#add_linked_video").attr("rel")},
                                                        function(data){}, "html"
                                        );

                                }
                        });
                }



		function _detachItemFromList(){
			var path_delete = $("#path_ajax_delete_item_list").val();
			$(".item_detach").click(
                            function(){	
                                if (confirm("Vous désirez vraiment supprimer?")) { 
                                    $.post(path_delete, {datas:$(this).attr("rel")}, 
                                        function(data){
                                            location.reload();
                                        }
                                    , "html")
                                }   
                            }
                        );
							
		}


                function _sortItemFromList() { 
                        var obj		= $(".div_list tbody");
			var path_sort	= $("#path_ajax_sort_item_list").val();			

                        $(obj).sortable({			
                                axis: "y",
                                containment: ".tlisting",
                                handle: ".item",
                                distance: 10,
				containment: 'parent',
                                stop: function(event, ui){
                                        $(obj).find("tr").each(function(){
                                                index = parseInt($(this).index()+1);
                                                $(this).find(".count").text(index);
                                        });
                                        var ranking = new Array();
                                        var record = new Array();
                                        var i= 0;					
										
                                        $(this).find(".count").each(function(){
                                                
                                                ranking[i] = $(this).text();
                                                var aTemp =$(this).attr("id").split("_");
                                                record[i]=aTemp[1];	
                                                i++;
                                        });
                                        var str_ranking = ranking.join("_");
                                        var str_record = record.join("_"); 
                                        $.post(path_sort, 
                                                        {ids_ranking:str_ranking,ids_record:str_record,datas:$(this).find(".sort_item_id").val()},
                                                        function(data){}, "html"
                                        );

                                }
                        });
                }
                
				
				
				
				
				
                function _uploadVideo() {
   
			path_upload_video	= $("#path_ajax_upload_video").val();	
			$('#uploadVideo').uploadify({
				'uploader': '/js/uploadify/uploadify.swf',
				'script': path_upload_video,
				'cancelImg': '/image/admin/icon_supprimer.gif',
				'buttonImg': '/image/admin/btn_parcourir.png',
				'width': '78',
				'height': '20',
				'auto'  : true,
				'scriptData': {'PHPSESSID': $(".upload_key").attr("id")}


					,onSelect: function() {
						$("#id_url_video").val("");
					}


					
					,onComplete: function(event, queueID, fileObj, response, data) {
								$(".file_name_temp_video").html(response);
					}
					



				}); 
		
                }
				
                function _datepicker() {
			$( ".datepicker" ).datepicker($.datepicker.regional['fr']);


                }		
			
			
			
		function _getListBlockForPage(){
			var path_get_list = $("#path_get_list").val();
			$("#select_page_id").change(
                            function(){
				$.post(path_get_list, {page:$(this).val()}, 
                                    function(data){
					$("#list_block_in_page").html(data);
                                        item.addBlock();
                                        item.removeBlock();
                                        item.sortBlock();
                                    }
                                , "html")	
                            }
                        );
		}
			
			
		function _colorpicker(){
			$('.color_picker').ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).css("background-color","#"+hex);
					$(el).val(hex);
					$(el).ColorPickerHide();
				}	
				
			});
		}		
			
			
		function _addBlock(){
                    var path_add_block = $("#path_ajax_add_block").val();
			$('.add_block').change(
			     function(){
				
				$.post(path_add_block, {page:$("#page").val(),position:$(this).attr("rel"),block_id:$(this).val()}, 
                                    function(data){
					location.reload();
                                    }
                                , "html")
                                
                            }
			);
		}  
                        
		function _removeBlock(){
                    var path_add_block = $("#path_ajax_delete_link_block").val();
			$('.item_delete').click(
			     function(){
				
				$.post(path_add_block, {page:$("#page").val(),aDatas:$(this).attr("rel")}, 
                                    function(data){
					location.reload();
                                    }
                                , "html")
                                
                            }
			);
		}  
                       
		
                
                
                
                
                
                
                
                function _sortBlock() { 
                        var obj		= $(".div_block tbody");
			var path_sort	= $("#path_ajax_sort_block").val();			

                        $(obj).sortable({			
                                axis: "y",
                                containment: ".tlisting",
                                handle: ".item",
                                distance: 10,
				containment: 'parent',
                                stop: function(event, ui){
                                        $(obj).find("tr").each(function(){
                                                index = parseInt($(this).index()+1);
                                                $(this).find(".count").text(index);
                                        });
                                        var ranking = new Array();
                                        var record = new Array();
                                        var i= 0;					
										
                                        $(this).find(".count").each(function(){
                                                
                                                ranking[i] = $(this).text();
                                                var aTemp =$(this).attr("id").split("_");
                                                record[i]=aTemp[1];	
                                                i++;
                                        });
                                        var str_ranking = ranking.join("_");
                                        var str_record = record.join("_"); 
                                        $.post(path_sort, 
                                                        {ids_ranking:str_ranking,ids_record:str_record,page:$("#page").val(),position:$(this).attr("id")},
                                                        function(data){}, "html"
                                        );

                                }
                        });
                }
                
                
                
                
		function _addPageUi(){
               

				$( ".add_rub" ).click(function() {
					$( "#dialog-form" ).dialog( "open" );
					$("#parent_id").val($(this).attr("rel"));
					return false;
				});				
				
				
				$( "#dialog-form" ).dialog({
					width:500,
					autoOpen: false,
					modal: true,
					buttons: {
						Ok: function() {
							item.addPage();
						}
					}
				});   
			   
		}   
                

		function _addPage(){
			
			var path_add = $("#url_ajax_add_rub").val();
			
			var aNameRub =$(".name_rub_class");
		        var aResultsNameRub = new Object();
                        aNameRub.each(function(){
				aResultsNameRub[$(this).attr("rel")] = 	$(this).val();					
                         });

			$.post(path_add, {aResultsNameRub:aResultsNameRub, parent_id : $("#parent_id").val()}, 
                                    function(data){
					if(data){
						$("#message_error").html(data);
					}else{
						$("#message_error").html("");	
						location.reload();
					}
                                    }
                                , "html")			
			
		}
                
				
				
		function _deleteComposite(){
			
	
			$( "#dialog-confirm" ).dialog({
				autoOpen: false,
				resizable: false,
				height:170,
				modal: true,
				buttons: {
					"OK": function() {
						var path_delete = $("#url_ajax_delete_rub").val(); 
						$.post(path_delete, {composite_id : $("#delete_id").val()}, 
							function(data){
								location.reload();
							}, "html")
						$( this ).dialog( "close" );
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
			
			
			
			$('.delete_composite').click(
			     function(){
				$("#delete_id").val($(this).attr("id"));
				$( "#dialog-confirm" ).dialog( "open" );	
                            }
			);
		
		}		
				
		                                                                                        
		//return { addSubRubricHomeReload:_addSubRubricHomeReload, addSubRubricHome:_addSubRubricHome,saveSeo:_saveSeo, changeSubRubricNameValidate:_changeSubRubricNameValidate, changeSubRubricName:_changeSubRubricName , addSubRubricProduct:_addSubRubricProduct,removeLinkSubRub:_removeLinkSubRub, deleteItem : _deleteItem,sortRecord: _sortRecord, addRubric:_addRubric, removeRubric:_removeRubric, uploadVideo:_uploadVideo, addLinkVideo:_addLinkVideo, removeLinkVideo:_removeLinkVideo, addSubRubric:_addSubRubric}
		return {changeDesignerForProduct:_changeDesignerForProduct ,deleteComposite:_deleteComposite, addPage:_addPage, addPageUi:_addPageUi, sortBlock:_sortBlock,removeBlock:_removeBlock, addBlock:_addBlock, colorpicker:_colorpicker,getListBlockForPage:_getListBlockForPage,datepicker:_datepicker, uploadVideo:_uploadVideo,sortItemFromList:_sortItemFromList, detachItemFromList:_detachItemFromList,sortRecord: _sortRecord,removeItemFromFullList:_removeItemFromFullList,addLinkItemToList:_addLinkItemToList}
	}();
        
        
        
  
        
        
        
	$(document).ready(function() {
		//item.deleteItem();
		item.sortRecord();
		item.removeItemFromFullList();
                item.addLinkItemToList();
                item.detachItemFromList();
		item.sortItemFromList();	
		item.uploadVideo();
		item.datepicker();
		item.getListBlockForPage();
		item.colorpicker();
                item.addBlock();
                item.removeBlock();
                item.addPageUi();
		item.deleteComposite();	
                //item.changeDesignerForProduct();
	});   
        
        