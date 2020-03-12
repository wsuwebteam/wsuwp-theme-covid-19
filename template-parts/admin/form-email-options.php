<form  class="wsu-t-covid__email-form" method="post" action="<?php echo esc_url( $form_url ); ?>">
	<input type="hidden" value="email_options" name="page" />
	<input type="hidden" value="update" name="email_options_action" />
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="<?php echo esc_attr( $options['send_from'] ); ?>" name="send_from" placeholder="Send From Email" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="<?php echo esc_attr( $options['send_from_title'] ); ?>" name="send_from_title" placeholder="Send From Title" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="<?php echo esc_attr( $options['bcc_to'] ); ?>" name="bcc_to" placeholder="Bcc To" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="<?php echo esc_attr( $options['bcc_to_alt'] ); ?>" name="bcc_to_alt" placeholder="Bcc To" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="<?php echo esc_attr( $options['reply_to'] ); ?>" name="reply_to" placeholder="Reply To" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="<?php echo esc_attr( $options['subject'] ); ?>" name="subject" placeholder="Email Subject" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--checkbox">
		<label><input type="checkbox" value="1" name="send_email" <?php checked( 1, $options['send_email'] ); ?> /> Send Email</label>
	</div>
	<h2>Update Email Send Time (Sent Daily)</h2>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--time">
		<select name="send_time" >
			<?php for ( $d = 1; $d < 11; $d++ ) : $date = ( $d < 10 ) ? '0' . $d : $d; ?>
				<option value="<?php echo esc_attr( $date ); ?>" <?php selected( $date, $options['send_time'] ); ?>><?php echo esc_html( $d ); ?>AM</option>
			<?php endfor; ?>
			<?php for ( $d = 0; $d < 13; $d++ ) : $date = ( $d + 12 ); ?>
				<option value="<?php echo esc_attr( $date ); ?>" <?php selected( $date, $options['send_time'] ); ?>><?php echo esc_html( $d ); ?>PM</option>
			<?php endfor; ?>
		</select>
	</div>
	<h3>Merge Tags</h3>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--html">
		<ul>
			<li>[posts] ..... [/posts] = Repeat for each post.</li>
			<li>[faqs] ..... [/faqs] = Repeat for each FAQ.</li>	
			<li>[academics] ..... [/academics] = Repeat for each Academic Ops</li>
			<li>[post_title] = Post Title.</li>
			<li>[post_date] = Post Publish Date.</li>
			<li>[post_link] = Post Link.</li>
			<li>[post_excerpt] = Post Excerpt.</li>
			<li>[post_content] = Post Content.</li>
			<li>[date_month] = Month (March, April, ...).</li>
			<li>[date_day] = Numeric Day.</li>
			<li>[date_day_name] = Text Day (Monday).</li>
		</ul>
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--textarea">
		<textarea name="email_template"><?php echo stripslashes( $options['email_template'] ); ?></textarea>
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--submit">
		<input type="submit" value="Save" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--button">
		<a href="<?php echo esc_url( get_site_url() ); ?>?preview_wsu_email=true" target="_blank" >View Email</a>
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--button">
		<a href="<?php echo esc_url( get_site_url() ); ?>?preview_wsu_email=true&demo_content=true" target="_blank" >View Email (demo content)</a>
	</div>
</form>
<form  class="wsu-t-covid__email-form" method="post" action="<?php echo esc_url( $form_url ); ?>">
	<input type="hidden" value="send_test" name="send_test" />
	<h2>Send Test Email</h2>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--text">
		<input type="text" value="" name="send_to" placeholder="Test Email Addresses" />
	</div>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--submit">
		<input type="submit" value="Send Test Email" />
	</div>
</form>
<form  class="wsu-t-covid__email-form" method="post" action="<?php echo esc_url( $form_url ); ?>">
	<input type="hidden" value="send_manual" name="send_manual" />
	<h2>Send Manual Email</h2>
	<div class="wsu-t-covid__email-form-field wsu-t-covid__email-form-field--submit">
		<input type="submit" value="Send Email Manual" />
	</div>
</form>
<style>
	.wsu-t-covid__email-form {
		padding-left: 1rem;
		padding-right: 1rem;
		box-sizing: border-box;
	}
	.wsu-t-covid__email-form-field {
		margin-bottom: 1.5rem;
	}
	.wsu-t-covid__email-form-field--textarea textarea {
		width: 100%;
		max-width: 700px;
		height: 800px;
	}
</style>
