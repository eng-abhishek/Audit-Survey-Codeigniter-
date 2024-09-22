$(function () {
  $('#parent_user,.only_rtc,.only_oac,#school_destination,.oas_district').hide();
  var base_url = $('#base_url').val();

  	if($("#group_id").val() == "5" || $("#group_id").val() == "3")
  	{
  		call_district($('#parent_user_id').attr("data-uid"));
  	}

	$("#group_id").change(function(){
    	var parent_user_type= $("#group_id option:selected").val();

      if(parent_user_type == '3')
      {
        $('.parent_user_type').text('Reporting RTC');
      }
      else if(parent_user_type == '5')
      {
        $('.parent_user_type').text('Reporting LTC');
      }
       else if(parent_user_type == '7')
      {
        $('.parent_user_type').text('Reporting OAC');
      }
    	



		$('.oas_district').show();
    	$('#school_destination').hide();   
		$('#parent_user').hide();
		$('#parent_user_id').empty();
        
        if($(this).val() == "2")
        {
          	$('.only_rtc').show();
          	$("#organization_name").rules("add", {required: true, messages: { required: "Organization name is required"}});
          	$("#billing_address_1").rules("add", {required: true, messages: { required: "Billing address is required"}});
            $("#billing_state").rules("add", {required: true, messages: { required: "State is required"}});
            $("#billing_city").rules("add", {required: true, messages: { required: "City is required"}});
            load_districts();

            $('.only_oac').hide();
            $("#school_destination_id").rules("remove", "required");
            $("#district").prop("multiple",  "multiple");
        }

        if($(this).val() == "3")
        {
        	fill_user(2);
        }

        if($(this).val() == "4")
        {
        	load_districts();
          $('.only_rtc').hide();
          $('.only_oac').hide();
          $("#district").prop("multiple",  "multiple");
        }

        
        if($(this).val() == "5")
        {
        	fill_user(4);
        }

        if($(this).val() == "6")
        {
          $('.only_oac').show();
          $("#school_destination_id").rules("add", "required");
          load_districts();
          $("#district").prop("multiple",  "");
        }

        if($(this).val() == "7")
        {
        	fill_user(6);
          $('.oas_district').hide();
          $("#district").rules("remove", "required");
        }
    });


    function fill_user(id,seletedUser='')
    {
    	$('#parent_user').show();
      	$('.only_rtc,.only_oac').hide();
      	$('#district').empty();
        $("#district").prop("multiple",  "multiple");

      	$("#organization_name").rules("remove", "required");
       	$("#billing_address_1").rules("remove", "required");
        $("#billing_state").rules("remove", "required");
        $("#billing_city").rules("remove", "required");

        $("#school_destination_id").rules("remove", "required");



		$.ajax({
			url: base_url+"/users/getusers/"+id,
			method: 'GET',
			dataType: 'json',
			success: function (data) {
			    var option_list = '<option>--Select--</option>';
			    $.each(data, function(key,value) {
			        var selected ='';
		              if(seletedUser == value.id)
		              {
		                  selected ='selected';
		              }
			        option_list += '<option value="'+value.id+'"'+selected+'>'+value.first_name +' '+value.last_name+'</option>';
			    });
			    $('#parent_user_id').append(option_list);
			}
		});
    }

    $('#parent_user_id').change(function(){ 
    	var parent_id = $(this).val();
    	if($(this).val() == '6')
    	{
	    	$('#school_destination').show();   
	    	$('#school_destination_text').text('');   
	     	$.ajax({
				  url: base_url+"/users/getschooldestination/"+$(this).val(),
				  method: 'GET',
				  dataType: 'json',
				  success: function (data) {
				     $('#school_destination_text').text(data[0].school_name);
				  }
	        });
	    }

      	call_district(parent_id);
    });


    function call_district(parent_id)
    {
    	if($('#group_id').val() == '3' || $('#group_id').val() == '5')
      	{
      		$('#district').empty();
      		$.ajax({
				  url: base_url+"/users/getuserdistricts/"+parent_id,
				  method: 'GET',
				  dataType: 'json',
				  success: function (data) {
				    	var option_list = '';
					    $.each(data, function(key,value) {
					        option_list += '<option value="'+value.id+'">'+value.district_name+'</option>';
					    });
					    $('#district').append(option_list);
				  }
	        });
      	}
    }

    function load_districts()
    {
    	 //load districts here
        $('#district').empty();
  		$.ajax({
			  url: base_url+"/users/getalldistricts/",
			  method: 'GET',
			  dataType: 'json',
			  success: function (data) {
			  	console.log(data);
			    	var option_list = '<option value="">--Select--</option>';
				    $.each(data, function(key,value) {
				        option_list += '<option value="'+value.id+'">'+value.district_name+'</option>';
				    });
				    $('#district').append(option_list);
			  }
        });
    }

     $(".userForm").validate({
        rules: {
          group_id: {
            required: true,
          },
          "districts[]": {
            required: true,
          },
          name: {
            required: true,
            minlength : 3,
            maxlength: 150,
            alpha: true
          },
          last_name: {
            required: true,
            minlength : 3,
            maxlength: 150,
            alpha: true
          },
          address1: {
            required: true,
            minlength : 10
          },
          title_role: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          city: {
            required: true,
          },
          state: {
            required: true,
          },
          email: {
            required: true,
            validate_email: true,
            minlength : 3,
            maxlength: 150,
            remote: {
                url: base_url+"/users/check_email_exist/",
                type: "post"
            }
          },
          phone: {
            required: true,
            alphanumeric: true,
            minlength : 5,
            maxlength: 20
          },
          address: {
            required: true,
            minlength : 10
          },
          fax: {
            digits: true,
            minlength : 3
          },
          zipcode: {
            required: true,
            minlength : 3,
            maxlength: 20
          },
        },
        messages: {
           group_id: {
              required: "User Type is required",
            },
            "districts[]": {
              required: "Districts is required",
            },
            name: {
              required: "First Name is required",
            },
            last_name: {
              required: "Last Name is required",
            },
            address1: {
              required: "Office Address 1 is required",
            },
            title_role: {
              required: "Title/Role is required",
            },
            city: {
              required: "City is required",
            },
            state: {
              required: "State is required",
            },
            email: {
              required: "Email ID is required",
              remote: "Email already in use!"
            },
            phone: {
              required: "Phone is required",
            },
            address: {
              required: "Address is required",
            },
            zipcode: {
              required: "Zipcode is required"
            },
        },
    });

   $('#phone').keyup(function() {
  	jQuery.validator.addMethod("alphanumeric", function(value, element) {
  		return this.optional(element) || /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/i.test(value);
  	}, "Numbers and hyphen only");
  });

   jQuery.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
  }, "Alphabets and space allowed");

	jQuery.validator.addMethod("validate_email", function(value, element) {

    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
  }, "Please enter a valid Email.");
});