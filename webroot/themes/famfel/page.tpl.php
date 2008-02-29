<?php
global $user;
if ($user->uid > 0) {
	$user = user_load(array("name" => $user->name));
	$loggedin = true;
	
}
else {
	$loggedin = false;
}
$cutOffDate = ($user->created + (30 * 24 * 60 * 60));
if( $cutOffDate > time() && in_array($user->profile_current_plan, array("Month-to-month","Month-to-Month","month")) )
{
	$daysLeft = number_format(($cutOffDate - time()) / 60 / 60 / 24);
	$guarantee = true;
}
else
{
	$guarantee = false;
}

if ($_GET['AID']) { $_SESSION['AID'] = $_GET['AID']; } 
elseif ($_POST['AID']) { $_SESSION['AID'] = $_POST['AID']; }

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">

<head>
	<title><?php print $head_title; ?></title>
	<?php print $head; ?>
	<?php print $styles; ?>
	<style type="text/css" media="all">@import "/modules/htmlarea/xinha/Xinha.css";</style>
	<?php print $scripts; ?>
	<script type="text/javascript">
    // Your code goes here
	$(document).ready(function(){
	   	$("div.description2").hide();
		$("div.antivirus").hide();
		$('div.cookies').hide();
		$('p.togle').hide();
		$("a#showDescription")
			.click(function(){
		       $("div.description2").show("slow");
		       return false;
		     });
		$("a#hideDescription")
			.click(function(){
				$("div.description2").hide('slow');
				return false;
			});
		$("a#showcookies")
			.click(function(){
				$("div.cookies").show("slow");
				return false;
			});
		$("a#hidecookies")
			.click(function(){
				$("div.cookies").hide("slow");
				return false;
			});
		$("a#showantivirus")
			.click(function(){
				$("div.antivirus").show("slow");
				return false;
			});
		$("a#hideantivirus")
			.click(function(){
				$("div.antivirus").hide("slow");
				return false;
			});
		$("input#profile_syncronize_passwords")
			.change(function(){
				$("fieldset.hidder").slideToggle("slow");
			});
		$("a.toglecontrol")
			.click(function(){
				$("p.togle").slideToggle("slow");
				return false;
			})
	 });
  </script>
	<style>
	<?php
	$is_admin = array_key_exists('3', $user->roles);
	$is_active = array_key_exists('9', $user->roles);
	$is_delinquent = array_key_exists('7', $user->roles);
	$is_canceled = array_key_exists('8', $user->roles); 
		// echo $is_admin.'<br />'.$is_active.'<br />'.$is_delinquent.'<br />'.$is_canceled;
		// echo "<pre>". print_r($user->roles) . "</pre>";
	?>
	<?php if (!$is_admin):?>
		
		fieldset.collapsible,
		.profile-profile_subscription_id,
		.profile-profile_payment,
		.profile-profile_sweeper,
		.profile-profile_sweeper_username,
		.profile-profile_sweeper_password,
		.profile-profile_security_q,
		.profile-profile_security_a,
		.profile-profile_terms_of_service
		{display:none;}
		
	<?php endif; ?>	
	<?php if($is_delinquent || $is_canceled || !$is_active): ?>
		.active_only {display: none;}
	<?php else: ?>
		.active_only {display: block;}
	<?php endif; ?>
		#button_holder { position: absolute; top: 570px; right: 16px; width: 180px; }
		
		#guarantee { width: 100%; margin-right: 0;}
		#guarantee img, #vid_home img {display: block; margin: 0 auto;}
		#guarantee img {width: 158px;}
		#vid_home { text-align: center; margin-right: 0; }
		#vid_home img {width: 175px;}
		
		#guarantee3 img { position:absolute; }
		#guarantee3 img { top:570px; color:#314134; right:16px; }
		#guarantee, .guarantee2, #guarantee3 { text-align: center; }
		.guarantee2 a, #guarantee3 a { display: block; text-align: center; font-size: 16px; color: white; font-weight: bold; background: #6C9B70; border: 2px solidd #000; }
		#guarantee3 a, .guarantee2 a
		{
			text-decoration: none;
			padding:5px;
			margin: 15px 20px 15px 10px; 
			font-size: 14px;
		}
		.guarantee2 a:hover, #guarantee3 a:hover { background-color: #283E2D; }
		.seetuts { width: 280px; border-right: 1px solid #AF8459}
		.seetuts, .macUsers { float: left; }
		.seetuts .guarantee2 a, #guarantee a, #guarantee3 a {text-decoration:none;padding:10px; margin: 15px 20px 15px 10px; }
		.macUsers { width: 300px; }
		.macUsers p { padding-left: 20px; margin-top: 0px;}
		
		.mac_button2 {width: 300px;}
		.mac_button2 a {font-size: 12px;}
		
	<?php if(strpos($_SERVER['HTTP_USER_AGENT'],'IE 6') !== FALSE):?>
		.mac_button2 {display:inline;}
		#guarantee a, #guarantee3 a {height: 20px;}
		#button_holder { right: -10px;}
	<?php endif;?>
	
	<?php if(!$guarantee):?>
		#guarantee3 {display:none;}
	<?php else: ?>
		#account_info { float: left; display:inline; width: 250px; }
	<?php endif; ?>
	
	</style>
</head>

<?php
/**
* Create a <body> class and id for each page.
*
* - Class names are general, applying to a whole section of documents (e.g. admin or ).
* - Id names are unique, applying to a single page.
*/
// Remove any leading and trailing slashes.
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
// Split up the remaining URI into an array, using '/' as delimiter.
$uri_parts = explode('/', $uri_path);

// If the first part is empty, label both id and class 'main'.
if ($uri_parts[0] == '') {
    $body_id = 'main';
    $body_class = 'main';
}
else {
    // Construct the id name from the full URI, replacing slashes with dashes.
    $body_id = str_replace('/','-', $uri_path);
    // Construct the class name from the first part of the URI only.
    $body_class = $uri_parts[0];
}

if (strstr($uri_path, 'edit')) {
	$body_class .= " edit";
}
/**
* Add prefixes to create a kind of protective namepace to prevent possible
* conflict with other css selectors.
*
* - Prefix body ids with "page-"(since we use them to target a specific page).
* - Prefix body classes with "section-"(since we use them to target a whole sections).
*/
$body_id = 'page-'.$body_id;
$body_class = 'section-'.$body_class;
?>

<?php /* different ids allow for separate theming of the home page */ ?>

<body class="<?php print $body_class ?>" id="<?php print $body_id ?>" <?php print theme("onload_attribute"); ?>>
<!--body class="<?php print $body_classes; ?>"-->
  <div id="page">
    
    <div id="container" class="clear-block">
	  <div id="header">
      <div id="logo-title">

        <?php print $search_box; ?>      
        
        <div id="name-and-slogan">

        <?php if (!empty($site_name)): ?>
          <h1 id='site-name'>
            <a href="<?php print $base_path ?>" title="<?php print t('Home'); ?>" rel="home">
              <?php print $site_name; ?>
            </a>
          </h1>
        <?php endif; ?>

        <?php if (!empty($site_slogan)): ?>
          <div id='site-slogan'>
            <?php print $site_slogan; ?>
          </div>
        <?php endif; ?>

        </div> <!-- /name-and-slogan -->

      </div> <!-- /logo-title -->

      <?php if (!empty($header)): ?>
        <div id="header-region">
          
          <?php print $header; ?>
        </div>
      <?php endif; ?>

    </div> <!-- /header -->
                  
      <?php if (!empty($sidebar_left)): ?>
        <div id="sidebar-left" class="column sidebar">
		  	<!--<span id="minHeightKludge">&nbsp;</span>-->
          <?php print $sidebar_left; ?>
			<div style="height: 50px;"></div>
			
			<a href="/customer_care" id="help"><img src="/themes/famfel/img/help.jpg" alt="Need help? Click here to email us." /></a>
        </div> <!-- /sidebar-left -->
      <?php endif; ?>  
      <?php $page_class = str_replace(' ', '_', strip_tags($title));?>
		<?php
		if (!strpos($body_class, 'edit')) {
			if (strpos($title, ' Resources')) {
				$christian_resources = true;
			} else {
				$christian_resources = false;
			}
			if(strpos($body_id, 'ode-3') || strpos($title, ' Filtering with a Christian')){
				$home_page = true;
			} else {
				$home_page = false;
			}
		}
		?>
      <div id="content" class="column <?php echo $page_class; ?>"><div id="squeeze">
        <?php if (!empty($mission)): ?><div id="mission"><?php print $mission; ?></div><?php endif; ?>

        <?php if (!empty($content_top)):?><div id="content-top"><?php print $content_top; ?></div><?php endif; ?>

        <?php if (!empty($title)): ?><h2 class="title"><span><?php print $title; ?></span></h2><?php endif; ?>

		<?php if (!empty($tabs) && $is_admin): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
		
		<?php if (!in_array($_SERVER['REQUEST_URI'], array('/','/sweeper/signup','/confirmation')) && empty($_POST)): ?>
		<div class="breadcrumb"><a href="javascript: history.go(-1)">Back to previous page</a></div>
		<?php endif; ?>
		
		<?php if($is_delinquent): ?>
		<div class="delinquent messages error">
			<p class="notice">
				<span class="pop">Your account has been deactivated because your subscription failed to
				renew.</span>  This may be due to a declined or expired credit card.  To fix
				this issue click one of the following links:
			</p>
			<ul>
				<li>To change your credit card, <a href="https://<?php echo $_SERVER['SERVER_NAME']?>/change_card">please click here.</a></li>
				<li>To change your subscription, <a href="https://<?php echo $_SERVER['SERVER_NAME']?>/change_plan">please click here.</a></li>
			</ul>
			<p class="notice">
				Failure to update your credit card information will result in
				termination of your filter service.  If this takes place, and the
				FamilyFellowship.com filter client is still installed on your
				computer[s], your will be unable to access the internet.  If you do not
				wish to continue your subscription with FamilyFellowship.com, please
				uninstall the filter client from <em>all</em> of your computers and
				then click on the "cancel my account" link below.
			</p>
			<p class="notice">
				Please <a href="/customer_care">feel free to contact customer care</a>
				with any questions or concerns.
			</p>
		</div>
		<?php elseif($is_canceled): ?>
		<div class="cancel messages error">
			<p class="notice pop">Your account has been deactivated because you chose to cancel your subscription.</span>
			</p>
			<p class="notice">
				If you would like to reactivate your account, <a href="/sweeper">please click here</a>.
			</p>
			
			<p class="notice">
				Please <a href="/customer_care">feel free to contact customer care</a>
				with any questions or concerns.
			</p>
		</div>
		<?php elseif(!$is_active && !$is_admin && $loggedin && !in_array($_SERVER['REQUEST_URI'], array('/','/sweeper/signup','/confirmation'))): ?>
		<div class="non_active messages error">
			<p class="notice pop">
				You have not finished the signup process!
			</p>
			
			<p class="notice">
				Please <a href="/sweeper">click here</a> to finish
			</p>
		</div>
		<?php endif;?>
		
        <?php print $help; ?>
        <?php print $messages; ?>

		<?php if(!$loggedin && (in_array($title, array('My Account', 'FamilyFellowship.com Video Tutorial Series', 'Acount Information')))):?>
		
		<h3>You must login to see view this section.</h3>
		<p>Not yet a FamilyFellowship.com member?  <a href="/buy_now">Click here to signup!</a></p>
		<p>Forgot your FamilyFellowship.com website account password?  <a href="/customer_care/account_password_retrieval">Click here to retrieve it</a>.</p> 

		<p>
		Enter your FamilyFellowship.com Website Username and Password to login. This will only log you in to this website. <strong>To manage your FamilyFellowship.com Internet Filter, please login to your Profile Manager</strong>.
		</p>

		<form action="/user/login"  method="post" id="user-login">
		<input type="hidden" name="uri" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
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
		<?php 
		elseif(($is_delinquent || $is_canceled) && $title =='FamilyFellowship.com Video Tutorial Series'):
		
		drupal_goto('my_account');
		
		else:?>
        <?php print $content; ?>
		<?php endif; ?>
		
        <?php print $feed_icons; ?>
		<?php if ($christian_resources): ?>
			<!--/div--><!-- end div#resource_left -->
			<div id="resource_right">
			
			<div id="dailyVs">
			<div>
			<script src="/misc/quotes.js" language="JavaScript" type="text/javascript">
			</script>
			<script language="JavaScript" type="text/javascript">
				write_quote()
			</script>
			</div>
			<a href="/salvation" id="salvationBtn"><img src="/themes/famfel/img/salvation.jpg" alt="Salvation: click here to read" /></a>
			</div>
			</div>
			<!--end div#resource_right-->
		<?php 
		endif; 
		if ($home_page): 
		?>			
			<div id="filteringAd"> 
				<h3>Basic Filtering</h3> 
				<ul> 
					<li>Filters up to five PC's</li> 
					<li>Works with any ISP</li> 
					<li>Toll-Free Support</li> 
					<li>Free Setup</li>
				</ul> <a id="details" href="/filter_features">Details</a> <a id="buyNow" href="/buy_now">Buy Now</a> 
			</div> 
			<div id="button_holder">
			<p id="guarantee">
			<a href="/guarantee"><img border="0" src="/themes/famfel/img/guarantee.jpg" alt="30 Day Money-Back Guarantee! click here for more details" /></a>
			</p>
			<div id="vid_home">
				 <a href="/video_view.php"><img border="0" src="/themes/famfel/img/overview.png" alt="See an overview of the actual filter" /></a>
			</div>
			</div>
		<?php endif; ?>
		<div class="clear bottom-padding"></div>
          
        
        <?php if (!empty($content_bottom)): ?><div id="content-bottom"><?php print $content_bottom; ?></div><?php endif; ?>
      </div></div> <!-- /squeeze /main -->

	  <div id="footer-wrapper">
	      <div id="footer">
	        <?php print $footer_message; ?>
	      </div> <!-- /footer -->
	    </div> <!-- /footer-wrapper -->

    <?php print $closure; ?>

    </div> <!-- /container -->

    
    
  </div> <!-- /page -->
  <script type="text/javascript">
 	  //<![CDATA[
	  if(typeof sIFR == "function"){
	  	  sIFR.replaceElement("h2 span", "/flash/sifr.swf", "#ffffff", null, null, "#000000", 0, 0, 0, 0, null, null, "transparent");
	  }
	  //]]>
  </script>
	<?php print $closure ?>
</body>
</html>