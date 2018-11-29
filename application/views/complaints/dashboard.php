<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>






  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <small><?php echo @$desc; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('Complaints'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Complaints</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $title; ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
        <div id="status_wise_report_in_pie" style="min-width: 310px; min-height: 400px; margin: 0 auto"></div>
        <div id="status_wise_report_in_bar" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

            
<div id="container" style="min-width: 310px; min-height: 400px; margin: 0 auto"></div>

<table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th style="width:50%;">Complaint Types</th>
        <th>Number of Complaints</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($total_complaints_by_type as $t_c_b_type): ?>
            <tr>
                <td><?php echo $t_c_b_type->complainTypeTitle; ?></td>
                <td><?php echo $t_c_b_type->complain_type_count;?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="text text-info">
            <td>Total Complaints</td>
            <td><?php echo $total_complaints; ?></td>
        </tr>
    </tbody>
  </table>

<div id="five_year_complaints" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th style="width:50%;">Complaint Year</th>
        <th>Number of Complaints</th>
      </tr>
    </thead>
    <tbody> <?php $reversed = array_reverse($last_five_year); ?>
        <?php foreach($reversed as $last_five_y): ?>
            <tr>
                <td><?php echo $last_five_y->year_of; ?></td>
                <td><?php echo $last_five_y->total_complaints;?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
  
  

<div id="district_wise" style="min-width: 300px; height: 400px; margin: 0 auto"></div>

<!--<table class="table table-bordered table-responsive">-->
<!--    <thead>-->
<!--      <tr>-->
<!--        <th style="width:50%;">District Name</th>-->
<!--        <th>Number of Complaints</th>-->
<!--      </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
        
<!--        <?php foreach($total_complaints_by_district as $district_info): ?>-->
<!--            <tr>-->
<!--                <td><?php echo $district_info->districtTitle; ?></td>-->
<!--                <td><?php echo $district_info->district_count;?></td>-->
<!--            </tr>-->
<!--        <?php endforeach; ?>-->
<!--        <tr class="text text-info">-->
<!--            <td>Total Complaints</td>-->
<!--            <td><?php echo $total_complaints; ?></td>-->
<!--        </tr>-->
<!--    </tbody>-->
<!--  </table>-->
  
  
<!--<div id="seven_days" style="min-width: 300px; height: 400px; margin: 0 auto"></div>-->

<!--<table class="table table-bordered table-responsive">-->
<!--    <thead>-->
<!--      <tr>-->
<!--        <th style="width:33.3%;">Day</th>-->
<!--        <th style="width:33.3%;">Date</th>-->
<!--        <th>Number of Complaints</th>-->
<!--      </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
        
<!--        <?php foreach($last_seven_days as $seven_day): ?>-->
<!--            <tr>-->
                <?php //$date = strtotime($seven_day->date_figure); ?>
<!--                <td><?php echo $seven_day->day_name_here; ?></td>-->
<!--                <td><?php echo date("d-M-Y", strtotime($seven_day->date_figure));?></td>-->
<!--                <td><?php echo $seven_day->total_complaints;?></td>-->
<!--            </tr>-->
<!--            <?php endforeach; ?>-->
<!--    </tbody>-->
<!--  </table>-->

<!--<div id="monthly_report" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->

<div id="current_year_report" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!--<div id="daily_report_of_one_month" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="text text-center">
                
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



<script>
    
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Total Complaints Type Wise'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
            <?php foreach($total_complaints_by_type as $t_c_b_type): ?>
                {

            name: '<?php echo $t_c_b_type->complainTypeTitle; ?>',
            y: <?php echo $t_c_b_type->complain_type_count;?>
            },
        <?php endforeach; ?>
            ]
    }]
});
</script>

<?php $data_for_five_years = ''; ?>

<?php foreach($last_five_year as $five_year): ?>
    <?php $data_for_five_years .= $five_year->total_complaints.",";

    ?>
<?php endforeach; ?>

<?php $year_of = $last_five_year[0]->year_of; ?>
<script>

Highcharts.chart('five_year_complaints', {

    title: {
        text: 'Five Year Complaints'
    },

    xAxis: {
        tickInterval: 1
    },

    yAxis: {
        type: 'logarithmic',
        minorTickInterval: 1
    },
    tooltip: {
        headerFormat: '<b>Complaints per year</b><br />',
        pointFormat: 'Year = {point.x}, Complaints = {point.y}'
    },

    series: [{
        name: 'Complaints',
        data: [<?php echo $data_for_five_years; ?>],
        pointStart: <?php echo $year_of; ?>
    }]
});
</script>



<script>
    
// Create the chart

Highcharts.chart('district_wise', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'All Complaints From Cities'
    },
    // subtitle: {
    //     text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
    // },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Complaints'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Total Complaints: <b>{point.y}</b>'
    },
    series: [{
        name: 'Population',
        data: [
            <?php foreach($total_complaints_by_district as $district_info): ?>
            
            ['<?php echo $district_info->districtTitle; ?>', <?php echo $district_info->district_count;?>],
            <?php endforeach; ?>
            // ['Beijing', 20.8],
            // ['Karachi', 14.9],
            // ['Shenzhen', 13.7],
            // ['Guangzhou', 13.1],
            // ['Istanbul', 12.7],
            // ['Mumbai', 12.4],
            // ['Moscow', 12.2],
            // ['São Paulo', 12.0],
            // ['Delhi', 11.7],
            // ['Kinshasa', 11.5],
            // ['Tianjin', 11.2],
            // ['Lahore', 11.1],
            // ['Jakarta', 10.6],
            // ['Dongguan', 10.6],
            // ['Lagos', 10.6],
            // ['Bengaluru', 10.3],
            // ['Seoul', 9.8],
            // ['Foshan', 9.3],
            // ['Tokyo', 9.3]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>



<script>
    
// Create the chart

Highcharts.chart('seven_days', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'All Complaints In Week'
    },
    // subtitle: {
    //     text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
    // },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Complaints'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Last Seven Days Complaints: <b>{point.y}</b>'
    },
    series: [{
        name: 'Population',
        data: [
            <?php foreach($last_seven_days as $seven_day): ?>
            
            ['<?php echo $seven_day->day_name_here; ?>', <?php echo $seven_day->total_complaints;?>],
            <?php endforeach; ?>
            // ['Beijing', 20.8],
            // ['Karachi', 14.9],
            // ['Shenzhen', 13.7],
            // ['Guangzhou', 13.1],
            // ['Istanbul', 12.7],
            // ['Mumbai', 12.4],
            // ['Moscow', 12.2],
            // ['São Paulo', 12.0],
            // ['Delhi', 11.7],
            // ['Kinshasa', 11.5],
            // ['Tianjin', 11.2],
            // ['Lahore', 11.1],
            // ['Jakarta', 10.6],
            // ['Dongguan', 10.6],
            // ['Lagos', 10.6],
            // ['Bengaluru', 10.3],
            // ['Seoul', 9.8],
            // ['Foshan', 9.3],
            // ['Tokyo', 9.3]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>

<script>


// Create the chart
Highcharts.chart('monthly_report', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Report'
    },
    // subtitle: {
    //     text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    // },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Complaints'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },

    "series": [
        {
            "name": "Complaints",
            "colorByPoint": true,
            "data": [
                <?php foreach($monthly_report as $monthly_re): ?>
                    {
                        "name":'<?php echo $monthly_re->complainTypeTitle; ?>', 
                        "y":<?php echo $monthly_re->total_complaints;?>
                    },
            <?php endforeach; ?>
    
            ]
        }
    ]
});

</script>


<script>
    
Highcharts.chart('current_year_report', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Current Year Monthly Report'
    },
    // subtitle: {
    //     text: 'Source: WorldClimate.com'
    // },
    xAxis: {
        categories: [
            <?php $month_name_old = "bla bla"; ?>
            <?php $type_1 = "";$values_type_1 = "";$type_2 = "";$values_type_2 = "";$type_3 = "";$values_type_3 = "";$type_4 = "";$values_type_4 = "";
$type_5 = "";$values_type_5 = "";$type_6 = "";$values_type_6 = "";
?>

            <?php foreach($current_year_report as $curr_y_r): ?>
            <?php if($curr_y_r->month_name != $month_name_old){
                echo "'".$curr_y_r->month_name."',";
                $month_name_old = $curr_y_r->month_name;
            } ?>
            
            // prapring data for chart...
            <?php
                   switch ($curr_y_r->complain_type_id) {
                        case "1":
                            $type_1 = $curr_y_r->complainTypeTitle;
                            $values_type_1 .= $curr_y_r->total_complaints.",";
                            break;
                        case "2":
                            $type_2 = $curr_y_r->complainTypeTitle;
                            $values_type_2 .= $curr_y_r->total_complaints.",";
                            break;
                        case "3":
                            $type_3 = $curr_y_r->complainTypeTitle;
                            $values_type_3 .= $curr_y_r->total_complaints.",";
                            break;
                        case "4":
                            $type_4 = $curr_y_r->complainTypeTitle;
                            $values_type_4 .= $curr_y_r->total_complaints.",";
                            break;
                        case "5":
                            $type_5 = $curr_y_r->complainTypeTitle;
                            $values_type_5 .= $curr_y_r->total_complaints.",";
                            break;
                        case "5":
                            $type_5 = $curr_y_r->complainTypeTitle;
                            $values_type_5 .= $curr_y_r->total_complaints.",";
                            break;
                        case "6":
                            $type_6 = $curr_y_r->complainTypeTitle;
                            $values_type_6 .= $curr_y_r->total_complaints.",";
                            break;
                    }
                
                ?>
            
            <?php endforeach; ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Complaints'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
    {
        name: '<?php echo $type_1; ?>',
        data: [<?php echo rtrim($values_type_1);?>]

    },
    {
        name: '<?php echo $type_2; ?>',
        data: [<?php echo rtrim($values_type_2);?>]

    },
    {
        name: '<?php echo $type_3; ?>',
        data: [<?php echo rtrim($values_type_3);?>]

    },
    {
        name: '<?php echo $type_4; ?>',
        data: [<?php echo rtrim($values_type_4);?>]

    },
    {
        name: '<?php echo $type_5; ?>',
        data: [<?php echo rtrim($values_type_5);?>]

    },
    {
        name: '<?php echo $type_6; ?>',
        data: [<?php echo rtrim($values_type_6);?>]

    }
    ]
});
</script>


<script>
    
    
Highcharts.chart('daily_report_of_one_month', {

    chart: {
        type: 'column'
    },
    title: {
        text: 'Current Month'
    },
    // subtitle: {
    //     text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
    // },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Complaints'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: ' <b>{point.y} Complaints</b>'
    },
    series: [{
        name: 'Population',
        data: [
                <?php foreach($daily_report_of_one_month as $daily_report_of_curr): ?>
                    ['<?php echo $daily_report_of_curr->date_figure; ?>', <?php echo $daily_report_of_curr->total_complaints;?> ],
                <?php endforeach; ?>
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
    
</script>

<!--status_wise_report starts-->
<script>
// Create the chart
Highcharts.chart('status_wise_report_in_bar', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Over-all Complaints Status Wise'
    },
    // subtitle: {
    //     text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    // },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Complaints'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },

    "series": [
        {
            "name": "Complaints",
            "colorByPoint": true,
            "data": [
                <?php foreach($status_wise as $s_w): ?>
                {
                    "name": "<?php echo $s_w->statusTitle; ?>",
                    "y": <?php echo $s_w->total_complaint; ?>,
                    "drilldown": null
                },
                <?php endforeach;?>
            ]
        }
    ]
});
</script>
<!--end here-->

<!-- starts status_wise_in_pie-->
<script>
    
Highcharts.chart('status_wise_report_in_pie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Over-all Complaints Status Wise'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
                <?php foreach($status_wise as $s_w): ?>
                {
                    "name": "<?php echo $s_w->statusTitle; ?>",
                    "y": <?php echo $s_w->total_complaint; ?>,
                    "drilldown": null
                },
                <?php endforeach;?>
            ]
    }]
});
</script>
<!--end-->