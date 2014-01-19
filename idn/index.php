<?php
$encoded = $decoded = $add = '';
header('Content-Type: text/html; charset=utf-8');
require_once('idna_convert.class.php');

$idn_version = isset($_REQUEST['idn_version']) && $_REQUEST['idn_version'] == 2003 ? 2003 : 2008;
$IDN = new idna_convert(array('idn_version' => $idn_version));

$version_select = '<select size="1" name="idn_version"><option value="2003">IDNA 2003</option><option value="2008"';
if ($idn_version == 2008) {
    $version_select .= ' selected="selected"';
}
$version_select .= '>IDNA 2008</option></select>';

if (isset($_REQUEST['encode'])) {
    $decoded = isset($_REQUEST['decoded']) ? stripslashes($_REQUEST['decoded']) : '';
    $encoded = $IDN->encode($decoded);
}
if (isset($_REQUEST['decode'])) {
    $encoded = isset($_REQUEST['encoded']) ? stripslashes($_REQUEST['encoded']) : '';
    $decoded = $IDN->decode($encoded);
}
$lang = 'en';
if (isset($_REQUEST['lang'])) {
    if ('de' == $_REQUEST['lang'] || 'en' == $_REQUEST['lang']) $lang = $_REQUEST['lang'];
    $add .= '<input type="hidden" name="lang" value="'.$_REQUEST['lang'].'" />'."\n";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phlyLabs Punycode Converter</title>
<meta name="author" content="phlyLabs" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">
/*<![CDATA[*/
/*]]>*/
</style>
</head>
<body>
 <h1>IDN Converter</h1><br />
 <br />
 <table border="0" cellpadding="2" cellspacing="2" align="center">
  <thead>
   <tr>
    <th align="left">Original (Unicode)</th>
    <th align="right">Punycode (ACE)</th>
   </tr>
  </thead>
  <tbody>
   <tr>
    <td align="right">
     <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="get">
      <input type="text" name="decoded" value="<?php echo htmlspecialchars($decoded, ENT_QUOTES, 'UTF-8'); ?>" size="48" maxlength="255" /><br />
      <?php //echo $version_select; ?>
      <input type="submit" name="encode" value="Encode &gt;&gt;" /><?php echo $add; ?>
     </form>
    </td>
    <td align="left">
     <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="get">
      <input type="text" name="encoded" value="<?php echo htmlspecialchars($encoded, ENT_QUOTES, 'UTF-8'); ?>" size="48" maxlength="255" /><br />
      <input type="submit" name="decode" value="&lt;&lt; Decode" /><?php echo $add; ?>
     </form>
    </td>
   </tr>
  </tbody>
 </table>
 <br />
</div>
</body>
</html>
