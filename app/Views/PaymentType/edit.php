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
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">

                                <div class="settings-sub-header">
                                    <h6>Update Payment Type</h6>
                                </div>
                                <?= $this->include('PaymentType/form.php') ?>
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
    <script>
    $(document).ready(function() {

        $.fields = function() {

            $('input.form-check-input[type="radio"]').removeAttr('required');

            $('input[name="fields[]"]:checked').each(function() {
                $('#field_' + $(this).val() + '_radio1').attr('required', 'required');
            })
        }
        $.fields();
    });
    </script>
</body>

</html>