$(function () {

    var seconds = 5; // refresh rate on the queue table
    setInterval(function() {$("#studentTable").load('display.php #studentTable'); }, seconds*1000);

});