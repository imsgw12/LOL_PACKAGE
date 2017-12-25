<html>
<body>
<link rel = stylesheet href='../ungoldstyle.css' type='text/css'>
<meta charset="utf-8">
<meta http-equiv = "Content-Type" content = "text/html; charset = euc-kr">
<link rel = "stylesheet"href='ungodstyle.css' type='text/css'>

<?php
include_once 'Snoopy.class.php';
include_once 'simple_html_dom.php';

$TOP = $_GET["TOP"];
$JUNGLE = $_GET["JUNGLE"];
$MID = $_GET["MID"];
$AD = $_GET["AD"];
$SUP = $_GET["SUP"];

//$connect = new mysqli ("localhost", "cs20121603", "dbpass","db20121603");

$Top_name = $Top_per = array();
$Jungle_name = $Jungle_per = array();
$Mid_name = $Mid_per = array();
$Ad_name = $Ad_per = array();
$Sup_name = $Sup_per = array();

$target = 0;
$Top_inx = $Jungle_inx = $Mid_inx = $Ad_inx = $Sup_inx=0;

function Make_DB ( $value ) {
  global $TOP, $JUNGLE, $MID, $AD, $SUP;
  global $target;
  
  if($value) {
/*    $table = "CREATE TABLE $value (
				    Number INT PRIMARY KEY AUTO_INCREMENT,
				    Name   VARCHAR(10) NOT NULL,
				    Position VARCHAR(10) NOT NULL,
				    Percentage VARCHAR(5) NOT NULL
				   );";
    
    $connect->query($table); */
    
    $fp = fopen("$value.txt","w+");
    if(!$fp) die("cannot open the file.");

    $link = "https://www.leagueofgraphs.com/en/champions/counters/";
    $link .= "$value"; 

    $i = 0;
    foreach(file_get_html($link)->find('table[class=data_table sortable_table]') as $Result) {
        foreach($Result->find('span[class=name]') as $name){
   	  $Name[$i] = $name->plaintext;
	  $i++;
        }
	$i=0;
        foreach($Result->find('i') as $Pos) {
          $Position[$i] = $Pos->plaintext;
	  $i++;
        }
	$i=0;
	foreach($Result->find('div[class=progress-bar-container show-for-large-up-custom]') as $Per){
		foreach($Per->find('span[class=percentage]') as $temp) {
		  $Percentage[$i] = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$temp->plaintext);
		  $i++;
		}
	}
        break;
    }

  
    for ( $k = 0 ; $k < $i ; $k++ ) {
      $string = $Name[$k];
      $string .= '/';
      $string .= $Position[$k];
      $string .= '/';
      $string .= $Percentage[$k];
      $string .= "\n";

      fwrite($fp, $string);
/*      $sql = "INSERT INTO $value (Name, Position, Percentage)
              VALUES ('$name', '$position', '$percentage')";
      echo $sql;
      echo "<br>";
      $connect->query($sql); */
    }
    if ( !$TOP ) Find ( $value, "Top") ;
    if ( !$JUNGLE ) Find ( $value, "Jungler" );
    if ( !$MID ) Find ($value, "Mid");
    if ( !$AD ) Find ($value, "AD Carry" );
    if ( !$SUP ) Find ($value, "Support" ); 
    $target++;
  }
  fclose($fp);
}

function Find ( $name, $flag ) {
  global $Top_name, $Top_per;
  global $Jungle_name , $Jungle_per;
  global $Mid_name , $Mid_per;
  global $Ad_name , $Ad_per;
  global $Sup_name , $Sup_per;
  global $Top_inx, $Jungle_inx, $Mid_inx, $Ad_inx, $Sup_inx;

  $fp = fopen ("$name.txt", "r");
  
  while ( !feof($fp) ) {
    $string = fgets($fp, 100);
    $data = explode('/', $string);

    if( ! strcmp($data[1], $flag) ) {
      if ( !strcmp($flag , "Top") ) {
	$Top_name[$Top_inx] = $data[0];
	$Top_per[$Top_inx++] = (int)$data[2];
      }
      if ( !strcmp($flag , "Jungler") ) {
	$Jungle_name[$Jungle_inx] = $data[0];
	$Jungle_per[$Jungle_inx++] = (int) $data[2];
      }
      if ( !strcmp($flag , "Mid" )) {
	$Mid_name[$Mid_inx] = $data[0];
	$Mid_per[$Mid_inx++] =(int)$data[2];
      }
      if ( !strcmp($flag ,"AD Carry")) {
	$Ad_name[$Ad_inx] = $data[0];
	$Ad_per[$Ad_inx++] = (int)$data[2];
      }
      if ( !strcmp($flag ,"Support")) {
	$Sup_name[$Sup_inx] = $data[0];
	$Sup_per[$Sup_inx++] = (int)$data[2];
      }
    }
  }
  fclose($fp);
}

function intersec ($index, $name, $per) {

  global $target;
  
  $max_sum = -999;

  for( $i = 0; $i < $index; $i++){
    $count = 0;
    $sum = $per[$i];
    
    for( $j = 0 ; $j < $index ; $j++){
     if( $name[$i] == $name[$j] ) {
	$count++;
        if ( $i != $j ) {
	  $sum = $sum + $per[$j];
	}
      }
    }
    if($count == $target) {
      if ($sum > $max_sum) {
	$max_sum = $sum;
	$result_name = $name[$i];
      }
    }
  }
  return $result_name;
}

Make_DB($TOP);
Make_DB($JUNGLE);
Make_DB($MID);
Make_DB($AD);
Make_DB($SUP);

$Result_TOP = intersec($Top_inx, $Top_name, $Top_per);
$Result_JUNGLE = intersec($Jungle_inx, $Jungle_name, $Jungle_per);
$Result_MID = intersec($Mid_inx, $Mid_name, $Mid_per);
$Result_AD = intersec($Ad_inx, $Ad_name, $Ad_per);
$Result_SUP = intersec($Sup_inx, $Sup_name, $Sup_per);

$img_path = "/~cse20141563/public_html/img/";

if ($Result_TOP) {
  $Result_TOP = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$Result_TOP);
  $Result_TOP = strtolower($Result_TOP);
}
else if ( !$Result_TOP ) $Result_TOP = $TOP;

if ($Result_JUNGLE) {
  $Result_JUNGLE = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$Result_JUNGLE);
  $Result_JUNGLE = strtolower($Result_JUNGLE);
} else if( !$Result_JUNGLE) $Result_JUNGLE = $JUNGLE;

if ($Result_MID) {
  $Result_MID = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$Result_MID);
  $Result_MID = strtolower($Result_MID);
} else if( !$Result_MID) $Result_MID = $MID;

if ($Result_AD) {
  $Result_AD = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$Result_AD);
  $Result_AD = strtolower($Result_AD);
} else if( !$Result_AD ) $Result_AD = $AD;

if ($Result_SUP) {
  $Result_SUP = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "",$Result_SUP);
  $Result_SUP = strtolower($Result_SUP);
} else if (!$Result_SUP) $Result_SUP = $SUP;

?>

<table class = "type02">
<thead>
<tr> 
<td> <img src = "/~cse20141563/img/<?=$Result_TOP?>.png" onerror="this.style.display='none'" alt=""/ > </td>
<td> <img src = "/~cse20141563/img/<?=$Result_JUNGLE?>.png" onerror="this.style.display='none'" alt=""/> </td>
<td> <img src = "/~cse20141563/img/<?=$Result_MID?>.png" onerror="this.style.display='none'" alt=""/ > </td>
<td> <img src = "/~cse20141563/img/<?=$Result_AD?>.png" onerror="this.style.display='none'" alt=""/ > </td>
<td> <img src = "/~cse20141563/img/<?=$Result_SUP?>.png" onerror="this.style.display='none'" alt=""/ > </td>
</tr>

<tr>
<td > <?=$Result_TOP?> </td>
<td> <?=$Result_JUNGLE?> </td>
<td> <?=$Result_MID?> </td>
<td> <?=$Result_AD?> </td>
<td> <?=$Result_SUP?> </td>

</thead>


