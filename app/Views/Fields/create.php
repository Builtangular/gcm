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

                      <?php echo form_open_multipart(base_url() . $currentController . '/' . $currentMethod . (($token > 0) ? '/' . $token : ''), ['name' => 'actionForm', 'id' => 'actionForm']); ?>

                      <div class="settings-sub-header">
                        <h6>Add Field</h6>
                      </div>
                      <div class="profile-details">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-wrap">
                              <label class="col-form-label">
                                Field Name <span class="text-danger">*</span>
                              </label>

                              <input type="text" name="name" class="form-control" value="<?= set_value('name') ?>" required>
                              <?php
                              if ($validation->getError('name')) {
                                echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
                              }
                              ?>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="submit-button">
                        <input type="submit" name="add_profile" class="btn btn-primary" value="Save Changes">
                        <button type="button" class="btn btn-warning" onclick="window.location.reload();">Reset</button>
                        <a href="<?php echo base_url(); ?>fields" class="btn btn-light">Cancel</a>
                      </div>

                      <?php echo form_close() ?>
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
  <!-- Profile Upload JS -->
  <script src="<?php echo base_url(); ?>assets/js/profile-upload.js"></script>

  <!-- Sticky Sidebar JS -->
  <script src="<?php echo base_url(); ?>assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
</body>

</html>