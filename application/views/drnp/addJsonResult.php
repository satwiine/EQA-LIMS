<?php
$data = file_get_contents($_FILES['fileToUpload']['tmp_name']);

$data=json_decode($data,true);

  ///get the constanta needed for data extracting
  $vlSampleId=$data['report']['inputSequence']['header'];
  $atype =$data['report']['bestMatchingSubtype']['display'];
  $trandate = $data['currentVersion']['publishDate'];
  $muts= count($data['report']['alignedGeneSequences']);
  $drugscores=count($data['report']['drugResistance']);
  $groupmuts=count($data['report']['mutations']);

  // populate the samples_base table
 $basedata=array(
      'trandate'=>$trandate,
      'sample_id'=>$vlSampleId,
      'vtype'=>$atype
 );

if(count($basedata)>0){
  ?>
  <html>
  <head>
    <title></title>
  </head>
  <body>
    <table class="table table-bordered table-striped">
      <tr>
        <td>xx</td>
      </tr>
    </table>
  </body>
  </html>
  <?php
}
// print_r($basedata);

/*
  
  

//get MAC Address (something i need to use in future)
//echo exec('getmac');



  //push data to db
  $base_outcome=$sample->create($basedata);


//////Group Mutations covered here
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

  //push data to db
  $mut_outcome=$sample->addMutation($mut_data);
  
 

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
  //push data to db
  $dr_outcome=$sample->addDrugMutation($dr_data);


  ////update the drugnames that were just added in the drugmutation by sampleid and drugcode
  for($g=0;$g<count($data['report']['drugResistance']);$g++){
    for($h=0;$h<count($data['report']['drugResistance'][$g]['levels']);$h++){

      //prepare array to use to insert data into db
      $dr_upd_data[$h]['sample_id']=$vlSampleId;
      $dr_upd_data[$h]['drugcode']=$data['report']['drugResistance'][$g]['levels'][$h]['drug']['name'];
      $dr_upd_data[$h]['drugname']=$data['report']['drugResistance'][$g]['levels'][$h]['drug']['fullName'];
    }
  }

  //push data to db
  $upd_outcome=$sample->updateDrugMutation ($dr_upd_data);

  ////Group Mutations
  $cx=array();$dm_data=array();
  foreach($data['report']['drugResistance'] as $row){
    foreach($row['mutationsByTypes'] as $mutbytype){
      $cx[]= $mutbytype;
    }
  }
  for($z=0;$z<count($cx);$z++){
    $gene=$cx[$z]['drugClass']['name'];
    $muttype=$cx[$z]['mutationType'];
    if(count($cx[$z]['mutations'])>0){
      
      //prepare array to use to insert data into db
      $dm_data[$z]['sample_id']=$vlSampleId;
      $dm_data[$z]['name']=$gene;
      $dm_data[$z]['type']=$muttype;
      for($w=0;$w<count($cx[$z]['mutations']);$w++){
        $dm_data[$z]['mutstr']=$cx[$z]['mutations'][$w]['text'];
      } 
    }
  }

  //push data to db
  $gm_outcome=$sample->addGroupMutation($dm_data);
  
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

  //push data to db
  $cm_outcome=$sample->addComment($cm_data);
  

  ///think of pushing data to cphl at once
*/
?>