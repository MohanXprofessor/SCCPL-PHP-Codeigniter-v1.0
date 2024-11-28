<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brands extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Courses';

		$this->load->model('model_brands');
	}

	/* 
	 * It only redirects to the manage product page and
	 */
	public function index()
	{
		if (!in_array('viewBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_brands->getBrandData();

		$this->data['results'] = $result;

		$this->render_template('brands/index', $this->data);
	}

	/*
	 * Fetches the brand data from the brand table 
	 * this function is called from the datatable ajax function
	 */
	public function fetchBrandData()
	{
		$result = array('data' => array());

		$data = $this->model_brands->getBrandData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if (in_array('viewBrand', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editBrand(' . $value['id'] . ')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';
			}

			if (in_array('deleteBrand', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeBrand(' . $value['id'] . ')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
				';
			}

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
			$pd = $this->model_stores->getStoresData($value["project_id"]);
			$project = "--";

			if ($pd != null)
				$project = $pd['name'];

			$result['data'][$key] = array(
				$value['name'],
				//$value['rate'],
				$project,
				$value['duration_in_months'],
				$value['duration_in_hours'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	 * It checks if it gets the brand id and retreives
	 * the brand information from the brand model and 
	 * returns the data into json format. 
	 * This function is invoked from the view page.
	 */
	public function fetchBrandDataById($id)
	{
		if ($id) {
			$data = $this->model_brands->getBrandData($id);
			echo json_encode($data);

		}

		return false;
	}

	/*
	 * Its checks the brand form validation 
	 * and if the validation is successfully then it inserts the data into the database 
	 * and returns the json format operation messages
	 */
	public function create()
	{

		if (!in_array('createBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('brand_name', 'Brand name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				// Updates added by Akash Fulari on 29-03-2024
				'project_id' => $this->input->post('project_id'),
				'name' => $this->input->post('brand_name'),
				//'rate' => $this->input->post('rate'), // added rate and timing 3/28/19 ramiz
				'duration_in_months' => $this->input->post('duration_in_months'),
				'duration_in_hours' => $this->input->post('duration_in_hours'),
				'active' => $this->input->post('active'),
				'added_by' => $this->userId
			);

			$create = $this->model_brands->create($data);
			if ($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Succesfully created';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Error in the database while creating the brand information';
			}
		} else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($response);

	}

	/*
	 * Its checks the brand form validation 
	 * and if the validation is successfully then it updates the data into the database 
	 * and returns the json format operation messages
	 */
	public function update($id)
	{
		if (!in_array('updateBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if ($id) {
			$this->form_validation->set_rules('edit_brand_name', 'Brand name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == TRUE) {
				$data = array(
					// Updates added by Akash Fulari on 29-03-2024
					'project_id' => $this->input->post('project_id'),
					'name' => $this->input->post('edit_brand_name'),
					'active' => $this->input->post('edit_active'),
					//	'rate' => $this->input->post('rate'), // added rate and timing 3/28/19 ramiz
					'duration_in_months' => $this->input->post('duration_in_months'),
					'duration_in_hours' => $this->input->post('duration_in_hours'),
					'added_by' => $this->userId
				);

				$update = $this->model_brands->update($data, $id);
				if ($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Succesfully updated';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Error in the database while updated the brand information';
				}
			} else {
				$response['success'] = false;
				foreach ($_POST as $key => $value) {
					$response['messages'][$key] = form_error($key);
				}
			}
		} else {
			$response['success'] = false;
			$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	 * It removes the brand information from the database 
	 * and returns the json format operation messages
	 */
	public function remove()
	{
		if (!in_array('deleteBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$brand_id = $this->input->post('brand_id');
		$response = array();
		if ($brand_id) {
			$delete = $this->model_brands->remove($brand_id);

			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}