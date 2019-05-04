<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Suppliers';

		$this->load->model('model_suppliers');
	}

	// It only redirects to the manage suppliers page 
	public function index()
	{
		if(!in_array('viewSuppliers', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('suppliers/index', $this->data);
	}

	// It retrieve the specific supplier information via a supplier id and returns the data in json format.
	public function fetchSuppliersDataById($id)
	{
		if($id) {
			$data = $this->model_suppliers->getSuppliersData($id);
			echo json_encode($data);
		}
	}

	// Load and Display Data to Table
	public function fetchSuppliersData()
	{
		$result = array('data' => array());

		$data = $this->model_suppliers->getSuppliersData();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateSuppliers', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteSuppliers', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['name'],
				$value['contact'],
				$value['address'],
				$status,
				$buttons

			);
		} // /foreach
		echo json_encode($result);
	}

	// Validation and Create
	public function create()
	{
		if(!in_array('createSuppliers', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		/*check/validate create form */
		$this->form_validation->set_rules('suppliers_name', 'Suppliers name', 'trim|required');
		$this->form_validation->set_rules('suppliers_contact', 'Suppliers contact', 'trim|required|numeric|max_length[13]');
		$this->form_validation->set_rules('suppliers_address', 'Suppliers address', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');


		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');


        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('suppliers_name'),
						'contact' => $this->input->post('suppliers_contact'),
						'address' => $this->input->post('suppliers_address'),
        		'active' => $this->input->post('active')
        	);

        	$create = $this->model_suppliers->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	// Validation and Update
	public function update($id)
	{
		if(!in_array('updateSuppliers', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {

			$this->form_validation->set_rules('edit_suppliers_name', 'Suppliers name', 'trim|required');
			$this->form_validation->set_rules('edit_suppliers_contact', 'Suppliers Contact', 'trim|required|numeric|max_length[13]');
			$this->form_validation->set_rules('edit_suppliers_address', 'Suppliers address', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');


			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_suppliers_name'),
							'contact' => $this->input->post('edit_suppliers_contact'),
							'address' => $this->input->post('edit_suppliers_address'),
	        		'active' => $this->input->post('edit_active')
							);

	        	$update = $this->model_suppliers->update($data, $id);

	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	//Delete
	public function remove()
	{
		if(!in_array('deleteSuppliers', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$suppliers_id = $this->input->post('suppliers_id');

		$response = array();
		if($suppliers_id) {
			$delete = $this->model_suppliers->remove($suppliers_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refresh the page again!!";
		}

		echo json_encode($response);
	}

}
