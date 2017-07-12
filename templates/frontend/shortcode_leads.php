<style>
input:invalid, select:invalid, textarea:invalid{ 
	border: 1px solid red;
}
input:valid, select:valid, textarea:valid{ 
	border: inherit;
}
</style>
	<div class="wp-pushpress">
		<ul class="wp-pushpress-list">
			<li class="item-first">
				<h3><?php echo $leads['lead_page_title'];?></h3>
				<div class="clear"></div>
			</li>
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<li class="item-other">
				<p class="lead-text"><?php echo $leads['lead_page_description'];?></p>
				<?php Wp_Pushpress_Messages::get_messages();?>
				<form id="subscribe-form" class="form" action="" method="post">
				<div class="btn-group">
					<label for="billing_first_name">Your Name</label>
					<input required name="billing_first_name" id="billing_first_name" value="<?php echo $form['billing_first_name'];?>" placeholder="First Name" />
					<input required name="billing_last_name" id="billing_last_name" value="<?php echo $form['billing_last_name'];?>" placeholder="Last Name" />
				</div>
				<div class="btn-group">
					<label for="email">Your Email</label>
					<input name="email" id="email" value="<?php echo $form['email'];?>" placeholder="email@example.com" required />
				</div>
				<?php 
					if ($leads['lead_page_show_dob']) { 
				?>
				<div class="btn-group">
					<label for="your_birthday">Your Date of Birth</label>
					<input name="your_birthday" <?php if ($leads['lead_page_dob_required']) { echo 'required'; }?> id="your_birthday" class="your-birthday" value="<?php echo $form['your_birthday'];?>" placeholder="01/01/1990" />
				</div>
				<?php } // if show dob 
					if ($leads['lead_page_show_phone']) { 
				?>				
				<div class="btn-group">
					<label for="phone">Your Phone</label>
					<input name="phone" id="phone" <?php if ($leads['lead_page_phone_required']) { echo 'required'; }?> value="<?php echo $form['phone'];?>" placeholder="310-989-5552" />
				</div>
				<?php } // show phont
					if ($leads['lead_page_show_postal']) {
				?>
				<div class="btn-group">
					<label for="billing_postal_code">Your Postal Code</label>
					<input name="billing_postal_code" id="billing_postal_code" <?php if ($leads['lead_page_postal_required']) { echo 'required'; }?> value="<?php echo $form['billing_postal_code'];?>" placeholder="90000" />
				</div>
				<?php
					} // show postal
					if (isset($leadTypes) && count($leadTypes)) {
						if (count($leadTypes) == 1) {
							reset($leadTypes);
							$lead_type = key($leadTypes);
							$redirect = $leadTypes[$lead_type];

							?>
							<input type="hidden" name="lead_type" id="lead-type-nonce" value="<?php echo $lead_type;?>">
							<input type="hidden" name="redirect_nonce" id="redirect_nonce" value="<?php echo $redirect ?>">
							<?php
						}
						else {
							?>
							<div class="btn-group">
								<label for="objective">What Are You Interested In?</label>
								<select name="lead_type" id="lead-type" required>
									<option value="">-Select one-</option>
									<?php foreach ($leadTypes as $lead_type=>$redirect) {
									$selected = "";
									if ($form['lead_type'] === $lead_type) {
										$selected = "selected";
									}
									?>
									<option rel="<?php echo $redirect;?>" value="<?php echo $lead_type;?>" <?php echo $selected;?>><?php echo $lead_type;?>
										<?php
										}
										?>
								</select>
								<input type="hidden" name="redirect_nonce" id="redirect_nonce" value="<?php echo $form['redirect_nonce']?>">
							</div>
						<?php  } // if count == 1
					} // if is set types
					?>
				<?php
					if ($leads['lead_page_show_client_objectives']) { 
				?>
				<div class="btn-group">
					<label for="objective">What are your objectives</label>
					<select name="objective" id="objective">
						<option value="">-Select one-</option>
						<?php for($i = 0; $i < sizeof($leadsObj); $i++):?>

							<option value="<?php echo $leadsObj[$i];?>"<?php echo ($leadsObj[$i] == $form['objective']) ? 'selected' : '';?>><?php echo $leadsObj[$i];?></option>
						<?php endfor;?>

					</select>
				</div>
				<?php 
					} // show objectives
					if ($leads['lead_page_show_preferred_communication']) {
				?>
				<div class="btn-group">
					<label for="preferred-communication">Preferred Communication</label>
					<select <?php if ($leads['lead_page_preferred_comm_required']) { echo 'required'; }?> name="preferred_communication" id="preferred-communication">
                        <option value="">-Select one-</option>
                        <option <?php if ( $form['preferred_communication'] == 'any' ) { echo 'selected'; }?> value="any">Any</option>
                        <option <?php if ( $form['preferred_communication'] == 'email' ) { echo 'selected'; }?> value="email">Email</option>
                        <option <?php if ( $form['preferred_communication'] == 'phone' ) { echo 'selected'; }?> value="call">Phone</option>
                        <option <?php if ( $form['preferred_communication'] == 'text' ) { echo 'selected'; }?> value="text">Text</option>
                    </select> 
				</div>
				<?php } //  show pref comm
					if ($leads['lead_page_show_referral_source']) { 
				?>
				<div class="btn-group">
					<label for="referred_by_id">How did you hear about us?</label>
					<select <?php if ($leads['lead_page_referral_required']) { echo 'required'; }?> name="referred_by_id" id="referred_by_id">
						<option value="">-Select one-</option>
						<?php for($i = 0; $i < sizeof($referral); $i++):?>
							<option value="<?php echo $referral[$i]['id'];?>"<?php echo ($referral[$i]['id'] == $form['referred_by_id']) ? 'selected' : '';?>><?php echo $referral[$i]['name'];?></option>

						<?php endfor;?>
					</select>
				</div>
				<?php }
				 if ($leads['lead_page_allow_message']) { ?>
						<div class="btn-group">
							<label for="billing_exp" class="col-xs-12">Questions? Send us a message along with this!</label>
							<textarea <?php if ($leads['lead_page_message_required']) { echo 'required'; }?> class="form-control" name="lead_message"><?php echo $form['lead_message'];?></textarea>
						</div>
					<?php } 
					if (strlen(trim(get_option('wp-pushpress-recaptcha-sitekey')))) {
				?>
				<div class="btn-group">
					<label>Are you human?</label>
					<div class="g-recaptcha" data-sitekey="<?php echo get_option( 'wp-pushpress-recaptcha-sitekey');?>"></div>
				</div>
				<?php } // if there's a google captcha key ?>
				<div class="btn-group">
					<?php wp_nonce_field( 'save_leads_info', 'save_leads_info_nonce');?>
					<button type="submit" name="btnLead">Submit</button>
				</div>
				</form>
			</li>
		</ul>
	</div>
