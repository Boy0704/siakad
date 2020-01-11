<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_bayar_dinamis extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_bayar_dinamis_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'jenis_bayar_dinamis/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'jenis_bayar_dinamis/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'jenis_bayar_dinamis/index.html';
            $config['first_url'] = base_url() . 'jenis_bayar_dinamis/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Jenis_bayar_dinamis_model->total_rows($q);
        $jenis_bayar_dinamis = $this->Jenis_bayar_dinamis_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_bayar_dinamis_data' => $jenis_bayar_dinamis,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title']  = 'Jenis Pembayaran Dinamis';
        $this->template->load('template', 'jenis_bayar_dinamis/jenis_bayar_dinamis_list',$data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_bayar_dinamis_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_jenis_bayar_dinamis' => $row->id_jenis_bayar_dinamis,
		'jenis_bayar_dinamis' => $row->jenis_bayar_dinamis,
	    );
            $this->load->view('jenis_bayar_dinamis/jenis_bayar_dinamis_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_bayar_dinamis'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_bayar_dinamis/create_action'),
	    'id_jenis_bayar_dinamis' => set_value('id_jenis_bayar_dinamis'),
	    'jenis_bayar_dinamis' => set_value('jenis_bayar_dinamis'),
	);
        $data['title']  = 'Jenis Pembayaran Dinamis';
        $this->template->load('template', 'jenis_bayar_dinamis/jenis_bayar_dinamis_form',$data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jenis_bayar_dinamis' => $this->input->post('jenis_bayar_dinamis',TRUE),
	    );

            $this->Jenis_bayar_dinamis_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('jenis_bayar_dinamis'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_bayar_dinamis_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_bayar_dinamis/update_action'),
		'id_jenis_bayar_dinamis' => set_value('id_jenis_bayar_dinamis', $row->id_jenis_bayar_dinamis),
		'jenis_bayar_dinamis' => set_value('jenis_bayar_dinamis', $row->jenis_bayar_dinamis),
	    );
            $data['title']  = 'Jenis Pembayaran Dinamis';
        $this->template->load('template', 'jenis_bayar_dinamis/jenis_bayar_dinamis_form',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_bayar_dinamis'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jenis_bayar_dinamis', TRUE));
        } else {
            $data = array(
		'jenis_bayar_dinamis' => $this->input->post('jenis_bayar_dinamis',TRUE),
	    );

            $this->Jenis_bayar_dinamis_model->update($this->input->post('id_jenis_bayar_dinamis', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_bayar_dinamis'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_bayar_dinamis_model->get_by_id($id);

        if ($row) {
            $this->Jenis_bayar_dinamis_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_bayar_dinamis'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_bayar_dinamis'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis_bayar_dinamis', 'jenis bayar dinamis', 'trim|required');

	$this->form_validation->set_rules('id_jenis_bayar_dinamis', 'id_jenis_bayar_dinamis', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jenis_bayar_dinamis.php */
/* Location: ./application/controllers/Jenis_bayar_dinamis.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-01-11 11:09:57 */
/* http://harviacode.com */