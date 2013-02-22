<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	var $data;
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('post_model', 'category_model'));
		$this->data['nav'] = $this->post_model->fetchAll();
		$this->load->vars($this->data);
	}
	
	public function index()	{
		$this->load->model('setting_model');

		$data['slide'] = $this->setting_model->fetchSetting();

		$this->load->view('landing_page', $data);
		
		
	}
	
	public function accomodation() {
		$id = $this->uri->segment('2');
		
		
		$id = $this->post_model->findBySlug($id);
		
		if (empty($id)) {
			show_404();
		}
		else {
			if ($this->post_model->fetchById($id) !== FALSE) {
				$data['content'] = $this->post_model->fetchById($id);
				$data['images'] = explode(', ', $data['content']->images);
				//var_dump($data['images']);
				$this->load->view('accomodation/view', $data);
			}
			
			else {
				show_404();
			}
		}
	}
	
	public function facilities() {
		$id = $this->uri->segment('2');
		$id = $this->post_model->findBySlug($id);
		
		if (empty($id)) {
			show_404();
		}
		else {
			//check if slug is exist
			//var_dump($this->facility_model->searchBySlug($id));
			if ($this->post_model->fetchById($id) !== FALSE) {
				$data['content'] = $this->post_model->fetchById($id);
				$this->load->view('facility/view', $data);
			}
			
			else {
				show_404();
			}
			
			// if slug exist show the view
			
			
			//slug not exist show 404
		}

	}
	
	public function gallery() {
		$data['content'] = 'gallery';
		$this->load->view('admin/index', $data);
	}
	
	public function rsvp() {
		$id = $this->uri->segment(2);
		if ($id == 'meeting-room') {
			$this->load->view('rsvp/meeting');
		}
		//var_dump($id);
	}
	
}
