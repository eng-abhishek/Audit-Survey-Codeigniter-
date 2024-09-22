<?php
echo view('header');
echo view('sidebar');
?>
<style type="text/css">
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #2bad49;
    background-color: #28a745;
    box-shadow: none; }    
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>New District</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('districts'); ?>">Dstricts</a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <?php echo form_open(base_url('districts/add'), ['class' => 'destrictForm']); ?>
        <div class="row">
              <div class="col-sm-3"></div>  
                <div class="col-sm-3"></div>  
                         <div class="col-sm-3"></div>  
              <div class="col-sm-3">
                     
 <div class="custom-control custom-switch" style="float:right;margin-right:30px">
<input type="checkbox" class="custom-control-input listaction" value="1" checked="checked" name="district_status" id="district_status" onChange="checkStatus()">
 <label class="custom-control-label" for="district_status"></label>
 <font id="textStatus">Active</font>
 </div>
          </div>
          </div><br>
            <div class="row">
              
                <div class="col-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Districts</h3>
                        </div>
                        <div class="card-body">
                         
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.district_name'), 'name'); ?>
                                      <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'name',
                                        'id'    => 'name',
                                        'class'  => 'form-control',
                                        'value' => set_value('name'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.district_code'), 'district_code'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $district_code = [
                                        'name'  => 'district_code',
                                        'id'    => 'district_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('district_code'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($district_code);
                                    ?>
                                </div>
                             </div>

                           <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.web_url'), 'district_web_url'); ?>
                                            <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $district_web_url = [
                                        'name'  => 'district_web_url',
                                        'type'=>'url',
                                        'id'    => 'district_web_url',
                                        'class'  => 'form-control',
                                        'value' => set_value('district_web_url'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($district_web_url);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.billing_address1'), 'billing_address'); ?>
                                        <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $billing_address1 = [
                                        'name'  => 'billing_address_1',
                                        'id'    => 'billing_address_1',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('billing_address_1'),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($billing_address1);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.billing_address2'), 'billing_address_2'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $billing_address2 = [
                                        'name'  => 'billing_address_2',
                                        'id'    => 'billing_address_2',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('billing_address_2'),
                                      
                                    ];
                                    echo form_textarea($billing_address2);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.state'), 'state'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                <select name="state" style="color:black;" id="state" class="form-control" onchange="getCityData(this.value)" required="">
                                <option value="">select state</option>
                                <?php if($getState){ foreach($getState as $getStateData){ ?>
                                <option value="<?php echo $getStateData->id;?>"><?php echo $getStateData->state_name;?></option>
                                <?php } }?>
                                </select>
                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.city'), 'city'); ?>
                                        <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                <select name="city" style="color:black;" class="form-control" required="" id="getCity"><option value=""> select city </option></select>
                                </div>
                            </div>

                              <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.zip_code'), 'zip_code'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $zip_code = [
                                        'name'  => 'zip_code',
                                        'id'    => 'zip_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('zip_code'),
                                       
                                    ];
                                    echo form_input($zip_code);
                                    ?>
                                </div>
                            </div>

                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="form-group">
                <?php echo form_submit('submit', 'Create', ['class' => 'btn btn-info ']); ?>
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<?php echo view('scripts'); ?>
<script type="text/javascript">

function checkStatus(){
if($('#district_status').is(':checked')){
$('#district_status').attr('value','1');
$('#textStatus').html('Active');
}else{
$('#district_status').attr('value','0');      
$('#textStatus').html('Inactive');
}
}

function getCityData(id){
      $.ajax({
      url: "<?php echo base_url('districts/getCityData')?>",
      method:'POST',
      data:{id:id},
      success:function(data){
      $('#getCity').html(data);
      }
      }) }

$(function(){
$('.destrictForm').validate({
    rules:{
    name:{
    required:true,
    maxlength:80,
    minlength:2,
    },
    district_code:{
    required:true,
    maxlength:50,
    minlength:2,
    number:true,
    remote:{
    url:"<?php echo base_url('/districts/check_destrict_code_exist');?>",
    type: "post",
    }
    },
    district_web_url:{
    required:true,
    url:true,
    maxlength:500,
    },
    billing_address_1:{
    required:true,
    maxlength:500,
    minlength:20,
    },
    billing_address_2:{
    required:true,
    maxlength:500,
    minlength:20,
    },
    state:{
    required:true,
    },
    city:{
    required:true,
    },
    zip_code:{
    maxlength:60,
    minlength:2,
    number:true,
    },
    },
    messages:{
    name:{
    required:"Please enter district name",
    },
    district_code:{
    required:"Please enter district code",
    remote:"This code is already exist try other",
    },
    district_web_url:{
    required:"Please enter district website url",
    },
    billing_address_1:{
    required:"Please enter billing address 1",
    },
    billing_address_2:{
    required:"Please enter billing address 2",
    },
    state:{
    required:"Please select state",
    },
    city:{
    required:"Please select city",
    },
    }
     
});
})
</script>
<?php echo view('footer'); ?>
