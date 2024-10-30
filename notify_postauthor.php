<?php
/**
 * Notify an author of a comment/trackback/pingback to one of their posts.
 *
 * @since 1.0.0
 *
 * @param int $comment_id Comment ID
 * @param string $comment_type Optional. The comment type either 'comment' (default), 'trackback', or 'pingback'
 * @return bool False if user email does not exist. True on completion.
 */
function wp_notify_postauthor($comment_id, $comment_type='') {
	$commentedOptions = get_option("commentedOptions");
	$trackbackOptions = get_option("trackbackOptions");
	
	$comment = get_comment($comment_id);
	$post    = get_post($comment->comment_post_ID);
	$user    = get_userdata( $post->post_author );
	$current_user = wp_get_current_user();

	if ( $comment->user_id == $post->post_author ) return false; // The author moderated a comment on his own post

	if ('' == $user->user_email) return false; // If there's no email to send the comment to

	$comment_author_domain = @gethostbyaddr($comment->comment_author_IP);
	
	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	if ( empty( $comment_type ) ) $comment_type = 'comment';

	if ('comment' == $comment_type) {
		/* translators: 1: post id, 2: post title */
		
		//$notify_message  = sprintf( __('New comment on your article #%1$s "%2$s"'), $comment->comment_post_ID, $post->post_title ) . "\r\n";
		$notify_message  = sprintf( __(stripslashes($commentedOptions['msg'])), $comment->comment_post_ID, $post->post_title ) . "\r\n \r\n";
		
		// Add commenters name to email
		/* translators: 1: comment author, 2: author IP, 3: author domain */
		if ($commentedOptions['name'] == 'yes'){
		//$notify_message .= sprintf( __('Author : %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
			$notify_message .= sprintf( __('Author : %1$s (IP: %2$s)'), $comment->comment_author, $comment->comment_author_IP) . "\r\n";
		}
		
		// Add commenters email to email
		if ($commentedOptions['email'] == 'yes'){
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
		}
		
		// Add commenters url to email
		if ($commentedOptions['url'] == 'yes'){
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
		}
		
		
		// Add commenters url to email
		if ($commentedOptions['comment'] == 'yes'){
			$notify_message .= "\r\n" . __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
		}
		
		if ($commentedOptions['view'] == 'yes'){
			$notify_message .= __('You can see all comments here: ') . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";
			
		}
		
		/* translators: 1: blog name, 2: post title */
		$subject = sprintf( __('New Comment: "%2$s"'), $blogname, $post->post_title );
		
		
	} elseif ('trackback' == $comment_type || 'pingback' == $comment_type) {
		if ($trackbackOptions['enabled'] == 'yes'){
			/* translators: 1: post id, 2: post title */
			$notify_message  = sprintf( __(stripslashes($trackbackOptions['msg'])), $comment->comment_post_ID, $post->post_title ) . "\r\n";
			
			/* translators: 1: website name, 2: author IP, 3: author domain */
			if ($commentedOptions['name'] == 'yes'){
				$notify_message .= sprintf( __('Website: %1$s (IP: %2$s)'), $comment->comment_author, $comment->comment_author_IP ) . "\r\n";
			}
			
			// Add commenters url to email
			if ($commentedOptions['url'] == 'yes'){
				$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			}
			
			
			// Add commenters url to email
			if ($commentedOptions['comment'] == 'yes'){
				$notify_message .= "\r\n" . __('Excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			}
			
			if ($commentedOptions['view'] == 'yes'){
				$notify_message .= __('You can see all trackbacks here: ') . "\r\n";
				$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";
			}
			
			/* translators: 1: blog name, 2: post title */
			$subject = sprintf( __('New Trackback: "%2$s"'), $blogname, $post->post_title );
		}
	}
	
	
	
	
	
	if ( EMPTY_TRASH_DAYS )
		if ($commentedOptions['trash'] == 'yes'){
			$notify_message .= sprintf( __('Trash it: %s'), admin_url("comment.php?action=trash&c=$comment_id") ) . "\r\n";
		}
	else
		if ($commentedOptions['trash'] == 'yes'){
			$notify_message .= sprintf( __('Delete it: %s'), admin_url("comment.php?action=delete&c=$comment_id") ) . "\r\n";
			$notify_message .= sprintf( __('Spam it: %s'), admin_url("comment.php?action=spam&c=$comment_id") ) . "\r\n";
		}

	$wp_email = 'admin@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));

	if ( '' == $comment->comment_author ) {
		$from = "From: \"$blogname\" <$wp_email>";
		if ( '' != $comment->comment_author_email )
			$reply_to = "Reply-To: $comment->comment_author_email";
	} else {
		$from = "From: \"$comment->comment_author\" <$wp_email>";
		if ( '' != $comment->comment_author_email )
			$reply_to = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
	}

	$message_headers = "$from\n"
		. "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";

	if ( isset($reply_to) )
		if ($commentedOptions['replyTo'] == 'yes'){
			$message_headers .= $reply_to . "\n";
		} else {
			$rp_email = 'donotreply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
			$reply_to = "Reply-To: \"Do Not Reply\" <$rp_email>";
			$message_headers .= $reply_to . "\n";
		}

	$notify_message = apply_filters('comment_notification_text', $notify_message, $comment_id);
	$subject = apply_filters('comment_notification_subject', $subject, $comment_id);
	$message_headers = apply_filters('comment_notification_headers', $message_headers, $comment_id);

	@wp_mail($user->user_email, $subject, $notify_message, $message_headers);

	return true;
}
?>