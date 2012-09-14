$(document).ready(function() {
	// Init show/hide sections
	$('.cm-group-header').disableSelection();
	$('.cm-group-header .ui-icon').click(function() {
		$(this).parents('.cm-group:first').find('.cm-group-content').slideToggle();
		$(this).toggleClass('ui-icon-triangle-1-s').toggleClass('ui-icon-triangle-1-e');
	});
	$('.cm-group-header').dblclick(function() {
		$(this).parents('.cm-group:first').find('.cm-group-content').slideToggle();
		$('.ui-icon', this).toggleClass('ui-icon-triangle-1-s').toggleClass('ui-icon-triangle-1-e');
	});
});
