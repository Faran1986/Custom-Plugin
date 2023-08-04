(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

		
	$(document).ready(function(){

	
            //get event detail

            $(document).on('click', '.mbsc-calendar-labels>.mbsc-calendar-label-start, .mbsc-event, .mbsc-schedule-event ', function(){

				var post_id = $(this).data('id');
				$('.aw-event-details').css('right','-600px');
				$('#awLoader').show();

				if(post_id > 0){

					  $.ajax({
					  url: ajax_object.ajaxurl,
					  type: 'POST',
					  // dataType: 'json',
					  data:{ 
							action: 'get_event_detail',
							post_id : post_id
					  },
					  success: function( response ){
							
							$('.event-content').html(response);
							$('.aw-event-details').css('right','0px');
							$('#awLoader').hide();
					   }

					  });

				}

		  });

		  $('.removeModel').click(function(){
				$('.aw-event-details').css('right','-600px');
		  });


		  

    		$('.temp-type').click(function(){
    			var id = $(this).data('id')
    			$('.temp-type').removeClass('aw-active');
    			$(this).addClass('aw-active');
    			$('.calendar-temp').fadeOut();
    			$('#temp'+id).fadeIn();
    		});







            $.ajax({
				url: ajax_object.ajaxurl, 
                type: 'POST',
                dataType: 'json',
                data:{ 
                  action: 'get_calendar_events',
                },
                success: function( response ){ 

                  show_calendar(response);

                } // success

            });

            // get events against category
            $('#eventCat').on('change', function(){

                  var cat_slug = $('#eventCat').val();
                  var search_content = $('#searchContent').val();
				  $('#awLoader').show();

                  if(cat_slug != ''){
                  

                  $.ajax({
					url: ajax_object.ajaxurl, 
                        type: 'POST',
                        dataType: 'json',
                        data:{ 
                              action: 'get_search_events',
                              cat_slug : cat_slug,
                        },
                        success: function( response ){ 
							$('#awLoader').hide();
                              show_calendar(response);

                        } // success

                        });

                  }

                  });
            


            // search event 
            $('#searchBtn').click(function(){

                  var search_content = $('#searchContent').val();
                  var cat_slug = $('#eventCat').val();
				  $('#awLoader').show();

                  if(search_content != ''){
                      

                  $.ajax({
                        // url:"<?= admin_url( 'admin-ajax.php' ); ?>", 
					  url: ajax_object.ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data:{ 
                              action: 'get_search_events',
                              search_content : search_content,
                        },
                        success: function( response ){ 
							$('#awLoader').hide();
                              show_calendar(response);

                        } // success

                        });
                  
                  }

            });







            function show_calendar(response){

                  
                  /* ===========================================
                     Monthly view 
                     ==========================================*/

                     mobiscroll.setOptions({
                        theme: 'ios',
                        themeVariant: 'light',
                        clickToCreate: false,
                        dragToCreate: false,
                        dragToMove: false,
                        dragToResize: false,
                        eventDelete: false
                        });

                        $(function () {

                        var inst = $('#demo-desktop-month-view').mobiscroll().eventcalendar({
                              view: {
                                    calendar: { labels: true }
                              },
                              onEventClick: function (event, inst) {
                                    mobiscroll.toast({
                                    message: event.event.title
                                    });
                              }
                        }).mobiscroll('getInst');

                        inst.setEvents(response);
                       

                        });


                        /* ===========================================
                        Weekly view 
                        ==========================================*/


                        mobiscroll.setOptions({
                        locale: mobiscroll.localeEn,              
                        theme: 'ios',                              
                        themeVariant: 'light'                 
                        });
                        
                        $(function () {
                        
                              var inst = $('#demo-desktop-week-view').mobiscroll().eventcalendar({
                                    
                                    view: {                 
                                    schedule: { type: 'week' }
                                    },
                                    onEventClick: function (event, inst) {  
                                    mobiscroll.toast({ 
                                          
                                          message: event.event.title
                                    });
                                    }
                              }).mobiscroll('getInst');
                        
                              inst.setEvents(response);
                        
                        });



                        /* ===========================================
                        Daily view 
                        ==========================================*/


                        mobiscroll.setOptions({
                        theme: 'ios',
                        themeVariant: 'light',
                        clickToCreate: true,
                        dragToCreate: true,
                        dragToMove: true,
                        dragToResize: true,
                        eventDelete: true
                        });

                        $(function () {

                        var inst = $('#demo-desktop-day-view').mobiscroll().eventcalendar({
                              view: {
                                    schedule: { type: 'day' }
                              },
                              onEventClick: function (event, inst) {
                                    mobiscroll.toast({
                                    message: event.event.title
                                    });
                              }
                        }).mobiscroll('getInst');

                        inst.setEvents(response);

                        });





                        /* ===========================================
                        Agenda view 
                        ==========================================*/
                        
                        mobiscroll.setOptions({
                        theme: 'ios',
                        themeVariant: 'light'
                        });

                        $(function () {

                        var inst = $('#demo-daily-events').mobiscroll().eventcalendar({
                              view: {
                                    calendar: { type: 'week' },
                                    agenda: { type: 'day' }
                              },
                              onEventClick: function (event, inst) {
                                    mobiscroll.toast({
                                    message: event.event.title
                                    });
                              }
                        }).mobiscroll('getInst');

                        inst.setEvents(response);

                        });



            }

            


    	});




})( jQuery );
