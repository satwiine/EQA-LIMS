<?php
ob_start();
require('fpdf.php');
	include('../config/config.php');
	 include('dev/config/functions/dts.php');
	 $g=new dts();
	 $noExpectedRes=0;
	// $_REQUEST['sample']=252;

	 $rp=$g->viewSampleDetails($_REQUEST['sample']);
	 $othercomments=$g->getOtherCommentsBySample($_REQUEST['sample']);
	 $td=$g->getTestKitInfoBySample($_REQUEST['sample']);
	 $sgrade=$g->getSampleGradeById($_REQUEST['sample']);
	 $approval=$g->approverBySample($_REQUEST['sample']);
	 $apddt=$g->cleanDate($approval[0]['approvaldate']);
	 $sample=$rp['qtr'].''.$rp['testercode'];

	 if(count($othercomments)>0){
			for ($i=0; $i < count($othercomments); $i++) { 
				if($othercomments[$i]['commentid']==3 or $othercomments[$i]['commentid']==2){
					$St='Un-Graded';
					$noExpectedRes=1;
				}
			}
		} 

	 if(count($othercomments>0)){
	 	if($approval[0]['comments']!=''){
	 		$cm[0]=$approval[0]['comments'];
	 		for ($i=1; $i <= count($othercomments); $i++) { 
			//$cm[$i]=$othercomments[$i]['description']; // this comment was rejected by Lab Team

			}
	 	}
	 	else{
	 		for ($i=0; $i < count($othercomments); $i++) { 
			$cm[$i]=$othercomments[$i]['description'];
			}
	 	}
	}
	else{
		if($approval[0]['comments']!=''){
	 		$cm[0]=$approval[0]['comments'];
	 	}
	} 
	 $batchno="UVRI-HIV QA ".$rp['qtr'];
	 
	 //////////////////////////testkit info process
	 $ctd=count($td);
			$t1="";$t2="";$t3="";
			$t1lot="";$t2lot="";$t3lot="";
			$t1edate="";$t3edate="";$t3edate="";
			if($ctd>0){
				for ($i=0; $i < $ctd; $i++) { 
					$sc=$td[$i]['categoryname'];
					if($sc=='Screening'){
						$t1=$td[$i]['name'];
						$t1lot=$td[$i]['lotNumber'];
						$t1edate=$g->cleanDate($td[$i]['expirydate']);
					}
					elseif($sc=='Confirmatory'){
						$t2=$td[$i]['name'];
						$t2lot=$td[$i]['lotNumber'];
						$t2edate=$g->cleanDate($td[$i]['expirydate']);
					}
					elseif($sc=='Tie Breaker'){
						$t3=$td[$i]['name'];
						$t3lot=$td[$i]['lotNumber'];
						$t3edate=$g->cleanDate($td[$i]['expirydate']);
					}
				}
			}
	 ////////////////////////////end
	 ////////////////////////////////////////////////////process results
			$sgrade=$g->getSampleGradeById($_REQUEST['sample']);
			$out=$g->reportResults($_REQUEST['sample']);							
			 $cres=count($out);
			 $St='PASS';
			 $p=0;
			 $tp=6;
			// print_r($out);
			 //echo $out[0][0];
			// exit;
			for ($i=0; $i < $cres; $i++) { 
					if($out[$i][8]=='POS'){
						$style="background:#B0C4DE;";
					}
					else
					{
						$style="background:#FAFAFA;";
					}
					if ($out[$i][2] == 'R' )
					{
						$sstyle="background:#B0C4DE;";
					}
					else
					{
						$sstyle="background:#FAFAFA;";
					}
					if ($out[$i][4] == 'R' )
					{
						$cstyle="background:#B0C4DE;";
					}
					else
					{
						$cstyle="background:#FAFAFA;";
					}
					if ($$out[$i][6] == 'R' )
					{
						$tbstyle="background:#B0C4DE;";
					}
					else
					{
						$tbstyle="background:#FAFAFA;";
					}
			
			}
	////////////////////////////////////////////////////end 
	 class PDF extends FPDF
	{
		
		function Header(){
			//logo
			$this->Image('leftLogo.png',17,10,45);
			$this->Image('centerLogo.png',65,20,65);
			$this->Image('rightLogo.png',150,15,35);
			$this->SetFont('Arial','B',15);
			//$this->Cell(20);
			//$this->Cell(140,44,$rp['testercode'],0,0,'R');
			$this->Ln(20);
		}

		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont('Arial','I',8);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}

	}

	$p=new PDF();


	$p->AliasNbPages();
	$p->AddPage();
	$p->SetFont('Arial','',10);
	$p->SetXY(160,27);
	$p->Cell(100,10,$rp['testercode'],0,0,'L');
	$p->SetFont('Arial','',6);
	$y=45;
	$p->Image('resPart1.png',17,40,170);
	$p->SetXY(36,$y+9);
	$p->Cell(100,10,$rp['sitename'],0,0,'L');	///positioning the site name
	$p->SetXY(156,$y+9);
	$p->Cell(100,10,$batchno,0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(36,$y+9);
	$p->Cell(100,10,$rp['department'],0,0,'L');	///positioning the site name
	$p->SetXY(70,$y+9);
	$p->Cell(70,10,$rp['hub'],0,0,'L');  //positioning the sample batch
	$p->SetXY(156,$y+9);
	$p->Cell(100,10,$rp['dispatchdate'],0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(36,$y+9);
	$p->Cell(100,10,$rp['owner'],0,0,'L');	///positioning the site name
	$p->SetXY(156,$y+9);
	$p->Cell(100,10,$rp['receiptdate'],0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(36,$y+11);
	$p->Cell(100,10,$rp['location'],0,0,'L');	///positioning the site name
	$p->SetXY(156,$y+9);
	$p->Cell(100,10,$rp['recosdate'],0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(36,$y+11);
	$p->Cell(100,10,$rp['district'],0,0,'L');	///positioning the site name
	$p->SetXY(156,$y+8);
	$p->Cell(100,10, $rp['testdate'],0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(36,$y+11);
	$p->Cell(100,10,$rp['region'],0,0,'L');	///positioning the site name
	$p->SetXY(156,$y+8);
	$p->Cell(100,10, $rp['UVRIrxDate'],0,0,'L');  //positioning the sample batch
	$y+=20;
	////////////12///////////////////contact 
	$p->SetXY(55,$y+9);
	$p->Cell(100,10,$rp['runsup'],0,0,'L');	///positioning the site name
	$p->SetXY(140,$y+9);
	$p->Cell(100,10, $rp['tester'],0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->Cell(100,10,$rp['tel'],0,0,'L');	///positioning the site name
	$p->SetXY(140,$y+9);
	$p->Cell(100,10, $rp['tcontact'],0,0,'L');  //positioning the sample batch
	$y+=18;

	$p->SetXY(45,$y+9);
	$p->Cell(100,10,$t1,0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->Cell(100,10, $t2,0,0,'L');  //positioning the sample batch
	$p->SetXY(156,$y+9);
	$p->Cell(100,10, $t3,0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(45,$y+9);
	$p->Cell(100,10,$t1lot,0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->Cell(100,10, $t2lot,0,0,'L');  //positioning the sample batch
	$p->SetXY(156,$y+9);
	$p->Cell(100,10, $t3lot,0,0,'L');  //positioning the sample batch
	$y+=6;
	$p->SetXY(45,$y+9);
	$p->Cell(100,10,$t1edate,0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);

	$p->Cell(100,10, $t2edate,0,0,'L');  //positioning the sample batch
	$p->SetXY(156,$y+9);
	$p->Cell(100,10, $t3edate,0,0,'L');  //positioning the sample batch

	$p->Image('resPart2.png',17,156,170);
	$y+=29;
	$p->SetXY(49,$y+9);
	$p->Cell(100,10,$out[0][1],0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->SetXY(63,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10,$out[0][2],0,0,'L');	///positioning expected screening
	$p->SetXY(77,$y+9);
	}
	$p->Cell(100,10, $out[0][3],0,0,'L');  //positioning Confirmatory
	$p->SetXY(91,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10, $out[0][4],0,0,'L');  //positioning expected confirmatory
	$p->SetXY(105,$y+9);
	}
	$p->Cell(100,10, $out[0][5],0,0,'L');  //positioning tie breaker
	$p->SetXY(119,$y+9);
	$p->Cell(100,10, $out[0][6],0,0,'L');  //positioning tie breaker
	$p->SetXY(133,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10, $out[0][7],0,0,'L');  //positioning tie Final Result
	$p->SetXY(147,$y+9);
	}
	$p->Cell(100,10, $out[0][8],0,0,'L');  //positioning tie Final Result
	$p->SetXY(161,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10, $out[0][9],0,0,'L');  //positioning tie Final Result
	}
	$y+=6;
	$p->SetXY(49,$y+9);
	$p->Cell(100,10,$out[1][1],0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->SetXY(63,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10,$out[1][2],0,0,'L');	///positioning expected screening
}
	$p->SetXY(77,$y+9);
	$p->Cell(100,10, $out[1][3],0,0,'L');  //positioning Confirmatory
	$p->SetXY(91,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10, $out[1][4],0,0,'L');  //positioning expected confirmatory
}
	$p->SetXY(105,$y+9);
	$p->Cell(100,10, $out[1][5],0,0,'L');  //positioning tie breaker
	$p->SetXY(119,$y+9);
	$p->Cell(100,10, $out[1][6],0,0,'L');  //positioning tie breaker
	$p->SetXY(133,$y+9);
	$p->Cell(100,10, $out[1][7],0,0,'L');  //positioning tie Final Result
	$p->SetXY(147,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10, $out[1][8],0,0,'L');  //positioning tie Final Result

	$p->SetXY(161,$y+9);
	$p->Cell(100,10, $out[1][9],0,0,'L');  //positioning tie Final Result
	}
	$y+=6;
	$p->SetXY(49,$y+9);
	$p->Cell(100,10,$out[2][1],0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->SetXY(63,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10,$out[2][2],0,0,'L');	///positioning expected screening
}
	$p->SetXY(77,$y+9);
	
	$p->Cell(100,10, $out[2][3],0,0,'L');  //positioning onfirmatory
	$p->SetXY(91,$y+9);
if($noExpectedRes==0){
	$p->Cell(100,10, $out[2][4],0,0,'L');  //positioning expected confirmatory
}
	$p->SetXY(105,$y+9);
	$p->Cell(100,10, $out[2][5],0,0,'L');  //positioning tie breaker
	$p->SetXY(119,$y+9);
if($noExpectedRes==0){
	$p->Cell(100,10, $out[2][6],0,0,'L');  //positioning tie breaker
}
	$p->SetXY(133,$y+9);
	
	$p->Cell(100,10, $out[2][7],0,0,'L');  //positioning tie Final Result

	$p->SetXY(147,$y+9);
	
	$p->Cell(100,10, $out[2][8],0,0,'L');  //positioning tie Final Result
	$p->SetXY(161,$y+9);
	if($noExpectedRes==0){
		$p->Cell(100,10, $out[2][9],0,0,'L');  //positioning tie Final Result
	}
	$y+=5;
	$p->SetXY(49,$y+9);
	$p->Cell(100,10,$out[3][1],0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->SetXY(63,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10,$out[3][2],0,0,'L');	///positioning expected screening
}
	$p->SetXY(77,$y+9);
	$p->Cell(100,10, $out[3][3],0,0,'L');  //positioning onfirmatory
	$p->SetXY(91,$y+9);
	$p->Cell(100,10, $out[3][4],0,0,'L');  //positioning expected confirmatory
	$p->SetXY(105,$y+9);
	$p->Cell(100,10, $out[3][5],0,0,'L');  //positioning tie breaker
	$p->SetXY(119,$y+9);
	$p->Cell(100,10, $out[3][6],0,0,'L');  //positioning tie breaker
	$p->SetXY(133,$y+9);
	$p->Cell(100,10, $out[3][7],0,0,'L');  //positioning tie Final Result
	$p->SetXY(147,$y+9);
	$p->Cell(100,10, $out[3][8],0,0,'L');  //positioning tie Final Result
	$p->SetXY(161,$y+9);
	$p->Cell(100,10, $out[3][9],0,0,'L');  //positioning tie Final Result

	$y+=5;
	$p->SetXY(49,$y+9);
	$p->Cell(100,10,$out[4][1],0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->SetXY(63,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10,$out[4][2],0,0,'L');	///positioning expected screening
}
	$p->SetXY(77,$y+9);
	$p->Cell(100,10, $out[4][3],0,0,'L');  //positioning Confirmatory
	$p->SetXY(91,$y+9);
	$p->Cell(100,10, $out[4][4],0,0,'L');  //positioning expected confirmatory
	$p->SetXY(105,$y+9);
	$p->Cell(100,10, $out[4][5],0,0,'L');  //positioning tie breaker
	$p->SetXY(119,$y+9);
	$p->Cell(100,10, $out[4][6],0,0,'L');  //positioning tie breaker
	$p->SetXY(133,$y+9);
	$p->Cell(100,10, $out[4][7],0,0,'L');  //positioning tie Final Result
	$p->SetXY(147,$y+9);
	$p->Cell(100,10, $out[4][8],0,0,'L');  //positioning tie Final Result
	$p->SetXY(161,$y+9);
	$p->Cell(100,10, $out[4][9],0,0,'L');  //positioning tie Final Result

	$y+=5;
	$p->SetXY(49,$y+9);
	$p->Cell(100,10,$out[5][1],0,0,'L');	///positioning the site name
	$p->SetXY(102,$y+9);
	$p->SetXY(63,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10,$out[5][2],0,0,'L');	///positioning expected screening
	$p->SetXY(77,$y+9);
}
	$p->Cell(100,10, $out[5][3],0,0,'L');  //positioning Confirmatory
	$p->SetXY(91,$y+9);
	$p->Cell(100,10, $out[5][4],0,0,'L');  //positioning expected confirmatory
	$p->SetXY(105,$y+9);
	$p->Cell(100,10, $out[5][5],0,0,'L');  //positioning tie breaker
	$p->SetXY(119,$y+9);
	$p->Cell(100,10, $out[5][6],0,0,'L');  //positioning tie breaker
	$p->SetXY(133,$y+9);
	$p->Cell(100,10, $out[5][7],0,0,'L');  //positioning tie Final Result
	$p->SetXY(147,$y+9);
	if($noExpectedRes==0){
	$p->Cell(100,10, $out[5][8],0,0,'L');  //positioning tie Final Result
	
	$p->SetXY(161,$y+9);
	$p->Cell(100,10, $out[5][9],0,0,'L');  //positioning tie Final Result
}
	$y+=8;
	$p->SetXY(40,$y+9);
	$p->Cell(100,10,$sgrade['score'],0,0,'C');
	$p->SetXY(145,$y+9);
	$p->Cell(30,10, $sgrade['status'],0,0,'C');
	$y+=12;
	$p->SetXY(20,$y+9);
	$p->Cell(70,10,$cm[0],0,0,'L');
	$p->SetXY(80,$y+9);
	$p->Cell(70,10,$cm[3],0,0,'L');
	$p->SetXY(140,$y+9);
	$p->Cell(70,10,$cm[6],0,0,'L');

	$y+=4;
	$p->SetXY(20,$y+9);
	$p->Cell(70,10,$cm[1],0,0,'L');
	$p->SetXY(80,$y+9);
	$p->Cell(70,10,$cm[4],0,0,'L');
	$p->SetXY(140,$y+9);
	$p->Cell(70,10,$cm[7],0,0,'L');

	$y+=4;
	$p->SetXY(20,$y+9);
	$p->Cell(70,10,$cm[2],0,0,'L');
	$p->SetXY(80,$y+9);
	$p->Cell(70,10,$cm[5],0,0,'L');
	$p->SetXY(140,$y+9);
	$p->Cell(70,10,$cm[8],0,0,'L');

	$y+=14;
	$p->SetXY(30,$y+8);
	$p->Cell(50,18,$approval[0]['names'],0,0,'L');
	//$p->SetXY(80,$y+5);
	$p->Image('images/Signatures/'.$approval[0]['signature'],94,240,15);
	/*TODO:   Get final Results from t
	he samplegrading, and comments as well as tester information*/
	$p->SetXY(150,$y+8);
	$p->Cell(50,18,$apddt,0,0,'L');
	$p->Output();
	//$rp['']
?>
