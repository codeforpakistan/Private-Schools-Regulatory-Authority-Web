<form class="form-horizontal" method="post" enctype="multipart/form-data" id="Form1" action="<?php echo base_url('Complaints/change_status_process'); ?>/<?php echo $comp->complain_id; ?>"  >
        <div class="container">
        <div class="row">
        <div class="col-xs-offset-1 col-xs-8">
            <strong class="text-center"><span class="text-success"> <h4>** Complaints Details. **</h4></span></strong>
            <br>
          <table class="table table-bordered table-responsive table-condensed">
            <thead>
              <tr>
                <th class="text-center" colspan="2">Complaints Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width: 50%"><b>Complaint Id</b></td>
                <td class="text-center"><?php echo $comp->complain_id; ?></td>
              </tr>

              <tr>
                <td><b>School Name</b></td>
                <td class="text-center"><?php echo $comp->schoolName; ?></td>
              </tr>

              <tr>
                <td><b>Address</b></td>
                <td class="text-center"><?php echo $comp->schoolAddress; ?></td>
              </tr>

              <tr>
                <td><b>Complainent Name</b></td>
                <td class="text-center"><?php echo $comp->userTitle; ?></td>
              </tr>

              <tr>
                <td><b>Cell #</b></td>
                <td class="text-center"><?php echo $comp->contactNumber; ?></td>
              </tr>

              <tr>
                <td><b>Complaint Type</b></td>
                <td class="text-center"><?php echo $comp->complainTypeTitle; ?></td>
              </tr>

              <tr>
                <td><b>Complain Detail</b></td>
                <td class="text-center"><?php echo $comp->complainDetail; ?></td>
              </tr>

              <tr>
                <td><b>Date</b></td>
                <td class="text-center"><?php echo date("d-M-Y",strtotime($comp->dated));?></td>
              </tr>

              <tr>
                <td><b>Status</b></td>
                <td class="text-center"><?php echo $comp->statusTitle; ?></td>
              </tr>
            </tbody>
          </table>
          <?php $feedback = $comp->feedback; ?>
          <?php if(count($feedback) > 0 ): ?>
            <strong class="text-center"><span class="text-success"> <h4>** Complainent Feedback. **</h4></span></strong>
          <table class="table table-bordered table-responsive table-condensed">
                <thead>
                  <tr>
                    <th style="width:20%;">Complaint Resolved</th>
                    <th>Details</th>
                    <th style="width:20%;">Date</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($feedback as $fb): ?>
                  <tr>
                    <td><?php echo $fb->agree_or_not_agree; ?></td>
                    <td><?php echo $fb->details; ?></td>
                    <td><?php echo date("d-M-Y", strtotime($fb->date));?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          
          
          
          
           <strong class="text-center"><span class="text-success"> <h4>** You Must Provide Attachments. **</h4></span></strong>
            <br>
          <table class="table table-bordered table-responsive table-condensed">
            <thead>
              <tr>
                <th class="text-center" colspan="2">Complaints Forword To</th>
              </tr>
            </thead>
            <tbody>
        <?php foreach($statuses as $process_status): ?>
         <tr>
             <td>
             <div class="radiotext">
                 <label for='<?php echo "status_id_".$process_status->statusId; ?>'><?php echo $process_status->statusTitle; ?></label>
             </div>
             </td>
             
             <td>
                 <div class="radio">
                     <label><input type="radio" id='<?php echo "status_id_".$process_status->statusId; ?>' name="status_id" required value="<?php echo $process_status->statusId; ?>"><?php echo $process_status->statusTitle; ?></label>
                 </div>
             </td>
         </tr>
        <?php endforeach; ?>
        
        <tr>
            <td>
                Complainent Can Feed-back After
            </td>
            <td>
                <input type="number" class="form form-control" name="complainent_feedback_day" min="1" max="10" value="10">
            </td>
        </tr>
        <tr>
                <td class="text-center" style="width:50%;">
                    <label for="files_array">Attach Files</label>
                </td>
                <td>
                    <div class="form-group">
                    <input type="file" multiple="multiple" class="form-control-file" required="required" id="files_array" name="files[]" form="Form1" style="padding-left:15px;">
                    <span class="text text-center text-danger" id="invalid_file_span" style="display:none;">Please Upload only Image files.</span>
                    <input type="hidden" id="status_id" name="current_status_id" value="<?php echo $comp->status_id; ?>">
                    <input type="hidden" id="complain_id" name="complain_id" value="<?php echo $comp->complain_id;?>">
                    <input type="hidden" name="function_redirection" value="<?php echo $func_name;?>">
                    <input type="hidden" name="db_column_name" value="<?php echo $db_column_name; ?>">
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text text-center">
                  <button type="submit" name="file_upload" class="btn btn-success btn-flat btn-sm" style="min-width:250px;" id="update" form="Form1" onclick="change_text(this);">Proceed</button>
                </td>
              </tr>
</table>
        </div>
        </div>
        </div>
      </form>



        // <script type="text/javascript">
        //   $('form[id="Form1"] input:submit').on('click', function(e) {
        //       $("#update").prop('disabled', true);
        //       $("#update").val("Please Wait...");

        //       // return false;
        //   });
        // </script>
        
        <script>
            function change_text(this1)
            {
                    var at_least_one_radio_button_is_checked = $('input[name="status_id"]:checked').length;
                    

                   if($("#files_array").val() != '' && at_least_one_radio_button_is_checked != 0){
                        this1.innerHTML='<i class="fa fa-spinner fa-spin"></i> Sending data…';
                        //   this1.disabled=true;
                        setTimeout(function(){ $("#update").prop('disabled', true); }, 0500);
                        }
                        

                
            }
            
            $('#files_array').change(
                function () {
                    var fileExtension = ['jpeg', 'jpg', 'png'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        
                        var $el = $('#files_array').val(null);
                         $("#invalid_file_span").show(); 
                        return false; 
                    }
});
        </script>