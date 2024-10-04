<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<?php
$si=$sampleInfo;
$er=$expected_res;
//print_r($er);
?>

 <style type="text/css">

			body{
				font-size: 10px;
			}
			.simon{
				border-right: none;
				border-left: none;
				padding: 3px 5px;
			}
			.small{
				font-size: 100%;
			}
			.form-control{
				height: 25px;
				padding:2px 8px;
				font-size: 12px;
			}		
			.profile-label{
				padding: 10px;
				margin-top: 2px;
				font-size: 1em;
			}
			.profile-logout{
				padding: 10px;
				margin-top: 2px;
				
			}

			.center {
			  display: block;
			  margin-left: auto;
			  margin-right: auto;
			  
			}
			table th {
				text-align: left;
				font-weight: bolder;
			}
		</style>
<div class="row">
	<table class="table table-condensed table-bordered" style="font-size: 14px; width: 80%; margin: auto;">
		<tr style="background-color: #ccc;">
			<th colspan="2" width="48%">Testing Site Information </th><th rowspan="10"></th><th colspan="2" width="48%">Sample Management Information</th>
		</tr>
		<tr>
			<th style="text-align:left;">
				Name of Facility
			</th><td>
				<?php if(isset($si['sitename'])){echo $si['sitename'];}?>
			</td><th>
				Batch # 
			</th><td colspan="2">
				<?php if(isset($si['cycleid'])){echo $si['cycleid'];}?>
			</td>
		</tr>

		<tr>
			<th>
				Facility Level
			</th><td>
				<?php if(isset($si['level'])){echo $si['levelname'];}?>
			</td><th colspan="2" style="background-color: #ccc;">
			
			</th>
		</tr>
		<tr>
			<th>
				Department
			</th><td>
				<?php if(isset($si['department'])){echo $si['department'];}?>
			</td><th>
				Date of Dispatch 
			</th><td colspan="2">
				<?php if(isset($si['dod'])){echo $si['dod'];}?>
			</td>
		</tr>
		<tr>
			<th>
				Location / Streetname
			</th><td>
				<?php if(isset($si['locationname'])) { echo $si['locationname'];}?>
			</td><th width="25%">
				Date Sample Received (at site) 
			</th><td colspan="2">
				<?php if(isset($si['dsr'])) {echo $si['dsr'];}?>
			</td>
		</tr>
		<tr>
			<th>
				Division
			</th><td>
				<?php if(isset($si['divisionname'])) {echo $si['divisionname'];}?>
			</td><th>
				Received By 
			</th><td colspan="2">
				<?php if(isset($si['rxby'])) {echo $si['rxby'];}?>
			</td>
		</tr>
		<tr>
			<th>
				Sub County
			</th><td>
				
			</td><th>
				Date/Time Sample Recieved 
			</th><td colspan="2">
				<?php if(isset($si['dtsr'])) {echo $si['dsr'];}?>
			</td>

		</tr>
		<tr>
			<th>
				District
			</th><td>
				<?php if(isset($si['districtname'])) {echo $si['districtname'];}?>
			</td><th>
				Date/Time Sample Receonstituted 
			</th><td colspan="2">
				<?php if(isset($si['dtsr'])) {echo $si['dtsr'];}?>
			</td>
			
		</tr>
		<tr>
			<th>
				Region
			</th><td>
				<?php if(isset($si['regionname'])) {echo $si['regionname'];}?>
			</td><th>
				Date/Time Sample Tested 
			</th><td colspan="2">
				<?php if(isset($si['dtst'])) {echo $si['dtst'];}?>
			</td>

		</tr>
		<tr>
			<th>
				Ownership
			</th><td>
				<?php if(isset($si['owner'])) {echo $si['owner'];}?>
			</td><th>
				Quality of Sample 
			</th><td colspan="2">
				<?php if(isset($si['sqty'])) {if($si['sqty']==1){echo 'Good';} else {echo 'Unsuitable';}}?>
			</td>

		</tr>
	</table>
</div>
<div class="row">
	<table class="table table-condensed table-stripped" style="font-size: 14px; width:80%; margin: auto;">
		<tr>
			<th>Testing Staf: Name</th><td><?php if(isset($si['testername'])) {echo $si['testername'];}?></td>
			<th>Contact</th><td><?php  if(isset($si['contact'])) {echo $si['contact'];}?></td>
			<th>Title</th><td><?php if(isset($si['title'])) {echo $si['title'];}?></td>
			
		</tr>
		<tr>
			<th>Site Supervisor: Name</th><td><?php if(isset($si['supervisorname'])) {echo $si['supervisorname'];}?></td>
			<th>Title</th><td><?php //echo $si[''];?></td><th>Contact</th><td><?php if(isset($si['tel'])) {echo $si['tel'];}?></td>
			
		</tr>
	</table>
</div>
<div class="row">
	<h5 style="text-align: center;">RTRI Test Kit Information</h5>
	<table class="table table-condensed table-bordered" style="font-size: 14px; width:80%; margin: auto;">
		<tr style="background-color: #ccc;">
			<th>Test Name</th><th>Kit Lot Number</th><th>Expiry Date</th><th>Reasons for not Testing</th>
		</tr>
		<tr>
			<td><?php if(isset($si['kit'])) {echo $si['kit'];}?></td><td><?php if(isset($si['lotnum'])) {echo $si['lotnum'];}?></td><td><?php if(isset($si['expirydate'])) {echo $si['expirydate'];}?></td><td></td>
		</tr>
	</table>
</div>

<div class="row">
	<h5 style="text-align: center;">Results</h5>
	<table class="table table-condensed table-bordered" style="font-size: 14px; width:80%; margin: auto;">
		<tr style="background-color: #ccc;">
			<th rowspan="2"> Sample </th>
			<th colspan="3" style="text-align: center;"><strong>(Visual Results Mark &#10004; if line present)</strong></th>
			<th rowspan="2" style="vertical-align: bottom;">Recency Interpretation</th>
			<th rowspan="2" style=" vertical-align: bottom;">Expected Result</th>
			<th rowspan="2" style=" vertical-align: bottom;">Status</th>
		</tr>
		<tr style="background-color: #ccc;"><th>Control(C)Line</th><th>Verification(V)Line</th><th>Long Time(LT)Line</th></tr>
		<!--tr>
			<th>QC - Long Term</th>
			<td style="text-align: center;">
				<?php
					
						//	echo '&#10003;';
						
				?>
			</td>
			<td style="text-align: center;">
				<?php
					//echo '&#10003;';
				?>
			</td>
			<td style="text-align: center;">
				<?php
					//echo '&#10003;';
					
				?>
			</td>
			<td style="text-align: left;">
				<?php
				
							//	echo 'LT';
					
				?>
			</td>
			<td>
				<?php 
					//echo 'PASS';
				 ?>
			</td>
		</tr>

		<tr>
			<th>QC - Recent</th>
			<td style="text-align: center;">
				<?php
					//echo '&#10003;';
				?>
			</td>
			<td style="text-align: center;">
				<?php
					//echo '&#10003;';
					
				?>
			</td>
			<td style="text-align: center;">
				<?php
					
				?>
			</td>
			<td style="text-align: left;">
				<?php
					
					//echo 'Recent';
					
				?>
			</td>
			<td>
				<?php 
					//	echo 'PASS';
				?>
			</td>
		</tr>

		<tr>
			<th>QC - Negative</th>
			<td style="text-align: center;">
				<?php
					
						//	echo '&#10003;';
					
				?>
			</td>
			<td style="text-align: center;">
				<?php
					// foreach($sampleRes as $sr):
					// 	if($sr['panelid']==30 and $sr['catid']==200 and $sr['result']==1){
					// 		echo '&#10003;';
					// 	}
					// endforeach;
				?>
			</td>
			<td style="text-align: center;">
				<?php
					// foreach($sampleRes as $sr):
					// 	if($sr['panelid']==30 and $sr['catid']==300 and $sr['result']==1){
					// 		echo '&#10003;';
					// 	}
					// endforeach;
				?>
			</td>
			<td style="text-align: left;">
				<?php
				
						//		echo 'NEG';
					
				?>
			</td>
			<td>
				<?php //if(isset($perform['NcRes'])){echo  $perform['NcRes'];} 
						//echo 'PASS';
				?>
			</td>
		</tr -->

		<tr>
			<th>PT -1 </th>
			<td style="text-align: center;">
				<?php
					foreach($sampleRes as $sr):
						if($sr['panelid']==40 and $sr['catid']==100 and $sr['result']==1){
							echo '&#10003;';
						}
						// else {
						// 	$perform['pt1']='FAIL';
						// }
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
			<td style="text-align: left;">
				<?php
				echo $perform['pt1_ex_fr'];
				?>
			</td>
			<td><?php foreach($er as $e): if($e['panelid']==40 && $e['catid']==400){echo $e['Description'];} endforeach; ?></td>
			<td>
					<?php echo  $perform['pt1']; ?>
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
						// else {
						// 	$perform['pt2']='FAIL';
						// }
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
			<td style="text-align: left;">
				<?php
					
				echo $perform['pt2_ex_fr'];
				?>
			</td>
			<td><?php foreach($er as $e): if($e['panelid']==50 && $e['catid']==400){echo $e['Description'];} endforeach; ?></td>
			<td>
				<?php echo  $perform['pt2']; ?>
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
						// else {
						// 	$perform['pt3']='FAIL';
						// }
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
			<td style="text-align: left;">
				<?php
					
				echo $perform['pt3_ex_fr'];
				?>
			</td>
			<td><?php foreach($er as $e): if($e['panelid']==60 && $e['catid']==400){echo $e['Description'];} endforeach; ?></td>
			<td>
				<?php echo  $perform['pt3']; ?>
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
					// 	else {
					// 		$perform['pt4']='FAIL';
					// 	}
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
			<td style="text-align: left;">
				<?php
				echo $perform['pt4_ex_fr'];
				?>
			</td>
			<td><?php foreach($er as $e): if($e['panelid']==70 && $e['catid']==400){echo $e['Description'];} endforeach; ?></td>
			<td>
				<?php echo  $perform['pt4']; ?>
			</td>
		</tr>
		
	</table>
	<form method="post" action="<?php echo base_url('recApprove');?>">
	<table class="table table-condensed table-bordered" style="font-size: 14px; width:80%; margin: auto;">
		 
		<tr>
			<th>Score</th><td><?php $pscore = $perform['score']; echo $pscore; ?>%</td>
			<th>Status</th><td><?php if($perform['score']==100){$pstat= 'PASS';}else{$pstat= 'FAIL';} 
				echo $pstat;
			?></td>
		</tr>
		<tr>
			<input type="hidden" name="pscore" id="pscore" value="<?php echo $pscore; ?>">
			<input type="hidden" name="pstat" id="pstat" value="<?php echo $pstat; ?>">
			<td colspan="4">Extra Comments</td>
		</tr>
		<tr>
           	<th colspan="4">Please Specify Extra Comments/Corrective Action Below</th>
        </tr>
        <tr>                                            
            <td colspan="4">
                <select class="form-control" id="syphcomments" name="syphcomments[]" multiple>
					<?php
					foreach($commentcategory as $cc):
						echo '<option value="'.$cc['cid'].'" >'.$cc['description'].'</option>';
					endforeach; 
					?>						
				</select>
            </td>
            
            
        </tr>
        
        
        <tr>
        	<td><button class="btn btn-default" id="btn-approve">Approve</button></td>
        	<input type="hidden" name="approvedby" id="approvedby" value="<?php echo $_SESSION['id'];?>">
                                    <input type="hidden" name="sampleid" id="sampleid" value="<?php if(isset($si['sampleid'])) {echo $si['sampleid'];}?>">
                                    <input type="hidden" name="v" value="saveApproval">
        </tr>
	</table>
	</form>
	<div>
		<?php 
			
		?>
	</div>

									
                                    
</div>
			
           
<script type="text/javascript">

                $(document).ready(function(){
                	$('#syphcomments').multiselect({		
						nonSelectedText: 'Select Reason'				
					});

                    var base_url ="<?php echo base_url();?>";
                                            

                    function getValueUsingClass(){
                        /* declare an checkbox array */
                        var chkArray = [];
                        
                        /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
                        $(".chk:checked").each(function() {
                            chkArray.push($(this).val());
                        });
                        
                        /* we join the array separated by the comma */
                        var selected;
                        selected = chkArray.join(',') + ",";
                       // return selected.substr(0, selected.length -1); //remove the trailing comma
                        return chkArray;
                    	}
                	});
            </script>
           
       