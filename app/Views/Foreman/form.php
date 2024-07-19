<?php $validation = \Config\Services::validation();

use App\Models\UserTypePermissionModel;
use App\Models\PartyModel;
?>
<!-- Settings Info -->
<div class="card">
  <div class="card-body">
    <div class="settings-form">
      <?php
      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      $last = array_pop($uriSegments);
      if ($last == 'create') {
        $action = 'foreman/create';
      } else {
        $action = 'foreman/edit';
      }

      $userPermissions = new UserTypePermissionModel();
      ?>
      <form method="post" action="<?php echo base_url() . $action; ?>" enctype="multipart/form-data">

        <div class="profile-details">
          <div class="row">
            <input type="hidden" name="id" id="foreman_id" value="<?php
                                                                  if (isset($foreman_data)) {
                                                                    echo $foreman_data['id'];
                                                                  }
                                                                  ?>">
            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">
                  Foreman Name <span class="text-danger">*</span>
                </label>

                <select class="dropdown selectopt" name="name" id="party_id" <?= isset($foreman_data) && $foreman_data['name'] != '' ? 'style="pointer-events: none;"' : '' ?>>
                  <option>Select</option>
                  <?php
                  foreach ($parties as $party) {
                  ?>
                    <option value="<?php echo $party['id']; ?>" <?= isset($foreman_data) && $foreman_data['name'] == $party['id'] ? 'selected' : '' ?>><?php echo ucwords($party['party_name']); ?></option>
                  <?php
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
            <div class="target" id="target">
            </div>

            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">
                  Bank A/C No:
                </label>
                <input type="text" name="bank_account_number" class="form-control" value="<?php
                                                                                          if (isset($foreman_data)) {
                                                                                            echo $foreman_data['bank_account_number'];
                                                                                          } else {
                                                                                            echo set_value('bank_account_number');
                                                                                          }
                                                                                          ?>">
                <?php
                if ($validation->getError('bank_account_number')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('bank_account_number') . '</div>';
                }
                ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">
                  Bank IFSC:
                </label>
                <input type="text" name="bank_ifsc_code" class="form-control" value="<?php
                                                                                      if (isset($foreman_data)) {
                                                                                        echo $foreman_data['bank_ifsc_code'];
                                                                                      } else {
                                                                                        echo set_value('bank_ifsc_code');
                                                                                      }
                                                                                      ?>">
                <?php
                if ($validation->getError('bank_ifsc_code')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('bank_ifsc_code') . '</div>';
                }
                ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">Driving Licence Number</label>
                <input type="text" name="dl_no" class="form-control" value="<?php
                                                                            if (isset($foreman_data)) {
                                                                              echo $foreman_data['dl_no'];
                                                                            } else {
                                                                              echo set_value('dl_no');
                                                                            }
                                                                            ?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">Driving Licence Issue Auth.</label>
                <input type="text" name="dl_authority" value="<?= isset($foreman_data) ? $foreman_data['dl_authority'] : '' ?>" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">Driving Licence Expiry Date</label>
                <input type="date" name="dl_expiry" value="<?= isset($foreman_data) ? $foreman_data['dl_expiry'] : '' ?>" min="<?= date('Y-m-d') ?>" class="form-control">
              </div>
            </div>


            <div class="col-md-3">
              <div class="form-wrap">
                <label class="col-form-label">
                  DL Image - Front
                </label>
                <?php if (isset($foreman_data) && $foreman_data['dl_image_front'] != '') { ?>
                  <img src="<?= base_url('public/uploads/foremanDocs/') . $foreman_data['dl_image_front'] ?>" style="height: 150px;">
                <?php } ?>
                <input type="file" name="dl_image_front" class="form-control">
                <?php
                if ($validation->getError('dl_image_front')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('dl_image_front') . '</div>';
                }
                ?>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-wrap">
                <label class="col-form-label">
                  DL Image - Back
                </label>
                <?php if (isset($foreman_data) && $foreman_data['dl_image_back'] != '') { ?>
                  <img src="<?= base_url('public/uploads/foremanDocs/') . $foreman_data['dl_image_back'] ?>" style="height: 150px;">
                <?php } ?>
                <input type="file" name="dl_image_back" class="form-control">
                <?php
                if ($validation->getError('dl_image_back')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('dl_image_back') . '</div>';
                }
                ?>
              </div>
            </div>


            <div class="col-md-3">
              <div class="form-wrap">
                <label class="col-form-label">
                  Profile Image 1
                </label>
                <?php if (isset($foreman_data) && $foreman_data['profile_image1'] != '') { ?>
                  <img src="<?= base_url('public/uploads/foremanDocs/') . $foreman_data['profile_image1'] ?>" style="height: 150px;">
                <?php } ?>
                <input type="file" name="profile_image1" class="form-control">
                <?php if (isset($foreman_data)) { ?>

                <?php }
                if ($validation->getError('profile_image1')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('profile_image1') . '</div>';
                }
                ?>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-wrap">
                <label class="col-form-label">
                  Profile Image 2
                </label>
                <?php if (isset($foreman_data) && $foreman_data['profile_image2'] != '') { ?>
                  <img src="<?= base_url('public/uploads/foremanDocs/') . $foreman_data['profile_image2'] ?>" style="height: 150px;">
                <?php } ?>
                <?php
                if ($validation->getError('profile_image2')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('profile_image2') . '</div>';
                }
                ?>
                <input type="file" name="profile_image2" class="form-control">
                <?php if (isset($foreman_data)) { ?>

                <?php } ?>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-wrap">
                <label class="col-form-label">UPI ID</label>
                <input type="text" name="upi" value="<?= isset($foreman_data) ? $foreman_data['upi_text'] : '' ?>" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-wrap">
                <label class="col-form-label">
                  UPI ID Image
                </label>
                <?php if (isset($foreman_data) &&  $foreman_data['upi_id'] != '') { ?>
                  <img src="<?= base_url('public/uploads/foremanDocs/') . $foreman_data['upi_id'] ?>" style="height: 150px;">
                <?php } ?>
                <input type="file" name="upi_id" class="form-control">
                <?php
                if ($validation->getError('upi_id')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('upi_id') . '</div>';
                } ?>
              </div>
            </div>

          </div>
        </div>

        <div class="submit-button">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="<?php echo base_url(); ?>foreman" class="btn btn-light">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /Settings Info -->