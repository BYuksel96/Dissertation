$(function () { //waits for page to load before js function works

    var seconds = 5; 
    setInterval(function() {$("#studentTable").load('main.php #studentTable'); }, seconds*1000)

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
                    $('#close').trigger('click');
                    $('#modalText').text(data.text);
                    $('#responseModal').modal('show');
                    $("#studentTable").load('main.php #studentTable');
                }
                else{ //if request is successful the form is reset and then closed
                    $("#helpForm")[0].reset();
                    $('#close').trigger('click');
                    $('#modalText').text(data.text);
                    $('#responseModal').modal('show');
                    $("#studentTable").load('main.php #studentTable');
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
    $("#submitButton").html("Submit Request");
    $("#submitButton").removeClass("btn btn-warning");
    $("#submitButton").addClass("btn btn-success");
    $.ajax({
        url: 'edit.php',
        dataType: 'json',
        success : function (data) { 
            var x = objButton.value;
            $("#seatFill").val(x);
        }
    });
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

function deleteItem(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST', //get or post? this time we want to post data to the php file
        url: 'delete.php', //php file we send the data to
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'error'){
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
                $("#studentTable").load('main.php #studentTable');
            }
            else{ //if request is successful the form is reset and then closed
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
                $("#studentTable").load('main.php #studentTable');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

function editItem(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST', //get or post? this time we want to post data to the php file
        url: 'edit.php', //php file we send the data to
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'success'){
                $("#weekSub").val(data.week);
                $("#taskNo").val(data.task);
                $("#severity").val(data.psev);
                $("#time").val(data.time);
                $("#description").val(data.desc);
                $("#seatFill").val(data.seat);
                $("#submitButton").html("Edit");
                $("#submitButton").removeClass("btn btn-success");
                $("#submitButton").addClass("btn btn-warning");
            }
            else{
                alert("nope");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

function helpStudent(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST', //get or post? this time we want to post data to the php file
        url: 'acceptRequest.php', //php file we send the data to
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'success'){
                $("#studentTable").load('main.php #studentTable');
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
            }
            else{
                $("#studentTable").load('main.php #studentTable');
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}