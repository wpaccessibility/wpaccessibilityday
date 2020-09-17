(function ($) {
	'use strict';
	$(function () {
		$( 'h2.talk-time' ).each( function ( index ) {
			var utcTime  = $( this ).attr( 'data-time' );
			var userTime = new Date( utcTime ).toLocaleTimeString().replace( ':00 ', ' ' );
			var zone     = Intl.DateTimeFormat().resolvedOptions().timeZone;
			$( this ).append( '<span class="localtime">' + userTime + ' ' + zone + '</span>' );
		});
	});
}(jQuery));