<?php
class Blog extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_tulisan');
		$this->load->model('m_pengguna');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_tulisan->get_all_tulisan();
		$this->load->view('author/v_blog',$x);
	}
	
	function get_edit(){
		$x['data']=$this->m_tulisan->get_all();
		$x['kat']=$this->m_kategori->get_all_kategori();
		$this->load->view('author/v_edit_blog',$x);
	}

	function simpan_tulisan(){
				$config['upload_path'] = './assets/images/'; 
	            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; 
	            $config['encrypt_name'] = TRUE; 

	            $this->upload->initialize($config);
	            if(!empty($_FILES['filefoto']['name']))
	            {
	                if ($this->upload->do_upload('filefoto'))
	                {
	                        $gbr = $this->upload->data();
	                        // Compress Image dengan tujuan  mengurangi ukuran file gambar yang diunggah tanpa mengorbankan kualitas gambar yang signifikan
							// Proses kompresi ini dapat membantu mengurangi waktu pengunduhan dan menghemat ruang penyimpanan di server
	                       
							// menggunakan GD2 untuk melakukan proses pengolahan gambar
							$config['image_library']='gd2';
							// Menentukan path dari gambar yang akan diolah, diambil dari hasil unggahan gambar sebelumnya
	                        $config['source_image']='./assets/images/'.$gbr['file_name'];
	                        $config['create_thumb']= FALSE;
	                        $config['maintain_ratio']= FALSE;
							// Menentukan kualitas kompresi gambar sebagai 60% yang merupakan tingkat kualitas yang cukup baik dengan ukuran file yang lebih kecil
	                        $config['quality']= '60%';
							// Menentukan lebar gambar setelah dikompres, dalam piksel
	                        $config['width']= 710;
							// Menentukan tinggi gambar setelah dikompres, dalam piksel
	                        $config['height']= 460;
							// Menentukan lokasi dan nama file untuk menyimpan gambar yang telah dikompres
							// Dalam kasus ini, nama file tetap sama dengan file asli, namun gambar tersebut telah dikompres
	                        $config['new_image']= './assets/images/'.$gbr['file_name'];
	                        $this->load->library('image_lib', $config);
	                        $this->image_lib->resize();

	                        $gambar=$gbr['file_name'];
													$judul=strip_tags($this->input->post('xjudul'));
													$isi=$this->input->post('xisi');
													$string   = preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $judul);
													$trim     = trim($string);
													$slug     = strtolower(str_replace(" ", "-", $trim));
													$kategori_id=strip_tags($this->input->post('xkategori'));
													$data=$this->m_kategori->get_kategori_byid($kategori_id);
													$q=$data->row_array();
													$kategori_nama=$q['kategori_nama'];
													//$imgslider=$this->input->post('ximgslider');
													$imgslider='0';
													$kode=$this->session->userdata('idadmin');
													$user=$this->m_pengguna->get_pengguna_login($kode);
													$p=$user->row_array();
													$user_id=$p['pengguna_id'];
													$user_nama=$p['pengguna_nama'];
													$this->m_tulisan->simpan_tulisan($judul,$isi,$kategori_id,$kategori_nama,$imgslider,$user_id,$user_nama,$gambar,$slug);
													echo $this->session->set_flashdata('msg','success');
													redirect('author/blog');
											}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('author/blog');
	                }

	            }else{
					redirect('author/blog');
				}

	}

	function update_tulisan(){

	            $config['upload_path'] = './assets/images/';
	            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
	            $config['encrypt_name'] = TRUE;

	            $this->upload->initialize($config);
	            if(!empty($_FILES['filefoto']['name']))
	            {
	                if ($this->upload->do_upload('filefoto'))
	                {
	                        $gbr = $this->upload->data();
	                        // Compress Image dengan tujuan  mengurangi ukuran file gambar yang diunggah tanpa mengorbankan kualitas gambar yang signifikan
							// Proses kompresi ini dapat membantu mengurangi waktu pengunduhan dan menghemat ruang penyimpanan di server
	                       
							// menggunakan GD2 untuk melakukan proses pengolahan gambar
	                        $config['image_library']='gd2';
							// Menentukan path dari gambar yang akan diolah, diambil dari hasil unggahan gambar sebelumnya
	                        $config['source_image']='./assets/images/'.$gbr['file_name'];
	                        $config['create_thumb']= FALSE;
	                        $config['maintain_ratio']= FALSE;
							// Menentukan kualitas kompresi gambar sebagai 60% yang merupakan tingkat kualitas yang cukup baik dengan ukuran file yang lebih kecil
	                        $config['quality']= '60%';
							// Menentukan lebar gambar setelah dikompres, dalam piksel
	                        $config['width']= 710;
							// Menentukan tinggi gambar setelah dikompres, dalam piksel
	                        $config['height']= 460;
							// Menentukan lokasi dan nama file untuk menyimpan gambar yang telah dikompres
							// Dalam kasus ini, nama file tetap sama dengan file asli, namun gambar tersebut telah dikompres
	                        $config['new_image']= './assets/images/'.$gbr['file_name'];
	                        $this->load->library('image_lib', $config);
	                        $this->image_lib->resize();

	                        $gambar=$gbr['file_name'];
	                        $tulisan_id=$this->input->post('kode');
	                        $judul=strip_tags($this->input->post('xjudul'));
													$isi=$this->input->post('xisi');
													$string   = preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $judul);
													$trim     = trim($string);
													$slug     = strtolower(str_replace(" ", "-", $trim));
													$kategori_id=strip_tags($this->input->post('xkategori'));
													$data=$this->m_kategori->get_kategori_byid($kategori_id);
													$q=$data->row_array();
													$kategori_nama=$q['kategori_nama'];
													//$imgslider=$this->input->post('ximgslider');
													$imgslider='0';
													$kode=$this->session->userdata('idadmin');
													$user=$this->m_pengguna->get_pengguna_login($kode);
													$p=$user->row_array();
													$user_id=$p['pengguna_id'];
													$user_nama=$p['pengguna_nama'];
													$this->m_tulisan->update_tulisan($tulisan_id,$judul,$isi,$kategori_id,$kategori_nama,$imgslider,$user_id,$user_nama,$gambar,$slug);
													echo $this->session->set_flashdata('msg','info');
													redirect('author/blog/get_edit');

	                }else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('author/blog/get_edit');
	                }

	            }else{
									$tulisan_id=$this->input->post('kode');
									$judul=strip_tags($this->input->post('xjudul'));
									$isi=$this->input->post('xisi');
									$string   = preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $judul);
									$trim     = trim($string);
									$slug     = strtolower(str_replace(" ", "-", $trim));
									$kategori_id=strip_tags($this->input->post('xkategori'));
									$data=$this->m_kategori->get_kategori_byid($kategori_id);
									$q=$data->row_array();
									$kategori_nama=$q['kategori_nama'];
									//$imgslider=$this->input->post('ximgslider');
									$imgslider='0';
									$kode=$this->session->userdata('idadmin');
									$user=$this->m_pengguna->get_pengguna_login($kode);
									$p=$user->row_array();
									$user_id=$p['pengguna_id'];
									$user_nama=$p['pengguna_nama'];
									$this->m_tulisan->update_tulisan_tanpa_img($tulisan_id,$judul,$isi,$kategori_id,$kategori_nama,$imgslider,$user_id,$user_nama,$slug);
									echo $this->session->set_flashdata('msg','info');
									redirect('author/blog/get_edit');
	            }

	}

	function hapus_tulisan(){
		$kode=$this->input->post('kode');
		$gambar=$this->input->post('gambar');
		$path='./assets/images/'.$gambar;
		unlink($path);
		$this->m_tulisan->hapus_tulisan($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('author/blog/get_edit');
	}

	function update_approve($tulisan_id) {
        $this->m_tulisan->update_approve($tulisan_id);
        redirect('author/blog'); 
    }

	
}