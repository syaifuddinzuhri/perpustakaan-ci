<?php

class Buku extends CI_Controller
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
		$data['main_content'] = 'buku/index';
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
		$query = $this->db->get("buku");
		$data['data'] = $query->result();
		$data['total'] = $this->db->count_all("buku");
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
		$this->form_validation->set_rules('judul', 'Judul', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('penerbit', 'Penerbit', 'required');
		$this->form_validation->set_rules('penulis', 'Penulis', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->insert('buku', $insert);
			$id = $this->db->insert_id();
			$q = $this->db->get_where('buku', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'judul_error' => form_error('judul'),
					'jumlah_error' => form_error('jumlah'),
					'penerbit_error' => form_error('penerbit'),
					'penulis_error' => form_error('penulis'),
					'tahun_error' => form_error('tahun'),
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
		$q = $this->db->get_where('buku', array('id' => $id));
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
		$this->form_validation->set_rules('judul', 'Judul', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('penerbit', 'Penerbit', 'required');
		$this->form_validation->set_rules('penulis', 'Penulis', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->where('id', $id);
			$this->db->update('buku', $insert);
			$q = $this->db->get_where('buku', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'judul_error' => form_error('judul'),
					'jumlah_error' => form_error('jumlah'),
					'penerbit_error' => form_error('penerbit'),
					'penulis_error' => form_error('penulis'),
					'tahun_error' => form_error('tahun'),
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
		$this->db->delete('buku');
		echo json_encode(['success' => true]);
	}
}
