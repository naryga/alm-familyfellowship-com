<?php global $user; ?>
<img id="navigating" src="/themes/famfel/img/navigatingYourFamily.jpg" alt="Navigating Your Way Through The Internet" />

<p>Welcome to your FamilyFellowship.com Account!  From here you can gain access to our members only tutorials.  You can download the FamilyFellowship.com Filter Profile Manager Client to your PC.  You can also view or edit your contact information.</p>

<div id="account_info">
<h3>Account Info</h3>
<ul>
<li><a href="/my_account/view">View My Account Info</a></li>
<li><a href="/user/<?php echo $user->uid; ?>/edit/Step+3%3A+My+Contact+Information">Edit My Contact Info</a></li>
<li><a href="/user/<?php echo $user->uid; ?>/edit/">Change Password/Account Email Address</a></li>
<li><a href="https://familyfellowship.com/change_card">Change your credit card</a></li>
<li><a href="/cancel">Cancel My Account</a></li>
<li><a href="/logout">Log Out</a></li>
</ul>
</div>

<div id="guarantee3" class="left">
<h3>30 money back guarantee.</h3>
<p>
	You are eligible for our 30 Day Money Back Guarantee for
	<?php echo $daysLeft?> more days.
</p>
<a href="/cancel">Click here to Cancel your account</a>
<p><small>This action is irrevocable!</small></p>
</div>
<div class="clear"></div>
<div class="active_only">
<h3 style="text-align: center;">Down Load your familyfellowship.com Filter</h3>
<div class="guarantee2">
		<a href="/sweeper">Click here to download the filter.</a>
</div>
<p class="pop" style="text-align: center">IMPORTANT NOTICE:</p>
<p>
	Your FamilyFellowship.com
	filter account can be downloaded ONLY 5 (FIVE) times. 	<a href="#" id="showDescription">Click here for more info</a>
</p>

<div class="description2">
<p>
	Please be sure to keep track of how many times you have downloaded your 
	filter. <strong>If Exceeded, the Filter on the 6th computer will not work,</strong>
	this will cause you to be unable to access the Internet <strong>on that PC
	only</strong>. You will also notice you are unable to uninstall the filter.
	In the event that this happens please contact Customer Care with your
	Profile Manager User Name, stating the problem and we will be glad to
	resolve this issue for you.
	<a href="#" id="hideDescription">Click here to hide this info</a>
</p>
</div>
<br />
<h3 style="text-align: center; margin-top: 20px;">Filter Remote Access</h3>


<div class="guarantee2">
	<a href="http://sweeper.familyfellowship.com:8080/webadmin/clientlogin/" target="_blank">Click here for Remote Access to your Filter</a>
</div>
<p style="text-align: center;"><small><a href="#" id="showantivirus">Click here for more details</a></small></p>
<div class="antivirus">
	<p>Remote access grants you the ability to access your profile manager from any computer – anywhere, be it a Mac, Linux or Windows Operating system (OS).  You must be using the latest version of Internet Explorer, FireFox or Safari, and have an Internet Connection.</p>
	<p>When you click on the link for remote access you will see your Profile manager Login screen.</p>
	<p>Enter your Profile manager user name and password and you will then see your profile manager with all your profiles.</p>
	<p>This is great for when you are at work or out of town and would like to make changes to your children’s profiles or say you down loaded your filter on your parent(s) “The Grandparent(s)“ PC and they called you for assistance on how to manage a profile or set one up and you are at work. You get the idea.</p>
	<p><a href="#" id="hideantivirus">Click here to hide this information</a></p>
</div>

<h3>Support</h3>
<ul>
<li><a href="/customer_care/tutorials">View our Members only Video Tutorials</a></li>
<li><a href="/faq">View our Members only F.A.Q.</a></li>
<li><a href="/customer_care">Contact Customer Care</a></li>
</ul>
</div><!-- end active_only -->

<h3>Forgot the following info? Retrieve it here</h3>
<ul>
<!--<li><a href="/user/<?php echo $user->uid;?>/edit">FamilyFellowship.com Account password</a></li>-->
<li><a href="/customer_care/profile_password_retrieval">FamilyFellowship.com Filter Profile Manager Password</a> &mdash; Requires your Security Question and Answer</li>
<li><a href="customer_care/profile_security_retrieval">Your Security Question and Answer</a> &mdash; Requires your Profile Manager Username and Password.</li>
</ul>