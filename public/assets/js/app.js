$(function () {
     // $("#district_status").bootstrapSwitch();  
$(".validateForm").validate({

        errorClass: "is-invalid",
        validClass: "is-valid",
        errorPlacement: function (error, element) {
            if (element.attr("id") == '') {
                error.insertAfter(element);
            } else {
                return false;
            }
        },
    });

    
    // $('#date_range').daterangepicker();
    // $('#date_range').on('apply.daterangepicker', function (ev, picker) {
    //     $('#start_date').val(picker.startDate.format('YYYY-MM-DD'));
    //     $('#end_date').val(picker.endDate.format('YYYY-MM-DD'));
    // });

});

