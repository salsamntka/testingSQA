<?php
class Komentar extends CI_Controller{
    function __construct(){
    	parent::__construct();
    	if($this->session->userdata('masuk') !=TRUE){
              $url=base_url('administrator');
              redirect($url);
          };
    	$this->load->model('m_kategori');
    }

    function index(){
        $x['data']=$this->db->query("SELECT tbl_komentar.*,tulisan_judul,tulisan_slug FROM tbl_komentar JOIN tbl_tulisan ON komentar_tulisan_id=tulisan_id ORDER BY komentar_id DESC");
        $this->load->view('author/v_komentar',$x);
    }

    function publish(){
        $kode = htmlspecialchars($this->uri->segment(4),ENT_QUOTES);
        $this->db->query("UPDATE tbl_komentar SET komentar_status='1' WHERE komentar_id='$kode'");
        echo $this->session->set_flashdata('msg','success');
        redirect('author/komentar');
    }

    function reply(){
        // Mengambil id komentar yang akan dijawab dari input post dengan nama 'komenid'. Fungsi htmlspecialchars() digunakan untuk mengonversi karakter khusus HTML menjadi entitas HTML untuk mencegah serangan XSS (Cross-Site Scripting)
        $komentar_id = htmlspecialchars($this->input->post('komenid'),ENT_QUOTES);
        //  Mengambil nama pengguna dari session
        $nama = $this->session->userdata('nama');
        // Mengambil id tulisan yang dikomentari dari input post dengan nama 'postid'
        // Fungsi htmlspecialchars() juga digunakan di sini untuk alasan keamanan
        $tulisan_id = htmlspecialchars($this->input->post('postid'),ENT_QUOTES);
        // Mengambil isi komentar dari input post dengan nama 'komentar'. Fungsi htmlspecialchars() digunakan untuk mengonversi karakter khusus HTML menjadi entitas HTML
        // sementara nl2br() digunakan untuk mengganti karakter newline (\n) menjadi tag <br> agar teks dapat ditampilkan dengan format baris baru yang sesuai di HTML
        $komentar = nl2br(htmlspecialchars($this->input->post('komentar',TRUE),ENT_QUOTES));
        $data = array(
            'komentar_nama' 			=> $nama,
            'komentar_email' 			=> '',
            'komentar_isi' 				=> $komentar,
            'komentar_status' 		=> 1,
            'komentar_tulisan_id' => $tulisan_id,
            'komentar_parent'     => $komentar_id
        );

        $this->db->insert('tbl_komentar', $data);
        echo $this->session->set_flashdata('msg','info');
        redirect('author/komentar');
    }

    function hapus(){
  		$kode=$this->input->post('kode');
  		$this->db->delete('tbl_komentar', array('komentar_id' => $kode));
  		echo $this->session->set_flashdata('msg','success-hapus');
  		redirect('author/komentar');
  	}
}
