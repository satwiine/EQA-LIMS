<?php error_reporting(0);?>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- content heade -->
  <section class="content-header">
    <h1>Manage Elements</h1>

    <ol class="breadcrumb">
      <li><a href="#">
          <i class="fa fa-dashboard"></i>Home
        </a>
      </li>
      <li class="active"><a href="<?php echo base_url('Element');?>">Elements</a></li>
      <li class="active">
        Elemnets Value
      </li>
    </ol>
  </section>

  <!-- Main Content -->
  <section class="content">
    <!-- Small boxes -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        
        <div class="box">
          <div class="box-body">
            <h5>Get Result File </h5>
          </div>
        </div>

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')):?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success');?>
          </div>
          <?php elseif ($this->session->flashdata('error')):?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error');?>
          </div>  
        <?php endif;?>
        
        <br><br>

        <div class="box">
          <!-- /.box header -->
          <div class="box-body">
           <h3>Your file was successfully uploaded!</h3>

			<ul>
			<?php 
				$fname='';
			foreach ($upload_data as $item => $value):?>
			<li><?php echo $item;?>: <?php echo $value;?></li>
			<?php if($item=='raw_name'){$fname=$value.'.json'; } ?>
			<?php endforeach; ?>
			</ul>

			<p>
				<?php
						$path=base_url('/uploads/'.$fname);
						$jsonData=file_get_contents($path);
						$data = json_decode($jsonData,true);

						///static values
						$vlSampleId=$data['report']['inputSequence']['header'];
						$atype =$data['report']['bestMatchingSubtype']['display'];
						$trandate = $data['currentVersion']['publishDate'];
						$muts= count($data['report']['alignedGeneSequences']);
						$drugscores=count($data['report']['drugResistance']);
						$groupmuts=count($data['report']['mutations']);
						$mutprev=count($data['report']['mutationPrevalences']);

						
						

						$basedata=array(
						      'trandate'=>$trandate,
						      'sample_id'=>$vlSampleId,
						      'vtype'=>$atype
						 );

						 ?>
						 	
						 <?php

						//mutations
							$mut_data=array();
							  for($i=0;$i<$muts;$i++){
							    $gene = $data['report']['alignedGeneSequences'][$i]['gene']['name'];
							    for($j=0;$j<count($data['report']['alignedGeneSequences'][$i]['mutations']); $j++){
							      
							      $mut_type=$data['report']['alignedGeneSequences'][$i]['mutations'][$j]['__typename'];
							      $mut_str=$data['report']['alignedGeneSequences'][$i]['mutations'][$j]['text'];

							      //prepare an array to pass to the model to add data
							      $mut_data[$j]['sample_id']=$vlSampleId;
							      $mut_data[$j]['atype']=$atype;
							      $mut_data[$j]['gene']=$gene;
							      $mut_data[$j]['mutationtype']=$mut_type;
							      $mut_data[$j]['mutation_string']=$mut_str;
							    }
							  }

						  //drug mutations 
						  for($g=0;$g<count($data['report']['drugResistance']);$g++){
						    for($h=0;$h<count($data['report']['drugResistance'][$g]['drugScores']);$h++){
						      //insert into drug mutations
						      $dr_code=$data['report']['drugResistance'][$g]['drugScores'][$h]['drug']['displayAbbr'];
						      $dr_name=$data['report']['drugResistance'][$g]['drugScores'][$h]['drug']['name'];
						      $cat_name=$data['report']['drugResistance'][$g]['drugScores'][$h]['drugClass']['name'];
						      $score=$data['report']['drugResistance'][$g]['drugScores'][$h]['score'];
						      $level=$data['report']['drugResistance'][$g]['drugScores'][$h]['level'];
						      $mut_str=$data['report']['drugResistance'][$g]['drugScores'][$h]['text'];
						   
						   //prepare array to use to insert data into db
						        $dr_data[$h]['sample_id']=$vlSampleId;
						        $dr_data[$h]['drugcode']=$dr_code;
						        $dr_data[$h]['drugname']=$dr_name;
						        $dr_data[$h]['category']=$cat_name;
						        $dr_data[$h]['score']=$score;
						        $dr_data[$h]['level']=$level;
						        $dr_data[$h]['restext']=$mut_str;
						    }
						  }

						  //update drug resistance names
						  for($g=0;$g<count($data['report']['drugResistance']);$g++){
						    for($h=0;$h<count($data['report']['drugResistance'][$g]['levels']);$h++){

						      //prepare array to use to insert data into db
						      $dr_upd_data[$h]['sample_id']=$vlSampleId;
						      $dr_upd_data[$h]['drugcode']=$data['report']['drugResistance'][$g]['levels'][$h]['drug']['name'];
						      $dr_upd_data[$h]['drugname']=$data['report']['drugResistance'][$g]['levels'][$h]['drug']['fullName'];
						    }
						  }

						  ///Comments
						  $cm_data=array();
						  for($q=0;$q<count($data['report']['drugResistance']);$q++){
						    $gene=$data['report']['drugResistance'][$q]['gene']['name'];
						    for($r=0;$r<count($data['report']['drugResistance'][$q]['commentsByTypes']);$r++){
						     
						      $cat_name= $data['report']['drugResistance'][$q]['commentsByTypes'][$r]['commentType'];
						      $comment= $data['report']['drugResistance'][$q]['commentsByTypes'][$r]['comments'][0]['text'];
						      
						      //prepare array to use to insert data into db
						      $cm_data[$r]['sample_id']=$vlSampleId;
						      $cm_data[$r]['category']=$cat_name;
						      $cm_data[$r]['comment']=$comment;
						    }
						  }


						  ////Group Mutations
						  $cx=array();$dm_data=array();
						  $t=0;
						  foreach($data['report']['drugResistance'] as $row){
						    foreach($row['mutationsByTypes'] as $mutbytype){
						      $cx[]= $mutbytype;
						    }
						  }
						  for($z=0;$z<count($cx);$z++){
						   // $gene=$cx[$z]['drugClass']['name'];
						    $muttype=$cx[$z]['mutationType'];
						    if(count($cx[$z]['mutations'])>0){
						      
						      //prepare array to use to insert data into db
						      $dm_data[$t]['sample_id']=$vlSampleId;
						      $dm_data[$t]['name']=$gene;
						      $dm_data[$t]['type']=$muttype;
						      for($w=0;$w<count($cx[$z]['mutations']);$w++){
						        $dm_data[$t]['mutstr']=$cx[$z]['mutations'][$w]['text'];
						      } 
						      $t+=1;
						    }
						  }

						   
				 ?>
				 <table class="table table-bordered table-striped">
				 	<thead>
				 		<tr>
				 			<th>Sample Id</th><th>Date</th><th>Outcome</th>
				 		</tr>
				 	</thead>
				 	<tbody>
				 		<tr>
				 			<td><?php echo $vlSampleId;?></td>
				 			<td><?php echo $trandate;?></td>
				 			<td>
				 				
				 			</td>
				 		</tr>

				 	</tbody>
				 </table>

				 <form id="myForm" method="post" action="<?php echo base_url('insert_dr_data');?>" >
				  <label for="sample_id">Sampleid:</label>
				  <input type="text" id="sample_id" name="sample_id" value="<?php echo $vlSampleId;?>">
				  <label for="trandate">Date:</label>
				  <input type="text" id="trandate" name="trandate" value="<?php echo $trandate;?>">
				  <input type="text" id="vtype" name="vtype" value="<?php echo $atype;?>">

				  <button type="submit" id="submit" style="display:block;">Save Resulta</button>
				  <p><?php echo anchor('manage/getDRjsonResult', 'Upload Another File!'); ?></p>
				  <table style="visibility:hidden;">
				  		<tr>
				  			<th>Gene</th><th>Mutation Type</th><th>Mutation String</th>
				  		</tr>
				  		<?php
				  			for($i=0;$i<count($mut_data);$i++){
				  				echo '<tr>
				  						<td><input type="text" name="gene[]" value="',$mut_data[$i]['gene'],'"></td>
				  						<td><input type="text" name="muttype[]" value="',$mut_data[$i]['mutationtype'],'"></td>
				  						<td><input type="text" name="mutstring[]" value="',$mut_data[$i]['mutation_string'],'"></td>
				  					 </tr>';
				  			} 
				  		?>
				  </table>

				  <table style="visibility: hidden;">
				  		<tr>
				  			<th>drugcode</th><th>Drug Name</th><th>Category</th><th>Score</th><th>Level</th><th>Resistance Text</th>
				  		</tr>
				  		<?php
				  			for($i=0;$i<count($dr_data);$i++){
				  				echo '<tr>
				  						<td><input type="text" name="drugcode[]" value="',$dr_data[$i]['drugcode'],'"></td>
				  						<td><input type="text" name="drugname[]" value="',$dr_data[$i]['drugname'],'"></td>
				  						<td><input type="text" name="category[]" value="',$dr_data[$i]['category'],'"></td>
				  						<td><input type="text" name="score[]" value="',$dr_data[$i]['score'],'"></td>
				  						<td><input type="text" name="level[]" value="',$dr_data[$i]['level'],'"></td>
				  						<td><input type="text" name="restext[]" value="',$dr_data[$i]['restext'],'"></td>
				  					 </tr>';
				  			} 
				  		?>
				  </table>

				  <table style="visibility: hidden;">
				  		<tr>
				  			<th>Gene</th><th>Mutation Type</th>
				  		</tr>
				  		<?php
				  			for($i=0;$i<count($dr_upd_data);$i++){
				  				echo '<tr>
				  						<td><input type="text" name="upddrugcode[]" value="',$dr_upd_data[$i]['drugcode'],'"></td>
				  						<td><input type="text" name="upddrugname[]" value="',$dr_upd_data[$i]['drugname'],'"></td>
				  					 </tr>';
				  			} 
				  		?>
				  </table>

				   <table style="visibility: visible;">
				  		<tr>
				  			<th>Category</th><th>Comment</th><th>Group</th>
				  		</tr>
				  		<?php

				  		for($x=0;$x<count($data['report']['drugResistance']);$x++){
				  			$grp=$data['report']['drugResistance'][$x]['gene']['name'];
				  			for($y=0;$y<count($data['report']['drugResistance'][$x]['commentsByTypes']);$y++){
				  				$cat=$data['report']['drugResistance'][$x]['commentsByTypes'][$y]['commentType'];
				  				for($z=0;$z<count($data['report']['drugResistance'][$x]['commentsByTypes'][$y]['comments']);$z++){
				  					echo '<tr>
				  					  <td><input type="text" name="cmgroup[]" value="'.$grp.'"></td>
				  						<td><input type="text" name="cmcategory[]" value="'.$cat.'"></td>
				  						<td><input type="text" name="cmcomment[]" value="'.$data['report']['drugResistance'][$x]['commentsByTypes'][$y]['comments'][$z]['text'].'"></td>
				  					 </tr>';
				  				}
				  			}
				  		}

				  		?>
				  </table>
				  
				  <table style="visibility: hidden;">
				  		<tr>
				  			<th>group type</th><th>Gene</th><th>Mutation text</th>
				  		</tr>
				  		<?php
				  				for($t=0;$t<count($data['report']['drugResistance']);$t++){
										for($u=0;$u<count($data['report']['drugResistance'][$t]['mutationsByTypes']);$u++){
											if(count($data['report']['drugResistance'][$t]['mutationsByTypes'][$u]['mutations'])>0){
												$gene= $data['report']['drugResistance'][$t]['gene']['name'];
												for($e=0;$e<count($data['report']['drugResistance'][$t]['mutationsByTypes'][$u]['mutations']);$e++){
													echo '<tr>
															<td><input type="text" name="gpmuttype[]" value="'.$data['report']['drugResistance'][$t]['mutationsByTypes'][$u]['mutationType'].'" ></td>
															<td><input type="text" name="gpgene[]" value="'.$gene.'" ></td>
															<td><input type="text" name="gpmutstr[]" value="'.$data['report']['drugResistance'][$t]['mutationsByTypes'][$u]['mutations'][$e]['text'].'" ></td>
													</tr>';
												}
											}
										}
									
									}
				  			
				  		?>
				  </table>

				  
				</form>
			</p>
			

          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<!-- js -->


