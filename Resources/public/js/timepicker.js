// änderungen / 090521:
// OK beim einlesen im american mode zeit umrechnen
// OK datum einlesen
// OK beim ändern des input feldes widget anpassen / neu einlesen
// OK >> wenn keine stunde/minute angegeben ist 00 angeben
// OK sprache datepicker
// OK sprache durch parameter reingeben
// OK mehrere felder bedienen
// OK datepicker als klickbar machen

/** fixes / 090521:
	- convert widget time to am/pm if american mode is on
	- show correct date from input
	- on change at input field modify widget
	- if there is no hour/minute given in input, show 00
	- start datepicker in given language
	- new parameter for language
	- able to work on many fields
	- write date from datepicker
*/
jQuery.fn.datetime = function() {

	var userLang 		= arguments[0]['userLang'] || 'en';
	var b24Hour			= !(arguments[0]['americanMode'] || false);	
	var markerClass		= 'hasDateTime';
	var renderedLang 	= '';
				
	return this.each(function(){
			 
				var datepicker_def 	= {
							changeMonth: true,
							changeYear: true,
							dateFormat: 'dd/mm/yy',
							showButtonPanel: true, 
							onSelect: writeDate						
				};			
		
				var lang = {};

				lang['en'] = {
								time: 	'Time',
								hour:	'Hour',
								minute:	'Minute',
								close:	'Close'			
							};
							
				lang['fr'] = {
								time: 	'Temps',
								hour:	'Heure',
								minute:	'Minute',
								close:	'Fermer'			
							};	
				
				$(this).data('sets',datepicker_def);
				$(this).data('userLang',userLang);
				$(this).data('b24Hour',b24Hour);
				
				function renderPickerPlug(b24Hour_,lang_) {
					renderedLang = (lang[lang_]) ? lang_ : '';
					renderedLang = (renderedLang != 'en') ? renderedLang : '';
					var loadedLang = lang[lang_] || lang['en'];
					
					if (!$('#pickerplug').length) {
					
						var htmlins = '<ul id="pickerplug">';
						htmlins += '<li>';
						htmlins += '<div id="datepicker"></div>';
						htmlins += '</li>';
						htmlins += '<li>';
						htmlins += '<div id="timepicker">';
						htmlins += '<h3 id="tpSelectedTime">';
						htmlins += '	<span id="text_time"></span>';
						htmlins += '	<span class="selHrs" >00</span>';
						htmlins += '	<span class="delim" >:</span>';
						htmlins += '	<span class="selMins">00</span>';
						htmlins += '	<span class="dayPeriod">am</span>';
						htmlins += '</h3>';			
						htmlins += '<ul id="sliderContainer">';	
						htmlins += '	<li>';
						htmlins += '        <h4 id="text_hour"></h4>';
						htmlins += '        <div id="hourSlider" class="slider"></div>';
						htmlins += '	</li>';
						htmlins += '	<li>';
						htmlins += '        <h4 id="text_minute"></h4>';				
						htmlins += '        <div id="minuteSlider" class="slider"></div>';
						htmlins += '	</li>';
						htmlins += '</ul>';
						htmlins += '</div>';
						htmlins += '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" id="text_close"></button>';				
						htmlins += '</li>';				
						htmlins += '</ul>';
						$('body').append(htmlins);	
						
						$('#datepicker').datepicker();
						$(document).mousedown(closePickPlug);			
						$('#pickerplug .ui-datepicker-close').click(closePickPlug);							

	 // Slider
						$('#hourSlider').slider({
							orientation: "vertical",   
							range: 'min',                 
							min: 0,
							max: 23,
							step: 1,
							slide: function(event, ui) {
								writeDate(writeTime(ui.value,'hour'),'time');
								
							},
							change: function(event, ui) {
								$('#tpSelectedTime .selHrs').effect('highlight', 1000);
							}
						});
						// Slider
						$('#minuteSlider').slider({
							orientation: "vertical",      
							range: 'min',                                  
							min: 0,
							max: 55,
							step: 5,
							slide: function(event, ui) {                   
								writeDate(writeTime(ui.value,'minute'),'time');                                           
							},
							change: function(event, ui) {
								$('#tpSelectedTime .selMins').effect('highlight', 1000);
							}
						});
					
		//Inline editor bind
						$('#tpSelectedTime .selHrs').keyup(function(e){
							if((e.which <= 57 && e.which >= 48) && ($(this).text() >=1 && $(this).text() <=12 ) ){
							//console.log("Which: "+e.which);
						   $('#hourSlider').slider('value', parseInt($(this).text()));
							//console.log("Val: "+parseInt($(this).val()))
							}else{
								$(this).val($(this).text().slice(0, -1));
							}
							//if($(this).val() < 1){
							//    $(this).val(1);
							//}
						});
						
		//Inline editor bind
						$('#tpSelectedTime .selMins').keyup(function(e){
							if((e.which <= 57 && e.which >= 48) && ($(this).text() >=0 && $(this).text() <=59 ) ){
							//console.log("Which: "+e.which);
						   $('#minuteSlider').slider('value', parseInt($(this).text()));
							//console.log("Val: "+parseInt($(this).val()))
							}else{
								$(this).text($(this).text().slice(0, -1));
							}
							//if($(this).val() < 1){
							//    $(this).val(1);
							//}
						});					
					}

					$('.dayPeriod').toggle(!b24Hour);
					$('#text_time').text(loadedLang['time']);
					$('#text_hour').text(loadedLang['hour']);
					$('#text_minute').text(loadedLang['minute']);
					$('#text_close').text(loadedLang['close']);
					
					$('#pickerplug').data('userLang',lang_);
					$('#pickerplug').data('b24Hour',b24Hour_);	
				}
				
				$(this).bind('focus',function(){ 
					
					var top 	= $(this).offset().top+$(this).outerHeight(); 
					var left 	= $(this).offset().left;
					
					if ($(this).data('userLang') 	!= $('#pickerplug').data('userLang') || 
						$(this).data('b24Hour') 	!= $('#pickerplug').data('userLang') ) {
						renderPickerPlug($(this).data('b24Hour'),$(this).data('userLang'));
					}
					
					$('#pickerplug').css({
										left: left+'px',
										top: top+'px'
										}).show();						
					
					if ($(this).data('userLang')!='en' && lang[$(this).data('userLang')]) {
						$('#datepicker').datepicker('option', $.extend({},
												$.datepicker.regional[$(this).data('userLang')]));	
						$('#datepicker').datepicker('option', $.extend($(this).data('sets')));													
					} else {
						$('#datepicker').datepicker('option', $.extend({},
												$.datepicker.regional['']));	
						$('#datepicker').datepicker('option', $.extend($(this).data('sets')));												
					}					

					parseTime(this);
					
					if ($('#pickerplug').css('display') == 'none') { 											
						$('#pickerplug').show();
					}
					
					$(this).bind('keyup',parseTime);
					//$(this).bind('slider',writeTime);

					$(this).addClass(markerClass);

					$('#pickerplug').data('inputfield',this);
				});

				function parseTime (obj) {

					var time = ($(obj).val() || $(this).val()).split(" ");
					
					if (time.length < 2) {
						time = ['00-00-00','00:00:00'];
					}
						
					$('#pickerplug').data('lastdate',time[0]);	//lastdate = time[0];
					$('#pickerplug').data('lasttime',time[1]);  //lasttime = time[1];					
					time = time[1].split(":");					
					
					if (time.length < 2) {
						time = ['00','00','00'];
					}
					
					var hour	= time[0] || '00';
					var minute 	= time[1] || '00';
				
					writeTime(hour,'hour');
					writeTime(minute,'minute');

					$('#hourSlider').slider('option', 'value', hour);
					$('#minuteSlider').slider('option', 'value', minute);	
										
					/*$('#datepicker').datepicker(
											'setDate', 
											$.datepicker.parseDate(
													datepicker_def['dateFormat'], 
													$('#pickerplug').data('lastdate')
												));*/
					var tmp_date = $('#pickerplug').data('lastdate');
					if(tmp_date.length < 10) {
						
						var now = new Date();
						
						var dy = now.getFullYear(); // Get full year (as opposed to last two digits only)
						var dm = ((now.getMonth() + 1) < 10) ? ("0" + (now.getMonth() + 1)) : now.getMonth() + 1 // Get month and correct it (getMonth() returns 0 to 11)
						var dd = (now.getDate() < 10) ? ("0" + now.getDate()) : now.getDate();
						var mm = (now.getMinutes() < 10) ? ("0" + now.getMinutes()) : now.getMinutes();
						var hh = (now.getHours() < 10) ? ("0" + now.getHours()) : now.getHours();
						tmp_date = dd + '/' + dm + '/' + dy + ' ' + hh + ":" + mm + ":00";
					}
					
					$('#datepicker').datepicker(
						'setDate',
						$.datepicker.parseDate(
						datepicker_def['dateFormat'],
						tmp_date,
						{
							shortYearCutoff: 20,
							dayNamesShort: $.datepicker.regional[renderedLang].dayNamesShort,
							dayNames: $.datepicker.regional[renderedLang].dayNames,
							monthNamesShort: $.datepicker.regional[renderedLang].monthNamesShort,
							monthNames: $.datepicker.regional[renderedLang].monthNames
						}
					));
				}
				
				function writeTime(fragment,type) {
					var time = '';
					
					switch (type) {
						case 'hour':
	                    	var hours = parseInt(fragment,10);
								
	                    	if (!$('#pickerplug').data('b24Hour') && hours > 11) {                    		
	                    		hours -= 12;
	                    		$('.dayPeriod').text('pm');
	                    		
	                    	} else if (!$('#pickerplug').data('b24Hour')) {
	                    		$('.dayPeriod').text('am');
	                    	} 
	                    	
	                    	if (hours < 10) {
	                    		hours = '0'.concat(hours);
	                    	}
	                    	if (fragment < 10) {
	                    		fragment = '0'.concat(parseInt(fragment));
	                    	}
	                    	
	                    	$('#tpSelectedTime .selHrs').text(hours);
	                    	
	                    	time = fragment+':'+$('#tpSelectedTime .selMins').text();						
							break;
						case 'minute':
	                    	minutes = ((fragment < 10) ? '0' :'') + parseInt(fragment,10);
	                    	$('#tpSelectedTime .selMins').text(minutes);
	                   
	                        time = $('#hourSlider').slider('option', 'value')+':'+minutes;  						
							break;
					}
					return time;
				}				
				
				function writeDate (text,type) {

					switch (type) {
						case 'time':
							$('#pickerplug').data('lasttime',text+':00');						
							break;	
						default:
							$('#pickerplug').data('lastdate',text);												
					}
					
					$($('#pickerplug').data('inputfield')).val(
								$('#pickerplug').data('lastdate')+' '+$('#pickerplug').data('lasttime')
					);
				}
				
				function closePickPlug (event) {

					if (($(event.target).parents('#pickerplug').length ||
						$(event.target).hasClass(markerClass)) &&
						!$(event.target).hasClass('ui-datepicker-close')) {					
						return;
					}
					
					$('#pickerplug').hide();		
					$(this).unbind('click',closePickPlug);
					$(this).unbind('keyup',parseTime);
					$(this).removeClass(markerClass);
				}
								
            });
            
           }
		   
	﻿/* French initialisation for the jQuery UI date picker plugin. */
	/* Written by Keith Wood (kbwood@virginbroadband.com.au) and Stéphane Nahmani (sholby@sholby.net). */
	jQuery(function($){
		$.datepicker.regional['fr'] = {
			closeText: 'Fermer',
			prevText: '&#x3c;Préc',
			nextText: 'Suiv&#x3e;',
			currentText: 'Aujourd’hui',
			monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
			'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
			monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
			'Jul','Aoû','Sep','Oct','Nov','Déc'],
			dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
			dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
			dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
			dateFormat: 'dd/mm/yy', firstDay: 1,
			isRTL: false};
		$.datepicker.setDefaults($.datepicker.regional['fr']);
	});﻿
	/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
	/* Written by Andrew Stromnov (stromnov@gmail.com). */
	jQuery(function($){
		$.datepicker.regional['ru'] = {
			closeText: 'Закрыть',
			prevText: '&#x3c;Пред',
			nextText: 'След&#x3e;',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
			'Июл','Авг','Сен','Окт','Ноя','Дек'],
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			dateFormat: 'dd.mm.yy', firstDay: 1,
			isRTL: false};
		$.datepicker.setDefaults($.datepicker.regional['ru']);
	});