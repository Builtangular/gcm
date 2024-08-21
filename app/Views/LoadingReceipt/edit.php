<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?>
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="row">
					<div class="col-md-12"> 
						<?php $validation = \Config\Services::validation(); ?>
						<?php
						$session = \Config\Services::session();
						if ($session->getFlashdata('success')) {
							echo '
								<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
								';
						}
						?>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<!-- Settings Info -->
								<div class="card">
									<div class="card-body">
										<div class="settings-form"> 
											<?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($loading_receipts['id']>0) ? '/'.$loading_receipts['id'] : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
											<div class="settings-sub-header">
												<h4>Edit Loading Receipt</h4>
											</div>
											<?= $this->include('LoadingReceipt/form.php') ?>     
										</div>
									</div>
								</div>
								<!-- /Settings Info -->

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->
	<input type="hidden" id="selected_consignor_name" value="<?php echo $selected_consignor_name; ?>"/> 
	<input type="hidden" id="selected_consignee_name" value="<?php echo $selected_consignee_name; ?>"/> 

	<?= $this->include('partials/vendor-scripts') ?>

	<script>
		$.getBookingDetails = function() {
			$("#transporter_bilti_no_span").attr('hidden','hidden');
			$("#e_way_bill_no_span").attr('hidden','hidden');
			$("#transporter_bilti_no").attr('readonly','readonly');
			$("#transporter_bilti_no").removeAttr('required','required');
			$("#e_way_bill_no").attr('readonly','readonly');
			$("#e_way_bill_no").removeAttr('required','required');
			$("#transporter_bilti_no").val('');
			$("#e_way_bill_no").val('');
			$('#transporter_div').attr('hidden','hidden');
			$(".tr-req").val('');
			var booking_id = $('#booking_id').val();
			
			$(".tr-req").removeAttr('required');
			if(booking_id){
				$.ajax({
					method: "POST",
					url: '<?php echo base_url('loadingreceipt/getBookingDetails') ?>',
					data: {
						booking_id: booking_id
					},
					dataType: "json",
					success: function(res) { 
						$("#office_id").val(res.office_id).attr("selected","selected").trigger('change').attr('disabled','disabled');
						$("#booking_date").val(res.booking_date).attr('disabled','disabled');
						$("#vehicle_number").val(res.vehicle_id);
						$("#consignment_date").attr('min',res.booking_date);
						$("#loading_station").val(res.bp_city);
						$("#delivery_station").val(res.bp_city);
						$("#charge_weight").val(res.guranteed_wt);
						$("#customer_name").val(res.party_name);
						// alert(res.is_lr_third_party );
						if(res.is_lr_third_party > 0){
							$("#transporter_bilti_no_span").removeAttr('hidden');
							$("#e_way_bill_no_span").removeAttr('hidden');
							$("#transporter_bilti_no").removeAttr('readonly');
							$("#transporter_bilti_no").attr('required','required');
							$("#e_way_bill_no").removeAttr('readonly');
							$("#e_way_bill_no").attr('required','required');
							$('#transporter_div').removeAttr('hidden');
							$(".tr-req").attr('required','required');
						} 
					}
				});
			}else{
				$("#office_id").val('').trigger('change').attr('disabled','disabled');
				$("#booking_date").val('').attr('disabled','');
				$("#vehicle_number").val('');
				$("#consignment_date").attr('min','');
				$("#loading_station").val('');
				$("#delivery_station").val('');
				$("#charge_weight").val('');
				$("#customer_name").val('');
			}
			
		}

		$(document).ready(function() {
			$("#consignor_name").select2({
				tags: true
			}); 
			 $("#consignee_name").select2({
				tags: true
			});  
		}); 
		function changeIdIpt(branch_id,party_id,id,key = 'consignor'){
			// return true;
			var party_id = (party_id) > 0 ? party_id : 0; 
			var pre = 'place_of_dispatch';
			if(key == 'consignor'){
				pre = 'place_of_delivery';
			}  
			if((party_id>0) && (branch_id !='')){
				$.ajax({
				method: "POST",
				url: '<?php echo base_url('loadingreceipt/getPartyDetails') ?>',
				data: {
					party_id: party_id,
					branch_id:branch_id
				},
				dataType: "json",
				success: function(res) { 
						$("#"+pre+"_state").val(res.state_id).attr("selected","selected").trigger('change');  
						$("#"+pre+"_address").val(res.address);
						$("#"+pre+"_city").val(res.city);
						$("#"+pre+"_pincode").val(res.pincode);
					}
				}); 
			}else{
				$("#"+pre+"_state").val('').attr("selected","selected").trigger('change');  
				$("#"+pre+"_address").val('');
				$("#"+pre+"_city").val('');
				$("#"+pre+"_pincode").val('');
			}
		}
		
		$.getVehicleBookings = function() {
			var vehicle_id = $('#vehicle_number').val();
			
			$.ajax({
				method: "POST",
				url: '<?php echo base_url('loadingreceipt/getVehicleBookings') ?>',
				data: {
					vehicle_id: vehicle_id
				},
				dataType: "json",
				success: function(res) { 
					console.log(res);
					var html  ='<option value="">Select Booking</option>';
					if(res){
						$.each(res, function(i, item) { 
							var selected = (i==0) ? 'selected' : '';
							html += '<option value="'+item.id+'" "'+selected+'">'+item.booking_number+'</option>'
						}); 
					}
					$('#booking_id').html(html);
					$('#booking_id').val('').attr("selected","selected").trigger('change');   
				}
			});
		}

		function customerBranches(customer_id,customer_type){  
			$("#"+customer_type+"_office_id").attr('disabled','disabled');
			$("#"+customer_type+"_office_id").removeAttr('required');
			$('#'+customer_type+'_office_id').val('').attr("selected","selected").trigger('change');
			$("#"+customer_type+"_branch_span").attr('hidden','hidden');
			if(customer_id > 0 ){
				$('#'+customer_type+'_id').val(customer_id); 
				$.ajax({
					method: "POST",
					url: '<?php echo base_url('loadingreceipt/getCustomerBranches') ?>',
					data: {
						customer_id: customer_id  
					},
					dataType: "json",
					success: function(res) { 
						console.log(res);
						var html  ='<option value="">Select Ofiice</option>';
						if(res){
							$.each(res, function(i, item) { 
								var selected = (i==0) ? 'selected' : '';
								html += '<option value="'+item.office_name+'" "'+selected+'">'+item.office_name+'</option>'
							}); 
							$("#"+customer_type+"_office_id").removeAttr('disabled');
							$("#"+customer_type+"_office_id").attr('required','required');
						} 
						$('#'+customer_type+'_office_id').html(html);
						$('#'+customer_type+'_office_id').val('').attr("selected","selected").trigger('change');  
						$("#"+customer_type+"_branch_span").removeAttr('hidden');
					}
				});
			}
			partyInfo(customer_id, customer_type);
		}

		function partyInfo(party_id=0, key = 'consignor'){   
			var pre = 'place_of_delivery';
			if(key == 'consignee'){
				pre = 'place_of_dispatch';
			} 
			
			$("#"+key+"_state").val('').attr("selected","selected").trigger('change');  
			$("#"+key+"_address").val('');
			$("#"+key+"_city").val('');
			$("#"+key+"_pincode").val('');
			$("#"+key+"_GSTIN").val('');
			$("#"+pre+"_name").val('');

			if(party_id>0){
				$.ajax({
				method: "POST",
				url: '<?php echo base_url('loadingreceipt/getPartyInfo') ?>',
				data: {
					party_id: party_id
				},
				dataType: "json",
				success: function(res) {console.log(res);
						$("#"+key+"_state").val(res.state_id).attr("selected","selected").trigger('change');   
						$("#"+key+"_address").val(res.business_address);
						$("#"+key+"_city").val(res.city);
						$("#"+key+"_pincode").val(res.postcode);
						$("#"+key+"_GSTIN").val(res.gst);
						$("#"+pre+"_name").val(res.party_name); 
					}
				});
			}
		}
	</script>
</body>

</html>