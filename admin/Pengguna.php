<?php
class Pengguna extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('administrator');
            redirect($url);
        };
		$this->load->model('m_pengguna');
		$this->load->library('upload');
	}


	function index(){
		$kode=$this->session->userdata('idadmin');
		$x['user']=$this->m_pengguna->get_pengguna_login($kode);
		$x['data']=$this->m_pengguna->get_all_pengguna();
		$this->load->view('admin/v_pengguna',$x);
	}

	function simpan_pengguna(){
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

	                        $gambar=$gbr['file_name'];
	                        $nama=$this->input->post('xnama');
	                        $jenkel=$this->input->post('xjenkel');
	                        $username=$this->input->post('xusername');
	                        $password=$this->input->post('xpassword');
                            $konfirm_password=$this->input->post('xpassword2');
                            $email=$this->input->post('xemail');
                            $nohp=$this->input->post('xkontak');
							$level=$this->input->post('xlevel');
     						if ($password <> $konfirm_password) {
     							echo $this->session->set_flashdata('msg','error');
	               				redirect('admin/pengguna');
     						}else{
	               				$this->m_pengguna->simpan_pengguna($nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar);
	                    		echo $this->session->set_flashdata('msg','success');
	               				redirect('admin/pengguna');
	               				
	               			}
	                    
	                }else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pengguna');
	                }
	                 
	            }else{
	            	$nama=$this->input->post('xnama');
	                $jenkel=$this->input->post('xjenkel');
	                $username=$this->input->post('xusername');
	                $password=$this->input->post('xpassword');
                    $konfirm_password=$this->input->post('xpassword2');
                    $email=$this->input->post('xemail');
                    $nohp=$this->input->post('xkontak');
					$level=$this->input->post('xlevel');
	            	if ($password <> $konfirm_password) {
     					echo $this->session->set_flashdata('msg','error');
	               		redirect('admin/pengguna');
     				}else{
	               		$this->m_pengguna->simpan_pengguna_tanpa_gambar($nama,$jenkel,$username,$password,$email,$nohp,$level);
	                    echo $this->session->set_flashdata('msg','success');
	               		redirect('admin/pengguna');
	               	}
	            } 

	}

	function update_pengguna(){
				
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
							// Menentukan lebar gambar setelah dikompres, dalam piksel
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

	                        $gambar=$gbr['file_name'];
	                        $kode=$this->input->post('kode');
	                        $nama=$this->input->post('xnama');
	                		$jenkel=$this->input->post('xjenkel');
	                		$username=$this->input->post('xusername');
	                		$password=$this->input->post('xpassword');
                    		$konfirm_password=$this->input->post('xpassword2');
                    		$email=$this->input->post('xemail');
                    		$nohp=$this->input->post('xkontak');
							$level=$this->input->post('xlevel');
                            if (empty($password) && empty($konfirm_password)) {
                            	$this->m_pengguna->update_pengguna_tanpa_pass($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar);
	                    		echo $this->session->set_flashdata('msg','info');
	               				redirect('admin/pengguna');
     						}elseif ($password <> $konfirm_password) {
     							echo $this->session->set_flashdata('msg','error');
	               				redirect('admin/pengguna');
     						}else{
	               				$this->m_pengguna->update_pengguna($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar);
	                    		echo $this->session->set_flashdata('msg','info');
	               				redirect('admin/pengguna');
	               			}
	                    
	                }else{
	                    echo $this->session->set_flashdata('msg','warning');
	                    redirect('admin/pengguna');
	                }
	                
	            }else{
	            	$kode=$this->input->post('kode');
	            	$nama=$this->input->post('xnama');
	                $jenkel=$this->input->post('xjenkel');
	                $username=$this->input->post('xusername');
	                $password=$this->input->post('xpassword');
                    $konfirm_password=$this->input->post('xpassword2');
                    $email=$this->input->post('xemail');
                    $nohp=$this->input->post('xkontak');
					$level=$this->input->post('xlevel');
	            	if (empty($password) && empty($konfirm_password)) {
                       	$this->m_pengguna->update_pengguna_tanpa_pass_dan_gambar($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level);
	                    echo $this->session->set_flashdata('msg','info');
	               		redirect('admin/pengguna');
     				}elseif ($password <> $konfirm_password) {
     					echo $this->session->set_flashdata('msg','error');
	               		redirect('admin/pengguna');
     				}else{
	               		$this->m_pengguna->update_pengguna_tanpa_gambar($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level);
	                    echo $this->session->set_flashdata('msg','warning');
	               		redirect('admin/pengguna');
	               	}
	            } 

	}

	function hapus_pengguna(){
		$kode=$this->input->post('kode');
		$data=$this->m_pengguna->get_pengguna_login($kode);
		$q=$data->row_array();
		$p=$q['pengguna_photo'];
		$path=base_url().'assets/images/'.$p;
		delete_files($path);
		$this->m_pengguna->hapus_pengguna($kode);
	    echo $this->session->set_flashdata('msg','success-hapus');
	    redirect('admin/pengguna');
	}

	function reset_password(){
   
        $id=$this->uri->segment(4);
        $get=$this->m_pengguna->getusername($id);
        if($get->num_rows()>0){
            $a=$get->row_array();
            $b=$a['pengguna_username'];
        }
        $pass=rand(123456,999999);
        $this->m_pengguna->resetpass($id,$pass);
        echo $this->session->set_flashdata('msg','show-modal');
        echo $this->session->set_flashdata('uname',$b);
        echo $this->session->set_flashdata('upass',$pass);
	    redirect('admin/pengguna');
   
    }


}