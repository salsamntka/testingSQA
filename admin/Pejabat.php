<?php
class Pejabat extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_pejabat');
		$this->load->model('m_pengguna');
		$this->load->library('upload');
	}


	function index(){
		$x['data']=$this->m_pejabat->get_all_pejabat();
		$this->load->view('admin/v_pejabat',$x);
	}
	
	function simpan_pejabat(){
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
							$jabpejabat=strip_tags($this->input->post('xjab'));

							$this->m_pejabat->simpan_pejabat($nip,$nama,$jenkel,$jabpejabat,$photo);
							echo $this->session->set_flashdata('msg','success');
							redirect('admin/pejabat');
					}else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pejabat');
	                }
	                 
	            }else{
	            	$nip=strip_tags($this->input->post('xnip'));
					$nama=strip_tags($this->input->post('xnama'));
					$jenkel=strip_tags($this->input->post('xjenkel'));
					$jabpejabat=strip_tags($this->input->post('xjab'));

					$this->m_pejabat->simpan_pejabat_tanpa_img($nip,$nama,$jenkel,$jabpejabat);
					echo $this->session->set_flashdata('msg','success');
					redirect('admin/pejabat');
				}
				
	}
	
	function update_pejabat(){
				
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
							$jabpejabat=strip_tags($this->input->post('xjab'));

							$this->m_pejabat->update_pejabat($kode,$nip,$nama,$jenkel,$jabpejabat,$photo);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/pejabat');
	                    
	                }else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pejabat');
	                }
	                
	            }else{
							$kode=$this->input->post('kode');
							$nip=strip_tags($this->input->post('xnip'));
							$nama=strip_tags($this->input->post('xnama'));
							$jenkel=strip_tags($this->input->post('xjenkel'));
							$jabpejabat=strip_tags($this->input->post('xjab'));
							$this->m_pejabat->update_pejabat_tanpa_img($kode,$nip,$nama,$jenkel,$jabpejabat);
							echo $this->session->set_flashdata('msg','info');
							redirect('admin/pejabat');
	            } 

	}

	function hapus_pejabat(){
		$kode=$this->input->post('kode');
		$gambar=$this->input->post('gambar');
		$path='./assets/images/'.$gambar;
		unlink($path);
		$this->m_pejabat->hapus_pejabat($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/pejabat');
	}

}