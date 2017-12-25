<html class="Link_Info">
<head>
<link rel="stylesheet" href="../Ungold_Get_Video.css?ver=1">
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
</head>
<body class="main">


<?php

include_once 'simple_html_dom.php';

//echo ("MySQL - PHP Connect Test <br/>");

//parameter getting new version
$q = $_REQUEST["q"];
//$q = test_input($q);
$q = explode(' ', $q);

//$search_value = $q[0];


$addr = "http://www.inven.co.kr/board/powerbbs.php?name=subject&keyword=" . $q[1] . "&x=0&y=0&come_idx=2959&iskin=&mskin=&p=1&query=list&my=&category=&sort=PID&orderby=&sterm=";



//echo $addr;

$html = file_get_html($addr);

//print_r($html->plaintext);

//print $html->plaintext;

foreach($html->find('a.sj_ln') as $article) {
//$item['teamgamer'] = $article->find('td', 0)->plaintext;
//$item['color2 tx5'] = $article->find('div.color2 tx5', 0)->plaintext;
//echo $article->plaintext . '</br>';

//echo $article->href;
//echo $article->plaintext;
$item['link'] = $article->href;
$item['title'] = $article->plaintext;
$video_info[] = $item;
//$team_gamer_info[] = $item;

//print_r($team_gamer_info);
}

 
?>

<SCRIPT language="JavaScript">

var video_info = <?php echo json_encode($video_info)?>;

for (i = 1; i < video_info.length; i++){
	
	document.write("<a class=\"button1\" href=\"");
	document.write(video_info[i]['link']);
	document.write("\">");
	document.write(video_info[i]['title']);
	document.write("</a></br>");

}

</SCRIPT>

<a class = "button" href='Ungold_Gamer_Info.php?q=<?php echo $q[2];?>'>Back</a>


</body>
</html>
