$(function () {
	var base_url = $('#base_url').val();
	$("#oacinvites").validate({
		rules: {
			email_ids: {
				required: true,
				codExistss: true,
			},
		},
		messages: {
           email_ids: {
              required: "Email Id(s) is required",
            },
        },
	});

	var error_email = '';
	$.validator.addMethod('codExistss', function (value, element) {
			var emails = $('#email_ids').val();
			// Split string by comma into an array
			emails = emails.split(",");
			var valid = true;
			var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var invalidEmails = [];

			for (var i = 0; i < emails.length; i++) {
			    // Trim whitespaces from email address
			    emails[i] = emails[i].trim();
			    
			    // Check email against our regex to determine if email is valid
			    if( emails[i] == "" || ! regex.test(emails[i])){
			        invalidEmails.push(emails[i]);
			    }
			}

			// Output invalid emails
			if(invalidEmails != 0) {
				error_email = invalidEmails.join(', ');
			    return false;
			}
     		return true;
       },function(error, element){ return "Invalid email's "+error_email; });
});