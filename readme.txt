=== Comment-Emailer ===
Contributors: Gordon French
Donate link: http://wordpress.gordonfrench.com/
Tags: email, autoresponder, comment, comments, emailer, trackback, pingback
Requires at least: 2.0
Tested up to: 2.9.2
Stable tag: 1.0.5

Comment-Emailer allows you to customize the email wordpress automatically 
sends when a new comment, pingback or trackback has been approved. 


== Description ==

Comment-Emailer allows you to customize the email wordpress automatically 
sends when a new comment, pingback or trackback has been approved. 
With Commented-Emailer you can change the sending email address, message body,
and enable or disable all of the default options such as including the authors
name, ipaddress, website, comment or reply to address.

After installation you will have a new tab under settings that 
will give you access to change just about every access of your
auto generated emails. Just make sure you enable Commented-Emailer 



== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the complete folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enable the plugin on the comment Email tab under settings.



== Frequently Asked Questions ==

= Can I add html to the message? =

No, this version is using the default wordpress function which only
sends text emails.


= Fatal Error after upgrade =

Sorry, this issue has been fixed but if you have an older version please 
disable the plugin before upgrading. If you have already tried to upgrade
and get this error you will need to edit one of the files.

Go to plugin - editor and from the upper dropdown select comment-emailer
then edit the top file comment-emailer/comment-emailer.php

Line 22 says include 'notify_postauthor.php'; please comment this line out
activate the plugin then disable the plugin. Once you have diasabled the plugin
you can uncomment this line and then reenable the plugin.





== Screenshots ==

1. Admin Settings area


== Changelog ==

= 1.0 =
* Original Release

= 1.0.1 =
* fixed image path

= 1.0.2 =
*repaired an update issues



== Upgrade Notice ==







