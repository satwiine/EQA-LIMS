<?php
   // $dbhost = '10.0.0.4:3036';
   // $dbuser = 'root';
   // $dbpass = 'simpleplan';
   // $dbname = 'uvri_pt';
   
   // $backup_file = $dbname . date("Y-m-d-H-i-s") . '.gz';
   // $command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "uvri_pt | gzip > $backup_file";
   
   // system($command);

   // $DBHOST="10.0.0.4";
   // $DBUSER="root";
   // $DBPASSWD="simpleplan";
   // $DATABASE="uvri_pt";

   // $filename = "backup-EQA_DB_" . date("d-m-Y") . ".sql.gz";
   // $mime = "application/x-gzip";

   // header( "Content-Type: " . $mime );
   // header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

   // $cmd = "mysqldump -h $DBHOST -u $DBUSER --password=$DBPASSWD $DATABASE | gzip --best";   

   // passthru( $cmd );


   
   $dir = "assets/tbackup/";
   $filename = "EQA_backup_" . date("YmdHis") . ".sql.gz";

   $db_host = "10.0.0.4";
   $db_username = "root";
   $db_password = "simpleplan";
   $db_database = "uvri_pt";

   $cmd = "mysqldump -h {$db_host} -u {$db_username} --password={$db_password} {$db_database} | gzip > {$dir}{$filename}";
   exec($cmd);

   header("Content-type: application/octet-stream");
   header("Content-Disposition: attachment; filename=\"$filename\"");

   passthru("cat {$dir}{$filename}");
?>