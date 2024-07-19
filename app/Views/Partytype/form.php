<?php $validation = \Config\Services::validation();

use App\Models\UserTypePermissionModel;
?>
<!-- Settings Info -->
<div class="card">
  <div class="card-body">
    <div class="settings-form">
      <?php
      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      $last = array_pop($uriSegments);
      if ($last == 'create') {
        $action = 'partytype/create';
      } else {
        $action = 'partytype/edit';
      }
      $userPermissions = new UserTypePermissionModel();
      ?>
      <form method="post" action="<?php echo base_url() . $action; ?>" enctype="multipart/form-data">
        <div class="profile-details">
          <div class="row">
            <input type="hidden" name="id" value="<?php
                                                  if (isset($partytype_data)) {
                                                    echo $partytype_data['id'];
                                                  }
                                                  ?>">
            <div class="col-md-6">
              <div class="form-wrap">
                <label class="col-form-label">
                  Party Type Name <span class="text-danger">*</span>
                </label>
                <input type="text" required name="name" class="form-control" value="<?php
                                                                                    if (isset($partytype_data)) {
                                                                                      echo $partytype_data['name'];
                                                                                    } else {
                                                                                      echo set_value('name');
                                                                                    }
                                                                                    ?>">
                <?php
                if ($validation->getError('name')) {
                  echo '<div class="alert alert-danger mt-2">' . $validation->getError('name') . '</div>';
                }
                ?>
              </div>
            </div>

            <div class="col-md-6">
              <label class="col-form-label mt-2"> Sale <span class="text-danger">*</span> </label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sale" required <?= isset($partytype_data) && $partytype_data['sale'] == '1' ? 'checked' : '' ?> id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sale" required <?= isset($partytype_data) && $partytype_data['sale'] == '0' ? 'checked' : '' ?> id="inlineRadio2" value="0">
                <label class="form-check-label" for="inlineRadio2">No</label>
              </div>
            </div>


          </div>
        </div>
        <div class="submit-button">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="<?php echo base_url(); ?>partytype" class="btn btn-light">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /Settings Info -->