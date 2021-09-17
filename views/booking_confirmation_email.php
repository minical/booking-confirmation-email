
<div class="app-page-title">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="pe-7s-mail-open text-success"></i>
			</div>
			<div><?php echo l('booking-confirmation-email/booking_confirmation_email_settings'); ?>

		</div>
	</div>
</div>
</div>


<div class="main-card card">
	<div class="card-body">
<form method="post" action="<?php echo base_url();?>email/save_booking_confirmation_email
	">

	<fieldset>
	
			
		<ul>	
			<li>
				<?php echo l('booking-confirmation-email/Thanks for booking your stay at', true); ?> <?php echo $company['name']; ?><br/><br/>
			</li>
			<li>

                <textarea name="booking_confirmation_email_header" class="form-control booking_confirmation_email_header" id="booking_confirmation_email_header" rows="5"><?php echo $company['booking_confirmation_email_header']; ?></textarea>
				<br/><br/>
			</li>
			<li>
				<b><?php echo l('booking-confirmation-email/Guest Information', true); ?></b><br/>
				[<?php echo l('booking-confirmation-email/Information goes here', true); ?>]<br/><br/>
			</li>
			<li>
				<b><?php echo l('booking-confirmation-email/Reservation Information', true); ?></b><br/>
				[<?php echo l('booking-confirmation-email/Information goes here', true); ?>]<br/><br/>
			</li>
			<li>
				<b><?php echo l('booking-confirmation-email/Contact Information', true); ?></b><br/>
				<?php echo $company['name']; ?><br/><br/>

				<?php echo $company['address']; ?>,<br/>
				<?php echo $company['city'].", ".$company['region'].", ".$company['country']; ?><br/>
				<?php echo $company['postal_code']; ?><br/><br/>

				<?php echo l('booking-confirmation-email/Phone', true); ?>: <?php echo $company['phone']; ?><br/>
				<?php echo l('booking-confirmation-email/Fax', true); ?>: <?php echo $company['fax']; ?><br/><br/>

				<?php echo l('booking-confirmation-email/Email', true); ?>: <?php echo $company['email']; ?><br/>
				<?php echo l('booking-confirmation-email/Website', true); ?>: <?php echo $company['website']; ?><br/><br/>

			</li>

			<li>
				<?php echo l('booking-confirmation-email/Reservation Policies', true); ?>: <?php echo $company['reservation_policies']; ?>
				<br/><br/>
			</li>
			<li>
				*<?php echo l('booking-confirmation-email/Estimated total before tax and service charges', true); ?>.
			</li>

		</ul>
	</fieldset>
	<br />
	<input type="submit" name="submit" class="btn btn-light ml-5" value="<?php echo l('booking-confirmation-email/Update', true); ?>" />
</form>		
</div></div>