<?php
// menangani halaman kontak dan pengiriman pesan melalui formulir kontak
class Contact extends CI_Controller{
  function __construct(){
		parent::__construct();
      $this->load->model('m_kontak');
      $this->load->model('m_pengunjung');
  		$this->m_pengunjung->count_visitor();
	}
	function index(){
		  $this->load->view('depan/v_contact');
	}

  // digunakan untuk menangani proses pengiriman pesan melalui formulir kontak
  // Pertama-tama, data yang dimasukkan oleh pengguna (nama, email, kontak, pesan) diambil menggunakan $this->input->post() dan 
  // kemudian disanitasi menggunakan fungsi htmlspecialchars() dengan parameter ENT_QUOTES untuk mencegah injeksi skrip
  // Setelah itu, data yang sudah disanitasi tersebut dikirim ke model m_kontak menggunakan method kirim_pesan(). 
  // Setelah pesan berhasil terkirim, pesan notifikasi diset menggunakan flashdata() dan pengguna diarahkan kembali ke halaman kontak menggunakan redirect()
  function kirim_pesan(){
      $nama=htmlspecialchars($this->input->post('xnama',TRUE),ENT_QUOTES);
      $email=htmlspecialchars($this->input->post('xemail',TRUE),ENT_QUOTES);
      $kontak=htmlspecialchars($this->input->post('xphone',TRUE),ENT_QUOTES);
      $pesan=htmlspecialchars($this->input->post('xmessage',TRUE),ENT_QUOTES);
      $this->m_kontak->kirim_pesan($nama,$email,$kontak,$pesan);
      echo $this->session->set_flashdata('msg','<p><strong> NB: </strong> Terima Kasih Telah Menghubungi Kami.</p>');
      redirect('contact');
  }
}
