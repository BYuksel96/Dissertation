$(function () { //waits for page to load before js function works

    //function submits help request data
    $('#helpForm').on('submit', function(e) {

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'submitRequest.php', //php file we send the data to
            dataType: 'json',
            data: $('#helpForm').serialize(), //takes contents of the form (using form id tag)
            success : function (data) { 
                if(data.type == 'error'){ //if there is an issue with the form being sent it is reset and an appropriate error message is displayed
                    $("#helpForm")[0].reset();
                    alert(data.text);
                }
                else{ //if request is successful the form is reset and then closed
                    $("#helpForm")[0].reset();
                    $('#close').trigger('click');
                    alert(data.text);
                    //may want a better way of dealing with this... maybe another modal box to say account is created just some suggestion
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });
});

function addSeat(objButton) {
    var x = objButton.value;
    $("#seatFill").val(x);
}

function buttonDisable(){
    $.ajax({
        url: 'accInfo.php',
        dataType: 'json',
        success : function (data) { 
            var accType = data.text;
            var i;
            if (accType != 'student'){
                for(i = 0; i < 7; i++) {
                    var idName = '#seat' + i;
                    $(idName).prop('disabled', true);
                }
            }
        }
    });
}