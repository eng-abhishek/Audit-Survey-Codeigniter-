$(function () {
  
     $(".registerOACForm").validate({
        rules: {
          districts: {
            required: true,
          },
          school_destination_id: {
            required: true,
          },
          name: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          last_name: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          address1: {
            required: true,
          },
          title_role: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          city: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          state: {
            required: true,
          },
          zipcode: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 30
          },
          email: {
            required: true,
            email: true,
            minlength : 3,
            maxlength: 150
          },
          ext: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 20
          },
          phone: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 30
          },
          address: {
            required: true,
            minlength : 3,
          },
          fax: {
            digits: true,
            minlength : 3,
          },
        },
        messages: {
          districts: {
            required: "District is required.",
          },
          school_destination_id: {
            required: "School destination is required.",
          },
          name: {
            required: "First Name is required.",
          },
          last_name: {
            required: "Last name is required.",
          },
          address1: {
            required: "Address is required.",
          },
          title_role: {
            required: "Title/Role is required.",
          },
          city: {
            required: "city is required.",
          },
          state: {
            required: "State is required.",
          },
          zipcode: {
            required: "Zipcodeis required.",
          },
          email: {
            required: "Email id is required.",
          },
          ext: {
            required: "Extension is required.",
          },
          phone: {
            required: "Phone is required.",
          },
          address: {
            required: "Address is required.",
          },
        
        },
    });   
});