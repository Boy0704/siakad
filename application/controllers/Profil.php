<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller
{

	var $title = "Profil";

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$id_users = $this->session->userdata('id_users');
		if ($this->session->userdata('level') != '')
		{
			$data['title']     = $this->title;
			$this->template->load('template', 'profil',$data);

			if(isset($_POST['submit']))
			{
					$password = $this->input->post('password');
					$password2 = $this->input->post('password2');

					$simpan = 'y';
					$lokasi = 'images/users';
					$file_size = 1024 * 3; // 3 MB
					$this->upload->initialize(array(
						"file_type"     => "image/jpeg",
						"upload_path"   => "./$lokasi",
						"allowed_types" => "jpg|jpeg|png",
						"max_size" => "$file_size"
					));

					$cek_foto = $this->db->get_where('app_users',"id_users='$id_users'")->row()->foto;
					if ($_FILES['foto']['error'] <> 4) {
							if ( ! $this->upload->do_upload('foto'))
							{
									$simpan = 'n';
									$pesan  = $this->upload->display_errors('<p>', '</p>');
							}
							 else
							{
								if ($cek_foto != '') {
										unlink($cek_foto);
								}
										$gbr = $this->upload->data();
										$filename = "$lokasi/".$gbr['file_name'];
										$foto = preg_replace('/ /', '_', $filename);
										$simpan = 'y';
							}
					}else {
						$foto   = $cek_foto;
						$simpan = 'y';
						if ($password=='') {
							$simpan = 'yn';
						}
					}

					if ($password!='') {
						if (strlen($password)<3) {
							$simpan = 'n';
							$pesan  = "Minimal Password 3 karakter";
						}elseif ($password!=$password2) {
							$simpan = 'n';
							$pesan  = "Password tidak cocok";
						}
					}

					if ($simpan=='y') {
						if ($foto==Null) {$foto = '';}
						if ($password=='') {
							$data   =   array('foto'=>$foto);
						}else{
							$data   =   array('password'=>hash_string($password),'foto'=>$foto);
						}
						$this->Mcrud->update('app_users',$data, 'id_users',$id_users);
						$this->session->set_flashdata('message', '<div class="alert alert-success">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												<strong><i class="fa fa-check"></i> Sukses!</strong> Data Profil berhasil disimpan.
										</div>');
					}elseif ($simpan=='n') {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												<strong><i class="fa fa-close"></i> Gagal!</strong> '.$pesan.'.
										</div>');
					}
					redirect($this->uri->segment(1));
			}

		}
		else{
			echo "<script>alert('anda tidak punya akses disini')</script>";
			redirect(base_url(),'refresh');
		}
	}


}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
