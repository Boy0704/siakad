<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penelitian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Penelitian_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'penelitian/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'penelitian/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'penelitian/index.html';
            $config['first_url'] = base_url() . 'penelitian/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Penelitian_model->total_rows($q);
        $penelitian = $this->Penelitian_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        
        $data = array(
            'penelitian_data' => $penelitian,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'title' => 'Penelitian'
        );
        $this->template->load('template', 'penelitian/penelitian_list',$data);
        // $this->load->view('penelitian/penelitian_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Penelitian_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_penelitian' => $row->id_penelitian,
		'nidn' => $row->nidn,
		'nama_dosen' => $row->nama_dosen,
		'jenis_penelitian' => $row->jenis_penelitian,
		'total_dana' => $row->total_dana,
		'file_proposal' => $row->file_proposal,
	    );
            $this->load->view('penelitian/penelitian_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penelitian'));
        }
    }

    public function create() 
    {
         $ses = $this->session->userdata('keterangan');
            $get="SELECT ad.hp,ad.email,ad.dosen_id,ad.nama_lengkap,ad.nip,ap.nama_prodi
                        FROM app_dosen as ad,akademik_prodi as ap
                        WHERE ad.dosen_id=$ses";
            $bio = $this->db->query($get)->row();
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('penelitian/create_action'),
	    'id_penelitian' => set_value('id_penelitian'),
	    'nidn' => $bio->nip,
	    'nama_dosen' => $bio->nama_lengkap,
	    'jenis_penelitian' => set_value('jenis_penelitian'),
	    'total_dana' => set_value('total_dana'),
	    'file_proposal' => set_value('file_proposal'),
        'title' => 'Penelitian',
	);
        $this->template->load('template', 'penelitian/penelitian_form',$data);
        //$this->load->view('penelitian/penelitian_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nidn' => $this->input->post('nidn',TRUE),
		'nama_dosen' => $this->input->post('nama_dosen',TRUE),
		'jenis_penelitian' => $this->input->post('jenis_penelitian',TRUE),
		'total_dana' => $this->input->post('total_dana',TRUE),
		'file_proposal' => $this->input->post('file_proposal',TRUE),
	    );

            $this->Penelitian_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('penelitian'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Penelitian_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penelitian/update_action'),
		'id_penelitian' => set_value('id_penelitian', $row->id_penelitian),
		'nidn' => set_value('nidn', $row->nidn),
		'nama_dosen' => set_value('nama_dosen', $row->nama_dosen),
		'jenis_penelitian' => set_value('jenis_penelitian', $row->jenis_penelitian),
		'total_dana' => set_value('total_dana', $row->total_dana),
		'file_proposal' => set_value('file_proposal', $row->file_proposal),
        'title' => 'Penelitian',
	    );
            $this->template->load('template', 'penelitian/penelitian_form',$data);
            //$this->load->view('penelitian/penelitian_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penelitian'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_penelitian', TRUE));
        } else {
            $data = array(
		'nidn' => $this->input->post('nidn',TRUE),
		'nama_dosen' => $this->input->post('nama_dosen',TRUE),
		'jenis_penelitian' => $this->input->post('jenis_penelitian',TRUE),
		'total_dana' => $this->input->post('total_dana',TRUE),
		'file_proposal' => $this->input->post('file_proposal',TRUE),
	    );

            $this->Penelitian_model->update($this->input->post('id_penelitian', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('penelitian'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Penelitian_model->get_by_id($id);

        if ($row) {
            $this->Penelitian_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('penelitian'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penelitian'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nidn', 'nidn', 'trim|required');
	$this->form_validation->set_rules('nama_dosen', 'nama dosen', 'trim|required');
	$this->form_validation->set_rules('jenis_penelitian', 'jenis penelitian', 'trim|required');
	$this->form_validation->set_rules('total_dana', 'total dana', 'trim|required');
	// $this->form_validation->set_rules('file_proposal', 'file proposal', 'trim|required');

	$this->form_validation->set_rules('id_penelitian', 'id_penelitian', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

