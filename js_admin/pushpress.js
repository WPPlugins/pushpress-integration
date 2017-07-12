
jQuery( function( $ ) {

	var parms = {
		columnWidth: 340,
		gutter: 20,
		itemSelector: '#website-integrations-container ul li',
		transitionDuration: 0
	}
	var $container = $('#website-integrations-container ul');

	function enable_link_tab(){
		// Javascript to enable link to tab
		var url = document.location.toString();
		$( '.nav-tab-wrapper .nav-tab-active' ).removeClass( 'nav-tab-active' );
		if (url.match('#')) {

			$('.nav-tab-wrapper a[href=#' + url.split('#')[1] + ']').addClass('nav-tab-active');

			var tabPaneActive = $('.nav-tab-wrapper a[href=#' + url.split('#')[1] + ']').attr('aria-controls');

			if( $('.pushpress-wrap .tab-pane').is(":visible") ){

				$( '.pushpress-wrap .tab-active' ).fadeOut('slow', function(){

					$( '.pushpress-wrap .tab-active' ).removeClass( 'tab-active' );

					$( '#' + tabPaneActive ).fadeIn(200, function(){

						$( '#' + tabPaneActive ).addClass('tab-active');

						if ( url.split('#')[1] == 'website-integrations' ){

							// initialize
							$container.masonry(parms);

						}

					});

				});
			}else{
				$( '.pushpress-wrap .tab-active' ).removeClass( 'tab-active' );
				$( '#' + tabPaneActive ).addClass('tab-active');

				if ( url.split('#')[1] == 'website-integrations' ){

					// initialize
					$container.masonry(parms);

				}
			}

		}else{

			var hash = $('.nav-tab-wrapper a:eq(0)').attr('href');
			var tabPaneActive = $('.nav-tab-wrapper a[href=' + hash + ']').attr('aria-controls');

			$('.nav-tab-wrapper a[href=' + hash + ']').addClass('nav-tab-active');

			if( $('.pushpress-wrap .tab-pane').is(":visible") ){
				$( '.pushpress-wrap .tab-active' ).fadeOut('slow', function(){
					$( '.pushpress-wrap .tab-active' ).removeClass( 'tab-active' );

					$( '#' + tabPaneActive ).fadeIn(200, function(){
						$( '#' + tabPaneActive ).addClass('tab-active');
					});
				});
			}else{
				$( '.pushpress-wrap .tab-active' ).removeClass( 'tab-active' );

				$( '#' + tabPaneActive ).addClass('tab-active');
			}

		}
	}

	enable_link_tab();

	$(window).on('hashchange', function(){
		enable_link_tab();
	});
});
