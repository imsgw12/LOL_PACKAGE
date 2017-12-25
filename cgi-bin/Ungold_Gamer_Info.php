<html class="Contest_Gamer">
<body class="Contest_Gamer2">
<link rel=stylesheet href='../Ungold_Gamer_Info.css?ver=1' type='text/css'>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<?php

include_once 'Snoopy.class.php';
include_once 'simple_html_dom.php';

$q = $_REQUEST["q"];

//echo $q;

$addr = "http://lol.inven.co.kr/dataninfo/match/teamList.php?teams=" . $q;

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

$html = file_get_html($addr);

//foreach($html->find('img') as $element) 
//echo $element->src . '<br>';
//echo $html->plaintext;
 
foreach($html->find('div.listFrame') as $article) {
$item1['contest_date'] = $article->find('div.date', 0)->plaintext;
$item1['title'] = $article->find('div.title', 0)->plaintext;
$item1['stage'] = $article->find('div.stage', 0)->plaintext;


$item1['tx4'] = $article->find('span.tx4', 0)->plaintext;
$contest_info[] = $item1;
}

foreach($html->find('div.wTeam') as $article) {
$item2['teamname'] = $article->find('a.teamname', 0)->plaintext;
//$item['color1 tx5'] = $article->find('div.color1 tx5', 0)->plaintext;


$team_w_info[] = $item2;
}

foreach($html->find('div.lTeam') as $article) {
$item3['teamname'] = $article->find('a.teamname', 0)->plaintext;
//$item['color2 tx5'] = $article->find('div.color2 tx5', 0)->plaintext;


$team_l_info[] = $item3;
//print_r($team_l_info);
}

$addr = "http://lol.inven.co.kr/dataninfo/proteam/proteam.php?code=" . $q . "&iskin=lol";

$html = file_get_html($addr);

//print_r($html->plaintext);

foreach($html->find('td') as $article) {
//$item['teamgamer'] = $article->find('td', 0)->plaintext;
//$item['color2 tx5'] = $article->find('div.color2 tx5', 0)->plaintext;
//echo $article->plaintext . '</br>';

$item4['gamer'] = $article->plaintext;
$gamer_info[] = $item4;
//$team_gamer_info[] = $item;

//print_r($team_gamer_info);
}

foreach($html->find('td.name') as $article) {
//$item['teamgamer'] = $article->find('td', 0)->plaintext;
//$item['color2 tx5'] = $article->find('div.color2 tx5', 0)->plaintext;
//echo $article->plaintext . '</br>';

$item4['gamer_divide'] = $article->plaintext;
$gamer_divide_info[] = $item4;
//$team_gamer_info[] = $item;

//print_r($team_gamer_info);
}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	// 차트를 사용하기 위한 준비입니다.
	google.charts.load('current', {packages:['corechart']});
</script>

<table class="Contest_Gamer">
<thead class="Contest_Gamer">
<tr class="Contest_Gamer">
        <!--<th scope="cols">포지션</th>-->
        <th class="Contest_Gamer">Name</th>
        <th class="Contest_Gamer">NickName</th>
        <th class="Contest_Gamer">Game</th>
        <th class="Contest_Gamer">Win</th>
        <th class="Contest_Gamer">Lose</th>
        <th class="Contest_Gamer">Total Kill</th>
        <th class="Contest_Gamer">Total Death</th>
        <th class="Contest_Gamer">Total Assist</th>
        <th class="Contest_Gamer">Kill Per Game</th>
        <th class="Contest_Gamer">Death Per Game</th>
        <th class="Contest_Gamer">Assist Per Game</th>
        <th class="Contest_Gamer">KDA</th>
        <th class="Contest_Gamer">Kill Involvement</th>
</tr>
</thead>

<tbody class="Contest_Gamer">
<SCRIPT language="JavaScript">


var contest_info = <?php echo json_encode($contest_info)?>;
var team_w_info = <?php echo json_encode($team_w_info)?>;
var team_l_info = <?php echo json_encode($team_l_info)?>;
var team_gamer_info = <?php echo json_encode($gamer_info)?>;
var team_divide_info = <?php echo json_encode($gamer_divide_info)?>;
var q = <?php echo $q;?>;

var i = 12;
//while (i < 20){
while (i < team_gamer_info.length){
document.write("<tr class=\"Contest_Gamer\">");


/*if (team_gamer_info[i]["gamer"] == "")
	i++;
document.write("<td>");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;*/

if (team_gamer_info[i]["gamer"] == "")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];

//document.write("<button>");
document.write("<a class=\"btn btn-three\" href=");
document.write("\'Ungold_Get_Video.php?q=");
document.write(team_gamer_info[i + 1]["gamer"]);
document.write(" ");
document.write(q);
document.write("\'>");
document.write(value);
document.write("</a>");
//<button id='back' onclick ="location.href='../Ungold_Contest_Info.html'"><img src="http://pds.inven.co.kr/upload/2016/01/04/intro/i13247536708.jpg"></button>

document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


if (team_gamer_info[i]["gamer"] == "a")
	i++;
document.write("<td class=\"Contest_Gamer\">");
var value = team_gamer_info[i]["gamer"];
document.write(value);
document.write("</td>");
i++;


document.write("</tr>");

if (team_gamer_info[i]["gamer"] == team_divide_info[0]["gamer_divide"])
	break;

}

</SCRIPT>
<tr class="Contest_Gamer">
<td class="Contest_Gamer">
<a class="button1" href='../Ungold_Contest_Info.html'>Back</a>
</td>
</tr>
</tbody>
</table>
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
