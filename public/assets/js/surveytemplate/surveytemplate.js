$(function () {
    //$("#template_status").bootstrapSwitch();
    var base_url = $('#base_url').val();

    /*$('#template_status').on('switchChange.bootstrapSwitch', function (e, data) {
        alert("hello");
           if(data == true)
           {
                $('#survey_template_status').val('1');
           }    
           else
           {
                $('#survey_template_status').val('0');
           }
    });*/

    $('#template_status').click(function(){
      if($(this).is(":checked")){
        $(this).val("1");
      }
      else if($(this).is(":not(:checked)")){
        $(this).val("0");
      }
    });

    $(".surveytemplateform").validate({
        rules: {
          survey_template_name: {
            required: true,
            remote: {
                    url: base_url+"/surveytemplate/checktemplatename",
                    type: "post"
                },
            },
        },
        messages: {
            survey_template_name: {
                required: "Template name is required",
                remote: "Template Name already in use!"
            },
        },
        submitHandler: function(form) {
            var row_count = $('#fieldsurveytable tbody tr').length;
            if(row_count > 0)
            {
                return true;
            }
            else
            {
                alert("Please add field for the template");
                return false; 
            }
        }
    });

    $(".editsurveytemplateform").validate({
        rules: {
          survey_template_name: {
            required: true,
            },
        },
        messages: {
            survey_template_name: {
                required: "Template name is required",
                remote: "Template Name already in use!"
            },
        },
        submitHandler: function(form) {
            var row_count = $('#fieldsurveytable tbody tr').length;
            if(row_count > 0)
            {
                return true;
            }
            else
            {
                alert("Please add field for the template");
                return false; 
            }
        }
    });
    
    $(".templatequestionForm").validate({
        rules: {
          field_inputname: {
            required: true,
          },
        },
        messages: {
            field_inputname: {
                required: "Field name is required"
            },
        },
        submitHandler: function(form) {
            callsave();
            return false; 
        }
    });


    /* for survey js*/    
    $('#texttype').on('change', function() {
        //alert( this.value );
        if(this.value == 'Dropdown')
        {
            $('#fieldoptionlist,#add_field_option').show();
            $('#fieldoptioncheckbox').hide();
        }
        else if(this.value == 'Checkbox' || this.value == 'Radio')
        {
            $('#fieldoptionlist,#add_field_option').hide();
            $('#fieldoptioncheckbox').show();
        }
        else
        { 
            $('#fieldoptioncheckbox').hide();
            $('#fieldoptionlist,#add_field_option').hide();   
        }
    });

    $('#add_field_option').on('click', function () {

        if($('#tbody tr').length == 0)
        {
            var option_length = 1;
        }
        else
        {
            var option_length = parseInt($('#tbody tr:last').attr('data-rid')) + parseInt(1);
        }

        $("#dynamicoption").find('tbody').append('<tr data-rid="'+option_length+'"><td><input type="text" id="option'+option_length+'" name="option['+option_length+'][name]" /></td><td><input type="checkbox" data-row="'+option_length+'" class="alert_flag" id="oalert_flag'+option_length+'" name="option['+option_length+'][alert_flag]" value="0" /></td><td><input type="checkbox" data-row="'+option_length+'" class="end_flag" id="option'+option_length+'_end_flag" value="0" /></td><td><textarea data-row="'+option_length+'" id="option'+option_length+'_alert_notes" name="option'+option_length+'_alert_notes" class="alert_notes" disabled></textarea></td><td><textarea data-row="'+option_length+'" name="option'+option_length+'_audit_notes" id="option'+option_length+'_audit_notes" class="end_audit_notes" disabled></textarea></td><td><button data-id="0" class="btn btn-danger remove" type="button">Remove</button></td></tr>');
    
        addvalidationrules('option'+option_length,'Option label is required');
    });

    $('#add_field_checkbox').on('click', function () {

        if($('#tbody_checkbox tr').length == 0)
        {
            var option_length = 1;
        }
        else
        {
            var option_length = parseInt($('#tbody_checkbox tr:last').attr('data-rid')) + parseInt(1);
        }

        $("#dynamiccheckbox").find('tbody').append('<tr data-rid="'+option_length+'"><td><input type="text" id="option'+option_length+'" name="option['+option_length+'][name]" value="" /></td><td><button data-id="0" class="btn btn-danger removecheckbox" type="button">Remove</button></td></tr>');
        addvalidationrules('option'+option_length,'Option is required');
    });


    // jQuery button click event to remove a row
    $('#tbody').on('click', '.remove', function () {
        $(this).closest('tr').remove();
    });


    $('#tbody_checkbox').on('click', '.removecheckbox', function () {
        $(this).closest('tr').remove();
    });

    function callsave(){
        var fieldname = $('.field_inputname').val();
        var is_mandatory = $('.field_ismandatory').val();
        var fieldtype = $('#texttype').val();
        var hidden_questionid = $('.hidden_questionid').val();
        var is_mandatory_text = 'No';
        var form_type =$('.hidden_formtype').val();


        if($('#field_tbody tr').length == 0)
        {
            $('#fieldsurveytable').show();
            var row_length = 1;
        }
        else
        {
            var row_length = parseInt($('#field_tbody tr:last').attr('data-rid')) + parseInt(1);
        }
         //check update or insert
        if(form_type == '1')
        {
            row_length = $('.hidden_formrowid').val();
            $(".field"+$('.hidden_formrowid').val()).remove();
        }
        
        if(fieldtype == "Text" || fieldtype == "Textarea" || fieldtype == "Email" || fieldtype == "Number" || fieldtype == "Datepicker" || fieldtype == "Image")
        {
            $('#add_survey_form').append('<div class="field'+row_length+'"><input type="hidden" class="field_'+row_length+'_name" name="field['+row_length+'][name]" value="'+fieldname+'" /><input type="hidden" class="field_'+row_length+'_mandatory" name="field['+row_length+'][mandatory]" value="'+is_mandatory+'" /><input type="hidden" class="field_'+row_length+'_type" name="field['+row_length+'][type]" value="'+fieldtype+'" /><input type="hidden" class="field_'+row_length+'_question_id" name="field['+row_length+'][question_id]" value="'+hidden_questionid+'" /></div>');
        }
        else if(fieldtype == "Checkbox" || fieldtype == "Radio" )
        {
            var coption = '';
          /*  $("#dynamiccheckbox tbody tr td:nth-child(1)").each(function(index) {
                coption += '<input type="hidden" class="rc_option'+row_length+'" id="rc_'+row_length+'_option_'+index+'" name="field['+row_length+'][option]['+index+'][label]" value="'+$(this).find("input").val()+'" />';
                coption += '<input type="hidden" class="rc_option'+row_length+'" id="rc_'+row_length+'_option_'+index+'" name="field['+row_length+'][option]['+index+'][option_id]" value="'+$(this).find(".removecheckbox").attr("data-id")+'" />';

            });*/

            $("#dynamiccheckbox tbody tr").each(function(index) {
                coption += '<div class="option_row_'+row_length+'">';
                $(this).find("td").each(function(indexo, element) {
                    if(indexo == 0)
                    {
                        coption += '<input type="hidden" class="rc_option'+row_length+'" id="rc_'+row_length+'_option_'+index+'" name="field['+row_length+'][option]['+index+'][label]" value="'+$(this).find("input").val()+'" />';
                    }
                    else
                    {
                        coption += '<input type="hidden" id="rc_'+row_length+'_option_id_'+index+'" name="field['+row_length+'][option]['+index+'][option_id]" value="'+$(this).find(".removecheckbox").attr("data-id")+'" />';
                    }
                });
                coption += '</div>';
            });


            $('#add_survey_form').append('<div class="field'+row_length+'"><input type="hidden" class="field_'+row_length+'_name" name="field['+row_length+'][name]" value="'+fieldname+'" /><input type="hidden" class="field_'+row_length+'_mandatory" name="field['+row_length+'][mandatory]" value="'+is_mandatory+'" /><input type="hidden" class="field_'+row_length+'_type" name="field['+row_length+'][type]" value="'+fieldtype+'" /><input type="hidden" class="field_'+row_length+'_question_id" name="field['+row_length+'][question_id]" value="'+hidden_questionid+'" />'+coption+'</div>');
        
        }
        else if(fieldtype == "Dropdown")
        {
           
            var coption = '';
            $("#dynamicoption tbody tr").each(function(index) {
                coption += '<div class="option_row_'+row_length+'">';
                $(this).find("td").each(function(indexo, element) {
                    if(indexo == 3 || indexo == 4)
                    {
                        coption += '<input type="hidden" id="field_'+index+'_option_'+index+'_'+indexo+'" name="field['+row_length+'][option]['+index+']['+indexo+']" value="'+$(this).find("textarea").val()+'" />';
                    }
                    else if(indexo == 5)
                    {
                        coption += '<input type="hidden" id="field_'+index+'_option_'+index+'_'+indexo+'" name="field['+row_length+'][option]['+index+']['+indexo+']" value="'+$(this).find(".remove").attr("data-id")+'" />';
                    }
                    else
                    {
                        coption += '<input type="hidden" id="field_'+index+'_option_'+index+'_'+indexo+'" name="field['+row_length+'][option]['+index+']['+indexo+']" value="'+$(this).find("input").val()+'" />';
                    }
                });
                coption += '</div>';
            });
            $('#add_survey_form').append('<div class="field'+row_length+'"><input type="hidden" class="field_'+row_length+'_name" name="field['+row_length+'][name]" value="'+fieldname+'" /><input type="hidden" class="field_'+row_length+'_mandatory" name="field['+row_length+'][mandatory]" value="'+is_mandatory+'" /><input type="hidden" class="field_'+row_length+'_type" name="field['+row_length+'][type]" value="'+fieldtype+'" /><input type="hidden" class="field_'+row_length+'_question_id" name="field['+row_length+'][question_id]" value="'+hidden_questionid+'" />'+coption+'</div>');
        }

        if(is_mandatory == '1')
        {
            is_mandatory_text = 'Yes';
        } 

        if(form_type == '1')
        {   
            $('.td_name_'+row_length).text(fieldname);
            $('.td_type_'+row_length).text(fieldtype);
            $('.td_mandatory_'+row_length).text(is_mandatory_text);
        }
        else
        {
            $('#field_tbody').append('<tr data-rid="'+row_length+'"><td class="td_no_'+row_length+'">'+row_length+'</td><td class="td_name_'+row_length+'">'+fieldname+'</td><td class="td_type_'+row_length+'">'+fieldtype+'</td><td class="td_mandatory_'+row_length+'">'+is_mandatory_text+'</td><td ><a class="editrow" data-rowid="'+row_length+'" data-coln="field'+row_length+'" href="#"><i class="fas fa-edit"></i></a><a class="removerow" data-coln="field'+row_length+'" href="#"><i class="fas fa-trash"></i></a></td></tr>');    
        }
        $('#myModal').modal('toggle');

        renumberRows();
    }

    // remove survey template root table
    $(document).on("click", ".removerow", function(e) {
        $("."+$(this).attr("data-coln")).remove();
        $(this).closest("tr").remove();
        renumberRows();
    });

    $(document).on("click", ".editrow", function(e) {

        var r_id = $(this).attr("data-rowid");
        $('.field_inputname').val($('.field_'+r_id+'_name').val());
        $('.hidden_questionid').val($('.field_'+r_id+'_question_id').val());
        if($('.field_'+r_id+'_mandatory').val() == "1")
        {
            $('.field_ismandatory').prop("checked", true);
        }

        $("#texttype option[value='"+$('.field_'+r_id+'_type').val()+"']").prop('selected', true);
        
        //need to check dropdown,radio,checkbox
        if($('.field_'+r_id+'_type').val() == 'Dropdown')
        {
            $(".option_row_"+r_id).each(function(i) {
                cnt = i+1;
                alertchecked='';
                endflagchecked='';
                if($('#field_'+i+'_option_'+i+'_1').val() == '1')
                {
                    alertchecked='checked';
                }

                if($('#field_'+i+'_option_'+i+'_2').val() == '1')
                {
                    endflagchecked='checked';
                }

                $("#dynamicoption").find('tbody').append('<tr data-rid="'+cnt+'"><td><input type="text" id="option'+cnt+'" name="option['+cnt+'][name]" value="'+$('#field_'+i+'_option_'+i+'_0').val()+'"/></td><td><input type="checkbox" data-row="'+cnt+'" class="alert_flag" name="option['+cnt+'][alert_flag]" value="'+$('#field_'+i+'_option_'+i+'_1').val()+'" id="oalert_flag'+cnt+'" '+alertchecked+' /></td><td><input type="checkbox" data-row="'+cnt+'" class="end_flag" id="option'+cnt+'_end_flag" value="'+$('#field_'+i+'_option_'+i+'_2').val()+'" '+endflagchecked+' /></td><td><textarea data-row="'+cnt+'" id="option'+cnt+'_alert_notes" name="option'+cnt+'_alert_notes" class="alert_notes" disabled>'+$('#field_'+i+'_option_'+i+'_3').val()+'</textarea></td><td><textarea data-row="'+cnt+'" name="option'+cnt+'_audit_notes" id="option'+cnt+'_audit_notes" class="end_audit_notes" disabled>'+$('#field_'+i+'_option_'+i+'_4').val()+'</textarea></td><td><button data-id="'+$('#field_'+i+'_option_'+i+'_5').val()+'" class="btn btn-danger remove" type="button">Remove</button></td></tr>');
                addvalidationrules('option'+cnt);

               /* $('#option'+cnt).val($('#field_'+i+'_option_'+i+'_0').val());
                $('#oalert_flag'+cnt).val($('#field_'+i+'_option_'+i+'_1').val());
                $('#option'+cnt+'_end_flag'+i).val($('#field_'+i+'_option_'+i+'_2').val());
                $('#option'+cnt+'_alert_notes').val($('#field_'+i+'_option_'+i+'_3').val());
                $('#option'+cnt+'_audit_notes').val($('#field_'+i+'_option_'+i+'_4').val());*/
            });
            $("#fieldoptionlist,#add_field_option").css("display", "block");
        }
        else if($('.field_'+r_id+'_type').val() == "Checkbox" || $('.field_'+r_id+'_type').val() == "Radio" )
        {
            $(".rc_option"+r_id).each(function(i) {
                rccnt = i+1;
                console.log(rccnt+"***"+i);
                $("#dynamiccheckbox").find('tbody').append('<tr data-rid="'+rccnt+'"><td><input type="text" id="option'+rccnt+'" name="option['+rccnt+'][name]" value="" /></td><td><button data-id="'+$('#rc_'+r_id+'_option_'+i+'_optionid').val()+'" class="btn btn-danger removecheckbox" type="button">Remove</button></td></tr>');
                $('#option'+rccnt).val($('#rc_'+r_id+'_option_'+i).val());
            });

            $("#fieldoptioncheckbox").css("display", "block");
            
        }

        $('.hidden_formtype').val('1');
        $('.hidden_formrowid').val(r_id);
        $('#myModal').modal('show');
    });


    function renumberRows() {
      $("#field_tbody td:first-child").each(function(i, v) {
        $(this).text(i + 1);
      });
    }


    //checkbox
    $('.field_ismandatory').change(function(){
        this.value = (Number(this.checked));
    });


    $('#tbody').on('click', '.alert_flag', function () {
        if($(this).prop("checked") == true){
            $(this).val('1');
            $('#option'+$(this).attr("data-row")+'_alert_notes').prop("disabled", false);
            addvalidationrules('option'+$(this).attr("data-row")+'_alert_notes','Alert Notes is required');
        }
        else if($(this).prop("checked") == false){
            $(this).val('0');
            $('#option'+$(this).attr("data-row")+'_alert_notes').prop("disabled", true);
            removevalidationrules('option'+$(this).attr("data-row")+'_alert_notes');
            $('#option'+$(this).attr("data-row")+'_alert_notes').val("");
        }
    });

    $('#tbody').on('click', '.end_flag', function () {
        if($(this).prop("checked") == true){
            $(this).val('1');
            $('#option'+$(this).attr("data-row")+'_audit_notes').prop("disabled", false);
            addvalidationrules('option'+$(this).attr("data-row")+'_audit_notes','End Audit Notes is required');
        }
        else if($(this).prop("checked") == false){
            $(this).val('0');
            $('#option'+$(this).attr("data-row")+'_audit_notes').prop("disabled", true);
            removevalidationrules('option'+$(this).attr("data-row")+'_audit_notes');
            $('#option'+$(this).attr("data-row")+'_audit_notes').val("");

        }
    });
    

    function addvalidationrules(fname,msg='This field is required')
    {
        $('#'+fname).rules("add", 
        {
            required: true,
            messages: {
                required: msg
            }
        });
    }


    function removevalidationrules(fname)
    {
        $('#'+fname).rules("remove");
    }

    $('#myModal').on('hidden.bs.modal', function (e) {
      $(this)
        .find("input,textarea,select")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

        $("#tbody,#tbody_checkbox").empty();
        $('#fieldoptioncheckbox').hide();
        $('#fieldoptionlist,#add_field_option').hide();   
    })


    function templatedelete()
    {
        var r=confirm("Do you want to delete this?")
        if (r==true)
            alert("hello");
          //window.location = url+"user/deleteuser/"+id;
        else
          return false;
        
    }
});
