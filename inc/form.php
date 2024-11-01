	<form method="post" action="options.php">
	
		<?php settings_fields( 'survey-settings-group' ); ?>
		<?php do_settings_sections( 'survey-settings-group' ); ?>
		
		 <table class="form-table">
		 
			<tr valign="top">
				<th scope="row"><?php _e('Custom text - Survey Title:', 'survey'); ?></th>
				<td><input type="text" name="seos_form_title" value="<?php echo esc_attr( get_option('seos_form_title') ); ?>" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Admin Email:', 'survey'); ?> </th>
				<td><input type="text" name="seos_admin_email" value="<?php echo esc_attr( get_option('seos_admin_email') ); ?>" /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('Custom text - Your message is send:', 'survey'); ?></th>
				<td><input type="text" name="seos_send" value="<?php echo esc_attr( get_option('seos_send') ); ?>" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Custom text - Your message is not sent:', 'survey'); ?></th>
				<td><input type="text" name="seos_not_send" value="<?php echo esc_attr( get_option('seos_not_send') ); ?>" /></td>
			</tr>	
			
			<tr valign="top">
				<th scope="row"><?php _e('Custom text Antispam - Enter the SUM:', 'survey'); ?> </th>
				<td><input type="text" name="seos_spam" value="<?php echo esc_attr( get_option('seos_spam') ); ?>" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Custom text - Send Button:', 'survey'); ?> </th>
				<td><input type="text" name="seos_send_button" value="<?php echo esc_attr( get_option('seos_send_button') ); ?>" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Shortcode - Include form in your website:', 'survey'); ?> </th>
				<td> <?php echo "<textarea cols=\"10\" rows=\"1\" readonly>[survey]</textarea> "; ?></td>
			</tr>
			
		</table>
		
			<h3><?php _e('Each field will be activated if you inserted a text.', 'survey'); ?></h3>
		
		<table class="form-table">
		
			<tr valign="top">
				<th scope="row"><?php _e('Number of Questions', 'survey'); ?></th>
				<td>
					<br />
					<input style="width: 50px;" type="number" min="0" max="20" name="questions_number" value="<?php echo esc_attr( get_option('questions_number') ); ?>" />
					<span class="survey-keep"><?php submit_button("keep"); ?></span>
					
				</td>
			</tr>	

			<?php for($q=1; $q<=get_option('questions_number'); $q++) {?>
			<tr valign="top">
				<th scope="row"><?php _e('Title of Question '.$q, 'survey'); ?></th>
				<td>
					<input type="text" name="question<?php echo $q; ?>" value="<?php echo esc_attr( get_option('question'.$q) ); ?>" />
					<br />
					<?php _e('Number of Fields:', 'survey'); ?>
					<input style="width: 50px;" type="number" min="0" max="10" name="count_rad<?php echo $q; ?>" value="<?php echo esc_attr( get_option('count_rad'.$q) ); ?>" />
					<span class="survey-keep"><?php submit_button("keep"); ?></span>
					
					
					<?php $count_rad = $q; 
					$count_rad = get_option('count_rad'.$q); ?>
					<?php for($rad=1; $rad<=$count_rad; $rad++){ 
						echo "<p>" . __("Field ", "survey").$rad .' <input size="60" type="text" name="seos_form_radio_text'.$q.$rad.'" value="'.get_option("seos_form_radio_text".$q.$rad).'" /></p>';				
					} ?>
				</td>
			</tr>			
	
			<?php } ?>
	
		</table>

				
		<?php submit_button(); ?>
		
		

	</form>