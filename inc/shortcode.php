<?php

function survey_form_html() {
	$seos_required = "<span class='required'>" . esc_attr( get_option('seos_required')) . "</span>";
	$required1 = esc_attr( get_option('required1'));
	$required2 = esc_attr( get_option('required2'));
	$required3 = esc_attr( get_option('required3'));
	$required4 = esc_attr( get_option('required4'));
	$required5 = esc_attr( get_option('required5'));
	$required6 = esc_attr( get_option('required6'));
	$required7 = esc_attr( get_option('required7'));
	$required8 = esc_attr( get_option('required8'));
	$required9 = esc_attr( get_option('required9'));
	$rand = (isset($_POST['rand']) ? $_POST['rand'] : null); 
	$text = (isset($_POST['text']) ? $_POST['text'] : null); 	
	$numb = 10;
	$sum = ($numb + $rand);
	$error = "";
	$checked = "";

	if( get_option('seos_form_title')){echo "<h1 class='scf-title'>" . get_option('seos_form_title') . "</h1>"; }
	
?> <div id="send"></div> <?php

	echo '<form class="survey-form" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';

for($q=1; $q<=get_option('questions_number'); $q++) {
	
		echo '<p class="question-title">'. get_option("question".$q). '</p>';
				
		for($new=1; $new<=get_option('count_rad'.$q); $new++){

		if (get_option('seos_form_radio_text'.$q.$new) != "") {
			echo '<p class="question-radio">'; ?>
			<input name="seos_form_radio<?php echo $q; ?>" type="radio" value="<?php echo get_option("seos_form_radio_text".$q.$new); ?>"<?php checked( $q.$new, get_option( "seos_form_radio".$q) ); ?> ' />
			<?php
			echo '' . esc_attr( get_option("seos_form_radio_text".$q.$new) ); 
			if(empty($_POST["seos_form_radio".$q]) ) { $error = true;}
			echo '</p>';
		}

	}
}


	echo '<p>';
	echo '' . esc_attr( get_option('seos_form_antispam') )  . ' ' . '<br/>'; 
	echo  '<input class="noselect" type="text" name="rand" value="' . rand(1,50). '+10' . '" readonly="readonly" />' ;
	if ( get_option('seos_spam')){ echo  '<label class="scf-sum">'. ' ' . esc_attr( get_option('seos_spam') ). ' ' . '</label>';}
	else {echo  '<label>'. _e(" Enter the SUM: ", "scf"). '</label>';}
	echo  '<input type="text" name="text" value="" />';
	if(isset($_POST['text']) && ($sum != $text) or empty($_POST['text']) ) { $error = true; echo ' ' . $seos_required;}
	echo '</p>';
	
	if ( get_option('seos_send_button')){ echo '<p><input type="submit" name="seos-submitted" value="' . esc_attr( get_option('seos_send_button')) . '"></p>';}
	else {echo '<p><input type="submit" name="seos-submitted" value="Send"></p>';}
	
	echo '</form>';
	
	$to = $subject  = $message = $headers = "";
	
	if ( isset( $_POST['seos-submitted'] ) and $error == false) {
		
		$to = get_option('seos_admin_email');
		
		$subject = "Survey";
	
		$name = "Your Survey";
		
		if (empty($_POST["seos-email"])) {
			$email  = "no@mail";		
		}


		function send (){
			for($q=1; $q<=get_option('questions_number'); $q++) {
				$opa .= $_POST['seos_form_radio'.$q] . "<br />";
			}
			return $opa;	
		}
		
	
		$headers  = "From: $name <$email>" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8";
	
		$message  = "<h1><a target='_blank' href='https://seosthemes.com/'>Seos Survey</a></h1>" . "";
		$message .= "<table style='font-size: 14px; padding:1px;' border=1>";

		$message .= '<tr><td style="padding:5px;">Radio Buttons:</td><td style="padding:5px;">'. send () . "</td></tr>";

		$message .= '<tr><td style="padding:5px;">USER IP:</td><td style="padding:5px;"><a target="_blank" href="https://seosthemes.com/survey/">Upgrade to Pro Version</a></td></tr>';
		$message .= "</table>";

	}

		if (wp_mail( $to, $subject, $message, $headers) and $_POST['seos-submitted']) { 

			echo '<div>';
			if (get_option('seos_send')) {?> <script>document.getElementById("send").innerHTML = '<?php echo '<h1 style=\"color: #FF0000;\">' . esc_attr( get_option('seos_send')) . '</h1>' ; ?>' ;</script> <?php
			echo '</div>'; } else { 
			?>
				<script>document.getElementById("send").innerHTML = "<h1 style=\"color: #FF0000;\">Your message is send</h1>"; </script>
			<?php  }	
		} 
		
		elseif 
			(!wp_mail( $to, $subject, $message, $headers) and  isset($_POST['seos-submitted'])) {
				echo '<div>';
				if (get_option('seos_not_send')) {?> <script>document.getElementById("send").innerHTML = '<?php echo '<h1 style=\"color: #FF0000;\">' . esc_attr( get_option('seos_not_send')) . '</h1>' ; ?>' ;</script> <?php
				echo '</div>';} else { 
				?>
					<script>document.getElementById("send").innerHTML = "<h1 style=\"color: #FF0000;\">Your message is not sent.</h1>"; </script> 
				<?php }
}

}

function survey_shortcode() {
	ob_start();
	survey_form_html();
	return ob_get_clean();
}

add_shortcode( 'survey', 'survey_shortcode' );

