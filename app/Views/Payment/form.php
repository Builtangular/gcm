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
						$errors = $validation->getErrors();
						if($errors){
							foreach($errors as $error){
								echo '<div class="alert alert-danger mt-2">' . $error . '</div>';
							}
						}
						?>
                        <!-- Form Div -->
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <!-- Settings Info -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="settings-form">
                                            <?php echo form_open_multipart(base_url().$currentController.'/'.$currentMethod.(($token>0) ? '/'.$token : ''), ['name'=>'actionForm', 'id'=>'actionForm']);?>
                                            <div class="settings-sub-header">
                                                <h4>Raise Payment Request</h4>
                                            </div>
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="payment_for" checked id="inlineRadio1"
                                                                value="driver">
                                                            <label class="form-check-label"
                                                                for="inlineRadio1">Driver</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="payment_for" id="inlineRadio2" value="vendor">
                                                            <label class="form-check-label"
                                                                for="inlineRadio2">Vendor</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="col-form-label" style="padding-right: 10px;">
                                                            Payment Types<span class="text-danger">*</span>
                                                        </label>
                                                        <?php foreach($payment_types as $val){?>
                                                        <input type="radio" name="payment_type" id="payment_type_id"
                                                            onchange="displayDivs()" value="<?= $val['id'] ?>" required>
                                                        <label for="<?= $val['name'] ?>"
                                                            style="padding-right:15px"><?= $val['name'] ?></label>
                                                        <?php } ?>
                                                        <?php
														if ($validation->getError('payment_type_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('payment_type_id') . '</div>';
														}
														?>
                                                    </div>
                                                    <div class="col-md-6 driver_div">
                                                        <label class="col-form-label">
                                                            Driver<span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2" id="driver_id"
                                                            name="driver_id" required
                                                            onchange="getDriverVehicles();getDriverBookings();">
                                                            <option value="">Select Driver</option>
                                                            <?php foreach($drivers as $val){?>
                                                            <option value="<?= $val['id'] ?>">
                                                                <?= $val['driver_name'].' - '.$val['rc_number'] ?>
                                                            </option>
                                                            <?php }?>
                                                        </select>
                                                        <?php
														if ($validation->getError('driver_id')) {
															echo '<div class="alert alert-danger mt-2">' . $validation->getError('driver_id') . '</div>';
														}
														?>
                                                    </div>
                                                    <div class="col-md-6 driver_div booking_div">
                                                        <label class="col-form-label">Booking No.</label>
                                                        <select class="form-control select2" id="booking_no"
                                                            name="booking_no">
                                                            <option value="">Select Booking</option>
                                                        </select>
                                                    </div>
                                                    <div id="field_name"></div>

                                                    <!-- Purpose Of Update for Money -->
                                                    <div class="col-md-6 purpose_of_updates" hidden>
                                                        <div class="form-wrap">
                                                            <label class="col-form-label">
                                                                Purpose Of Update
                                                            </label>
                                                            <select class="form-class select2" id="purpose_update_id"
                                                                name="purpose_update">
                                                                <option value="">Select Purpose</option>
                                                                <?php foreach($purpose_update as $val){?>
                                                                <option value="<?= $val['id'] ?>"><?= $val['name'] ?>
                                                                </option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- ./ Purpose Of Update for Money -->
                                                    <!-- Authorized Employee: -->
                                                    <div class="col-md-6 employee_selection">
                                                        <div class="form-wrap">
                                                            <label class="col-form-label">
                                                                Authorized Employee<span
                                                                    class="text-danger employee_selection">*</span>
                                                            </label>
                                                            <select class="form-class select2"
                                                                id="authorized_employee_id" name="authorized_employee"
                                                                required onchange="getEscalationEmployees();">
                                                                <option value="">Select Authorized Employee</option>
                                                                <?php foreach($authorized_employee as $val){?>
                                                                <option value="<?= $val['id'] ?>"><?= $val['name'] ?>
                                                                </option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 employee_selection">
                                                        <div class="form-wrap">
                                                            <label class="col-form-label">
                                                                Escalation Employee<span
                                                                    class="text-danger employee_selection">*</span>
                                                            </label>
                                                            <select class="form-class select2"
                                                                id="escalation_employee_id"
                                                                name="escalation_employee" required>
                                                                <option value="">Select Escalation Employee</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- ./ Authorized Employee: -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="submit-button">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                            <input type="reset" name="reset" class="btn btn-warning" value="Reset">
                                            <a href="<?php echo base_url().$currentController; ?>"
                                                class="btn btn-light">Cancel</a>
                                        </div>
                                    </div> <!-- ./ Card Body -->
                                </div> <!-- ./ Card -->
                            </div> <!-- Settings Info -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

    <?= $this->include('partials/vendor-scripts') ?>
    <script>
    function displayDivs() {
        var payment_type_id = $("input[name='payment_type']:checked").val();
        var html = '<div class="col-md-6 driver_div">';
        // alert('payment_type_id '+payment_type_id); 
        $('#field_name').html(html);
        if (payment_type_id > 0) {
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('payments/getPaymentTypeFields') ?>',
                data: {
                    payment_type_id: payment_type_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        response.forEach(function(val) {
                            var lowerCaseResponse = val.name.toLowerCase();
                            html += '<div class="form-wrap"><label class="col-form-label">' + val
                                .name + ''
                            if (val.mandatory == 1) {
                                html += '<span class="text-danger">*</span>'
                            }
                            html += '</label>'
                            if (val.mandatory == 1) {
                                if (lowerCaseResponse == "vehicle") {
                                    html += '<input type="text" name="' + lowerCaseResponse +
                                        '" id="' +
                                        lowerCaseResponse +
                                        '" class="form-control" value="" readonly required>'
                                } else if (val.name == "Quantity") {
                                    html += '<input type="number" name="' + lowerCaseResponse +
                                        '" id="' +
                                        lowerCaseResponse +
                                        '" class="form-control" value="" required>'
                                } else {
                                    html += '<input type="text" name="' + lowerCaseResponse +
                                        '" id="' +
                                        lowerCaseResponse +
                                        '" class="form-control" value="" required>'
                                }
                            } else {
                                html += '<input type="text" name="' + lowerCaseResponse + '" id="' +
                                    lowerCaseResponse + '" class="form-control">'
                            }
                            html += '</div>'
                        });
                        html += '</div>'
                        $('#field_name').html(html);
                    }
                }
            });
            if (payment_type_id == 3) {
                $('.purpose_of_updates').removeAttr('hidden');
                $('.purpose_of_updates').attr('required', 'required');
            } else {
                $('.purpose_of_updates').attr('hidden', 'hidden');
            }
        }
    }

    function getDriverVehicles() {
        var driver_id = $('#driver_id').val();
        if (driver_id > 0) {
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('payments/getDriverVehicles') ?>',
                data: {
                    driver_id: driver_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        response.forEach(function(val) {
                            $('#vehicle').val(val.rc_number)
                        });
                    }
                }
            });
        }

    }

    function getDriverBookings() {
        var driver_id = $('#driver_id').val();
        var html = '<option value="0">Select Booking No.</option>';
        $('#booking_no').html(html);
        if (driver_id > 0) {
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('payments/getDriverBookings') ?>',
                data: {
                    driver_id: driver_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        response.forEach(function(val) {
                            html += '<option value="' + val.id + '">' + val.booking_number +
                                '</option>'
                        });
                        $('#booking_no').html(html);
                    }
                }
            });
        }
    }

    function getEscalationEmployees() {
        var auth_emp_id = $('#authorized_employee_id').val();
        // alert('authorized_employee_id = '+auth_emp_id);
        var html = '<option value="">Select Escalation Employees</option>';
        $('#escalation_employee_id').html(html);
        if (auth_emp_id > 0) {
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('payments/getEscalationEmployees') ?>',
                data: {
                    auth_emp_id: auth_emp_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        response.forEach(function(val) {
                            html += '<option value="' + val.id + '">' + val.name +
                                '</option>'
                        });
                        $('#escalation_employee_id').html(html);
                    }
                }
            });
        }
    }
    /* function getSameTypesVehicles() {
        var vehicle_id = $('#vehicle_id').val();
        var html = '<option value="0">Select Vehicle</option>';
        $('#transfer_from_vehicle_id').html(html);
        if (vehicle_id > 0) {
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('payments/getSameTypesVehicles') ?>',
                data: {
                    vehicle_id: vehicle_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        response.forEach(function(val) {
                            html += '<option value="' + val.id + '">' + val.rc_number + '</option>'
                        });
                        $('#transfer_from_vehicle_id').html(html);
                    }
                }
            });
        }
    } */

    $("input[name='payment_for']").click(function() {
        var payment_for = $('input[name="payment_for"]:checked').val();
        if (payment_for == 'vendor') {
            $('input[name="payment_type"]:eq(2)').prop('checked', true);
        }
    });
    </script>
</body>

</html>