<!DOCTYPE html>
<html>
<head>
<style>
div.gallery {
    border: 1px solid #ccc;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    min-height: 150px;
}

div.desc {
    padding: 15px;
    text-align: center;
}

* {
    box-sizing: border-box;
}

.responsive {
    padding: 0 6px;
    float: left;
    width: 24.99999%;
}

@media only screen and (max-width: 700px) {
    .responsive {
        width: 49.99999%;
        margin: 6px 0;
    }
}

@media only screen and (max-width: 500px) {
    .responsive {
        width: 100%;
    }
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}
</style>
</head>
<body>



<?php if(count($complainent_files_list) > 0):?>
<h3 style="margin:25px;">Complainent Files</h3>
<?php foreach($complainent_files_list as $c_f_l): ?>
<!--`complainUploadId`,-->
<!--`complainUploadName`,-->
<!--`complain_id`-->
<div class="responsive" id="complainent_<?php echo $c_f_l->complainUploadId; ?>">
  <div class="gallery" style="height:284px;">
    <div style="height:223px;">
    <a target="_blank" href="<?php echo base_url('uploads/images_uploaded_by_complainer/');?><?php echo $c_f_l->complainUploadName; ?>">
      <img src="<?php echo base_url('uploads/images_uploaded_by_complainer/');?><?php echo $c_f_l->complainUploadName; ?>" class="img img-responsive" alt="Complainent Image" height="210">
    </a>
    </div>
    <!--<div class="desc">Add a description of the image here</div>-->
    <div class="desc">
        <a href="javascript:void(0);" onclick="delete_the_record(<?php echo $c_f_l->complainUploadId; ?>, 'complainUploadId', 'complain_uploads', 'complainUploadName', 'complainent_');" class="btn btn-flat btn-xs btn-danger no-print" >Delete &nbsp;<i class="fa fa-trash-o"></i></a>
    </div>
  </div>
</div>
<?php endforeach; ?>
<?php else: ?>
<h3 class="text text-danger text-center">No Attachments Found Against Complaint Uploaded By Complainent<strong>!</strong></h3>
<?php endif; ?>

<br />
<div class="clearfix"></div>




<?php $counter = 1; ?>
<?php if(count($attachments) > 0):?>
<h3 style="margin:25px;">Complaint Progress Files</h3>
<?php foreach($attachments as $att): ?>
<!--process_file_name-->
<!--complain_status_wise_attachment_id-->
<!--status_id-->
<!--complain_id-->

<div class="responsive" id="progress_<?php echo $att->complain_status_wise_attachment_id; ?>">
  <div class="gallery" STYLE="HEIGHT:284PX;"style="height:284px;"
    <a target="_blank" href="<?php echo base_url('uploads/images_uploaded_by_complainer/');?><?php echo $att->process_file_name; ?>">
      <img src="<?php echo base_url('uploads/images_uploaded_by_complainer/');?><?php echo $att->process_file_name; ?>" alt="Image" class="img img-responsive" height="210">
    </a>
    <div class="desc"><?php echo $att->statusTitle; ?></div>
    <div class="desc">
        <a href="javascript:void(0);" onclick="delete_the_record(<?php echo $att->complain_status_wise_attachment_id; ?>, 'complain_status_wise_attachment_id', 'complain_status_wise_attachment', 'process_file_name', 'progress_');" class="btn btn-flat btn-xs btn-danger no-print" >Delete &nbsp;<i class="fa fa-trash-o"></i></a>
    </div>
  </div>
</div>
<?php // if($counter == 3): ?>
<!--<div class="clearfix"></div>-->
<?php //$counter = 1; ?>
<?php //endif; ?>
<?php endforeach; ?>
<?php else: ?>
<h3 class="text text-center text-danger">No Attachments Found Against Complaint Processed<strong>!</strong></h3>
<?php endif; ?>



<div style="padding:6px;">
  <p>&nbsp;</p>
</div>

</body>
</html>


<script>
    function delete_the_record(id, column_id_name, table, file_column_name, prefix_id_text ){
        var div_id_that_may_delete = prefix_id_text+id;
            var deletion = confirm('Are you sure you wnat to perform deletion.');
            if(!deletion){
              return deletion;
            }
            // alert("<?php //echo base_url('School/delete_record_by_id')?>");
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('Complaints/delete_record_by_id/')?>",
                data: {"id": id, "column_id_name":column_id_name, "table":table, "file_column_name":file_column_name },

                success: function(data){
                    obj = $.parseJSON(data);                   
                    if(obj.status == false){
                    alert("Deletion failed, Please try again.");
                    }
                    // pass
                    if(obj.status == true){
                      $("#"+div_id_that_may_delete).fadeOut(0500);
                    }

                },
                 error:function (error) {
                   alert("deletion error in ajax process :"+error);

                 }

            });
    }
</script>
