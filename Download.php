<?php
// bertanggung jawab untuk menampilkan daftar file yang tersedia dan memungkinkan pengguna untuk mengunduh file-file tersebut
// Saat pengguna memilih untuk mengunduh file, controller ini mengambil file dari server dan mengirimkannya kepada pengguna untuk diunduh
class Download extends CI_Controller{
	// dijalankan setiap kali objek dari kelas Download dibuat. Di dalamnya, dilakukan load model m_files untuk mengakses data file dari database, 
	// load helper download untuk fungsi unduh file, dan load model m_pengunjung serta pemanggilan fungsi count_visitor() dari model m_pengunjung untuk menghitung jumlah pengunjung
	function __construct(){
		parent::__construct();
		$this->load->model('m_files');
		$this->load->helper('download');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}

	// pengambilan data file dari database menggunakan model m_files, 
	// kemudian data tersebut dimuat ke dalam view 'depan/v_download' untuk ditampilkan kepada pengguna
	function index(){
		$x['data']=$this->m_files->get_all_files();
		$this->load->view('depan/v_download',$x);
	}

	// digunakan untuk menangani proses unduhan file 
	// Pertama-tama, id file yang akan diunduh diambil dari segment URI menggunakan $this->uri->segment(3)
	// Kemudian, dilakukan pengambilan data file dari database berdasarkan id tersebut menggunakan method get_file_byid() dari model m_files
	// Setelah itu, path file diatur berdasarkan nama file yang diperoleh dari hasil query, dan data file diambil menggunakan file_get_contents()
	// Terakhir, menggunakan fungsi force_download() dari helper download, file akan didownload dengan nama yang sesuai
	function get_file(){
		$id=$this->uri->segment(3);
		$get_db=$this->m_files->get_file_byid($id);
		$q=$get_db->row_array();
		$file=$q['file_data'];
		$path='./assets/files/'.$file;
		$data = file_get_contents($path);
		$name = $file;
		force_download($name, $data);
	}

}
