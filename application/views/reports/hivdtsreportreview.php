<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	 function cleanDate($t){
			if($t=='0000-00-00 00:00:00' || $t=='0000-00-00' || $t==''){
				$d="";
			}

			else{
				$d=date('d-M-Y',strtotime($t));
			}
			return $d;
		}


	$rp=$sampledetail;
	
	$cycle=$rp['cycleid'];
	$td=$teskitinfo;

$hp1exp_scres='';$hp1exp_conres=''; $hp1exp_tbres='';$hp1exp_fres='';
$hp2exp_scres='';$hp2exp_conres=''; $hp2exp_tbres='';$hp2exp_fres='';
$hp3exp_scres='';$hp3exp_conres=''; $hp3exp_tbres='';$hp3exp_fres='';
$hp4exp_scres='';$hp4exp_conres=''; $hp4exp_tbres='';$hp4exp_fres='';

$hp1yr_scres='';$hp1yr_conres=''; $hp1yr_tbres='';$hp1yr_fres=''; 	$p1mark=0;
$hp2yr_scres='';$hp2yr_conres=''; $hp2yr_tbres='';$hpy2rp_fres=''; 	$p2mark=0;
$hp3yr_scres='';$hp3yr_conres=''; $hp3yr_tbres='';$hp3yr_fres='';		$p3mark=0;
$hp4yr_scres='';$hp4yr_conres=''; $hp4yr_tbres='';$hp4yr_fres='';		$p4mark=0;

$syp1_fr 	= $syp2_fr 	= $syp3_fr 	= $syp4_fr 	='';
$syp1_efr = $syp2_efr = $syp3_efr = $syp4_efr 	='';
$sp1mark 	= $sp2mark 	= $sp3mark = $sp4mark =0;

//to determine if we have blank results default is false
	$p1blank = $p2blank  = $p3blank  = $p4blank =false;


$hhdr = $hsdr=0; // hide_hiv_expected_result(hhdr), hide_syph_expected_results(hsdr)
$sfr=1; //use it to show final result regardless of expired dates
//$hide_expected_results=array_column($hivothercomments, 'commentid');
if(count($syphcomments)>0){
	foreach($syphcomments as $c):
		if($c['schemeid']==1){
			if($c['commentid']==2 || $c['commentid']==3){
				$hhdr=1;
				$sfr=0; 
			}
		}
		else {
			if($c['schemeid']==2){
			if($c['commentid']==2 || $c['commentid']==3){
				$hsdr=1;
				$sfr=0; 
			}
		}
		}
	endforeach;
}
if(isset($syphresult)){
	foreach($syphresult as $sr):
		if($sr['rpanel']==1){
			$syp1_fr = $sr['resdesc'];
			if($sr['finalResult']==$sr['panfr']){
				$sp1mark =1;
			}
		}
		elseif($sr['rpanel']==2){
			$syp2_fr = $sr['resdesc'];
			if($sr['finalResult']==$sr['panfr']){
				$sp2mark =1;
			}
		}
		elseif($sr['rpanel']==3){
			$syp3_fr = $sr['resdesc'];
			if($sr['finalResult']==$sr['panfr']){
				$sp3mark =1;
			}
		}
		elseif($sr['rpanel']==4){
			$syp4_fr = $sr['resdesc'];
			if($sr['finalResult']==$sr['panfr']){
				$sp4mark =1;
			}
		}
	endforeach;
}
$sgrade = $sperf='';
if((($sp4mark+$sp3mark+$sp2mark+$sp1mark)/4)==1){
	$sgrade ='Satisfactory';
	$sperf=((($sp1mark+$sp2mark+$sp3mark+$sp4mark)/4)*100).'%';
}
else{
	$sgrade ='Un-Satisfactory';
	$sperf=((($sp1mark+$sp2mark+$sp3mark+$sp4mark)/4)*100).'%';
}
// echo '<pre>';
// print_r($hivresults);exit;
foreach($hivresults as $hr):
	if($hr['rpanel']==1){
		$hp1yr_scres=$hr['yr_screening_desc'];
		$hp1yr_conres=$hr['yr_conf_desc'];
		$hp1yr_tbres=$hr['yr_tb_desc'];
		$hp1yr_fres=$hr['yrfr'];

		if($hr['panscreening']==2){ //NR
			//check for blank results
			if($hp1yr_scres=='' && $hp1yr_fres=='' ){
				$p1blank=true;
			}
			if($hr['screening'] == $hr['panscreening'] && $hr['screening']!='')
			{
				if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
					$p1mark=1;
				}
			}
			else { 		//screening results not concodant
				if($hr['confirmatory']==$hr['panscreening'] && $hr['confirmatory']!=''){
					if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
					$p1mark=1;
					}
				}
			}
		}
		elseif($hr['panscreening']==1){		//Reactive
			//check for blanks
			if($hp1yr_scres=='' &&$hp1yr_conres=='' && $hp1yr_fres=='' ){
				$p1blank=true;
			}
			if($hr['screening'] == $hr['panscreening'] && $hr['screening'] !='')
			{
				if($hr['confirmatory']==$hr['panscreening']){
					if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
							$p1mark=1;
						}
				}
				else { //Use tie breaker
						if($hr['Tiebreaker']==$hr['panscreening']){
							if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
								$p1mark=1;
							}
						}
				}
			}
		}
	}

	//panel 2
	if($hr['rpanel']==2){
		$hp2yr_scres=$hr['yr_screening_desc'];
		$hp2yr_conres=$hr['yr_conf_desc'];
		$hp2yr_tbres=$hr['yr_tb_desc'];
		$hp2yr_fres=$hr['yrfr'];

		if($hr['panscreening']==2){ //NR
			//check for blank results
			if($hp2yr_scres=='' && $hp2yr_fres=='' ){
				$p2blank=true;
			}
			if($hr['screening'] == $hr['panscreening'] && $hr['screening']!='')
			{
				if($hr['panfr']==$hr['finalResult']&& $hr['finalResult']!=''){
					$p2mark=1;
				}
			}
			else { 		//screening results not concodant
				if($hr['confirmatory']==$hr['panscreening'] && $hr['confirmatory']!=''){
					if($hr['panfr']==$hr['finalResult']&& $hr['finalResult']!=''){
					$p2mark=1;
					}
				}
			}
		}
		elseif($hr['panscreening']==1){		//Reactive
			//check for blanks
			if($hp2yr_scres=='' &&$hp2yr_conres=='' && $hp2yr_fres=='' ){
				$p2bank=true;
			}
			if($hr['screening'] == $hr['panscreening'] && $hr['screening']!='')
			{
				if($hr['confirmatory']==$hr['panscreening']){
					if($hr['panfr']==$hr['finalResult']&& $hr['finalResult']!=''){
							$p2mark=1;
						}
				}
				else { //Use tie breaker
						if($hr['Tiebreaker']==$hr['panscreening']){
							if($hr['panfr']==$hr['finalResult']&& $hr['finalResult']!=''){
								$p2mark=1;
							}
						}
				}
			}
		}
	}

	//panel 3
	if($hr['rpanel']==3){
		$hp3yr_scres=$hr['yr_screening_desc'];
		$hp3yr_conres=$hr['yr_conf_desc'];
		$hp3yr_tbres=$hr['yr_tb_desc'];
		$hp3yr_fres=$hr['yrfr'];

		if($hr['panscreening']==2){ //NR
			//check for blank results
			if($hp3yr_scres=='' && $hp3yr_fres=='' ){
				$p3blank=true;
			}
			if($hr['screening'] == $hr['panscreening']&& $hr['screening']!='')
			{
				if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
					$p3mark=1;
				}
			}
			else { 	//screening results not concodant
				if($hr['confirmatory']==$hr['panscreening']&& $hr['confirmatory']!=''){
					if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
					$p3mark=1;
					}
				}
			}
		}
		elseif($hr['panscreening']==1){		//Reactive
			//check for blanks
			if($hp3yr_scres=='' &&$hp3yr_conres=='' && $hp3yr_fres=='' ){
				$p3bank=true;
			}
			if($hr['screening'] == $hr['panscreening']&& $hr['screening']!='')
			{
				if($hr['confirmatory']==$hr['panscreening'] && $hr['confirmatory']!=''){
					if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
							$p3mark=1;
						}
				}
				else { //Use tie breaker
						if($hr['Tiebreaker']==$hr['panscreening']&& $hr['Tiebreaker']!=''){
							if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
								$p3mark=1;
							}
						}
				}
			}
		}
	}

	//panel 4
	if($hr['rpanel']==4){
		$hp4yr_scres=$hr['yr_screening_desc'];
		$hp4yr_conres=$hr['yr_conf_desc'];
		$hp4yr_tbres=$hr['yr_tb_desc'];
		$hp4yr_fres=$hr['yrfr'];

		if($hr['panscreening']==2){ //NR
			//check for blank results
			if($hp4yr_scres=='' && $hp4yr_fres=='' ){
				$p4blank=true;
			}
			if($hr['screening'] == $hr['panscreening']&& $hr['screening']!='')
			{
				if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
					$p4mark=1;
				}
			}
			else { 	//screening results not concodant
				if($hr['confirmatory']==$hr['panscreening'] && $hr['confirmatory']!=''){
					if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
					$p4mark=1;
					}
				}
			}
		}
		elseif($hr['panscreening']==1){		//Reactive
			//check for blanks
			if($hp4yr_scres=='' &&$hp4yr_conres=='' && $hp4yr_fres=='' ){
				$p4blank=true;
			}
			if($hr['screening'] == $hr['panscreening']&& $hr['screening']!='')
			{
				if($hr['confirmatory']==$hr['panscreening']){
					if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
							$p4mark=1;
						}
				}
				else { //Use tie breaker
						if($hr['Tiebreaker']==$hr['panscreening'] && $hr['Tiebreaker']!=''){
							if($hr['panfr']==$hr['finalResult'] && $hr['finalResult']!=''){
								$p4mark=1;
							}
						}
				}
			}
		}
	}
endforeach;

$grade = $perf='';
if((($p1mark+$p2mark+$p3mark+$p4mark)/4)==1){
	$grade='Satisfactory';
	$perf=((($p1mark+$p2mark+$p3mark+$p4mark)/4)*100).'%';
}
else{
	$grade='Un-Satisfactory';
	$perf=((($p1mark+$p2mark+$p3mark+$p4mark)/4)*100).'%';
}
	//syphillis expected results
	foreach($syphexpectedresult as $ser):
		if($ser['panelid']==1){
			if($ser['categoryid']==4 && $hsdr==0){
				$syp1_efr=$ser['displayresult'];
			}
		}

		if($ser['panelid']==2){
			if($ser['categoryid']==4 && $hsdr==0){
				$syp2_efr=$ser['displayresult'];
			}
		}

		if($ser['panelid']==3){
			if($ser['categoryid']==4 && $hsdr==0){
				$syp3_efr=$ser['displayresult'];
			}
		}

		if($ser['panelid']==4){
			if($ser['categoryid']==4 && $hsdr==0){
				$syp4_efr=$ser['displayresult'];
			}
		}
	endforeach;
	// hiv expected results
	foreach($hivexpectedresult as $her):
		if($her['panelid']==1){
			if($her['categoryid']==1 && $hhdr==0){
				$hp1exp_scres=$her['displayresult'];
			}
			elseif($her['categoryid']==2 && $hhdr==0){
				$hp1exp_conres=$her['displayresult'];
			}
			elseif($her['categoryid']==3 && $hhdr==0){
				$hp1exp_tbres=$her['displayresult'];
			}
			elseif($her['categoryid']==4 && $hhdr==0){
				$hp1exp_fres=$her['displayresult'];
			}
		}
		elseif($her['panelid']==2) {
			if($her['categoryid']==1 && $hhdr==0){
				$hp2exp_scres=$her['displayresult'];
			}
			elseif($her['categoryid']==2 && $hhdr==0){
				$hp2exp_conres=$her['displayresult'];
			}
			elseif($her['categoryid']==3 && $hhdr==0){
				$hp2exp_tbres=$her['displayresult'];
			}
			elseif($her['categoryid']==4 && $hhdr==0){
				$hp2exp_fres=$her['displayresult'];
			}
		}
		elseif($her['panelid']==3) {
			if($her['categoryid']==1 && $hhdr==0){
				$hp3exp_scres=$her['displayresult'];
			}
			elseif($her['categoryid']==2 && $hhdr==0){
				$hp3exp_conres=$her['displayresult'];
			}
			elseif($her['categoryid']==3 && $hhdr==0){
				$hp3exp_tbres=$her['displayresult'];
			}
			elseif($her['categoryid']==4 && $hhdr==0){
				$hp3exp_fres=$her['displayresult'];
			}
		}
		elseif($her['panelid']==4) {
			if($her['categoryid']==1 && $hhdr==0){
				$hp4exp_scres=$her['displayresult'];
			}
			elseif($her['categoryid']==2 && $hhdr==0){
				$hp4exp_conres=$her['displayresult'];
			}
			elseif($her['categoryid']==3 && $hhdr==0){
				$hp4exp_tbres=$her['displayresult'];
			}
			elseif($her['categoryid']==4 && $hhdr==0){
				$hp4exp_fres=$her['displayresult'];
			}
		}
	endforeach;
?>

<!DOCTYPE>
<html>
<head>
		<style type="text/css" media="print">
			@page{
				size: auto;
				margin:0: 
			}
				#divtoprint{page-break-after: always;} /* Create a page break for each record*/
				html{
					height: 98%;
					padding-bottom: 0;
				}
				td,th{
					vertical-align:text-bottom;
				}
				body{
					background: #fff;
					color: #444;
					font:normal 45% sans-serif;
					font-size:10px;
					line-height: 1.5;
				}
				.center{
					text-align: center;
					padding: 2px;
				}
				.rptBorder{
					border-collapse: collapse;
					border-color: #098909;
					padding: 0;
					font-size: small;
				}
				.rptHeader{
					background: #f0f0f0;
					border: solid 1px #ddd;
					color: #555;
					text-align: center;
				}
				.spxZone{
					padding:6px 2px;
				}
				.rptCenter{
					text-align: center;
					padding: 4px 10px 4px 5px;
					font-weight: bold;
					line-height: normal;
					white-space: normal;
				}
				.rptCase{
					/*text-transform:none;*/
				}
				.tpBorder{
					border-top:solid 1px;
					margin-top: 4px;	
				}
				.rptbox{
					border-left: solid 1px;
					border-right: solid 1px;
				}
		</style>
<script type="text/javascript">
	function Printdivs(){
		var divtoprint=document.getElementById('divtoprint');
		var popupwin=window.open('','','width=100,height=100');
		popupwin.document.open();
		popupwin.document.write('<html><body onload="window.print()">'+divtoprint.innerHTML+'</html>');
		//popupwin.document.close();
		//window.close();
		//window.location.href = '/closekiosk';
		window.open('location', '_self', '');
		window.close();

	}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/styles1.css') ?>" media="screen" />
<style>
table {margin-bottom: 1.2em; }
th {font-weight: bold;}
thead th {background: #C3D9FF;}
th,td,caption {padding: 4px 10px 4px 5px;}
tr.even td {background: #F2F6FA;}
tfoot {font-style: italic;}
caption {background: #EEE;}
/*#BrowserPrintdefaults{display: none;}*/
.patch{
	background: #000;
	color: #fff;
	font-size: small;
	width: 120px;
	position: relative;
	top: -30px;
	padding-left: 6px;
}
.tcpatch{
	background: #000;
	color: #fff;
	font-size: 11px;
	padding: 3px;
	margin-bottom: 23px;
	border: solid 1px #000;
}
.vri{
	width:140px;
	position: relative;
	top:-35px;
	left: 80px;
	font-weight: bold;
	font-size: small;
}
.uvri_heading,.sero_heading,.prof_heading,.dts_heading{
	text-transform:uppercase;
	text-align: center;
	font-weight:bold;
}
.uvri_heading{
	font-family: "Times New Roman",Georgia,Serif;
	font-size: large;
	
}
.sero_heading{
	font-family: arial;
	font-size: large;
	font-weight: bolder;
}
.prof_heading{
	font-family: "Times New Roman",Georgia,Serif;
	font-size: large;;
}
.dts_heading{
	font-family: serif;
	font-weight: bolder;
	font-variant-caps: all-small-caps;
	font-size: small;
}
.mocd{
	font-size: 20px;
	font-weight: bolder;
	text-transform: uppercase;

}
.tclbl{
	text-align: center;
	vertical-align:text-top;
	font-size: 16px;
	font-weight: bold;
	margin-top: -5px;
	border: solid 1px;
	position: relative;
	top: -20px;
	border-top: none;
}
table.data-table {
	border: 1px solid #CCB;
	margin-bottom: 1em;
	/*width: 100%;*/
}
table.data-table th {
	background: #F0F0F0;
	border: 1px solid #DDD;
	color: #555;
	text-align: center;
	/*text-align: left;*/
}
table.data-table tr {border-bottom: 1px solid #DDD;}
table.data-table td, table th {padding: 6px;}
table.data-table td {
	background: #F6F6F6;
	border: 1px solid #DDD;
}
table.data-table tr.even td {background: #FCFCFC;}
table {border-collapse:collapse;}
table.data-table{margin-top:5px;}
</style>	
</head>


	<!--input type="button" name="simon" value="print" onclick="Printdiv();"-->
	<body>
		<div id="divtoprint" style="width:1000px; margin:auto;">
				<!--      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   -->
		<div class="row" style="width:900px;">
		<div style="width:16%;display:inline-block;">
			<img src="<?php echo base_url('assets/images/moh.png');?>" alt="UVRI" align="absmiddle" >
			<div class="vri">
				Uganda Virus Research Institute
			</div>
			<div class="patch">
				UVRI Toll Free:<br>
				Call: 0800100410<br>
				SMS: 8227
			</div>
		</div>
		<div style="width:70%; display:inline-block; align-self: center; position:relative;top:-30px;">
			<div class="uvri_heading">uganda virus reserch institute</div>
			<div class="sero_heading">national hiv serology qa/qc</div>
			<div class="prof_heading">hiv/syphilis proficiency assessment scheme</div>
			<div class="dts_heading">dts result report</div>
		</div>
		<div style="width:12%;display:inline-block;float:right;position:relative; top:30px;">
			<div class="mocd">moh/cdc</div>
			<div class="tcpatch">TESTER CODE</div>
			<div class="tclbl"><?php echo $rp['testercode'];?></div>
		</div>
	</div>

		  <table  border="0" class="data-table" width="100%" style="font-size:12px;">		 
            
         <tr class="even">
            <th colspan="2">FEED BACK REPORT</th>
          </tr>
		  <TR>
		  <td> <TABLE width="100%" style="font-size:12px;">  
		   <th colspan="4"> <b>TESTING SITE DETAILS<b></th>
		  <tr class ="even">
            <td ><b> Testing Site</b></td>
            <td colspan="3">
					<?php 
					 echo $rp['Sitename'];?>  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php echo '<br><span style="float:right;"><strong>', $rp['owner'],'</strong></span>'; 

					 ?>
	</td>
            </tr>
			 <tr class ="even">
            <td colspan="1"><b> Department</b></td>
            <td colspan="1">
			<?php  echo $rp['departmentname'];?>   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php //echo  $rp['deliverymode'];  ?>
	</td>
	 
            </tr>
			<tr class="even">
			  <td ><b> Ownership</b></td>
            <td colspan="3">
					<?php  echo $rp['owner'];?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php echo  $rp['location']; ?>
	</td>
			</tr>
			 <tr class="even">
            <td > <b>Sub county</b></td>
            <td colspan="3">
					<?php  echo $rp['division'];?>
	</td>
	  </tr>
          <tr class="even">
            <td > <b>District</b></td>
            <td colspan="3">
					<?php  echo $rp['DistrictName'];?>
	</td>
	  </tr>
	 <tr class="even">
            <td ><b> Region</b></td>
            <td colspan="3">
					<?php  echo $rp['region']; ?>
	</td>
		  </tr> 
		 
		  </TABLE style="font-size:12px;"></td>
		  <td> <TABLE width="100%">  <tr class ="even">
            <th colspan="2"> <b>SAMPLE SPECIFICATIONS<b></th>
                </tr>
          <tr class="even">
            <td ><b> Sample ID<b></td>
            <td >
					UVRI-HIV QA <?php echo $rp['cycle']; ?>
	</td>
	  </tr>
	   
	 <tr class="even">
            <td ><b> Date of Dispatch<b></td>
            <td >
					<?php  echo $rp['dod'];?>
	</td>
	</tr>
	<tr class="even">
            <td ><b> Date Received<b></td>
            <td >
					<?php  echo $rp['dsr'];?>
	</td>
	</tr>
	 <tr class="even">
            <td ><b> Date Reconstituted<b></td>
            <td >
					<?php  echo $rp['dtsr'];?>
	</td>
		  </tr> 
		   <tr class="even">
            <td ><b> Date Sample Tested<b></td>
            <td >
					<?php  echo $rp['dtst'];?>
	</td>
		  </tr> 
		 
				   <tr class="even">
            <td ><b> Date Results Received at UVRI<b></td>
            <td colspan="">
					<?php  echo $rp['DateRxAtUVRI'];?>
	</td>
		  </tr> </TABLE> </td>
		  </TR>
         
		      <tr class="even">
            <th colspan="2">CONTACT DETAILS</th>
          </tr> 
    <TR>
		  <td colspan="2"> <table  border="0" class="data-table" width="100%">		 
		  	 
			<tr class ="even">
            <td colspan="1"><b> Site Supervisor</b></td>
            <td colspan="1"><?php  echo $rp['supervisorname'];?>	</td>
	        <td ><b> Testing Personnel</b></td>
            <td colspan="3"><?php  echo $rp['TesterName'];?>	</td>
            </tr>
			<tr class ="even">
            <td colspan="1"><b> Telephone</b></td>
            <td colspan="1"><?php  echo $rp['tel'];?>	</td>
	        <td ><b> Telephone</b></td>
            <td colspan="3"><?php  echo $rp['contacts']; ?>	</td>
            </tr>
		
		  </TABLE></td>
		  </TR>
             
		   <tr class="even">
            <th colspan="2">KIT DETAILS</th>
          </tr> 
    <TR>
		  <td colspan="2">
		   <table  border="0" class="data-table" width="100%" style="font-size:12px;">		 
		  	 
			<tr class="odd">
				<th colspan="6">HIV Kits</th>
				<th colspan="2">Syphilis Kits</th>
			</tr>
			
		   	<tr class="even">
			<?php
			
			
			$ctd=count($td);
			$t1="";$t2="";$t3="";
			$t1lot="";$t2lot="";$t3lot="";
			$t1edate="";$t3edate="";$t3edate="";
			if($ctd>0){
				for ($i=0; $i < $ctd; $i++) { 
					$sc=$td[$i]['testcatid'];
					if($sc=='1'){
						$t1=$td[$i]['testname'];
						$t1lot=$td[$i]['lotno'];
						$t1edate=$td[$i]['expdt'];
					}
					elseif($sc=='2'){
						$t2=$td[$i]['testname'];
						$t2lot=$td[$i]['lotno'];
						$t2edate=$td[$i]['expdt'];
					}
					elseif($sc=='3'){
						$t3=$td[$i]['testname'];
						$t3lot=$td[$i]['lotno'];
						$t3edate=$td[$i]['expdt'];
					}
				}
			}
	
			?>
			 			<td style='background:#FAFAFA' width="12.5%"><b> Kit1: </b></td>
			 			<td style='background:#FAFAFA' width="12.5%"><?php echo $t1; ?></td>
			  		<td style='background:#FAFAFA' width="12.5%"><b> Kit 2: </b></td>
		 			 	<td style='background:#FAFAFA' width="12.5%"><?php echo $t2; ?> </td>
					  <td style='background:#FAFAFA' width="12.5%"><b> Kit 3: </b></td>
					 	<td style='background:#FAFAFA' width="12.5%"><?php echo $t3; ?> </td>
					 	<td style="background-color: #FAFAFAFA;" width="12.5%">Kit Name:</td>
					 	<td> <?php  if(isset($syphkits['kitName'])){ echo $syphkits['kitName'];};?></td>
             </tr>
			 <tr  class="even">
			 					   <td style='background:#FAFAFA'><b>Lot #: </b></td>
					  <td style='background:#FAFAFA'><?php if(isset($t1lot)){echo $t1lot;} ?></td>
					   <td style='background:#FAFAFA'><b>Lot # 2:</b></td>
		 			 <td style='background:#FAFAFA'><?php if(isset($t2lot)){ echo $t2lot;} ?> </td>
					  <td style='background:#FAFAFA'><b>Lot # 3: </b></td>
					 <td style='background:#FAFAFA'><?php if(isset($t3lot)){echo $t3lot;} ?> </td>
					 <td>Lot #</td><td><?php  if(isset($syphkits['LotNo'])){echo $syphkits['LotNo'];}?></td>
					 </tr>
			 <tr  class="even">
			 					   <td style='background:#FAFAFA'><b>Expiry Date: </b></td>
					  <td style='background:#FAFAFA'><?php if(isset($t1edate)){echo $t1edate;} ?></td>
					   <td style='background:#FAFAFA'><b>Expiry Date</b></td>
		 			 <td style='background:#FAFAFA'><?php if(isset($t2edate)){echo $t2edate;} ?> </td>
					  <td style='background:#FAFAFA'><b>Expiry Date </b></td>
					 <td style='background:#FAFAFA'><?php if(isset($t3edate)){echo $t3edate;} ?> </td>
					 <td>Expiry Date:</td><td><small><?php if(isset($syphkits['expiryDate'])){echo $syphkits['expiryDate'];}?></small></td>
					 </tr>
			
			
			
		  </TABLE></td>
		  </TR>
		   <tr class="even">
            <th colspan="2"> RESULTS</th>
          </tr>
          <tr class="even">
            <td colspan="2">  
      <table  border="0" class="data-table" width="100%">		 
			<tr>
				<td colspan="10"><strong>HIV</strong></td>
				<td colspan="3"><strong>SYPHILIS</strong></td>
			</tr>				
			<tr>
				<th rowspan="2" width="19%"> <small>Sample ID</small></th>
				<th  colspan="2"><small>Screening</small></th>
				<th  colspan="2"><small>Confirmatory</small></th>
				<th  colspan="2"><small>Tie Breaker</small></th>
				<th  colspan="2"><small>Final Result</small></th>
				<th><small>Status</small></th>
				<th  colspan="2"><small>Final Result</small></th>
				<th><small>Status</small></th>
				
				
				
					
		  </tr>
		  <tr>
				
				<th  ><small>YR</small></th>
				<th  ><small>ER</small></th>
				<th  ><small>YR</small></th>
				<th  ><small>ER</small></th>
				<th  ><small>YR</small></th>
				<th  ><small>ER</small></th>
				<th  ><small>YR</small></th>	
				<th  ><small>ER</small></th>	
				<th  ><small>Pass/Fail</small></th>
				<th  ><small>YR</small></th>	
				<th  ><small>ER</small></th>	
				<th  ><small>Pass/Fail</small></th>	
		  </tr>
		  <tr>
		  		<td><small><?php echo $rp['panel_label'].'-1'; ?></small></td>
		  		<td><small><?php if(isset($hp1yr_scres)){echo $hp1yr_scres; } ?></small></td>
		  		<td style="text-align:center;"><small><?php if(isset($hp1exp_scres)){echo $hp1exp_scres;} ?></small></td>
		  		<td><small><?php if(isset($hp1yr_conres)){echo $hp1yr_conres;}  ?></small></td>
		  		<td style="text-align:center;"><small><?php if(isset($hp1exp_conres)){echo $hp1exp_conres;} ?></small></td>
		  		<td><small><?php if(isset($hp1yr_tbres)){echo $hp1yr_tbres;} ?></small></td>
		  		<td style="text-align:center;"><small><?php  if(isset($hp1exp_tbres)){echo $hp1exp_tbres;} ?></small></td>
		  		<td><small><?php echo $hp1yr_fres; ?></small></td>
		  		<td style="text-align:center;"><small><?php if(isset($hp1exp_fres)){echo $hp1exp_fres;} ?></small></td>
		  		<td><small><?php if(count($hivresults)>0){if($hhdr==0 || ($hhdr==1 && $sfr==1)){if($p1mark==1 ){ echo 'PASS'; } else {echo 'FAIL';}}} ?></small></td>
		  		<td><small><?php echo $syp1_fr;?></small></td>
		  		<td><small><?php if(isset($syp1_efr)){ echo $syp1_efr;}?></small></td>
		  		
		  		<td><small>
		  			<?php 
		  			if($syp1_fr!=''){
		  				if($syp1_efr ==''){
			  				echo '';
			  			}
				  		elseif($syp1_efr==$syp1_fr)
				  			{ echo 'PASS';} 
				  		elseif($syp1_fr!=$syp1_efr && $syp1_fr=='')
				  			{echo 'Un-Graded';}
				  		else
				  			{ echo 'FAIL';}
				  	}
		  			?>
		  			</small></td>
		  </tr>
		  <tr>
		  		<td><small><?php echo $rp['panel_label'].'-2';   ?></small></td>
		  		<td><small><?php echo $hp2yr_scres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp2exp_scres; ?></small></td>
		  		<td><small><?php echo $hp2yr_conres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp2exp_conres; ?></small></td>
		  		<td><small><?php echo $hp2yr_tbres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp2exp_tbres; ?></small></td>
		  		<td><small><?php if(isset($hp2yr_fres)){echo $hp2yr_fres;} ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp2exp_fres; ?></small></td>
		  		
		  		<td><small><?php if(count($hivresults)>0){if($hhdr==0 || ($hhdr==1 && $sfr==1)){if( $p2mark==1){ echo 'PASS'; } else {echo 'FAIL';}}} ?></small></td>
		  		<td><small><?php echo $syp2_fr; ?></small></td>
		  		<td><small><?php echo $syp2_efr; ?></small></td>
		  		
		  		<td><small> 
		  			<?php 
		  			if($syp2_fr!=''){
		  				if($syp2_efr ==''){
			  				echo '';
			  			}
			  			elseif($syp2_efr==$syp2_fr)
			  			{ echo 'PASS';} 
			  			elseif($syp2_fr!=$syp2_efr && $syp2_fr=='')
			  				{echo 'Un-Graded';}
			  			else{ echo 'FAIL';} 
		  			}
		  			?>
		  			</small></td>
		  </tr>
		  <tr>
		  	<?php
							if($cycle==36){
								if($hp3yr_scres!='' && $hp3yr_scres=='NR')
	  						{ 
	  								$hp3exp_scres=$hp3yr_scres; $hp3yr_conres=$hp3exp_conres;
	  								if($hp3exp_fres=='NEG'){
	  									$hp3exp_fres=$hp3exp_fres;
	  									$p3mark=1;
	  									//$score=$score+25;
	  								}
	  						}

	  						if($hp3yr_scres!='' && $hp3yr_scres=='R' ){ 
	  							$hp3exp_tbres='R';
	  							if($hp3yr_conres=='R')
	  								{
	  									if($hp3exp_conres!='R'){
	  										if($hp3yr_tbres=='R'){
	  											if($hp3exp_fres=='POS' || $hp3exp_fres=='INC'){
	  												$hp3exp_tbres=$hp3yr_tbres; 
				  									$hp3exp_fres='POS'; 
				  									$p3mark=1;
				  									//$score=$score+25;
	  											}
	  										}
	  									}
	  									else {
	  										$hp3exp_tbres=$hp3yr_conres; 
		  									$hp3exp_fres='POS'; 
		  									$p3mark=1;
		  									//$score=$score+25;
	  									}
	  								}

	  						}
	  						//if($score==100){$status='PASS';} //updating status for cycle 36
							}
				 ?>
		  		<td><small><?php echo $rp['panel_label'].'-3';  ?></small></td>
		  		<td><small><?php echo $hp3yr_scres  ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp3exp_scres; ?></small></td>
		  		<td><small><?php echo $hp3yr_conres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp3exp_conres; ?></small></td>
		  		<td><small><?php echo $hp3yr_tbres;?></small></td>
		  		<td style="text-align:center;"><small><?php if($hp3yr_tbres !=''){echo $hp3exp_tbres;} ?></small></td>
		  		<td><small><?php echo $hp3yr_fres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp3exp_fres; ?></small></td>
		  		
		  		<!--td><small><?php //if($hhdr==0 || ($hhdr==1 && $sfr==1)){if($p3mark==1){ echo 'PASS'; } else {echo 'FAIL';}} ?></small></td-->
		  		<td><small><?php if(count($hivresults)>0){if($hhdr==0 || ($hhdr==1 && $sfr==1)){if($p3mark ==1){ echo 'PASS'; } else {echo 'FAIL';}}} ?></small></td>
		  		<td><small><?php echo $syp3_fr; ?></small></td>
		  		<td><small><?php echo $syp3_efr; ?></small></td>
		  		
		  		<td><small>
		  			<?php
		  			if($syp3_fr!='')
		  			{
			  			if($syp3_efr ==''){
			  				echo '';
			  			}
			  			elseif($syp3_efr==$syp3_fr)
			  				{ echo 'PASS';} 
			  			elseif($syp3_fr!=$syp3_efr && $syp3_fr=='')
			  				{echo 'Un-Graded';}
			  			else
			  				{ echo 'FAIL';} 
		  			}
		  		?>
		  			
		  				</small></td>
		  </tr>
		  <tr>
		  		<td><small><?php echo $rp['panel_label'].'-4';  ?></small></td>
		  		<td><small><?php if(isset($hp4yr_scres)) {echo $hp4yr_scres;}  ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp4exp_scres; ?></small></td>
		  		<td><small><?php if(isset($hp4yr_conres)){ echo $hp4yr_conres;} ?></small></td>
		  		<td style="text-align:center;"><small><?php if(isset($hp4exp_conres)) {echo $hp4exp_conres;} ?></small></td>
		  		<td><small><?php echo $hp4yr_tbres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp4exp_tbres; ?></small></td>
		  		<td><small><?php echo $hp4yr_fres; ?></small></td>
		  		<td style="text-align:center;"><small><?php echo $hp4exp_fres; ?></small></td>
		  		
		  		<td><small><?php if(count($hivresults)>0){if($hhdr==0 || ($hhdr==1 && $sfr==1)){if($p4mark ==1){ echo 'PASS'; } else {echo 'FAIL';}}} ?></small></td>
		  		<td><small><?php if(isset($syp4_fr)){echo $syp4_fr;} ?></small></td>
		  		<td><small><?php if(isset($syp4_efr)){echo $syp4_efr;}  ?></small></td>
		  		
		  		<td><small><?php 

		  					if(isset($syp4_fr) and $syp4_fr!='' ){
		  						if($syp4_efr==''){
		  							echo '';
		  						}
		  						elseif($syp4_efr==$syp4_fr)
		  							{ echo 'PASS';} 
		  						elseif($syp4_fr!=$syp4_efr && $syp4_fr=='' )
		  							{echo 'Un-Graded';}
		  						else{ echo 'FAIL';}
		  					}
		  			 ?></small></td>
		  </tr>
		  <?php
		
		  ///check comments for missing testkit dates and expiry
	 		 if(count($hivothercomments)>0){
							for ($i=0; $i < count($hivothercomments); $i++) { 
								if($hivothercomments[$i]['commentid']==3 or $hivothercomments[$i]['commentid']==2 or $hivothercomments[$i]['commentid']==9 or $hivothercomments[$i]['commentid']==10){
									$St='Un-Graded';
									$noExpectedRes=1;
								}
							}
						} 
			?> 
	 
		  </table>
		  <table width="100%" align="center">
		  <tr><td colspan="4">HIV PT Outcome</td><td colspan="4">Syphilis PT Outcome</td></tr>
		    <tr>
		 	 <td width="12.5%"><div align="center"><strong>Percentage Score</strong></div></td>
		 	 <td width="12.5%"><div align="center"><?php if(isset( $rp['score'])){echo $rp['score'];} ?></div></td>
			 <td width="12.5%"><div align="center"><strong>Overall Status</strong></div></td>
		 	 <td width="12.5%"><div align="center"><?php if(isset($rp['status'])){echo $rp['status']; }?></div></td>
		 	 <td width="12.5%"><div align="center"><strong>Percentage Score</strong></div></td>
		 	 <td width="12.5%"><div align="center"><?php if(isset($syphkits['score'])){echo  $syphkits['score'];} ?></div></td>
			 <td width="12.5%"><div align="center"><strong>Overall Status</strong></div></td>
		 	 <td width="12.5%"><div align="center"><?php if(isset($syphkits['score'])){echo  $syphkits['Result'];}?></div></td>
	</tr>
	
	 <tr>
	 <td colspan="8"><strong> Final Comments/Corrective Action Recommended </strong></td>

	</tr>
	
	 <tr>
	<td colspan="4"><?php
		/*  hiv comments*/
		$hcomment='';
		if(count($syphcomments)>0)
		{
					foreach($syphcomments as $com):
						if($com['schemeid']==1){
							$hcomment.= '<span>'.$com['description'].'</span>, &nbsp;'; 
						}
					endforeach;
					$hcomment=rtrim($hcomment,', ');
					// if(isset($hcomment))
					// {
						echo $hcomment;
					//}
		}
		
	?>
		
	</td>
	<td colspan="4">
		<?php 
			//syphilis comments
		$scomment='';
		if(count($syphcomments)>0)
		{
					foreach($syphcomments as $com):
						if($com['schemeid']==2){
							$scomment.= '<span>'.$com['description'].'</span>, &nbsp;'; 
						}
					endforeach;
					$scomment=rtrim($scomment,', ');
					// if($scomment)
					// {
						echo $scomment;
					//}
		}
		?>
	
	</td>
	</tr>
	
<!--      removed some staff -->
	 <tr class="even">
            <th colspan="8"> FOR PROJECT COORDINATOR</th>
          </tr>
	<tr  >
	<td colspan="4" ><strong>Name: &nbsp;&nbsp;&nbsp;<?php echo $approver[0]['names']; ?>  </strong></td>
	<td colspan="2" ><strong>Sign: &nbsp;&nbsp;&nbsp; <?php echo'<img src="'.base_url('assets/images/Signatures/'. $approver[0]['signature']).'" width="95px; height=70px;">';?>  </strong></td>
	<td colspan="2" ><strong>Date: &nbsp;&nbsp;&nbsp; <?php echo cleanDate($rp['approvaldate']);?> </strong></td>
		</tr>
		  </table> 
		      
	</table>
<div style="font-size:14px; background-color: #000; color:#fff; padding: 5px; font-weight: bolder; margin-top: -40px;" >KEY: NR - Non Reactive, R - Reactive, INV - Invalid, ER - Expected Result, YR - Your Result </div>

</div>
</body>

