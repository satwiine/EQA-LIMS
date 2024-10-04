<?php
	$hivscreening='';	$sclot='';	$hivconf='';	$conflot='';	$hivtieb='';	$tblot='';	$scexp='';	$conexp='';	$tbexp='';
	
	$hivp1screening='';$hivp1confirm=''; $hivp1tie=''; $hivp1fr='';
	$hivp2screening='';$hivp2confirm=''; $hivp2tie=''; $hivp2fr='';
	$hivp3screening='';$hivp3confirm=''; $hivp3tie=''; $hivp3fr='';
	$hivp4screening='';$hivp4confirm=''; $hivp4tie=''; $hivp4fr='';

	$hivp1scr_res=''; $hivp1con_res=''; $hivp1tb_res=''; $hivp1fr_res=''; 
	$hivp2scr_res=''; $hivp2con_res=''; $hivp2tb_res=''; $hivp2fr_res=''; 
	$hivp3scr_res=''; $hivp3con_res=''; $hivp3tb_res=''; $hivp3fr_res=''; 
	$hivp4scr_res=''; $hivp4con_res=''; $hivp4tb_res=''; $hivp4fr_res=''; 


	$syphkit='';	$syphlot='';	$syphexpdt='';

	$spyp1res='';$spyp2res='';$spyp3res='';$spyp4res='';

	foreach($hivtestkit as $hk):
		if($hk['testcatid']==1){
			$hivscreening=$hk['testname'];
			$sclot=$hk['lotno'];
			$scexp=$hk['expdt'];
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
<!DOCTYPE>
<html>
	<head>
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

		<script type="text/javascript">
			function PrintDiv(){
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
	</head>
	<body>
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
					<th colspan="1">Contact Details</th>
				</tr>
				<tr>
					<td colspan="2">
						<table border="0" width="100%">
							<tr class="even">
								<th colspan="1">Site Supervisor</th>
								<td colspan="1"><?php echo $sample['supervisorname'];?></td>
							</tr>
							<tr class="even">
								<th colspan="1">Telephone</th>
								<td colspan="1"><?php echo $sample['tel'];?></td>
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
							<div style=" width: 100%;">
								<table border="0" class="data-table" width="100%">
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
		            		</th><th colspan="8">HIV</th><th></th><th>Syphilis</th></tr>
		            		<tr>
								
								<th  colspan="2"><small>Screening</small></th>
								<th  colspan="2"><small>Confirmatory</small></th>
								<th  colspan="2"><small>Tie Breaker</small></th>
								<th  colspan="2"><small>Final Result</small></th>
							
								
								<th></th>
								<th>Final Results</th>	
						  	</tr>
						  	<tr>
								<td>UVRI HIV/SYPH</td>
								<td colspan="2"><?php echo $hivp1scr_res;?> </td>
								<td colspan="2"><?php echo $hivp1con_res;?></td>
								<td colspan="2"><?php echo $hivp1tb_res;?></td>
								<td colspan="2"><?php echo $hivp1fr_res;?></td>
							
								
								<td></td>
								<td><?php echo $spyp1res;?></td>	
						  	</tr>
						  	<tr>
								<td> UVRI HIV/SYPH</td>
								<td colspan="2"><?php echo $hivp2scr_res;?> </td>
								<td colspan="2"><?php echo $hivp2con_res;?></td>
								<td colspan="2"><?php echo $hivp2tb_res;?></td>
								<td colspan="2"><?php echo $hivp2fr_res;?></td>
							
								
								<td></td>
								<td><?php echo $spyp2res;?></td>	
						  	</tr>
						  	<tr>
								<td>UVRI HIV/SYPH</td>
								<td colspan="2"><?php echo $hivp3scr_res;?> </td>
								<td colspan="2"><?php echo $hivp3con_res;?></td>
								<td colspan="2"><?php echo $hivp3tb_res;?></td>
								<td colspan="2"><?php echo $hivp3fr_res;?></td>
							
								
								<td></td>
								<td><?php echo $spyp3res;?></td>	
						  	</tr>
						  	<tr>
								<td>UVRI HIV/SYPH</td>
								<td colspan="2"><?php echo $hivp4scr_res;?> </td>
								<td colspan="2"><?php echo $hivp4con_res;?></td>
								<td colspan="2"><?php echo $hivp4tb_res;?></td>
								<td colspan="2"><?php echo $hivp4fr_res;?></td>
							
								
								<td></td>
								<td><?php echo $spyp4res;?></td>	
						  	</tr>
		            	</table>
		            </td>				
				</tr>
			</table>
			

			<form action="<?php echo base_url('approvedts');?>">
				<input type="hidden" value="<?php echo $sample['sampleid'] ;?>">

				<table class="table table-condensed table-bordered" width="90%">
					<tr>
						<td colspan="4" align="center">HIV</td>
						<td colspan="4" align="center">SYPHILIS</td>
					</tr>
					<tr class="even">
						<th> Score</th>
						<td> 100</td>
						<th>Overall Status</th>
						<td> Pass </td>
						<th> Score</th>
						<td> 85</td>
						<th>Overall Status</th>
						<td>Fail</td>
					</tr>
					<tr>
						<td colspan="4">
							<select class="form-control">
								<option value="">Select</option>
							</select>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<pre>
		<?php print_r($dtsresult);

			echo '<br>';

			print_r($hivexpectedresult);

			foreach($hivexpectedresult as $e):
				if($e['panelid']==1 && $e['']){}
			endforeach;
		?>
	</pre>
	</body>

</html>