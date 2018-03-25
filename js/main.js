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