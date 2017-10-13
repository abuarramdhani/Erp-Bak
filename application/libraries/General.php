<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
class general
{

	function __construct()
	{
		$this->CI = &get_instance();
		date_default_timezone_set('Asia/Jakarta');
		
		// Model Document Controller -----start-----
			$this->CI->load->model('DocumentStandarization/MainMenu/M_general');
		// Model Document Controller -------end-----
	}
	// General Function ---------------------------start---
	public function ambilPekerja($list)
	{
		if($list=='all')
		{
			$data['pekerja'] 	= 	$this->M_general->ambilSemuaPekerja();
		}
		elseif($list=='min-kasie')
		{
			$data['pekerja'] 	= 	$this->M_general->ambilPekerjaMinKasie();
		}
		return $data['pekerja'];
	}

	public function konversiTanggalkeDatabase($tanggal, $format)
	{
		// Ubah tanggal jika menggunakan separator '/'
		$tanggal 	= 	str_replace('/', '-', $tanggal);
		// strtotime
		$tanggal 	= 	strtotime($tanggal);
		// Ubah tanggal sesuai format
		if($format=='tanggal')
		{
			$tanggal 	= 	date('Y-m-d', $tanggal);
		}
		elseif($format=='datetime' || $format=='timestamp')
		{
			$tanggal 	= 	date('Y-m-d H:i:s', $tanggal);
		}

		return $tanggal;
	}

	public function ambilWaktuEksekusi()
	{
		$tanggalEksekusi 	= 	date('Y-m-d H:i:s');
		return $tanggalEksekusi;
	}

	public function uploadDokumen($inputfile, $namafile = FALSE, $direktoriUpload = FALSE)
	{
		$fileDokumen = null;
		$errorinfo = null;
		// echo 'bisa';
		// exit();
		$this->CI->load->library('upload');
    		if(!empty($_FILES[$inputfile]['name']))
    		{

    			$fileDokumen;

    			if(is_null($namafile))
    			{
	        		$fileDokumen		 		= filter_var($_FILES[$inputfile]['name'],  FILTER_SANITIZE_URL);
    			}
    			else 
    			{
    				$direktoriDokumen					= $_FILES[$inputfile]['name'];
    				$ekstensiDokumen					= pathinfo($direktoriDokumen,PATHINFO_EXTENSION);
    				$fileDokumen						= filter_var($namafile.".".$ekstensiDokumen, FILTER_SANITIZE_URL); 

    			}
    			$fileDokumen 	= 	str_replace('&', '_', $fileDokumen);
    			// $nama_STNK 							= filter_var($_FILES[$inputfile]['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

    			if(is_null($direktoriUpload)==FALSE)
    			{

    				$config['upload_path'] 			= $direktoriUpload;

    				if(!file_exists($direktoriUpload))
    				{
    					mkdir($direktoriUpload, 0777, true);
    				}

    			}
    			else
    			{
 					$config['upload_path']          = base_url('assets/upload/');    				
    			}
				$config['allowed_types'] 		= '*';
	        	$config['file_name']		 	= $fileDokumen;
	        	$config['overwrite'] 			= TRUE;


	        	$this->CI->upload->initialize($config);

	    		if ($this->CI->upload->do_upload($inputfile)) 
	    		{
            		$this->CI->upload->data();
	        		$fileDokumen 	= 	$config['file_name'];
        		} 
        		else 
        		{
        			$errorinfo = $this->CI->upload->display_errors();
        			$fileDokumen 	= 	NULL;
        		}
        	}
        	if(is_null($errorinfo)!=TRUE)
        	{
        		echo $errorinfo;
        		exit();
        	}

		return 	$fileDokumen;
	}

	// General Function -----------------------------end---

	// General Document Standarization Function ---start---

	public function cekBusinessProcess($id)
	{	
		$BP 	= 	$this->CI->M_general->cekBusinessProcess($id);
		return $BP[0]->kode_business_process;
	}

	public function cekContextDiagram($id)
	{
		$CD 	= 	$this->CI->M_general->cekContextDiagram($id);
		return $CD[0]->kode_context_diagram;
	}

	public function cekFile($namaDokumen, $nomorRevisi, $nomorKontrol, $fileDokumen, $direktoriFile)
	{
		$fileLama 			= 	explode('_-_',$fileDokumen);
		$namaDokumenLama 	= 	$fileLama[0];
		$nomorRevisiLama	= 	substr($fileLama[1], 5);
		$nomorKontrolLama 	= 	$fileLama[2];

		$ekstensiFile 		=	pathinfo($direktoriFile.$fileDokumen, PATHINFO_EXTENSION);
		if(!(str_replace(' ', '_', $namaDokumen)==$namaDokumenLama AND str_replace(' ', '_', $nomorRevisi)==$nomorRevisiLama AND str_replace(' ', '_', $nomorKontrol)==$nomorKontrolLama))
		{
			rename($direktoriFile.$fileDokumen, filter_var($direktoriFile.str_replace(' ', '_', $nomorKontrol).'_-_'.str_replace(' ', '_', $nomorRevisi).'_-_'.str_replace(' ', '_', $namaDokumen).'.'.$ekstensiFile, FILTER_SANITIZE_URL));
			$fileDokumen 	= 	filter_var(str_replace(' ', '_', $nomorKontrol).'_-_'.str_replace(' ', '_', $nomorRevisi).'_-_'.str_replace(' ', '_', $namaDokumen).'.'.$ekstensiFile, FILTER_SANITIZE_URL);
		}
		return $fileDokumen;
	}

	public function notifikasiRevisi($jenisDokumen)
	{
		if($jenisDokumen=='BP' || $jenisDokumen=='CD' || $jenisDokumen=='SOP' || $jenisDokumen=='WI' || $jenisDokumen=='COP')
		{
			$data['notif'] 		= 	null;
			$jumlahData			= 	$this->CI->M_general->cekJumlahNotif($jenisDokumen, 'revisi');
			if($jumlahData>0)
			{
				$data['notif'] 	= 	$this->CI->M_general->ambilNotifikasi($jenisDokumen, 'revisi');
			}
			return $data['notif'];
		}
		else
		{
			echo '	<center>
						<h1><b>Terima Kasih</b></h1>
						<br/>
						<h3>Anda telah menemukan bug di program kami.</h3>
						<h4><i>Simpan informasi di bawah untuk dapat dilaporkan ke ICT Human Resource (VoIP: 12300)</i></h4>
						<hr/>
					</center>
					<p>
						Info : ERP->Document Controller->"Dokumen" Group Menu-->Fungsi notifikasiRevisi class General mendapat argumen selain "BP, CD, SOP, WI, dan COP".
					</p>';
			exit();
		}
	}

	public function notifikasiDokumenBaru($jenisDokumen)
	{
		if($jenisDokumen=='BP' || $jenisDokumen=='CD' || $jenisDokumen=='SOP' || $jenisDokumen=='WI' || $jenisDokumen=='COP')
		{
			$data['notif'] 		= 	null;
			$jumlahData			= 	$this->CI->M_general->cekJumlahNotif($jenisDokumen, 'dokumenBaru');
			if($jumlahData>0)
			{
				$data['notif'] 	= 	$this->CI->M_general->ambilNotifikasi($jenisDokumen, 'dokumenBaru');
			}
			return $data['notif'];
		}
		else
		{
			echo '	<center>
						<h1><b>Terima Kasih</b></h1>
						<br/>
						<h3>Anda telah menemukan bug di program kami.</h3>
						<h4><i>Simpan informasi di bawah untuk dapat dilaporkan ke ICT Human Resource (VoIP: 12300)</i></h4>
						<hr/>
					</center>
					<p>
						Info : ERP->Document Controller->"Dokumen" Group Menu-->Fungsi notifikasiRevisi class General mendapat argumen selain "BP, CD, SOP, WI, dan COP".
					</p>';
			exit();
		}
	}

	// General Document Standarization Function -----end---

}