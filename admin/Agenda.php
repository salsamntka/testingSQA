<?php
class Agenda extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_agenda');
		$this->load->model('m_pengguna');
		$this->load->library('upload');
	}

	function index(){
		$x['data']=$this->m_agenda->get_all_agenda();
		$this->load->view('admin/v_agenda',$x);
	}

	function simpan_agenda(){
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

					$foto=$gbr['file_name'];
					$nama_agenda=strip_tags($this->input->post('xnama_agenda'));
					$deskripsi=$this->input->post('xdeskripsi');
					$mulai=$this->input->post('xmulai');
					$selesai=$this->input->post('xselesai');
					$tempat=$this->input->post('xtempat');
					$waktu=$this->input->post('xwaktu');

					$this->m_agenda->simpan_agenda($foto,$nama_agenda,$deskripsi,$mulai,$selesai,$tempat,$waktu);
					echo $this->session->set_flashdata('msg','success');
					redirect('admin/agenda');
			}else{
				echo $this->session->set_flashdata('msg','warning');
				redirect('admin/agenda');
			}
			 
		}else{
		$nama_agenda=strip_tags($this->input->post('xnama_agenda'));
		$deskripsi=strip_tags($this->input->post('xdeskripsi'));
		$mulai=strip_tags($this->input->post('xmulai'));
		$selesai=strip_tags($this->input->post('xselesai'));
		$tempat=strip_tags($this->input->post('xtempat'));
		$waktu=strip_tags($this->input->post('xwaktu'));

		$this->m_agenda->simpan_agenda_tanpa_img($nama_agenda,$deskripsi,$mulai,$selesai,$tempat,$waktu);
		echo $this->session->set_flashdata('msg','success');
		redirect('admin/agenda');
		}
	}

	function update_agenda(){
				
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

					$foto=$gbr['file_name'];
					$kode=$this->input->post('kode');
					$nama_agenda=strip_tags($this->input->post('xnama_agenda'));
					$deskripsi=$this->input->post('xdeskripsi');
					$mulai=$this->input->post('xmulai');
					$selesai=$this->input->post('xselesai');
					$tempat=$this->input->post('xtempat');
					$waktu=$this->input->post('xwaktu');

					$this->m_agenda->update_agenda($kode,$foto,$nama_agenda,$deskripsi,$mulai,$selesai,$tempat,$waktu);
					echo $this->session->set_flashdata('msg','info');
					redirect('admin/agenda');
				
			}else{
				echo $this->session->set_flashdata('msg','warning');
				redirect('admin/agenda');
			}
			
		}
		else{
		$kode=strip_tags($this->input->post('kode'));
		$nama_agenda=strip_tags($this->input->post('xnama_agenda'));
		$deskripsi=strip_tags($this->input->post('xdeskripsi'));
		$mulai=strip_tags($this->input->post('xmulai'));
		$selesai=strip_tags($this->input->post('xselesai'));
		$tempat=strip_tags($this->input->post('xtempat'));
		$waktu=strip_tags($this->input->post('xwaktu'));

		$this->m_agenda->update_agenda_tanpa_img($kode,$nama_agenda,$deskripsi,$mulai,$selesai,$tempat,$waktu);
		echo $this->session->set_flashdata('msg','info');
		redirect('admin/agenda');
		}
	}
	
	function hapus_agenda(){
		$kode=strip_tags($this->input->post('kode'));
		$gambar=$this->input->post('gambar');
		$path='./assets/images/'.$gambar;
		unlink($path);
		$this->m_agenda->hapus_agenda($kode);
		echo $this->session->set_flashdata('msg','success-hapus');
		redirect('admin/agenda');
	}

}
