$(function () {
    $("#is_active_status").bootstrapSwitch();

    $('#is_active_status').on('switchChange.bootstrapSwitch', function (e, data) {
           if(data == true)
           {
                $('#is_active').val('1');
           }    
           else
           {
                $('#is_active').val('0');
           }
    });


    $(".buscompany").validate({
        rules: {
          name: {
            required: true,
            alpha: true,
            minlength : 3,
            maxlength: 150
          },
          address1: {
            required: true,
          },
          city: {
            required: true,
            alpha: true,
          },
          zipcode: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 10
          },
          mobile: {
            required: true,
            digits: true,
            minlength : 5,
            maxlength: 20
          },
          ext: {
            digits: true,
            minlength : 3,
            maxlength: 20
          },
          email: {
            required: true,
            validate_email: true,
            minlength : 3,
            maxlength: 150,
          },
          contractor_code: {
            required: true,
            minlength : 3,
            maxlength: 20
          },
        },
        messages: {
            name: {
                required: "Company name is required."
            },
            address1: {
                required: "Address1 is required.",
            },
            address2: {
                required: "Address2 is required.",
            },
            state:{
                required: "State is required.",
            },
            city:{
                required: "City is required.",
            },
            zipcode:{
                required: "Zipcode is required.",
            }, 
            mobile:{
                required: "Mobile Number is required.",
            }, 
            ext:{
                required: "Extension is required.",
            }, 
            email:{
                required: "Email id is required.",
            }, 
            contractor_code:{
                required: "Contractor Code is required.",
            }, 
        },
    });
});

function load_cities(id='')
{
    var state_id = $('#state').val();
    var base_url = $('#base_url').val();
    $('#city').empty();
    $.ajax({
        url: base_url+"/bus-companies/getcities"+"/"+state_id,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var option_list = '';
            $.each(data, function(key,value) {
                var selected ='';
                if(id != '')
                {
                    if(value.id == id)
                    {
                        selected ='selected';
                    }
                }
                option_list += '<option value="'+value.id+'"'+selected+'>'+value.city+'</option>';
            });

            $('#city').append(option_list);
            console.log(option_list);
        }
    });
}


    $(document).on( 'click', '.del_bus_company', function () {
        var id = $(this).attr("data-id");
        var url = $('#base_url').val();

        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",  
                url: url+"/bus-companies/check_mapping",
                data: 'id='+id, 
                success: function(data){  
                    var response = JSON.parse(data);
                    if(response.status == 1)
                    {
                        Swal.fire(response.message);
                    }

                    if(response.status == 0)
                    {
                        location.href= url+"/bus-companies/delete/"+id;
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                }       
            });
            
        }
        else
        {
            return false;
        }
    });

    });