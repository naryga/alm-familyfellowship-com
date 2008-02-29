<?php

$test = true;

echo "<h1>Hi there.  Here's what we've got:</h1>";


if ($test == true or $test == 'local'):
	$_POST = $_GET;
?>
	<a href="/anet_aid_parser.php?x_invoice_num=101_33603&x_response_code=1&x_amount=5.95">Click here to test a successfull $5.95</a>
	<a href="/anet_aid_parser.php?x_invoice_num=101_33595&x_response_code=2&x_amount=5.95">Click here to test a failed $5.95</a>
	<a href="/anet_aid_parser.php?x_invoice_num=101_&x_response_code=2&x_amount=5.95">Click here to test a non aid (fail)</a>
	<a href="/anet_aid_parser.php?x_invoice_num=101_&x_response_code=1&x_amount=5.95">Click here to test a non aid (pass)</a>
	
<?
endif;

echo "<pre>";
print_r($_GET);
echo "</pre>";

echo "<pre>";
print_r($_POST);
echo "</pre>";

if (count($_POST) > 1) {
	
	$invoice_array = explode('_', $_POST['x_invoice_num']);
	print_r($invoice_array);
	if ($invoice_array[1] != null && ($_POST['x_response_code'] == 1 || $test == true)) {
		echo "<h2>We're in...</h2>";
		$aid = $invoice_array['1'];
		
		
		$aid_commission = new AIDInterface;
		
		switch ($_POST['x_amount']) {
			case '5.95':
				$cm1 = '1.00';
				break;
			case '15.95':
				$cm1 = '3.00';
				break;
			case '27.95':
				$cm1 = '6.00';
				break;
			case '49.95':
				$cm1 = '12.00';
				break;
			default:
				$cm1 = '1.00';
				break;
		}

		$did_it_work = $aid_commission->reportCommission($_POST['x_amount'], $_POST['x_invoice_num'], $aid, $cm1);
		
		$aid_commission->destruct();
	} else {
		$did_it_work = "no it didn't";
	}
	
	echo $did_it_work;
	
	$body = "Here are the results, folks\n";


	foreach ($_POST as $id => $value){
		$body.= "$id >> $value \n\n";
	}
	
	$body .= $did_it_work;
	
	mail("nathan@ashleafmedia.com", "[FamilyFellowship.com silent URL test settings]",$body);
}

#############################################################
# name		:	sweeper_account.php							#
# Function	:	Sweeper Server Account Management Class		#
# Author	:	Nathan R. Garza								#
# Copyright	:	2007 AshLeaf Media -- All Rights Reserved	#
# Location	:	forthcoming									#
#############################################################

class AIDInterface
{
	var $url = "https://interneka.com/affiliate/";
	var $command = "WIDLink.php";
	var $connection;
	var $wid = 824;
	
	function AIDInterface()
	{
		$this->connection = curl_init();
		if($this->connection)
		{
		}
		else
		{
		}
		
	}
	
	function destruct()
	{
		curl_close($this->connection);
		unset ($this->connection);
		if(!$this->connection)
		{
			
		}
		else
		{
			
		}
	}
	
	function reportCommission($totalCost, $orderId, $aid, $cm1)
	{
		$args = func_get_args();
		// $post_fields = "login=$login&password=$password&organization={$this->organization}&classification={$this->classification}&email_address=$email&first_name=$f_name&last_name=$l_name&ttl=$expiration";
		$post_fields = "WID={$this->wid}&TotalCost=$totalCost&OrderId=$orderId&AID=$aid&cm1=$cm1&Recuring=yes";
		$result = $this->curlStuff($post_fields);
		return $result;
		// $pos = strpos($result, 'ERROR');
		// if ($pos) {
		// 	$pos2 = strpos($result, 'Account already exists:');
		// }
		// 
		// if ($pos && !$pos2) {
		// 	return false;
		// } else {
		// 	return $result;
		// }
	}
	
	function curlStuff($post_fields)
	{
		echo $this->url.$this->command.'?'.$post_fields;
		curl_setopt($this->connection, CURLOPT_URL, $this->url.$this->command.'?'.$post_fields);
		curl_setopt($this->connection, CURLOPT_AUTOREFERER, 1);
		curl_setopt($this->connection, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->connection, CURLOPT_POST, 0);
		// curl_setopt($this->connection, CURLOPT_POSTFIELDS, $post_fields);
		$result = curl_exec ($this->connection);
		return $result;
	}
}

?>