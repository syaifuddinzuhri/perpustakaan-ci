<?php

class Peminjaman extends CI_Controller
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
		$mhs = $this->db->get("mahasiswa");
		$buku = $this->db->get("buku");
		$data['data_mhs'] = $mhs->result();
		$data['data_buku'] = $buku->result();
		$data['main_content'] = 'peminjaman/index';
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
		$this->db->select('peminjaman.*, mahasiswa.nama as nama_mhs, buku.judul as judul_buku')
			->from('peminjaman')
			->join('buku', 'buku.id = peminjaman.buku_id')
			->join('mahasiswa', 'mahasiswa.id = peminjaman.mhs_id');
		$result = $this->db->get();
		$data['data'] = $result->result_array();
		$data['total'] = $result->num_rows();
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
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('mhs_id', 'Mahasiswa', 'required');
		$this->form_validation->set_rules('buku_id', 'Buku', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->insert('peminjaman', $insert);
			$id = $this->db->insert_id();
			$q = $this->db->get_where('peminjaman', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'tgl_pinjam_error' => form_error('tgl_pinjam'),
					'tgl_kembali_error' => form_error('tgl_kembali'),
					'jumlah_error' => form_error('jumlah'),
					'jumlah_error' => form_error('jumlah'),
					'mhs_id_error' => form_error('mhs_id'),
					'buku_id_error' => form_error('buku_id'),
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
		$q = $this->db->get_where('peminjaman', array('id' => $id));
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
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('mhs_id', 'Mahasiswa', 'required');
		$this->form_validation->set_rules('buku_id', 'Buku', 'required');
		if ($this->form_validation->run()) {
			$insert = $this->input->post();
			$this->db->where('id', $id);
			$this->db->update('peminjaman', $insert);
			$q = $this->db->get_where('peminjaman', array('id' => $id));
			echo json_encode(array(
				'status' => true,
				'data' => $q->row()
			));
		} else {
			$array = array(
				'status'   => false,
				'message' => 'Data tidak valid',
				'errors' => array(
					'tgl_pinjam_error' => form_error('tgl_pinjam'),
					'tgl_kembali_error' => form_error('tgl_kembali'),
					'jumlah_error' => form_error('jumlah'),
					'jumlah_error' => form_error('jumlah'),
					'mhs_id_error' => form_error('mhs_id'),
					'buku_id_error' => form_error('buku_id'),
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
		$this->db->delete('peminjaman');
		echo json_encode(['success' => true]);
	}
}
