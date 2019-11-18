<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $menu = $this->Menu_model->get_all();


      $data = array(
          'menu_data' => $menu,
          'title' => 'menu',
          'role' => $this->session->userdata('role'),
          'nama' => $this->session->userdata('nama')
      );
        $this->template->load('template', 'menu'.'/list',$data);
     
    }

    public function read($id)
    {
        $row = $this->Menu_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'menu' => $row->menu,
		'sub_menu' => $row->sub_menu,
		'icon' => $row->icon,
		'is_main_menu' => $row->is_main_menu,
		'menu_aktif' => $row->menu_aktif,
	    );

    $data = array(
        'title' => 'menu',
        'role' => $this->session->userdata('role'),
        'nama' => $this->session->userdata('nama'),
    );
      $this->template->load('template', 'menu'.'/view',$data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function create()
    {
        $data = array(
        'button' => 'Create',
        'action' => site_url('menu/create_action'),
        'id' => set_value('id'),
        'menu' => set_value('menu'),
        'sub_menu' => set_value('sub_menu'),
        'icon' => set_value('icon'),
        'is_main_menu' => set_value('is_main_menu'),
        'menu_aktif' => set_value('menu_aktif'),
        'title' => 'menu',
        'role' => $this->session->userdata('role'),
        'nama' => $this->session->userdata('nama')
  	 );
          $this->template->load('template', 'menu'.'/form',$data);

    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'menu' => $this->input->post('menu',TRUE),
		'sub_menu' => $this->input->post('sub_menu',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'is_main_menu' => $this->input->post('is_main_menu',TRUE),
		'menu_aktif' => $this->input->post('menu_aktif',TRUE),
	    );

            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('menu'));
        }
    }

    public function update($id)
    {
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('menu/update_action'),
		'id' => set_value('id', $row->id),
		'menu' => set_value('menu', $row->menu),
		'sub_menu' => set_value('sub_menu', $row->sub_menu),
		'icon' => set_value('icon', $row->icon),
		'is_main_menu' => set_value('is_main_menu', $row->is_main_menu),
		'menu_aktif' => set_value('menu_aktif', $row->menu_aktif),
        'title' => 'menu',
          'role' => $this->session->userdata('role'),
          'nama' => $this->session->userdata('nama'),
	    );
           $this->template->load('template', 'menu'.'/form',$data);

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'menu' => $this->input->post('menu',TRUE),
		'sub_menu' => $this->input->post('sub_menu',TRUE),
		'icon' => $this->input->post('icon',TRUE),
		'is_main_menu' => $this->input->post('is_main_menu',TRUE),
		'menu_aktif' => $this->input->post('menu_aktif',TRUE),
	    );

            $this->Menu_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('menu'));
        }
    }

    public function delete($id)
    {
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $this->Menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('menu', 'menu', 'trim|required');
	$this->form_validation->set_rules('sub_menu', 'sub menu', 'trim|required');
	$this->form_validation->set_rules('icon', 'icon', 'trim|required');
	$this->form_validation->set_rules('is_main_menu', 'is main menu', 'trim|required');
	$this->form_validation->set_rules('menu_aktif', 'menu aktif', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-05-07 08:06:45 */
/* http://harviacode.com */