<?php
class Dashboard extends CI_Controller{
	// function __construct(){
	// 	parent::__construct();
	// 	if($this->session->userdata('masuk') !=TRUE){
    //         $url=base_url('administrator');
    //         redirect($url);
    //     };
	// 	$this->load->model('m_pengguna');
	// 	$this->load->library('upload');
	// }


	function index(){
		// $kode=$this->session->userdata('idadmin');
		// $x['user']=$this->m_pengguna->get_pengguna_login($kode);
		// $x['data']=$this->m_pengguna->get_all_pengguna();
		$this->load->view('author/v_index');
	}
}