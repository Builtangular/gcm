<?php
use App\Models\PartyClassificationModel;
use App\Models\PartytypeModel;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('partials/title-meta') ?>
  <?= $this->include('partials/head-css') ?>
  <!-- Summernote CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/summernote/summernote-lite.min.css">
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

              <form method="post" action="<?php echo base_url() ?>party/searchByStatus" >
                      <!-- Search -->
                      <div class="search-section">
                        <div class="row">
                          <div class="col-md-2 col-sm-3">
                              <label class="col-form-label">
                                Search By Status
                              </label>
                          </div>
                          <div class="col-md-3 col-sm-3">
                              <div class="form-wrap">
                                    <select class="form-control" name="status">
                                    <option>Select</option>
                                      <option value="Active">Active</option>
                                      <option value="Inactive">Inactive</option>
                                    </select>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-3">
                            <input type="submit" value="Submit" class="btn btn-primary">
                          </div>
                        </div>
                      </div>
                  </form>
                <?php
                  $session = \Config\Services::session();
                  if($session->getFlashdata('success')) {
                      echo '
                      <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
                      ';
                  }
                  ?>
                <!-- Contact List -->
                <div class="table-responsive custom-table">
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th>Action</th>
                        <th>Customer Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Total Inv.</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($party_data)
                        {
                            foreach($party_data as $party)
                            {
                              $pcustomertype = new PartytypeModel();
                              $pcustomertype = $pcustomertype->where('id', $party['id'])->findAll();
                              

                              if($party['status'] == 'Inactive'){
                                $status= '<span class="badge badge-pill bg-danger">Inactive</span>';
                              }else{
                                $status ='<span class="badge badge-pill bg-success">Active</span>';
                              }

                              if($party['status'] == 'Active'){
                                $bun = '<a href="status/'.$party['id'].'" class="btn btn-danger btn-sm" role="button">Inactive</a>';
                              }else{
                                $bun = '<a href="status/'.$party['id'].'" class="btn btn-success btn-sm" role="button">Active</a>';
                              }
                                echo '
                                <tr>
                                    <td>
                                    '.$bun.'
                                    <a href="'.base_url().'party/edit/'.$party['id'].'"  class="btn btn-info btn-sm" role="button"><i class="ti ti-pencil"></i></a>

                                    <button type="button"   onclick="delete_data('.$party["id"].')" class="btn btn-secondary btn-sm"> <i class="ti ti-trash"></i></button>
                                    </td>
                                    
                                    <td>'.$party['party_name'].'</td>
                                    <td>'.$party['contact_person'].'</td>
                                    <td>'.$party['primary_phone'].'</td>
                                    <td>20</td>
                                    <td>'.$status.'</td>
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
  <!-- Summernote JS -->
  <script src="<?php echo base_url();?>assets/plugins/summernote/summernote-lite.min.js"></script>
  <script>
    function delete_data(id)
    {
        if(confirm("Are you sure you want to remove it?"))
        {
            window.location.href="<?php echo base_url(); ?>/party/delete/"+id;
        }
        return false;
    }
</script>
</body>

</html>