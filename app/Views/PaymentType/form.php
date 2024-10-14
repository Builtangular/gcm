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
				$action = 'payment_types/create';
			} else {
				$action = 'payment_types/edit';
			}
			$userPermissions = new UserTypePermissionModel();
			?>
            <form method="post" action="<?php echo base_url() . $action; ?>" enctype="multipart/form-data">
                <div class="profile-details">
                    <div class="row">
                        <input type="hidden" name="id" value="<?php
                                                  if (isset($paymenttypedata)) {
                                                    echo $paymenttypedata['id'];
                                                  }
                                                  ?>">
                        <div class="col-md-6">
                            <div class="form-wrap">
                                <label class="col-form-label">
                                    Payment Type <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="payment_type_name" class="form-control" pattern="[A-Za-z0-9 ]+"
                                    title="Only letters, numbers, and spaces are allowed." value="<?php
									if (isset($paymenttypedata)) {
										echo $paymenttypedata['name'];
									  } else {
										echo set_value('name');
									  }
									  ?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-wrap">
                                <table class="table table-borderless" style="width: 40%;">
                                    <thead>
                                        <tr>
                                            <td class="col-form-label">Fields</td>
                                            <td class="col-form-label">Mandatory</td>
                                            <td class="col-form-label">Non Mandatory</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
										if (isset($fields)) {
										foreach ($fields as $row) {
											// print_r($row);
											if (isset($paymenttypedata)) {
											$pField = $PaymentTypeFieldsModel->where(['field_id' => $row['id'], 'payment_type_id' => $paymenttypedata['id']])->first();
											}
										?>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox" name="fields[]"
                                                    id="field_<?php echo $row["id"]; ?>"
                                                    value="<?php echo $row["id"]; ?>"
                                                    <?= (isset($pField) && $pField['field_id'] == $row['id']) ? 'checked' : ''; ?>
                                                    style="height: 20px; width: 20px;" onclick="$.fields();"><label
                                                    for="field_<?php echo $row["id"]; ?>"
                                                    class="col-form-label">&nbsp;<?php echo ucwords($row["name"]); ?></label>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="radio"
                                                    name="radio_<?php echo $row["id"]; ?>"
                                                    id="field_<?php echo $row["id"]; ?>_radio1" value="1"
                                                    <?= (isset($pField) && $pField['mandatory'] == 1) ? 'checked' : ''; ?>
                                                    style="height: 20px; width: 20px;">
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="radio"
                                                    name="radio_<?php echo $row["id"]; ?>"
                                                    id="field_<?php echo $row["id"]; ?>_radio2" value="0"
                                                    <?= (isset($pField) && $pField['mandatory'] == 0) ? 'checked' : ''; ?>
                                                    style="height: 20px; width: 20px;">
                                            </td>
                                        </tr>
                                        <?php
										}
										}
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-button">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="<?php echo base_url(); ?>payment_types" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>