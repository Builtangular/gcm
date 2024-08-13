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

            <!-- Page Header -->
            <div class="page-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="page-title">Bookings</h4>
                </div>
                <div class="col-4 text-end">
                  <div class="head-icons">
                    <a href="<?= base_url('booking') ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Page Header -->

            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('booking'); ?>">
              <div class="card main-card">
                <div class="card-body">
                  <h4>Search / Filter</h4>
                  <hr>
                  <div class="row">

                    <div class="col-md-3">
                      <div class="form-wrap">
                        <label class="col-form-label">Status</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                          <option value="">Select Status</option>
                          <?php foreach ($statuses as $s) { ?>
                            <option value="<?= $s['id'] ?>"><?= ucwords($s['status_name']) ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <button class="btn btn-info mt-4">Search</button>&nbsp;&nbsp;
                      <a href="./booking" class="btn btn-warning mt-4">Reset</a>&nbsp;&nbsp;
                    </div>

                    <div class="col-md-3 text-end mt-3">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>
                  </div>
                </div>
              </div>
            </form>


            <div class="card main-card">
              <div class="card-body">

                <div class="row mb-3">
                  <div class="col-md-12 col-sm-12">
                    <?php
                    $session = \Config\Services::session();

                    if ($session->getFlashdata('success')) {
                      echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                    }

                    if ($session->getFlashdata('danger')) {
                      echo '<div class="alert alert-danger">' . $session->getFlashdata("danger") . '</div>';
                    }
                    ?>
                  </div>

                </div>
                <!-- /Search -->

                <!-- Product Type List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="ProductCategory">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Booking Id</th>
                        <th>Customer Name</th>
                        <th>Vehicle RC</th>
                        <th>Booking Date</th>
                        <th>From City</th>
                        <th>Drop City</th>
                        <th>Status</th>
                        <th>Loading Receipt</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      foreach ($bookings as $b) {

                        $from = $pickup->where('booking_id', $b['id'])->first();
                        $to = $drop->where('booking_id', $b['id'])->first();

                      ?>
                        <tr>
                          <td><?= $i++; ?>.</td>
                          <!-- <td>
                            <div class="btn-group dropend my-1">
                              <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <?php if (!$b['approved']) { ?>
                                  <li><a href="<?= base_url('booking/approve/' . $b['id']) ?>" class="dropdown-item btn btn-light btn-sm" role="button"><i class="ti ti-pencil"></i> Approve</a></li>
                                <?php }
                                if ($b['vehicle_id'] == '0') { ?>
                                  <li><a href="<?= base_url('booking/asign_vehicle/' . $b['id']) ?>" class="dropdown-item btn btn-light btn-sm" role="button"><i class="fa fa-car" aria-hidden="true"></i> Assign Vehicle</a></li>
                                <?php } ?>
                              </ul>
                            </div>

                          </td> -->
                          <td><?= makeListActions($currentController, $Action, $b['id'], 2, false, $b) ?></td>
                          <td><?= $b['booking_number'] ?></td>
                          <td><?= $b['party_name'] ?></td>
                          <td><?= $b['rc_number'] != '' ? $b['rc_number'] : '<span class="text-danger">Not Assigned</span>' ?></td>
                          <td><?= date('d M Y', strtotime($b['booking_date'])) ?></td>
                          <td><?= isset($from['city']) ? $from['city'] : '' ?></td>
                          <td><?= isset($to['city']) ? $to['city'] : '' ?></td>
                          <td><span class="badge badge-pill <?= $b['status_bg'] ?>"><?= $b['status_name'] ?></span></td>
                          <?php 
                              $status = 'Not Generated';$lr_flag = 0;
                              if(isset($b['lr_Status']) && ($b['lr_Status'] >0) ){
                                $status = 'Generated';
                                $lr_flag = 1;
                              }
                              if(isset($b['lr_approved']) && ($b['lr_approved'] >0) ){
                                $status = 'Approved';
                                $lr_flag = 1;
                              }
                              if(isset($b['lr_Status']) && ($b['lr_Status'] ==2) ){
                                $status = 'Cancelled';
                                $lr_flag = 0;
                              }
                            ?>
                          <td><span class="badge badge-pill <?= ($lr_flag >0 ? 'bg-success' : 'bg-danger') ?>">                            
                             <?= $status ?></span>
                          </td>        
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <div class="datatable-length"></div>
                  </div>
                  <div class="col-md-6">
                    <div class="datatable-paginate"></div>
                  </div>
                </div>
                <!-- /Product Type List -->

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
    <!-- /Page Wrapper -->


  </div>
  <!-- /Main Wrapper -->

  <!-- scripts link  -->
  <?= $this->include('partials/vendor-scripts') ?>

  <!-- page specific scripts  -->
  <script>
    function delete_data(id) {
      if (confirm("Are you sure you want to remove this product category ?")) {
        window.location.href = "<?php echo base_url('product-categories-delete/'); ?>" + id;
      }
      return false;
    }


    // datatable init
    if ($(' #ProductCategory').length > 0) {
      $('#ProductCategory').DataTable({
        "bFilter": false,
        "bInfo": false,
        "autoWidth": true,
        "language": {
          search: ' ',
          sLengthMenu: '_MENU_',
          searchPlaceholder: "Search",
          info: "_START_ - _END_ of _TOTAL_ items",
          "lengthMenu": "Show _MENU_ entries",
          paginate: {
            next: 'Next <i class=" fa fa-angle-right"></i> ',
            previous: '<i class="fa fa-angle-left"></i> Prev '
          },
        },
        initComplete: (settings, json) => {
          $('.dataTables_paginate').appendTo('.datatable-paginate');
          $('.dataTables_length').appendTo('.datatable-length');
        }
      });
    }
  </script>
</body>

</html>