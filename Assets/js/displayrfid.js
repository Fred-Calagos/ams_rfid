$(document).ready(function(){
    $('#rfidcard').focus();
    $('body').mousemove(function(){
        $('#rfidcard').focus();
    });

    $('#rfidcard').keyup(function(){
        if ($(this).val().length >= 10) {
            var student_id = $(this).val();
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: { student_id: student_id },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#img').attr('src', data.images);
                        $('#fname').text(data.fname);
                        $('#lname').text(data.lname);
                    } else {
                        $('#img').attr('src', '');  // Clear the image source
                        $('#fname').text('Unknown');
                        $('#lname').text('Unknown');
                    }
                },
                error: function() {
                    // Handle error if any
                }
            });
            $(this).val('');
        }
    });
});