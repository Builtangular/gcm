<!DOCTYPE html>

<html lang="en">

<head>

  <?= $this->include('partials/title-meta') ?>

  <?= $this->include('partials/head-css') ?>


  <style>
    .image-container12 {

      display: inline-block;

      margin: 10px;

    }

    .img12 {

      cursor: pointer;

      width: 100px;

      height: 100px;

      border: 2px solid #ddd;

    }
  </style>

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

                      <form action="<?php echo base_url(); ?>vehiclet/edit" method="post">

                        <div class="settings-sub-header">

                          <h6>Edit Vehicle Model</h6>

                        </div>

                        <div class="profile-details">

                          <input type="hidden" name="id" value="<?php

                                                                if (isset($vehiclet_data)) {

                                                                  echo $vehiclet_data['id'];
                                                                }

                                                                ?>">

                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-wrap">

                                <label class="col-form-label">

                                  Vehicle Type <span class="text-danger">*</span>

                                </label>

                                <select class="form-control select" name="name" required>

                                  <option value="">Select</option>

                                  <?php

                                  if (isset($vehicletype_data)) {

                                    foreach ($vehicletype_data as $row) { ?>

                                      <option value="<?= $row['id'] ?>" <?= $row['id'] == $vehiclet_data['vehicle_type_id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>

                                  <?php  }
                                  }

                                  ?>

                                </select>

                                <?php

                                if ($validation->getError('name')) {

                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
                                }

                                ?>

                              </div>

                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Vehicle Manufacturer <span class="text-danger">*</span>
                                </label>

                                <select class="form-control select" name="mfg" required>
                                  <option value="">Select</option>
                                  <?php
                                  if (isset($vehicle_mfg)) {
                                    foreach ($vehicle_mfg as $mfg) { ?>
                                      <option value="<?= $mfg['id'] ?>" <?= $mfg['id'] == $vehiclet_data['mfg_id'] ? 'selected' : '' ?>><?= $mfg['name'] ?></option>
                                  <?php

                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-wrap">
                                <label class="col-form-label">
                                  Vehicle Body Type <span class="text-danger">*</span>
                                </label>

                                <select class="form-control select" name="body" required>
                                  <option value="">Select</option>
                                  <?php
                                  if (isset($vehicle_body)) {
                                    foreach ($vehicle_body as $body) { ?>
                                      <option value="<?= $body['id'] ?>" <?= $body['id'] == $vehiclet_data['body_type_id'] ? 'selected' : '' ?>><?= $body['name'] ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>



                            <div class="col-md-6">

                              <div class="form-wrap">

                                <label class="col-form-label">

                                  Model No. <span class="text-danger">*</span>

                                </label>



                                <input type="text" name="model_no" class="form-control" value="<?= $vehiclet_data['model_no']; ?>" pattern="[A-Za-z0-9 ]+" title="Only letters, numbers, and spaces are allowed." required>

                                <?php

                                if ($validation->getError('model_no')) {

                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('model_no') . '</div>';
                                }

                                ?>

                              </div>

                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Unladen Weight<span class="text-danger">*</span> </label>
                                <input type="text" name="unladen_wt" class="form-control" value="<?= $vehiclet_data['unladen_weight']; ?>">
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-wrap">
                                <label class="col-form-label">Laden Weight<span class="text-danger">*</span> </label>
                                <input type="text" name="laden_wt" class="form-control" value="<?= $vehiclet_data['laden_weight']; ?>">
                              </div>
                            </div>



                            <div class="col-md-6">

                              <div class="form-wrap">

                                <label class="col-form-label">

                                  Fuel Type <span class="text-danger">*</span>

                                </label>

                                <?php

                                if (isset($fueltype_data)) {

                                  foreach ($fueltype_data as $row1) {

                                ?>

                                    <input type="radio" id="<?= $row1['id'] ?>" name="fuel_type_id" value="<?= $row1['id'] ?>" <?= $vehiclet_data['fuel_type_id'] === $row1['id'] ? 'checked' : '' ?> required>

                                    <label for="<?= $row1['id'] ?>" style="padding-right: 15px;"><?= ucwords($row1['fuel_name']) ?></label>

                                <?php }
                                } ?>

                                <?php

                                if ($validation->getError('fuel_type_id')) {

                                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('fuel_type_id') . '</div>';
                                }

                                ?>

                              </div>

                            </div>



                          </div>

                        </div>

                        <div class="submit-button">

                          <input type="submit" name="add_fuel_type" class="btn btn-primary" value="Save Changes">

                          <a href="./<?= $vehiclet_data['id']; ?>" class="btn btn-warning">Reset</a>

                          <a href="<?php echo base_url(); ?>vehiclet" class="btn btn-light">Cancel</a>

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



  <?= $this->include('partials/vendor-scripts') ?>
  <script src="<?php echo base_url(); ?>public/assets/js/common.js"></script>


</body>



</html>