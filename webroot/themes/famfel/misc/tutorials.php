<?php 
global $user;
$user = user_load(array("name" => $user->name)); 

if($user->uid > 0):
?>
<img src="/themes/famfel/img/tutorials_top.jpg" alt="Let us help you make a christ centered, family friendly internet experience!" />
<h2>Welcome to the FamilyFellowship.com Video Tutorial Library</h2>
<p>
	<strong>Here is where we show you how to get the most out of your Filtering by
	offering easy to understand video with voice tutorials.</strong>
</p>
<p>
	<strong>** Note:</strong> To view these video's you will need to have
	either quicktime, or RealPlayer installed on your computer.  Click on the
	following links to obtain
	<a href="http://www.apple.com/quicktime/download/" target="_blank">QuickTime</a>
	| <a href="http://www.real.com/" target="_blank">RealPlayer</a>
</p>
<p>
	<strong>If you’re not sure</strong> if you have Quick time or Real player – Click on the
	video – if it plays, all is fine, if not – please select one of these:
	<a href="http://www.apple.com/quicktime/download/" target="_blank">QuickTime</a>
	or
	<a href="http://www.real.com/" target="_blank">RealPlayer</a>.
	Each will take you to the free down load of each
	player. When completed please return to the Tutorials
</p>
<p>
	<strong>** Note:</strong> If you use a Dial up connection you will experience a slight wait while the video loads before the video will play
</p>
<h3>The Basics &mdash; Getting Started</h3>
<p><strong>The first item you need to know is:</strong></p>
<h3>How to open the profile manager:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/01-ff-open-profile-manager-candidate.mov">here</a> to view this video.  It will open in a new window.
	</p>
</li>
</ul>
<p>
	You viewed the front page of the profile manager when you entered your 1st time login information after you down loaded your filter for the 1st time. 
</p>
<p>
	This Video is designed to show you how to access your profile manager at the time of your 1st time login, as well as, to how to open and access your profile manager any time thereafter. 
</p>

<p><strong>I need to Know how to make a new profile:</strong></p>

<h3>Create a new Profile:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/02-create_new_profile.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Setting the Default Profile:</h3>
<ul>
<li>
	<p><em>This is an important / useful item when you would like your children’s or your  computer to start up each time with their profile you made for them or yourself.</em></p>

	<p>
		Click <a target="_blank" href="/files/video/05_ff_default_profile-01.mov">here</a>.  The video will open in
		a separate window and may take some time to download, depending on your connection speed.
	</p>
</li>
</ul>


<h3>Allow/Deny Internet Access:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/03-allow_deny_all_01.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Switch Profiles:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/06_ff_switch_profiles.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Change your profile password:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/07_ff_change_profile_password.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Manage Emailed Reports:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/08_ff_email_reports.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Categories:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/09_ff_categories.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Protocols:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/10_ff_protocals.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Allow/Deny Lists:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/11_ff_allow_deny_list.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>What to do when your profile manager times out:</h3>
<ul>
<li>
	<p>If you take too long to change your profile settings your will be logged out of the Profile Manager.  Don't worry!  It's a normal function, with a simple fix.  See this movie to find out how.</p>
	<p>
		Click <a target="_blank" href="/files/video/12_ff_timeout.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<h3>Block Internet Access by Time:</h3>
<ul>
<li>
	<p>
		Click <a target="_blank" href="/files/video/13_ff_time.mov">here</a>.
		The video will open in a separate window and may take some time to
		download, depending on your connection speed.
	</p>
</li>
</ul>

<p><a href="/my_account">Back to My Account Page</a></p>

<?php 
else:
drupal_goto("my_account");
?>
<p>
	To view our Members only tutorials, please log in <a href="/my_account">here</a>.
	Not a member yet? <a target="_blank" href="/buy_now">Click here to sign up!</a>
</p>
<?php endif;?>
