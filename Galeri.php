<?php
// bertanggung jawab untuk menampilkan galeri foto dan mengorganisasikannya berdasarkan album
// Saat pengguna mengakses halaman galeri, mereka akan melihat daftar album foto yang tersedia, 
// dan saat mereka memilih sebuah album, mereka akan melihat galeri foto yang terkait dengan album tersebut
class Galeri extends CI_Controller{

	//  fungsi konstruktor yang akan dijalankan setiap kali objek dari kelas Galeri dibuat. 
	// Di dalamnya, dilakukan load model m_galeri untuk mengakses data galeri foto, 
	// load model m_album untuk mengakses data album foto, load model m_pengunjung serta pemanggilan fungsi count_visitor() dari model m_pengunjung untuk menghitung jumlah pengunjung
	function __construct(){
		parent::__construct();
		$this->load->model('m_galeri');
		$this->load->model('m_album');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}

	// dilakukan pengambilan data semua album foto dan data semua galeri foto menggunakan masing-masing model 
	function index(){
		$x['alb']=$this->m_album->get_all_album();
		$x['all_galeri']=$this->m_galeri->get_all_galeri();
		$this->load->view('depan/v_galeri',$x);
	}

	// untuk menampilkan galeri foto berdasarkan album tertentu. Pertama-tama, id album yang dipilih oleh pengguna diambil dari segment URI menggunakan $this->uri->segment(3)
	// Kemudian, dilakukan pengambilan data album foto dan data galeri foto berdasarkan id album tersebut menggunakan method get_all_album() dan get_galeri_by_album_id() dari masing-masing model m_album dan m_galeri
	// Data tersebut dimuat ke dalam view 'depan/v_galeri_per_album' untuk ditampilkan kepada pengguna
	function album(){
		$idalbum=$this->uri->segment(3);
		$x['alb']=$this->m_album->get_all_album();
		$x['data']=$this->m_galeri->get_galeri_by_album_id($idalbum);
		$this->load->view('depan/v_galeri_per_album',$x);
	}
}
