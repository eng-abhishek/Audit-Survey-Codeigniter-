<html>
<body>
	<h1><?=sprintf('Profile has been created')?></h1>
	<p>
		<?=sprintf(lang('IonAuth.emailForgotPassword_subheading'), anchor('signup-password/' . $signup_password_code, ' login into account'))?>
	</p>
</body>
</html>
