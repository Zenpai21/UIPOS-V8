<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_auth');
	}

	//Validate -> Login -> Start Session -> Directs Dashboard-> Logout
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('username', 'Username', 'required');
    	$this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {

           	$user_exists = $this->model_auth->check_user($this->input->post('username'));

           	if($user_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('username'), $this->input->post('password'));

           		if($login) {

           			$logged_in_sess = array(
           				'id' => $login['id'],
				        'username'  => $login['username'],
				        'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
           			redirect('dashboard', 'refresh');
           		}
           		else {
           			$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'User does not exists';
           		$this->load->view('login', $this->data);
           	}
        }
        else {
		   
			// False case and reload Login Page
            $this->load->view('login');
        }
	}

	/*
		Clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}

}
