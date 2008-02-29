<?php

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
	var $wid = '824';
	
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
		$post_fields = "WID={$this->wid}&TotalCost=$totalCost&OrderID=$orderId&AID=$aid&cm1=$cm1&Recuring=no";
		$result = $this->curlStuff($post_fields);
		return $result;
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