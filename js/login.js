$(function() { // initialise on load

	$('#demon-login-form').on('submit', function(e) { // Function is called when the login button is pressed on the demonstrator side of being able to access the system
        
        e.preventDefault(); // Prevents page from opening

        // View account.js for clarification on the ajax function below and how it operates, if needed.

        $.ajax({
            type: 'POST',
            url: 'demonLogin.php',
            dataType: 'json',
            data: $('#demon-login-form').serialize(),
            success : function (data) { 
                if(data.type == 'error'){
                    document.getElementById("msg-response").innerHTML=data.text;
                }
                else { // If login is successful demonstrator is redirected to the main page
                    window.location.replace("main.php");
                }
            }
        });
    });
    $('#student-login-form').on('submit', function(e) { // Function is called when login button is pressed on the student side of being able to login to the system
        
        e.preventDefault(); // Prevents page from opening

        $.ajax({
            type: 'POST',
            url: 'studentLogin.php',
            dataType: 'json',
            data: $('#student-login-form').serialize(),
            success : function (data) { 
                if(data.type == 'error'){
                    document.getElementById("msg-response-stu").innerHTML=data.text;
                }
                else {
                    window.location.replace("main.php");
                }
            }
        });
    });

    // The two functions below are how a user is able to toggle between how they choose to log in to the tool.
    // If the student anchor tag is clicked then the student login form is presented to the user.
    // If the demonstrator anchor tag is clicked then the demonstrator login form is presented to the user.
    // It should be noted that when one form is visible the other is hidden.
    $('#student-form').click(function(e) {
		$("#student-login-form").delay(250).fadeIn(250); // Animation to fade in the student login form
 		$("#demon-login-form").fadeOut(250); // Animation to fade out the demonstrator login form
		$('#demon-form').removeClass('active'); // Removing the active class from the demonstrator login form - This is for css purposes. (A way of being able to identify which form is currently active and therefore the properties of the content is editted accordingly)
		$(this).addClass('active'); // Adding the active tag to the student login form
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