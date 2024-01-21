<html>
<head>
<title><?php echo $pagetitle; ?></title>
</head>
<body style="margin-top:20px;margin-left:20px;margin-right:20px;">
<table width="100%" border="0" cellpadding="10" cellspacing="0"border="0">
<tr bgcolor="#33FFFF">
<td colspan="5"><h2>Template Specific Header</h2></td>
</tr>
<tr bgcolor="#EEEEEE">
<td nowrap><a href=#">Navigation Link 1</a></td>
<td nowrap><a href="#">Navigation Link 2</a></td>
<td nowrap><a href="#">Navigation Link 3</a></td>
<td nowrap><a href="#">Navigation Link 4</a></td>
<td width="100%">&nbsp;</td>
</tr>
</table>
<br />
<table width="100%" cellpadding="10" cellspacing="0" border="0">
<tr>
<td width="30%" valign="top" bgcolor="#EEEEEE"><strong>Template Specific 
Navigation</strong><br /><br />
<a href="#">Link 1</a><br />
<a href="#">Link 2</a><br />
<a href="#">Link 3</a><br />
</td>
<td width="70%" valign="top"><?php 
echo $pagemaincontent; 
?></td>
</tr>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="10" border="0">
<tr>
<td colspan="2" bgcolor="#33FFFF">Template Specific Footer</td>
</tr>
</table>
</body>
</html>
