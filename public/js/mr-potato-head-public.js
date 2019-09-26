(function( $ ) {
	'use strict';


	var posts = [];
	var retrievedPosts = false;
	var count = 5;
	var currentOffset = 0;
	var pgbdCurrentDateString;
	var pgbdCurrentContainerNumber = 0;
	var pgbdContainerSelector = '';
	var noMorePosts = false;

	var expirationTimers = {};


	var spinnerOptions = {
		lines: 9 // The number of lines to draw
		, length: 5 // The length of each line
		, width: 2 // The line thickness
		, radius: 4 // The radius of the inner circle
		, scale: 1 // Scales overall size of the spinner
		, corners: 1 // Corner roundness (0..1)
		, color: '#000' // #rgb or #rrggbb or array of colors
		, opacity: 0.6 // Opacity of the lines
		, rotate: 0 // The rotation offset
		, direction: 1 // 1: clockwise, -1: counterclockwise
		, speed: 1 // Rounds per second
		, trail: 60 // Afterglow percentage
		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		, className: 'spinner' // The CSS class to assign to the spinner
		, top: '50%' // Top position relative to parent
		, left: '50%' // Left position relative to parent
		, shadow: false // Whether to render a shadow
		, hwaccel: false // Whether to use hardware acceleration
		, position: 'absolute' // Element positioning
	}

// var spinner = new Spinner( spinnerOptions );


	$(document).ready( function (){

		// make sure short code is on page before running.
		var shortcodeHTML = $('#pgbd-shortcode').html();

		if ( shortcodeHTML !=  undefined ) {
			count = $('#pgbd-shortcode').data( 'count');

			$('#pgbd-load-more').click( function(){
				if ( !noMorePosts ) {
					displayPosts();
				}

			});

			formatForMobile();
			displayPosts();
		}

		displayExpirationTimers();
		handleFixedPositionTargets();

	});


	function handleFixedPositionTargets() {

		var elem = $('.mph-fix-pos-target');
		var classToAdd = 'mph-pos-fixed-top';

		// var w = $( elem ).width();
		// $( elem ).css( "width", w );


		$(window).scroll(function() {


			if ($(document).scrollTop() > 150) {

				if( typeof handleFixedPositionTargets.widthSet == 'undefined' ) {
					var w = $( elem ).parent().width();
					$( elem ).css( "width", w );
					handleFixedPositionTargets.widthSet = true;
				}

				$( elem ).addClass( classToAdd );
			} else {
				$ ( elem ).removeClass( classToAdd );
			}
		});
	}


	function displayExpirationTimers() {

		$('.mph-expiration-container').each( function(index, elem ){


			var postNumber = $( elem ).data('post');
			// var expire = elem.dataset.expire;  // Who the f___  knows why the jQuery call returns undefined?
			var expire = $( elem ).data('expire');

			// var expireTime = new Date( expire * 1000 );
			expire *= 1000;



			expirationTimers [ postNumber ] = setInterval(function( ) {

				// Get today's date and time
				var now = new Date().getTime();

				// Find the distance between now and the count down date
				var distance = expire - now;

				// Time calculations for days, hours, minutes and seconds
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				var dateString = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
				$( elem ).empty ();
				$( elem ).prepend( dateString );

				// If the count down is finished, write some text
				if (distance < 0) {
					clearInterval( expirationTimers[ postNumber ] );
					$(this).prepend( "Expired" );
				}
			}, 1000);
		});

	}


	function displayPosts() {

		/*
         * Setting currentOffset = 0 only all retrievals will download all of the proposals for the map.
         * Sending lastProposalRefresh will get only those from the last refresh. That
         * needs be combined with the ability to also get updated proposals. For now,
         * all proposals are refreshed (replaced) in order to update the local copies.
         */


		if ( retrievedPosts === false ) {
			showSpinner();
		}


		$.ajax({
			url:  objectl10n.wpsiteinfo.site_url + '/wp-admin/admin-ajax.php',
			data:{
				'action':'pgbd_ajax',
				'fn':'get_posts',
				'documentURL' : document.URL,
				'count' : count,
				'currentOffset' : currentOffset
			},
			dataType: 'JSON',
			success:function(data){

				stopSpinner();



				if ( data.errorData != null && data.errorData == 'true' ) {
					reportError( data );
					return;
				}
				// data is expected to be an array of proposals or false.
				if ( data !== false ) {



					retrievedPosts = true;
					// reset time of update
					posts = data ;

					if ( posts.length == 0 ) {
						displayBottomMessage( objectl10n.no_more_posts_msg  );
						noMorePosts = true;
						return;
					}

					for ( var i = 0 ; i < posts.length ; i++ ) {

						// Detect a new date

						var postDate = new Date( posts[i].timestamp * 1000 );

						var postDateString = getMonthName( postDate.getMonth() ) + ' ' + postDate.getDate() + ', ' + postDate.getFullYear();

						if ( pgbdCurrentDateString != postDateString ) {
							pgbdCurrentDateString = postDateString;
							pgbdContainerSelector = 'pgbd-group-' + pgbdCurrentContainerNumber++;
							var sectionContent = getDateSectionContent( pgbdContainerSelector, postDateString );
							$('#pgbd-shortcode').append( sectionContent );
						}

						var post = posts[i];
						var postContent = getPostContent( post );
						$('#' + pgbdContainerSelector ).append( postContent );
					}

					currentOffset += count;

				}
				else {
					console.log('AJAX call to post_proposal returned false');
				}
			},
			error: function(errorThrown){
				stopSpinner();
				console.log( errorThrown.responseText.substring(0,500) );
			}

		});


	}



	function getPostContent( post ) {

		var content = objectl10n.content_template;
		content = content.replace('__TITLE__', post.title );
		content = content.replace('__EXCERPT__', post.excerpt );
		content = content.replace( '__THUMBNAIL__', post.thumbnail );
		content = content.replace( '__URL__', post.url );

		return content;
	}

	function getDateSectionContent( selector, postDateString ) {

		var content = objectl10n.date_section_template;
		content = content.replace('__GROUP_SECTION_ID__', selector );
		content = content.replace('__GROUP_HEADING__', postDateString );

		return content;

	}


	function displayBottomMessage( message ) {

		$('#pgbd-bottom-msg').empty();
		$('#pgbd-bottom-msg').append('<p class="pgbd-msg">' + message  + '</p>');
	}


	function reportError( errorData ) {
		var errorString = objectl10n.server_error + errorData.errorMessage ;
		alert( errorString );
	}


	function getMonthName ( month ) {
		var monthStrings = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		return monthStrings [ month ]

	}

	function showSpinner() {
		// spinner.spin( mapContainer );
	}

	function stopSpinner() {
		// spinner.stop();
	}



	function formatForMobile() {


	}

})( jQuery );
