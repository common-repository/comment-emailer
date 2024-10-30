<?php

/*
 * @package commented-emailer
 * @author Gordon French
 * @version 1.0.5
 *

Plugin Name: Comment Emailer
Plugin URI: http://wordpress.gordonfrench.com/comment-emailer/

Description: Comment Emailer, allows you to modify the email that is sent to the post author when a new comment has been made. The default wordpress email says from wordpress@ and lacks formating. With Commented Emailer you can pick whaat information gets sent to the author and how that information will look.


Author: Gordon French
Version: 1.0.5
Author URI: http://wordpress.gordonfrench.com
*/

$commentedOptions = get_option("commentedOptions");

// deletes the options array so that you
//do not get an error on reactivation
function commented_remove() {
	$commentedOptions['enabled'] == 'no';
	$commentedOptions['includeFile'] = '';
	update_option("commentedOptions", $commentedOptions);
	delete_option("commentedOptions");
}
register_deactivation_hook( __FILE__, 'commented_remove' );

function commented_active() {
	$commentedOptions['enabled'] == 'no';
	$commentedOptions['includeFile'] = '';
	update_option("commentedOptions", $commentedOptions);
}
register_activation_hook( __FILE__, 'commented_active' );



    ###############################
	####   ACTIVATION ERROR		###
	###############################

if ($commentedOptions['enabled'] == 'yes'){
	//please commet this line out if having activation problems
	//after activation please uncomment this line.
	// to comment out this line just add the two // before it.
	if (!empty($commentedOptions['includeFile'])){
		include $commentedOptions['includeFile'];
	}
}






// add the settings page to the main sidebar under settings
function commented_menu() {
   add_options_page('commented-emailer', 'Comment Email', '8', 'commented_emailer', 'commented_emailer');
}
add_action('admin_menu', 'commented_menu');





function commented_emailer() {
	###############################
	####		COMMENTS 		###
	###############################
	
	// get the options array
	$commentedOptions = get_option("commentedOptions");
	

	// check to see if the form was submited
	//if so save the changes to the array
	if ($_POST['commentSubmit']){
		
		$commentedOptions['includeFile'] = 'notify_postauthor.php';
		// set enabled option
		$commentedOptions['enabled'] = $_POST['enabled'];
		$commentedOptions['msg'] = $_POST['commented_msg'];


		$commentedOptions['name'] = $_POST['name'];
		$commentedOptions['email'] = $_POST['email'];
		$commentedOptions['url'] = $_POST['url'];
		$commentedOptions['comment'] = $_POST['comment'];
		$commentedOptions['trash'] = $_POST['trash'];
		$commentedOptions['fromEmail'] = $_POST['fromEmail'];
		$commentedOptions['replyTo'] = $_POST['replyTo'];
		$commentedOptions['view'] = $_POST['view'];

		

		// add options to the array

		update_option("commentedOptions", $commentedOptions);

		

		echo '<div class="savedBox"><b>Your settings have been saved</b></div>';

	}

	

	// set the default setting

	if (empty($commentedOptions['enabled'])){$commentedOptions['enabled'] = 'no';}
	if (empty($commentedOptions['name'])){$commentedOptions['name'] = 'no';}
	if (empty($commentedOptions['email'])){$commentedOptions['email'] = 'no';}
	if (empty($commentedOptions['url'])){$commentedOptions['url'] = 'no';}
	if (empty($commentedOptions['comment'])){$commentedOptions['comment'] = 'no';}
	if (empty($commentedOptions['trash'])){$commentedOptions['trash'] = 'no';}
	if (empty($commentedOptions['fromEmail'])){$commentedOptions['fromEmail'] = 'wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));}

	if (empty($commentedOptions['view'])){$commentedOptions['view'] = 'yes';}
	if (empty($commentedOptions['replyTo'])){$commentedOptions['replyTo'] = 'no';}

	

	

	// set the checked option for the radio buttons

	if ($commentedOptions['enabled'] == 'no'){
		$enabledYesChecked = '';
		$enabledNoChecked = 'CHECKED';
	} else if ($commentedOptions['enabled'] == 'yes') {

		$enabledYesChecked = 'CHECKED';
		$enabledNoChecked = '';
	}

	

	// set the checked option for the radio buttons
	if ($commentedOptions['name'] == 'no'){
		$nameYesChecked = '';
		$nameNoChecked = 'CHECKED';
	} else if ($commentedOptions['name'] == 'yes') {
		$nameYesChecked = 'CHECKED';
		$nameNoChecked = '';
	}

	

	// set the checked option for the radio buttons

	if ($commentedOptions['email'] == 'no'){
		$emailYesChecked = '';
		$emailNoChecked = 'CHECKED';
	} else if ($commentedOptions['email'] == 'yes') {
		$emailYesChecked = 'CHECKED';
		$emailNoChecked = '';
	}

	

	// set the checked option for the radio buttons
	if ($commentedOptions['url'] == 'no'){
		$urlYesChecked = '';
		$urlNoChecked = 'CHECKED';
	} else if ($commentedOptions['url'] == 'yes') {
		$urlYesChecked = 'CHECKED';
		$urlNoChecked = '';
	}

	

	// set the checked option for the radio buttons

	if ($commentedOptions['comment'] == 'no'){
		$commentYesChecked = '';
		$commentNoChecked = 'CHECKED';
	} else if ($commentedOptions['comment'] == 'yes') {
		$commentYesChecked = 'CHECKED';
		$commentNoChecked = '';
	}

	

	// set the checked option for the radio buttons

	if ($commentedOptions['trash'] == 'no'){
		$trashYesChecked = '';
		$trashNoChecked = 'CHECKED';
	} else if ($commentedOptions['trash'] == 'yes') {
		$trashYesChecked = 'CHECKED';
		$trashNoChecked = '';
	}

	

	// set the checked option for the radio buttons

	if ($commentedOptions['view'] == 'no'){
		$viewYesChecked = '';
		$viewNoChecked = 'CHECKED';
	} else if ($commentedOptions['view'] == 'yes') {
		$viewYesChecked = 'CHECKED';
		$viewNoChecked = '';
	}

	

	// set the checked option for the radio buttons

	if ($commentedOptions['replyTo'] == 'no'){
		$replyToYesChecked = '';
		$replyToNoChecked = 'CHECKED';
	} else if ($commentedOptions['replyTo'] == 'yes') {
		$replyToYesChecked = 'CHECKED';
		$replyToNoChecked = '';
	}

	

	

	

	###############################
	####		Trackback 		###
	###############################

	

	// get the options array
	$trackbackOptions = get_option("trackbackOptions");

	

	// check to see if the form was submited
	//if so save the changes to the array
	if ($_POST['trackbackSubmit']){
		// set enabled option
		$trackbackOptions['enabled'] = $_POST['enabled'];
		$trackbackOptions['msg'] = $_POST['track_msg'];
		

		// add options to the array
		update_option("trackbackOptions", $trackbackOptions);
		echo '<div class="savedBox"><b>Your settings have been saved</b></div>';
	}

	

	// set the default setting
	if (empty($trackbackOptions['enabled'])){$trackbackOptions['enabled'] = 'no';}



	

	

	// set the checked option for the radio buttons
	if ($trackbackOptions['enabled'] == 'no'){
		$enabledTYesChecked = '';
		$enabledTNoChecked = 'CHECKED';
	} else if ($trackbackOptions['enabled'] == 'yes') {
		$enabledTYesChecked = 'CHECKED';
		$enabledTNoChecked = '';
	}
	
	?>

    

    <div class="wrap">
      <h2><img src="<?php bloginfo('url'); ?>/wp-content/plugins/comment-emailer/images/email-icon.png"/> Commented Emailer</h2>
	  
       <form name="comments" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
      	 <div class="settingsArea"> 
            <p><strong>Enabled:  &nbsp;  &nbsp;  &nbsp;</strong>
            Yes: <input type="radio" name="enabled" value="yes" <?php echo $enabledYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="enabled" value="no" <?php echo $enabledNoChecked; ?>/><br>
            <small>Commented-Emailer, must be enabled to overide the default email settings</small>.</p>


            <p><strong>From Email: &nbsp;</strong>
            <input type="text" name="fromEmail" value="<?php  echo $commentedOptions['fromEmail']; ?>" /><br />
            <small>Email should match your website "myEmail@mysite.com"</small>.</p>

            

            <p style="clear:both">
                <div><b>Message</b></div>
                <textarea name="commented_msg" rows="10" cols="50"><?php echo stripslashes($commentedOptions['msg']); ?></textarea><br />
                <small>Enter the message you want included in the email. </small>
            </p>


            <p><strong>Include Commenters Name &amp; IP: &nbsp;</strong>
            Yes: <input type="radio" name="name" value="yes" <?php echo $nameYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="name" value="no" <?php echo $nameNoChecked; ?>/><br>
            <small>Would you like the commenters name &amp; ip-address to be in the email?</small>.</p>


            <p><strong>Include Commenters Email: &nbsp; &nbsp;</strong>
            Yes: <input type="radio" name="email" value="yes" <?php echo $emailYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="email" value="no" <?php echo $emailNoChecked; ?>/><br>
            <small>Would you like the commenters email to be in the email?</small>.</p>


            <p><strong>Include Commenters URL: &nbsp; &nbsp; &nbsp;</strong>
            Yes: <input type="radio" name="url" value="yes" <?php echo $urlYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="url" value="no" <?php echo $urlNoChecked; ?>/><br>
            <small>Would you like the commenters website to be in the email?</small>.</p>


            <p><strong>Include a copy of the comment: &nbsp; &nbsp;</strong>
            Yes: <input type="radio" name="comment" value="yes" <?php echo $commentYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="comment" value="no" <?php echo $commentNoChecked; ?>/><br>
            <small>Would you like a copy of the comment to be in the email?</small>.</p>

            

            <p><strong>Include Trash, Delete &amp; Spam links: &nbsp;</strong>
            Yes: <input type="radio" name="trash" value="yes" <?php echo $trashYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="trash" value="no" <?php echo $trashNoChecked; ?>/><br>
            <small>Would you like the Trash It, Spam It &amp; Delete It link in the email?</small>.</p>


            <p><strong>Include view all comments links: &nbsp;</strong>
            Yes: <input type="radio" name="view" value="yes" <?php echo $viewYesChecked; ?>/>  &nbsp;  &nbsp;
            No:  <input type="radio" name="view" value="no" <?php echo $viewNoChecked; ?>/><br>
            <small>Would you like the view all comments link in the email?</small>.</p>

            

            <p><strong>Enable Reply To: &nbsp;</strong>

            Yes: <input type="radio" name="replyTo" value="yes" <?php echo $replyToYesChecked; ?>/>  &nbsp;  &nbsp;

            No:  <input type="radio" name="replyTo" value="no" <?php echo $replyToNoChecked; ?>/><br>

            <small>If disabled reply to will be do not reply</small>.</p>

            

     	</div>

            <input type="hidden" id="commentSubmit" name="commentSubmit" value="1" />        

            <input name="save" value="Save" type="submit" />

       </form>

    </div>

    

    <br />

	<br />

	<br />



    

	<style type="text/css"> 

       .settingsArea	{ background-color:#f1f1f1; padding:10px; width:500px; border:1px solid #e3e3e3; margin:10px 0px; position:relative; }

	   .savedBox		{ position:relative; width:500px; border:2px solid #229585; background-color:#c2f7f0; padding:10px;  margin:20px 0px 0px}

	   .errorBox		{ position:relative; width:500px; border:2px solid #f7a468; background-color:#f7d8c2; padding:10px; margin:20px 0px 0px}

	   .highlight		{ border:2px solid #f7a468; background-color:#f7d8c2}

	   

	   .notes		{ background-color:#f5f6f7; border:1px solid #e3e3e3; padding:10px; font-size:90%; color:#666}

	</style>

    

    <script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/plugins/rss-2-post/scripts/jquery.js"></script> 

       <script language="JavaScript" type="text/javascript">

		$(document).ready(function(){

			$(".errorBox").animate( {opacity: 1.0}, 3000, function() {

				$(".errorBox").animate( {opacity: 0.5}, 2000, function() {

					$(".errorBox").slideUp("slow");

				});

			}); 

		

			$(".savedBox").animate( {opacity: 1.0}, 3000, function() {

				$(".savedBox").animate( {opacity: 0.5}, 2000, function() {

					$(".savedBox").slideUp("slow");

				});

			}); 

		});

	</script>

    

    <div class="wrap">

      <h2><img src="<?php bloginfo('url'); ?>/wp-content/plugins/comment-emailer/images/email-icon.png"/> Trackback &amp; Pingback Emailer</h2>

	  

       <form name="trackback" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>"/>

      	 <div class="settingsArea"> 

            <p><strong>Enabled:  &nbsp;  &nbsp;  &nbsp;</strong>

            Yes: <input type="radio" name="enabled" value="yes" <?php echo $enabledTYesChecked; ?>/>  &nbsp;  &nbsp;

            No:  <input type="radio" name="enabled" value="no" <?php echo $enabledTNoChecked; ?>/><br>

            <small>If Trackback Emailer is disabled trackback and pingpack emails will not be sent.</small>.</p>

            

            

            

            <p style="clear:both">

                <div><b>Message</b></div>

                <textarea name="track_msg" rows="10" cols="50"><?php echo stripslashes($trackbackOptions['msg']); ?></textarea><br />

                <small>Enter the message you want included in the email. </small>

            </p>

            

            

     	</div>

            <input type="hidden" id="trackbackSubmit" name="trackbackSubmit" value="1" />        

            <input name="save" value="Save" type="submit" />

       </form>

    </div>

    

    <?php

}





?>