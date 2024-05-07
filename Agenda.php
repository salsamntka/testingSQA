<?php
// controller ini bertanggung jawab untuk menampilkan halaman agenda 
// dengan menggunakan data yang diambil dari model dan mengatur proses pagination untuk tampilan halaman tersebut
class Agenda extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_agenda');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}

	// method untuk menampilkan halaman agenda
	function index(){
		// memanggil metod agenda dan disimpan di variabel $jum
		$jum=$this->m_agenda->agenda();
		// untuk menentukan halaman yang sedang aktif
        $page=$this->uri->segment(3);
		// kondisi yang mengecek apaka $page memiliki nilai atau tidak
		// jika tidak maka halaman pertama sedang ditampilkan dan nilainya 0
        if(!$page):
            $offset = 0;
		// jika variabel $page memiliki nilai maka satu halaman menampilkan 7 agenda per halaman
        else:
            $offset = $page;
        endif;
        $limit=7;
		// konfigurasi untuk URL dasar dari halaman agenda
        $config['base_url'] = base_url() . 'agenda/index/';
		// konfigurasi untuk jumlah total baris data yang akan ditampilkan dalam pagination
		// Jumlah ini diambil dari hasil perhitungan jumlah data agenda yang telah diambil dari database
            $config['total_rows'] = $jum->num_rows();
			//  konfigurasi untuk jumlah data yang akan ditampilkan per halaman
            $config['per_page'] = $limit;
            $config['uri_segment'] = 3;
						//Tambahan untuk styling
	          $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
	          $config['full_tag_close']   = '</ul></nav></div>';
	          $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
	          $config['num_tag_close']    = '</span></li>';
	          $config['cur_tag_open']     = '<li class="page-item"><span class="page-link">';
	          $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
	          $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
	          $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
	          $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
	          $config['prev_tagl_close']  = '</span>Next</li>';
	          $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
	          $config['first_tagl_close'] = '</span></li>';
	          $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
	          $config['last_tagl_close']  = '</span></li>';
            $config['first_link'] = 'Awal';
            $config['last_link'] = 'Akhir';
            $config['next_link'] = 'Next >>';
            $config['prev_link'] = '<< Prev';
            $this->pagination->initialize($config);
            $x['page'] =$this->pagination->create_links();
		$x['data']=$this->m_agenda->agenda_perpage($offset,$limit);
		$this->load->view('depan/v_agenda',$x);
	}

}
