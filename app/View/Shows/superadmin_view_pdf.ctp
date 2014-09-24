<html>
<head>
<title>CAREER FAIR EXHIBITOR GUIDE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	font-family: "Times New Roman", Times, serif;
	color: #000000;
}
.td1 {
	font-size: 15px; 
	text-align: right; 
	padding-top: 10px; 
	font-weight: normal;
}
.td2 {
	font-size: 15px; 
	text-align: left; 
	padding-left: 25px; 
	padding-top: 10px; 
	font-weight: normal;
}
.subhead1 {
	font-size: 15px; 
	text-align: left;
	border-bottom: solid 1px #000000;
}
.topright {
	font-size: 15px; 
	border-left: solid 1px #000000;
	padding-left: 20px; 
	font-weight: normal;
}

</style>
</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="right" width="50%" style="padding-right: 20px;">
	<img src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/TECHEXPO_HIRINGEVENTS_PDF.png" width="400px" height="60px">
      
	</td>	
	<td class="topright" width="50%" align="left">
		276 5th Avenue, Suite 906<br />
		New York, New York 10001<br />
		(212) 655-4505 ext. 225<br />
	</td>
	</tr>
<tr><td style="font-size: 18px; text-align: center; padding-top: 35px;" colspan="3">CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%">EVENT OVERVIEW</td>
	</tr>
	<tr>
		<td width="25%" class="td1">Event Date:</td>
		<td width="75%" class="td2"><?php  echo date('l,F d Y',strtotime($show['Show']['show_dt'])); ?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="25%" class="td1">Event Location:</td>
		<td width="75%" class="td2"><?php echo $show['Show']['show_name']; ?> <br />
									<?php echo $show['Location']['site_name'].' '.$show['Location']['site_address']; ?><br />
									<?php echo $show['Location']['location_city'].", ".$show['Location']['location_state']." ".$show['Location']['site_zip']; ?><br />
									410.859.8300
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="25%" class="td1">Event Scope:</td>
		<td width="75%" class="td2"><?php echo $show['ShowsHome']['special_message']; ?></td>
	</tr>
</table>	
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%">EVENT SCHEDULE</td>
	</tr>
	<tr valign="top">
		<td width="25%" class="td1"><?php echo $show['Show']['show_hours']; ?></td>
		<td width="75%" class="td2"><?php echo $show['Show']['show_descr']; ?></td>
	</tr>
</table>	
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%">IMPORTANT CONTACT INFORMATION</td>
	</tr>
	<tr valign="top">
		<td width="25%" class="td1">Events Director:</td>
		<td width="75%" class="td2">Nancy Mathew 212.655.4505 ext. 225</td>
	</tr>
</table>
</body>
</html>

