$(function() {
  //$('input[name="survey_date_range"]').daterangepicker();
  $('#assign_bus_route').click(function(){  
  		$('.selected_route').text('');
  		var route_selected = $("#assign_bus_route option:selected").map(function () {
        		return $(this).text();
    		}).get().join(',');

  		$('.selected_route').text(route_selected);
  });

  $(".surveyform").validate({
        rules: {
          survey_name: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          survey_template: {
            required: true,
          },
          "assign_bus_route[]": {
            required: true,
          },
          "shift[]": {
            required: true,
          },
          survey_date_range: {
            required: true,
          },
          survey_type: {
            required: true,
          },
          survey_no_shift: {
            required: true,
            digits: true,
            min: 1,
            max: 3
          },
        },
        messages: {
            survey_name: {
                required: "Survey Name is required."
            },
            survey_template: {
                required: "Survey Template is required."
            },
            "assign_bus_route[]": {
                required: "Assign Bus Route is required."
            },
            "shift[]": {
                required: "Shift is required."
            },
            survey_no_shift: {
                required: "No of Survey per shift is required."
            },
        },
    });
});