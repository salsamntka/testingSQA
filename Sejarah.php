<?php
// bertanggung jawab dalam menampilkan sejarah ke halaman pengguna
class Sejarah extends CI_Controller{
	function __construct(){
		parent::__construct();
		//  untuk menghitung jumlah pengunjung
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}

	// menampilkan sejarah
	function index(){
		$x['tot_files']=$this->db->get('tbl_files')->num_rows();
		$x['tot_agenda']=$this->db->get('tbl_agenda')->num_rows();
		$this->load->view('depan/v_sejarah',$x);
	}
}