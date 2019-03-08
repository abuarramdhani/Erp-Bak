<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

 
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->library('General');
        $this->load->library('encrypt');
        $this->load->model('M_Index');
        $this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/PerhitunganPesangon/M_pesangon');

		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->load->helper('terbilang_helper');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }
	public function checkSession()
	{
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
    public function index()
    {
    	$this->checkSession();
    	$user_id = $this->session->userid;
    	
    	$data['Title']	= 'Perhitungan Pesangon';
    	$data['Menu'] = 'Cetak';
    	$data['SubMenuOne'] = 'Perhitungan Pesangon';
    	$data['SubMenuTwo'] = '';
    	
    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    	$data['data'] = $this->M_pesangon->lihat();
    	
    	$this->load->view('V_Header',$data); 
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MasterPekerja/PerhitunganPesangon/V_Index',$data);
    	$this->load->view('V_Footer',$data);
    }
    		public function create()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
        
        
    	$data['Title']	= 'Perhitungan Pesangon';
    	$data['Menu'] = 'Cetak';
    	$data['SubMenuOne'] = 'Perhitungan Pesangon';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/PerhitunganPesangon/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

		public function update($encrypt_id)
	{   	
		$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypt_id);
			$id	=	$this->encrypt->decode($id);
	// echo $id;exit();


		$this->checkSession();
		$user_id = $this->session->userid;
        
    
        
    	$data['Title']	= 'Perhitungan Pesangon';
    	$data['Menu'] = 'Cetak';
    	$data['SubMenuOne'] = 'Perhitungan Pesangon';
		$data['SubMenuTwo'] = '';
		$data['id']			=	$encrypt_id;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	    $data['editHitungPesangon'] = $this->M_pesangon->editHitungPesangon($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/PerhitunganPesangon/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

    public function daftar_pekerja_aktif(){
    	$noind = $this->input->get('term');
    	$data = $this->M_pesangon->getPekerjaAktif($noind);
    	echo json_encode($data);
		
    }

	


   	public function detailPekerja()
	{
		$noind 						=	$this->input->post('noind');
		$detailPekerja 				=	$this->M_pesangon->detailPekerja($noind);
		echo json_encode($detailPekerja);
		
    }

    	public function add()
	{
		// echo "<pre>";print_r($_POST);exit();

		$noind 		     			=	$this->input->post('txtNoind');
		$jabatan_terakhir 			=	$this->input->post('txtJabatan');
		$masa_kerja_tahun 			=	$this->input->post('txtTahun');
		$masa_kerja_bulan 			=	$this->input->post('txtBulan');
		$masa_kerja_hari 			=	$this->input->post('txtHari');
		$pasal_pengali_pesangon 	=	$this->input->post('txtPasal');
		$jml_pesangon 				=	$this->input->post('txtPesangon');
		$jml_upmk 	   	    		=	$this->input->post('txtUPMK');
		$jml_cuti 	    			=	$this->input->post('txtCuti');
		$uang_ganti_kerugian 		=	$this->input->post('txtRugi');
		$potongan 					=	$this->input->post('txtPotongan');
		$hutang_koperasi 			=	$this->input->post('txtHutangKoperasi');
		$hutang_perusahaan 			=	$this->input->post('txtHutangPerusahaan');
		$lain_lain 					=	$this->input->post('txtLainLain');
		$no_rekening 				=	$this->input->post('txtNomorRekening');
		$nama_rekening 				=	$this->input->post('txtNamaRekening');
		$bank 						=	$this->input->post('txtBank');
		$approver1 					=	'Agus Nugroho';
		$approver2 					=	'Bambang Yudhoseno';
		$created_by 				=	$this->session->user;
		$penerima 				    =	$this->input->post('txtPenerima');
		$pengirim 					=	$this->input->post('txtPengirim');


		$inputHitungPesangon			= 	array
										(
											'noinduk'				    =>	$noind,
											'jabatan_terakhir'	    =>	$jabatan_terakhir,
											'masa_kerja_tahun'  	=>  $masa_kerja_tahun,
											'masa_kerja_bulan'      =>  $masa_kerja_bulan,
											'masa_kerja_hari' 	    =>  $masa_kerja_hari,
											'pasal_pengali_pesangon' =>  $pasal_pengali_pesangon,
											'jml_pesangon' 	        =>  $jml_pesangon,
											'jml_upmk' 	            =>  $jml_upmk,
										    'jml_cuti'              =>	$jml_cuti,
										    'uang_ganti_kerugian'	=>	$uang_ganti_kerugian,
										    'potongan'			    =>  $potongan,
										    'hutang_koperasi'		=>	$hutang_koperasi,
										    'hutang_perusahaan'		=>	$hutang_perusahaan,
										    'lain_lain'				=>	$lain_lain,
										    'no_rekening'			=>  $no_rekening,
										    'nama_rekening'			=>  $nama_rekening,
										    'bank'                  =>  $bank,
										    'approver1'             =>  $approver1,
										    'approver2'             =>  $approver2,
										    'created_by'            =>  $created_by,
										    'penerima'              =>  $penerima,
										    'pengirim'              =>  $pengirim
										);

										// echo "<pre>";print_r($inputHitungPesangon);exit();
		$this->M_pesangon->inputHitungPesangon($inputHitungPesangon);


		redirect('MasterPekerja/PerhitunganPesangon');
		
	}


	public function edit($id)
	{
	// echo "<pre>";print_r($_POST);exit();
	
			$id 	=	str_replace(array('-', '_', '~'), array('+', '/', '='),$id);
			$id 	=	$this->encrypt->decode($id);

        
		$jabatan_terakhir 			=	$this->input->post('txtJabatan');
		$potongan 					=	$this->input->post('txtPotongan');
		$hutang_koperasi 			=	$this->input->post('txtHutangKoperasi');
		$hutang_perusahaan 			=	$this->input->post('txtHutangPerusahaan');
		$lain_lain 					=	$this->input->post('txtLainLain');
		$no_rekening 				=	$this->input->post('txtNomorRekening');
		$nama_rekening 				=	$this->input->post('txtNamaRekening');
		$bank 						=	$this->input->post('txtBank');
		$edit_by                    =	$this->session->user;
		$edit_date                  =	date(' M,d,y');





		$updateHitungPesangon			= 	array
										(
											
											'jabatan_terakhir'	    =>	$jabatan_terakhir,
										    'potongan'			    =>  $potongan,
										    'hutang_koperasi'		=>	$hutang_koperasi,
										    'hutang_perusahaan'		=>	$hutang_perusahaan,
										    'lain_lain'				=>	$lain_lain,
										    'no_rekening'			=>  $no_rekening,
										    'nama_rekening'			=>  $nama_rekening,
										    'bank'                  =>  $bank,
										    'edit_by'               =>  $edit_by,
										    'edit_date'             =>  $edit_date
	

										    
										);
		$this->M_pesangon->update($id,$updateHitungPesangon);


		redirect('MasterPekerja/PerhitunganPesangon');
	}

			public function delete($id)
		{
			$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$id	=	$this->encrypt->decode($id);
			$this->M_pesangon->delete($id);

			redirect('MasterPekerja/PerhitunganPesangon');

		}

		public function previewcetak($encrypt_id)
		{
			$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypt_id);
			$id	=	$this->encrypt->decode($id);


         $data['id']			=	$encrypt_id;

		 $data['data'] = $this->M_pesangon->cetak($id);
		 $data['penerima'] = $this->M_pesangon->penerima($id);
         $data['pengirim'] = $this->M_pesangon->pengirim($id);
		  
                                                
         // print_r($data['penerima']);exit();

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4',0,'',10,10,10,10,0,0);
		$filename = 'PerhitunganPesangon.pdf';
		

		$html = $this->load->view('MasterPekerja/PerhitunganPesangon/V_Cetak', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	   }


}