<?php

namespace Modules\Auth\Controllers;

use App\Controllers\BaseController;
use Modules\User\Models\UserModel;
use Modules\User\Models\GroupModel;

class Auth extends BaseController
{
	/**
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * Configuration
	 *
	 * @var \IonAuth\Config\IonAuth
	 */
	protected $configIonAuth;

	/**
	 * IonAuth library
	 *
	 * @var \IonAuth\Libraries\IonAuth
	 */
	protected $ionAuth;

	/**
	 * Session
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Validation library
	 *
	 * @var \CodeIgniter\Validation\Validation
	 */
	protected $validation;

	/**
	 * Validation list template.
	 *
	 * @var string
	 * @see https://bcit-ci.github.io/CodeIgniter4/libraries/validation.html#configuration
	 */
	protected $validationListTemplate = 'list';

	/**
	 * Views folder
	 * Set it to 'auth' if your views files are in the standard application/Views/auth
	 *
	 * @var string
	 */
	protected $viewsFolder = 'Modules\Auth\Views';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		if (!empty($this->configIonAuth->templates['errors']['list'])) {
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}
		$this->userModel = new UserModel();
		$this->groupModel = new GroupModel();
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function index()
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		} else {
			return redirect()->to('/users');

			$this->data['title'] = lang('Auth.index_heading');

			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');
			//list the users
			$this->data['users'] = $this->ionAuth->users()->result();
			foreach ($this->data['users'] as $k => $user) {
				$this->data['users'][$k]->groups = $this->ionAuth->getUsersGroups($user->id)->getResult();
			}
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'index', $this->data);
		}
	}

	/**
	 * Log the user in
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function login()
	{
		if ($this->ionAuth->loggedIn()) {
			return redirect()->to('/users');
		}

		$this->data['title'] = lang('Auth.login_heading');
		$this->data['message'] = '';
		if ($this->request->getPost()) {
			// validate form input
			$this->validation->setRule('identity', str_replace(':', '', lang('Auth.login_identity_label')), 'required');
			$this->validation->setRule('password', str_replace(':', '', lang('Auth.login_password_label')), 'required');
			if ($this->validation->withRequest($this->request)->run()) {

				if ($this->ionAuth->login($this->request->getVar('identity'), $this->request->getVar('password'))) {
					//if the login is successful
					//redirect them back to the home page
					//$this->session->setFlashdata('success_message', $this->ionAuth->messages());

					$staff_users = array('3','5');
					$oac_users = array('7');

					if(in_array($this->ionAuth->user()->row()->group_id,$staff_users))
					{
						return redirect()->to('/bus-routes')->withCookies();			
					}
					else if(in_array($this->ionAuth->user()->row()->group_id,$oac_users))
					{
						return redirect()->to('/users/dashboard')->withCookies();
					}
					else
					{
						return redirect()->to('/users')->withCookies();
					}
				} else {
					// if the login was un-successful
					// redirect them back to the login page
					$this->session->setFlashdata('error_message', $this->ionAuth->errors($this->validationListTemplate));
					// use redirects instead of loading views for compatibility with MY_Controller libraries
					return redirect()->back()->withInput();
				}
			} else {
				$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');
			}
		}

		return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'login', $this->data);
	}

	/**
	 * Log the user out
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function logout()
	{
		$this->data['title'] = 'Logout';

		// log the user out
		$this->ionAuth->logout();

		// redirect them to the login page
		//$this->session->setFlashdata('message', $this->ionAuth->messages());
		return redirect()->to('/login')->withCookies();
	}

	/**
	 * Change password
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function change_password()
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		$this->validation->setRule('old', lang('Auth.change_password_validation_old_password_label'), 'required');
		$this->validation->setRule('new', lang('Auth.change_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
		$this->validation->setRule('new_confirm', lang('Auth.change_password_validation_new_password_confirm_label'), 'required');

		$user = $this->data['user'] = $this->ionAuth->user()->row();

		if (!$this->request->getPost() || $this->validation->withRequest($this->request)->run() === false) {
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = ($this->validation->getErrors()) ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

			// render
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'change_password', $this->data);
		} else {
			$identity = $this->session->get('identity');

			$change = $this->ionAuth->changePassword($identity, $this->request->getPost('old'), $this->request->getPost('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return $this->logout();
			} else {
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/change-password');
			}
		}
	}

	/**
	 * Forgot password
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function forgot_password()
	{
		$this->data['title'] = lang('Auth.forgot_password_heading');

		// setting validation rules by checking whether identity is username or email
		if ($this->configIonAuth->identity !== 'email') {
			$this->validation->setRule('identity', lang('Auth.forgot_password_identity_label'), 'required');
		} else {
			$this->validation->setRule('identity', lang('Auth.forgot_password_validation_email_label'), 'required|valid_email');
		}

		if (!($this->request->getPost() && $this->validation->withRequest($this->request)->run())) {
			$this->data['type'] = $this->configIonAuth->identity;

			if ($this->configIonAuth->identity !== 'email') {
				$this->data['identity_label'] = lang('Auth.forgot_password_identity_label');
			} else {
				$this->data['identity_label'] = lang('Auth.forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'forgot-password', $this->data);
		} else {
			$identityColumn = $this->configIonAuth->identity;
			$identity = $this->ionAuth->where($identityColumn, $this->request->getPost('identity'))->users()->row();

			if (empty($identity)) {
				if ($this->configIonAuth->identity !== 'email') {
					$this->ionAuth->setError('Auth.forgot_password_identity_not_found');
				} else {
					$this->ionAuth->setError('Auth.forgot_password_email_not_found');
				}

				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				// return redirect()->to('/forgot-password');
				return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'forgot-password', $this->data);
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ionAuth->forgottenPassword($identity->{$this->configIonAuth->identity});

			if ($forgotten) {
				// if there were no errors
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/login'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/forgot_password');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function reset_password($code = null)
	{
		if (!$code) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$this->data['title'] = lang('Auth.reset_password_heading');

		$user = $this->data['user'] = $this->ionAuth->forgottenPasswordCheck($code);
		if ($user) {
			// if the code is valid then display the password reset form

			$this->validation->setRule('new', lang('Auth.reset_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
			$this->validation->setRule('new_confirm', lang('Auth.reset_password_validation_new_password_confirm_label'), 'required');

			if (!$this->request->getPost() || $this->validation->withRequest($this->request)->run() === false) {
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

				$this->data['minPasswordLength'] = $this->configIonAuth->minPasswordLength;
				$this->data['code'] = $code;

				// render
				return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
			} else {
				$identity = $user->{$this->configIonAuth->identity};

				// do we have a valid request?
				if ($user->id != $this->request->getPost('user_id')) {
					// something fishy might be up
					$this->ionAuth->clearForgottenPasswordCode($identity);

					throw new \Exception(lang('Auth.error_security'));
				} else {
					// finally change the password
					$change = $this->ionAuth->resetPassword($identity, $this->request->getPost('new'));

					if ($change) {
						// if the password was successfully changed
						$this->session->setFlashdata('message', $this->ionAuth->messages());
						return redirect()->to('/login');
					} else {
						$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
						return redirect()->to('/reset-password/' . $code);
					}
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
			return redirect()->to('/forgot-password');
		}
	}


	/**
	 * signup password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function signup_password($code = null)
	{
		if (!$code) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$this->data['title'] = lang('Auth.reset_password_heading');

		$user = $this->data['user'] = $this->ionAuth->signupPasswordCheck($code);
		
		if ($user) {
			// if the code is valid then display the password reset form

			$this->validation->setRule('new', lang('Auth.reset_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
			$this->validation->setRule('new_confirm', lang('Auth.reset_password_validation_new_password_confirm_label'), 'required');

			if (!$this->request->getPost() || $this->validation->withRequest($this->request)->run() === false) {
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

				$this->data['minPasswordLength'] = $this->configIonAuth->minPasswordLength;
				$this->data['code'] = $code;

				// render
				return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'signup_password', $this->data);
			} else {
				$identity = $user->{$this->configIonAuth->identity};

				// do we have a valid request?
				if ($user->id != $this->request->getPost('user_id')) {
					// something fishy might be up
					$this->ionAuth->clearForgottenPasswordCode($identity);

					throw new \Exception(lang('Auth.error_security'));
				} else {
					// finally change the password
					$change = $this->ionAuth->resetPassword($identity, $this->request->getPost('new'));

					if ($change) {
						// if the password was successfully changed
						$this->session->setFlashdata('message', $this->ionAuth->messages());
						return redirect()->to('/login');
					} else {
						$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
						return redirect()->to('/reset-password/' . $code);
					}
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
			return redirect()->to('/forgot-password');
		}
	}


	/**
	 * Activate the user
	 *
	 * @param integer $id   The user ID
	 * @param string  $code The activation code
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function activate(int $id, string $code = ''): \CodeIgniter\HTTP\RedirectResponse
	{
		$activation = false;

		if ($code) {
			$activation = $this->ionAuth->activate($id, $code);
		} else if ($this->ionAuth->isAdmin()) {
			$activation = $this->ionAuth->activate($id);
		}

		if ($activation) {
			// redirect them to the auth page
			$this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth');
		} else {
			// redirect them to the forgot password page
			$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
			return redirect()->to('/forgot_password');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param integer $id The user ID
	 *
	 * @throw Exception
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function deactivate(int $id = 0)
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			// redirect them to the home page because they must be an administrator to view this
			throw new \Exception('You must be an administrator to view this page.');
			// TODO : I think it could be nice to have a dedicated exception like '\IonAuth\Exception\NotAllowed
		}

		$this->validation->setRule('confirm', lang('Auth.deactivate_validation_confirm_label'), 'required');
		$this->validation->setRule('id', lang('Auth.deactivate_validation_user_id_label'), 'required|integer');

		if (!$this->validation->withRequest($this->request)->run()) {
			$this->data['user'] = $this->ionAuth->user($id)->row();
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
		} else {
			// do we really want to deactivate?
			if ($this->request->getPost('confirm') === 'yes') {
				// do we have a valid request?
				if ($id !== $this->request->getPost('id', FILTER_VALIDATE_INT)) {
					throw new \Exception(lang('Auth.error_security'));
				}

				// do we have the right userlevel?
				if ($this->ionAuth->loggedIn() && $this->ionAuth->isAdmin()) {
					$message = $this->ionAuth->deactivate($id) ? $this->ionAuth->messages() : $this->ionAuth->errors($this->validationListTemplate);
					$this->session->setFlashdata('message', $message);
				}
			}

			// redirect them back to the auth page
			return redirect()->to('/auth');
		}
	}

	/**
	 * Create a new user
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function create_user()
	{
		$this->data['title'] = lang('Auth.create_user_heading');

		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/auth');
		}

		$tables                        = $this->configIonAuth->tables;
		$identityColumn                = $this->configIonAuth->identity;
		$this->data['identity_column'] = $identityColumn;

		// validate form input
		$this->validation->setRule('first_name', lang('Auth.create_user_validation_fname_label'), 'trim|required');
		$this->validation->setRule('last_name', lang('Auth.create_user_validation_lname_label'), 'trim|required');
		if ($identityColumn !== 'email') {
			$this->validation->setRule('identity', lang('Auth.create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identityColumn . ']');
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email');
		} else {
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->validation->setRule('phone', lang('Auth.create_user_validation_phone_label'), 'trim');
		$this->validation->setRule('company', lang('Auth.create_user_validation_company_label'), 'trim');
		$this->validation->setRule('password', lang('Auth.create_user_validation_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[password_confirm]');
		$this->validation->setRule('password_confirm', lang('Auth.create_user_validation_password_confirm_label'), 'required');

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$email    = strtolower($this->request->getPost('email'));
			$identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
			$password = $this->request->getPost('password');

			$additionalData = [
				'first_name' => $this->request->getPost('first_name'),
				'last_name'  => $this->request->getPost('last_name'),
				'company'    => $this->request->getPost('company'),
				'phone'      => $this->request->getPost('phone'),
			];
		}
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run() && $this->ionAuth->register($identity, $password, $email, $additionalData)) {
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth');
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

			$this->data['first_name'] = [
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => set_value('first_name'),
			];
			$this->data['last_name'] = [
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => set_value('last_name'),
			];
			$this->data['identity'] = [
				'name'  => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => set_value('identity'),
			];
			$this->data['email'] = [
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'email',
				'value' => set_value('email'),
			];
			$this->data['company'] = [
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => set_value('company'),
			];
			$this->data['phone'] = [
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => set_value('phone'),
			];
			$this->data['password'] = [
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => set_value('password'),
			];
			$this->data['password_confirm'] = [
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => set_value('password_confirm'),
			];

			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'create_user', $this->data);
		}
	}

	/**
	 * Redirect a user checking if is admin
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function redirectUser()
	{
		if ($this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}
		return redirect()->to('/');
	}

	/**
	 * Edit a user
	 *
	 * @param integer $id User id
	 *
	 * @return string string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function edit_profile()
	{
		$this->data['title'] = lang('Auth.edit_user_heading');

		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}
		$id = $this->ionAuth->user()->row()->id;
		$user          = $this->ionAuth->user($id)->row();
		$groups        = $this->ionAuth->groups()->resultArray();
		$currentGroups = $this->ionAuth->getUsersGroups($id)->getResult();

		if (!empty($_POST)) {

			if($user->email != $this->request->getPost('email'))
			{
				$this->validation->setRule('email', 'email', 'trim|required|valid_email|is_unique[' . $this->configAuditSurvey->table_users . '.email]');
			}
			if($user->group_id == '2')
			{
				// validate form input
				$this->validation->setRule('organization_name', 'organization name', 'alpha_space|trim|required|min_length[3]|max_length[150]');
				$this->validation->setRule('billing_address_1', 'Billing address', 'trim|required|min_length[3]');
				$this->validation->setRule('billing_state', 'billing state', 'trim|required');
				$this->validation->setRule('billing_city', 'billing city', 'trim|required|min_length[3]|max_length[150]');
				$this->validation->setRule('first_name', 'first name', 'alpha_space|trim|required|min_length[3]|max_length[150]');
				$this->validation->setRule('last_name', 'Last name', 'alpha_space|trim|required|min_length[3]|max_length[150]');
				$this->validation->setRule('state', 'state', 'trim|required');
				$this->validation->setRule('city', 'city', 'trim|required|min_length[3]|max_length[150]');
				$this->validation->setRule('address', 'address', 'trim|required|min_length[10]');
				$this->validation->setRule('phone', 'phone', 'trim|required|min_length[6]|max_length[30]');


				$this->validation->setRule('zipcode', 'zipcode', 'trim|required|min_length[3]|max_length[20]');
				$this->validation->setRule('title', 'title', 'trim|required|min_length[3]|max_length[150]');
				$this->validation->setRule('ext', 'ext', 'trim|required|min_length[3]|max_length[20]');
			}
			

			if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
				if($user->group_id == '2')
				{

					$data = [
						'first_name' => trim($this->request->getPost('first_name')),
						'last_name' => trim($this->request->getPost('last_name')),
						'email'  => $this->request->getPost('email'),
						'address' => trim($this->request->getPost('address')),
						'office_address2' => trim($this->request->getPost('office_address')),
						'phone' => trim($this->request->getPost('phone')),
						'title_role' => trim($this->request->getPost('title')),
						'extension' => trim($this->request->getPost('ext')),
						'fax' => trim($this->request->getPost('fax')),
						'city' => trim($this->request->getPost('city')),
						'zipcode' => trim($this->request->getPost('zipcode')),
	            		'state' => $this->request->getPost('state'),
						'organization_name'=> trim($this->request->getPost('organization_name')),
						'billing_address_1' => trim($this->request->getPost('billing_address_1')),
						'billing_address_2' => trim($this->request->getPost('billing_address_2')),
						'website_url'  => trim($this->request->getPost('website_url')),
						'billing_state'  => $this->request->getPost('billing_state'),
						'billing_city' => trim($this->request->getPost('billing_city')),
						'billing_zipcode'  => trim($this->request->getPost('billing_zipcode')),

					];
				}
				else
				{
					$data['email'] = $this->request->getPost('email');
					$data['extension'] = $this->request->getPost('ext');
					$data['phone'] = $this->request->getPost('phone');
				}

				if($this->request->getPost('sms_survey_completion'))
				{
					$data['sms_survey_completion'] = $this->request->getPost('sms_survey_completion');
				}
				else
				{
					$data['sms_survey_completion'] = '0';
				}

				if($this->request->getPost('sms_receive_alerts'))
				{
					$data['sms_survey_alert'] = $this->request->getPost('sms_receive_alerts');
				}
				else
				{
					$data['sms_survey_alert'] = '0';
				}

				if($this->request->getPost('email_survey_completion'))
				{
					$data['email_survey_completion'] = $this->request->getPost('email_survey_completion');
				}
				else
				{
					$data['email_survey_completion'] = '0';
				}

				if($this->request->getPost('email_survey_alerts'))
				{
					$data['email_survey_alert'] = $this->request->getPost('email_survey_alerts');
				}
				else
				{
					$data['email_survey_alert'] = '0';
				}

				// check to see if we are updating the user
				if ($this->ionAuth->update($user->id, $data)) {
					$this->session->setFlashdata('message', $this->ionAuth->messages());
				} else {
					$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				}
				
			}
		}

		// display the edit user form

		// set the flash data error message if there is one
		$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;
		//$this->data['created_by'] = $this->userModel->select('name')->find($user->created_by);
		$this->data['state_master'] = $this->groupModel->get_all_data($this->configAuditSurvey->table_state_master);

		//get district ltc, rtc name
		$this->data['districts'] = $this->userModel->getUserDistrict($id);

		//get parent user name and phone number
		if($_SESSION['user_type'] == ROLE_RTS || $_SESSION['user_type'] == ROLE_LTS || $_SESSION['user_type'] == ROLE_OAS)
		{
			$this->data['parent_user'] = $this->userModel->getCoordinatorData($id);
		}

		//oac user
		if($_SESSION['user_type'] == ROLE_OAC || $_SESSION['user_type'] == ROLE_OAS)
		{
			$this->data['school_destination'] = $this->userModel->getUserSchoolDestination($id);
		}

		$this->data['ionAuth'] = $this->ionAuth;

		return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'edit_profile', $this->data);
	}

	/**
	 * Create a new group
	 *
	 * @return string string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function create_group()
	{
		$this->data['title'] = lang('Auth.create_group_title');

		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/auth');
		}

		// validate form input
		$this->validation->setRule('group_name', lang('Auth.create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$newGroupId = $this->ionAuth->createGroup($this->request->getPost('group_name'), $this->request->getPost('description'));
			if ($newGroupId) {
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/auth');
			}
		} else {
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

			$this->data['group_name'] = [
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => set_value('group_name'),
			];
			$this->data['description'] = [
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => set_value('description'),
			];

			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'create_group', $this->data);
		}
	}

	/**
	 * Edit a group
	 *
	 * @param integer $id Group id
	 *
	 * @return string|CodeIgniter\Http\Response
	 */
	public function edit_group(int $id = 0)
	{
		// bail if no group id given
		if (!$id) {
			return redirect()->to('/auth');
		}

		$this->data['title'] = lang('Auth.edit_group_title');

		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/auth');
		}

		$group = $this->ionAuth->group($id)->row();

		// validate form input
		$this->validation->setRule('group_name', lang('Auth.edit_group_validation_name_label'), 'required|alpha_dash');

		if ($this->request->getPost()) {
			if ($this->validation->withRequest($this->request)->run()) {
				$groupUpdate = $this->ionAuth->updateGroup($id, $this->request->getPost('group_name'), ['description' => $this->request->getPost('group_description')]);

				if ($groupUpdate) {
					$this->session->setFlashdata('message', lang('Auth.edit_group_saved'));
				} else {
					$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				}
				return redirect()->to('/auth');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = $this->validation->listErrors($this->validationListTemplate) ?: ($this->ionAuth->errors($this->validationListTemplate) ?: $this->session->getFlashdata('message'));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->configIonAuth->adminGroup === $group->name ? 'readonly' : '';

		$this->data['group_name']        = [
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => set_value('group_name', $group->name),
			$readonly => $readonly,
		];
		$this->data['group_description'] = [
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => set_value('group_description', $group->description),
		];

		return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
	}

	/**
	 * Render the specified view
	 *
	 * @param string     $view       The name of the file to load
	 * @param array|null $data       An array of key/value pairs to make available within the view.
	 * @param boolean    $returnHtml If true return html string
	 *
	 * @return string|void
	 */
	protected function renderPage(string $view, $data = null, bool $returnHtml = true): string
	{
		$viewdata = $data ?: $this->data;

		$viewHtml = view($view, $viewdata);

		if ($returnHtml) {
			return $viewHtml;
		} else {
			echo $viewHtml;
		}
	}
}
