<?php
class Login extends CI_Controller{
    function __construct(){
        parent:: __construct();
        $this->load->model('m_login');
    }

    function index(){
        $this->load->view('admin/v_login');
    }

    // mendapatkan data username dan password dari inputan form
    function auth(){
        $username=strip_tags(str_replace("'", "", $this->input->post('username')));
        $password=strip_tags(str_replace("'", "", $this->input->post('password')));
        $u=$username;
        $p=$password;

        // melakukan validasi login dengan memanggil method cekadmin dari model m_login
        $cadmin=$this->m_login->cekadmin($u,$p);
        // untuk debugging
        // echo json_encode($cadmin);
        // jika data pengguna ditemukan, maka set session dan redirect ke dashboard
        if($cadmin->num_rows() > 0){
         $this->session->set_userdata('masuk',true);
         $this->session->set_userdata('user',$u);
         $xcadmin=$cadmin->row_array();
         if($xcadmin['pengguna_level']=='1'){
            $this->session->set_userdata('akses','1');
            $idadmin=$xcadmin['pengguna_id'];
            $user_nama=$xcadmin['pengguna_nama'];
            $this->session->set_userdata('idadmin',$idadmin);
            $this->session->set_userdata('nama',$user_nama);
            redirect('admin/dashboard');
         }else{
             $this->session->set_userdata('akses','2');
             $idadmin=$xcadmin['pengguna_id'];
             $user_nama=$xcadmin['pengguna_nama'];
             $this->session->set_userdata('idadmin',$idadmin);
             $this->session->set_userdata('nama',$user_nama);
             redirect('author/dashboard');
         }

       }else{
         echo $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert"><span class="fa fa-close"></span></button> Username Atau Password Salah</div>');
         redirect('admin/login');
       }

    }

    function logout(){
        // menghapus semua session pengguna menggunakan sess_destroy()
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
