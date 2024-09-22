<?php echo view('Modules\Auth\Views\header'); ?>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="<?php echo base_url(); ?>"><?php echo config('AuditSurvey')->siteName; ?></a>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Reset your password here</p>
				<div id="infoMessage">
					<?php
					if (isset($message)) {
						echo $message;
					} else if (session()->getFlashdata('message') !== NULL) {
						echo session()->getFlashdata('message');
					}
					?>
				</div>
				<?php if (session()->getFlashdata('error_message') !== NULL) : ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?php echo session()->getFlashdata('error_message'); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				<?php endif; ?>
				<?php echo form_open('reset-password/' . $code,['class'=>'reset_password','id' => 'reset_password']); ?>

				<div class="mb-3">
					<?php
					$new_password = [
						'name'    => 'new',
						'id'      => 'new',
						'class'  => 'form-control',
						'type'    => 'password',
						'pattern' => '^.{' . config('IonAuth')->minPasswordLength . '}.*$',
						'placeholder' => sprintf(lang('Auth.reset_password_new_password_label'), $minPasswordLength)
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
					<div class="col-8">
						<a href="<?php echo base_url('login'); ?>">Login</a>
					</div>
					<!-- /.col -->
					<div class="col-4">
						<?php
						$user_id = [
							'name'  => 'user_id',
							'id'    => 'user_id',
							'type'  => 'hidden',
							'value' => $user->id,
						];
						echo form_input($user_id);
						echo form_submit('submit', lang('Auth.reset_password_submit_btn'), ['class' => 'btn btn-primary btn-block']);
						?>
					</div>
					<!-- /.col -->
				</div>


				<?php echo form_close(); ?>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->
	<?php echo view('Modules\Auth\Views\footer'); ?>