<?php
#############################################################
# name		:	sweeper_account.php							#
# Function	:	Sweeper Server Account Management Class		#
# Author	:	Nathan R. Garza								#
# Copyright	:	2007 AshLeaf Media -- All Rights Reserved	#
# Location	:	forthcoming									#
#############################################################

class SweeperAccount
{
	var $url = "http://sweeper.familyfellowship.com/webadmin/api/";
	var $command = "account_create.php";
	var $organization = "FamilyFellowship";
	var $classification = "user";
	var $connection;
	
	function SweeperAccount()
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
	
	function addAccount($login,$password,$email,$f_name,$l_name,$expiration = null)
	{
		$args = func_get_args();
		$post_fields = "login=$login&password=$password&organization={$this->organization}&classification={$this->classification}&email_address=$email&first_name=$f_name&last_name=$l_name&ttl=$expiration";
		$result = $this->curlStuff($post_fields);
		$pos = strpos($result, 'ERROR');
		if ($pos) {
			$pos2 = strpos($result, 'Account already exists:');
		}
		
		if ($pos && !$pos2) {
			return false;
		} else {
			return $result;
		}
	}
	
	function verifyAccount($login)
	{
		$this->command = "account_query.php";
		$post_fields = "login=$login";
		$result = $this->curlStuff($post_fields);
		if (strpos($result, "OK") !== false) {
			$status = true;
		} else {
			$status = false;
		}
		return $status;
	}
	
	function editAccount($login, $options)
	{
		// //stub it out
		// return true;
		$this->command ="account_edit.php";
		$post_fields = "login=$login";
		foreach ($options as $key => $value) {
			$post_fields .= "&$key=$value";
		}
		$result = $this->curlStuff($post_fields);
		return result;
	}
	
	function deleteAccount($login,$group = null)
	{
		$this->command = "account_delete.php";
		$post_fields = "login=$login&usergroups=$group";
		$result = $this->curlStuff($post_fields);
		return $result;
	}
	
	function curlStuff($post_fields)
	{
		curl_setopt($this->connection, CURLOPT_URL, $this->url.$this->command);
		curl_setopt($this->connection, CURLOPT_AUTOREFERER, 1);
		curl_setopt($this->connection, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->connection, CURLOPT_POST, 1);
		curl_setopt($this->connection, CURLOPT_POSTFIELDS, $post_fields);
		$result = curl_exec ($this->connection);
		return $result;
	}
}

?>