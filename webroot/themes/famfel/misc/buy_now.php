<?php
global $user; 
// $user = user_load(array("name" => $user->name));
?>
<p style="width: 170px; float:right; margin-right: 10px; margin-left:10px; text-align:center;">
<img src="/files/images/image003.jpg" alt="FamilyFellowship.com" />
</p>
<p>
With Price tiers that are sure to fit any budget, FamilyFellowship.com provides a Christ centered internet management filtering solution perfect for your home.
</p>

<p>
Just pick from one of the subscription levels below to begin your enjoyable journey of having your internet experience based upon your Christian family values! Each of our plans includes the ability to filter up to five(5) PC's or Laptops.
</p>


<div class="break" style="clear:both;"></div>

<table id="store_table"><thead><th>Plan</th><th>Price</th><th>Equivalent to</th><th>&nbsp;</th></thead>

<!-- ONE MONTH PLAN -->
<tr><td><strong>
<!-- NAME -->
Month-to-month

</strong></td><td>
<!-- PRICE -->
<span class="pop"><strong>*</strong> $5.95</span>

</td><td>
<!-- MONTHLY -->
<span class="pop">$5.95 per month</span>

<?if($user->uid > 0):?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/change_plan">Change your Plan!</a></td></tr>
<?else:?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/user/register">Signup now!</a></td></tr>
<?endif;?>

<tr><td colspan="4" style=" border-bottom: 2px solid #ccc; padding: 20px 0;">* 30 Day Money Back Guarantee applies to Month-to-month subscription ONLY. <a href="/guarantee">click here</a> for details.</span></td></tr>



<!-- QUARTERLY PLAN -->
<tr><td><strong>
<!-- NAME -->
Quarterly

</strong></td><td>
<!-- PRICE -->
$15.95

</td><td>
<!-- MONTHLY -->
$5.31 per month

<?if($user->uid > 0):?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/change_plan">Change your Plan!</a></td></tr>
<?else:?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/user/register">Signup now!</a></td></tr>
<?endif;?>

<!-- SEMI-ANNUAL PLAN -->
<tr><td><strong>
<!-- NAME -->
Semi-Annual

</strong></td><td>
<!-- PRICE -->
$27.95

</td><td>
<!-- MONTHLY -->
$4.65 per month

<?if($user->uid > 0):?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/change_plan">Change your Plan!</a></td></tr>
<?else:?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/user/register">Signup now!</a></td></tr>
<?endif;?>

<!-- ANNUAL PLAN -->
<tr><td><strong>
<!-- NAME -->
Annual

</strong></td><td>
<!-- PRICE -->
$49.95

</td><td>
<!-- MONTHLY -->
$4.16 per month

<?if($user->uid > 0):?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/change_plan">Change your Plan!</a></td></tr>
<?else:?>
</td><td><a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/user/register">Signup now!</a></td></tr>
<?endif;?>


</table>


<!-- (c) 2006. Authorize.Net is a registered trademark of Lightbridge, Inc. --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="c5417078-6db6-46e5-a319-dd644d5901be";</script> <script type="text/javascript" language="javascript" src="http://VERIFY.AUTHORIZE.NET/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payments</a> </div>



<p>Shop with confidence at FamilyFellowship.com.  See our <a href="/secure_shopping">secure shopping page</a>.</p>
<img src="files/images/visa_mc_amex_disc_239x40.gif" />
