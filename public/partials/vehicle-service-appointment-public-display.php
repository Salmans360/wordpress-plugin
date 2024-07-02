<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://torque360.co
 * @since      1.0.0
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/public/partials
 */

?>
<div id="service-appointment-torque360">
<div class="torque-loader"><div class="sipner"></div></div>

	<form action="" method="post" class="search-block">
		<select name="search_by" class="torque-search-by">
			<option value="phone">Phone Number</option>
			<option value="email">Email</option>
		</select>
		<input type="text" name="search_query" class="torque-search-query" placeholder="Enter Phone Number">
		<input type="submit" id="torque-customer-search" value="Search">
	</form>

	<p id="torque-api-response"></p>

	<form action="" method="post" id="appointment-form-torque360">
		<div class="torque-step1">
			<div class="customer-info">
				<div class="input-group">
					<label for="torque-name">Name</label>
					<input type="hidden" id="torque-customer-id" name="customer_id" placeholder="Enter Name">
					<input type="text" id="torque-name" name="name" placeholder="Enter Name">
				</div>
				<div class="input-group">
					<label for="torque-phone">Phone Number</label>
					<input type="text" id="torque-phone" name="phone" placeholder="Enter Phone Number">
				</div>
				<div class="input-group">
					<label for="torque-email">Email Address</label>
					<input type="email" id="torque-email" name="email" placeholder="Enter Email Address">
				</div>
<!-- 				<div class="input-group">
					<label for="torque-address">Address</label>
					<input type="text" id="torque-address" name="address" placeholder="Enter Address">
				</div> -->
			</div>

			<div class="vehicle-selector input-group" style="display:none;">
				<label for="select-vehicle">Select Vehicle</label>
				<select name="select-vehicle" id="select-vehicle" class="select-dropdown">
					<option selected disabled>No Vehicle Selected</option>
				</select>
			</div>

			<div class="vehicle-info">
				<div class="input-group">
					<label for="vehicle-make">Vehicle Make</label>
					<input type="hidden" id="vehicle-id" name="vehicle_id">
					<input type="text" id="vehicle-make" name="vehicle_make" placeholder="Enter Vehicle Make">
				</div>
				<div class="input-group">
					<label for="vehicle-model">Vehicle Model</label>
					<input type="text" id="vehicle-model" name="vehicle_model" placeholder="Enter Vehicle Model">
				</div>
				<div class="input-group">
					<label for="model-year">Model Year</label>
					<input type="text" id="model-year" name="model_year" placeholder="Enter Vehicle Year">
				</div>
<!-- 				<div class="input-group">
					<label for="engine-size">Engine Size</label>
					<input type="text" id="engine-size" name="engine_size" placeholder="Enter Vehicle Engine Size">
				</div> -->
<!-- 				<div class="input-group license-div">
					<label for="license-plate">License Plate</label>
					<input type="text" id="license-plate" name="license_plate" placeholder="Enter Model License Plate">
				</div> -->
<!-- 				<div class="input-group">
					<label for="vehicle-color">Color</label>
					<input type="text" id="vehicle-color" name="color" placeholder="Enter Vehicle Color">
				</div> -->
			</div>
			<div class="input-group license-div">
					<label for="license-plate">License Plate</label>
					<input type="text" id="license-plate" name="license_plate" placeholder="Enter Model License Plate">
				</div>
		</div>

		<div class="torque-step2" style="display:none;">
		    <div class="torque-cards-container">
		    	<div class="torque-card">
		    		<img src="<?=plugins_url( 'img/avatar.png', __FILE__ );?>" >
		    		<div class="content">
		    			<p class="customer-name"></p>
		    			<p class="customer-mobile"></p>
		    		</div>
		    	</div>
		    	<div class="torque-card">
		    		<img src="<?=plugins_url( 'img/car.png', __FILE__ );?>">
		    		<div class="content">
		    			<p class="customer-car-model"></p>
		    			<p class="customer-license-plate"></p>
		    		</div>
		    	</div>
		    </div>
					
			<div class="input-group">
				<label for="torque-multiselect">Service Request Details</label>
				<select id="torque-multiselect" name="services" multiple="multiple">
					<?php
                        $services_array = get_option( 'torque_vehicle_services', '' );
                        if(is_array($services_array)){
                            foreach($services_array['title'] as $key => $value)
                                printf( '<option value="%s">%s</option>', $value, $value);
                        }
                    ?>
				</select>
			</div>
					
			<div class="torque-date-time-container">
				<div class="date-input-group">
				<label for="torque-datepicker">Select Date</label>
					<input type="text" id="torque-datepicker" name="date" value="">
				</div>
				<div class="input-group">
					<label for="option-1">Available Slots</label>
					<select name="time" id="time">
						<option value="9:00">09:00 AM - 10:00 AM</option>
						<option value="10:00">10:00 AM - 11:00 AM</option>
						<option value="11:00">11:00 AM - 12:00 PM</option>
						<option value="12:00">12:00 PM - 01:00 PM</option>
						<option value="13:00">01:00 PM - 02:00 PM</option>
						<option value="14:00">02:00 PM - 03:00 PM</option>
						<option value="15:00">03:00 PM - 04:00 PM</option>
						<option value="16:00">04:00 PM - 05:00 PM</option>
						<option value="17:00">05:00 PM - 06:00 PM</option>
						<option value="18:00">06:00 PM - 07:00 PM</option>
						<option value="19:00">07:00 PM - 08:00 PM</option>
						<option value="20:00">08:00 PM - 09:00 PM</option>
						<option value="21:00">09:00 PM - 10:00 PM</option>
						<option value="22:00">10:00 PM - 11:00 PM</option>
						<option value="23:00">11:00 PM - 12:00 AM</option>
						<option value="24:00">12:00 AM - 01:00 AM</option>
						<option value="1:00">01:00 AM - 02:00 AM</option>
						<option value="2:00">02:00 AM - 03:00 AM</option>
						<option value="3:00">03:00 AM - 04:00 AM</option>
						<option value="4:00">04:00 AM - 05:00 AM</option>
						<option value="5:00">05:00 AM - 06:00 AM</option>
						<option value="6:00">06:00 AM - 07:00 AM</option>
						<option value="7:00">07:00 AM - 08:00 AM</option>
						<option value="8:00">08:00 AM - 09:00 AM</option>
					</select>
<!-- 					<div class="radio-group">
						<input type="radio" id="option-1" name="time" value="9:00">
						<label for="option-1">9:00 AM</label>
						<input type="radio" id="option-2" name="time" value="10:00">
						<label for="option-2">10:00 AM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-3" name="time" value="11:00">
						<label for="option-3">11:00 PM</label>
						<input type="radio" id="option-4" name="time" value="12:00">
						<label for="option-4">12:00 PM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-5" name="time"  value="13:00" checked>
						<label for="option-5">1:00 PM</label>
						<input type="radio" id="option-6" name="time" value="14:00">
						<label for="option-6">2:00 PM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-7" name="time" value="15:00">
						<label for="option-7">3:00 PM</label>
						<input type="radio" id="option-8" name="time" value="16:00">
						<label for="option-8">4:00 PM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-9" name="time" value="17:00">
						<label for="option-9">5:00 PM</label>
						<input type="radio" id="option-10" name="time" value="18:00">
						<label for="option-10">6:00 PM</label>
					</div> -->
				</div>	
			</div>
	    </div>
    </form>
	<div class="control-block">
		<a href="javascript:;" class="torque-btn back" style="display:none;">Back</a>
		<a href="javascript:;" class="torque-btn book" style="display:none;">Book Appointment</a>
		<a href="javascript:;" class="torque-btn next">Next</a>
	</div>
</div>