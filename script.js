// Function Validation Form
function valForm() {

	var formMessages = $('#form-messages');

	if ($('#name').val() == '') {
		$('#name-group').addClass('has-error');
		$('#name-alert').addClass('text-danger').html('Your name is empty');

	} else {
		$('#name-group').removeClass('has-error');
		$('#name-alert').removeClass('text-danger').html('');
	}

	if ($('#email').val() === '') {
		$('#email-group').addClass('has-error');
		$('#email-alert').addClass('text-danger').html('Your email is empty');
	} else {
		$('#email-group').removeClass('has-error');
		$('#email-alert').removeClass('text-danger').html('');
	}

	if ($('#message').val() === '') {
		$('#message-group').addClass('has-error');
		$('#message-alert').addClass('text-danger').html('Your message is empty');

		return false
	} else {
		$('#message-group').removeClass('has-error');
		$('#message-alert').removeClass('text-danger').html('');
	}
	return true;

}
// End Function

$(function() {

	// Contact Form
    var form = $('#contactform');
    var formMessages = $('#form-messages');

	$(form).submit(function(event) {

	    event.preventDefault();
	    formMessages.html('');

	    if(valForm()){
	    	var formData = $(form).serialize();

			$.ajax({
			    type: 'POST',
			    url: $(form).attr('action'),
			    data: formData
			}).done(function(response) {

			    $(formMessages).removeClass('text-warning');
			    $(formMessages).addClass('text-success');

			    $(formMessages).text('Your message has been sent.');

			    // Clear the form.
			    $('#name').val('');
			    $('#email').val('');
			    $('#message').val('');

			}).fail(function(data) {

			    $(formMessages).removeClass('success');
			    $(formMessages).addClass('error');

			    if (data.responseText !== '') {
			        $(formMessages).text(data.responseText);
			    } else {
			        $(formMessages).text('Oops! An error occured and your message could not be sent.');
			    }
			});
	    }

	    
	});
	// End Contact Form
});