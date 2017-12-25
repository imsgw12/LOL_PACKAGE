<html class="Contest_Info2">
<body class="Contest_Info2">
<link rel=stylesheet href='../Ungold_Contest_Info_Php.css?ver=1' type='text/css'>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">



<?php

include_once 'Snoopy.class.php';
include_once 'simple_html_dom.php';

$q = $_REQUEST["q"];

//echo $q;


$snoopy = new snoopy;
$snoopy->fetch("http://lol.inven.co.kr/dataninfo/match/teamList.php?teams=217");
$txt = $snoopy->results;
//$rex="/\<a href=\"http://news.naver.com/\" class=\"cl_a cl_news\" data-clk=\"ncy.newshome\"\>(.*)\<\/a\>/";
//$rex="/\<option value=\"nexearch\"\>(.*)\<\/option\>/";
//$rex = '/<legend class="blind">(.*?)<\/legend>/is'
//$rex="/\<div class=\"area_layout.+\"\>(.*)\<\/div\>/";
//$rex="/\<div class=\"area_layout.+\"\>(.*)\<\/div\>/";
preg_match_all('/<div class="date">(.*?)<\/div>/is', $snoopy->results, $text1);
//preg_match_all($rex,$txt,$o);
//priint_r($o);
//print_r($txt);
//echo $text1[0][0];
preg_match_all('/<div class="title">(.*?)<\/div>/is', $snoopy->results, $text2);
preg_match_all('/<div class="stage">(.*?)<\/div>/is', $snoopy->results, $text3);
preg_match_all('/<span class="tx4">(.*?)<\/span>/is', $snoopy->results, $text4);
//$text11 = $text1[0][0]
//$text22 = $text2[0][0]

//table making
//echo "<table class=\"type01\">";
//echo "<tr><td>$text11</td><td>$text22</td></tr>";
//echo "</table>";

$addr = "http://lol.inven.co.kr/dataninfo/match/teamList.php?teams=". $q;

$html = file_get_html($addr);

//foreach($html->find('img') as $element) 
//echo $element->src . '<br>';
//echo $html->plaintext;
 
foreach($html->find('div.listFrame') as $article) {
$item['contest_date'] = $article->find('div.date', 0)->plaintext;
$item['title'] = $article->find('div.title', 0)->plaintext;
$item['stage'] = $article->find('div.stage', 0)->plaintext;


$item['tx4'] = $article->find('span.tx4', 0)->plaintext;
$contest_info[] = $item;
}

foreach($html->find('div.wTeam') as $article) {
$item['teamname'] = $article->find('a.teamname', 0)->plaintext;
//$item['color1 tx5'] = $article->find('div.color1 tx5', 0)->plaintext;


$team_w_info[] = $item;
}

foreach($html->find('div.lTeam') as $article) {
$item['teamname'] = $article->find('a.teamname', 0)->plaintext;
//$item['color2 tx5'] = $article->find('div.color2 tx5', 0)->plaintext;


$team_l_info[] = $item;
}

?>
<div class="container">
<table class="contest_info">
<thead class="contest_info">
<tr>
        <th scope="cols" class="contest_info">대회 날짜</th>
        <th scope="cols" class="contest_info">대회 타이틀</th>
        <th scope="cols" class="contest_info">대회 스테이지</th>
        <th scope="cols" class="contest_info">블루팀</th>
        <th scope="cols" class="contest_info">레드팀</th>
        <th scope="cols" class="contest_info">킬 스코어</th>
</tr>
</thead>

<tbody class="contest_info">
<SCRIPT language="JavaScript">


var contest_info = <?php echo json_encode($contest_info)?>;
var team_w_info = <?php echo json_encode($team_w_info)?>;
var team_l_info = <?php echo json_encode($team_l_info)?>;

//for (var i=0; i<6; i++){
for (var i=0; i<contest_info.length; i++){
document.write("<tr class=\"contest_info\">");

document.write("<td class=\"contest_info\">");
var value = contest_info[i]["contest_date"];
document.write(value);
document.write("</td>");

document.write("<td class=\"contest_info\">");
value = contest_info[i]["title"];
document.write(value);
document.write("</td>");

document.write("<td class=\"contest_info\">");
value = contest_info[i]["stage"];
document.write(value);
document.write("</td>");

document.write("<td class=\"contest_info\">");
value = team_w_info[i]["teamname"];
document.write(value);
document.write("</td>");

document.write("<td class=\"contest_info\">");
value = team_l_info[i]["teamname"];
document.write(value);
document.write("</td>");

document.write("<td class=\"contest_info\">");
value = contest_info[i]["tx4"];
document.write(value);
document.write("</td>");

document.write("</tr>");
}

</SCRIPT>
<tr class="contest_info">
<td class="contest_info">
<a class="button1" href='../Ungold_Contest_Info.html'>Back</a>
</tr>
</td>
</tbody>
</table>
</div>
<!--
</table>

<table class="type01">
    <thead>
    <tr>
        <th scope="cols">타이틀</th>
        <th scope="cols">내용</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">항목명</th>
        <td>내용이 들어갑니다.</td>
    </tr>
    <tr>
        <th scope="row" class="even">항목명</th>
        <td class="even">내용이 들어갑니다.</td>
    </tr>
    <tr>
        <th scope="row">항목명</th>
        <td>내용이 들어갑니다.</td>
    </tr>
    </tbody>
</table>
-->


</body>
</html>
