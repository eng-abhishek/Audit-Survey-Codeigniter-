  <?php
echo view('header');
echo view('sidebar');
?>
<style type="text/css">
#calendar{
background: white;
border: 1px solid #cbc9c9;
}
.fc-today{
    background:#f7d9d9 !important;
    border: none !important;
    border-top: 1px solid #ddd !important;
    font-weight: bold;
}
.fc-title{
    font-size: 1.1em;
    font-weight:bold;
}
.holiday:before{
    content: '';
    display: block;
    width: 90%;
    height: 80%;
    margin: 8% auto;
    border-radius: 55%;
    background: #f3991245;
}
.custom-ratio .weekoff:before{
    content: '';
    display: block;
    width: 90%;
    height: 80%;
    margin: 5% auto;
    border-radius: 55%;
    background: #ffc107;
}
.regular-radio {
    display: none;
}

.regular-radio:checked + label:before {
    background-color: #ffc107;
}
.regular-radio:focus + label:before {
    background-color: #ffc107;
}
.regular-radio + label:before{
    background-color:#f3991245;
    border-radius:10px;
    display: inline-block;
    position: relative;
    height:17px;
    width:17px;
    content: ' ';
    margin-right: 10px;
    cursor: pointer;sor:pointer;
}

label {
    display: inline;
    position: relative;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Calendar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('school-calendar'); ?>">Calendar</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
        <?php //echo form_open(base_url('school-calendar/add'), ['class' => 'validateForm']); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Calendar</h3>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php //echo form_label('Calender', 'Calender'); ?>
                                </div>
                                <div class="input-group col-sm-6">
                               
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-2">
                                    <?php //echo form_label('Calender', 'Calender'); ?>
                                </div>
                                <div class="input-group col-sm-8">
                               
                                <div id="calendar"></div>
                                </div>
                                <div class="col-sm-2"></div>
                                </div>
                                <div class="form-group row" style="padding-top:20px">
                                <div class="col-sm-3">
                               
<b>Legend</b><br>
<input id="radio-1-1" name="radio-1-set" class="regular-radio" disabled type="radio">            
<label for="radio-1-1">Holiday</label>
<br>
<input id="radio-1-2" name="radio-2-set" class="regular-radio" disabled type="radio" checked>            
<label for="radio-1-2">Weekoff</label>

                                </div>
                                <div class="input-group col-sm-6">
                                </div>
                                <div class="col-sm-2">
                                 <select name="eventType" id="eventType" class="form-control">
                                  <option value="Holiday">Holiday</option>
                                  <option value="Weekoff">WeekOff</option>  
                                </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
      
            <!-- /.row -->
            <div class="form-group">
           
            </div>
            <?php //echo form_close(); ?>
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


<?php echo view('scripts');
echo view('footer'); ?>
<script type="text/javascript">
 $(function(){ 
var calendar=$('#calendar').fullCalendar({
    editable:true,
     header:{
     left:'prev',
     center:'title',
     right:'next'
     },
    events:"<?php echo base_url('school-calendar/getSelectedDate');?>",
    eventColor: '#378006',
    selectable:true,
    selectHelper:true,
    multiple:true,
    height:650,
    select:function(start,end,allDay){
    var title=$('#eventType').val();
    if(title){
var start = $.fullCalendar.formatDate(start,"Y-MM-DD");
var end = $.fullCalendar.formatDate(end,"Y-MM-DD");
$.ajax({
url:"<?php echo base_url('school-calendar/insert'); ?>",
type:"POST",
data:{title:title,start:start,end:end},
success:function(){
calendar.fullCalendar('refetchEvents');
alert("Added Successfully");
}
})
    }
    },

    eventDrop:function(event){
    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
    //alert(start);
    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
    //alert(end);
    var title = event.title;
    var id = event.id;

    $.ajax({
    url:"<?php echo base_url('school-calendar/update');?>",
    type:"POST",
    data:{title:title, start:start, end:end, id:id},
    success:function()
    {
    calendar.fullCalendar('refetchEvents');
    alert("Event Updated");
    }
    })
    },
    eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove it?"))
     {
      var id = event.id;
      $.ajax({
       url:"<?php echo base_url('school-calendar/delete');?>",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },
    });
 })
</script>