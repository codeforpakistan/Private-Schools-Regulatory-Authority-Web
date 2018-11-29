
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
                <tr>
                  <th class="text-center">#</th>
                  <th>School</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Complainer</th>
                  <!-- <th>CNIC</th> -->
                  <th>Cell #</th>
                  <th>Complaint Type</th>
                  <th>Complain Detail</th>
                  <!-- <th>From</th> -->
                  <th>Date</th>
                  <th>Status</th>
                  <th>Completion Date</th>
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
                    <td><?php echo date("d-M-Y",strtotime($comp->dated));?></td>
                    <td><?php echo $comp->statusTitle; ?></td>
                    <td><?php echo $comp->endDate; ?></td>                    
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
