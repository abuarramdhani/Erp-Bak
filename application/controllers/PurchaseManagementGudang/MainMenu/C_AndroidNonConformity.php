<?php
class C_AndroidNonConformity extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function UploadImage(){
		// $year		= date('Y');
  		$file_path	= "./assets/upload_pm/";

  		// if(!is_dir('./assets/upload_pm'))
  		// {
	   //     	mkdir('./assets/upload_pm', 0777, true);
	   //     	chmod('./assets/upload_pm', 0777);
	   //  }

	   //  if(!is_dir('./assets/upload_pm/'.$year))
  		// {
	   //     	mkdir('./assets/upload_pm/'.$year, 0777, true);
	   //     	chmod('./assets/upload_pm/'.$year, 0777);
	   //  }

  		$namafile = isset($_FILES['uploaded_file']['name']) ? $_FILES['uploaded_file']['name'] : '';
  		$namafile2 = isset($_FILES['uploaded_file']['tmp_name']) ? $_FILES['uploaded_file']['tmp_name'] : '';
  		$file_path = $file_path . basename( $namafile);
  		if(move_uploaded_file($namafile2, $file_path)) {
  			echo "Success";
  		} else{
  			echo "Muach!";
  		}
	}

	public function SendEmail($id){
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host']='mail.quick.com';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);

		$this->email->from('system.non_confirmity@quick.com','Non Confirmity');
		$this->email->to('purchasing.sec8@quick.com');
		$this->email->subject('Non Confirmity New Data');
		$this->email->message('New Data Non Confirmity - '.$id);
			
		if (!$this->email->send()) {
			$error = $this->email->print_debugger();
			echo $error;exit();
		}else{
			$this->email->send();
		}
	}
	
}
?>
