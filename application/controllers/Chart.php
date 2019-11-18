<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends MY_Controller {
	var $title  =   "Statistik";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Chart_model');
	}

	public function index()
	{
			$char_data = $this->Chart_model->get_service_has_offers();
			$title = $this->title;
			$this->load->view('chart/chart_mahasiswa',array('title'=>$title,'char_data'=>$char_data));		
	}


	public function getdata() 
    { 
	    //         //data to json 

	    $responce->cols[] = array( 
	        "id" => "", 
	        "label" => "Topping", 
	        "pattern" => "", 
	        "type" => "string" 
	    ); 
	    $responce->cols[] = array( 
	        "id" => "", 
	        "label" => "Jumlah", 
	        "pattern" => "", 
	        "type" => "number" 
	    ); 

	    $data = $this->Chart_model->getChartData(); 
	    foreach($data as $cd) 
	    { 
		    $responce->rows[]["c"] = array( 
		        array( 
		            "v" => "$cd->keterangan", 
		            "f" => null 
		        ) , 
		        array( 
		            "v" => (int)$cd->jumlah, 
		            "f" => null 
		        ) 
		    ); 
	    } 

    	echo json_encode($responce); 
    } 

    public function getPersonas(){
		$result = $this->Chart_model->getChartData(); 
		echo json_encode($result);
	}

}

/* End of file chart.php */
/* Location: ./application/controllers/chart.php */