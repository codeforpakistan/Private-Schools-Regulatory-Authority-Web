<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row"> 
        <div class="col-md-12" style="margin-top:5%;">
	            <div id="div_ajax_response" class="text-center" style="display: none;"></div>
            <form id="Form2" method="post" onsubmit="" enctype="multipart/form-data" action="<?php echo base_url('mobile_apis/add_feed_back_by_complaint_id_process');?>" style="width:80%; padding-left:10%">
                <input type="hidden" name="complaint_id" value="<?php echo $complaint_id;  ?>" id="complaint_id_in_feedback">
                
                <div class="form-group ">
                    <label class="col-sm-12">
                        <strong>Is your complaint is resolved ?</strong>
                        <select name="resolve_or_not" required="required" form="Form2" id="resolve_or_not" style="width:100%;">
                            <option>Select </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </label>
                </div>
                <br />
                
                <div class="form-group ">
                    <label class="col-sm-12">
                        <input type="text" name="feedback" class="form-control" required="required" form="Form2" id="feedback" placeholder="Enter Your Feed Back On Complaint">
                    </label>
                </div>
                <br />
                <span>&nbsp;</span>
                
                <div class="form-group" align="center">
                    <input type="submit" value="Add Feed Back" id="submit_feedback" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
