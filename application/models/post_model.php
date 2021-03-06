<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class post_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('category_model');
	}
	
	public function fetchAll() {
		$q = $this->db->get('posts');
		return $q->result();
	}

	function categoryId($id) {
		$q = $this->db->get_where('categories', array('category' => $id));

		return $q->row()->id;
	}

	function categoryById($id) {
		$q = $this->db->get_where('categories', array('id' => $id));

		return $q->row()->category;
	}
	
	public function fetchByCategory($cat) {
		$id = $this->categoryId($cat);
		$q = $this->db->get_where('posts', array('category_id' => $id));
		
		if ($q->num_rows() > 0) {
			return $q->result();
		}

		else {
			return false;
		}
	}
	
	public function fetchById($id) {
		$q = $this->db->get_where('posts', array('id' => $id));
		
		return $q->row();
	
	}
	
	public function findBySlug($slug) {
		$q = $this->db->get_where('posts', array('slug' => $slug));
		
		return $q->row('id');
	}
	
	public function updatePost($post, $fn=NULL) {
		if ($post['category'] == 1) {
			$fac = '';
			foreach ($post['facil'] as $row) {
				if ($fac == NULL) {
					$fac = $row;
				}
				else {
					$fac = $fac.', '.$row;
				}
			}
			if ($fn) {
				$data = array(
							'title' => $post['title'],
							'content' => $post['desc'],
							'category_id' => $post['category'],
							'slug' => $post['slug'],
							'images' => $post['files'],
							'facilities' => $fac,
							'cover_image' => $fn
						);
			}
			else {
				$data = array(
							'title' => $post['title'],
							'content' => $post['desc'],
							'category_id' => $post['category'],
							'slug' => $post['slug'],
							'images' => $post['files'],
							'facilities' => $fac,
						);
			}
		}
		else {
			if ($fn) {
				$data = array(
							'title' => $post['title'],
							'content' => $post['desc'],
							'category_id' => $post['category'],
							'slug' => $post['slug'],
							'images' => $post['files'],
							'cover_image' => $fn
						);
			}
			else {
				if ($post['category'] == 4) {
					var_dump($_FILES);
					$data = array(
							'title' => $post['title'],
							'meta_desc' => $post['metadesc'],
							'content' => $post['desc'],
							'category_id' => $post['category'],
							'slug' => $post['slug'],
							'images' => $post['files'],
						);
				}
				else {
					$data = array(
							'title' => $post['title'],
							'content' => $post['desc'],
							'category_id' => $post['category'],
							'slug' => $post['slug'],
							'images' => $post['files'],
						);
				}
			}
		}
		$this->db->where('id', $post['id']);
		if ($this->db->update('posts', $data)) {
			return TRUE;
		}

		
	}
	
	public function savePost($post) {
		if ($post['category'] == 1) {
			$fac = '';
			foreach ($post['facil'] as $row) {
				if ($fac == NULL) {
					$fac = $row;
				}
				else {
					$fac = $fac.', '.$row;
				}
			}

			$data = array(
						'title' => $post['title'],
						'content' => $post['desc'],
						'category_id' => $post['category'],
						'slug' => $post['slug'],
						'images' => $post['files'],
						'facilities' => $fac
					);
		}
		else {
			if ($post['category'] == 4) {
				$data = array(
						'title' => $post['title'],
						'meta_desc' => $post['metadesc'],
						'content' => $post['desc'],
						'category_id' => $post['category'],
						'slug' => $post['slug'],
						'images' => $post['files'],
						'cover_image' => $_FILES['cover']['name']
					);
			}
			else if ($post['category'] != 3) {
				$data = array(
						'title' => $post['title'],
						'content' => $post['desc'],
						'category_id' => $post['category'],
						'slug' => $post['slug'],
						'images' => $post['files']
					);
			}
			else {
				$data = array(
						'title' => $post['title'],
						'content' => $post['desc'],
						'category_id' => $post['category'],
						'slug' => $post['slug'],
					);
			}
		}
				
		if ($this->db->insert('posts', $data)) {
			return TRUE;
		}
	}
	
	public function deletePost() {
		$id = $this->input->get('id');
		
		if (empty($id)) {
			return false;
		}
		
		else {
			$q = $this->db->delete('posts', array('id' => $id));
			if ($q) {
				return true;
			}
			else {
				return false;
			}
		}
	}

	function getFacility($id) {
		$q = $this->db->get_where('facilities', array('id' => $id));

		return $q->row();
	}

	public function fetchOffer() {
		$q = $this->db->get('offers');

		return $q->result();
	}

	public function update_offer($data) {
		$this->db->where('id', $data['id']);
		if ($this->db->update('offers', $data)) {
			return TRUE;
		}
	}

	function getRoomName($id) {
		$q = $this->db->get_where('posts', array('id' =>$id));

		return $q->row();
	}

	public function readEvent($slug, $date) {
		$date1 = date('Y-m-d H:i:s', $date);
		$date2 = strtotime(date("Y-m-d H:i:s", strtotime($date1)) . " +1 day");
		$array = array('slug' => $slug, 'timestamp >' => $date1, 'timestamp <' => date("Y-m-d H:i:s", $date2));
		$this->db->where($array);
		$this->db->from('posts');
		$q = $this->db->get();
		return $q->row(); 
	}

	public function fetchEvent($offset=22, $limit) {
		$this->db->where('category_id', 3)->order_by('timestamp', 'desc');
		//$this->db->from('posts', $start, $limit);
		$q = $this->db->get('posts', $limit, $offset);
		return $q->result();
	}

	public function totalEvents() {
		$q = $this->db->get_where('posts', array('category_id' => 3));

		return $q->num_rows();
	}
}