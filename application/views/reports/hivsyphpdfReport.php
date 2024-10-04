<?php
	ob_start();
	//include(base_url('assets/pdf/fpdf.php'));
	//getbatchno using cycleid of the samplein question
	//$sample=$sampledetail;
	//$batchno=$sample['description'];

//header('Location: http://localhost/coag_printing/pdfreport.php?sampleid='.$sampleid);
//exit();

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
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
			table {margin-bottom: 1.2em; border-spacing:1px; }
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
			.tdh{
				font-weight: bolder;
				font-size: 10px;
				text-transform: capitalize;
			}
			table.data-table tr.even td {background: #FCFCFC;}
			table {border-collapse:collapse;}
			table.data-table{margin-top:5px;}
		</style>
		
	</head>
	<body>
		<div id="divtoprint" style="width:85%; margin:auto; font-size: 10px;">
			<div class="row" style="width:90%;">
					<div style="width:10%;display:inline-block;margin-left: 5%;">
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
					<div style="width:60%; display:inline-block; align-self: center; position:absolute;top:30px; left:25%;">
						<div class="uvri_heading">uganda virus reserch institute</div>
						<div class="sero_heading">national hiv serology qa/qc</div>
						<div class="prof_heading">hiv proficiency assessment scheme</div>
						<div class="dts_heading">dts result report</div>
					</div>
					<div style="width:12%;display:inline-block;float:right;position:absolute; top:30px; right:4%">
					<div class="mocd">moh/cdc</div>
					<div class="tcpatch">TESTER CODE</div>
					<div class="tclbl"><?php echo $sampledetail['testercode'];?></div>
				</div>
			</div>
		
		<div class="row" style="width:100%; margin-left: -10px;">
			<table class="data-table table table-bordered table-condensed" width="100%" style="font-size: 10px;">
				<tr class="even">
					<th colspan="2">Results Feedback Report</th>
				</tr>
				<tr>
					<td width="50%">
						<table class="table table-condensed" width="100%">
							<tr>
								<th colspan="2">
									<strong>Testing Details</strong>
								</th>
							</tr>
							<tr>
								<td class="tdh" width="30%">Testing Site</td>
								<td><?php echo 'Site detail name';?></td>
							</tr>
							<tr>
								<td class="tdh">Department</td>
								<td><?php echo 'Department';?></td>
							</tr>
							<tr>
								<td class="tdh">Ownership</td>
								<td><?php echo 'ownership';?></td>
							</tr>
							<tr>
								<td class="tdh">Division</td>
								<td><?php echo 'Division';?></td>
							</tr>
							<tr>
								<td class="tdh">District</td>
								<td><?php echo 'District';?></td>
							</tr>
							<tr>
								<td class="tdh">Region</td>
								<td><?php echo 'Region';?></td>
							</tr>
						</table>
					</td>
					<td>
						<table class="table table-condensed">
							<tr>
								<th colspan="2">
									<strong>Sample Specifications</strong>
								</th>
							</tr>
							<tr>
								<td class="tdh" width="30%">Batch #</td>
								<td><?php echo 'Batch Number';?></td>
							</tr>
							<tr>
								<td class="tdh">Dispatched</td>
								<td><?php echo 'Date of Dispatch';?></td>
							</tr>
							<tr>
								<td class="tdh">Recieved</td>
								<td><?php echo 'Date Recieved';?></td>
							</tr>
							<tr>
								<td class="tdh">Reconstituted</td>
								<td><?php echo 'Date Reconstituted';?></td>
							</tr>
							<tr>
								<td class="tdh">Tested</td>
								<td><?php echo 'Date Sample Tested';?></td>
							</tr>
							<tr>
								<td class="tdh">Feedback</td>
								<td><?php echo 'Result Reciept Date';?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th colspan="2">
						Contact Details
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table table-condensed">
							<tr>
								<td class="tdh" width="15%">Site Supervisor</td>
								<td></td>
								<td class="tdh" width="15%">Testing Personel</td>
								<td></td>
							</tr>
							<tr>
								<td class="tdh">Supervisor Tel</td>
								<td></td>
								<td class="tdh">Tester Tel</td>
								<td></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th colspan="2">
						Testkit Details
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table table-condensed">
							<tr>
								<td class="tdh" width="15.3%">Test 1:</td>
								<td></td>
								<td class="tdh" width="15.3%">Test 2:</td>
								<td></td>
								<td class="tdh" width="15.3%">Test 3:</td>
								<td></td>
							</tr>
							<tr>
								<td class="tdh">Lot #</td>
								<td></td>
								<td class="tdh">Lot #</td>
								<td></td>
								<td class="tdh">Lot #</td>
								<td></td>
							</tr>
							<tr>
								<td class="tdh">Expiry Date</td>
								<td></td>
								<td class="tdh">Expiry Date</td>
								<td></td>
								<td class="tdh">Expiry Date</td>
								<td></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th colspan="2">Results</th>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table table-condensed" width="100%">
							<tr>
								<td class="tdh" rowspan="2">Sample ID</td>
								<th colspan="2"> Screening</th>
								<th colspan="2"> Confirmatory</th>
								<th colspan="2"> Tie Breaker</th>
								<th colspan="2"> HIV Result</th>
								<th>Pass/Fail</th>
								<th colspan="2"> SYPH Result</th>
								<th>Pass/Fail</th>
							</tr>
							<tr>
								<th>Your Result</th><th>Expected Result</th>
								<th>Your Result</th><th>Expected Result</th>
								<th>Your Result</th><th>Expected Result</th>
								<th>Your Result</th><th>Expected Result</th>
								<th></th>
								<th>Your Result</th><th>Expected Result</th>
								<th></th>
							</tr>
							<tr>
								<td class="tdh">UVRI 1</td>
								<td>nr</td><td>nr</td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td>
								<td></td><td></td>
								<td></td>
							</tr>
							<tr>
								<td class="tdh">UVRI 2</td>
								<td>nr</td><td>nr</td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td>
								<td></td><td></td>
								<td></td>
							</tr>
							<tr>
								<td class="tdh">UVRI 3</td>
								<td>nr</td><td>nr</td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td>
								<td></td><td></td>
								<td></td>
							</tr>
							<tr>
								<td class="tdh">UVRI 4</td>
								<td>nr</td><td>nr</td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td><td></td>
								<td></td>
								<td></td><td></td>
								<td></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table table-condensed">
							<tr><th colspan="2">HIV Final Grading</th> <th colspan="2">Syphilis Final Grading</th></tr>
							<tr>
								<td colspan="2">
									<table class="table table-condensed">
										<tr>
											<td class="tdh" width="25%">Your %age Score</td>
											 <td > </td>
											 <td class="tdh" width="25%">Overall Status</td>
											 <td> </td>
										</tr>
									</table>
								</td>
								<td colspan="2">
									<table class="table table-condensed">
										<tr>
											<td class="tdh" width="25%">Your %age Score</td>
											 <td> </td>
											 <td class="tdh" width="25%">Overall Status</td>
											 <td> </td>
										</tr>
									</table>
								</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td class="tdh" width="16%"> Final Comments/Corrective Actions Recommended</td><td ></td>
				</tr>
				<tr>
					<th colspan="2">FOR Project Coordinator</th>
				</tr>
				<tr>
					<td colspan="2">
						<table class="table table-condensed">
							<tr>
								<td class="tdh" width="33%">
									<span>Name:</span>
									<span style="padding-left: 10%;"> <?php echo 'Approver';?></span>
								</td>
								<td class="tdh" width="33%">
									<span style="margin-right: 10%;">Sign:</span>
									<span> <?php echo 'Approver Signature';?></span>
								</td>
								<td class="tdh" width="33%">
									<span>Date:</span>
									<span style="padding-left:10%;"> <?php echo 'Approval Date';?></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
		</div>
		
	</div>

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

	</body>
	</html>
