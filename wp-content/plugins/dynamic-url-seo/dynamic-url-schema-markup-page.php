<?php
function dus_schema_markup_callback()
{
	global $wpdb;
	if (isset($_POST["schema_form_submitted"]) && !empty($_POST["schema_form_submitted"]) && wp_verify_nonce($_POST['dus_insert_schema_form'], 'dus-insert-schema-form')) 
	{
		if(is_user_logged_in())
		{
			if(current_user_can('administrator'))
			{
				foreach($_POST as $key => $value)
				{
					$exp_key = explode('-', $key);
					if($exp_key[0] == '')
					{
						$arr_result_value = sanitize_text_field($value);
						$arr_result_value = str_replace('\\','',$arr_result_value);
						$arr_result_key = sanitize_text_field($key);
						dus_insert_schema( $arr_result_key, $arr_result_value );
					}
				}
			}
		}				
	}
	
	if( (isset($_GET["update"]) && !empty($_GET["update"])) && (isset($_POST["schema_form_updated"]) && !empty($_POST["schema_form_updated"])) && wp_verify_nonce($_POST['dus_update_schema_form'], 'dus-update-schema-form')) 
	{
		if(is_user_logged_in())
		{
			if(current_user_can('administrator'))
			{
				foreach($_POST as $key => $value)
				{   
					$exp_key = explode('-', $key);
					if($exp_key[0] == '')
					{
						$arr_result_values = sanitize_text_field($value);
						$arr_result_values = str_replace('\\','',$arr_result_values);
						$arr_result_keys = sanitize_text_field($key);
						
							dus_update_schema( $arr_result_keys, esc_attr($arr_result_values) );
					}
				}
			}
		}
	}
?>
<div class="wrap">
	<?php
		$custom_schema = $wpdb->prefix . 'dynamic_custom_url_seo_schema'; // do not forget about tables prefix
        $get_total_schema = $wpdb->get_results ( "SELECT count(*) as total_record FROM $custom_schema ");
		
		if(isset($_POST["schema_form_updated"]) || isset($_POST["schema_form_submitted"])) {
			echo '<hr class="wp-header-end">';
			echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Settings saved.</p></div>';
		}
		if($get_total_schema[0]->total_record > 0) { ?>
			<form id="tabs" method="POST" action="<?php echo site_url('/wp-admin/admin.php?page=dynamic_url_seo_schema_markup&update=true'); ?>">
		<?php 
			wp_nonce_field('dus-update-schema-form','dus_update_schema_form'); 
		} 
		else 
		{ 
		?>
			<form id="tabs" method="POST" action="">
		<?php 
			wp_nonce_field('dus-insert-schema-form','dus_insert_schema_form'); 
		} 
		?>
		<ul>
			<li><a href="#website">Website</a></li>
			<li><a href="#organization">Organization/Business</a></li>
		</ul>
		<?php 
			$org_website_url = dus_get_schema( '-org_website_url' ); 
			$org_website_url = !empty($org_website_url) ? dus_get_schema( '-org_website_url' ) : site_url('/'); 
			//$org_website_url = !empty(dus_get_schema( '-org_website_url' )) ? dus_get_schema( '-org_website_url' ) : site_url('/'); 
		?>
		<div id="organization">
			<h2>Organization/Business</h2>
			<table class="form-table">
				<tr>
					<th>
						<label for="Name">Website URL:</label>
					</th>
					<td colspan="2"><input id="-org_website_url" type="text" name="-org_website_url" value="<?php echo $org_website_url; ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="Name">Type:</label>
					</th>
					<td colspan="2">
						<select name="-org_type" id="org_type">
							<option value="organization" <?php if(dus_get_schema( '-org_type' ) == "organization") echo 'selected="selected"'; ?>>Organization</option>
							<option value="local_business" <?php if(dus_get_schema( '-org_type' ) == "local_business") echo 'selected="selected"'; ?>>Local Business</option>
						</select>
					</td>
				</tr>
				<tr class="local_business_types">
					<th>
						<label for="Name">Local Business Type:</label>
					</th>
					<td colspan="2">
					<select name="-org_location_type" id="-org_location_type">
						<option value="">Select One</option>
						<option value="AnimalShelter" <?php if(dus_get_schema( '-org_location_type' ) == "AnimalShelter") echo 'selected="selected"'; ?>>AnimalShelter (eg. Animal shelter.)</option>
						<option value="AutomotiveBusiness" <?php if(dus_get_schema( '-org_location_type' ) == "AutomotiveBusiness") echo 'selected="selected"'; ?>>AutomotiveBusiness (eg. Car repair, sales, or parts.)</small></option>
						<option value="ChildCare" <?php if(dus_get_schema( '-org_location_type' ) == "ChildCare") echo 'selected="selected"'; ?>>ChildCare (eg. A Childcare center.)</option>
						<option value="Dentist" <?php if(dus_get_schema( '-org_location_type' ) == "Dentist") echo 'selected="selected"'; ?>>Dentist (eg. A dentist.)</option>
						<option value="DryCleaningOrLaundry" <?php if(dus_get_schema( '-org_location_type' ) == "DryCleaningOrLaundry") echo 'selected="selected"'; ?>>DryCleaningOrLaundry (eg. A dry-cleaning business.)</option>
						<option value="EmergencyService" <?php if(dus_get_schema( '-org_location_type' ) == "EmergencyService") echo 'selected="selected"'; ?>>EmergencyService (eg. An emergency service, such as a fire station or ER.)</option>
						<option value="EmploymentAgency" <?php if(dus_get_schema( '-org_location_type' ) == "EmploymentAgency") echo 'selected="selected"'; ?>>EmploymentAgency (eg. An employment agency.)</option>
						<option value="EntertainmentBusiness" <?php if(dus_get_schema( '-org_location_type' ) == "EntertainmentBusiness") echo 'selected="selected"'; ?>>EntertainmentBusiness (eg. A business providing entertainment.)</option>
						<option value="FinancialService" <?php if(dus_get_schema( '-org_location_type' ) == "FinancialService") echo 'selected="selected"'; ?>>FinancialService (eg. Financial services business.)</option>
						<option value="FoodEstablishment" <?php if(dus_get_schema( '-org_location_type' ) == "FoodEstablishment") echo 'selected="selected"'; ?>>FoodEstablishment (eg. A food-related business.)</option>
						<option value="GovernmentOffice" <?php if(dus_get_schema( '-org_location_type' ) == "GovernmentOffice") echo 'selected="selected"'; ?>>GovernmentOffice (eg. A government office—for example, an IRS or DMV office.)</option>
						<option value="HealthAndBeautyBusiness" <?php if(dus_get_schema( '-org_location_type' ) == "HealthAndBeautyBusiness") echo 'selected="selected"'; ?>>HealthAndBeautyBusiness (eg. Health and beauty.)</option>
						<option value="HomeAndConstructionBusiness" <?php if(dus_get_schema( '-org_location_type' ) == "HomeAndConstructionBusiness") echo 'selected="selected"'; ?>>HomeAndConstructionBusiness (eg. A construction business.)</option>
						<option value="InternetCafe" <?php if(dus_get_schema( '-org_location_type' ) == "InternetCafe") echo 'selected="selected"'; ?>>InternetCafe (eg. An internet cafe.)</option>
						<option value="LegalService" <?php if(dus_get_schema( '-org_location_type' ) == "LegalService") echo 'selected="selected"'; ?>>LegalService (eg. A LegalService is a business that provides legally-oriented services, advice and representation, e.g. law firms.)</option>
						<option value="Library" <?php if(dus_get_schema( '-org_location_type' ) == "Library") echo 'selected="selected"'; ?>>Library (eg. A library.)</option>
						<option value="LodgingBusiness" <?php if(dus_get_schema( '-org_location_type' ) == "LodgingBusiness") echo 'selected="selected"'; ?>>LodgingBusiness (eg. A lodging business, such as a motel, hotel, or inn.)</option>
						<option value="MedicalBusiness" <?php if(dus_get_schema( '-org_location_type' ) == "MedicalBusiness") echo 'selected="selected"'; ?>>MedicalBusiness (eg. A particular physical or virtual business of an organization for medical purposes...)</option>
						<option value="ProfessionalService" <?php if(dus_get_schema( '-org_location_type' ) == "ProfessionalService") echo 'selected="selected"'; ?>>ProfessionalService (eg. Original definition: "provider of professional services.")</option>
						<option value="RadioStation" <?php if(dus_get_schema( '-org_location_type' ) == "RadioStation") echo 'selected="selected"'; ?>>RadioStation (eg. A radio station.)</option>
						<option value="RealEstateAgent" <?php if(dus_get_schema( '-org_location_type' ) == "RealEstateAgent") echo 'selected="selected"'; ?>>RealEstateAgent (eg. A real-estate agent.)</option>
						<option value="RecyclingCenter" <?php if(dus_get_schema( '-org_location_type' ) == "RecyclingCenter") echo 'selected="selected"'; ?>>RecyclingCenter (eg. A recycling center.)</option>
						<option value="SelfStorage" <?php if(dus_get_schema( '-org_location_type' ) == "SelfStorage") echo 'selected="selected"'; ?>>SelfStorage (eg. A self-storage facility.)</option>
						<option value="ShoppingCenter" <?php if(dus_get_schema( '-org_location_type' ) == "ShoppingCenter") echo 'selected="selected"'; ?>>ShoppingCenter (eg. A shopping center or mall.)</option>
						<option value="SportsActivityLocation" <?php if(dus_get_schema( '-org_location_type' ) == "SportsActivityLocation") echo 'selected="selected"'; ?>>SportsActivityLocation (eg. A sports location, such as a playing field.)</option>
						<option value="Store" <?php if(dus_get_schema( '-org_location_type' ) == "Store") echo 'selected="selected"'; ?>>Store (eg. A retail good store.)</option>
						<option value="TelevisionStation" <?php if(dus_get_schema( '-org_location_type' ) == "TelevisionStation") echo 'selected="selected"'; ?>>TelevisionStation (eg. A television station.)</option>
						<option value="TouristInformationCenter" <?php if(dus_get_schema( '-org_location_type' ) == "TouristInformationCenter") echo 'selected="selected"'; ?>>TouristInformationCenter (eg. A tourist information center.)</option>
						<option value="TravelAgency" <?php if(dus_get_schema( '-org_location_type' ) == "TravelAgency") echo 'selected="selected"'; ?>>TravelAgency (eg. A travel agency.)</option>
					</select>
					<p class="description" id="new-admin-email-description"></p>
					</td>
				</tr>
				<tr>
					<th>
						<label for="Name">Name:</label>
					</th>
					<td colspan="2"><input id="-org_name" type="text" name="-org_name" value="<?php echo dus_get_schema( '-org_name' ); ?>" /></td>
				</tr>
				<tr class="local_business_description">
					<th>
						<label for="Name">Description:</label>
					</th>
					<td colspan="2"><textarea id="-org_description" type="text" name="-org_description" rows="5" cols="110"><?php echo dus_get_schema( '-org_description' ); ?></textarea></td>
				</tr>
				<tr class="org_main_number">
					<th>
						<label for="Telephone">Phone:</label>
					</th>
					<td colspan="2"><input id="-org_main_number" type="text" name="-org_main_number" value="<?php echo dus_get_schema( '-org_main_number' ); ?>" /><p class="description" id="mobile-number"><?php echo __('Enter mobile number including country code'); ?> </p></td>
				</tr>
				<tr>
					<th>
						<label for="Address">Address:</label>
					</th>
					<td colspan="2"><textarea id="-org_address" type="text" name="-org_address" rows="5" cols="110"><?php echo dus_get_schema( '-org_address' ); ?></textarea></td>
				</tr>
				<tr>
					<th>
						<label for="City">City:</label>
					</th>
					<td colspan="2"><input id="-org_city" type="text" name="-org_city" value="<?php echo dus_get_schema( '-org_city' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="State">State:</label>
					</th>
					<td colspan="2"><input id="-org_state" type="text" name="-org_state" value="<?php echo dus_get_schema( '-org_state' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="ZipCode">Postal/Zip Code:</label>
					</th>
					<td colspan="2"><input id="-org_zip_code" type="text" name="-org_zip_code" value="<?php echo dus_get_schema( '-org_zip_code' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="Country">Country:</label>
					</th>
					<td colspan="2"><input id="-org_country" type="text" name="-org_country" value="<?php echo dus_get_schema( '-org_country' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="Categories">Logo (use a URL to your logo image):</label>
					</th>
					<td colspan="2"><input id="-org_logo" type="text" name="-org_logo" value="<?php echo dus_get_schema( '-org_logo' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="ContactType">Contact Type:</label>
					</th>
					<td colspan="2">
						<select name="-org_contact_type" id="-org_contact_type">
							<option value="Customer service" <?php if(dus_get_schema( '-org_contact_type' ) == "Customer service") echo 'selected="selected"'; ?>>Customer service</option>
							<option value="Technical support" <?php if(dus_get_schema( '-org_contact_type' ) == "Technical support") echo 'selected="selected"'; ?>>Technical support</option>
							<option value="Billing support" <?php if(dus_get_schema( '-org_contact_type' ) == "Billing support") echo 'selected="selected"'; ?>>Billing support</option>
							<option value="Bill payment" <?php if(dus_get_schema( '-org_contact_type' ) == "Bill payment") echo 'selected="selected"'; ?>>Bill payment</option>
							<option value="Sales" <?php if(dus_get_schema( '-org_contact_type' ) == "Sales") echo 'selected="selected"'; ?>>Sales</option>
							<option value="Reservations" <?php if(dus_get_schema( '-org_contact_type' ) == "Reservations") echo 'selected="selected"'; ?>>Reservations</option>
							<option value="Credit card support" <?php if(dus_get_schema( '-org_contact_type' ) == "Credit card support") echo 'selected="selected"'; ?>>Credit card support</option>
							<option value="Emergency" <?php if(dus_get_schema( '-org_contact_type' ) == "Emergency") echo 'selected="selected"'; ?>>Emergency</option>
							<option value="Baggage tracking" <?php if(dus_get_schema( '-org_contact_type' ) == "Baggage tracking") echo 'selected="selected"'; ?>>Baggage tracking</option>
							<option value="Roadside assistance" <?php if(dus_get_schema( '-org_contact_type' ) == "Roadside assistance") echo 'selected="selected"'; ?>>Roadside assistance</option>
							<option value="Package tracking" <?php if(dus_get_schema( '-org_contact_type' ) == "Package tracking") echo 'selected="selected"'; ?>>Package tracking</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="Telephone">Contact No.:</label>
					</th>
					<td colspan="2"><input id="-org_phone_number" type="text" name="-org_phone_number" value="<?php echo dus_get_schema( '-org_phone_number' ); ?>" /><p class="description" id="mobile-number"><?php echo __('Enter mobile number including country code'); ?> </p></td>
				</tr>
				<tr>
					<th>
						<label for="Country">Latitude:</label>
					</th>
					<td colspan="2"><input id="-org_latitude" type="text" name="-org_latitude" value="<?php echo dus_get_schema( '-org_latitude' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="Longitude">Longitude:</label>
					</th>
					<td colspan="2"><input id="-org_longitude" type="text" name="-org_longitude" value="<?php echo dus_get_schema( '-org_longitude' ); ?>" /></td>
				</tr>
			</table>
		</div>
		<div id="website">
			<h2>Website</h2>
			<table class="form-table">
				<tr>
					<th>
						<label for="Name">Name:</label>
					</th>
					<td colspan="2"><input id="-website_name" type="text" name="-website_name" value="<?php echo dus_get_schema( '-website_name' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="AlternateName">Alternate Name:</label>
					</th>
					<td colspan="2"><input id="-website_alt_name" type="text" name="-website_alt_name" value="<?php echo dus_get_schema( '-website_alt_name' ); ?>" /></td>
				</tr>
				<tr>
					<th>
						<label for="URL">URL:</label>
					</th>
					<td colspan="2"><input id="-website_url" type="text" name="-website_url" value="<?php echo dus_get_schema( '-website_url' ); ?>" />
					<p class="description" id="tagline-description"><?php echo __('Eg.'); ?> <?php echo site_url('/'); ?></p>
					</td>
				</tr>
			</table>
		</div>
		<?php if($get_total_schema[0]->total_record > 0) { ?>
		<table class="form-table">
			<tr>
				<th>&nbsp;</th>
				<td colspan="2">
					<input class="button button-primary" type="submit" name="schema_form_updated" value="Update" />
				</td>
			</tr>
		</table>
		<?php } else { ?>
		<table class="form-table">
			<tr>
				<th>&nbsp;</th>
				<td colspan="2">
					<input class="button button-primary" type="submit" name="schema_form_submitted" value="Save Changes" />
				</td>
			</tr>
		</table>
		<?php } ?>
	</form>
</div>
<?php
}