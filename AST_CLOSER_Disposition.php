<? 

# PERFECT NETWORK CORP - CLOSER DISPOSITION
# http://www.perfectnetworkcorp.com

require("../My%20Documents/Websites/PNC%20Dialer%20Version%202/pncdial/dbconnect.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["group"]))				{$group=$_GET["group"];}
	elseif (isset($_POST["group"]))		{$group=$_POST["group"];}
if (isset($_GET["query_date"]))				{$query_date=$_GET["query_date"];}
	elseif (isset($_POST["query_date"]))		{$query_date=$_POST["query_date"];}
if (isset($_GET["submit"]))				{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))		{$submit=$_POST["submit"];}
if (isset($_GET["SUBMIT"]))				{$SUBMIT=$_GET["SUBMIT"];}
	elseif (isset($_POST["SUBMIT"]))		{$SUBMIT=$_POST["SUBMIT"];}

$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);

	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 6;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$auth=$row[0];

  if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or (!$auth))
	{
    Header("WWW-Authenticate: Basic realm=\"VICIDIAL CLOSER DISPOSITION\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Invalid Username/Password: |$PHP_AUTH_USER|$PHP_AUTH_PW|\n";
    exit;
	}

$NOW_DATE = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s");
$STARTtime = date("U");
if (!isset($group)) {$group = '';}
if (!isset($query_date)) {$query_date = $NOW_DATE;}

$stmt="select group_id from vicidial_inbound_groups;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$groups_to_print = mysql_num_rows($rslt);
$i=0;
while ($i < $groups_to_print)
	{
	$row=mysql_fetch_row($rslt);
	$groups[$i] =$row[0];
	$i++;
	}
?>

<HTML>
<HEAD>
<STYLE type="text/css">
<!--
   .green {color: white; background-color: green}
   .red {color: white; background-color: red}
   .blue {color: white; background-color: blue}
   .purple {color: white; background-color: purple}
-->
 </STYLE>

<? 
echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">\n";
echo "<TITLE>VICIDIAL: Closer Disposition</TITLE></HEAD><BODY BGCOLOR=WHITE>\n";
echo "<FORM ACTION=\"$PHP_SELF\" METHOD=GET>\n";
echo "<INPUT TYPE=TEXT NAME=query_date SIZE=10 MAXLENGTH=10 VALUE=\"$query_date\">\n";
echo "<SELECT SIZE=1 NAME=group>\n";
	$o=0;
	while ($groups_to_print > $o)
	{
		if ($groups[$o] == $group) {echo "<option selected value=\"$groups[$o]\">$groups[$o]</option>\n";}
		  else {echo "<option value=\"$groups[$o]\">$groups[$o]</option>\n";}
		$o++;
	}
echo "</SELECT>\n";
echo "<INPUT TYPE=submit NAME=SUBMIT VALUE=SUBMIT>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href=\"./admin.php?ADD=3111&group_id=$group\">MODIFY</a> | <a href=\"./server_stats.php\">REPORTS</a> </FONT>\n";
echo "</FORM>\n\n";

echo "<PRE><FONT SIZE=2>\n\n";

if (!$group)
{
echo "\n\n";
echo "PLEASE SELECT A CAMPAIGN AND DATE ABOVE AND CLICK SUBMIT\n";
}

else
{

##############################
#########  USER STATS

echo "\n";
echo "CLOSER DISPOSITION:\n";
echo "+----------+-----------------------+------------------------------+------------+-------+-------------+-------------+--------+---------+\n";
echo "|  AGENT   |     CLIENTS NAME      |           ADDRESS            |    CITY    | STATE | PHONENUMBER | CAMPAIGN_ID | STATUS | LEAD ID |\n";
echo "+----------+-----------------------+------------------------------+------------+-------+-------------+-------------+--------+---------+\n";

$stmt="SELECT 
vicidial_closer_log.user,
vicidial_closer_log.phone_number,
vicidial_closer_log.campaign_id,
vicidial_list.lead_id,
vicidial_list.first_name,
vicidial_list.last_name,
vicidial_list.address1,
vicidial_list.city,
vicidial_list.state,
vicidial_list.status,
vicidial_closer_log.lead_id
FROM
vicidial_list,
vicidial_closer_log
WHERE
vicidial_closer_log.list_id = 999
AND
call_date >= '$query_date 00:00:01' and call_date <= '$query_date 23:59:59'
AND
campaign_id='" . mysql_real_escape_string($group) . "'
AND
vicidial_closer_log.phone_number = vicidial_list.phone_number
order by vicidial_closer_log.user;";


$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$users_to_print = mysql_num_rows($rslt);
$i=0;
while ($i < $users_to_print)
	{
	$row=mysql_fetch_row($rslt);

	$user =	sprintf("%-8s", $row[0]);
	$phone_number =	sprintf("%-11s", $row[1]);
	$campaign_id =	$row[2];
	$first_name = sprintf("%-10.10s", $row[4]);
	$last_name = sprintf("%-10.10s", $row[5]);
	$address1 = sprintf("%-28.28s", $row[6]);
	$city = sprintf("%-10.10s", $row[7]);
	$state = sprintf("%-5.5s", $row[8]);
    $status =	sprintf("%-6.6s", $row[9]); 
	$lead_id = sprintf("%-7.7s", $row[10]); 

	echo "| $user | $first_name $last_name | $address1 | $city | $state | $phone_number | $campaign_id | $status | $lead_id |\n";
	$i++;
	}
echo "+----------+-----------------------+------------------------------+------------+-------+-------------+-------------+--------+---------+\n";

}

?>
</PRE>
</BODY></HTML>
