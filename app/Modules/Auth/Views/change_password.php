<?php
echo view('header');
echo view('sidebar');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Profile</h1>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<!-- <div class="row"> -->
				<!-- <div class="col-6"> -->
					<div class="card text-center">
						<div class="card-header">
							<h3 class="card-title">Change Password</h3>
						</div>
						<div class="card-body login-card-body">
							<div id="infoMessage">
								<?php
							/*	if (isset($message)) {
									echo $message;
								} else if (session()->getFlashdata('message') !== NULL) {
									echo session()->getFlashdata('message');
								}*/
								?>
							</div>
							<?php if (session()->getFlashdata('error_message') !== NULL) : ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo session()->getFlashdata('error_message'); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
							<?php endif; ?>
							<?php echo form_open('change-password',['class' => 'change_password_form','id' => 'change_password_form']); ?>

							<div class="mb-3">
								<?php
								$old_password = [
									'name' => 'old',
									'id'   => 'old',
									'class'  => 'form-control',
									'type'    => 'password',
									'placeholder' => sprintf(lang('Auth.change_password_old_password_label'), config('IonAuth')->minPasswordLength)
								];
								echo form_input($old_password);
								?>
							</div>

							<div class="mb-3">
								<?php
								$new_password = [
									'name' => 'new',
									'id'   => 'new',
									'class'  => 'form-control',
									'type'    => 'password',
									'pattern' => '^.{' . config('IonAuth')->minPasswordLength . '}.*$',
									'placeholder' => sprintf(lang('Auth.change_password_new_password_label'), config('IonAuth')->minPasswordLength)
								];
								echo form_input($new_password);
								?>
							</div>

							<div class="mb-3">
								<?php
								$new_password_confirm = [
									'name'    => 'new_confirm',
									'id'      => 'new_confirm',
									'class'  => 'form-control',
									'type'    => 'password',
									'pattern' => '^.{' . config('IonAuth')->minPasswordLength . '}.*$',
									'placeholder' => lang('Auth.reset_password_new_password_confirm_label')
								];
								echo form_input($new_password_confirm);
								?>
							</div>
							<div class="row">
								<div class="col-4">
									<?php
									echo form_submit('submit', lang('Auth.reset_password_submit_btn'), ['class' => 'btn btn-primary btn-block']);
									?>
								</div>
								<!-- /.col -->
							</div>


							<?php echo form_close(); ?>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				<!-- </div> -->
				<!-- /.col -->
			<!-- </div> -->
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- /.login-box -->
<?php echo view('scripts'); ?>
<script src="<?php echo base_url('assets/js/login/login.js'); ?>"></script>
<?php echo view('footer'); ?>