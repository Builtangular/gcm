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
            // print_r($material_details);
            ?>

            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <!-- Settings Info -->
                <div class="card">
                  <div class="card-body">
                    <div class="settings-form">
                      <?php echo form_open_multipart(base_url() . $currentController . '/' . $currentMethod . (($token > 0) ? '/' . $token : ''), ['name' => 'actionForm', 'id' => 'actionForm']); ?>
                      <div class="settings-sub-header">
                        <h6><?= isset($material_details) ? 'Edit' : 'Add' ?> Material</h6>
                      </div>
                      <div class="profile-details">
                        <div class="row g-3">

                          <div class="col-md-6">
                            <label class="col-form-label">Material Name <span class="text-danger">*</span></label>
                            <input type="text" required name="name" value="<?= isset($material_details) ?  $material_details['name'] : set_value('name') ?>" class="form-control">
                          </div>

                          <?php if (isset($material_details)) { ?>
                            <div class="col-md-2">
                              <div class="form-wrap">
                                <label class="col-form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" aria-label="Default select example">
                                  <option value="1" <?= isset($material_details) && $material_details['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                  <option value="0" <?= isset($material_details) && $material_details['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                </select>
                              </div>
                            </div>
                          <?php } ?>

                        </div>
                        <br>
                      </div>
                      <div class="submit-button">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="<?php echo base_url() . $currentController; ?>" class="btn btn-light">Back</a>
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


</body>

</html>