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

            <div class="card main-card">
              <div class="card-body">

                <!-- Search -->
                <div class="search-section">
                  <div class="row">
                    <?php
                    $session = \Config\Services::session();

                    if ($session->getFlashdata('success')) {
                      echo '<div class="alert alert-success">' . $session->getFlashdata("success") . '</div>';
                    }

                    ?>
                    <div class="col-md-5 col-sm-4">
                      <div class="form-wrap icon-form">
                        <span class="form-icon"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search Deals">
                      </div>
                    </div>


                    <div class="col-md-7 text-end">
                      <?php echo makeListActions($currentController, $Action, 0, 1); ?>
                    </div>
                  </div>
                </div>
                <!-- /Search -->


                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table" id="vttable">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Vehicle Type Name</th>
                        <th>No. of Tyres</th>
                        <th>Added</th>
                        <th>Updated</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($vehicletype_data) {
                        foreach ($vehicletype_data as $row) {
                          if ($row['status'] == 0) {
                            $status = '<span class="badge badge-pill bg-danger">Inactive</span>';
                          } else {
                            $status = '<span class="badge badge-pill bg-success">Active</span>';
                          }
                          $created_at_str = '';
                          $updated_at_str = '';
                          if (isset($row["created_at"])) {
                            $created_at_str = strtotime($row["created_at"]);
                            $strtime = date('d M Y', $created_at_str);
                          }
                          if (isset($row["updated_at"]) && ($row["updated_at"] != '0000-00-00 00:00:00')) {
                            $updated_at_str = strtotime($row["updated_at"]);
                            $strtime1 = date('d M Y', $updated_at_str);
                          } else {
                            $strtime1 = '-';
                          }
                          echo '
                                <tr>
                                    <td>' . makeListActions($currentController, $Action, $row['id'], 2) . '</td>
                                    <td>' . ucwords($row["name"]) . '</td>
                                    <td>' . ucwords($row["number_of_tyres"]) . '</td>
                                    <td>' . $strtime . '</td>
                                    <td>' . $strtime1 . '</td>
                                    <td>' . $status . '</td>
                                </tr>';
                        }
                      }
                      ?>
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
                <!-- /Contact List -->

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
    function delete_data(id) {
      if (confirm("Are you sure you want to remove it?")) {
        window.location.href = "<?php echo base_url(); ?>/vehicletype/delete/" + id;
      }
      return false;
    }

    // datatable init
    if ($('#vttable').length > 0) {
      $('#vttable').DataTable({
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
        },
        columnDefs: [{ 
          target: 3,  
          render: DataTable.render.datetime( "DD MMM YYYY" )
        },
        { 
          target: 4,  
          render: DataTable.render.datetime( "DD MMM YYYY" )
        } 
        ]
      });
    }
  </script>
</body>

</html>