(function ($) {
	'use strict';
	$(function () {
		var zone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		// Handle Internet Explorer's lack of timezone info.
		if ( undefined === zone ) {
			zone = 'your local time';
		}
		$( 'h2.event-time' ).each( function ( index ) {
			var utcTime  = $( this ).attr( 'data-time' );
			var userTime = new Date( utcTime ).toLocaleTimeString().replace( ':00 ', ' ' );
			var userDate = new Date( utcTime ).toLocaleDateString();

			$( this ).append( '<span class="localtime">' + userDate + ' at ' + userTime + ' ' + zone + '</span>' );
		});
		$( 'h2.talk-time' ).each( function ( index ) {
			var utcTime  = $( this ).attr( 'data-time' );
			var userTime = new Date( utcTime ).toLocaleTimeString().replace( ':00 ', ' ' );

			$( this ).append( '<span class="localtime">' + userTime + ' ' + zone + '</span>' );
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

	});
}(jQuery));