<?php
/**
* 
*/
class CreditCardClas
{
	function create($fisrtname, $lastname, )
	{
		
		$content .= '
		<form method="post" action="subscription_create2.php">
			<label for="fname">Fist Name</label><input type="text" name="firstName" id="fname" value="" />
			<label for="lname">Last Name</label><input type="text" name="lastName" id="lname" value="" />
			<label for="email">Email</label><input type="text" name="email" id="email" value="" />
			<label for="subscription">Subscription Level</label>
			<input type="hidden" name="subscription" value="'.$subscription.'" />
			<label for="cardNumber">Credit Card Number</label><input type="text" name="cardNumber" id="cardNumber" value="5424000000000015" />
			<label for="expirationDate">Credit Card Expiration</label><input type="text" name="expirationDate" id="expirationDate" value="2009-09" />
			<input type="submit" name="submit" value="Subscribe!" />
		</form>';
		/*
			<select id="subscription" name="subscription">
				<option value="1">Month-to-month</option>
				<option value="2">Quarterly</option>
				<option value="3">Semi Annual</option>
				<option value="4">Annual</option>
			</select>
		*/
	}
}

?>