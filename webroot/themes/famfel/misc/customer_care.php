<div class="column">
<p><strong>Tutorials:</strong></p>
<p>
Feel free to view our video over view of the FamilyFellowship.com Profile Manager <a href="/files/video/ff_public_intro.mov" target="_blank">here</a>.
</p>
<p>
<a href="/customer_care/tutorials">Click here</a> to view all of our Members Only Video Tutorials, covering every aspect of the FamilyFellowship.com Globally Managed Internet Filter.
</p>
</div>

<div class="column">
<p><strong>F.A.Q.</strong></p>
<P>
Have a question about FamilyFellowship.com?  Please read through our Frequently Asked Questions (FAQ)! <a href="/faq">Click here to view our FAQ page</a>
</p>
</div>
		
<div class="column">
<p><strong>Contact Us</strong></p>
<p>Technical, Billing and Sales Support:</p>
<p>Toll Free: 1-877-873-2300<br />
Hours: 8<small>AM</small> CST - 5<small>PM</small> CST<br />
<em><a href="/after_hours">Limited After Hours Support Available</a></em>
</p>

</div>
<div style="clear:both;"></div>
		<span class="hr"><hr /></span>
	        <?php print_r(theme_status_messages('error')); ?>
		<p>
			<span class="pop">Please Note:</span> To better serve you, if you
			already have an account with us and you are contacting us for support, please enter your
			My Account login user name, as well as the email address
			and phone number you used when you signed up for your account. Thank you!
		</p>
		<p><a href="#" class="toglecontrol">Click here for important email delivery information</a></p>
		<p class="togle">To ensure that you receive all communications from FamilyFellowship.com Customer Care, please add support@familyfellowship.com to your email program's address book, contact list or white list.</p>
		<form action="/customer_care/contact" method="post">
			<input type="hidden" name="cid" id="edit-cid" value="1" />
			<input type="hidden" name="subject" id="edit-subject" />
			<div id="left_fields">
				<p>
					<label for="edit-uname"><span>My Account User Name</span> <input name="uname" id="edit-uname" class="text" type="text" /></label>
					<span class="pop"><small>Current users only</small></span>
				</p>
				<p>
					<label for="edit-name"><span>Name</span> <input name="name" id="edit-name" class="text" type="text" /></label>
				</p>
				<p>
					<label for="edit-telephone"><span>Telephone</span> <input name="phone" id="edit-telephone" class="text" type="text" /></label>
				</p>
				<p>
					<label for="edit-email"><span>Email</span> <input name="email" id="edit-email" class="text" type="text" /></label>
				</p>
			</div>
			<textarea id="edit-message" name="message" class="help"></textarea>
			<input id="submitBtn" onmouseout="this.src='/themes/famfel/img/submit.jpg'" onmouseover="this.src='/themes/famfel/img/submit_over.jpg'" type="image" src="/themes/famfel/img/submit.jpg" />
<!--input type="submit" value="Submit Query" /-->
		</form>