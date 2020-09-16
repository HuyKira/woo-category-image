jQuery(document).ready(function($) {
	$('.icon-show').click(function(event) {
		$(this).toggleClass('active');
		$(this).next('ul').slideToggle(300);
	});
});