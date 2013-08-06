jQuery( document ).ready( function( $ ) {
	$('.archive').hide()
	$('.expand-archive').css('cursor', 'pointer');

	$('.expand-archive').click(function () {
		$('.archive').slideToggle('slow');
	});
});
