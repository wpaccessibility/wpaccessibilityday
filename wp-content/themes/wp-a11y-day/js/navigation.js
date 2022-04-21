/*
An accessible menu for WordPress
https://github.com/argenteum/accessible-nav-wp

Licensed GPL v.2 (http://www.gnu.org/licenses/gpl-2.0.html)

This work derived from:
https://github.com/WordPress/twentysixteen (GPL v.2)
https://github.com/wpaccessibility/a11ythemepatterns/tree/master/menu-keyboard-arrow-nav (GPL v.2)
*/

(function($) {

	var menuContainer = $('#main-navigation');
	var menuToggle    = menuContainer.find( '.menu-toggle' );

	// Toggles the menu button.
	if ( ! menuToggle.length ) {
		return;
	}

	menuToggle.add( menuContainer ).attr( 'aria-expanded', 'false' );
	menuToggle.on( 'click', function() {
		$(this).add( menuContainer ).toggleClass('toggled-on');
		// jscs:disable
		$(this).add( menuContainer ).attr( 'aria-expanded', $( this ).add( menuContainer ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		// jscs:enable
	});

	// Adds the dropdown toggle button.
	$('.menu-item-has-children > a').not(this).each( function() {
		var linkText         = $(this).text();
		var screenReaderText = { 'expand' : 'sub-menu', 'collapse' : 'sub-menu' };
		var dropdownToggle   = $(
				'<button />',
				{
					'class': 'dropdown-toggle',
					'aria-expanded': false,
					'type' : 'button'
				}
			).append( $(
				'<span />',
				{
					'class' : 'screen-reader-text',
					text : linkText + ' ' + screenReaderText.expand
				}
			)
		);
		dropdownToggle.append( $( '<span class="dashicons dashicons-arrow-down" aria-hidden="true"></span>' ) );

		//console.log($(this).text());
		$(this).after( dropdownToggle );
	});

	// Adds aria attribute
	menuContainer.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

	// Toggles the sub-menu when dropdown toggle button clicked
	menuContainer.find( '.dropdown-toggle' ).on( 'click', function(e) {
		var dashicon = $( this ).find( '.dashicons' );

		// close open submenus
		$( '.dropdown-toggle' ).not(this).each(function(){

			$(this).removeClass( 'toggled-on' );
			$(this).nextAll( '.sub-menu' ).removeClass( 'toggled-on' );
			 // jscs:disable
			$(this).attr( 'aria-expanded', $(this).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
		});

		e.preventDefault();
		$(this).toggleClass( 'toggled-on' );
		$(this).nextAll( '.sub-menu' ).toggleClass( 'toggled-on' );
		if ( dashicon.hasClass( 'dashicons-arrow-down' ) ) {
			dashicon.removeClass( 'dashicons-arrow-down' ).addClass( 'dashicons-arrow-up' );
		} else {
			dashicon.removeClass( 'dashicons-arrow-up' ).addClass( 'dashicons-arrow-down' );
		}
		// jscs:disable
		$(this).attr( 'aria-expanded', $(this).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		// jscs:enable

	});

	// Adds a class to sub-menus for styling
	$('.sub-menu .menu-item-has-children').parent('.sub-menu').addClass('has-sub-menu');

	$( '.menu-item-has-children a, .sub-menu' ).on( 'mouseover', function(e) {
		$(this).parent( 'li' ).addClass( 'focus' );
	});

	$( '.menu-item-has-children a, .sub-menu' ).on( 'mouseleave', function(e) {
		$(this).parent( 'li' ).removeClass( 'focus' );
	});

	// Keyboard navigation
	$( '.menu-item a, button.dropdown-toggle' ).on('keydown', function(e) {

		if ( [37,38,39,40,27].indexOf(e.keyCode) == -1 ) {
			return;
		}
		switch (e.keyCode) {
			case 27: // escape key
				$(this).parents('ul').first().prev('.dropdown-toggle.toggled-on').focus();
				$(this).parents('ul').first().prev('.dropdown-toggle.toggled-on').click();
				break;
			case 37: // left key
				e.preventDefault();
				e.stopPropagation();
				if ( $(this).hasClass('dropdown-toggle') ) {
					$(this).prev('a').focus();
				} else {
					if ($(this).parent().prev().children('button.dropdown-toggle').length) {
						$(this).parent().prev().children('button.dropdown-toggle').focus();
					} else {
						$(this).parent().prev().children('a').focus();
					}
				}

				if ($(this).is('ul ul ul.sub-menu.toggled-on li:first-child a')) {
					$(this).parents('ul.sub-menu.toggled-on li').children('button.dropdown-toggle').focus();
				}
			break;
			case 39: // right key
				e.preventDefault();
				e.stopPropagation();
				if ( $(this).next('button.dropdown-toggle').length ) {
					$(this).next('button.dropdown-toggle').focus();
				} else {
					$(this).parent().next().children('a').focus();
				}
				if ($(this).is('ul.sub-menu .dropdown-toggle.toggled-on')){
					$(this).parent().find('ul.sub-menu li:first-child a').focus();
				}
			break;
			case 40: // down key
				e.preventDefault();
				e.stopPropagation();
				if ( $(this).next().length ) {
					$(this).next().find('li:first-child a').first().focus();
				} else {
					$(this).parent().next().children('a').focus();
				}
				if ( ($(this).is('ul.sub-menu a')) && ($(this).next('button.dropdown-toggle').length) ) {
					$(this).parent().next().children('a').focus();
				}
				if (($(this).is('ul.sub-menu .dropdown-toggle')) && ($(this).parent().next().children('.dropdown-toggle').length)) {
					$(this).parent().next().children('.dropdown-toggle').focus();
				}
			break;
			case 38: // up key
				e.preventDefault();
				e.stopPropagation();
				if ( $(this).parent().prev().length ) {
					$(this).parent().prev().children('a').focus();
				} else {
					$(this).parents('ul').first().prev('.dropdown-toggle.toggled-on').focus();
				}
				if ( ($(this).is('ul.sub-menu .dropdown-toggle') ) && ( $(this).parent().prev().children('.dropdown-toggle').length ) ) {
					$(this).parent().prev().children('.dropdown-toggle').focus();
				}
			break;
		}
	});
})(jQuery);
