<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Documents extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Document';

		$this->load->model('model_documents');
		$this->load->model('model_result');
		$this->load->model('model_subjectnew');
		$this->load->model('model_batch');

	}

	public function create()
	{
		$res = array("status" => false, "message" => "");

		$this->form_validation->set_rules('title', 'Document Title', 'trim|required');
		$this->form_validation->set_rules('batch', 'Batch Id', 'trim|required');
		$this->form_validation->set_rules('subject', 'Subject Id', 'trim|required');
		$this->form_validation->set_rules('type', 'Document Type', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			if ($this->validateFormFile("document")) {
				$type = $this->input->post('type');
				
				$bid = $this->input->post('batch');
				$subject = $this->input->post('subject');
				$load = $this->model_documents->isItCreatedAlready($bid, $subject, $type);
				if (!$load) {
					$userFolderPath = "assets/uploads/documents/" . $type . "_type/" . $this->userData['firstname'] . "_" . $this->userData['firstname'];

					$file1 = $this->uploadFile($userFolderPath, 'document', 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|ppt|mp3|mp4|avi|ogg|webp|webm');
					$path = (($file1['status'] == 1) ? $file1['data']['full_path'] : null);

					if ($path) {
						$data = array(
							'batch_id' => $bid,
							'subject_id' => $subject,
							'title' => $this->input->post('title'),
							'type' => $type,
							'document' => $path,
							'added_by' => $this->userId
						);

						//print_r($data);die();
						$isCreated = $this->model_documents->createDocument($data);
						if ($isCreated) {
							$res['status'] = true;
							$res['message'] = "Document created successfully!.";
						} else {
							$res['message'] = "Unable to submit Document!.";
						}
					} else {
						$res['message'] = "Unable to uplaod your document file!.";
					}
				} else {
					$res['message'] = "Document already created.";
				}

			} else {
				$res['message'] = "Please select document file.";
			}
		} else {
			$res['message'] = "all fields are mendatory!!!.";
		}

		echo json_encode($res);
	}

	public function update()
	{
		
		$res = array("status" => false, "message" => "");

		$this->form_validation->set_rules('document_id', 'Document ID', 'trim|required');
		$this->form_validation->set_rules('title', 'Document Title', 'trim|required');
		$this->form_validation->set_rules('batch', 'Batch Id', 'trim|required');
		$this->form_validation->set_rules('subject', 'Subject Id', 'trim|required');
		$this->form_validation->set_rules('type', 'Document Type', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$type = $this->input->post('type');
			$qid = $this->input->post('document_id');
			$bid = $this->input->post('batch');
			$subject = $this->input->post('subject');
			$type = $this->input->post('type');
			$load = $this->model_documents->isExists($qid);
			if ($load != null) {
				$path = null;
				if ($this->validateFormFile("document")) {
					$userFolderPath = "assets/uploads/documents/" . $type . "_type/" . $this->userData['firstname'] . "_" . $this->userData['firstname'];

					$file1 = $this->uploadFile($userFolderPath, 'document', 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|ppt|mp3|mp4|avi|ogg|webp|webm');
					$path = (($file1['status'] == 1) ? $file1['data']['full_path'] : null);
				}

				$data = array(
					'batch_id' => $bid,
					'subject_id' => $subject,
					'title' => $this->input->post('title'),
					'type' => $type,
					'added_by' => $this->userId
				);

				if ($path != null) {
					$data['document'] = $path;

					$existingPath = $load['document'];
					unlink($existingPath);
				}

				$isCreated = $this->model_documents->updateDocument($data, $qid);
				if ($isCreated) {
					$res['status'] = true;
					$res['message'] = "Document updated successfully!.";
				} else {
					$res['message'] = "Unable to update Document!.";
				}
			} else {
				$res['message'] = "Document does not exists!!!.";
			}
		}
		else {
			$res['message'] = "all fields are mendatory!!!.";
		}

		echo json_encode($res);
	}

	public function submitResult()
	{
		$res = array("status" => false, "message" => "");

		$this->form_validation->set_rules('document_id', 'Document', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			if ($this->validateFormFile("document")) {
				$qid = $this->input->post('document_id');
				$load = $this->model_documents->isExists($qid);
				if ($load) {
					$userFolderPath = "assets/uploads/documents/results/" . $load['type'] . "_type/" . $this->userData['firstname'] . "_" . $this->userData['firstname'];

					$files_data = $this->uploadMultiFile($userFolderPath, $_FILES['document'], 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|ppt|mp3|mp4|avi|ogg|webp|webm');
					if ($files_data['status'] == 1) {
						$files = $files_data['data'];
						$isCreated = false;
						foreach ($files as $file) {
							$path = $file['full_path'];
							if ($path) {
								$data = array(
									'document_id' => $qid,
									'document' => $path,
									'added_by' => $this->userId
								);
								$isCreated = $this->model_result->createResult($data);
							}
						}
						if ($isCreated) {
							$res['status'] = true;
							$res['message'] = "Document result submitted successfully!.";
						} else {
							$res['message'] = "Unable to submit Document results!.";
						}
					} else {
						$res['message'] = "Unable to upload result files!!!.";
					}
				} else {
					$res['message'] = "Result paper already created.";
				}

			} else {
				$res['message'] = "Please select document file.";
			}
		} else {
			$res['message'] = "all fields are mendatory!!!.";
		}

		echo json_encode($res);
	}

	public function updateResult()
	{
		$res = array("status" => false, "message" => "");

		$this->form_validation->set_rules('document_id', 'Document', 'trim|required');
		$this->form_validation->set_rules('result_id', 'Result', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			if ($this->validateFormFile("document")) {

				$qid = $this->input->post('document_id');
				$rid = $this->input->post('result_id');

				$load1 = $this->model_documents->isExists($qid);
				$load2 = $this->model_result->isExists($rid);

				if ($load1 != null && $load2 != null) {
					$userFolderPath = "assets/uploads/quiestion_paper/results/" . $load1['type'] . "_type/" . $this->userData['firstname'] . "_" . $this->userData['firstname'];

					$file1 = $this->uploadFile($userFolderPath, 'document', 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|ppt|mp3|mp4|avi|ogg|webp|webm');
					$path = (($file1['status'] == 1) ? $file1['data']['full_path'] : null);
					if ($path != null) {
						$data = array(
							'document' => $path
						);
						$isCreated = $this->model_result->updateResult($data, $rid);
						if ($isCreated) {
							$existingPath = $load2['document'];
							unlink($existingPath);

							$res['status'] = true;
							$res['message'] = "Result updated successfully!.";
						} else {
							$res['message'] = "Unable to update Result!.";
						}
					} else {
						$res['message'] = "Unable to upload result file!!!.";
					}
				} else {
					if ($load1 == null)
						$res['message'] = "Document does not exists!.";
					else
						$res['message'] = "Result does not exists!.";
				}

			} else {
				$res['message'] = "Please select document file.";
			}
		} else {
			$res['message'] = "Invalid for fields!!!.";
		}

		echo json_encode($res);
	}

	public function getDocuments($bid)
	{
		$result = array('data' => array());
		$qpapers = $this->model_documents->getDocumentsByUserId($bid);
		$i = 0;
		
		foreach ($qpapers as $data) {
			$buttons = "";
			if (in_array('updateDocuments', $this->permission))
				$buttons .= ' <a class="btn btn-sm btn-success d-block" onclick="openUpdateDocumentModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\', \'' . $data['batch_id'] . '\', \'' . $data['subject_id'] . '\', \'' . $data['type'] . '\')" data-toggle="modal" data-target="#updateDocsModal" title="Update Question Paper"><i class="fa fa-pencil"></i></a>';
			// if (in_array('viewDocuments', $this->permission))
			// 	$buttons .= ' <a class="btn btn-sm btn-warning d-block" href="' . base_url("documents/viewResults/" . $data['id']) . '" title="View Results"><i class="fa fa-eye"></i></a>';
			if (in_array('deleteDocuments', $this->permission))
				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="deleteDocument(' . $data['id'] . ')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></a>';

			$batch = $this->model_batch->getProductData($data['batch_id']);
			$subject = $this->model_subjectnew->fetchSubjectnewDataById($data['subject_id']);
			$typ = $data['type'];
			$type = "";
			if ($typ == 1) {
				$type = "Grade 1";
			} else if ($typ == 2) {
				$type = "Grade 2";
			} else if ($typ == 3) {
				$type = "Grade 3";
			} else if ($typ == 4) {
				$type = "Assessment 1";
			} else if ($typ == 5) {
				$type = "Assessment 2";
			} else if ($typ == 6) {
				$type = "Assessment 3";
			} 
			else if ($typ == 7) {
				$type = "Event";
			}
			else if ($typ == 8) {
				$type = "Project Docs";
			} 
			else if ($typ == 9) {
				$type = "Other";
			} else if ($typ == 10) {
				$type = "Study Material";
			}
			else if ($typ == 11) {
				$type = "Syllabus";
			} 
			
			// if (in_array('createDocuments', $this->permission) && ($typ >= 1 && $typ <= 6))
			// 	$buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="openSubmitResultModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\')" data-toggle="modal" data-target="#addResultModal" title="Submit Result"><i class="fa fa-file-o"></i></a>';
			 $rpFind = "C:/xampp/htdocs/sspl2";
             $rpString = "";  

			$result['data'][$i] = array(
				$data['id'],
				$data['title'],
				$batch['batch_name'],
				$subject['subject'],
				$type,
				(($data['document'] != "" && in_array('viewDocuments', $this->permission)) 
				? "<a class='btn btn-sm btn-primary download' href='" . site_url(str_replace($rpFind, $rpString,$data['document'])). 
				"' download><i class='fa fa-download'></i> View Document</a>" : "---"),

				
				$buttons
			);
			$i++;
		}

		
		echo json_encode($result);
	}

	public function getProjectDocuments($bid)
	{
		
		$result = array('data' => array());
		$project = $this->model_documents->getProjectByUserBatchAndType($bid, $this->userId, 8);
		// print_r($project);die();
		$i = 0;
		foreach ($project as $data) {
			$buttons = "";
			if (in_array('updateDocuments', $this->permission))
				$buttons .= ' <a class="btn btn-sm btn-success d-block" onclick="openUpdateDocumentModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\', \'' . $data['batch_id'] . '\', \'' . $data['subject_id'] . '\', \'' . $data['type'] . '\')" data-toggle="modal" data-target="#updateDocsModal" title="Update Project Document"><i class="fa fa-pencil"></i></a>';
			// if (in_array('viewDocuments', $this->permission))
			// 	$buttons .= ' <a class="btn btn-sm btn-warning d-block" href="' . base_url("documents/viewResults/" . $data['id']) . '" title="View Results"><i class="fa fa-eye"></i></a>';
			if (in_array('deleteDocuments', $this->permission))
				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="deleteDocument(' . $data['id'] . ')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></a>';

			$batch = $this->model_batch->getProductData($data['batch_id']);
			$subject = $this->model_subjectnew->fetchSubjectnewDataById($data['subject_id']);
			$typ = $data['type'];
			$type = "";
			if ($typ == 1) {
				$type = "Grade 1";
			} else if ($typ == 2) {
				$type = "Grade 2";
			} else if ($typ == 3) {
				$type = "Grade 3";
			} else if ($typ == 4) {
				$type = "Assessment 1";
			} else if ($typ == 5) {
				$type = "Assessment 2";
			} else if ($typ == 6) {
				$type = "Assessment 3";
			} else if ($typ == 7) {
				$type = "Event";
			}
			else if ($typ == 8) {
				$type = "Project Docs";
			} 
			else if ($typ == 9) {
				$type = "Other";
			} else if ($typ == 10) {
				$type = "Study Material";
			}
			else if ($typ == 11) {
				$type = "Syllabus";
			} 

			// if (in_array('createDocuments', $this->permission) && ($typ >= 1 && $typ <= 6))
			// 	$buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="openSubmitResultModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\')" data-toggle="modal" data-target="#addResultModal" title="Submit Result"><i class="fa fa-file-o"></i></a>';
			// $rpFind = "/home/interfa1/";
            //       $rpString = "https://";

			$rpFind = "C:/xampp/htdocs/sspl2";
			$rpString = "";  
			$result['data'][$i] = array(
				$data['id'],
				$data['title'],
				$batch['batch_name'],
				$subject['subject'],
				$type,
				(($data['document'] != "" && in_array('viewDocuments', $this->permission)) 
				? "<a class='btn btn-sm btn-primary download' href='" . site_url(str_replace($rpFind, $rpString,$data['document'])). 
				"' download><i class='fa fa-download'></i> View Document</a>" : "---"),

				$buttons
			);
			$i++;
		}
		echo json_encode($result);
	}

	public function getStudyMaterial($bid)
	{
		$result = array('data' => array());
		$study_material = $this->model_documents->getStudyMaterialByUserBatchAndType($bid,  $this->userId, 10);
		$i = 0;
		foreach ($study_material as $data) {
			$buttons = "";
			if (in_array('updateDocuments', $this->permission))
				$buttons .= ' <a class="btn btn-sm btn-success d-block" onclick="openUpdateDocumentModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\', \'' . $data['batch_id'] . '\', \'' . $data['subject_id'] . '\', \'' . $data['type'] . '\')" data-toggle="modal" data-target="#updateDocsModal" title="Update Study Material"><i class="fa fa-pencil"></i></a>';
			// if (in_array('viewDocuments', $this->permission))
			// 	$buttons .= ' <a class="btn btn-sm btn-warning d-block" href="' . base_url("documents/viewResults/" . $data['id']) . '" title="View Results"><i class="fa fa-eye"></i></a>';
			if (in_array('deleteDocuments', $this->permission))
				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="deleteDocument(' . $data['id'] . ')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></a>';

			$batch = $this->model_batch->getProductData($data['batch_id']);
			$subject = $this->model_subjectnew->fetchSubjectnewDataById($data['subject_id']);
			$typ = $data['type'];
			$type = "";
			if ($typ == 1) {
				$type = "Grade 1";
			} else if ($typ == 2) {
				$type = "Grade 2";
			} else if ($typ == 3) {
				$type = "Grade 3";
			} else if ($typ == 4) {
				$type = "Assessment 1";
			} else if ($typ == 5) {
				$type = "Assessment 2";
			} else if ($typ == 6) {
				$type = "Assessment 3";
			} else if ($typ == 7) {
				$type = "Event";
			} else if ($typ == 8) {
				$type = "Project Docs";
			} else if ($typ == 9) {
				$type = "Other";
			}
			else if ($typ == 10) {
				$type = "Study Material";
			}
			else if ($typ == 11) {
				$type = "Syllabus";
			} 

			// if (in_array('createDocuments', $this->permission) && ($typ >= 1 && $typ <= 6))
			// 	$buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="openSubmitResultModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\')" data-toggle="modal" data-target="#addResultModal" title="Submit Result"><i class="fa fa-file-o"></i></a>';

			$rpFind = "C:/xampp/htdocs/sspl2";
			$rpString = "";  
			$result['data'][$i] = array(
				$data['id'],
				$data['title'],
				$batch['batch_name'],
				$subject['subject'],
				$type,
				(($data['document'] != "" && in_array('viewDocuments', $this->permission)) 
				? "<a class='btn btn-sm btn-primary download' href='" . site_url(str_replace($rpFind, $rpString,$data['document'])). 
				"' download><i class='fa fa-download'></i> View Document</a>" : "---"),
				$buttons
			);
			$i++;
		}
		echo json_encode($result);
	}

	public function getSyllabus($bid)
	{
		$result = array('data' => array());
		$syllabus = $this->model_documents->getSyllabusByUserBatchAndType($bid,  $this->userId, 11);
		$i = 0;
		foreach ($syllabus as $data) {
			$buttons = "";
			if (in_array('updateDocuments', $this->permission))
				$buttons .= ' <a class="btn btn-sm btn-success d-block" onclick="openUpdateDocumentModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\', \'' . $data['batch_id'] . '\', \'' . $data['subject_id'] . '\', \'' . $data['type'] . '\')" data-toggle="modal" data-target="#updateDocsModal" title="Update Syllabus"><i class="fa fa-pencil"></i></a>';
			// if (in_array('viewDocuments', $this->permission))
			// 	$buttons .= ' <a class="btn btn-sm btn-warning d-block" href="' . base_url("documents/viewResults/" . $data['id']) . '" title="View Results"><i class="fa fa-eye"></i></a>';
			if (in_array('deleteDocuments', $this->permission))
				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="deleteDocument(' . $data['id'] . ')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></a>';

			$batch = $this->model_batch->getProductData($data['batch_id']);
			$subject = $this->model_subjectnew->fetchSubjectnewDataById($data['subject_id']);
			$typ = $data['type'];
			$type = "";
			if ($typ == 1) {
				$type = "Grade 1";
			} else if ($typ == 2) {
				$type = "Grade 2";
			} else if ($typ == 3) {
				$type = "Grade 3";
			} else if ($typ == 4) {
				$type = "Assessment 1";
			} else if ($typ == 5) {
				$type = "Assessment 2";
			} else if ($typ == 6) {
				$type = "Assessment 3";
			} else if ($typ == 7) {
				$type = "Event";
			} else if ($typ == 8) {
				$type = "Project Docs";
			} else if ($typ == 9) {
				$type = "Other";
			}
			else if ($typ == 10) {
				$type = "Study Material";
			}
			 else if ($typ == 11) {
				$type = "Syllabus";
			} 
			$rpFind = "C:/xampp/htdocs/sspl2";
			$rpString = "";  
			// if (in_array('createDocuments', $this->permission) && ($typ >= 1 && $typ <= 6))
			// 	$buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="openSubmitResultModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\')" data-toggle="modal" data-target="#addResultModal" title="Submit Result"><i class="fa fa-file-o"></i></a>';

			$result['data'][$i] = array(
				$data['id'],
				$data['title'],
				$batch['batch_name'],
				$subject['subject'],
				$type,
				(($data['document'] != "" && in_array('viewDocuments', $this->permission)) 
				? "<a class='btn btn-sm btn-primary download' href='" . site_url(str_replace($rpFind, $rpString,$data['document'])). 
				"' download><i class='fa fa-download'></i> View Document</a>" : "---"),
				$buttons
			);
			$i++;
		}
		echo json_encode($result);
	}

	public function getOtherDocsDocuments($bid)
	{
		$result = array('data' => array());
		$syllabus = $this->model_documents->getOtherDocsByUserBatchAndType($bid,  $this->userId, 9);
		$i = 0;
		foreach ($syllabus as $data) {
			$buttons = "";
			if (in_array('updateDocuments', $this->permission))
				$buttons .= ' <a class="btn btn-sm btn-success d-block" onclick="openUpdateDocumentModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\', \'' . $data['batch_id'] . '\', \'' . $data['subject_id'] . '\', \'' . $data['type'] . '\')" data-toggle="modal" data-target="#updateDocsModal" title="Update Document"><i class="fa fa-pencil"></i></a>';
			// if (in_array('viewDocuments', $this->permission))
			// 	$buttons .= ' <a class="btn btn-sm btn-warning d-block" href="' . base_url("documents/viewResults/" . $data['id']) . '" title="View Results"><i class="fa fa-eye"></i></a>';
			if (in_array('deleteDocuments', $this->permission))
				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="deleteDocument(' . $data['id'] . ')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></a>';

			$batch = $this->model_batch->getProductData($data['batch_id']);
			$subject = $this->model_subjectnew->fetchSubjectnewDataById($data['subject_id']);
			$typ = $data['type'];
			$type = "";
			if ($typ == 1) {
				$type = "Grade 1";
			} else if ($typ == 2) {
				$type = "Grade 2";
			} else if ($typ == 3) {
				$type = "Grade 3";
			} else if ($typ == 4) {
				$type = "Assessment 1";
			} else if ($typ == 5) {
				$type = "Assessment 2";
			} else if ($typ == 6) {
				$type = "Assessment 3";
			} else if ($typ == 7) {
				$type = "Event";
			} else if ($typ == 8) {
				$type = "Project Docs";
			}
			else if ($typ == 9) {
				$type = "Other";
			}
			else if ($typ == 10) {
				$type = "Study Material";
			}
			else if ($typ == 11) {
				$type = "Syllabus";
			} 
			// if (in_array('createDocuments', $this->permission) && ($typ >= 1 && $typ <= 6))
			// 	$buttons .= ' <a class="btn btn-sm btn-info d-block" onclick="openSubmitResultModal(\'' . $data['id'] . '\', \'' . $data['title'] . '\')" data-toggle="modal" data-target="#addResultModal" title="Submit Result"><i class="fa fa-file-o"></i></a>';

			$rpFind = "C:/xampp/htdocs/sspl2";
			$rpString = "";  
			$result['data'][$i] = array(
				$data['id'],
				$data['title'],
				$batch['batch_name'],
				$subject['subject'],
				$type,
				(($data['document'] != "" && in_array('viewDocuments', $this->permission)) 
				? "<a class='btn btn-sm btn-primary download' href='" . site_url(str_replace($rpFind, $rpString,$data['document'])). 
				"' download><i class='fa fa-download'></i> View Document</a>" : "---"),
				$buttons
			);
			$i++;
		}
		echo json_encode($result);
	}
	public function getResults($qid)
	{
		$result = array('data' => array());
		$results = $this->model_result->getResultByDocumentId($qid);
		$i = 0;
		$qdata = $this->model_documents->getDocumentById($qid);
		foreach ($results as $data) {
			$buttons = "";
			if (in_array('updateDocuments', $this->permission))
				$buttons .= ' <a class="btn btn-sm btn-success d-block" onclick="openUpdateResultModal(' . $data['id'] . ', ' . $qdata['id'] . ')" data-toggle="modal" data-target="#updateResultModal" title="Update Result"><i class="fa fa-pencil"></i></a>';
			if (in_array('deleteDocuments', $this->permission))
				$buttons .= ' <a type="button" class="btn btn-sm btn-danger d-block" onclick="deleteResult(' . $data['id'] . ')" data-toggle="modal" data-target="#removeResultModal"><i class="fa fa-trash"></i></a>';
			$batch = $this->model_batch->getProductData($qdata['batch_id']);
			$subject = $this->model_subjectnew->fetchSubjectnewDataById($qdata['subject_id']);
			$typ = $qdata['type'];
			$type = "";
			if ($typ == 1) {
				$type = "Grade 1";
			} else if ($typ == 2) {
				$type = "Grade 2";
			} else if ($typ == 3) {
				$type = "Grade 3";
			} else if ($typ == 4) {
				$type = "Assessment 1";
			} else if ($typ == 5) {
				$type = "Assessment 2";
			} else if ($typ == 6) {
				$type = "Assessment 3";
			}
			$result['data'][$i] = array(
				$data['id'],
				$qdata['title'],
				$batch['batch_name'],
				$subject['subject'],
				$type,
				(($data['document'] != "" && in_array('viewDocuments', $this->permission)) ? "<a  class='btn btn-sm btn-primary' href='" . $data['document'] . "' download='" . $data['document'] . "'><i class='fa fa-download'></i> View Document</a>" : "---"),
				$buttons
			);
			$i++;
		}
		echo json_encode($result);
	}

	public function deleteResult()
	{
		$id = $this->input->post('id');
		$response = array();
		if ($id) {
			$delete = $this->model_result->deleteResults($id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Result Successfully removed";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the Result information";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

	public function delete()
	{
		$id = $this->input->post('id');

		// echo $id;die();
		$response = array();
		if ($id) {
			$delete = $this->model_documents->deleteDocument($id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Document Successfully removed";
			} else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the Document information";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

	public function validateFormFile($field_name)
	{
		if (empty($_FILES[$field_name]['name'])) {
			$this->form_validation->set_message('error', 'The ' . $field_name . ' field is required.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function index()
	{
		if (!in_array('createDocuments', $this->permission) || !in_array('updateDocuments', $this->permission) || !in_array('viewDocuments', $this->permission) || !in_array('deleteDocuments', $this->permission))
			redirect('dashboard', 'refresh');
		$this->render_template('documents/index', $this->data);
	}

	public function viewResults($qid)
	{
		if (!in_array('createDocuments', $this->permission) || !in_array('updateDocuments', $this->permission) || !in_array('viewDocuments', $this->permission) || !in_array('deleteDocuments', $this->permission))
			redirect('dashboard', 'refresh');
		$this->data['qid'] = $qid;
		$this->render_template('documents/results', $this->data);
	}
	/**
	 * @author Akash K. Fulari
	 * @date 23-04-2023 
	 * This is new functionality for documents module.
	 **/
	public function loadBatchesByUid($uid)
	{
		$res = array("status" => false, "message" => "");
		if ($uid != null) {
			$subjects = $this->model_subjectnew->getAllocatedBatchesByFacultyId($uid);
			if (sizeof($subjects) > 0) {
				$sel = "";
				foreach ($subjects as $subject) {
					$bid = $subject["bid"];
					$b = $this->model_batch->single_batch($bid);
					if ($b != null)
						$sel .= "<option value='$bid'>" . $b['batch_name'] . "</option>";
				}

				$res['status'] = true;
				$res['message'] = $sel;
			}
		}
		echo json_encode($res);
	}

	public function loadSubjectsByBidAndFacultyId($bid, $fid)
	{
		$res = array("status" => false, "message" => "");
		if ($bid != null) {
			$subjects = $this->model_subjectnew->getSubjectByBatchId($fid, $bid);
			if (sizeof($subjects) > 0) {
				$sel = "<select class='form-control' name='subject' id='subject_id'>";
				foreach ($subjects as $subject) {
					$sel .= "<option value='" . $subject['id'] . "'>" . $subject['subject'] . "</option>";
				}
				$sel .= "</select>";

				$res['status'] = true;
				$res['message'] = $sel;
			}
		}
		echo json_encode($res);
	}
}