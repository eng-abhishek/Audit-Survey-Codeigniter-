$(function () {
    $(".loginform").validate({
        rules: {
          identity: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          password: {
            required: true,
          },
        },
        messages: {
            identity: {
                required: "Email id is required."
            },
            password: {
                required: "Password is required.",
            },
        },
    });

    //forgot password validation
     $(".forgotpasswordForm").validate({
        rules: {
          identity: {
            required: true,
            email:true
          },
        },
        messages: {
            identity: {
                required: "Email id is required"
            },
        },
    });


     //forgot password validation
     $(".change_password_form").validate({
        rules: {
          old: {
            required: true,
          },
          new: {
            required: true,
            minlength : 6
          },
          new_confirm: {
            required: true,
            minlength : 6
          },
        },
        messages: {
            old: {
                required: "Old password is required"
            },
            new: {
                required: "New password is required"
            },
            new_confirm: {
                required: "New confirm password is required"
            },
        },
    });


      //reset password validation
     $(".reset_password").validate({
        rules: {
          new: {
            required: true,
            minlength : 6
          },
          new_confirm: {
            required: true,
            equalTo : "#new"
          },
        },
    });
});


 
