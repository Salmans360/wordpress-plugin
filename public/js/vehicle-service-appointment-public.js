(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	var customer = "";
	$(document).ready(function() {
		const emailRegex = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		$('#torque-phone').mask('(000) 000-0000');

		$("#select-vehicle").change(function() {
			changeVehicle($(this).val());
		});
	
		$('#torque-datepicker').datepicker({
			minDate: new Date(),
			beforeShow: function(input, inst){
				$(inst.dpDiv).addClass('torque-datepicker');
			}
		});
		$('#torque-multiselect').select2();

		changeSearchBy($('input[name="search_query"]'), false);
		$('.torque-search-by').change(function() {
			changeSearchBy($('input[name="search_query"]'), true);
		});

		$('#torque-customer-search').click(function(elm) {
			elm.preventDefault();
			$('.torque-search-query').removeAttr('style');
			$('#service-appointment-torque360 input').removeAttr('style');
			if( ($('.torque-search-by').val() == "phone" && $('.torque-search-query').val().length <= 13) || ($('.torque-search-by').val() == "email" && !emailRegex.test($('.torque-search-query').val())) ){
				$('.torque-search-query').css('border', '1px solid red');
				$('html, body').animate({
					scrollTop: $('.torque-search-query').offset().top-100
				}, 1000);
				$('.torque-search-query').focus();
				return false;
			}else{
				$('.torque-loader').show();
				$.post(ajax.url, {
					'action': 'torque_customer_search',
					'search_by': $('.torque-search-by').val(),
					'search_query': $('.torque-search-query').val(),
					'nonce': ajax.search_nonce
				}, function(response){
					$('.torque-loader').hide();

					if(response.success){
						printResponse(response.data.message);

						if (response.data.data[0] != null) {
							$('#appointment-form-torque360').trigger('reset');
							$('#torque-multiselect').val(null).trigger('change');

							customer = response.data.data[0];
							$('#torque-customer-id').val(customer.id);
							$('#torque-name').val(customer.name);
							$('#torque-phone').val(customer.phone);
							$('#torque-email').val(customer.email);
							$('#torque-address').val(customer.address);
							$("#select-vehicle").html('');
							$("#select-vehicle").append( $('<option selected></option>').val(-1).html('Select Vehicle'));
							$.each(customer.vehicles, function(index, vehicle) {
								$("#select-vehicle").append( $('<option></option>').val(index).html(vehicle.modelYear+" "+vehicle.vehicleMake+" "+vehicle.vehicleModel+" "+ vehicle.licensePlate) );
							});

							$(".vehicle-selector").show();
						}
					}else{
						printResponse("Unable to search, Please contact website owner.");
					}
				});
			}
		});

		$('.torque-btn').click(function() {
			if($(this).hasClass('next')){
				var move = false;
				
				printResponse("");

				$.each($('.torque-step1 input:not([type="hidden"])'), function(index, input){
					$(input).removeAttr('style');

					if($(input).val() == ""){
						$(input).css('border', '1px solid red');
						$('html, body').animate({
							scrollTop: $(input).offset().top-100
						}, 1000);

						move = false;
						return false;
					}
					move = true;
				});

				if(move){
					$('.torque-card p.customer-name').html( $("#torque-name").val() );
					$('.torque-card p.customer-mobile').html( "Mobile: " + $("#torque-phone").val() );

					$('.torque-card p.customer-car-model').html( $('#model-year').val() + " " + $('#vehicle-make').val()  + " " + $('#vehicle-model').val() );
					$('.torque-card p.customer-license-plate').html( "License Plate: " + $('#license-plate').val() );

					$('.torque-step1, .torque-btn.next').hide();
					$('.torque-step2, .torque-btn.back, .torque-btn.book').show();
				}

			}else if($(this).hasClass('back')){

				$('.torque-step1, .torque-btn.next').show();
				$('.torque-step2, .torque-btn.back, .torque-btn.book').hide();

			}else if($(this).hasClass('book')){

				var data = convertFormToJSON($('#appointment-form-torque360'));
				data.services = $('#torque-multiselect').select2("val").join();
				$('.select2-selection').removeAttr('style');
				$('#torque-datepicker').removeAttr('style');

				if(data.services == ""){
					$('.select2-selection').css('border', '1px solid red');
					$('html, body').animate({
						scrollTop: $('.select2-selection').offset().top-100
					}, 1000);
				}else if($('#torque-datepicker').val() == ""){
					$('#torque-datepicker').css('border', '1px solid red');
					$('html, body').animate({
						scrollTop: $('#torque-datepicker').offset().top-100
					}, 1000);
				}else{
					$('.torque-loader').show();
					$.post(ajax.url, {
						'action': 'torque_process_appointment',
						'data': data,
						'nonce': ajax.appointment_nonce
					}, function(response){
						$('.torque-loader').hide();

						if(response.success){
							window.location.replace("https://carmotiveauto.com/thank-you");
							
							printResponse($.parseJSON(response.data).message);
							
							$('#appointment-form-torque360, .search-block').trigger('reset');
							$('.torque-search-by').trigger('change');
							$(".vehicle-selector").hide();
							$('#torque-multiselect').val(null).trigger('change');
							$('.torque-step1, .torque-btn.next').show();
							$('.torque-step2, .torque-btn.back, .torque-btn.book').hide();
						}else{
							printResponse("Unable to add appointment, Please contact website owner.");
						}
						
					});
				}
			}
		});
	});

	function changeVehicle(key) {

		$('#vehicle-id').val(customer.vehicles[key].id);
		$('#vehicle-make').val(customer.vehicles[key].vehicleMake);
		$('#vehicle-model').val(customer.vehicles[key].vehicleModel);
		$('#model-year').val(customer.vehicles[key].modelYear);
		$('#engine-size').val(customer.vehicles[key].displacement);
		$('#license-plate').val(customer.vehicles[key].licensePlate);
		$('#vehicle-color').val(customer.vehicles[key].color);

		$('.torque-card p.customer-car-model').html( customer.vehicles[key].modelYear + " " + customer.vehicles[key].vehicleMake  + " " + customer.vehicles[key].vehicleModel );
		$('.torque-card p.customer-license-plate').html( "License Plate: " + customer.vehicles[key].licensePlate );
	}

	function changeSearchBy($elm, empty) {
		if($('.torque-search-by').val() == "phone"){
			$elm.attr('placeholder', 'Enter Phone Number').removeAttr('style').mask('(000) 000-0000');
		}
		else if($('.torque-search-by').val() == "email"){
			$elm.attr('placeholder', 'Enter Your Email').removeAttr('style').unmask();
		}

		if(empty){
			$elm.val('');
		}
	}

	function printResponse(msg) {
		$('#torque-api-response').html(msg);
		if(msg != ""){
			$('html, body').animate({
			    scrollTop: $('#torque-api-response').offset().top-100
			}, 1000);
		}
	}

	function convertFormToJSON(form) {
		return form
		  .serializeArray()
		  .reduce(function (json, { name, value }) {
			json[name] = value;
			return json;
		}, {});
	}
})( jQuery );
