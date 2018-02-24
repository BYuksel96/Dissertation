$(function() {

    $('#student-form').click(function(e) {
		$("#student-login-form").delay(100).fadeIn(100);
 		$("#demon-login-form").fadeOut(100);
		$('#demon-form').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#demon-form').click(function(e) {
		$("#demon-login-form").delay(100).fadeIn(100);
 		$("#student-login-form").fadeOut(100);
		$('#student-form').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});