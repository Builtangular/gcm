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

            <?= $this->include('partials/page-title') ?>

            <?php $validation = \Config\Services::validation();

            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">

                      <?php
                      // print_r($booking_details);
                      // print_r($offices);
                      ?>
                      <form method="post" enctype="multipart/form-data" action="<?php echo base_url('booking/approve/' . $booking_details['id']); ?>">

                        <div class="settings-sub-header">
                          <h6>Approve Booking</h6>
                        </div>
                        <div class="profile-details">
                          <div class="row g-3">


                            <div class="col-md-3">
                              <label class="col-form-label">Booking For <span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="booking_for" id="booking_for" aria-label="Default select example">
                                <option value="">Select Material</option>
                                <?php if($booking_for) { foreach($booking_for as $val){?>
                                  <option value="<?= $val['id'] ?>" <?= $booking_details['booking_for'] == $val['id'] ? 'selected' : '' ?> ><?= $val['name'] ?></option>
                                <?php }}?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="office_id" id="office_id" aria-label="Default select example">
                                <option value="">Select Office</option>
                                <?php foreach ($offices as $o) {
                                  echo '<option value="' . $o['id'] . '"  ' . ($booking_details['office_id'] == $o['id'] ? 'selected' : '') . '>' . $o['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle Type<span class="text-danger">*</span></label>
                              <select class="form-select" name="vehicle_type" required id="vehicle_type" onchange="$.getVehicles();">
                                <option value="">Select Vehicle Type</option>
                                <?php foreach ($vehicle_types as $vt) {
                                  echo '<option value="' . $vt['id'] . '"  ' . ($booking_details['vehicle_type_id'] == $vt['id'] ? 'selected' : '') . '>' . $vt['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Vehicle RC<span class="text-danger">*</span></label>
                              <select class="form-select select2" name="vehicle_rc" required id="vehicle_rc">
                                <option value="">Select RC</option>
                                <?php foreach ($vehicle_rcs as $rc) {
                                  echo '<option value="' . $rc['id'] . '" ' . ($booking_details['vehicle_id'] == $rc['id'] ? 'selected' : '') . '>' . $rc['rc_number'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-4">
                              <label class="col-form-label">Customer Name<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="customer_id" id="customer_id" aria-label="Default select example" onchange="$.getPartyType();">
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '" ' . ($booking_details['customer_id'] == $c['id'] ? 'selected' : '') . '>' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Branch<span class="text-danger">*</span></label>
                              <select class="form-select" name="customer_branch" required id="customer_branch" aria-label="Default select example">
                                <option value="">Select Branch</option>
                              </select>
                              <label id="msg" class="text-danger"></label>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Customer Type</label>
                              <select class="form-select" name="customer_type" id="customer_type" aria-label="Default select example">
                                <option value="">Select Type</option>
                              </select>
                            </div> 

                            <?php 
                            $city = isset($last_booking_transaction['city']) && ($last_booking_transaction['city']) ? $last_booking_transaction['city']: '';
                            $state = isset($last_booking_transaction['state_name']) && ($last_booking_transaction['state_name']) ? ' , '.$last_booking_transaction['state_name']: '';
                            $pincode = isset($last_booking_transaction['pincode']) && ($last_booking_transaction['pincode']) ? ' , '.$last_booking_transaction['pincode']: '';
                            ?>
                            <?php if($city || $state || $pincode){ ?>
                              <div class="col-md-12">
                              <h6>Last Drop:  
                                  <?= $city. $state .$pincode  ?>
                              </h6>
                              </div>
                            <?php } ?>  

                            <div class="col-md-12">
                              <label class="col-form-label">Pickup Details<span class="text-danger">*</span></label>
                            </div>  

                            
                            <div class="col-md-3">
                                <label class="col-form-label">Country<span class="text-danger">*</span></label>
                                <select class="form-select" name="pickup_country_id"  required onchange="getState(this.value,'pickup_state_id')">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countries as $s) { ?>
                                        <option value="<?= $s['country_id'] ?>" <?= isset($booking_pickups['country_id']) && ($booking_pickups['country_id'] == $s['country_id']) ? 'selected' : '' ?>><?= $s['name'] ?></option>
                                        <?php } ?>
                                        <option value="0" <?= isset($booking_pickups['country_id']) && ($booking_pickups['country_id'] == 0) ? 'selected' : '' ?> >Other Country</option>
                                </select>
                                <?php
                                if ($validation->getError('country_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('country_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-3">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <input type="hidden"  name="selected_pickup_state_id" id="selected_pickup_state_id" class="form-control" value="<?= isset($booking_pickups['state']) ? $booking_pickups['state'] : '' ?>">   
                                <select class="form-select" name="pickup_state_id" id="pickup_state_id" aria-label="Default select example" required onchange="getCitiesByState(this.value,'pickup_city')">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) { ?>
                                        <option value="<?= $s['state_id'] ?>" <?= isset($booking_pickups['state']) && ($booking_pickups['state'] == $s['state_id']) ? 'selected' : '' ?>><?= $s['state_name'] ?></option>
                                        <?php } ?>
                                        <option value="0" <?= isset($booking_pickups['state']) && ($booking_pickups['state'] == 0) ? 'selected' : '' ?>>Other State</option>
                                </select>
                                <?php
                                if ($validation->getError('pickup_state_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_state_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">City<span class="text-danger">*</span></label> 
                                <input type="hidden"  name="pickup_city_id" id="pickup_city_id" class="form-control" value="<?= isset($booking_pickups['city_id']) ? $booking_pickups['city_id'] : '' ?>">   
                                <select class="form-select" name="pickup_city" id="pickup_city" aria-label="Default select example" required  onchange="changeCity(this,$(this).find(':selected').attr('pickup_city_id'),'pickup_city_id','pickup_pin');getPincodeByCity($(this).find(':selected').attr('pickup_city_id'),'pickup_pin');">
                                        <option value="">Select </option>  
                                        <option value="0" <?= isset($booking_pickups['city_id']) && ($booking_pickups['city_id'] == 0) ? 'selected' : '' ?>>Other City</option>
                                </select>

                                <?php
                                if ($validation->getError('pickup_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_city') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">PinCode</label>                                 
                                <input type="hidden" name="selected_pickup_pin" id="selected_pickup_pin" class="form-control" value="<?= isset($booking_pickups['pincode']) ? $booking_pickups['pincode'] : '' ?>">
                                
                                <select class="form-select" name="pickup_pin" id="pickup_pin">
                                    <option value="">Select </option>  
                                </select>

                                <?php if ($validation->getError('pickup_pin')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('pickup_pin') . '</div>';
                                }   
                                ?>
                            </div>
                            <div class="col-md-12">
                              <label class="col-form-label">Drop Details<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Country<span class="text-danger">*</span></label>
                                <select class="form-select" name="drop_country_id"  required onchange="getState(this.value,'drop_state_id')">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countries as $s) { ?>
                                        <option value="<?= $s['country_id'] ?>" <?= isset($booking_drops['country_id']) && ($booking_drops['country_id'] == $s['country_id']) ? 'selected' : '' ?>><?= $s['name'] ?></option>
                                        <?php } ?>
                                        <option value="0" <?= isset($booking_drops['country_id']) && ($booking_drops['country_id'] == 0) ? 'selected' : '' ?>>Other Country</option>
                                </select>
                                <?php
                                if ($validation->getError('country_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('country_id') . '</div>';
                                }   
                                ?>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                <input type="hidden"  name="selected_drop_state_id" id="selected_drop_state_id" class="form-control" value="<?= isset($booking_drops['state']) ? $booking_drops['state'] : '' ?>">   
                                <select class="form-select" name="drop_state_id" id="drop_state_id" aria-label="Default select example" required  onchange="getCitiesByState(this.value,'drop_city')">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $s) { ?>
                                         <option value="<?= $s['state_id'] ?>" <?= isset($booking_drops['state']) && ($booking_drops['state'] == $s['state_id']) ? 'selected' : '' ?>><?= $s['state_name'] ?></option> 
                                        <?php } ?>
                                        <option value="0" <?= isset($booking_drops['state']) && ($booking_drops['state'] == 0) ? 'selected' : '' ?>>Other State</option>
                                </select>
                                <?php
                                if ($validation->getError('drop_state_id')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_state_id') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">City<span class="text-danger">*</span></label>
                                <input type="hidden"  name="drop_city_id" id="drop_city_id" class="form-control" value="<?= isset($booking_drops['city_id']) ? $booking_drops['city_id'] : 0 ?>">                               
                                <select class="form-select" name="drop_city" id="drop_city" aria-label="Default select example" required  onchange="changeCity(this,$(this).find(':selected').attr('drop_city_id'),'drop_city_id','drop_pin');getPincodeByCity($(this).find(':selected').attr('drop_city_id'),'drop_pin');">
                                        <option value="">Select </option> 
                                        <?php if(!empty($drop_cities)){ ?>
                                          <?php foreach($drop_cities as $key => $c){ ?>
                                            <option value="<?php echo $c;?>" drop_city_id="<?php echo $key;?>"><?php echo $c;?></option>
                                          <?php }?>
                                        <?php } ?>
                                        <option value="0" <?= isset($booking_drops['city_id']) && ($booking_drops['city_id'] == 0) ? 'selected' : '' ?>>Other City</option>
                                </select>
                                <?php
                                if ($validation->getError('drop_city')) {
                                    echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_city') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">PinCode</label> 
                                <input type="hidden" name="selected_drop_pin" id="selected_drop_pin" class="form-control" value="<?= isset($booking_drops['pincode']) ? $booking_drops['pincode'] : '' ?>">
                                <select class="form-select" name="drop_pin" id="drop_pin">
                                    <option value="">Select </option>  
                                </select>
                               <?php if ($validation->getError('drop_pin')) {
                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('drop_pin') . '</div>';
                                }   
                                ?>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-2">
                              <label class="col-form-label">Pickup Date <span class="text-danger">*</span></label>
                              <input type="date" required name="pickup_date" id="pickup_date" value="<?= $booking_details['pickup_date'] ?>" class="form-control">
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Drop Date</label>
                              <input type="date" name="drop_date" id="drop_date" value="<?= $booking_details['drop_date'] ?>" class="form-control">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Booking By<span class="text-danger">*</span></label>
                              <select class="form-select" required name="booking_by" aria-label="Default select example" onchange="">
                                <option value="">Select Employee</option>
                                <?php foreach ($employees as $e) {
                                  echo '<option value="' . $e['id'] . '"  ' . ($booking_details['booking_by'] == $e['id'] ? 'selected' : '') . '>' . $e['name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <label class="col-form-label">Booking Date<span class="text-danger">*</span></label>
                              <input type="date" required name="booking_date" value="<?= $booking_details['booking_date'] ?>" class="form-control">
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <label class="col-form-label">Rate Type <span class="text-danger">*</span></label>
                              <select class="form-select" name="rate_type" id="rate_type" onchange="$.calculation()" required>
                                <option value="">Select Rate Type</option>
                                <option value="1" <?= $booking_details['rate_type'] == '1' ? 'selected' : '' ?>>By Weight</option>
                                <option value="2" <?= $booking_details['rate_type'] == '2' ? 'selected' : '' ?>>Aggregate</option>
                              </select>
                            </div>

                            <div class="col-md-3"> 
                              <label class="col-form-label">Rate (Rs) <span class="text-danger">*</span> <span id="rate_msg"></span></label>
                              <input type="number" step="0.01"  name="rate" id="rate" onchange="$.calculation()" class="form-control" value="<?= $booking_details['rate'] ?>" required>
                            </div>

                            <!-- <div class="col-md-3">
                              <label class="col-form-label">Commission</label>
                              <input type="number" step="0.01"  min="0" name="commission" id="commission" class="form-control"  value="<?= isset($booking_details['commission']) ? $booking_details['commission'] : '' ?>">
                              <?php
                              // if ($validation->getError('commission')) {
                              //     echo '<div class="alert alert-danger mt-2">' . $validation->getError('commission') . '</div>';
                              // }   
                              ?>
                            </div> -->

                            <div class="col-md-12"></div>

                            <div class="col-md-8">
                              <table class="table table-borderless" id="expense_table">
                                <tbody id="expense_body">
                                  <tr>
                                    <td width="40%">Expense Head</td>
                                    <td>Value</td>
                                    <td>Bill To Party</td>
                                  </tr>

                                  <?php
                                  if(isset($booking_expences) && !empty($booking_expences)){
                                  $i = 1;
                                  foreach ($booking_expences as $be) {
                                  ?>
                                    <tr id="del_expense_<?= $i ?>">
                                      <td>
                                        <select class="form-select" name="expense[]" aria-label="Default select example">
                                          <option value="">Select Expense</option>
                                          <?php if(isset($expense_heads)){
                                            foreach($expense_heads as $val){ ?> 
                                                  <option value="<?= $val['id'] ?>" <?= $be['expense'] == $val['id'] ? 'selected' : '' ?> ><?= $val['head_name'] ?></option>
                                          <?php }
                                          } ?> 
                                        </select>
                                      </td>
                                      <td><input type="number" name="expense_value[]" id="expense_<?= $i ?>" value="<?= $be['value'] ?>" class="form-control <?= $be['bill_to_party'] != 1 ? 'not_to_bill' : 'bill' ?>" onchange="$.billToParty('<?= $i ?>');"></td>
                                      <td><input class="form-check-input" type="checkbox" name="expense_flag_<?= $i ?>" id="expense_flag_<?= $i ?>" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('<?= $i ?>');" <?= $be['bill_to_party'] == 1 ? 'checked' : '' ?>></td>
                                      <td>
                                        <?php if ($i > 1) { ?>
                                          <button type="button" class="btn btn-sm btn-danger" onclick="$.delete(<?= $i ?>,'expense')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        <?php } else { ?>
                                          <button type="button" class="btn btn-sm btn-warning" onclick="$.addExpense()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        <?php } ?>

                                      </td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }}else{ ?>
                                    <tr>
                                      <td>
                                        <select class="form-select" name="expense[]" aria-label="Default select example">
                                          <option value="">Select Expense</option>
                                          <?php if(isset($expense_heads)){
                                              foreach($expense_heads as $val){ ?> 
                                                    <option value="<?= $val['id'] ?>"><?= $val['head_name'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                      </td>
                                      <td><input type="number" name="expense_value[]" id="expense_1" class="form-control not_to_bill" onchange="$.billToParty('1');"></td>
                                      <td><input class="form-check-input" type="checkbox" name="expense_flag_1" id="expense_flag_1" style="height:30px; width:30px; border-radius: 50%;" onchange="$.billToParty('1');"></td>
                                      <td><button type="button" class="btn btn-sm btn-warning" onclick="$.addExpense()"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                                    </tr>
                                    <?php } ?>

                                </tbody>
                              </table>
                            </div>

                            <div class="col-md-12"></div>

                            <div class="col-md-3">
                              <label class="col-form-label">Guaranteed / Charged Weight</label>
                              <input type="number" name="guranteed_wt" id="guranteed_wt" onchange="$.calculation()" class="form-control" value="<?= ($booking_details['guranteed_wt'] > 0) ? $booking_details['guranteed_wt'] : (isset($booking_vehicle_details['charge_wt']) ? $booking_vehicle_details['charge_wt'] : '') ?>">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Total Freight</label>
                              <input type="number" name="freight" id="freight" onchange="$.calculation()" class="form-control" value="<?= $booking_details['freight'] ?>" readonly>
                            </div>
                                                    
                            <div class="col-md-3">
                                <label class="col-form-label">Other Expenses</label>
                                <input type="decimal" step="0.01" id="other_expenses" class="form-control" name="other_expenses" readonly value="<?= isset($booking_details['other_expenses'])  ? $booking_details['other_expenses'] : 0  ?>" >
                            </div>
                            
                            <div class="col-md-3"> 
                              <label class="col-form-label">Advance</label>
                              <input type="number" name="advance" id="advance" onchange="$.calculation()" class="form-control" value="<?= $booking_details['advance'] ?>">
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Discount</label>
                              <input type="number" name="discount" id="discount" onchange="$.calculation()" class="form-control" value="<?= $booking_details['discount'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Balance</label>
                              <input type="number" name="balance" id="balance" onchange="$.calculation()" class="form-control" value="<?= $booking_details['balance'] ?>" readonly>
                            </div>

                            <div class="col-md-3">
                              <label class="col-form-label">Bill To<span class="text-danger">*</span></label>
                              <select class="form-select select2" required name="bill_to" aria-label="Default select example" onchange="">
                                <option value="">Select Party</option>
                                <?php foreach ($customers as $c) {
                                  echo '<option value="' . $c['id'] . '"' . ($booking_details['bill_to_party'] == $c['id'] ? 'selected' : '') . '>' . $c['party_name'] . '</option>';
                                } ?>
                              </select>
                            </div>

                            <div class="col-md-9">
                              <label class="col-form-label">Remarks</label>
                              <input type="text" name="remarks" class="form-control" value="<?= $booking_details['remarks'] ?>">
                            </div>

                            <div class="col-md-12 mb-3">
                              <input type="checkbox" id="approve" class="form-check-input" checked name="approve" value="1" style="height: 25px; width:25px;"> <label for="approve"> Approve</label>
                            </div>


                          </div>
                          <br>
                        </div>
                        <div class="submit-button">
                          <button type="submit" class="btn btn-primary" id="save-btn">Save Changes</button>
                          <a href="<?= base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : '') ?>" class="btn btn-warning">Reset</a>
                          <a href="<?php echo base_url('booking'); ?>" class="btn btn-light">Back</a>
                        </div>
                      </form>

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
  <input type="hidden" id="selected_pickup_city" value="<?php echo $selected_pickup_city; ?>"/> 
  <input type="hidden" id="selected_drop_city" value="<?php echo $selected_drop_city; ?>"/> 

  <?= $this->include('partials/vendor-scripts') ?>
  <script>
    $(document).ready(function() {
      $.getPartyType(); 
      $.getVehicles(); 
    });


    $.addPickup = function() {
      var tot = $('#pickup_table').children('tbody').children('tr').length;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/add-pickup'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#pickup_body').append(data);
        }
      })
    }

    $.addDrop = function() {
      var tot = $('#drop_table').children('tbody').children('tr').length;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/add-drop'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#drop_body').append(data);
        }
      })
    }

    $.delete = function(index, str) {
      $('#del_' + str + '_' + index).remove();
      $.calculation();
    }

    $.getPartyType = function() {

      var customer_id = $('#customer_id').val();

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('booking/getCustomerType') ?>',
        data: {
          customer_id: customer_id
        },
        success: function(response) {
          $('#customer_type').html(response);
        }
      });

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('booking/getCustomerBranch') ?>',
        data: {
          customer_id: customer_id
        },
        success: function(response) {
          if (response != '') {
            $('#customer_branch').html(response);
            $('#msg').html('');
            $('#save-btn').removeAttr('disabled');
          } else {
            $('#msg').html('branch not created for customer');
            $('#save-btn').attr('disabled', 'disabled');
          }
        }
      });

    }

    $.getVehicles = function() {
      var vehicle_type = $('#vehicle_type').val();

      $.ajax({
        method: "POST",
        url: '<?php echo base_url('booking/getUnassignVehicles') ?>',
        data: {
          vehicle_type: vehicle_type,
          booking_id:<?= $booking_details['id'] ?>
        },
        beforeSend: function() { 
            $('#save-btn').attr('disabled','disabled'); 
        }, 
        success: function(response) {
          $('#vehicle_rc').html(response);
          $('#save-btn').removeAttr('disabled'); 
        }
      });
    }

    $.setDrop = function() {
      var pickup_date = $('#pickup_date').val();
      console.log(pickup_date);
      $('#drop_date').attr('min', pickup_date);
    }

    $.addExpense = function() {
      var tot = $('#expense_table').children('tbody').children('tr').length;

      console.log(tot);
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('booking/addExpense'); ?>",
        data: {
          index: tot
        },
        success: function(data) {
          $('#expense_body').append(data);
        }
      })
    }

    $.billToParty = function(index) {
      if ($("#expense_flag_" + index).prop("checked")) {
        $('#expense_' + index).addClass('bill');
        $('#expense_' + index).removeClass('not_to_bill');
      } else {
        $('#expense_' + index).addClass('not_to_bill');
        $('#expense_' + index).removeClass('bill');
      }

      $.calculation();
    }

    $.calculation = function() {
      var rate_type = parseInt($('#rate_type').val());
      var rate = parseFloat($('#rate').val());
      var freight = 0;

      if (rate_type == 1) {
        //by weight
        $('#guranteed_wt_span').html('*');
        $('#guranteed_wt').attr('required', 'required');
        $('#rate_msg').html(' - Per KG');
      } else {
        //aggregate
        $('#guranteed_wt_span').html('');
        $('#guranteed_wt').removeAttr('required');
        $('#rate_msg').html(' - Overall');
      }

      
      var notbilltotal = 0;
      $('.not_to_bill').each(function() {
        notbilltotal += parseFloat($(this).val());
      });
      $('#discount').val(notbilltotal);
      
      if (rate > 0) {

        var billtotal = 0;
        $('.bill').each(function() {
          billtotal += parseFloat($(this).val());
        });

        console.log(billtotal);

        freight = freight;

        // for guranteed weight
        if (rate_type == 1) {

          var guranteed_wt = parseFloat($('#guranteed_wt').val());
          freight = (rate * guranteed_wt);

        } else {

          freight = rate;
        }
        $('#other_expenses').val(billtotal);
        $('#freight').val(freight);

        var advance = $('#advance').val();
        var discount = $('#discount').val();

        $('#balance').val((freight+billtotal) - advance - discount);


        console.log(rate_type, rate);
      }
    }

    function getCitiesByState(val,changed_id){ 
      var selectedchanged_id = $('#selected_'+changed_id).val();
      var html ='<option value="">Select</option>'; 
      // alert('getCitiesByState '+val+' / val ' +changed_id + ' / selected '+ $('#selected_'+changed_id).val());
      if(val == 0){ 
      var selected = (selectedchanged_id == 0) ? 'selected': '';
       html += '<option value="0" '+selected+'>Other City</option>';
       $('#'+changed_id).html(html);
       $('#'+changed_id).trigger('change'); 
      }
      if(val > 0){
            $.ajax({
              method: "POST",
              url: '<?php echo base_url('booking/getCitiesByState') ?>',
              data: {
                state_id: val
              },
              dataType:'json',
              beforeSend: function() { 
                   $("body").css({ opacity:0.5 });
                    $('#save-btn').attr('disabled','disabled'); 
              },
              complete: function(){
                $("body").css({ opacity:1});
                 $('#save-btn').removeAttr('disabled'); 
              },
              success: function(response) {
                console.log(response);
                var html ='<option value="0">Select</option>';
                if(response){
                  response.forEach(function(val) {
                    var selected =(selectedchanged_id == val.city) ? 'selected': '';
                      html += '<option value="'+val.city+'" '+changed_id+'_id="'+val.id+'" '+selected+'  >'+val.city+'</option>'
                  });
                }
                $('#'+changed_id).html(html);
                $('#'+changed_id).trigger('change');
              }
            });
        }
    }
    $(document).ready(function() {
      var pickup_city =  $("#pickup_city").select2({
        tags: true
      }); 
      var drop_city =  $("#drop_city").select2({
        tags: true
      }); 

      var pickup_pin =  $("#pickup_pin").select2({
        tags: true
      }); 

      var drop_pin =  $("#drop_pin").select2({
        tags: true
      }); 

      $('form').submit(function() { 
        $(":submit").attr("disabled", "disabled");
      });
      
    });
    $("#pickup_city").val($('#selected_pickup_city').val()).trigger('change');
    $("#drop_city").val($('#selected_drop_city').val()).trigger('change');
    function changeCity(thisv,city_id_val,id){   
      $('#'+id).val( (city_id_val) > 0 ? city_id_val : 0) ;
    }

    $("#pickup_country_id").trigger('change');
    $("#drop_country_id").trigger('change');

    $("#pickup_state_id").val($('#selected_pickup_state_id').val()).trigger('change');
    $("#drop_state_id").val($('#selected_drop_state_id').val()).trigger('change');

    function getState(val,changed_id){ 
      var html ='<option value="">Select</option>';  
      if(val == 0){
       html += '<option value="0">Other State</option>';
       $('#'+changed_id).html(html);
       $('#'+changed_id).trigger('change');
      }
      if(val > 0){
            $.ajax({
              method: "POST",
              url: '<?php echo base_url('booking/getStateByCountry') ?>',
              data: {
                country_id: val
              },
              dataType:'json',
              beforeSend: function() { 
                   $("body").css({ opacity:0.5 });
                    $('#save-btn').attr('disabled','disabled'); 
              },
              complete: function(){
                $("body").css({ opacity:1});
                 $('#save-btn').removeAttr('disabled'); 
              },
              success: function(response) {  
                if(response){ 
                  response.forEach(function(val) {
                      html += '<option value="'+val.state_id+'" >'+val.state_name+'</option>'
                  });
                }
                $('#'+changed_id).html(html);
                $('#'+changed_id).trigger('change');
              }
            });
        }
    } 
    function getPincodeByCity(city_id_val,changed_id){  
      var html ='<option value="">Select</option>';   
      if(city_id_val > 0){
            $.ajax({
              method: "POST",
              url: '<?php echo base_url('booking/getPincodeByCity/') ?>'+city_id_val, 
              dataType:'json',
              beforeSend: function() { 
                   $("body").css({ opacity:0.5 });
                    $('#save-btn').attr('disabled','disabled'); 
              },
              complete: function(){
                 $("body").css({ opacity:1});
                 $('#save-btn').removeAttr('disabled'); 
              },
              success: function(response) {   
                  if(response){  
                    var selectedchanged_id = $('#selected_'+changed_id).val();
                    console.log(selectedchanged_id); 
                    if(selectedchanged_id > 0){
                        response.push(selectedchanged_id) 
                    }
                    response.forEach(function(val) { 
                      var selected =(selectedchanged_id == val) ? 'selected': '';
                        html += '<option value="'+val+'" '+selected+'>'+val +'</option>'
                    });
                  }
                  $('#'+changed_id).html(html);  
              }
            });
        }else{
            $('#'+changed_id).html(html);
        } 
    } 
  </script>

</body>

</html>