  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  
  <style>
      .span_style{
          /*border-radius:0.5px;*/
          min-width:65px;
          /*font-size:12px;*/
      }
      .block_unblock_button{
          min-width: 70px;
      }
      
  </style>
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
            <div class="row">
                <div class="col-md-12">
                      <form id="Form2" method="post" enctype="multipart/form-data" action="<?php echo base_url('school/get_single_school_from_schools_by_id');?>">
                        <div class="form-group">
                          <!--<label class="col-sm-4">-->
                          <!--<input type="text" class="form-control" name="schools_id" required="required" form="Form2" id="schools_id" placeholder="Enter School Id Examples 1,2,3 etc.">-->
                          <!--</label>-->
                          
                        <label class="col-sm-4">
                            <input type="text" class="form-control" name="like_text" onkeyup="get_user_by_like(this);" required="required" form="Form1" id="like_text" placeholder="Complainant Name">
                        </label>
                          <!--<label class="col-sm-2">-->
                          <!--  <input type="submit" id="search" class="form-control btn-xs btn-primary btn-flat" form="Form2" value="Search">-->
                          <!--</label>-->
                        </div>
                      </form>
                </div>
            </div>
          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Name</th>
                  <th>Gender</th>                  
                  <th>CNIC</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Area</th>
                  <th>Date</th>
                  <th class="text text-center">Status</th>
                  <?php if($this->session->userdata('role_id') != 300):?>
                  <th style="min-width:135px;" class="text text-center">Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody id="searched_data_div">
                  <?php $page_offset = $this->uri->segment(3); if(empty($page_offset)){ $page_offset=0; }?>
                <?php if (!empty($complainents_list)): ?>
                  <?php $i = 1; foreach ($complainents_list as $comp): ?>

                  <tr style="font-size:12px;">
                    <td class="text-center"><?php echo $i; ?></td>
                    <td><?php echo $comp->userTitle; ?></td>
                    <td>
                        <?php switch($comp->gender):
                            case 1: 
                                echo 'Male';
                            break;
                            case 2: 
                                echo 'Female';
                            break;
                            default:
                                echo "Other";
                            endswitch; 
                        ?>
                    </td>
                    <td><?php echo $comp->cnic; ?></td> 
                    <td><?php echo $comp->contactNumber; ?></td>
                    <td><?php echo $comp->userEmail; ?></td>
                    <td><?php echo $comp->districtTitle; ?></td> 
                    <td><?php echo date("d-M-Y",strtotime($comp->createdDate));?></td>
                    <td class="text text-center">
                        <?php switch($comp->userStatus):
                            case 0: 
                                echo '<span class="badge bg-aqua span_style">Pending</span>';
                            break;
                            case 1: 
                                echo '<span class="badge bg-green span_style">Active</span>';
                            break;
                            case 2: 
                                echo '<span class="badge bg-red span_style">Blocked</span>';
                            break;
                            endswitch; ?>
                    </td>
                    <td class="text text-center">
                        <?php if($this->session->userdata('role_id') != 300):?>
                            <?php switch($comp->userStatus):
                            case 0: ?>
                                <a style="margin-bottom: 5px;" class="btn btn-flat btn-xs bg-aqua block_unblock_button" href='<?php echo base_url("Complaints/change_user_status/$comp->userId/1/$page_offset"); ?>'>
                                      Pending <i class="fa fa-pause"></i>
                                </a>
                            <?php break; ?>
                            <?php case 1: ?>   
                                <a style="margin-bottom: 5px;" class="btn btn-flat btn-xs bg-yellow block_unblock_button" href='<?php echo base_url("Complaints/change_user_status/$comp->userId/2/$page_offset"); ?>'>
                                  block <i class="fa fa-ban"></i>
                                </a>
                            <?php break; ?>
                            <?php case 2: ?>   
                                <a style="margin-bottom: 5px;" class="btn btn-flat btn-xs bg-yellow block_unblock_button" href='<?php echo base_url("Complaints/change_user_status/$comp->userId/1/$page_offset"); ?>'>
                                  Unblock <i class="fa fa-ban"></i>
                                </a>
                            <?php break; ?>
                            <?php endswitch; ?>
                                &nbsp;
                                <a style="margin-bottom: 5px;" class="btn btn-flat btn-xs bg-red block_unblock_button" href='<?php echo base_url("Complaints/delete_complainent/$comp->userId/$page_offset"); ?>' onclick="return confirm('Are you sure you want to delete the Complainent ?')">
                                  delete <i class="fa fa-trash"></i>
                                </a>
                       <?php endif; ?>
                    </td>                    
                  </tr>
                
                  <?php $i++; endforeach;?>
                <?php endif; ?>
              </tbody>
            </table>


          </div>
        </div>
        <!-- /.box-body -->
        <!--<div class="box-footer">-->
            <div class="text text-center">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        <!--</div>-->
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
      
        function get_user_by_like(likeObj) {
          var likObjValue = '';
          likObjValue = likeObj.value;
          // console.log();
          if(likObjValue.length > 0 ){
              $.ajax({
                   type: 'POST',
                   url: "<?php echo base_url('Complaints/search_complainant_by_like');?>",
                   data: {"matchString": likObjValue},
                   success: function(data){
                       console.log(data);
                      $('tr.bg-success').remove();
                      $('#searched_data_div').prepend(data);                 
                   },
                    error:function (err) {
                      alert("There is error in searching process :"+err);

                    }
              });
          }else{
              $('tr.bg-success').remove();
          }
      }
</script>
