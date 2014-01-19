<?php

//-----------------------------------------------------------
// DigPhp
// Licence : GNU GPL v3 : http://www.gnu.org/licenses/gpl.html
// Créateur : David Mercereau - david [.] mercereau [aro] zici [.] fr
// Home : http://dig.zici.fr
// Date : 02/2012
// Version : 0.1
// Dépendance : Pear Net_DNS
//----------------------------------------------------------- 

# Install pear net_dns : 
# bash~# pear install Net_DNS
# ref : http://pear.php.net/package/Net_DNS/redirected

error_reporting(E_ALL);

// Config
$ns_defaut='ns1.fdn.org';
$option_type = array(
                        'A'=>'A',
                        'AAAA'=>'AAAA',
                        'CNAME'=>'CNAME',
                        'NS'=>'NS',
                        'MX'=>'MX',
                        'TXT'=>'TXT',
                        'PTR'=>'PTR',
);

// Filtre
if (isset($_GET['ns']))
	$_GET['ns'] = filter_var($_GET['ns'], FILTER_SANITIZE_URL);
if (isset($_GET['domain']))
	$_GET['domain'] = filter_var($_GET['domain'], FILTER_SANITIZE_URL);

// Formulaire
echo '<h1>Dig</h1>
<p>Dig</p>
<form action="./" type="get">
<!-- Pour zici -->
<input type="hidden" value="dig" name="page" />
<!-- / Pour zici -->
	dig @';
	if (isset($_GET['ns']))
		echo '<input id="digns" value="'.$_GET['ns'].'" name="ns" type="text" title="Serveur dns" />';
	else
		echo '<input id="digns" value="'.$ns_defaut.'" name="ns" type="text" title="Serveur dns" />';
	echo'<select name="type">';
	foreach($option_type as $affichage=>$valeur)
	{
		if ($_GET['type'] == $valeur)
		{
				echo'<option value="'.$valeur.'" selected>'.$affichage.'</option>';
		}
		else
		{
				echo'<option value="'.$valeur.'">'.$affichage.'</option>';
		}
	}
	echo '</select>';
	if (isset($_GET['domain']))
		echo '<input value="'.$_GET['domain'].'" name="domain" type="text" title="domaine" />';
	else
		echo '<input value="" name="domain" type="text" title="domaine" />';
	echo '<input name="submit" type="submit" value="Go" />
</form>';

// Résolution
if (isset($_GET['domain']) && isset($_GET['ns']) && isset($_GET['type']))
{
	# http://pear.php.net/manual/fr/package.networking.net-dns.php
	require_once 'Net/DNS.php';
	$resolver = new Net_DNS_Resolver();
	$resolver->debug = 1; // Turn on debugging output to show the query
	$resolver->usevc = 1; // Force the use of TCP instead of UDP
	$resolver->nameservers = array(         // Set the IP addresses
							   $_GET['ns']  // to query.
							   );
	echo '<textarea id="digresultat" rows="25" cols="70">';
	$response =  $resolver->query($_GET['domain'], $_GET['type']);
	if (! $response) {
	  echo "\n";
	  echo "ANCOUNT is 0, therefore the query() 'failed'\n";
	  #echo "See Net_DNS_Resolver::rawQuery() to receive this packet\n";
	}
	echo '</textarea>';
}
?>

