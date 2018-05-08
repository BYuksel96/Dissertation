/*
*
* login.js - javascript file used only in login.php
* This file is used to pass data to and from the backend. It also works with frontend functionality.
* It is used to log helpers or students into the tool. (accounts are first validated before anyone is logged in)
*
*/

$(function() { // initialise on load

    // This function is used to pass demonstrator/helper login credentials to the backend. Then if login details are valid, the helper is then redirected to the main page (main.php)
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
    // Function below called when login button is pressed on the student side of login system. It is used to log students into the tool
    $('#student-login-form').on('submit', function(e) {
        
        e.preventDefault(); // Prevents page from opening

        $.ajax({
            type: 'POST', // Identifying that we are going to be posting data
            url: 'studentLogin.php', // Identifying the file to open (i.e. where we post the data to)
            dataType: 'json',
            data: $('#student-login-form').serialize(), // Obtaining the data from the specified form, using the ID tag
            success : function (data) { 
                if(data.type == 'error'){
                    document.getElementById("msg-response-stu").innerHTML=data.text;
                }
                else {
                    window.location.replace("main.php"); // Redirecting user to the next page
                }
            }
        });
    });

    // The two functions below are how a user is able to toggle between how they choose to log in to the tool.
    // If the student anchor tag is clicked then the student login form is presented to the user.
    // If the demonstrator anchor tag is clicked then the demonstrator login form is presented to the user.
    // It should be noted that when one form is visible the other is hidden.
    // Code origin: https://bootsnipp.com/snippets/featured/login-and-register-tabbed-form (Snippets of code where taken from here and altered for use in this application)
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