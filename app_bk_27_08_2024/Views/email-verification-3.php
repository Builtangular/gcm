<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->include('partials/title-meta') ?>
<?= $this->include('partials/head-css') ?>
</head>
<body class="account-page">
	
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<div class="account-content">
			<div class="login-wrapper login-new">
                <div class="login-shapes">
                    <div class="login-right-shape">
                        <img src="<?php echo base_url();?>assets/img/authentication/shape-01.png" alt="Shape">
                    </div>
                    <div class="login-left-shape">
                        <img src="<?php echo base_url();?>assets/img/authentication/shape-02.png" alt="Shape"> 
                    </div> 
                </div>
                <div class="container">
                    <div class="login-content user-login">
                        <div class="login-logo">
                           <img src="<?php echo base_url();?>assets/img/logo.svg" class="img-fluid" alt="Logo">
                       </div>
                        <form action="<?php echo base_url();?>deals-dashboard">
                            <div class="login-user-info login-user-inner">
                               <div class="login-heading text-center">
	                               <h4>Verify Your Email</h4>
	                               <p>We've sent a link to your email ter4@example.com. Please follow the link inside to continue</p>
	                           </div>
	                           <div class="login-form text-center">
	                               <h6>Didn't receive an email? <a href="javascript:void(0);" class="hover-a">Resend Link</a></h6>
	                           </div>
                               <div class="form-wrap mb-0">
                                   <button type="submit" class="btn btn-primary">Skip Now</button>
                               </div>
                           </div>
                        </form>
                    </div>
                    <div class="copyright-text">
                       <p>Copyright &copy;2024 - CRMS</p>
                   </div>
                </div>
            </div>
		</div>

	</div>
	<!-- /Main Wrapper -->



<?= $this->include('partials/vendor-scripts') ?>

</body>
</html>
