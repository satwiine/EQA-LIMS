
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">



<style type="text/css" media="print">
			@page{
				size:auto;
				margin: 0;
			}
			#divtoprint{
				page-break-after: always; /*creates a page break per record*/
			}
			html{
				height: 98%;
				padding-bottom: 0;
			}

			td,th{
				vertical-align: text-bottom;
			}
			body{
				background-color: #fff;
				color: #444;
				font: normal 45% sans-serif;
				font-size: 10px;
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

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/styles.css');?>">

		<style>
			table {margin-bottom: 1.2em; }
			th {font-weight: bold;}
			thead th {background: #C3D9FF;}
			th,td,caption {padding: 4px 10px 4px 5px;}
			tr.even td {background: #F2F6FA;}
			tfoot {font-style: italic;}
			caption {background: #EEE;}
			/*#BrowserPrintDefaults{display: none;}*/
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
<?php 
//picking syphilis duo info if its there
$syphrecord = $pickup_kitname = $pickup_lotno = $pickup_expdt='';


$ep1cat1res='';$ep2cat1res='';$ep3cat1res='';$ep4cat1res='';
$ep1cat2res='';$ep2cat2res='';$ep3cat2res='';$ep4cat2res='';
$ep1cat3res='';$ep2cat3res='';$ep3cat3res='';$ep4cat3res='';
$ep1frres='';$ep2frres='';$ep3frres='';$ep4frres='';

//expected results variables
$p1screxp_res=$p1conexp_res=$p1tbexp_res=$p1frexp_res=$p1syphfrexp_res='';
$p2screxp_res=$p2conexp_res=$p2tbexp_res=$p2frexp_res=$p2syphfrexp_res='';
$p3screxp_res=$p3conexp_res=$p3tbexp_res=$p3frexp_res=$p3syphfrexp_res='';
$p4screxp_res=$p4conexp_res=$p4tbexp_res=$p4frexp_res=$p4syphfrexp_res='';

$hivp1scr_res=''; $hivp1con_res=''; $hivp1tb_res=''; $hivp1fr_res=''; 
$hivp2scr_res=''; $hivp2con_res=''; $hivp2tb_res=''; $hivp2fr_res=''; 
$hivp3scr_res=''; $hivp3con_res=''; $hivp3tb_res=''; $hivp3fr_res=''; 
$hivp4scr_res=''; $hivp4con_res=''; $hivp4tb_res=''; $hivp4fr_res='';


$cycle=$sample['cycleid'];



//tester results
foreach($dtsresult as $d):
	if($d['panelid']==1 && $d['testcatid']==1){
		$hivp1scr_res=$d['result'];
	}

	if($d['panelid']==1 && $d['testcatid']==2){
		$hivp1con_res=$d['result'];
	}

	if($d['panelid']==1 && $d['testcatid']==3){
		$hivp1tb_res=$d['result'];
	}

	if($d['panelid']==1 && $d['testcatid']==4){
		$hivp1fr_res=$d['result'];
	}

	if($d['panelid']==2 && $d['testcatid']==1){
		$hivp2scr_res=$d['result'];
	}

	if($d['panelid']==2 && $d['testcatid']==2){
		$hivp2con_res=$d['result'];
	}

	if($d['panelid']==2 && $d['testcatid']==3){
		$hivp2tb_res=$d['result'];
	}

	if($d['panelid']==2 && $d['testcatid']==4){
		$hivp2fr_res=$d['result'];
	}

	//p3
	if($d['panelid']==3 && $d['testcatid']==1){
		$hivp3scr_res=$d['result'];
	}

	if($d['panelid']==3 && $d['testcatid']==2){
		$hivp3con_res=$d['result'];
	}

	if($d['panelid']==3 && $d['testcatid']==3){
		$hivp3tb_res=$d['result'];
	}

	if($d['panelid']==3 && $d['testcatid']==4){
		$hivp3fr_res=$d['result'];
	}

//p4
	if($d['panelid']==4 && $d['testcatid']==1){
		$hivp4scr_res=$d['result'];
	}

	
	if($d['panelid']==4 && $d['testcatid']==2){
		$hivp4con_res=$d['result'];
	}

	if($d['panelid']==4 && $d['testcatid']==3){
		$hivp4tb_res=$d['result'];
	}

	if($d['panelid']==4 && $d['testcatid']==4){
		$hivp4fr_res=$d['result'];
	}
endforeach;

///expected results
foreach($hivexpectedresult as $w):
	if($w['panelid']==1 && $w['categoryid']==1){
		$ep1cat1res=$w['result'];
		$p1screxp_res=$w['displayresult'];
	}

	if($w['panelid']==1 && $w['categoryid']==2){
		$ep1cat2res=$w['result'];
		$p1conexp_res=$w['displayresult'];
	}

	if($w['panelid']==1 && $w['categoryid']==3){
		$ep1cat3res=$w['result'];
		$p1tbexp_res=$w['displayresult'];
	}

	if($w['panelid']==1 && $w['categoryid']==4){
		$ep1frres=$w['result'];
		$p1frexp_res=$w['displayresult'];
	}

	if($w['panelid']==2 && $w['categoryid']==1){
		$ep2cat1res=$w['result'];
		$p2screxp_res=$w['displayresult'];
	}

	if($w['panelid']==2 && $w['categoryid']==2){
		$ep2cat2res=$w['result'];
		$p2conexp_res=$w['displayresult'];
	}

	if($w['panelid']==2 && $w['categoryid']==3){
		$ep2cat3res=$w['result'];
		$p2tbexp_res=$w['displayresult'];
	}

	if($w['panelid']==2 && $w['categoryid']==4){
		$ep2frres=$w['result'];
		$p2frexp_res=$w['displayresult'];
	}

	if($w['panelid']==3 && $w['categoryid']==1){
		$ep3cat1res=$w['result'];
		$p3screxp_res=$w['displayresult'];
	}

	if($w['panelid']==3 && $w['categoryid']==2){
		$ep3cat2res=$w['result'];
		$p3conexp_res=$w['displayresult'];
	}

	if($w['panelid']==3 && $w['categoryid']==3){
		$ep3cat3res=$w['result'];
		$p3tbexp_res=$w['displayresult'];
	}


	if($w['panelid']==3 && $w['categoryid']==4){
		$ep3frres=$w['result'];
		$p3frexp_res=$w['displayresult'];
	}


	if($w['panelid']==4&& $w['categoryid']==1){
		$ep4cat1res=$w['result'];
		$p4screxp_res=$w['displayresult'];
	}

	if($w['panelid']==4&& $w['categoryid']==2){
		$ep4cat2res=$w['result'];
		$p4conexp_res=$w['displayresult'];
	}

	if($w['panelid']==4&& $w['categoryid']==3){
		$ep4cat3res=$w['result'];
		$p4tbexp_res=$w['displayresult'];
	}

	if($w['panelid']==4 && $w['categoryid']==4){
		$ep4frres=$w['result'];
		$p4frexp_res=$w['displayresult'];
	}
endforeach;

//echo $hivp4scr_res;
//print_r($dtsresult);


$p1=markLine($ep1cat1res,$hivp1scr_res,$ep1cat2res,$hivp1con_res,$ep1cat3res,$hivp1tb_res,$ep1frres,$hivp1fr_res);
$p2=markLine($ep2cat1res,$hivp2scr_res,$ep2cat2res,$hivp2con_res,$ep2cat3res,$hivp2tb_res,$ep2frres,$hivp2fr_res);
$p3=markLine($ep3cat1res,$hivp3scr_res,$ep3cat2res,$hivp3con_res,$ep3cat3res,$hivp3tb_res,$ep3frres,$hivp3fr_res);
$p4=markLine($ep4cat1res,$hivp4scr_res,$ep4cat2res,$hivp4con_res,$ep4cat3res,$hivp4tb_res,$ep4frres,$hivp4fr_res);



////marking function
function markLine($sexp=null,$sact=null,$cexp=null,$cact=null,$texp=null,$tact=null,$fexp=null,$fact=null)
{
$d='';
	if($sexp==2){ //Non Reacive
		if($sact==2){
			if($fact==3 && $fexp==3){
				$d='PASS';
			}
			else{
				if($fact==8 || trim($fact=='') || empty($fact)){
					$d='N/A';
				}
				else{
					$d='FAIL';
				}
			}
		}
		else 
		{
			if((trim($sact)=='' && trim($fact)=='') ||$sact==6 &&trim($fact)==''){ //missing or invalid screening  and missingfinal  results 
				$d='N/A';
			}
			elseif((trim($sact)==5 && trim($fact)==7) || $sact==5 && trim($fact)==''){ //invalid screening with inditerminate or blank final results
				$d='N/A';
			}

			elseif(trim($sact==5) &&trim($cact==2) && trim($fact)==3){ //invalid screening but used confirmatory as screening
				$d='PASS';
			}
			elseif(trim($sact)=='' and trim($fact)!=''){ //final results with out screening result
				$d='FAIL';
			}
			else {
				$d='FAIL';
			}
		}
		if($sact==1){ //Reactive
			if($cact==2)
			{
				if($tact==2)
				{
					if($fact==3 && $fexp==3)
					{
						$d='PASS';
					}
					else 
					{
						$d='FAIL';
					}
				}
				else 
				{
					$d='FAIL';
				}
			}
			else
			{
				$d='FAIL';
			}
		}
	}

	if($sexp==1){
		if($sact==1){
			if($cact==1 && $cexp==1){
				if($fexp==4 && $fact==4){
					$d='PASS';
				}
				else {
					if($fact==8 || $fact=''){
						$d='N/A';
					}
					else {
						$d='FAIL';
					}
				}
			}
			else 
			{
				if($cact=='' && $cexp==1)
				{
					if($tact==1){
						if($fexp==4 && $fact==4)
						{
							$d='FAIL';
						}
						else 
						{
							$d='FAIL';
						}
					}
					else 
					{
						if($fact==8)
						{
							$d='N/A';
						}
						else 
						{
							$d='FAIL';
						}
					}
				}
				else
				{
					if($cact==8)
					{
						$d='N/A';
					}
					elseif ($cact==6 && $fact==''){
						$d='N/A';
					}
					elseif($cact==5 || $cact==2){
						if($tact==1){
							if($fact==4 && $fexp==4){
								$d='PASS';
							}
							else {
								$d='FAIL';
							}
						}
						else
						{
							$d='FAIL';
						}
					}
					else {
						$d='FAIL';
					}
				}
			}
		}
		else 
		{
			if(($sact=='' && $fact=='') || $sact==6 && $fact=='')
			{
				$d='N/A';
			}
			elseif($sact=='' &&$fact!=''){
				$d='FAIL';
			}
			else 
			{
				$d='FAIL';
			}
		}
	}
	return $d;
}


/////syphillis
$p1er=''; $p1r='';$p2er=''; $p2r='';$p3er=''; $p3r='';$p4er=''; $p4r='';


foreach($syphresult as $sr):
	if($sr['panelid'] ==1){
		$p1r=$sr['result'];
		
	}

	if($sr['panelid'] ==2){
		$p2r=$sr['result'];
		
	}
	if($sr['panelid'] ==3){
		$p3r=$sr['result'];
		
	}

	if($sr['panelid'] ==4){
		$p4r=$sr['result'];
		
	}
endforeach;

foreach($syphexpectedresult as $esr):
	if($esr['panelid'] ==1){
		$p1er=$esr['result'];
		$p1syphfrexp_res=$esr['displayresult'];
	}

	if($esr['panelid'] ==2){
		$p2er=$esr['result'];
		$p2syphfrexp_res=$esr['displayresult'];
	}
	if($esr['panelid'] ==3){
		$p3er=$esr['result'];
		$p3syphfrexp_res=$esr['displayresult'];
	}

	if($esr['panelid'] ==4){
		$p4er=$esr['result'];
		$p4syphfrexp_res=$esr['displayresult'];
	}
endforeach;


function markLineSyph($fexp=null,$fact=null){
	if($fexp==3){ //negative result
		if($fact== $fexp){
			$d='PASS';
		}
		else
		{
			$d='FAIL';
		}
	}
	elseif($fexp==4) 
	{	//Positive
		if($fact== $fexp){
			$d='PASS';
		}
		else
		{
			$d='FAIL';
		}
	}
	else {
		$d='FAIL';
	}
	return $d;
}
 $sp1=markLineSyph($p1er,$p1r);
 $sp2=markLineSyph($p2er,$p2r);
 $sp3=markLineSyph($p3er,$p3r);
 $sp4=markLineSyph($p4er,$p4r);

 ///generate score and Status
 			if(count($dtsresult)>0){
 				$score=0;
				$status='FAIL';
 			}
 			else {
 				$score='';
				$status='';
 			}
			if(count($syphresult)>0){
				$syphscore=0;
			$syphstatus='FAIL';
			}
			else {
				$syphscore='';
			$syphstatus='';
			}
			

			 //print_r($syphresult);
			///////hiv results grading
			 if($dtsresult){
			 	if($p1=='PASS'){
				 	$score+=25;
				 }
				 if($p2=='PASS'){
				 	$score+=25;
				 }
				 if($cycle==36){	/// disregarding the 3 panel of Jan - Mar 2024
				 		if($p3=='PASS'){
				 		$score+=25;
				 	}
				 	else{
				 		$score+=0;
				 	}
				 }
				 else {
				 	if($p3=='PASS'){
				 	$score+=25;
				 }
				 }
				 
				 if($p4=='PASS'){
				 	$score+=25;
				 }
				
					 	if($score==100)
					 	{
				 			$status='PASS';
				 		}
				 		else 
				 		{
				 			$status='FAIL';
				 		}
			 	//	}
			 }
			 ///syphilis results grading
			 if($syphresult){
			 	if($sp1=='PASS'){
				 	$syphscore+=25;
				 }
				 if($sp2=='PASS'){
				 	$syphscore+=25;
				 }
				 if($sp3=='PASS'){
				 	$syphscore+=25;
				 }
				 if($sp4=='PASS'){
				 	$syphscore+=25;
				 }

				 if($syphscore==100){
				 	$syphstatus='PASS';
				 }
				 else{
				 	$syphstatus='FAIL';
				 }
			 }


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

       


        <div class="box">
         
          <?php
         // echo count($syphiliskit); exit;
          //testkit holding variables
							$hivscreening=$sclot=$hivconf=$conflot=$hivtieb=$tblot=$scexp=$conexp=$tbexp='';
							
							$hivp1screening='';$hivp1confirm=''; $hivp1tie=''; $hivp1fr='';
							$hivp2screening='';$hivp2confirm=''; $hivp2tie=''; $hivp2fr='';
							$hivp3screening='';$hivp3confirm=''; $hivp3tie=''; $hivp3fr='';
							$hivp4screening='';$hivp4confirm=''; $hivp4tie=''; $hivp4fr='';

							 


							$syphkit='';	$syphlot='';	$syphexpdt='';

							$spyp1res='';$spyp2res='';$spyp3res='';$spyp4res='';

									foreach($hivtestkit as $hk):
										if($hk['testcatid']==1){
											$hivscreening=$hk['testname'];
											$sclot=$hk['lotno'];
											$scexp=$hk['expdt'];
											//get syphilis-duo kit info
											if($hk['testname']=='HIV/SYPHILLIS Duo'){
												$syphrecord=!empty($syphiliskit)? 1 : 1;
												$pickup_kitname=$hk['testname'];
												$pickup_lotno=$hk['lotno'];
												$pickup_expdt=$hk['expirydate'];
											}
										}
										elseif($hk['testcatid']==2){
											$hivconf=$hk['testname'];
											$conflot=$hk['lotno'];
											$conexp=$hk['expdt'];
										}
										if($hk['testcatid']==3){
											$hivtieb=$hk['testname'];
											$tblot=$hk['lotno'];
											$tbexp=$hk['expdt'];
										}
									endforeach;

									if(isset($syphiliskit)){
										$syphkit=$syphiliskit['kitName'];
										$syphlot=$syphiliskit['LotNo'];
										$syphexpdt=$syphiliskit['expiryDate'];


									}
							//get syphilis result
								if(isset($syphresult)){
									foreach($syphresult as $s):
										if($s['panelid']==1){
											$spyp1res=$s['Name'];
										}
										if($s['panelid']==2){
											$spyp2res=$s['Name'];
										}
										if($s['panelid']==3){
											$spyp3res=$s['Name'];
										}
										if($s['panelid']==4){
											$spyp4res=$s['Name'];
										}
									endforeach;
								}

								//get hiv results
								if(isset($dtsresult)){
									foreach($dtsresult as $d):
										if($d['panelid']==1 && $d['testcatid']==1){
											$hivp1scr_res=$d['Name'];
											$hivp1screening=$d['result']; ///the number values for grading
										}
										elseif($d['panelid']==1 && $d['testcatid']==2){
											$hivp1con_res=$d['Name'];
											$hivp1confirm=$d['result'];
										}
										elseif($d['panelid']==1 && $d['testcatid']==3){
											$hivp1tb_res=$d['Name'];
											$hivp1tie=$d['Name'];
										}
										elseif($d['panelid']==1 && $d['testcatid']==4){
											$hivp1fr_res=$d['Name'];
											$hivp1fr=$d['result'];
										}
										//panel2
										elseif($d['panelid']==2 && $d['testcatid']==1){
											$hivp2scr_res=$d['Name'];
											$hivp2screening=$d['result'];
										}
										elseif($d['panelid']==2 && $d['testcatid']==2){
											$hivp2con_res=$d['Name'];
											$hivp2confirm=$d['result'];
										}
										elseif($d['panelid']==2 && $d['testcatid']==3){
											$hivp2tb_res=$d['Name'];
											$hivp2tie=$d['result'];
										}
										elseif($d['panelid']==2 && $d['testcatid']==4){
											$hivp2fr_res=$d['Name'];
											$hivp2fr=$d['result'];
										}

										//panel3
										elseif($d['panelid']==3 && $d['testcatid']==1){
											$hivp3scr_res=$d['Name'];
											$hivp3screening=$d['result'];
										}
										elseif($d['panelid']==3 && $d['testcatid']==2){
											$hivp3con_res=$d['Name'];
											$hivp3confirm=$d['result'];
										}
										elseif($d['panelid']==3 && $d['testcatid']==3){
											$hivp3tb_res=$d['Name'];
											$hivp3tie=$d['result'];
										}	
										elseif($d['panelid']==3 && $d['testcatid']==4){
											$hivp3fr_res=$d['Name'];
											$hivp3fr=$d['result'];
										}

										//panel4
										elseif($d['panelid']==4 && $d['testcatid']==1){
											$hivp4scr_res=$d['Name'];
											$hivp4screening=$d['result'];
										}
										elseif($d['panelid']==4 && $d['testcatid']==2){
											$hivp4con_res=$d['Name'];
											$hivp4confirm=$d['result'];
										}
										elseif($d['panelid']==4 && $d['testcatid']==3){
											$hivp4tb_res=$d['Name'];
											$hivp4tie=$d['result'];
										}
										elseif($d['panelid']==4 && $d['testcatid']==4){
											$hivp4fr_res=$d['Name'];
											$hivp4fr=$d['result'];
										}
									endforeach;

									
								}
				  ?>
<!----------------------------------------------- -->
			<div id="divtoprint" style="width:80%; margin:auto;">
			<div class="row" style="width:90%;">
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
						<div class="prof_heading">hiv proficiency assessment scheme</div>
						<div class="dts_heading">dts result report</div>
					</div>
					<div style="width:12%;display:inline-block;float:right;position:relative; top:30px;">
					<div class="mocd">moh/cdc</div>
					<div class="tcpatch">TESTER CODE</div>
					<div class="tclbl"><?php echo $sample['testercode'];?></div>
				</div>
			</div>
		</div>
		<div class="row" style="width:80%; margin: auto;">
			<table border="0" class="data-table" width="90%">
				<tr class="even">
					<th colspan="2"> SAMPLE REVIEW REPORT</th>
				</tr>
				<tr class="even">
					<td>
						<table width="100%">
							<th colspan="4"><strong> TESTING SITE DETAILS </strong></th>
							<tr class="even">
								<td><strong> Testing Site</strong></td>
								<td colspan="3"><?php echo $sample['Sitename'];?></td>
							</tr>
							<tr class="even">
								<td colspan="1"><strong>Department</strong></td>
								<td colspan="1"><?php echo $sample['departmentname'];?></td>
							</tr>
							<tr class="even">
							  	<td><strong>Ownership</strong></td>
				            	<td colspan="3">
									<?php  echo $sample['owner'];?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php echo  $sample['location']; ?>
								</td>
							</tr>
							<tr class="even">
			            		<td><strong>Sub county</strong></td>
			            		<td colspan="3">
									<?php  echo $sample['division'];?>
								</td>
			  				</tr>

					          <tr class="even">
					            <td ><strong>District</strong></td>
					            <td colspan="3">
										<?php  echo $sample['DistrictName'];?>
								</td>
						  	</tr>
						  	<tr class="even">
					            <td><strong> Region</strong></td>
					            <td colspan="3">
									<?php  echo $sample['region']; ?>
								</td>
							  </tr>
						</table>
					</td>
					<td>
						<table width="100%">
							<tr class="even">
								<th colspan="2">
									<strong>
										SAMPLE SPECIFICATIONS
									</strong>
								</th>
							</tr>
							<tr class="even">
						        <td><strong> Sample ID</strong></td>
						        <td>
									UVRI-HIV QA <?php echo $sample['cycle']; ?>
								</td>
							</tr>
							<tr class="even">
						        <td><b> Date of Dispatch</b></td>
						        <td>
									<?php  echo $sample['dod'];?>
								</td>
							</tr>
							<tr class="even">
						            <td><b> Date Received</b></td>
						            <td>
											<?php  echo $sample['dsr'];?>
									</td>
							</tr>
							<tr class="even">
						        <td><b> Date Reconstituted</b></td>
						        <td>
									<?php  echo $sample['dtsr'];?>
								</td>
							</tr>
							<tr class="even">
						        <td><b> Date Sample Tested</b></td>
						        <td>
									<?php  echo $sample['dtst'];?>
								</td>
							</tr>
							<tr class="even">
						        <td><b> Date Results Recieved at UVRI</b></td>
						        <td>
									<?php  echo $sample['DateRxAtUVRI'];?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="even">
					<th colspan="2">Contact Details</th>
				</tr>
				<tr>
					<td colspan="2">
						<table border="0" width="100%">
							<tr class="even">
								<th style="text-align: left;" width="25%">Site Supervisor</th>
								<td style="text-align: left; padding-left: 2%;" width="25%"><?php echo $sample['supervisorname'];?></td>
								<th width="25%">Tester Name</th>
								<td width="25%"><?php echo $testerInfor['TesterName'];?></td>
							</tr>

							<tr class="even">
								<th style="text-align: left;">Telephone</th>
								<td style="text-align: left; padding-left: 2%;"><?php echo $sample['tel'];?></td>
								<th>Contact</th>
								<td><?php echo $testerInfor['contacts'];?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="even">
		            <th colspan="2">KIT DETAILS</th>
		        </tr> 
		    
				<tr>
					<td colspan="2">
						<div class="row">
							<div style=" width: 100%; padding-left: 1%;">
								<table border="0" class="data-table" width="99%">
									<tr class="even">
										<th  rowspan="2"></th><th colspan="3">HIV</th><th></th>
										<th>Syphilis</th><th>Reasons for not Testing</th>
									</tr>
									<tr>
										
										<th> Test 1 (Screening)</th>
										<th> Test 2 (Confirmatory)</th>
										<th> Test 3 (Tie Breaker)</th>
										
										<th></th>
										<th>Test 1 (Screening)</th>
										<th> </th>
									</tr>
									<tr>
										<th>Testname</th>
										<td><?php echo $hivscreening;?></td>
										<td><?php echo $hivconf;?></td>
										<td><?php echo $hivtieb;?></td>
										<td></td>
										<td><?php echo $syphkit;?></td>
										<td></td>
									</tr>
									<tr>
										<th>Lot#</th>
										<td><?php echo $sclot;?></td>
										<td><?php echo $conflot;?></td>
										<td><?php echo $tblot;?></td>
										<td></td>
										<td><?php echo $syphlot;?></td>
										<td></td>
									</tr>
									<tr>
										<th>Expiry Date</th>
										<td><?php echo $scexp;?></td>
										<td><?php echo $conexp;?></td>
										<td><?php echo $tbexp;?></td>
										<td></td>
										<td><?php echo $syphexpdt;?></td>
										<td></td>
									</tr>
									<tr><td></td><td colspan="6"><div id="hide_appender" style="visibility:hidden;"><input type="checkbox" name="export_kitinfo" value="On" id="export_kitinfo">&nbsp;&nbsp;Append Syphilis Missing Kit Info</div></td></tr>
								</table> 
							</div>
							
						</div>
					</td>
				</tr>
				<tr class="even">
		            <th colspan="2"> RESULTS</th>
		        </tr>
		        <tr class="even">
		            <td colspan="2">   
		            	<table  border="0" class="data-table" width="100%">
		            		<tr><th rowspan="2">Sample ID
		            		</th><th colspan="8">HIV</th><th></th><th colspan="2">Syphilis</th></tr>
		            		<tr>
								
								<th  colspan="1"><small>Screening</small></th>
								<th  colspan="1"><small>Expected</small></th>
								<th  colspan="1"><small>Confirmatory</small></th>
								<th  colspan="1"><small>Expected</small></th>
								<th  colspan="1"><small>Tie Breaker</small></th>
								<th  colspan="1"><small>Expected</small></th>
								<th  colspan="1"><small>Final Result</small></th>
								<th  colspan="1"><small>Expected</small></th>
							
								
								<th></th>
								<th>Final Results</th>
								<th>Expected</th>	

						  	</tr>
						  	<tr>
								<td>UVRI HIV/SYPH</td>
								<td colspan="1"><?php echo $hivp1scr_res;?> </td>
								<td colspan="1"><?php echo $p1screxp_res;?> </td>
								<td colspan="1"><?php echo $hivp1con_res;?></td>
								<td colspan="1"><?php echo $p1conexp_res;?> </td>
								<td colspan="1"><?php echo $hivp1tb_res;?></td>
								<td colspan="1"><?php echo $p1tbexp_res;?> </td>
								<td colspan="1"><?php echo $hivp1fr_res;?></td>
								<td colspan="1"><?php echo $p1frexp_res;?> </td>
							
								
								<td></td>
								<td><?php echo $spyp1res;?></td>	
								<td><?php echo $p1syphfrexp_res;?></td>
						  	</tr>
						  	<tr>
								<td> UVRI HIV/SYPH</td>
								<td colspan="1"><?php echo $hivp2scr_res;?> </td>
								<td colspan="1"><?php echo $p2screxp_res;?> </td>
								<td colspan="1"><?php echo $hivp2con_res;?></td>
								<td colspan="1"><?php echo $p2conexp_res;?> </td>
								<td colspan="1"><?php echo $hivp2tb_res;?></td>
								<td colspan="1"><?php echo $p2tbexp_res;?> </td>
								<td colspan="1"><?php echo $hivp2fr_res;?></td>
								<td colspan="1"><?php echo $p2frexp_res;?> </td>
							
								
								<td></td>
								<td><?php echo $spyp2res;?></td>
								<td><?php echo $p2syphfrexp_res;?></td>	
						  	</tr>
						  	<tr>
								<td>UVRI HIV/SYPH</td>
								<?php
											if($cycle==36){
												if($hivp3scr_res!='' && $hivp3scr_res=='NR')
					  						{ 
					  								$p3screxp_res=$hivp3scr_res; $p3conexp_res=$hivp3con_res;
					  								if($hivp3fr_res=='NEG'){
					  									$p3frexp_res=$hivp3fr_res;
					  									$p3mark=1;
					  									$score=$score+25;
					  								}
					  						}

					  						if($hivp3scr_res!='' && $hivp3scr_res=='R' ){ 
					  							$p3tbexp_res='R';
					  							if($p3conexp_res=='R')
					  								{
					  									if($hivp3con_res!='R'){
					  										if($hivp3con_res=='NR'){
					  											if($hivp3tb_res=='R'){
						  											if($hivp3fr_res=='POS' || $hivp3fr_res=='INC'){
						  												$p3tbexp_res=$hivp3tb_res; 
									  									$p3frexp_res='POS'; 
									  									$p3mark=1;
									  									//$score=$score+25;
						  											}
						  										}
					  										}
					  										elseif($hivp3con_res=='INV'){
					  											$p3mark=0;
					  										}
					  									}
					  									// else {
					  									// 	if($hivp3con_res=='NR')
					  									// 	{
					  									// 		if($hivp3tb_res=='R'){
															// 			$p3mark=1;
					  									// 		}
							  									 
							  									
					  									// 	}
					  									// }
					  								}

					  						}
					  						if($score==100){$status='PASS';} //updating status for cycle 36
											}
								 ?>
								<td colspan="1"><?php echo $hivp3scr_res;?> </td>
								<td colspan="1"><?php echo $p3screxp_res;?> </td>
								<td colspan="1"><?php echo $hivp3con_res;?></td>
								<td colspan="1"><?php echo $p3conexp_res;?> </td>
								<td colspan="1"><?php echo $hivp3tb_res;?></td>
								<td colspan="1"><?php if($hivp3tb_res!=''){echo $p3tbexp_res;}?> </td>
								<td colspan="1"><?php echo $hivp3fr_res;?></td>
								<td colspan="1"><?php echo $p3frexp_res;?> </td>
							
								
								<td></td>
								<td><?php echo $spyp3res;?></td>	
								<td><?php echo $p3syphfrexp_res;?></td>
						  	</tr>
						  	<tr>
								<td>UVRI HIV/SYPH</td>
								<td colspan="1"><?php echo $hivp4scr_res;?> </td>
								<td colspan="1"><?php echo $p4screxp_res;?> </td>
								<td colspan="1"><?php echo $hivp4con_res;?></td>
								<td colspan="1"><?php echo $p4conexp_res;?> </td>
								<td colspan="1"><?php echo $hivp4tb_res;?></td>
								<td colspan="1"><?php echo $p4tbexp_res;?> </td>
								<td colspan="1"><?php echo $hivp4fr_res;?></td>
								<td colspan="1"><?php echo $p4frexp_res;?> </td>
							
								
								<td></td>
								<td><?php echo $spyp4res;?></td>	
								<td><?php echo $p4syphfrexp_res;?></td>
						  	</tr>
		            	</table>
		            </td>				
				</tr>
				<tr>
					<td colspan="2">
						<form  method="post" action="<?php echo base_url('approvedts');?>">
						<table  width="100%">
							<tr>
								<th width="50%">HIV</th>
								<th >SYPHILIS</th>
							</tr>
							<tr>
								<td>
									<table width="100%">
										<tr>
											<th>Score</th><td> <?php echo $score;?></td><th>Over All Status</th><td> <?php echo $status;?></td>
										</tr>
										<tr>
											<th width="60%">
												Please Specify Extra Comments/Corrective HIV
											</th>
											<td colspan="3">
												<select class="form-control" id="hivcomments" name="hivcomments[]" multiple >
													<?php
													foreach($commentcategory as $cc):
														echo '<option value="'.$cc['cid'].'" >'.$cc['description'].'</option>';
													endforeach; 
													?>			
												</select>
											</td>
										</tr>
									</table>
								</td>
								<td>
									<table width="100%">
										<tr>
											<th>Score</th><td> <?php echo $syphscore;?></td><th>Over All Status</th><td> <?php echo $syphstatus;?></td>
										</tr>
										<tr>
											<th width="60%">Please Specify Extra Comments/Corrective SYPHILIS</th>
											<td colspan="3">
												<select class="form-control" id="syphcomments" name="syphcomments[]]" multiple>
													<?php
													foreach($commentcategory as $cc):
														echo '<option value="'.$cc['cid'].'" >'.$cc['description'].'</option>';
													endforeach; 
													?>						
												</select>
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<input type="hidden" name="hivscore" value="<?php echo $score;?>">
						<input type="hidden" name="hivstatus" value="<?php echo $status;?>">
						<input type="hidden" name="append_kit_info" id="kitinfo">
						<input type="hidden" name="sypscore" value="<?php echo $syphscore;?>">
						<input type="hidden" name="sypstatus" value="<?php echo $syphstatus;?>">
						<input type="hidden" 	name="trans_kitname" 	value="<?php echo $pickup_kitname;?>"> 
						<input type="hidden" 	name="trans_lot" 			value="<?php echo $pickup_lotno;?>"> 
						<input type="date" 	name="trans_expdate" 	value="<?php echo $pickup_expdt;?>" style="visibility: hidden;">
						
						<input type="hidden" name="sampleid" value="<?php echo $sample['sampleid'] ;?>">
						<input type="submit" name="approve" class="btn btn-primary btn-sm" value="Approve">
					</form>
					</td>
				</tr>
			</table>
			
			<?php
			
			?>

			
				

				
		</div>
		<pre>
		<?php //print_r($dtsresult);

			echo '<br>';

			//print_r($hivexpectedresult);

			
		?>
	</pre>


<!---------------------------------------------------->

        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--  <script type="text/javascript" src="<?php //echo base_url('/assets/js/jquery-1.12.4.js');?>"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script> -->

<script type="text/javascript">
		var base_url ="<?php echo base_url();?>";
		var has_syph ="<?php echo $syphrecord;?>";

  $(document).ready(function() {      
  	//alert(has_syph);
  	if(has_syph>0){
  		$('#hide_appender').css('visibility','visible');
  	}
  	else {
  		$('#hide_appender').css('visibility','hidden');
  	}
  $('#export_kitinfo').click(function() {
  if ($(this).is(':checked')) {
    $('#kitinfo').val($(this).val());
  }
  else{
  	$('#kitinfo').val('off');
  }
});
	
			$('#hivcomments').multiselect({		
				nonSelectedText: 'Select Reason'				
			});

			$('#syphcomments').multiselect({		
				nonSelectedText: 'Select Reason'				
			});
	});



</script>


<!-- <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->