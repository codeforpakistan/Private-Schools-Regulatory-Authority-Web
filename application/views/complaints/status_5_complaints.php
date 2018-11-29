  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo @$title; ?>
        <small><?php echo @$desc; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Complaints'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo @$title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo @$title; ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <thead>
                    <tr class="text text-center" style="background-color:#035361; color:white;">
                        <td></td>
                        <td colspan="3"><strong>School Info</strong></td>
                        <td colspan="2"><strong>Complainant Detail</strong></td>
                        <td colspan="6"><strong>Complaint Detail</strong></td>
                    </tr>
                <tr>
                  <th class="text-center">#</th>
                  <th>School</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Complainant</th>
                  <!-- <th>CNIC</th> -->
                  <th>Cell #</th>
                  <th>Complaint Type</th>
                  <th>Complaint Detail</th>
                  <!-- <th>From</th> -->
                  <th>Date</th>
                  <th>Status</th>
                  <th style="min-width:135px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($complaints)): ?>
                  <?php $i = 1; foreach ($complaints as $comp): ?>

                  <tr style="font-size:12px;">
                    <td class="text-center"><?php echo $i; ?></td>
                    <td><?php echo $comp->schoolName; ?></td>
                    <td><?php echo $comp->schoolAddress; ?></td>
                    <td><?php if(!empty($comp->telePhoneNumber)){
                          echo "Phone :".$comp->telePhoneNumber;
                    } if(!empty($comp->schoolMobileNumber)){ echo "<br /> Cell :".$comp->schoolMobileNumber; } ?></td>
                    <td><?php echo $comp->userTitle; ?></td>
                    <!-- <td><?php //echo $comp->cnic; ?></td> -->
                    <td><?php echo $comp->contactNumber; ?></td>
                    <td><?php echo $comp->complainTypeTitle; ?></td>
                    <!-- <td><?php //echo $comp->districtTitle; ?></td> -->
                    <td><?php echo $comp->complainDetail; ?></td>
                    <!-- <td><?php //echo $comp->complainFrom; ?></td> -->
                    <td><?php echo date("d-M-Y",strtotime($comp->dated));?><?php // echo $comp->status_5_date; ?></td>
                    <td><?php echo $comp->statusTitle; ?></td>
                    <td>
                        <?php if($this->session->userdata('role_id') != 300):?>
                        <button style="margin-bottom: 5px;" type="button" onclick="load_form_in_modal(<?php echo $comp->complain_id; ?>, 'Files Against ', 'Complaints/get_attachments_by_complain_id');" class="btn btn-flat btn-xs btn-info no-print">
                          View <i class="fa fa-eye"></i>
                        </button>
                        
                        <button style="margin-bottom: 5px;" type="button" onclick="load_form_in_modal(<?php echo $comp->complain_id; ?>, 'Attach the documents', 'Complaints/change_status');" class="btn btn-flat btn-xs btn-success no-print">
                          Proceed <i class="fa fa-arrow-right"></i>
                        </button>
                        <?php else: ?>
                        
                        <button style="margin-bottom: 5px;" type="button" disabled class="btn btn-flat btn-xs btn-info no-print">
                          View <i class="fa fa-eye"></i>
                        </button>
                        
                        <button style="margin-bottom: 5px;" type="button" disabled class="btn btn-flat btn-xs btn-success no-print">
                          Proceed <i class="fa fa-arrow-right"></i>
                        </button>
                        
                       <?php endif; ?> 
                    </td>                    
                  </tr>
                
                  <?php $i++; endforeach ?>
                <?php endif ?>
              </tbody>
            </table>


          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="text text-center">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>



<!-- Modal -->
<div class="modal fade" id="modal_one" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal_one_title">title will be goes dynamically</h4>
      </div>
      <div id="modal_one_content_goes_here">
        
      </div>
    </div>
    
  </div>
</div>
<script type="text/javascript">      
  function load_form_in_modal(id, title, url) {

      $.ajax({
          type: 'POST',
          url: "<?php echo base_url('')?>"+url,
          data: {"id": id, "func_name": "<?php echo $func_name; ?>", "db_column_name": "<?php echo $db_column_name; ?>"},

          success: function(data){
            // alert(data);
              $('#modal_one').modal('show');
              $("#modal_one_content_goes_here").html(data);
              $("#modal_one_title").html(title);

          },
           error:function (data) {
             // alert("getUcsByTehsilsId :s"+data);

           }

      });
    // $('#myModal').modal('show');

    
  }

</script>
