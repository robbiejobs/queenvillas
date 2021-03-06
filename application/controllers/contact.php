<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	var $data;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('post_model', 'category_model', 'gallery_model'));
		$this->data['nav'] = $this->post_model->fetchAll();
		$this->load->vars($this->data);
	}

	public function index() {
		//$this->load->library('recaptchalib');
		$this->load->view('contact_page');
	}

	public function sendMessage() {
		if (!empty($_POST['fname'])) {
			$this->load->model('setting_model');
			$this->load->config('admin');
			$this->load->library('PHPMailer');
			//$guser = $this->config->item('info_email_username');
			//$gpwd = $this->config->item('info_email_password');
			$emails = $this->setting_model->system_email();

			$guser = $emails->system_email;
			$gpwd = $emails->system_password;
			$rcpt = explode(',', $emails->support);
			$this->load->model('message_model');
			$message = $_POST['body'];
			$target = $_POST['email'];
			$this->message_model->saveMessage($_POST);
			// send thank you email to client
			foreach ($rcpt as $email) {
				$this->smtpmailer($email, $guser, 'QueenVillas Resort & Spa', 'Message From: '.$target, $message, $guser, $gpwd);
			}
			return $this->smtpmailer($target, $guser, 'QueenVillas Resort & Spa', 'Thank You For Contacting Us', $message, $guser, $gpwd);
			// send email to admin_info
			//$this->smtpmailer($hrd, $guser, 'donotreply@queenvillas.com', $_POST['subject'], $message, $guser, $gpwd);
		}
		else {
			$result = array(
						"status" => 'Access Violation',
						"response" => 'You cannot directly access this page'
						);
			echo json_encode($result);
		}
	}

	public function testSend() {
		$this->load->library('PHPMailer');
		$this->load->config('admin');
		$guser = $this->config->item('info_email_username');
		$gpwd = $this->config->item('info_email_password');
		$message = $_GET['body'];
		$target = $_GET['target'];
		if ($this->smtpmailer($target, $guser, 'donotreply@queenvillas.com', 'Thank You For Contacting Us', $message, $guser, $gpwd)) {
			$result = array("status" => $error);
			echo json_encode($result);
		}
	}

	function smtpmailer($to, $from, $from_name, $subject, $message, $guser, $gpwd) { 
		global $error;
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		//$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'mail.robbyprima.com';
		$mail->Port = 25; // 465: auth
		$mail->Username = $guser;  
		$mail->Password = $gpwd;           
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->MsgHTML($message);
		$mail->AltBody = strip_tags($message);
		$mail->AddAddress($to);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}
	}

}