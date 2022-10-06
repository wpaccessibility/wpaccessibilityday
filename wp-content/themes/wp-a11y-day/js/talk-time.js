(function ($) {
	'use strict';
	$(function () {
		var zone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		// Handle Internet Explorer's lack of timezone info.
		if ( undefined === zone ) {
			zone = 'your local time';
		}
		$( '.event-time' ).each( function ( index ) {
			var utcTime  = $( this ).attr( 'data-time' );
			var userTime = new Date( utcTime ).toLocaleTimeString().replace( ':00 ', ' ' );
			var userDate = new Date( utcTime ).toLocaleDateString();

			$( this ).append( '<span class="localtime">' + userDate + ' at ' + userTime + ' ' + zone + '</span>' );
		});
		$( 'h2.talk-time' ).each( function ( index ) {
			var utcTime  = $( this ).attr( 'data-time' );
			var userTime = new Date( utcTime ).toLocaleTimeString().replace( ':00 ', ' ' );

			$( this ).find( '.time-wrapper' ).append( '<span class="localtime">' + userTime + ' ' + zone + '</span>' );
		});

		$( '#input_8_36 .gfield-choice-input' ).each( function( index ) {
			var id    = $( this ).attr( 'id' );
			var label = $( 'label[for=' + id + ']' );
			var labelText = label.text();
			if ( -1 !== labelText.indexOf( '2nd' ) ) {
				var time = labelText.replace( ' UTC on November 2nd', '' );
				time = ( time.length === 4 ) ? '0' + time : time;
				var date = '2022-11-02T' + time  + ':00Z';
			} else {
				var time = labelText.replace( ' UTC on November 3rd', '' );
				time = ( time.length === 4 ) ? '0' + time : time;
				var date = '2022-11-03T' + time + ':00Z';
			}
			var utc   = Date.parse( date );
			var userTime = new Date( utc ).toLocaleTimeString().replace( ':00', '' );
			var userDate = new Date( utc ).toLocaleDateString();

			label.html( '<span class="localtime">' + userTime + ' on ' + userDate + ' (' + zone + ')</span>' );

		});

		var passwordButton = $( 'button.gform_show_password' );
		var label          = passwordButton.attr( 'label' );
		passwordButton.attr( 'aria-label', label );
		passwordButton.on( 'click', function(e) {
			label = $( this ).attr( 'label' );
			$( this ).attr( 'aria-label', label );
		});

		var slido = document.getElementById( 'slido' );
		if ( slido ) {
			var content = slido.contentWindow;
			console.log( content );
		}

		const streamtext = document.getElementById( 'streamtext' );
		const transcript = document.querySelector( '#transcript button' );
		const chat       = document.querySelector( '#chat button' );

		if ( transcript ) {
			if ( readCookie( 'streamtext.hidden' ) ) {
				streamtext.classList.add( 'hidden' );
				transcript.setAttribute( 'aria-expanded', 'false' );
			}

			transcript.addEventListener( 'click', function() {
				if ( streamtext.classList.contains( 'hidden' ) ) {
					streamtext.classList.remove( 'hidden' );
					transcript.setAttribute( 'aria-expanded', 'true' );
					eraseCookie( 'streamtext.hidden' );
				} else {
					streamtext.classList.add( 'hidden' );
					transcript.setAttribute( 'aria-expanded', 'false' );
					createCookie( 'streamtext.hidden', 1 );
				}
			});
		}

		if ( chat ) {
			if ( readCookie( 'slido.hidden' ) ) {
				slido.classList.add( 'hidden' );
				chat.setAttribute( 'aria-expanded', 'false' );
			}

			chat.addEventListener( 'click', function() {
				if ( slido.classList.contains( 'hidden' ) ) {
					slido.classList.remove( 'hidden' );
					chat.setAttribute( 'aria-expanded', 'true' );
					eraseCookie( 'slido.hidden' );
				} else {
					slido.classList.add( 'hidden' );
					chat.setAttribute( 'aria-expanded', 'false' );
					createCookie( 'slido.hidden', 1 );
				}
			});
		}
		// Cookie handler, non-$ style
		function createCookie(name, value, days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				var expires = "; expires=" + date.toGMTString();
			} else {
				var expires = '';
			}

			document.cookie = name + "=" + value + expires + "; path=/; SameSite=Strict;";
		}

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}

			return null;
		}

		function eraseCookie(name) {
			createCookie(name, "");
		}

	var toggleDetails = document.querySelectorAll( '.toggle-details' );
	if ( null !== toggleDetails ) {
		toggleDetails.forEach( (el) => {
			var parentEl = el.parentNode.parentNode;
			console.log( el );
			console.log( parentEl );
			var target   = parentEl.querySelector( '.inside' );
			target.classList.add( 'hidden' );
			el.addEventListener( 'click', function(e) {
				var expanded = this.getAttribute( 'aria-expanded' );
				if ( 'true' === expanded ) {
					target.classList.add( 'hidden' );
					this.setAttribute( 'aria-expanded', 'false' );
					this.firstChild.classList.add( 'dashicons-plus' );
					this.firstChild.classList.remove( 'dashicons-minus' );
				} else {
					target.classList.remove( 'hidden' );
					this.setAttribute( 'aria-expanded', 'true' );
					this.firstChild.classList.add( 'dashicons-minus' );
					this.firstChild.classList.remove( 'dashicons-plus' );
				}
			});
		});
	}


	});
}(jQuery));