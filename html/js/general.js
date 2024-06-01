$('#search_button').hide();
$('#white_error').hide();
$('#error').hide();
$('#error2').hide();
$('#error3').hide();
$('#error4').hide();
$('#error5').hide();

function hideErr() {
    var x = setInterval(function() {
        $('#white_error').fadeOut();
        $('#error').fadeOut();
        $('#error2').fadeOut();
        $('#error3').fadeOut();
        $('#error4').fadeOut();
        $('#error5').fadeOut();
        clearInterval(x);
    }, 5000);
}