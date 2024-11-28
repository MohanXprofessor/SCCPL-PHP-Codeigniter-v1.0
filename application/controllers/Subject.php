
<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-05-09 14:57:32
 Last Modification Date: 2024-05-09 15:03:49
*
**/
class Subject extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Subject';
		$this->load->model('model_subject');
	}

	public function addSubject()
	{
		$this->data['page_title'] = 'Add Subject';

		if (!in_array('createSubject', $this->permission)) {
			// redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('project_id', 'project_id', 'required');
		$this->form_validation->set_rules('course_id', 'course_id', 'required');
		$this->form_validation->set_rules('subject_title', 'subject_title', 'trim|required');
		$this->form_validation->set_rules('duration_in_hour', 'duration_in_hour', 'trim|required');
		$this->form_validation->set_rules('duration_in_months', 'duration_in_months', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			// true case

			$data = array(
				'project_id' => $this->input->post('project_id'),
				'course_id' => $this->input->post('course_id'),
				'subject_title' => $this->input->post('subject_title'),
				'duration_in_hour' => $this->input->post('duration_in_hour'),
				'duration_in_months' => $this->input->post('duration_in_months')
			);

			$create = $this->model_subject->createSubject($data);
			if ($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
				redirect('subject/addSubject', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('subject/addSubject', 'refresh');
			}
		} else {
			// false case
			// $group_data = $this->model_groups->getGroupData();
			// $this->data['group_data'] = $group_data;

			$this->render_template('subject/index', $this->data);
		}
	}

	public function updateSubject()
	{
		$this->data['page_title'] = 'Add Subject';

		if (!in_array('updateSubject', $this->permission)) {
			// redirect('dashboard', 'refresh');
		}

		// $this->form_validation->set_rules('id', 'id', 'required');
		$this->form_validation->set_rules('project_id', 'project_id', 'required');
		$this->form_validation->set_rules('course_id', 'course_id', 'required');
		$this->form_validation->set_rules('subject_title', 'subject_itle', 'trim|required');
		$this->form_validation->set_rules('duration_in_hour', 'duration_in_hour', 'trim|required');
		$this->form_validation->set_rules('duration_in_months', 'duration_in_months', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$id = $this->input->post('id');

			$data = array(

				'project_id' => $this->input->post('project_id'),
				'course_id' => $this->input->post('course_id'),
				'subject_title' => $this->input->post('subject_title'),
				'duration_in_hour' => $this->input->post('duration_in_hour'),
				'duration_in_months' => $this->input->post('duration_in_months')
			);


			$isUpdated = $this->model_subject->updateSubject($data, $id);

			if ($isUpdated) {
				$response['success'] = true;
				$response['messages'] = "Subject Successfully updated";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while update the subject information";
			}
			
			echo json_encode($response);
		} else {
			$this->render_template('subject/index', $this->data);
		}
	}


	public function removeSubject()
	{

		if (!in_array('removeSubject', $this->permission)) {
			// redirect('dashboard', 'refresh');
		}

		$id = $this->input->post('id');

		$response = array();
		if ($id) {
			$delete = $this->model_subject->removeSubject($id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Subject Successfully removed";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the subject information";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

	public function fetchSubjectData()
	{
		$result = array('data' => array());

		$data = $this->model_subject->getSubjectData();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			$buttons .= '<button type="button" class="btn btn-default" onclick="editSubject(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';

			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeSubject(' . $value['id'] . ')" data-toggle="modal" data-target="#removeSubjectModal"><i class="fa fa-trash"></i></button>';

			$result['data'][$key] = array(
				$value['project_id'],
				$value['course_id'],
				$value['subject_title'],
				$value['duration_in_months'],
				$value['duration_in_hour'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	public function fetchSubjectDataById($id)
	{
		$data = $this->model_subject->fetchSubjectDataById($id);
		echo json_encode($data);
	}
}
