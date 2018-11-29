<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php if(!empty($complaint_list)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
          <th>#</th>
          <th>School Name</th>
          <th>Complaint Type</th>
          <th>Complaint Details</th>
          <th>Status</th>
          <!-- <th class="no-print" style="width: 250px;">&nbsp;</th> -->
          <th>Complaint Date</th>
          <th>Feedback</th>
        </tr>
    </thead>
    <tbody>

            <?php $counter = 1; ?>
            <?php foreach($complaint_list as $complaint): ?>
            <tr id="complaint_id_<?php echo $complaint->complain_id; ?>">
            	<td><?php echo $counter; ?></td>
            	<td><?php echo $complaint->schoolName; ?></td>
            	<td><?php echo $complaint->complainTypeTitle; ?></td>
            	<td><?php echo $complaint->complainDetail; ?></td>
            	<td><?php echo $complaint->statusTitle; ?></td>
            	<?php $date = new DateTime($complaint->dated); ?>
            	<td><?php echo $date->format('d-M-Y'); ?></td>
            	<td>
                    <a href="javascript:void(0);" title="View Complaint Details" onclick="add_feed_back_by_complaint_id(<?php echo $complaint->complain_id; ?>);" ><i class="fa fa-reply" style="font-size:14px;"></i> Feedback
    </a> 
                     &nbsp; 
            	   <!--<a href="javascript:void(0);" title="View Complaint Details" onclick="view_full_details_by_complaint_id(<?php //echo $complaint->complain_id; ?>);" ><i class="fa fa-eye" style="font-size:17px;"></i>-->
                <!--    </a>-->

                    
                    
            	    
            	</td>
            </tr>
            <?php endforeach; ?>
    <?php else: ?>
            <h3 class="text text-center">No Complaints Found Against <strong>"</strong><?php echo $cnic; ?><strong>"</strong>.</h3>
<?php endif; ?>


    </tbody>
</table>