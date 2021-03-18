<?php 
# realtime_report.php
# 
# Copyright (C) 2014  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# live real-time stats for the VICIDIAL Auto-Dialer all servers
#
# Rewritten from AST_timeonVDADall.php report to be AJAX and javascript instead 
# of link-driven
#
# * Requires AST_timeonVDADall.php for AJAX-derived stats information
# 
# CHANGELOG:
# 101216-1355 - First Build
# 101218-1520 - Small time reload bug fix and formatting fixes
# 110111-1557 - Added options.php options, minor bug fixes
# 110113-1736 - Small fix
# 110303-2124 - Added agent on-hook phone indication and RING status and color
# 110316-2216 - Added Agent, Carrier and Preset options.php settings
# 110516-2128 - IE fix
# 110526-1807 - Added webphone_auto_answer option
# 120223-1917 - Added multi-user-group options
# 121129-2131 - Fixed Choose link position
# 130414-0247 - Added report logging
# 130610-0944 - Finalized changing of all ereg instances to preg
# 130616-2237 - Added filtering of input to prevent SQL injection attacks and new user auth
# 130901-0858 - Changed to mysqli PHP functions
# 140108-0722 - Added webserver and hostname to report logging
# 140624-1423 - Added droppedOFtotal options.php option
# 141001-2200 - Finalized adding QXZ translation to all admin files
# 141230-0032 - Added code for on-the-fly language translations display
#

$startMS = microtime();

$version = '2.10-17';
$build = '141230-0032';

header ("Content-type: text/html; charset=utf-8");

require("dbconnect_mysqli.php");
require("functions.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
session_start();
$_SESSION['username'] = 'fperdomo';
if (isset($_GET["server_ip"]))			{$server_ip=$_GET["server_ip"];}
	elseif (isset($_POST["server_ip"]))	{$server_ip=$_POST["server_ip"];}
if (isset($_GET["RR"]))					{$RR=$_GET["RR"];}
	elseif (isset($_POST["RR"]))		{$RR=$_POST["RR"];}
if (isset($_GET["inbound"]))			{$inbound=$_GET["inbound"];}
	elseif (isset($_POST["inbound"]))	{$inbound=$_POST["inbound"];}
if (isset($_GET["group"]))				{$group=$_GET["group"];}
	elseif (isset($_POST["group"]))		{$group=$_POST["group"];}
if (isset($_GET["groups"]))				{$groups=$_GET["groups"];}
	elseif (isset($_POST["groups"]))	{$groups=$_POST["groups"];}
if (isset($_GET["usergroup"]))			{$usergroup=$_GET["usergroup"];}
	elseif (isset($_POST["usergroup"]))	{$usergroup=$_POST["usergroup"];}
if (isset($_GET["user_group_filter"]))			{$user_group_filter=$_GET["user_group_filter"];}
	elseif (isset($_POST["user_group_filter"]))	{$user_group_filter=$_POST["user_group_filter"];}
if (isset($_GET["DB"]))					{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))		{$DB=$_POST["DB"];}
if (isset($_GET["adastats"]))			{$adastats=$_GET["adastats"];}
	elseif (isset($_POST["adastats"]))	{$adastats=$_POST["adastats"];}
if (isset($_GET["submit"]))				{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))	{$submit=$_POST["submit"];}
if (isset($_GET["SUBMIT"]))				{$SUBMIT=$_GET["SUBMIT"];}
	elseif (isset($_POST["SUBMIT"]))	{$SUBMIT=$_POST["SUBMIT"];}
if (isset($_GET["SIPmonitorLINK"]))				{$SIPmonitorLINK=$_GET["SIPmonitorLINK"];}
	elseif (isset($_POST["SIPmonitorLINK"]))	{$SIPmonitorLINK=$_POST["SIPmonitorLINK"];}
if (isset($_GET["IAXmonitorLINK"]))				{$IAXmonitorLINK=$_GET["IAXmonitorLINK"];}
	elseif (isset($_POST["IAXmonitorLINK"]))	{$IAXmonitorLINK=$_POST["IAXmonitorLINK"];}
if (isset($_GET["UGdisplay"]))			{$UGdisplay=$_GET["UGdisplay"];}
	elseif (isset($_POST["UGdisplay"]))	{$UGdisplay=$_POST["UGdisplay"];}
if (isset($_GET["UidORname"]))			{$UidORname=$_GET["UidORname"];}
	elseif (isset($_POST["UidORname"]))	{$UidORname=$_POST["UidORname"];}
if (isset($_GET["orderby"]))			{$orderby=$_GET["orderby"];}
	elseif (isset($_POST["orderby"]))	{$orderby=$_POST["orderby"];}
if (isset($_GET["SERVdisplay"]))			{$SERVdisplay=$_GET["SERVdisplay"];}
	elseif (isset($_POST["SERVdisplay"]))	{$SERVdisplay=$_POST["SERVdisplay"];}
if (isset($_GET["CALLSdisplay"]))			{$CALLSdisplay=$_GET["CALLSdisplay"];}
	elseif (isset($_POST["CALLSdisplay"]))	{$CALLSdisplay=$_POST["CALLSdisplay"];}
if (isset($_GET["PHONEdisplay"]))			{$PHONEdisplay=$_GET["PHONEdisplay"];}
	elseif (isset($_POST["PHONEdisplay"]))	{$PHONEdisplay=$_POST["PHONEdisplay"];}
if (isset($_GET["CUSTPHONEdisplay"]))			{$CUSTPHONEdisplay=$_GET["CUSTPHONEdisplay"];}
	elseif (isset($_POST["CUSTPHONEdisplay"]))	{$CUSTPHONEdisplay=$_POST["CUSTPHONEdisplay"];}
if (isset($_GET["NOLEADSalert"]))			{$NOLEADSalert=$_GET["NOLEADSalert"];}
	elseif (isset($_POST["NOLEADSalert"]))	{$NOLEADSalert=$_POST["NOLEADSalert"];}
if (isset($_GET["DROPINGROUPstats"]))			{$DROPINGROUPstats=$_GET["DROPINGROUPstats"];}
	elseif (isset($_POST["DROPINGROUPstats"]))	{$DROPINGROUPstats=$_POST["DROPINGROUPstats"];}
if (isset($_GET["ALLINGROUPstats"]))			{$ALLINGROUPstats=$_GET["ALLINGROUPstats"];}
	elseif (isset($_POST["ALLINGROUPstats"]))	{$ALLINGROUPstats=$_POST["ALLINGROUPstats"];}
if (isset($_GET["with_inbound"]))			{$with_inbound=$_GET["with_inbound"];}
	elseif (isset($_POST["with_inbound"]))	{$with_inbound=$_POST["with_inbound"];}
if (isset($_GET["monitor_active"]))				{$monitor_active=$_GET["monitor_active"];}
	elseif (isset($_POST["monitor_active"]))	{$monitor_active=$_POST["monitor_active"];}
if (isset($_GET["monitor_phone"]))				{$monitor_phone=$_GET["monitor_phone"];}
	elseif (isset($_POST["monitor_phone"]))		{$monitor_phone=$_POST["monitor_phone"];}
if (isset($_GET["CARRIERstats"]))			{$CARRIERstats=$_GET["CARRIERstats"];}
	elseif (isset($_POST["CARRIERstats"]))	{$CARRIERstats=$_POST["CARRIERstats"];}
if (isset($_GET["PRESETstats"]))			{$PRESETstats=$_GET["PRESETstats"];}
	elseif (isset($_POST["PRESETstats"]))	{$PRESETstats=$_POST["PRESETstats"];}
if (isset($_GET["AGENTtimeSTATS"]))				{$AGENTtimeSTATS=$_GET["AGENTtimeSTATS"];}
	elseif (isset($_POST["AGENTtimeSTATS"]))	{$AGENTtimeSTATS=$_POST["AGENTtimeSTATS"];}
if (isset($_GET["droppedOFtotal"]))				{$droppedOFtotal=$_GET["droppedOFtotal"];}
	elseif (isset($_POST["droppedOFtotal"]))	{$droppedOFtotal=$_POST["droppedOFtotal"];}
if (isset($_GET["collapseOne"]))				{$collapseOne=$_GET["collapseOne"];}
	elseif (isset($_POST["collapseOne"]))	{$collapseOne=$_POST["collapseOne"];}
if (isset($_GET["collapseTwo"]))				{$collapseTwo=$_GET["collapseTwo"];}
	elseif (isset($_POST["collapseTwo"]))	{$collapseTwo=$_POST["collapseTwo"];}
if (isset($_GET["collapseThree"]))				{$collapseThree=$_GET["collapseThree"];}
	elseif (isset($_POST["collapseThree"]))	{$collapseThree=$_POST["collapseThree"];}
if (isset($_GET["collapseFour"]))				{$collapseFour=$_GET["collapseFour"];}
	elseif (isset($_POST["collapseFour"]))	{$collapseFour=$_POST["collapseFour"];}

$edit = false;
if ($_GET['edit'] == 'true')
  $edit = true;
$report_name = 'Real-Time Main Report';
$db_source = 'M';

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,outbound_autodial_active,slave_db_server,reports_use_slave_db,enable_languages,language_method FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =					$row[0];
	$outbound_autodial_active =		$row[1];
	$slave_db_server =				$row[2];
	$reports_use_slave_db =			$row[3];
	$SSenable_languages =			$row[4];
	$SSlanguage_method =			$row[5];
	}
##### END SETTINGS LOOKUP #####
###########################################

$webphone_width =	'460';
$webphone_height =	'500';
$webphone_left =	'600';
$webphone_top =		'27';
$webphone_bufw =	'250';
$webphone_bufh =	'1';
$webphone_pad =		'10';
$webphone_clpos =	"<BR>  &nbsp; <a href=\"#\" onclick=\"hideDiv('webphone_content');\">"._QXZ("webphone")." -</a>";

if (file_exists('options.php'))
	{
	require('options.php');
	}

if (!isset($DB)) 
	{
	if (!isset($RS_DB)) {$DB=0;}
	else {$DB = $RS_DB;}
	}
if (!isset($RR)) 
	{
	if (!isset($RS_RR)) {$RR=40;}
	else {$RR = $RS_RR;}
	}
if (!isset($group)) 
	{
	if (!isset($RS_group)) {$group='ALL-ACTIVE';}
	else {$group = $RS_group;}
	}
if (!isset($usergroup)) 
	{
	if (!isset($RS_usergroup)) {$usergroup='';}
	else {$usergroup = $RS_usergroup;}
	}
if (!isset($UGdisplay)) 
	{
	if (!isset($RS_UGdisplay)) {$UGdisplay=0;}
	else {$UGdisplay = $RS_UGdisplay;}
	}
if (!isset($UidORname)) 
	{
	if (!isset($RS_UidORname)) {$UidORname=1;}
	else {$UidORname = $RS_UidORname;}
	}
if (!isset($orderby)) 
	{
	if (!isset($RS_orderby)) {$orderby='timeup';}
	else {$orderby = $RS_orderby;}
	}
if (!isset($SERVdisplay)) 
	{
	if (!isset($RS_SERVdisplay)) {$SERVdisplay=0;}
	else {$SERVdisplay = $RS_SERVdisplay;}
	}
if (!isset($CALLSdisplay)) 
	{
	if (!isset($RS_CALLSdisplay)) {$CALLSdisplay=1;}
	else {$CALLSdisplay = $RS_CALLSdisplay;}
	}
if (!isset($PHONEdisplay)) 
	{
	if (!isset($RS_PHONEdisplay)) {$PHONEdisplay=0;}
	else {$PHONEdisplay = $RS_PHONEdisplay;}
	}
if (!isset($CUSTPHONEdisplay)) 
	{
	if (!isset($RS_CUSTPHONEdisplay)) {$CUSTPHONEdisplay=0;}
	else {$CUSTPHONEdisplay = $RS_CUSTPHONEdisplay;}
	}
if (!isset($PAUSEcodes)) 
	{
	if (!isset($RS_PAUSEcodes)) {$PAUSEcodes='N';}
	else {$PAUSEcodes = $RS_PAUSEcodes;}
	}
if (!isset($with_inbound)) 
	{
	if (!isset($RS_with_inbound))	
		{
		if ($outbound_autodial_active > 0)
			{$with_inbound='Y';}  # N=no, Y=yes, O=only
		else
			{$with_inbound='O';}  # N=no, Y=yes, O=only
		}
	else {$with_inbound = $RS_with_inbound;}
	}
if (!isset($CARRIERstats)) 
	{
	if (!isset($RS_CARRIERstats)) {$CARRIERstats='0';}
	else {$CARRIERstats = $RS_CARRIERstats;}
	}
if (!isset($PRESETstats)) 
	{
	if (!isset($RS_PRESETstats)) {$PRESETstats='0';}
	else {$PRESETstats = $RS_PRESETstats;}
	}
if (!isset($AGENTtimeSTATS)) 
	{
	if (!isset($RS_AGENTtimeSTATS)) {$AGENTtimeSTATS='0';}
	else {$AGENTtimeSTATS = $RS_AGENTtimeSTATS;}
	}
if (!isset($droppedOFtotal)) 
	{
	if (!isset($RS_droppedOFtotal)) {$droppedOFtotal='0';}
	else {$droppedOFtotal = $RS_droppedOFtotal;}
	}

$ingroup_detail='';

if ( (strlen($group)>1) and (strlen($groups[0])<1) ) {$groups[0] = $group;}
else {$group = $groups[0];}

$NOW_TIME = date("Y-m-d H:i:s");
$NOW_DAY = date("Y-m-d");
$NOW_HOUR = date("H:i:s");
$STARTtime = date("U");
$epochONEminuteAGO = ($STARTtime - 60);
$timeONEminuteAGO = date("Y-m-d H:i:s",$epochONEminuteAGO);
$epochFIVEminutesAGO = ($STARTtime - 300);
$timeFIVEminutesAGO = date("Y-m-d H:i:s",$epochFIVEminutesAGO);
$epochFIFTEENminutesAGO = ($STARTtime - 900);
$timeFIFTEENminutesAGO = date("Y-m-d H:i:s",$epochFIFTEENminutesAGO);
$epochONEhourAGO = ($STARTtime - 3600);
$timeONEhourAGO = date("Y-m-d H:i:s",$epochONEhourAGO);
$epochSIXhoursAGO = ($STARTtime - 21600);
$timeSIXhoursAGO = date("Y-m-d H:i:s",$epochSIXhoursAGO);
$epochTWENTYFOURhoursAGO = ($STARTtime - 86400);
$timeTWENTYFOURhoursAGO = date("Y-m-d H:i:s",$epochTWENTYFOURhoursAGO);
$webphone_content='';

if ($non_latin < 1)
	{
	$PHP_AUTH_USER = preg_replace('/[^-_0-9a-zA-Z]/', '', $PHP_AUTH_USER);
	$PHP_AUTH_PW = preg_replace('/[^-_0-9a-zA-Z]/', '', $PHP_AUTH_PW);
	}
else
	{
	$PHP_AUTH_PW = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_PW);
	$PHP_AUTH_USER = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_USER);
	}
$RR = preg_replace('/[^0-9]/', '', $RR);
$inbound = preg_replace('/[^-_0-9a-zA-Z]/', '', $inbound);
$group = preg_replace('/[^-_0-9a-zA-Z]/', '', $group);
$groups[0] = preg_replace('/[^-_0-9a-zA-Z]/', '', $groups[0]);
$usergroup = preg_replace('/[^-_0-9a-zA-Z]/', '', $usergroup);
$DB = preg_replace('/[^0-9]/', '', $DB);
$adastats = preg_replace('/[^-_0-9a-zA-Z]/', '', $adastats);
$SIPmonitorLINK = preg_replace('/[^-_0-9a-zA-Z]/', '', $SIPmonitorLINK);
$IAXmonitorLINK = preg_replace('/[^-_0-9a-zA-Z]/', '', $IAXmonitorLINK);
$UGdisplay = preg_replace('/[^-_0-9a-zA-Z]/', '', $UGdisplay);
$UidORname = preg_replace('/[^-_0-9a-zA-Z]/', '', $UidORname);
$orderby = preg_replace('/[^-_0-9a-zA-Z]/', '', $orderby);
$SERVdisplay = preg_replace('/[^-_0-9a-zA-Z]/', '', $SERVdisplay);
$CALLSdisplay = preg_replace('/[^-_0-9a-zA-Z]/', '', $CALLSdisplay);
$PHONEdisplay = preg_replace('/[^-_0-9a-zA-Z]/', '', $PHONEdisplay);
$CUSTPHONEdisplay = preg_replace('/[^-_0-9a-zA-Z]/', '', $CUSTPHONEdisplay);
$NOLEADSalert = preg_replace('/[^-_0-9a-zA-Z]/', '', $NOLEADSalert);
$DROPINGROUPstats = preg_replace('/[^-_0-9a-zA-Z]/', '', $DROPINGROUPstats);
$ALLINGROUPstats = preg_replace('/[^-_0-9a-zA-Z]/', '', $ALLINGROUPstats);
$with_inbound = preg_replace('/[^-_0-9a-zA-Z]/', '', $with_inbound);
$monitor_active = preg_replace('/[^-_0-9a-zA-Z]/', '', $monitor_active);
$monitor_phone = preg_replace('/[^-_0-9a-zA-Z]/', '', $monitor_phone);
$CARRIERstats = preg_replace('/[^-_0-9a-zA-Z]/', '', $CARRIERstats);
$PRESETstats = preg_replace('/[^-_0-9a-zA-Z]/', '', $PRESETstats);
$AGENTtimeSTATS = preg_replace('/[^-_0-9a-zA-Z]/', '', $AGENTtimeSTATS);
$droppedOFtotal = preg_replace('/[^-_0-9a-zA-Z]/', '', $droppedOFtotal);

$stmt="SELECT selected_language from vicidial_users where user='$PHP_AUTH_USER';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$sl_ct = mysqli_num_rows($rslt);
if ($sl_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$VUselected_language =		$row[0];
	}

$auth=0;
$reports_auth=0;
$admin_auth=0;
$auth_message = user_authorization($PHP_AUTH_USER,$PHP_AUTH_PW,'REPORTS',1, 0);
if ($auth_message == 'GOOD')
	{$auth=1;}

if ($auth > 0)
	{
	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 7 and view_reports > 0;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$admin_auth=$row[0];

	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and user_level > 6 and view_reports > 0;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$reports_auth=$row[0];

	if ($reports_auth < 1)
		{
		$VDdisplayMESSAGE = _QXZ("You are not allowed to view reports");
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	if ( ($reports_auth > 0) and ($admin_auth < 1) )
		{
		$ADD=999999;
		$reports_only_user=1;
		}
	}
else
	{
	$VDdisplayMESSAGE = _QXZ("Login incorrect, please try again");
	if ($auth_message == 'LOCK')
		{
		$VDdisplayMESSAGE = _QXZ("Too many login attempts, try again in 15 minutes");
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$PHP_AUTH_PW|$auth_message|\n";
	exit;
	}
 
##### BEGIN log visit to the vicidial_report_log table #####
$LOGip = getenv("REMOTE_ADDR");
$LOGbrowser = getenv("HTTP_USER_AGENT");
$LOGscript_name = getenv("SCRIPT_NAME");
$LOGserver_name = getenv("SERVER_NAME");
$LOGserver_port = getenv("SERVER_PORT");
$LOGrequest_uri = getenv("REQUEST_URI");
$LOGhttp_referer = getenv("HTTP_REFERER");
if (preg_match("/443/i",$LOGserver_port)) {$HTTPprotocol = 'https://';}
  else {$HTTPprotocol = 'http://';}
if (($LOGserver_port == '80') or ($LOGserver_port == '443') ) {$LOGserver_port='';}
else {$LOGserver_port = ":$LOGserver_port";}
$LOGfull_url = "$HTTPprotocol$LOGserver_name$LOGserver_port$LOGrequest_uri";

$LOGhostname = php_uname('n');
if (strlen($LOGhostname)<1) {$LOGhostname='X';}
if (strlen($LOGserver_name)<1) {$LOGserver_name='X';}

$stmt="SELECT webserver_id FROM vicidial_webservers where webserver='$LOGserver_name' and hostname='$LOGhostname' LIMIT 1;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$webserver_id_ct = mysqli_num_rows($rslt);
if ($webserver_id_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$webserver_id = $row[0];
	}
else
	{
	##### insert webserver entry
	$stmt="INSERT INTO vicidial_webservers (webserver,hostname) values('$LOGserver_name','$LOGhostname');";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$affected_rows = mysqli_affected_rows($link);
	$webserver_id = mysqli_insert_id($link);
	}

$stmt="INSERT INTO vicidial_report_log set event_date=NOW(), user='$PHP_AUTH_USER', ip_address='$LOGip', report_name='$report_name', browser='$LOGbrowser', referer='$LOGhttp_referer', notes='$LOGserver_name:$LOGserver_port $LOGscript_name |$groups[0]|', url='$LOGfull_url', webserver='$webserver_id';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$report_log_id = mysqli_insert_id($link);
##### END log visit to the vicidial_report_log table #####

if ( (strlen($slave_db_server)>5) and (preg_match("/$report_name/",$reports_use_slave_db)) )
	{
	mysqli_close($link);
	$use_slave_server=1;
	$db_source = 'S';
	require("dbconnect_mysqli.php");
	echo "<!-- Using slave server $slave_db_server $db_source -->\n";
	}

if ($auth) 
	{
	$stmt="SELECT user_id,user,pass,full_name,user_level,user_group,phone_login,phone_pass,delete_users,delete_user_groups,delete_lists,delete_campaigns,delete_ingroups,delete_remote_agents,load_leads,campaign_detail,ast_admin_access,ast_delete_phones,delete_scripts,modify_leads,hotkeys_active,change_agent_campaign,agent_choose_ingroups,closer_campaigns,scheduled_callbacks,agentonly_callbacks,agentcall_manual,vicidial_recording,vicidial_transfers,delete_filters,alter_agent_interface_options,closer_default_blended,delete_call_times,modify_call_times,modify_users,modify_campaigns,modify_lists,modify_scripts,modify_filters,modify_ingroups,modify_usergroups,modify_remoteagents,modify_servers,view_reports,vicidial_recording_override,alter_custdata_override,qc_enabled,qc_user_level,qc_pass,qc_finish,qc_commit,add_timeclock_log,modify_timeclock_log,delete_timeclock_log,alter_custphone_override,vdc_agent_api_access,modify_inbound_dids,delete_inbound_dids,active,alert_enabled,download_lists,agent_shift_enforcement_override,manager_shift_enforcement_override,shift_override_flag,export_reports,delete_from_dnc,email,user_code,territory,allow_alerts,callcard_admin,force_change_password,modify_shifts,modify_phones,modify_carriers,modify_labels,modify_statuses,modify_voicemail,modify_audiostore,modify_moh,modify_tts,modify_contacts,modify_same_user_level from vicidial_users where user='$PHP_AUTH_USER';";
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$LOGfull_name				=$row[3];
	$LOGuser_level				=$row[4];
	$LOGuser_group				=$row[5];
	$LOGdelete_users			=$row[8];
	$LOGdelete_user_groups		=$row[9];
	$LOGdelete_lists			=$row[10];
	$LOGdelete_campaigns		=$row[11];
	$LOGdelete_ingroups			=$row[12];
	$LOGdelete_remote_agents	=$row[13];
	$LOGload_leads				=$row[14];
	$LOGcampaign_detail			=$row[15];
	$LOGast_admin_access		=$row[16];
	$LOGast_delete_phones		=$row[17];
	$LOGdelete_scripts			=$row[18];
	$LOGdelete_filters			=$row[29];
	$LOGalter_agent_interface	=$row[30];
	$LOGdelete_call_times		=$row[32];
	$LOGmodify_call_times		=$row[33];
	$LOGmodify_users			=$row[34];
	$LOGmodify_campaigns		=$row[35];
	$LOGmodify_lists			=$row[36];
	$LOGmodify_scripts			=$row[37];
	$LOGmodify_filters			=$row[38];
	$LOGmodify_ingroups			=$row[39];
	$LOGmodify_usergroups		=$row[40];
	$LOGmodify_remoteagents		=$row[41];
	$LOGmodify_servers			=$row[42];
	$LOGview_reports			=$row[43];
	$LOGmodify_dids				=$row[56];
	$LOGdelete_dids				=$row[57];
	$LOGmanager_shift_enforcement_override=$row[61];
	$LOGexport_reports			=$row[64];
	$LOGdelete_from_dnc			=$row[65];
	$LOGcallcard_admin			=$row[70];
	$LOGforce_change_password	=$row[71];
	$LOGmodify_shifts			=$row[72];
	$LOGmodify_phones			=$row[73];
	$LOGmodify_carriers			=$row[74];
	$LOGmodify_labels			=$row[75];
	$LOGmodify_statuses			=$row[76];
	$LOGmodify_voicemail		=$row[77];
	$LOGmodify_audiostore		=$row[78];
	$LOGmodify_moh				=$row[79];
	$LOGmodify_tts				=$row[80];
	$LOGmodify_contacts			=$row[81];
	$LOGmodify_same_user_level	=$row[82];

	$stmt="SELECT allowed_campaigns,allowed_reports,admin_viewable_groups,admin_viewable_call_times from vicidial_user_groups where user_group='$LOGuser_group';";
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$LOGallowed_campaigns =			$row[0];
	$LOGallowed_reports =			$row[1];
	$LOGadmin_viewable_groups =		$row[2];
	$LOGadmin_viewable_call_times =	$row[3];
	
	$LOGadmin_viewable_groupsSQL='';
	$valLOGadmin_viewable_groupsSQL='';
	$vmLOGadmin_viewable_groupsSQL='';
	if ( (!preg_match('/\-\-ALL\-\-/i',$LOGadmin_viewable_groups)) and (strlen($LOGadmin_viewable_groups) > 3) )
		{
		$rawLOGadmin_viewable_groupsSQL = preg_replace("/ \-/",'',$LOGadmin_viewable_groups);
		$rawLOGadmin_viewable_groupsSQL = preg_replace("/ /","','",$rawLOGadmin_viewable_groupsSQL);
		$LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
		$whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
		$valLOGadmin_viewable_groupsSQL = "and val.user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
		$vmLOGadmin_viewable_groupsSQL = "and vm.user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
		}
	else 
		{$admin_viewable_groupsALL=1;}

	}

#  and (preg_match("/MONITOR|BARGE|HIJACK/",$monitor_active) ) )
if ( (!isset($monitor_phone)) or (strlen($monitor_phone)<1) )
	{
	$stmt="select phone_login from vicidial_users where user='$PHP_AUTH_USER';";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$row=mysqli_fetch_row($rslt);
	$monitor_phone = $row[0];
	}

$stmt="SELECT realtime_block_user_info,user_group from vicidial_users where user='$PHP_AUTH_USER';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$realtime_block_user_info = $row[0];
$LOGuser_group =			$row[1];

$stmt="SELECT allowed_campaigns,allowed_reports,webphone_url_override,webphone_dialpad_override,webphone_systemkey_override from vicidial_user_groups where user_group='$LOGuser_group';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGallowed_campaigns =			$row[0];
$LOGallowed_reports =			$row[1];
$webphone_url =					$row[2];
$webphone_dialpad_override =	$row[3];
$system_key =					$row[4];

if ( (!preg_match("/$report_name/",$LOGallowed_reports)) and (!preg_match("/ALL REPORTS/",$LOGallowed_reports)) )
	{
    Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo _QXZ("You are not allowed to view this report").": |$PHP_AUTH_USER|$report_name|"._QXZ("$report_name")."|\n";
    exit;
	}

$LOGallowed_campaignsSQL='';
$whereLOGallowed_campaignsSQL='';
if ( (!preg_match("/ALL-/",$LOGallowed_campaigns)) )
	{
	$rawLOGallowed_campaignsSQL = preg_replace("/ -/",'',$LOGallowed_campaigns);
	$rawLOGallowed_campaignsSQL = preg_replace("/ /","','",$rawLOGallowed_campaignsSQL);
	$LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
	$whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
	}
$regexLOGallowed_campaigns = " $LOGallowed_campaigns ";

$allactivecampaigns='';
$stmt="select campaign_id,campaign_name from vicidial_campaigns where active='Y' $LOGallowed_campaignsSQL order by campaign_id;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$groups_to_print = mysqli_num_rows($rslt);
$i=0;
$LISTgroups[$i]='ALL-ACTIVE';
$i++;
$groups_to_print++;
while ($i < $groups_to_print)
	{
	$row=mysqli_fetch_row($rslt);
	$LISTgroups[$i] =$row[0];
	$LISTnames[$i] =$row[1];
	$allactivecampaigns .= "'$LISTgroups[$i]',";
	$i++;
	}
$allactivecampaigns .= "''";

$i=0;
$group_string='|';
$group_ct = count($groups);
while($i < $group_ct)
	{
	$groups[$i] = preg_replace('/[^-_0-9a-zA-Z]/', '', $groups[$i]);
	if ( (preg_match("/ $groups[$i] /",$regexLOGallowed_campaigns)) or (preg_match("/ALL-/",$LOGallowed_campaigns)) )
		{
		$group_string .= "$groups[$i]|";
		$group_SQL .= "'$groups[$i]',";
		$groupQS .= "&groups[]=$groups[$i]";
		}

	$i++;
	}
$group_SQL = preg_replace('/,$/i', '',$group_SQL);

$i=0;
$user_group_string='|';
$user_group_ct = count($user_group_filter);
while($i < $user_group_ct)
	{
	$user_group_filter[$i] = preg_replace('/[^-_0-9a-zA-Z]/', '', $user_group_filter[$i]);
#	if ( (preg_match("/ $user_group_filter[$i] /",$regexLOGallowed_campaigns)) or (preg_match("/ALL-/",$LOGallowed_campaigns)) )
#		{
		$user_group_string .= "$user_group_filter[$i]|";
		$user_group_SQL .= "'$user_group_filter[$i]',";
		$usergroupQS .= "&user_group_filter[]=$user_group_filter[$i]";
#		}

	$i++;
	}
$user_group_SQL = preg_replace('/,$/i', '',$user_group_SQL);

### if no campaigns selected, display all
if ( ($group_ct < 1) or (strlen($group_string) < 2) )
	{
	$groups[0] = 'ALL-ACTIVE';
	$group_string = '|ALL-ACTIVE|';
	$group = 'ALL-ACTIVE';
	$groupQS .= "&groups[]=ALL-ACTIVE";
	}
### if no user groups selected, display all
$user_group_none=0;
if ( ($user_group_ct < 1) or (strlen($user_group_string) < 2) )
	{
	$user_group_filter[0] = 'ALL-GROUPS';
	$user_group_string = '|ALL-GROUPS|';
	$usergroupQS .= "&user_group_filter[]=ALL-GROUPS";
	$user_group_none=1;
	}

if ( (preg_match('/\s\-\-NONE\-\-\s/',$group_string) ) or ($group_ct < 1) )
	{
	$all_active = 0;
	$group_SQL = "''";
	$group_SQLand = "and FALSE";
	$group_SQLwhere = "where FALSE";
	}
elseif ( preg_match('/ALL\-ACTIVE/i',$group_string) )
	{
	$all_active = 1;
	$group_SQL = $allactivecampaigns;
	$group_SQLand = "and campaign_id IN($allactivecampaigns)";
	$group_SQLwhere = "where campaign_id IN($allactivecampaigns)";
	}
else
	{
	$all_active = 0;
	$group_SQLand = "and campaign_id IN($group_SQL)";
	$group_SQLwhere = "where campaign_id IN($group_SQL)";
	}

if ( (preg_match('/\s\-\-NONE\-\-\s/',$user_group_string) ) or ($user_group_ct < 1) )
	{
	$all_active_groups = 0;
	$user_group_SQL = "''";
#	$user_group_SQLand = "and FALSE";
#	$user_group_SQLwhere = "where FALSE";
	}
elseif ( preg_match('/ALL\-GROUPS/i',$user_group_string) )
	{
	$all_active_groups = 1;
#	$user_group_SQL = '';
	$user_group_SQL = "'$rawLOGadmin_viewable_groupsSQL'";
#	$group_SQLand = "and campaign_id IN($allactivecampaigns)";
#	$group_SQLwhere = "where campaign_id IN($allactivecampaigns)";
	}
else
	{
	$all_active_groups = 0;
#	$user_group_SQLand = "and user_group IN($user_group_SQL)";
#	$user_group_SQLwhere = "where user_group IN($user_group_SQL)";
	}

$stmt="select user_group, group_name from vicidial_user_groups $whereLOGadmin_viewable_groupsSQL order by user_group;";
$rslt=mysql_to_mysqli($stmt, $link);
if (!isset($DB))   {$DB=0;}
if ($DB) {echo "$stmt\n";}
$usergroups_to_print = mysqli_num_rows($rslt);
$i=0;
$usergroups[$i]='ALL-GROUPS';
$usergroupnames[$i] = _QXZ("All user groups");
$i++;
$usergroups_to_print++;
while ($i < $usergroups_to_print)
	{
	$row=mysqli_fetch_row($rslt);
	$usergroups[$i] =$row[0];
	$usergroupnames[$i] =$row[1];
	$i++;
	}

if (!isset($RR))   {$RR=4;}

$NFB = '<b><font size=6 face="courier">';
$NFE = '</font></b>';
$F=''; $FG=''; $B=''; $BG='';

$select_list = "<TABLE WIDTH=700 CELLPADDING=5 BGCOLOR=\"#D9E6FE\"><TR><TD VALIGN=TOP>"._QXZ("Select Campaigns").": <BR>";
$select_list .= "<SELECT SIZE=8 NAME=groups[] ID=groups[] multiple>";
$o=0;
while ($groups_to_print > $o)
	{
	if (preg_match("/\|$LISTgroups[$o]\|/",$group_string)) 
		{$select_list .= "<option selected value=\"$LISTgroups[$o]\">$LISTgroups[$o] - $LISTnames[$o]</option>";}
	else
		{$select_list .= "<option value=\"$LISTgroups[$o]\">$LISTgroups[$o] - $LISTnames[$o]</option>";}
	$o++;
	}
$select_list .= "</SELECT>";
$select_list .= "<BR><font size=1>("._QXZ("To select more than 1 campaign, hold down the Ctrl key and click").")</font>";

$select_list .= "<BR><BR>"._QXZ("Select User Groups").": <BR>";
$select_list .= "<SELECT SIZE=8 NAME=user_group_filter[] ID=user_group_filter[] multiple>";
$o=0;
while ($o < $usergroups_to_print)
	{
	if (preg_match("/\|$usergroups[$o]\|/",$user_group_string))
		{$select_list .= "<option selected value=\"$usergroups[$o]\">$usergroups[$o] - $usergroupnames[$o]</option>";}
	else
		{
		if ( ($user_group_none > 0) and ($usergroups[$o] == 'ALL-GROUPS') )
			{$select_list .= "<option selected value=\"$usergroups[$o]\">$usergroups[$o] - $usergroupnames[$o]</option>";}
		else
			{$select_list .= "<option value=\"$usergroups[$o]\">$usergroups[$o] - $usergroupnames[$o]</option>";}
		}
	$o++;
	}
$select_list .= "</SELECT>";

$select_list .= "</TD><TD VALIGN=TOP ALIGN=CENTER>";
//$select_list .= "<a href=\"#\" onclick=\"hideDiv(\'campaign_select_list\');\">"._QXZ("Close Panel")."</a><BR><BR>";
$select_list .= "<TABLE CELLPADDING=2 CELLSPACING=2 BORDER=0>";

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Screen Refresh Rate").":  </TD><TD align=left><SELECT SIZE=1 NAME=RR ID=RR>";
$select_list .= "<option value=\"4\"";   if ($RR < 5) {$select_list .= " selected";}    $select_list .= ">4 "._QXZ("seconds")."</option>";
$select_list .= "<option value=\"10\"";   if ( ($RR >= 5) and ($RR <=10) ) {$select_list .= " selected";}    $select_list .= ">10 "._QXZ("seconds")."</option>";
$select_list .= "<option value=\"20\"";   if ( ($RR >= 11) and ($RR <=20) ) {$select_list .= " selected";}    $select_list .= ">20 "._QXZ("seconds")."</option>";
$select_list .= "<option value=\"30\"";   if ( ($RR >= 21) and ($RR <=30) ) {$select_list .= " selected";}    $select_list .= ">30 "._QXZ("seconds")."</option>";
$select_list .= "<option value=\"40\"";   if ( ($RR >= 31) and ($RR <=40) ) {$select_list .= " selected";}    $select_list .= ">40 "._QXZ("seconds")."</option>";
$select_list .= "<option value=\"60\"";   if ( ($RR >= 41) and ($RR <=60) ) {$select_list .= " selected";}    $select_list .= ">60 "._QXZ("seconds")."</option>";
$select_list .= "<option value=\"120\"";   if ( ($RR >= 61) and ($RR <=120) ) {$select_list .= " selected";}    $select_list .= ">2 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"300\"";   if ( ($RR >= 121) and ($RR <=300) ) {$select_list .= " selected";}    $select_list .= ">5 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"600\"";   if ( ($RR >= 301) and ($RR <=600) ) {$select_list .= " selected";}    $select_list .= ">10 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"1200\"";   if ( ($RR >= 601) and ($RR <=1200) ) {$select_list .= " selected";}    $select_list .= ">20 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"1800\"";   if ( ($RR >= 1201) and ($RR <=1800) ) {$select_list .= " selected";}    $select_list .= ">30 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"2400\"";   if ( ($RR >= 1801) and ($RR <=2400) ) {$select_list .= " selected";}    $select_list .= ">40 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"3600\"";   if ( ($RR >= 2401) and ($RR <=3600) ) {$select_list .= " selected";}    $select_list .= ">60 "._QXZ("minutes")."</option>";
$select_list .= "<option value=\"7200\"";   if ( ($RR >= 3601) and ($RR <=7200) ) {$select_list .= " selected";}    $select_list .= ">2 "._QXZ("hours")."</option>";
$select_list .= "<option value=\"63072000\"";   if ($RR >= 7201) {$select_list .= " selected";}    $select_list .= ">2 "._QXZ("years")."</option>";
$select_list .= "</SELECT></TD></TR>";

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Inbound").":  </TD><TD align=left><SELECT SIZE=1 NAME=with_inbound ID=with_inbound>";
$select_list .= "<option value=\"N\"";
	if ($with_inbound=='N') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("No")."</option>";
$select_list .= "<option value=\"Y\"";
	if ($with_inbound=='Y') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("Yes")."</option>";
$select_list .= "<option value=\"O\"";
	if ($with_inbound=='O') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("Only")."</option>";
$select_list .= "</SELECT></TD></TR>";

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Monitor").":  </TD><TD align=left><SELECT SIZE=1 NAME=monitor_active ID=monitor_active>";
$select_list .= "<option value=\"\"";
	if (strlen($monitor_active) < 2) {$select_list .= " selected";} 
$select_list .= ">"._QXZ("NONE")."</option>";
$select_list .= "<option value=\"MONITOR\"";
	if ($monitor_active=='MONITOR') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("MONITOR")."</option>";
$select_list .= "<option value=\"BARGE\"";
	if ($monitor_active=='BARGE') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("BARGE")."</option>";
#$select_list .= "<option value=\"HIJACK\"";
#	if ($monitor_active=='HIJACK') {$select_list .= " selected";} 
#$select_list .= ">HIJACK</option>";
$select_list .= "</SELECT></TD></TR>";

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Phone").":  </TD><TD align=left>";
$select_list .= "<INPUT type=text size=10 maxlength=20 NAME=monitor_phone ID=monitor_phone VALUE=\"$monitor_phone\">";
$select_list .= "</TD></TR>";
$select_list .= "<TR><TD align=center COLSPAN=2> &nbsp; </TD></TR>";

if ($UGdisplay > 0)
	{
	$select_list .= "<TR><TD align=right>";
	$select_list .= _QXZ("Select User Group").":  </TD><TD align=left>";
	$select_list .= "<SELECT SIZE=1 NAME=usergroup ID=usergroup>";
	$select_list .= "<option value=\"\">"._QXZ("ALL USER GROUPS")."</option>";
	$o=0;
	while ($usergroups_to_print > $o)
		{
		if ($usergroups[$o] == $usergroup) {$select_list .= "<option selected value=\"$usergroups[$o]\">$usergroups[$o]</option>";}
		else {$select_list .= "<option value=\"$usergroups[$o]\">$usergroups[$o]</option>";}
		$o++;
		}
	$select_list .= "</SELECT></TD></TR>";
	}

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Dialable Leads Alert").":  </TD><TD align=left><SELECT SIZE=1 NAME=NOLEADSalert ID=NOLEADSalert>";
$select_list .= "<option value=\"\"";
	if (strlen($NOLEADSalert) < 2) {$select_list .= " selected";} 
$select_list .= ">"._QXZ("NO")."</option>";
$select_list .= "<option value=\"YES\"";
	if ($NOLEADSalert=='YES') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("YES")."</option>";
$select_list .= "</SELECT></TD></TR>";

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Show Drop In-Group Row").":  </TD><TD align=left><SELECT SIZE=1 NAME=DROPINGROUPstats ID=DROPINGROUPstats>";
$select_list .= "<option value=\"0\"";
	if ($DROPINGROUPstats < 1) {$select_list .= " selected";} 
$select_list .= ">"._QXZ("NO")."</option>";
$select_list .= "<option value=\"1\"";
	if ($DROPINGROUPstats=='1') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("YES")."</option>";
$select_list .= "</SELECT></TD></TR>";

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Show Carrier Stats").":  </TD><TD align=left><SELECT SIZE=1 NAME=CARRIERstats ID=CARRIERstats>";
$select_list .= "<option value=\"0\"";
	if ($CARRIERstats < 1) {$select_list .= " selected";} 
$select_list .= ">"._QXZ("NO")."</option>";
$select_list .= "<option value=\"1\"";
	if ($CARRIERstats=='1') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("YES")."</option>";
$select_list .= "</SELECT></TD></TR>";

## find if any selected campaigns have presets enabled
$presets_enabled=0;
$stmt="select count(*) from vicidial_campaigns where enable_xfer_presets='ENABLED' $group_SQLand;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {$OUToutput .= "$stmt\n";}
$presets_enabled_count = mysqli_num_rows($rslt);
if ($presets_enabled_count > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$presets_enabled = $row[0];
	}
if ($presets_enabled > 0)
	{
	$select_list .= "<TR><TD align=right>";
	$select_list .= _QXZ("Show Presets Stats").":  </TD><TD align=left><SELECT SIZE=1 NAME=PRESETstats ID=PRESETstats>";
	$select_list .= "<option value=\"0\"";
		if ($PRESETstats < 1) {$select_list .= " selected";} 
	$select_list .= ">"._QXZ("NO")."</option>";
	$select_list .= "<option value=\"1\"";
		if ($PRESETstats=='1') {$select_list .= " selected";} 
	$select_list .= ">"._QXZ("YES")."</option>";
	$select_list .= "</SELECT></TD></TR>";
	}
else
	{
	$select_list .= "<INPUT TYPE=HIDDEN NAME=PRESETstats ID=PRESETstats value=0>";
	}

$select_list .= "<TR><TD align=right>";
$select_list .= _QXZ("Agent Time Stats").":  </TD><TD align=left><SELECT SIZE=1 NAME=AGENTtimeSTATS ID=AGENTtimeSTATS>";
$select_list .= "<option value=\"0\"";
	if ($AGENTtimeSTATS < 1) {$select_list .= " selected";} 
$select_list .= ">"._QXZ("NO")."</option>";
$select_list .= "<option value=\"1\"";
	if ($AGENTtimeSTATS=='1') {$select_list .= " selected";} 
$select_list .= ">"._QXZ("YES")."</option>";
$select_list .= "</SELECT></TD></TR>";

$select_list .= "</TABLE><BR>";
$select_list .= "<INPUT type=hidden name=droppedOFtotal value=\"$droppedOFtotal\">";
$select_list .= "</TD></TR>";
$select_list .= "<TR><TD ALIGN=CENTER>";
$select_list .= "<font size=1> &nbsp; </font>";
$select_list .= "</TD>";
$select_list .= "<TD NOWRAP align=right>";
$select_list .= "<font size=1>"._QXZ("VERSION").": $version &nbsp; "._QXZ("BUILD").": $build</font>";
$select_list .= "</TD></TR></TABLE>";

$open_list = "<TABLE WIDTH=250 CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#D9E6FE\"><TR><TD ALIGN=CENTER><a href=\"#\" onclick=\"showDiv(\'campaign_select_list\');\"><font size=2>"._QXZ("Choose Report Display Options")."</a></TD></TR></TABLE>";





if (strlen($monitor_phone)>1)
	{
	$stmt="SELECT extension,dialplan_number,server_ip,login,pass,protocol,conf_secret,is_webphone,use_external_server_ip,codecs_list,webphone_dialpad,outbound_cid,webphone_auto_answer from phones where login='$monitor_phone' and active = 'Y';";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
	$Mph_ct = mysqli_num_rows($rslt);
	if ($Mph_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$extension =				$row[0];
		$dialplan_number =			$row[1];
		$webphone_server_ip =		$row[2];
		$login =					$row[3];
		$pass =						$row[4];
		$protocol =					$row[5];
		$conf_secret =				$row[6];
		$is_webphone =				$row[7];
		$use_external_server_ip =	$row[8];
		$codecs_list =				$row[9];
		$webphone_dialpad =			$row[10];
		$outbound_cid =				$row[11];
		$webphone_auto_answer =		$row[12];

		if ($is_webphone == 'Y')
			{
			### build Iframe variable content for webphone here
			$codecs_list = preg_replace("/ /",'',$codecs_list);
			$codecs_list = preg_replace("/-/",'',$codecs_list);
			$codecs_list = preg_replace("/&/",'',$codecs_list);

			if ($use_external_server_ip=='Y')
				{
				##### find external_server_ip if enabled for this phone account
				$stmt="SELECT external_server_ip FROM servers where server_ip='$webphone_server_ip' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysqli_error_logging($NOW_TIME,$link,$mel,$stmt,'01065',$VD_login,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$exip_ct = mysqli_num_rows($rslt);
				if ($exip_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$webphone_server_ip =$row[0];
					}
				}
			if (strlen($webphone_url) < 6)
				{
				##### find webphone_url in system_settings and generate IFRAME code for it #####
				$stmt="SELECT webphone_url FROM system_settings LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysqli_error_logging($NOW_TIME,$link,$mel,$stmt,'01066',$VD_login,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$wu_ct = mysqli_num_rows($rslt);
				if ($wu_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$webphone_url =$row[0];
					}
				}
			if (strlen($system_key) < 1)
				{
				##### find system_key in system_settings if populated #####
				$stmt="SELECT webphone_systemkey FROM system_settings LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysqli_error_logging($NOW_TIME,$link,$mel,$stmt,'01068',$VD_login,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$wsk_ct = mysqli_num_rows($rslt);
				if ($wsk_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$system_key =$row[0];
					}
				}
		#	echo "<!-- debug: $webphone_dialpad|$webphone_dialpad_override|$monitor_phone|$extension -->";
			if ( ($webphone_dialpad_override != 'DISABLED') and (strlen($webphone_dialpad_override) > 0) )
				{$webphone_dialpad = $webphone_dialpad_override;}
			$webphone_options='INITIAL_LOAD';
			if ($webphone_dialpad == 'Y') {$webphone_options .= "--DIALPAD_Y";}
			if ($webphone_dialpad == 'N') {$webphone_options .= "--DIALPAD_N";}
			if ($webphone_dialpad == 'TOGGLE') {$webphone_options .= "--DIALPAD_TOGGLE";}
			if ($webphone_dialpad == 'TOGGLE_OFF') {$webphone_options .= "--DIALPAD_OFF_TOGGLE";}
			if ($webphone_auto_answer == 'Y') {$webphone_options .= "--AUTOANSWER_Y";}
			if ($webphone_auto_answer == 'N') {$webphone_options .= "--AUTOANSWER_N";}

			$session_name='RTS01234561234567890';

			### base64 encode variables
			$b64_phone_login =		base64_encode($extension);
			$b64_phone_pass =		base64_encode($conf_secret);
			$b64_session_name =		base64_encode($session_name);
			$b64_server_ip =		base64_encode($webphone_server_ip);
			$b64_callerid =			base64_encode($outbound_cid);
			$b64_protocol =			base64_encode($protocol);
			$b64_codecs =			base64_encode($codecs_list);
			$b64_options =			base64_encode($webphone_options);
			$b64_system_key =		base64_encode($system_key);

			$WebPhonEurl = "$webphone_url?phone_login=$b64_phone_login&phone_login=$b64_phone_login&phone_pass=$b64_phone_pass&server_ip=$b64_server_ip&callerid=$b64_callerid&protocol=$b64_protocol&codecs=$b64_codecs&options=$b64_options&system_key=$b64_system_key";
			$webphone_content = "<iframe src=\"$WebPhonEurl\" style=\"width:" . $webphone_width . ";height:" . $webphone_height . ";background-color:transparent;z-index:17;\" scrolling=\"auto\" frameborder=\"0\" allowtransparency=\"true\" id=\"webphone\" name=\"webphone\" width=\"" . $webphone_width . "\" height=\"" . $webphone_height . "\"> </iframe>";
			}
		}
	}



?>

<HTML>
<HEAD>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vici-admin-them/css/bootstrap.min.css" >
	<link rel="stylesheet" href="vici-admin-them/css/ace.min.css" >
	<link rel="stylesheet" href="vici-admin-them/css/font-awesome.min.css" >
	<link rel="stylesheet" href="vici-admin-them/css/font-awesome-animation.min.css" >
	<link rel="stylesheet" href="vici-admin-them/css/custom.css" >
	<!--<link type="text/css" rel="stylesheet" media="all" href="../agc/css/screen.css" />-->
	<!--[if lte IE 7]>
	<link type="text/css" rel="stylesheet" media="all" href="vici-admin-them/css/screen_ie.css" />
	<![endif]-->
   <link rel="stylesheet" href="vici-admin-them/css/jquery.bootgrid.min.css" >  
	<script src="vici-admin-them/js/jquery-2.1.1.min.js"></script>
	<script src="vici-admin-them/js/bootstrap.min.js"></script>
	<script src="vici-admin-them/js/jquery.sparkline.min.js"></script>
	<script src="vici-admin-them/js/ace.min.js"></script>
	<script src="vici-admin-them/js/jquery.bootgrid.min.js"></script>
	
<script language="Javascript" >
		$(document).ready(function(){
		
		});
		function ViewModal(users){
			'use strict';
			this.users = ko.observable(users);
		}
		function toggleColumn(column, isChecked) {
			if(isChecked){
				$('#grid-basic tr td:nth-child('+column+')').show();
				$('#grid-basic tr th:nth-child('+column+')').show();
			}else{
				$('#grid-basic tr td:nth-child('+column+')').hide();
				$('#grid-basic tr th:nth-child('+column+')').hide();
			}
                    
	    }
		
</script>
<script language="Javascript">

window.onload = startup;

function update_modal_data(){
	$('#myModal').modal('toggle');
	update_variables('form_submit','');
}
// functions to detect the XY position on the page of the mouse
function startup() 
	{
	//hideDiv('webphone_content');
	document.getElementById('campaign_select_list').innerHTML = select_list;
	//hideDiv('campaign_select_list');

	hide_ingroup_info();
	if (window.Event) 
		{
		document.captureEvents(Event.MOUSEMOVE);
		}
	document.onmousemove = getCursorXY;
	realtime_refresh_display();
	}

function getCursorXY(e) 
	{
	document.getElementById('cursorX').value = (window.Event) ? e.pageX : event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
	document.getElementById('cursorY').value = (window.Event) ? e.pageY : event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
	}

var PHP_SELF = '<?php echo $PHP_SELF ?>';
var select_list = '<?php echo $select_list ?>';
var open_list = '<?php echo $open_list ?>';
var monitor_phone = '<?php echo $monitor_phone ?>';
var user = '<?php echo $PHP_AUTH_USER ?>';
var pass = '<?php echo $PHP_AUTH_PW ?>';
var RR = '<?php echo $RR ?>';
var groupQS = '<?php echo $groupQS ?>';
var usergroupQS = '<?php echo $usergroupQS ?>';
var DB = '<?php echo $DB ?>';
var adastats = '<?php echo $adastats ?>';
var SIPmonitorLINK = '<?php echo $SIPmonitorLINK ?>';
var IAXmonitorLINK = '<?php echo $IAXmonitorLINK ?>';
var usergroup = '<?php echo $usergroup ?>';
var UGdisplay = '<?php echo $UGdisplay ?>';
var UidORname = '<?php echo $UidORname ?>';
var orderby = '<?php echo $orderby ?>';
var SERVdisplay = '<?php echo $SERVdisplay ?>';
var CALLSdisplay = '<?php echo $CALLSdisplay ?>';
var PHONEdisplay = '<?php echo $PHONEdisplay ?>';
var CUSTPHONEdisplay = '<?php echo $CUSTPHONEdisplay ?>';
var with_inbound = '<?php echo $with_inbound ?>';
var monitor_active = '<?php echo $monitor_active ?>';
var monitor_phone = '<?php echo $monitor_phone ?>';
var ALLINGROUPstats = '<?php echo $ALLINGROUPstats ?>';
var DROPINGROUPstats = '<?php echo $DROPINGROUPstats ?>';
var NOLEADSalert = '<?php echo $NOLEADSalert ?>';
var CARRIERstats = '<?php echo $CARRIERstats ?>';
var PRESETstats = '<?php echo $PRESETstats ?>';
var AGENTtimeSTATS = '<?php echo $AGENTtimeSTATS ?>';
var droppedOFtotal = '<?php echo $droppedOFtotal ?>';
var collapseOne = '<?php echo $collapseOne ?>';
var collapseTwo = '<?php echo $collapseTwo ?>';
var collapseThree = '<?php echo $collapseThree ?>';
var collapseFour = '<?php echo $collapseFour ?>';
// functions to hide and show different DIVs
function showDiv(divvar) 
	{
	if (document.getElementById(divvar))
		{
		divref = document.getElementById(divvar).style;
		divref.visibility = 'visible';
		if (divvar=="campaign_select_list") 
			{
			document.getElementById(divvar).style.zIndex=21;
			}
		}
	}
function hideDiv(divvar)
	{
	if (document.getElementById(divvar))
		{
		divref = document.getElementById(divvar).style;
		divref.visibility = 'hidden';
		if (divvar=="campaign_select_list") 
			{
			document.getElementById(divvar).style.zIndex=-1;
			}
		}
	}

function ShowWebphone(divvis)
	{
	if (divvis == 'show')
		{
		divref = document.getElementById('webphone_content').style;
		divref.visibility = 'visible';
		document.getElementById("webphone_visibility").innerHTML = "<a href=\"#\" onclick=\"ShowWebphone('hide');\"><?php echo _QXZ("webphone"); ?> -</a>";
		}
	else
		{
		divref = document.getElementById('webphone_content').style;
		divref.visibility = 'hidden';
		document.getElementById("webphone_visibility").innerHTML = "<a href=\"#\" onclick=\"ShowWebphone('show');\"><?php echo _QXZ("webphone"); ?> +</a>";
		}
	}

// function to launch monitoring calls
function send_monitor(session_id,server_ip,stage)
	{
	//	alert(session_id + "|" + server_ip + "|" + monitor_phone + "|" + stage + "|" + user);
	var xmlhttp=false;
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	// JScript gives us Conditional compilation, we can cope with old IE versions.
	// and security blocked creation of the objects.
	 try {
	  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	  try {
	   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (E) {
	   xmlhttp = false;
	  }
	 }
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
		{
		xmlhttp = new XMLHttpRequest();
		}
	if (xmlhttp) 
		{
		var monitorQuery = "source=realtime&function=blind_monitor&user=" + user + "&pass=" + pass + "&phone_login=" + monitor_phone + "&session_id=" + session_id + '&server_ip=' + server_ip + '&stage=' + stage;
		xmlhttp.open('POST', 'non_agent_api.php'); 
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(monitorQuery); 
		xmlhttp.onreadystatechange = function() 
			{ 
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
			//	alert(xmlhttp.responseText);
				var Xoutput = null;
				Xoutput = xmlhttp.responseText;
				var regXFerr = new RegExp("ERROR","g");
				var regXFscs = new RegExp("SUCCESS","g");
				if (Xoutput.match(regXFerr))
					{alert(xmlhttp.responseText);}
				if (Xoutput.match(regXFscs))
					{alert("<?php echo _QXZ("SUCCESS: calling"); ?> " + monitor_phone);}
				}
			}
		delete xmlhttp;
		}
	}


// function to change in-groups selected for a specific agent
function submit_ingroup_changes(temp_agent_user)
	{
	var temp_ingroup_add_remove_changeIndex = document.getElementById("ingroup_add_remove_change").selectedIndex;
	var temp_ingroup_add_remove_change =  document.getElementById('ingroup_add_remove_change').options[temp_ingroup_add_remove_changeIndex].value;

	var temp_set_as_defaultIndex = document.getElementById("set_as_default").selectedIndex;
	var temp_set_as_default =  document.getElementById('set_as_default').options[temp_set_as_defaultIndex].value;

	var temp_blendedIndex = document.getElementById("blended").selectedIndex;
	var temp_blended =  document.getElementById('blended').options[temp_blendedIndex].value;

	var temp_ingroup_choices = '';
	var txtSelectedValuesObj = document.getElementById('txtSelectedValues');
	var selectedArray = new Array();
	var selObj = document.getElementById('ingroup_new_selections');
	var i;
	var count = 0;
	for (i=0; i<selObj.options.length; i++) 
		{
		if (selObj.options[i].selected) 
			{
		//	selectedArray[count] = selObj.options[i].value;
			temp_ingroup_choices = temp_ingroup_choices + '+' + selObj.options[i].value;
			count++;
			}
		}

	temp_ingroup_choices = temp_ingroup_choices + '+-';

	//	alert(session_id + "|" + server_ip + "|" + monitor_phone + "|" + stage + "|" + user);
	var xmlhttp=false;
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	// JScript gives us Conditional compilation, we can cope with old IE versions.
	// and security blocked creation of the objects.
	 try {
	  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	  try {
	   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (E) {
	   xmlhttp = false;
	  }
	 }
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
		{
		xmlhttp = new XMLHttpRequest();
		}
	if (xmlhttp) 
		{
		var changeQuery = "source=realtime&function=change_ingroups&user=" + user + "&pass=" + pass + "&agent_user=" + temp_agent_user + "&value=" + temp_ingroup_add_remove_change + '&set_as_default=' + temp_set_as_default + '&blended=' + temp_blended + '&ingroup_choices=' + temp_ingroup_choices;
		xmlhttp.open('POST', '../agc/api.php'); 
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(changeQuery); 
		xmlhttp.onreadystatechange = function() 
			{ 
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
			//	alert(changeQuery);
				var Xoutput = null;
				Xoutput = xmlhttp.responseText;
				var regXFerr = new RegExp("ERROR","g");
				if (Xoutput.match(regXFerr))
					{alert(xmlhttp.responseText);}
				else
					{
					alert(xmlhttp.responseText);
					hide_ingroup_info();
					}
				}
			}
		delete xmlhttp;
		}
	}


// function to display in-groups selected for a specific agent
function ingroup_info(agent_user,count)
	{
	var cursorheight = (document.REALTIMEform.cursorY.value - 0);
	var newheight = (cursorheight + 10);
	document.getElementById("agent_ingroup_display").style.top = newheight;
	//	alert(session_id + "|" + server_ip + "|" + monitor_phone + "|" + stage + "|" + user);
	var xmlhttp=false;
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	// JScript gives us Conditional compilation, we can cope with old IE versions.
	// and security blocked creation of the objects.
	 try {
	  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	  try {
	   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (E) {
	   xmlhttp = false;
	  }
	 }
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
		{
		xmlhttp = new XMLHttpRequest();
		}
	if (xmlhttp) 
		{
		var monitorQuery = "source=realtime&function=agent_ingroup_info&stage=change&user=" + user + "&pass=" + pass + "&agent_user=" + agent_user;
		xmlhttp.open('POST', 'non_agent_api.php'); 
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(monitorQuery); 
		xmlhttp.onreadystatechange = function() 
			{ 
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
			//	alert(xmlhttp.responseText);
				var Xoutput = null;
				Xoutput = xmlhttp.responseText;
				var regXFerr = new RegExp("ERROR","g");
				if (Xoutput.match(regXFerr))
					{alert(xmlhttp.responseText);}
				else
					{
					document.getElementById("agent_ingroup_display").visibility = "visible";
					document.getElementById("agent_ingroup_display").innerHTML = Xoutput;
					}
				}
			}
		delete xmlhttp;
		}
	}


// function to display in-groups selected for a specific agent
function hide_ingroup_info()
	{
	document.getElementById("agent_ingroup_display").visibility = "hidden";
	document.getElementById("agent_ingroup_display").innerHTML = '';
	}

var ar_refresh=<?php echo "$RR;"; ?>
var ar_seconds=<?php echo "$RR;"; ?>
var $start_count=0;

function realtime_refresh_display()
	{
	if ($start_count < 1)
		{
		gather_realtime_content();
		}
	$start_count++;
	if (ar_seconds > 0)
		{
		document.getElementById("refresh_countdown").innerHTML = "" + ar_seconds + "";
		ar_seconds = (ar_seconds - 1);
		setTimeout("realtime_refresh_display()",1000);
		}
	else
		{
		document.getElementById("refresh_countdown").innerHTML = "0";
		ar_seconds = ar_refresh;
		//	window.location.reload();
		gather_realtime_content();
		setTimeout("realtime_refresh_display()",1000);
		}
	}


// function to gather calls and agents statistical content
function gather_realtime_content()
	{
	var xmlhttp=false;
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	// JScript gives us Conditional compilation, we can cope with old IE versions.
	// and security blocked creation of the objects.
	 try {
	  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	  try {
	   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (E) {
	   xmlhttp = false;
	  }
	 }
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
		{
		xmlhttp = new XMLHttpRequest();
		}
	if (xmlhttp) 
		{
			if(typeof $("#btn-collapseOne").attr("aria-expanded") != 'undefined'){
				collapseOne = $("#btn-collapseOne").attr("aria-expanded");
				collapseTwo = $("#btn-collapseTwo").attr("aria-expanded");
				collapseThree = $("#btn-collapseThree").attr("aria-expanded");
				collapseFour = $("#btn-collapseFour").attr("aria-expanded");
			}
		//console.log(collapseOne +" "+collapseTwo+" "+collapseThree+" "+collapseFour);
		RTupdate_query = "RTajax=1&DB=" + DB + "" + groupQS + usergroupQS + "&adastats=" + adastats + "&SIPmonitorLINK=" + SIPmonitorLINK + "&IAXmonitorLINK=" + IAXmonitorLINK + "&usergroup=" + usergroup + "&UGdisplay=" + UGdisplay + "&UidORname=" + UidORname + "&orderby=" + orderby + "&SERVdisplay=" + SERVdisplay + "&CALLSdisplay=" + CALLSdisplay + "&PHONEdisplay=" + PHONEdisplay + "&CUSTPHONEdisplay=" + CUSTPHONEdisplay + "&with_inbound=" + with_inbound + "&monitor_active=" + monitor_active + "&monitor_phone=" + monitor_phone + "&ALLINGROUPstats=" + ALLINGROUPstats + "&DROPINGROUPstats=" + DROPINGROUPstats + "&NOLEADSalert=" + NOLEADSalert + "&CARRIERstats=" + CARRIERstats + "&PRESETstats=" + PRESETstats + "&AGENTtimeSTATS=" + AGENTtimeSTATS + "&droppedOFtotal=" + droppedOFtotal + ""+ "&collapseOne=" + collapseOne + "" + "&collapseTwo=" + collapseTwo + "" + "&collapseThree=" + collapseThree + "" + "&collapseFour=" + collapseFour + "";

		xmlhttp.open('POST', 'AST_timeonVDADallnew.php'); 
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(RTupdate_query); 
		xmlhttp.onreadystatechange = function() 
			{ 
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
				document.getElementById("realtime_content").innerHTML = xmlhttp.responseText;
		//		alert(xmlhttp.responseText);
				}
			}
		delete xmlhttp;
		}
	}


// function to update variables based upon on-page links and forms without reload page(in most cases)
function update_variables(task_option,task_choice,force_reload)
	{
		
	if (task_option == 'SIPmonitorLINK')
		{
		if (SIPmonitorLINK == '1') {SIPmonitorLINK='0';}
		else {SIPmonitorLINK='1';}
		}
	if (task_option == 'IAXmonitorLINK')
		{
		if (IAXmonitorLINK == '1') {IAXmonitorLINK='0';}
		else {IAXmonitorLINK='1';}
		}
	if (task_option == 'UidORname')
		{
		if (UidORname == '1') {UidORname='0';}
		else {UidORname='1';}
		}
	if (task_option == 'orderby')
		{
		if (task_choice == 'phone')
			{
			if (orderby=='phoneup') {orderby='phonedown';}
			else {orderby='phoneup';}
			}
		if (task_choice == 'user')
			{
			if (orderby=='userup') {orderby='userdown';}
			else {orderby='userup';}
			}
		if (task_choice == 'group')
			{
			if (orderby=='groupup') {orderby='groupdown';}
			else {orderby='groupup';}
			}
		if (task_choice == 'time')
			{
			if (orderby=='timeup') {orderby='timedown';}
			else {orderby='timeup';}
			}
		if (task_choice == 'campaign')
			{
			if (orderby=='campaignup') {orderby='campaigndown';}
			else {orderby='campaignup';}
			}
		}
	if (task_option == 'adastats')
		{
		if (adastats == '1') {adastats='2';   document.getElementById("adastatsTXT").innerHTML = '- VIEW LESS';}
		else {adastats='1';   document.getElementById("adastatsTXT").innerHTML = '+ VIEW MORE';}
		}
	if (task_option == 'UGdisplay')
		{
		if (UGdisplay == '1') {UGdisplay='0';   document.getElementById("UGdisplayTXT").innerHTML = 'VIEW USER GROUP';}
		else {UGdisplay='1';   document.getElementById("UGdisplayTXT").innerHTML = 'HIDE USER GROUP';}
		}
	if (task_option == 'SERVdisplay')
		{
		if (SERVdisplay == '1') {SERVdisplay='0';   document.getElementById("SERVdisplayTXT").innerHTML = 'SHOW SERVER INFO';}
		else {SERVdisplay='1';   document.getElementById("SERVdisplayTXT").innerHTML = 'HIDE SERVER INFO';}
		}
	if (task_option == 'CALLSdisplay')
		{
		if (CALLSdisplay == '1') {CALLSdisplay='0';   document.getElementById("CALLSdisplayTXT").innerHTML = 'SHOW WAITING CALLS';}
		else {CALLSdisplay='1';   document.getElementById("CALLSdisplayTXT").innerHTML = 'HIDE WAITING CALLS';}
		}
	if (task_option == 'PHONEdisplay')
		{
		if (PHONEdisplay == '1') {PHONEdisplay='0';   document.getElementById("PHONEdisplayTXT").innerHTML = 'SHOW PHONES';}
		else {PHONEdisplay='1';   document.getElementById("PHONEdisplayTXT").innerHTML = 'HIDE PHONES';}
		}
	if (task_option == 'CUSTPHONEdisplay')
		{
		if (CUSTPHONEdisplay == '1') {CUSTPHONEdisplay='0';   document.getElementById("CUSTPHONEdisplayTXT").innerHTML = 'SHOW CUSTPHONES';}
		else {CUSTPHONEdisplay='1';   document.getElementById("CUSTPHONEdisplayTXT").innerHTML = 'HIDE CUSTPHONES';}
		}
	if (task_option == 'ALLINGROUPstats')
		{
		if (ALLINGROUPstats == '1') {ALLINGROUPstats='0';   document.getElementById("ALLINGROUPstatsTXT").innerHTML = 'SHOW IN-GROUP STATS';}
		else {ALLINGROUPstats='1';   document.getElementById("ALLINGROUPstatsTXT").innerHTML = 'HIDE IN-GROUP STATS';}
		}
	if (task_option == 'form_submit')
		{
		var RRFORM = document.getElementById('RR');
		RR = RRFORM[RRFORM.selectedIndex].value;
		ar_refresh=RR;
		ar_seconds=RR;
		var with_inboundFORM = document.getElementById('with_inbound');
		with_inbound = with_inboundFORM[with_inboundFORM.selectedIndex].value;
		var monitor_activeFORM = document.getElementById('monitor_active');
		monitor_active = monitor_activeFORM[monitor_activeFORM.selectedIndex].value;
		var DROPINGROUPstatsFORM = document.getElementById('DROPINGROUPstats');
		DROPINGROUPstats = DROPINGROUPstatsFORM[DROPINGROUPstatsFORM.selectedIndex].value;
		var NOLEADSalertFORM = document.getElementById('NOLEADSalert');
		NOLEADSalert = NOLEADSalertFORM[NOLEADSalertFORM.selectedIndex].value;
		var CARRIERstatsFORM = document.getElementById('CARRIERstats');
		CARRIERstats = CARRIERstatsFORM[CARRIERstatsFORM.selectedIndex].value;
		<?php
		if ($presets_enabled > 0)
			{
			?>
		var PRESETstatsFORM = document.getElementById('PRESETstats');
		PRESETstats = PRESETstatsFORM[PRESETstatsFORM.selectedIndex].value;
			<?php
			}
		else
			{echo "PRESETstats=0;\n";}
		?>
		var AGENTtimeSTATSFORM = document.getElementById('AGENTtimeSTATS');
		AGENTtimeSTATS = AGENTtimeSTATSFORM[AGENTtimeSTATSFORM.selectedIndex].value;
		var temp_monitor_phone = document.REALTIMEform.monitor_phone.value;
		var droppedOFtotal = document.REALTIMEform.droppedOFtotal.value;

		var temp_camp_choices = '';
		var selCampObj = document.getElementById('groups[]');
		var i;
		var count = 0;
		var selected_all=0;
		for (i=0; i<selCampObj.options.length; i++) 
			{
			if ( (selCampObj.options[i].selected) && (selected_all < 1) )
				{
				temp_camp_choices = temp_camp_choices + '&groups[]=' + selCampObj.options[i].value;
				count++;
				if (selCampObj.options[i].value == 'ALL-ACTIVE')
					{selected_all++;}
				}
			}
		groupQS = temp_camp_choices;

		var temp_usergroup_choices = '';
		var selCampObj = document.getElementById('user_group_filter[]');
		var i;
		var count = 0;
		var selected_all=0;
		for (i=0; i<selCampObj.options.length; i++) 
			{
			if ( (selCampObj.options[i].selected) && (selected_all < 1) )
				{
				temp_usergroup_choices = temp_usergroup_choices + '&user_group_filter[]=' + selCampObj.options[i].value;
				count++;
				if (selCampObj.options[i].value == 'ALL-ACTIVE')
					{selected_all++;}
				}
			}
		usergroupQS = temp_usergroup_choices;
		
		//hideDiv('campaign_select_list');
		
		// force a reload if the phone is changed
		if ( (temp_monitor_phone != monitor_phone) || (force_reload=='YES') )
			{
				var collapseOne = $("#btn-collapseOne").attr("aria-expanded");
				var collapseTwo = $("#btn-collapseTwo").attr("aria-expanded");
				var collapseThree = $("#btn-collapseThree").attr("aria-expanded");
				var collapseFour = $("#btn-collapseFour").attr("aria-expanded");
			reload_url = PHP_SELF + "?RR=" + RR + "&DB=" + DB + "" + groupQS + usergroupQS + "&adastats=" + adastats + "&SIPmonitorLINK=" + SIPmonitorLINK + "&IAXmonitorLINK=" + IAXmonitorLINK + "&usergroup=" + usergroup + "&UGdisplay=" + UGdisplay + "&UidORname=" + UidORname + "&orderby=" + orderby + "&SERVdisplay=" + SERVdisplay + "&CALLSdisplay=" + CALLSdisplay + "&PHONEdisplay=" + PHONEdisplay + "&CUSTPHONEdisplay=" + CUSTPHONEdisplay + "&with_inbound=" + with_inbound + "&monitor_active=" + monitor_active + "&monitor_phone=" + temp_monitor_phone + "&ALLINGROUPstats=" + ALLINGROUPstats + "&DROPINGROUPstats=" + DROPINGROUPstats + "&NOLEADSalert=" + NOLEADSalert + "&CARRIERstats=" + CARRIERstats + "&PRESETstats=" + PRESETstats + "&AGENTtimeSTATS=" + AGENTtimeSTATS + "&droppedOFtotal=" + droppedOFtotal + "" + "&collapseOne=" + collapseOne + "" + "&collapseTwo=" + collapseTwo + "" + "&collapseThree=" + collapseThree + "" + "&collapseFour=" + collapseFour + "";

		//	alert('|' + temp_monitor_phone + '|' + monitor_phone + '|\n' + reload_url);
			window.location.href = reload_url;
			}

		monitor_phone = document.REALTIMEform.monitor_phone.value;
		}
	gather_realtime_content();
	
	}


</script>
<STYLE type="text/css">
<!--
	.green {color: white; background-color: green}
	.red {color: white; background-color: red}
	.lightblue {color: black; background-color: #ADD8E6}
	.blue {color: white; background-color: blue}
	.midnightblue {color: white; background-color: #191970}
	.purple {color: white; background-color: purple}
	.violet {color: black; background-color: #EE82EE} 
	.thistle {color: black; background-color: #D8BFD8} 
	.olive {color: white; background-color: #808000}
	.lime {color: white; background-color: #006600}
	.yellow {color: black; background-color: yellow}
	.khaki {color: black; background-color: #F0E68C}
	.orange {color: black; background-color: orange}
	.black {color: white; background-color: black}
	.salmon {color: white; background-color: #FA8072}

	.r1 {color: black; background-color: #FFCCCC}
	.r2 {color: black; background-color: #FF9999}
	.r3 {color: black; background-color: #FF6666}
	.r4 {color: white; background-color: #FF0000}
	.b1 {color: black; background-color: #CCCCFF}
	.b2 {color: black; background-color: #9999FF}
	.b3 {color: black; background-color: #6666FF}
	.b4 {color: white; background-color: #0000FF}
<?php
	$stmt="select group_id,group_color from vicidial_inbound_groups;";
	$rslt=mysql_to_mysqli($stmt, $link);
	if ($DB) {echo "$stmt\n";}
	$INgroups_to_print = mysqli_num_rows($rslt);
		if ($INgroups_to_print > 0)
		{
		$g=0;
		while ($g < $INgroups_to_print)
			{
			$row=mysqli_fetch_row($rslt);
			$group_id[$g] = $row[0];
			$group_color[$g] = $row[1];
			echo "   .csc$group_id[$g] {color: black; background-color: $group_color[$g]}\n";
			$g++;
			}
		}

echo "\n-->\n
</STYLE>\n";

$stmt = "select count(*) from vicidial_campaigns where active='Y' and campaign_allow_inbound='Y' $group_SQLand;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$row=mysqli_fetch_row($rslt);
$campaign_allow_inbound = $row[0];

echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">\n";
echo "<TITLE>$report_name: $group</TITLE></HEAD><BODY BGCOLOR=WHITE marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";

	$short_header=1;

	//require("admin_header.php");
echo "<div class='container' >";

echo "<FORM ACTION=\"$PHP_SELF\" METHOD=GET NAME=REALTIMEform ID=REALTIMEform>\n";
echo "<INPUT TYPE=HIDDEN NAME=cursorX ID=cursorX>\n";
echo "<INPUT TYPE=HIDDEN NAME=cursorY ID=cursorY>\n";

#echo "<INPUT TYPE=HIDDEN NAME=RR ID=RR VALUE=\"$RR\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=DB ID=DB VALUE=\"$DB\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=adastats ID=adastats VALUE=\"$adastats\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=SIPmonitorLINK ID=SIPmonitorLINK VALUE=\"$SIPmonitorLINK\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=IAXmonitorLINK ID=IAXmonitorLINK VALUE=\"$IAXmonitorLINK\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=usergroup ID=usergroup VALUE=\"$usergroup\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=UGdisplay ID=UGdisplay VALUE=\"$UGdisplay\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=UidORname ID=UidORname VALUE=\"$UidORname\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=orderby ID=orderby VALUE=\"$orderby\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=SERVdisplay ID=SERVdisplay VALUE=\"$SERVdisplay\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=CALLSdisplay ID=CALLSdisplay VALUE=\"$CALLSdisplay\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=PHONEdisplay ID=PHONEdisplay VALUE=\"$PHONEdisplay\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=CUSTPHONEdisplay ID=CUSTPHONEdisplay VALUE=\"$CUSTPHONEdisplay\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=DROPINGROUPstats ID=DROPINGROUPstats VALUE=\"$DROPINGROUPstats\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=ALLINGROUPstats ID=ALLINGROUPstats VALUE=\"$ALLINGROUPstats\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=CARRIERstats ID=CARRIERstats VALUE=\"$CARRIERstats\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=PRESETstats ID=PRESETstats VALUE=\"$PRESETstats\">\n";
#echo "<INPUT TYPE=HIDDEN NAME=AGENTtimeSTATS ID=AGENTtimeSTATS VALUE=\"$AGENTtimeSTATS\">\n";

echo '<div class="page-header"><h1>'._QXZ("$report_name").'</h1></div>';
echo "<span  id=campaign_select_list_link>\n";
echo "</span>\n";
echo '<!-- Modal -->
<div class="modal fade" id="broadCastModal" tabindex="-1" role="dialog" aria-labelledby="broadCastModalLabel" aria-hidden="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="broadCastModalLabel">Broad Cast</h4>
      </div>
      <div class="modal-body">';
echo '';
echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="sendBroadCast" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>';
echo '<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Report Display Options</h4>
      </div>
      <div class="modal-body">';
echo "<span  id=campaign_select_list>\n";
echo "<TABLE WIDTH=0 HEIGHT=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=\"#D9E6FE\"><TR><TD ALIGN=CENTER>\n";
echo "";
echo "</TD></TR></TABLE>\n";
echo "</span>\n";
echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="update_modal_data();" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>';
echo "<span  id=webphone_content>\n";
echo "<TABLE WIDTH=" . $webphone_bufw . " CELLPADDING=" . $webphone_pad . " CELLSPACING=0 BGCOLOR=\"white\"><TR><TD ALIGN=LEFT>\n";
//echo "$webphone_content\n$webphone_clpos\n";
echo "</TD></TR></TABLE>\n";
echo "</span>\n";
echo "<span id=agent_ingroup_display>\n";
echo " &nbsp; ";
echo "</span>\n";
echo '<ul class="nav nav-tabs">
  <li role="presentation" class="active">'."<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\" >"._QXZ("Choose Report Display Options")."</a>".'</li>
  <li role="presentation">'."<a href=\"#\" onclick=\"update_variables('form_submit','','YES')\">"._QXZ("RELOAD NOW")."</a>".'</li>';
if (preg_match('/ALL\-ACTIVE/i',$group_string))
	{echo '<li role="presentation">'."<a href=\"./index.php?ADD=10\">"._QXZ("MODIFY")."</a>".'</li>';}
else
	{echo '<li role="presentation">'."<a href=\"./index.php?ADD=34&campaign_id=$group\">"._QXZ("MODIFY")."</a></li>";}

echo '<li role="presentation"><a   href="#" data-toggle="modal" id="btn-broadCast" data-target="#broadCastModal">BROADCAST</a></li>';
echo '<li role="presentation">'."<a href=\"./AST_timeonVDADallSUMMARY.php?RR=$RR&DB=$DB&adastats=$adastats\">"._QXZ("SUMMARY")."</a> </li>";
echo "</ul>";
echo " &nbsp; &nbsp; &nbsp; "._QXZ("refresh").": <span id=refresh_countdown name=refresh_countdown></span>\n\n";
if ($is_webphone == 'Y')
	{echo " &nbsp; &nbsp; &nbsp; <span id=webphone_visibility name=webphone_visibility><a href=\"#\" onclick=\"ShowWebphone('show');\">"._QXZ("webphone")." +</a></span>\n\n";}
else
	{echo " &nbsp; &nbsp; &nbsp; <span id=webphone_visibility name=webphone_visibility></span>\n\n";}

if ($webphone_bufh > 10)
	{echo "<BR><img src=\"images/pixel.gif\" width=1 height=$webphone_bufh>\n";}
if ($adastats<2)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('adastats','');\"><font size=1><span id=adastatsTXT>+ "._QXZ("VIEW MORE")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('adastats','');\"><font size=1><span id=adastatsTXT>- "._QXZ("VIEW LESS")."</span></font></a>";}
if ($UGdisplay>0)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('UGdisplay','');\"><font size=1><span id=UGdisplayTXT>"._QXZ("HIDE USER GROUP")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('UGdisplay','');\"><font size=1><span id=UGdisplayTXT>"._QXZ("VIEW USER GROUP")."</span></font></a>";}
if ($SERVdisplay>0)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('SERVdisplay','');\"><font size=1><span id=SERVdisplayTXT>"._QXZ("HIDE SERVER INFO")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('SERVdisplay','');\"><font size=1><span id=SERVdisplayTXT>"._QXZ("SHOW SERVER INFO")."</span></font></a>";}
if ($CALLSdisplay>0)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('CALLSdisplay','');\"><font size=1><span id=CALLSdisplayTXT>"._QXZ("HIDE WAITING CALLS")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('CALLSdisplay','');\"><font size=1><span id=CALLSdisplayTXT>"._QXZ("SHOW WAITING CALLS")."</span></font></a>";}
if ($ALLINGROUPstats>0)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('ALLINGROUPstats','');\"><font size=1><span id=ALLINGROUPstatsTXT>"._QXZ("HIDE IN-GROUP STATS")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('ALLINGROUPstats','');\"><font size=1><span id=ALLINGROUPstatsTXT>"._QXZ("SHOW IN-GROUP STATS")."</span></font></a>";}
if ($PHONEdisplay>0)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('PHONEdisplay','');\"><font size=1><span id=PHONEdisplayTXT>"._QXZ("HIDE PHONES")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('PHONEdisplay','');\"><font size=1><span id=PHONEdisplayTXT>"._QXZ("SHOW PHONES")."</span></font></a>";}
if ($CUSTPHONEdisplay>0)
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('CUSTPHONEdisplay','');\"><font size=1><span id=CUSTPHONEdisplayTXT>"._QXZ("HIDE CUSTPHONES")."</span></font></a>";}
else
	{echo " &nbsp; &nbsp; &nbsp; <a href=\"#\" onclick=\"update_variables('CUSTPHONEdisplay','');\"><font size=1><span id=CUSTPHONEdisplayTXT>"._QXZ("SHOW CUSTPHONES")."</span></font></a>";}

#echo "</TD></TR></TABLE>";
##### END header formatting #####

#echo "<TABLE CELLPADDING=4 CELLSPACING=0><TR><TD>";
/*echo '<div id="extinfo-containers" class="container padded">';
echo '<div id="SIP8001" class="box container-sipinfo" draggable="true" ondragstart="drag_start(event)" style="left: 553px; top: 349px;">
      <div class="box-header sip-border sip-header">
        <div class="close fright"><a href="#"><i class="fa fa-close"></i></a></div><div class="title">SIP&#x2F;8001</div>
      </div>
      <div class="box-content padded box-sipinfo">
          <div class="info-top"><div class="camp fleft">&nbsp;</div><div class="callstoday fright">&nbsp;</div></div><br />
          <div class="user">Offline</div>
          <div class="info-bottom"><div class="status fleft">&nbsp;</div><div class="time fright">&nbsp;</div></div>
      </div>
    </div>';
echo '</div>';*/
echo "<span id=realtime_content name=realtime_content></span>\n";






if ($db_source == 'S')
	{
	mysqli_close($link);
	$use_slave_server=0;
	$db_source = 'M';
	require("dbconnect_mysqli.php");
	}

$endMS = microtime();
$startMSary = explode(" ",$startMS);
$endMSary = explode(" ",$endMS);
$runS = ($endMSary[0] - $startMSary[0]);
$runM = ($endMSary[1] - $startMSary[1]);
$TOTALrun = ($runS + $runM);

$stmt="UPDATE vicidial_report_log set run_time='$TOTALrun' where report_log_id='$report_log_id';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);


?>
</FORM>
</div>
</BODY></HTML>
