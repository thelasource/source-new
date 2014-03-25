
( function() {
	
	//archive.js
	jQuery( document ).ready( function( $ ) {
		$('.archive').hide()
		$('.expand-archive').css('cursor', 'pointer');
		$('.expand-archive').click(function () {
			$('.archive').slideToggle('slow');
		});
	});

	//navigation.js
	var container = document.getElementById( 'site-navigation' ),
	button = container.getElementsByTagName( 'h1' )[0],
	menu = container.getElementsByTagName( 'ul' )[0];

	if ( undefined == button || undefined == menu )
		return false;

	button.onclick = function() {
		if ( -1 == menu.className.indexOf( 'nav-menu' ) )
			menu.className = 'nav-menu';
	
		if ( -1 != button.className.indexOf( 'toggled-on' ) ) {
			button.className = button.className.replace( ' toggled-on', '' );
			menu.className = menu.className.replace( ' toggled-on', '' );
			container.className = container.className.replace( 'main-small-navigation', 'navigation-main' );
		} else {
			button.className += ' toggled-on';
			menu.className += ' toggled-on';
			container.className = container.className.replace( 'navigation-main', 'main-small-navigation' );
		}
	};
	
	if ( ! menu.childNodes.length )	// Hide menu toggle button if menu is empty.
		button.style.display = 'none';



	//skip-link-focus-fix.js
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	is_opera = navigator.userAgent.toLowerCase().indexOf( 'opera' ) > -1,
	is_ie = navigator.userAgent.toLowerCase().indexOf( 'msie' ) > -1;

	if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
		var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;
	
				element.focus();
			}
		}, false );
	}
	// dropdown for the issues and volumes
	var dropdown = document.getElementById("ed");
	function onEditionChange() {
		if ( dropdown.options[dropdown.selectedIndex].value) {
			location.href =  combine_data.home + "/?edition=" + dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onEditionChange;

})();