$(function() { //initialise on load

	$('#demon-login-form').on('submit', function(e) { //function is called when login button is pressed
        
        e.preventDefault(); //prevents page from opening - so basically stops the page it is currently on from refreshing

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'demonLogin.php', //php we send the data login data to
            dataType: 'json',
            data: $('#demon-login-form').serialize(), //takes contents of the form
            success : function (data) { 
                if(data.type == 'error'){ //if username does not exist or password is inccorect an error message is displayed
                    document.getElementById("msg-response").innerHTML=data.text;
                }
                else { //if all is successful demonstrator is redirected to the main page
                    window.location.replace("main.php");
                }
            }
        });
    });
    $('#student-login-form').on('submit', function(e) { //function is called when login button is pressed
        
        e.preventDefault(); //prevents page from opening - so basically stops the page it is currently on from refreshing

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'studentLogin.php', //php we send the data login data to
            dataType: 'json',
            data: $('#student-login-form').serialize(), //takes contents of the form
            success : function (data) { 
                if(data.type == 'error'){ //if username does not exist or password is inccorect an error message is displayed
                    document.getElementById("msg-response-stu").innerHTML=data.text;
                }
                else { //if all is successful demonstrator is redirected to the main page
                    window.location.replace("main.php");
                }
            }
        });
    });
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