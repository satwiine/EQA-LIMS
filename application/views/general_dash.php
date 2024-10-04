<!DOCTYPE html>
<html lang="en">
<head>
  <title>UVRI EQA Tool Dashboard </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!-- <script type="text/javascript" src="<?php echo base_url('assets/fusioncharts/fusioncharts.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/fusioncharts/themes/fusioncharts.theme.fint.js');?>"></script> -->

  <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
  <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
<?php 
  
////Delimode 
//print_r($delimode);
$deli ='categories: [{ category: [{';
foreach($delimode as $d):
  $deli.='label:"'.$d['delimode'].'"},{';
endforeach;
 $deli=substr($deli,0,(strlen($deli)-2));
 $deli.=']}],"dataset": [{"seriesname": "Dispatch","data": [{';
foreach($delimode as $d):
  $deli.='value:"'.$d['dispatch'].'"},{';
endforeach;
 $deli=substr($deli,0,(strlen($deli)-2));
 $deli.=']},{"seriesname": "Response","data": [{';
foreach($delimode as $d):
  $deli.='value:"'.$d['return'].'"},{';
endforeach;
 $deli=substr($deli,0,(strlen($deli)-2));
 $deli.=']},{"seriesname": "Passed","data": [{';
foreach($delimode as $d):
  $deli.='value:"'.$d['passes'].'"},{';
endforeach;
 $deli=substr($deli,0,(strlen($deli)-2));
 $deli.=']},{"seriesname": "Failed","data": [{';
foreach($delimode as $d):
  $deli.='value:"'.$d['fail'].'"},{';
endforeach;
 $deli=substr($deli,0,(strlen($deli)-2));
 $deli.=']},{"seriesname": "Un-Graded","data": [{';
foreach($delimode as $d):
  $deli.='value:"'.$d['ungraded'].'"},{';
endforeach;
 $deli=substr($deli,0,(strlen($deli)-2));
 $deli.=']}]';

//facility level performance 
$fl='"categories": [{"category": [{';

foreach($level_perf as $lp):
  $fl.=' "label":"'.$lp['action'].'"},{';
endforeach;
 $fl=substr($fl,0,(strlen($fl)-2));
 $fl.=']}],"dataset": [{"seriesname": "HC II","data": [{';
 foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['HCII'].'"},{';
endforeach;
 $fl=substr($fl,0,(strlen($fl)-2));
 $fl.=']},{"seriesname": "HC III","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['HCIII'].'"},{';
endforeach;
  $fl=substr($fl,0,(strlen($fl)-2));
  $fl.=']},{"seriesname": "HC IV","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['HCIV'].'"},{';
endforeach;
  $fl=substr($fl,0,(strlen($fl)-2));
  $fl.=']},{"seriesname": "Private Clinic","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['Private_Clinic'].'"},{';
endforeach;
   $fl=substr($fl,0,(strlen($fl)-2));
   $fl.=']},{"seriesname": "General Hospital","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['General_Hospital'].'"},{';
endforeach;
  $fl=substr($fl,0,(strlen($fl)-2));
  $fl.=']},{"seriesname": "Laboratory","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['Laboratory'].'"},{';
endforeach;
 $fl=substr($fl,0,(strlen($fl)-2));
 $fl.=']},{"seriesname": "RRH","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['RRH'].'"},{';
endforeach;
 $fl=substr($fl,0,(strlen($fl)-2));
 $fl.=']},{"seriesname": "ART Clinic","data": [{';
foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['ARTClinic'].'"},{';
endforeach;
 $fl=substr($fl,0,(strlen($fl)-2));
 $fl.=']},{"seriesname": "National Refferal Hospital","data": [{';
 foreach($level_perf as $lp):
  $fl.=' "value":"'.$lp['NRH'].'"},{';
endforeach;
 $fl=substr($fl,0,(strlen($fl)-2));
 $fl.="]}]";



///regional performance
  $rp_lbl='"categories": [{"category": [{';
  foreach($region_perf as $rp):
    $rp_lbl.='"label":"'.$rp['region'].'"},{';
  endforeach;
  $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
  $rp_lbl.=']}],"dataset": [{"seriesname": "Response","data": [{';

  foreach($region_perf as $rp):
    $rp_lbl.='"value":"'.$rp['return'].'"},{';
  endforeach;

   $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
   $rp_lbl.=']},{"seriesname": "Passed","data": [{';

foreach($region_perf as $rp):
    $rp_lbl.='"value":"'.$rp['passes'].'"},{';
  endforeach;
  $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
  $rp_lbl.=']},{"seriesname": "Failed","data": [{';

  // foreach($region_perf as $rp):
  //   $rp_lbl.='"value":"'.$rp['return'].'"},{';
  // endforeach;
  //   $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
  //   $rp_lbl.=']},{"seriesname": "Passed","data": [{';

  

  foreach($region_perf as $rp):
    $rp_lbl.='"value":"'.$rp['fail'].'"},{';
  endforeach;
   $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
   $rp_lbl.=']},{"seriesname": "Un-Graded","data": [{';

  foreach($region_perf as $rp):
    $rp_lbl.='"value":"'.$rp['ungraded'].'"},{';
  endforeach;
    $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
    $rp_lbl.=']},{"seriesname": "Response rate %","data": [{';

  foreach($region_perf as $rp):
    $rp_lbl.='"value":"'.(($rp['return']/$rp['dispatch'])/100).'"},{';
  endforeach;
    $rp_lbl=substr($rp_lbl, 0, (strlen($rp_lbl)-2));
    $rp_lbl.=']}]';


//echo $rp_lbl;
  //exit();
  ///////////////////////
  $grd=$perform;
  if(count($grd)>0){  ///////////////////////////get the lables from data set
      $lbl='"categories":[{"category":[';
      for ($i=0; $i < count($grd); $i++) { 
        $lbl= $lbl.'{"label":"'.$grd[$i]['quarter'].'"},';
      }
      $lbl=substr($lbl, 0, (strlen($lbl)-1));
      $lbl.=']}],"dataset":[{"seriesname":"Returns","data":[';
      /////get returns
       for($j=0;$j<count($grd);$j++){
        $lbl=$lbl.'{"value":"'.$grd[$j]['return'].'"},';
       }
       $lbl=substr($lbl, 0, (strlen($lbl)-1));
       $lbl.=']},{"seriesname":"Un-Graded","data":[';
       /////get passed
       for($j=0;$j<count($grd);$j++){
        $lbl=$lbl.'{"value":"'.$grd[$j]['ungraded'].'"},';
       }
       $lbl=substr($lbl, 0, (strlen($lbl)-1));
       $lbl.=']},{"seriesname":"Passed","data":[';
       /////get failed
       for($j=0;$j<count($grd);$j++){
        $lbl=$lbl.'{"value":"'.$grd[$j]['passes'].'"},';
       }
        $lbl=substr($lbl, 0, (strlen($lbl)-1));
       $lbl.=']},{"seriesname":"Failed","data":[';
       /////get Ungraded
       for($j=0;$j<count($grd);$j++){
        $lbl=$lbl.'{"value":"'.$grd[$j]['fail'].'"},';
       }
       $lbl=substr($lbl, 0, (strlen($lbl)-1));
       $lbl.=']}]}';   
    }

    ///get regional data for stacked bar Graph
    $rgr=$region_chart;
    if(count($rgr)>0){
      $rgr_lbl ='"categories":[{"category":[';

      // iterate the array to pick regions;

      for($c=0; $c<count($rgr);$c++){
        $rgr_lbl=$rgr_lbl.'{"label":"'.$rgr[$c]['region'].'"},';
      }
      $rgr_lbl=substr($rgr_lbl,0,(strlen($rgr_lbl)-1));
      $rgr_lbl.=']}],"dataset":[{"seriesname":"Targeted","data":[';

      //get dispatched valueus
      for($k=0;$k < count($rgr);$k++){
        $rgr_lbl=$rgr_lbl.'{"value":"'.$rgr[$k]['dispatch'].'"},';
      }
      $rgr_lbl=substr($rgr_lbl,0,(strlen($rgr_lbl)-1));
      $rgr_lbl.=']},{"seriesname":"Returned","data":[';

      //get returned valueus
      for($p=0;$p < count($rgr);$p++){
        $rgr_lbl=$rgr_lbl.'{"value":"'.$rgr[$p]['return'].'"},';
      }
      $rgr_lbl=substr($rgr_lbl,0,(strlen($rgr_lbl)-1));
      $rgr_lbl.=']},{"seriesname":"Passed","data":[';
      
      //get passed valueus
      for($s=0;$s < count($rgr);$s++){
        $rgr_lbl=$rgr_lbl.'{"value":"'.$rgr[$s]['passes'].'"},';
      }
      $rgr_lbl=substr($rgr_lbl,0,(strlen($rgr_lbl)-1));
      $rgr_lbl.=']},{"seriesname":"Failed","data":[';

      //get failed valueus
      for($f=0;$f < count($rgr);$f++){
        $rgr_lbl=$rgr_lbl.'{"value":"'.$rgr[$f]['fail'].'"},';
      }
        $rgr_lbl=substr($rgr_lbl,0,(strlen($rgr_lbl)-1));
        $rgr_lbl.=']},{"seriesname":"Un-Graded","data":[';

        //get Ungraded valueus
        for($u=0;$u < count($rgr);$u++){
          $rgr_lbl=$rgr_lbl.'{"value":"'.$rgr[$u]['ungraded'].'"},';
        }
        $rgr_lbl=substr($rgr_lbl,0,(strlen($rgr_lbl)-1));
        $rgr_lbl.=']}]}';  
    }

    //echo $lbl;

?>


<div class="container-fluid">
  <div class="row content">  
    <div class="col-sm-12">
      <div class="well">
        <h4> Filtering Form</h4>
        
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well" style="background-color: #54a1c4; color: #fff;">
            <h4>Targeted Testers - Active Quarter </h4>
            <p><h3> <?php echo $targetedTesters;?></h3></p> 
            
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" style="background-color: #54a1c4; color: #fff;">
            <h4>Responsive Testers - Active Quarter </h4>
            <p><h3> <?php echo $returnedTesters;?></h3></p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" style="background-color: #54a1c4; color: #fff;">
            <h4>Passing Testers - Active Quarter </h4>
            <p><h3> <?php echo $passes;?></h3></p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" style="background-color: #54a1c4; color: #fff;">
            <h4>Failed Testers - Active Quarter </h4>
            <p><h3> <?php echo $fail;?></h3></p> 
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-9">
          <div class="well" id="pefromance_graph">
            <p>Put Graph</p> 
           
          </div>
        </div>

        <div class="col-sm-3">
          <div class="well" id="response_guage">
            <p>Put Graph</p> 
           
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="col-sm-6">
          <div class="well" id="tester_count" style="background-color: #54a1c4; color: #fff;">
            <h4>Active Testers - Active Quarter </h4>
            <p><h3> <?php echo $registeredTesters;?></h3></p> 
          </div>
        </div>

        <div class="col-sm-6">
          <div class="well" id="tester_fac" style="background-color: #54a1c4; color: #fff;">
            <h4>Active Facilities - Active Quarter </h4>
            <p><h3> <?php echo $registeredFacility;?></h3></p> 
          </div>
        </div>
        </div>
        <div class="col-sm-6">
          <div class="col-sm-4">
          <div class="well" id="ungraded" style="background-color: #54a1c4; color: #fff;">
            <h4>Un-Graded Testers - Active Quarter </h4>
            <p><h3> <?php echo $ungrade;?></h3></p> 
           
          </div>
        </div>

        <div class="col-sm-4">
          <div class="well" id="gtat" style="background-color: #54a1c4; color: #fff;">
            <p>Count Good TAT</p> 
           
          </div>
        </div>

        <div class="col-sm-4">
          <div class="well" id="btat" style="background-color: #54a1c4; color: #fff;">
            <p>Count Bad TAT</p> 
           
          </div>
        </div>
        </div>
  </div>
      
      

      <div class="row">
        <div class="col-sm-4">
          <div class="well" id="reg_chart">
            <p>Regional Performance graph</p> 
           
          </div>
        </div>
        
        <div class="col-sm-4">
          <div class="well" id="fac_chart">
            <p>Facility Level Graph</p> 
           
          </div>
        </div>

        <div class="col-sm-4">
          <div class="well" id="own_chart">
            <p>Owner Performance Graph</p> 
           
          </div>
        </div>
      </div>
    <div class="row">
        <div class="col-sm-3">
          <div class="well" id="cadre_graph">
            <p>Text</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" id="pepfar_graph">
            <p>Text</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" id="poct_graph">
            <p>Text</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well" id="delimode_graph">
            <p>Text</p> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  


</body>
</html>

<script type="text/javascript">
  var quarter="<?php echo $quarter;?>";
    //STEP 2 - Chart Data
    const dataSource = {
  chart: {
    caption: "Performance By Delivery Mode",
    subcaption: " "+ quarter+" ",
    //numberprefix: "$",
    //numbersuffix: "M",
    showvalues: "0",
    showsum: "0",
    legendbgalpha: "0",
    plottooltext:
      "Type: $label{br}<b>By : $seriesName</b>{br}Testers: $dataValue</div>",
    stack100percent: "1",
    theme: "candy"
  },
  <?php echo $deli;?>
};

FusionCharts.ready(function() {
  var myChart = new FusionCharts({
    type: "stackedcolumn3d",
    renderAt: "fac_chart",
    width: "100%",
    height: "400",
    dataFormat: "json",
    dataSource
  }).render();
});

//////////////////////////
FusionCharts.ready(function() {
  var cSatScoreChart = new FusionCharts({
    type: 'angulargauge',
    renderAt: 'response_guage',
    width: '450',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "Response Rate ",
        "subcaption": " "+ quarter+" ",
        "lowerLimit": "0",
        "upperLimit": "100",
        "theme": "fusion"
      },
      "colorRange": {
        "color": [{
          "minValue": "0",
          "maxValue": "50",
          "code": "#e44a00"
        }, {
          "minValue": "50",
          "maxValue": "75",
          "code": "#f8bd19"
        }, {
          "minValue": "75",
          "maxValue": "100",
          "code": "#6baa01"
        }]
      },
      "dials": {
        "dial": [{
          "value": "<?php echo $responseRate;?>"
        }]
      }
    }
  }).render();
});


FusionCharts.ready(function() {
  var revenueChart = new FusionCharts({
    type: 'mscolumn3d',
    renderAt: 'own_chart',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "theme": "fusion",
        "caption": "Facility Level Performance",
         "subcaption": " "+ quarter+" ",
        //"xAxisname": ""+ quarter+" ",
        //"yAxisName": "Revenues (In USD)",
        //"numberPrefix": "$",
        "plotFillAlpha": "80",
        "divLineIsDashed": "1",
        "divLineDashLen": "1",
        "divLineGapLen": "1"
      },
      <?php echo $fl;?>
    }
  });

  revenueChart.render();
});

FusionCharts.ready(function() {
  var revenueChart = new FusionCharts({
      type: 'mscolumn2d',
      renderAt: 'reg_chart',
      width: '650',
      height: '400',
      dataFormat: 'json',
      dataSource: {
        "chart": {
          "caption": "Regional Performance",
          "subCaption": ""+ quarter+" ",
          //"xAxisname": ""+ quarter+" ",
          //"pYAxisName": "Sales",
          //"sYAxisName": "Profit %",
          //"numberPrefix": "$",
          //"sNumberSuffix": "%",
          //"sYAxisMaxValue": "25",
          "divlineColor": "#999999",
          "divLineIsDashed": "1",
          "divLineDashLen": "1",
          "divLineGapLen": "1",
          "theme": "fusion"
        },

        <?php echo $rp_lbl;?>
      }
    })
    .render();
});

FusionCharts.ready(function() {
  var satisfactionChart = new FusionCharts({
    type: 'msstackedcolumn2dlinedy',
    renderAt: 'pefromance_graph',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "National Performance",
        "subcaption": ""+ quarter+" ",
        "xAxisName": "Quarter",
        "pYAxisName": "Sales",
        "sYAxisName": "Response Rate %",
        //"numberPrefix": "$",
        //"numbersuffix": "K",
        "sNumberSuffix": "%",
        "sYAxisMaxValue": "25",
        "divlineAlpha": "100",
        "divlineColor": "#999999",
        "divlineThickness": "1",
        "divLineDashed": "1",
        "divLineDashLen": "1",
        "theme": "fusion"
      },
      "categories": [{
        "category": [{
            "label": "UVRI HIV/SYP QA Y1 - Q1"
          },
          {
            "label": "UVRI HIV/SYP QA Y1 - Q2"
          },
          {
            "label": "UVRI HIV/SYP QA Y1 - Q3"
          },
          {
            "label": "UVRI HIV/SYP QA Y1 - Q4"
          }
        ]
      }],
      "dataset": [{
          "dataset": [{
              "seriesname": "Returns",
              "data": [{
                  "value": "1611"
                },
                {
                  "value": "6680"
                },
                {
                  "value": "6011"
                },
                {
                  "value": "5901"
                }
              ]
            },
            {
              "seriesname": "Un-Graded",
              "data": [{
                  "value": "3"
                },
                {
                  "value": "679"
                },
                {
                  "value": "665"
                },
                {
                  "value": "499"
                }
              ]
            }
          ]
        },
        {
          "dataset": [{
              "seriesname": "Passed",
              "data": [{
                  "value": "60"
                },
                {
                  "value": "5507"
                },
                {
                  "value": "4654"
                },
                {
                  "value": "4820"
                }
              ]
            },
            {
              "seriesname": "Failed",
              "data": [{
                  "value": "6"
                },
                {
                  "value": "460"
                },
                {
                  "value": "538"
                },
                {
                  "value": "533"
                }
              ]
            }
          ]
        }
      ],
      "lineset": [{
        "seriesname": "Response Rate %",
        "showValues": "0",
        "data": [{
            "value": "21.48"
          },
          {
            "value": "86.58"
          },
          {
            "value": "77.60"
          },
          {
            "value": "78.68"
          }
        ]
      }]
    }
  });

  satisfactionChart.render();

});

FusionCharts.ready(function() {
  var revenueChart = new FusionCharts({
    type: 'pie3d',
    renderAt: 'cadre_graph',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "Cadre Info",
        "subCaption": ""+ quarter+" ",
        //"numberPrefix": "$",
        "showPercentInTooltip": "0",
        "decimals": "1",
        //Theme
        "theme": "fusion"
      },
      "data": [{
          "label": "Food",
          "value": "285040"
        },
        {
          "label": "Apparels",
          "value": "146330"
        },
        {
          "label": "Electronics",
          "value": "105070"
        },
        {
          "label": "Household",
          "value": "49100"
        }
      ]
    }
  }).render();

});


FusionCharts.ready(function() {
  var revenueChart = new FusionCharts({
    type: 'doughnut3d',
    renderAt: 'pepfar_graph',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "pepfar",
        "subCaption": ""+ quarter+" ",
        "numberPrefix": "$",
        "startingAngle": "310",
        "defaultCenterLabel": "Total revenue: $64.08K",
        "centerLabel": "Revenue from $label: $value",
        "centerLabelBold": "1",
        "showTooltip": "0",
        "decimals": "0",
        "theme": "fusion"
      },
      "data": [{
          "label": "Food",
          "value": "28504"
        },
        {
          "label": "Apparels",
          "value": "14633"
        },
        {
          "label": "Electronics",
          "value": "10507"
        },
        {
          "label": "Household",
          "value": "4910"
        }
      ]
    }
  }).render();
});


FusionCharts.ready(function() {
  var revenueChart = new FusionCharts({
    type: 'doughnut2d',
    renderAt: 'poct_graph',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "POCT Performance",
        "subCaption": ""+ quarter+" ",
        "numberPrefix": "$",
        "startingAngle": "20",
        "showPercentValues": "1",
        "showPercentInTooltip": "0",
        "enableSmartLabels": "0",
        "enableMultiSlicing": "0",
        "decimals": "1",
        "useDataPlotColorForLabels": "1",
        //Theme
        "theme": "fusion"
      },
      "data": [{
        "label": "Food",
        "value": "285040"
      }, {
        "label": "Apparels",
        "value": "146330"
      }, {
        "label": "Electronics",
        "value": "105070"
      }, {
        "label": "Household",
        "value": "49100",
        "isSliced": "1"
      }]
    }
  }).render();
});


FusionCharts.ready(function() {
  var revenueChart = new FusionCharts({
    type: 'doughnut2d',
    renderAt: 'delimode_graph',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "Delivery Mode",
        "subCaption": ""+ quarter+" ",
        //"numberPrefix": "$",
        "bgColor": "#ffffff",
        "startingAngle": "310",
        "showLegend": "1",
        //"defaultCenterLabel": "Total revenue: 64.08K",
       // "centerLabel": "Revenue from $label: $value",
        "centerLabelBold": "1",
        "showTooltip": "0",
        "decimals": "0",
        "pieRadius": "90",
        "theme": "fusion"
      },
      "data": [{
          "label": "Food",
          "value": "28504"
        },
        {
          "label": "Apparels",
          "value": "14633"
        },
        {
          "label": "Electronics",
          "value": "10507"
        },
        {
          "label": "Household",
          "value": "4910"
        }
      ]
    }
  }).render();
});

</script>
