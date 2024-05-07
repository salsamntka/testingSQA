<?php
// bertanggung jawab untuk menampilkan daftar pejabat dengan menggunakan fitur pagination
// Saat pengguna mengakses halaman pejabat, mereka akan melihat daftar pejabat yang ditampilkan per halaman sesuai dengan jumlah pejabat yang ditentukan
class Pejabat extends CI_Controller{
	// fungsi konstruktor yang akan dijalankan setiap kali objek dari kelas pejabat dibuat. Di dalamnya, dilakukan load model m_pejabat untuk mengakses data pejabat
	// load model m_pengunjung untuk mengakses data pengunjung, serta pemanggilan fungsi count_visitor() dari model m_pengunjung untuk menghitung jumlah pengunjung
	function __construct(){
		parent::__construct();
		$this->load->model('m_pejabat');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}

	// method untuk menampilkan halaman pejabat
	function index(){
		// memanggil metod pejabat dan disimpan di variabel $jum
		$jum=$this->m_pejabat->pejabat();
		// untuk menentukan halaman yang sedang aktif
        $page=$this->uri->segment(3);
		// kondisi yang mengecek apakah $page memiliki nilai atau tidak
		// jika tidak maka halaman pertama sedang ditampilkan dan nilainya 0
        if(!$page):
            $offset = 0;
			// // jika variabel $page memiliki nilai maka satu halaman menampilkan 8 pejabat per halaman
        else:
            $offset = $page;
        endif;
        $limit=8;
        $config['base_url'] = base_url() . 'pejabat/index/';
            $config['total_rows'] = $jum->num_rows();
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
						$x['data']=$this->m_pejabat->pejabat_perpage($offset,$limit);
						$this->load->view('depan/v_pejabat',$x);
	}

}
