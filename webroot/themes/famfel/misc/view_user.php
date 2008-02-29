<?php 
global $user;
$user = user_load(array("name" => $user->name)); 

if($user->uid > 0):?>

<table id="famfel_user_info" class="famfel_tables">
	<tr>
		<td class="lables"><strong>User Name</strong></td><td><?php echo $user->name;?></td>
	</tr>
	<tr>
		<td class="lables"><strong>Email Address</strong><br /><a href="/user/<?php echo $user->uid;?>/edit">Edit Email</a></td><td valign="top"><?php echo $user->mail;?></td>
	</tr>
	<tr>
		<td class="lables"><strong>Full Name</strong></td><td><?php echo $user->profile_full_name;?></td>
	</tr>
	<tr>
		<td valign="top" class="lables"><strong>Address</strong></td>
		<td>
			<?php echo $user->profile_street_address;?><br />
			<?php echo (strlen($user->profile_street_address_2)?$user->profile_street_address_2.'<br />':null);?>
			<?php echo $user->profile_city.', '.$user->profile_state_province;?><br />
			<?php echo $user->profile_country;?>
		</td>
	</tr>
	<?php if (isset($user->profile_current_plan)): ?>
	<tr>
		<td class="lables"><strong>Subscription Plan</strong><br /><a href="https://familyfellowship.com/change_plan">Click here to change</a></td><td valign="top"><?php echo $user->profile_current_plan;?></td>
	</tr>
	<?php endif; ?>
</table>
<a href="/user/<?php echo $user->uid;?>/edit/Step+3%3A+My+Contact+Information">Edit My Account Info</a>

<?php else:?>

<h3>You must login to see view this section.</h3>
<p>Not yet a FamilyFellowship.com member?  <a href="/buy_now">Click here to signup!</a></p>
<p>Forgot your FamilyFellowship.com website account password?  <a href="/user/password">Click here to request a new one</a>.</p> 

<p>
Enter your FamilyFellowship.com Website Username and Password to login. This will only log you in to this website. <strong>To manage your FamilyFellowship.com Internet Filter, please login to your Profile Manager</strong>.
</p>

<form action="/user/login"  method="post" id="user-login">
<div><div class="form-item">
 <p><label for="edit-name">Username: <span class="form-required" title="This field is required.">*</span></label>
 <input type="text" maxlength="60" name="name" id="edit-name"  size="30" value="" tabindex="1" class="form-text required" /></p>
 <div class="description"><p>Enter your Family Fellowship username.</p></div>
</div>
<div class="form-item">
 <p><label for="edit-pass">Password: <span class="form-required" title="This field is required.">*</span></label>
 <input type="password" name="pass" id="edit-pass"  size="30"  tabindex="2" class="form-text required" /></p>
 <div class="description"><p>Enter the password that accompanies your username.</p>
</div>
</div>
<input type="hidden" name="form_id" id="edit-user-login" value="user_login"  />
<input type="submit" name="op" id="edit-submit" value="Log in"  tabindex="3" class="form-submit" />

</div></form>

<?php endif;?>