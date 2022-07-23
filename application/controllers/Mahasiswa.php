<?php

class Mahasiswa extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data['main_content'] = 'mahasiswa/index';
		$this->load->view('master', $data);
	}

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function getAll()
	{
		$this->load->database();
		$query = $this->db->get("mahasiswa");
		$data['data'] = $query->result();
		$data['total'] = $this->db->count_all("mahasiswa");
		echo json_encode($data);
	}


	/**
	 * Store Data from this method.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->load->database();
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->insert('mahasiswa', $insert);
			$id = $this->db->insert_id();
			$q = $this->db->get_where('mahasiswa', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'email_error' => form_error('email'),
					'nama_error' => form_error('nama'),
					'jurusan_error' => form_error('jurusan'),
				),
			);
			echo json_encode($array);
		}
	}


	/**
	 * Edit Data from this method.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$this->load->database();
		$q = $this->db->get_where('mahasiswa', array('id' => $id));
		echo json_encode($q->row());
	}


	/**
	 * Update Data from this method.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$this->load->database();
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->where('id', $id);
			$this->db->update('mahasiswa', $insert);
			$q = $this->db->get_where('mahasiswa', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'email_error' => form_error('email'),
					'nama_error' => form_error('nama'),
					'jurusan_error' => form_error('jurusan'),
				),
			);
			echo json_encode($array);
		}
	}


	/**
	 * Delete Data from this method.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->delete('mahasiswa');
		echo json_encode(['success' => true]);
	}
}
