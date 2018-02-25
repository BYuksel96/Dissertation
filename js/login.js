$(function() {

    $('#student-form').click(function(e) {
		$("#student-login-form").delay(250).fadeIn(250);
 		$("#demon-login-form").fadeOut(250);
		$('#demon-form').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#demon-form').click(function(e) {
		$("#demon-login-form").delay(250).fadeIn(250);
 		$("#student-login-form").fadeOut(250);
		$('#student-form').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});