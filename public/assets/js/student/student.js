 $(function () {
    // The DOM element you wish to replace with Tagify
    var input = document.querySelector('input[name=spl_transportation_list]');

    // initialize Tagify on the above input node reference
    new Tagify(input)

    load_cities();
    $('#dob').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });

    $('.spl_transportation').hide();
});


 $(".studentForm").validate({
        rules: {
          firstname: {
            required: true,
          },
          lastname: {
            required: true,
          },
          state_id: {
            required: true,
          },
          address1: {
            required: true,
          },
          city: {
            required: true,
          },
          zipcode: {
            required: true,
          },
          district_code: {
            required: true,
          },
        },
        messages: {
            firstname: {
                required: "Field name is required"
            },
        },
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


$('.special_transportations').click(function() {
   if($(this).val() == "Yes")
   {
        $('.spl_transportation').show();
   }
   else
   {
        $('.spl_transportation').hide();
   }
});