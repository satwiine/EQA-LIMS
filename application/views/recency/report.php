<?php
$rp=$sampleInfo;

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
	function PrintDiv(){
		var divtoprint=document.getElementById('divtoprint');
		var popupwin=window.open('','','width=100,height=100');
		popupwin.document.open();
		popupwin.document.write('<html><body onload="window.print()">'+divtoprint.innerHTML+'</html>');
		window.open('location', '_self', '');
		window.close();

	}
</script>
<link rel="stylesheet" type="text/css" href="css/style/style.css" media="screen" />
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
</head>


	<!--input type="button" name="simon" value="print" onclick="PrintDiv();"-->
	<body onLoad="JavaScript:window.print();">
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
			<div class="sero_heading">national hiv recency qa/qc</div>
			<div class="prof_heading">hiv-1 recency proficiency assessment scheme</div>
			<div class="dts_heading"></div>
		</div>
		<div style="width:12%;display:inline-block;float:right;position:relative; top:30px;">
			<div class="mocd">moh/cdc</div>
			<div class="tcpatch">TESTER CODE</div>
			<div class="tclbl"><?php if( isset($rp[0]['testercode']))echo ($rp[0]['testercode']);?></div>
		</div>
	</div>

		  <table  border="0" class="data-table" WIDTH="890PX" >		 
            
         <tr class="even">
            <th colspan="2">FEED BACK REPORT</th>
          </tr>
		  <TR>
		  <TD> <TABLE width="450px">  
		   <th colspan="4"> <b>TESTING SITE DETAILS<b></th>
		  <tr class ="even">
            <td ><b> Testing Site</b></td>
            <td colspan="3">
					<?php if(isset($rp[0]['sitename']))
					 echo $rp[0]['sitename'];?>  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php if(isset($rp[0]['hub'])) echo '<br><span style="float:right;"><strong>', $rp[0]['hub'],'</strong></span>'; 

					 ?>
	</td>
            </tr>
			 <tr class ="even">
            <td colspan="1"><b> Department</b></td>
            <td colspan="1">
			<?php if(isset($rp[0]['department'])) echo $rp[0]['department'];?>   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php  if(isset($rp[0]['deliverymode'])) echo  $rp[0]['deliverymode'];  ?>
	</td>
	 
            </tr>
			<tr class="even">
			  <td ><b> Ownership</b></td>
            <td colspan="3">
					<?php if(isset($rp[0]['owner'])) echo $rp[0]['owner'];?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php if(isset($rp[0]['location'])) echo  $rp[0]['location']; ?>
	</td>
			</tr>
			 <tr class="even">
            <td > <b>Sub county</b></td>
            <td colspan="3">
					<?php if(isset($rp[0]['division'])) echo $rp[0]['division'];?>
	</td>
	  </tr>
          <tr class="even">
            <td > <b>District</b></td>
            <td colspan="3">
					<?php if(isset($rp[0]['district'])) echo $rp[0]['district'];?>
	</td>
	  </tr>
	 <tr class="even">
            <td ><b> Region</b></td>
            <td colspan="3">
					<?php if(isset($rp[0]['region'])) echo $rp[0]['region']; ?>
	</td>
		  </tr> 
		 
		  </TABLE></TD>
		  <TD> <TABLE width="450px">  <tr class ="even">
            <th colspan="2"> <b>SAMPLE SPECIFICATIONS<b></th>
                </tr>
          <tr class="even">
            <td ><b> Sample ID<b></td>
            <td >
					UVRI-HIV QA <?php if(isset($rp[0]['cycleid'])) echo $rp[0]['cycleid']; ?>
	</td>
	  </tr>
	   
	 <tr class="even">
            <td ><b> Date of Dispatch<b></td>
            <td >
					<?php if(isset($rp[0]['dod'])) echo $rp[0]['dod'];?>
	</td>
	</tr>
	<tr class="even">
            <td ><b> Date Received<b></td>
            <td >
					<?php if(isset($rp[0]['dsr'])) echo $rp[0]['dsr'];?>
	</td>
	</tr>
	 <tr class="even">
            <td ><b> Date Reconstituted<b></td>
            <td >
					<?php if(isset($rp[0]['recondate'])) echo $rp[0]['recondate'];?>
	</td>
		  </tr> 
		   <tr class="even">
            <td ><b> Date Sample Tested<b></td>
            <td >
					<?php if(isset($rp[0]['testingdate'])) echo $rp[0]['testingdate'];?>
	</td>
		  </tr> 
		 
				   <tr class="even">
            <td ><b> Date Results Received at UVRI<b></td>
            <td colspan="">
					<?php if(isset($rp[0]['daterxatuvri'])) echo $rp[0]['daterxatuvri'];?>
	</td>
		  </tr> </TABLE> </TD>
		  </TR>
         
		      <tr class="even">
            <th colspan="2">CONTACT DETAILS</th>
          </tr> 
    <TR>
		  <TD colspan="2"> <table  border="0" class="data-table" WIDTH="890PX">		 
		  	 
			<tr class ="even">
            <td colspan="1"><b> Site Supervisor</b></td>
            <td colspan="1"><?php if(isset($rp[0]['supervisorname'])) echo $rp[0]['supervisorname'];?>	</td>
	        <td ><b> Testing Personnel</b></td>
            <td colspan="3"><?php if(isset($rp[0]['testername'])) echo $rp[0]['testername'];?>	</td>
            </tr>
			<tr class ="even">
            <td colspan="1"><b> Telephone</b></td>
            <td colspan="1"><?php if(isset($rp[0]['tel'])) echo $rp[0]['tel'];?>	</td>
	        <td ><b> Telephone</b></td>
            <td colspan="3"><?php if(isset($rp[0]['contact'])) echo $rp[0]['contact']; ?>	</td>
            </tr>
		
		  </TABLE></TD>
		  </TR>
             
		   <tr class="even">
            <th colspan="2">KIT DETAILS</th>
          </tr> 
    <TR>
		  <TD colspan="2">
		  	<table class="table table-condensed table-bordered" width="100%">
		  		<tr><th>Test Name</th><th>Kit Lot Number</th><th>Expiry Date</th><th>If you did not test, give reasons</th></tr>
		  		<tr><td><?php if(isset($rp[0]['testkit'])) echo $rp[0]['testkit'];?></td><td><?php if(isset($rp[0]['lotnum'])) echo $rp[0]['lotnum'];?></td><td><?php if(isset($rp[0]['expirydate'])) echo $rp[0]['expirydate'];?></td><td><?php //echo rp[''];?></td></tr>
		  	</table>
		  </TD>
		  </TR>
		   <tr class="even">
            <th colspan="2"> RESULTS</th>
          </tr>
          <tr class="even">
            <td colspan="3">   

            <table class="table table-condensed table-bordered" width="100%" style="font-size: 12px;">
		<!--tr style="background-color: #ccc;">
			<th rowspan="2"> Sample </th>
			<th colspan="3" style="text-align: center;"><strong>(Visual Results Mark &#10004; if line present)</strong></th>
			<th colspan="2" width="30%">Recency Interpretation <span style="font-weight:lighter; font-size:12px; "><i>[All 3 lines = LT,C & V lines =Recent, only C line =Neg, No C line or C & LT lines with no V line at all=Invalid]</i></span></th>
			<th rowspan="2">Status</th>
		</tr>
		<tr style="background-color: #ccc;"><th>Control(C)Line</th><th>Verification(V)Line</th><th>Long Time(LT)Line</th><th>Your Result</th><th>Expected Result</th></tr>
		<tr>
			<th>QC - Long Term</th>
			<td style="text-align: center;">
				<?php
				/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==10 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
					*/
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==10 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
					*/
				?>
			</td>
			<td style="text-align: center;">
				<?php
				/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==10 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
					*/
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==10 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
					*/
				?>
			</td>
			<td> <?php //echo $expected_res[0]['Description']; /*if(isset($perform['ex_ltc_fr'])){echo  $perform['ex_ltc_fr'];}*/ ?></td>
			<td>
				<?php // if(isset($perform['ltcRes'])){echo  $perform['ltcRes'];} ?>
			</td>
		</tr>

		<tr>
			<th>QC - Recent</th>
			<td style="text-align: center;">
				<?php
				//	foreach($sampleRes as $sr):
			//			if($sr['panelid']==20 and $sr['catid']==100 and $sr['result']==1){
			//				echo '&#10003;';
			//			}
			//		endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php /*
					foreach($sampleRes as $sr):
						if($sr['panelid']==20 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
					*/
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==20 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
					*/
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==20 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
					*/
				?>
			</td>
			<td><?php  echo $expected_res[1]['Description']; ?></td>
			<td>
				<?php if(isset($perform['RcRes'])){echo  $perform['RcRes'];} ?>
			</td>
		</tr>

		<tr>
			<th>QC - Negative</th>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==30 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==30 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==30 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==30 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
					?>
				<td>
					<?php // echo $expected_res[2]['Description'];?>
				</td>
				
			</td>
			<td>
				<?php// if(isset($perform['NcRes'])){echo  $perform['NcRes'];} ?>
			</td>
		</tr-->

		<tr>
			<th>PT -1 </th>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==40 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==40 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==40 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==40 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
				?>
			</td>
			<td><?php echo $expected_res[0]['Description'];?></td>
			<td>
					<?php echo  $perform[0]['Final_Interpretation']; ?>
			</td>
		</tr>

		<tr>
			<th>PT -2 </th>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==50 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==50 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==50 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==50 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
				?>
			</td>
			<td><?php echo $expected_res[1]['Description']; ?></td>
			<td>
				<?php echo   $perform[1]['Final_Interpretation']; ?>
			</td>
		</tr>
		<tr>
			<th>PT -3 </th>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==60 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==60 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==60 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==60 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
				?>
			</td>
			<td><?php echo $expected_res[2]['Description']; ?></td>
			<td>
				<?php echo   $perform[2]['Final_Interpretation']; ?>
			</td>
		</tr>

		<tr>
			<th>PT -4 </th>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==70 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==70 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==70 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==70 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
				?>
			</td>
			<td><?php echo $expected_res[3]['Description']; ?></td>
			<td>
				<?php  echo   $perform[3]['Final_Interpretation']; ; ?>
			</td>
		</tr>
		<!--tr>
			<th>PT -5 </th>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==80 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==80 and $sr['catid']==200 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==80 and $sr['catid']==300 and $sr['result']==1){
							echo '&#10003;';
						}
					endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php/*
					foreach($sampleRes as $sr):
						if($sr['panelid']==80 and $sr['catid']==400){
							if($sr['result']==1){
								echo 'LT';
							}
							else if($sr['result']==2){
								echo 'Recent';
							}
							else if($sr['result']==3){
								echo 'NEG';
							}
							else if($sr['result']==4){
								echo 'Invalid';
							}
						}
					endforeach;
				?>
			</td>
			<td><?php //echo $expected_res[7]['Description']; ?></td>
			<td>
				<?php// echo  $perform['pt5']; ?>
			</td>
		</tr>
	</table>
		  <table width="100%" align="center">
		  <tr>
		 	 <td COLSPAN=""><div align="center"><strong>Your Percentage Score</strong></div></td>
		 	 <td COLSPAN=""><div align="center"><?php if(isset($rp[0]['score'])) echo $rp[0]['score']; ?></div></td>
			   <td><div align="center"><strong>Overall Status</strong></div></td>
		 	   <td><div align="center"><?php if(isset($rp[0]['status'])) echo $rp[0]['status'];?></div></td>
	</tr>
	
	 <tr-->
	 <td colspan="4"><strong> Final Comments/Corrective Action Recommended </strong></td>

	</tr>
	
	 <tr>
	<td colspan="4"><?php
		if(count($samplecomments)>0){
			foreach ($samplecomments as $sc): 
				echo '<p>'.$sc['description'].'</p>';
			endforeach;
		}
	?></td>
	</tr>
	
<!--      removed some staff -->
	 <tr class="even">
            <th colspan="4"> FOR PROJECT COORDINATOR</th>
          </tr>
	<tr  >
	<td colspan="" ><strong>Name: &nbsp;&nbsp;&nbsp;<?php if(isset($rp[0]['approver'])) echo $rp[0]['approver']; ?>  </strong></td>
	<td colspan="" ><strong>Sign: &nbsp;&nbsp;&nbsp; <?php if(isset($rp[0]['signature'])) echo'<img src="', base_url('assets/images/Signatures/'), $rp[0]['signature'],'" width="95px; height=70px;">';?>  </strong></td>
	<td colspan="2" ><strong>Date: &nbsp;&nbsp;&nbsp; <?php if(isset($rp[0]['approvaldate']))echo $rp[0]['approvaldate'];?> </strong></td>
		</tr>
		  </table>      
	</table>
	

</div>
</body>