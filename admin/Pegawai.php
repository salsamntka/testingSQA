<?php
class Pegawai extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_pegawai');
		$this->load->model('m_pengguna');
		$this->load->model('m_jabpegawai');
		$this->load->library('upload');
	}


	function index(){
		$x['pegawai']=$this->m_jabpegawai->get_all_pegawaijabatan();
		$x['data']=$this->m_pegawai->get_all_pegawai();
		$this->load->view('admin/v_pegawai',$x);
	}
	
	function simpan_pegawai(){
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
	                        $config['width']= 300;
							// Menentukan tinggi gambar setelah dikompres, dalam piksel
	                        $config['height']= 300;
							// Menentukan lokasi dan nama file untuk menyimpan gambar yang telah dikompres
							// Dalam kasus ini, nama file tetap sama dengan file asli, namun gambar tersebut telah dikompres
	                        $config['new_image']= './assets/images/'.$gbr['file_name'];
	                        $this->load->library('image_lib', $config);
	                        $this->image_lib->resize();

	                        $photo=$gbr['file_name'];
							$nip=strip_tags($this->input->post('xnip'));
							$nama=strip_tags($this->input->post('xnama'));
							$jenkel=strip_tags($this->input->post('xjenkel'));
							$pegawai=strip_tags($this->input->post('xjabatanpegawai'));

							$this->m_pegawai->simpan_pegawai($nip,$nama,$jenkel,$pegawai,$photo);
							echo $this->session->set_flashdata('msg','success');
							redirect('admin/pegawai');
					}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pegawai');
	                }
	                 
	            }else{
	            	$nip=strip_tags($this->input->post('xnip'));
					$nama=strip_tags($this->input->post('xnama'));
					$jenkel=strip_tags($this->input->post('xjenkel'));
					$pegawai=strip_tags($this->input->post('xjabatanpegawai'));
					$this->m_pegawai->simpan_pegawai_tanpa_img($nip,$nama,$jenkel,$pegawai);
					echo $this->session->set_flashdata('msg','success');
					redirect('admin/pegawai');
				}
				
	}
	
	function update_pegawai(){
				
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
	                        $config['width']= 300;
							// Menentukan tinggi gambar setelah dikompres, dalam piksel
	                        $config['height']= 300;
							// Menentukan lokasi dan nama file untuk menyimpan gambar yang telah dikompres
							// Dalam kasus ini, nama file tetap sama dengan file asli, namun gambar tersebut telah dikompres
	                        $config['new_image']= './assets/images/'.$gbr['file_name'];
	                        $this->load->library('image_lib', $config);
	                        $this->image_lib->resize();
	                        $gambar=$this->input->post('gambar');
							$path='./assets/images/'.$gambar;
							unlink($path);

	                        $photo=$gbr['file_name'];
	                        $kode=$this->input->post('kode');
							$nip=strip_tags($this->input->post('xnip'));
							$nama=strip_tags($this->input->post('xnama'));
							$jenkel=strip_tags($this->input->post('xjenkel'));
							$pegawai=strip_tags($this->input->post('xjabatanpegawai'));

							$this->m_pegawai->update_pegawai($kode,$nip,$nama,$jenkel,$pegawai,$photo);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/pegawai');
	                    
	                }else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pegawai');
	                }
	                
	            }else{
							$kode=$this->input->post('kode');
							$nip=strip_tags($this->input->post('xnip'));
							$nama=strip_tags($this->input->post('xnama'));
							$jenkel=strip_tags($this->input->post('xjenkel'));
							$pegawai=strip_tags($this->input->post('xjabatanpegawai'));

							$this->m_pegawai->update_pegawai_tanpa_img($kode,$nip,$nama,$jenkel,$pegawai);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/pegawai');
	            } 

	}

	function hapus_pegawai(){
		$kode=$this->input->post('kode');
		$gambar=$this->input->post('gambar');
		$path='./assets/images/'.$gambar;
		unlink($path);
		$this->m_pegawai->hapus_pegawai($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/pegawai');
	}

}