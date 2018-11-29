<?php $page_offset = $this->uri->segment(3); if(empty($page_offset)){ $page_offset=0; }?>
<?php if(count($complainents_list) > 0):?>
                  <?php $i = 1; foreach ($complainents_list as $comp): ?>

                  <tr style="font-size:12px;background-color:#035361; color:white;" class="bg-success">
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
<?php else: ?>
<tr class="bg-success text-center" style="font-size:12px;background-color:#035361; color:white;"><td colspan="10"><strong>No Complainant Found Againt The Creiteria.</strong></td></tr>
<?php endif; ?>