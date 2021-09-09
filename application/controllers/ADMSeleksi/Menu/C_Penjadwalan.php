<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class C_Penjadwalan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('General');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('KonversiBulan');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('ADMSeleksi/M_penjadwalan');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }

  //================================= SET UP PENJADWALAN PSIKOTEST ===========================================================================================
  
  public function Penjadwalan() // Set Up Penjadwalan
  {
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Penjadwalan Psikotest - Quick ERP', 'Penjadwalan Psikotest', 'Setting / Setup', 'Setup Penjadwalan');

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ADMSeleksi/Penjadwalan/V_Penjadwalan', $data);
    $this->load->view('V_Footer',$data);
  }
  
	public function get_nama_psikotest(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_penjadwalan->get_namates($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

  public function search(){
    $tipe = $this->input->post('tipe');
    $tanggal = $this->input->post('tanggal');
    $getdata = $this->M_penjadwalan->data_peserta($tipe, $tanggal);
    foreach ($getdata as $key => $value) {
        $getdata[$key]['kode_akses'] = $this->randomKodeAkses(6, false, 'lud');
    }

    $data['data'] = $getdata;
    $this->load->view('ADMSeleksi/Penjadwalan/V_Daftar_Peserta', $data);
  }
  
	function randomKodeAkses($length = 6, $add_dashes = false, $available_sets = 'luds')
	{
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$kode_akses = '';
		foreach($sets as $set)
		{
			$kode_akses .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$kode_akses .= $all[array_rand($all)];
		$kode_akses = str_shuffle($kode_akses);
		if(!$add_dashes)
			return $kode_akses;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($kode_akses) > $dash_len)
		{
			$dash_str .= substr($kode_akses, 0, $dash_len) . '-';
			$kode_akses = substr($kode_akses, $dash_len);
		}
		$dash_str .= $kode_akses;
		return $dash_str;
  }

  // public function hapus_peserta(){
    // $this->M_penjadwalan->hapus_peserta($this->input->post('kode'));
    // $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'SET UP PENJADWALAN PSIKOTEST', "HAPUS PESERTA ".$this->input->post('nama')."", $this->session->user, "HAPUS DATA PESERTA", "PENJADWALAN PSIKOTEST");
  // }
  
  public function save(){
    $tipe           = $this->input->post('kode_akses_psikotest');
    $tanggal        = $this->input->post('tanggal_surat_psikotest');
    $kode           = $tipe.'_'.DateTime::createFromFormat('d/m/Y', $tanggal)->format('dmy');
    $tgl_tes        = $this->input->post('tanggal_psikotest');
    $waktu_mulai    = $this->input->post('waktu_mulai_psikotest');
    $waktu_selesai  = $this->input->post('waktu_selesai_psikotest');
    $zona           = $this->input->post('zona_psikotest');
    $nama_tes       = $this->input->post('nama_test_psikotest');
    
    $nama_peserta   = $this->input->post('nama_peserta');
    $nohp           = $this->input->post('no_hp');
    $kode_akses     = $this->input->post('kode_akses');
    $nik   = $this->input->post('nik');
    $pendidikan     = $this->input->post('pendidikan');

    $datanya = array();
    for ($i=0; $i < count($nama_peserta); $i++) { 
      for ($t=0; $t < count($nama_tes) ; $t++) { 
      $datanya = array( 'kode_test' => $kode,
                        'tgl_surat' => DateTime::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d'),
                        'tgl_test' => DateTime::createFromFormat('d/m/Y', $tgl_tes)->format('Y-m-d'),
                        'waktu_mulai' => $waktu_mulai,
                        'waktu_selesai' => $waktu_selesai,
                        'zona' => $zona,
                        'id_test' => $nama_tes[$t],
                        'nik' => $nik[$i],
                        'nama_peserta' => $nama_peserta[$i],
                        'pendidikan' => $pendidikan[$i],
                        'no_hp' => $nohp[$i],
                        'kode_akses' => $kode_akses[$i],
                        'created_by' => $this->session->user,
                        'creation_date' => date('Y-m-d H:m:i')

      );
      $this->M_penjadwalan->savePesertaPsikotest($datanya);
      }
    }
    // echo "<pre>";print_r($datanya);exit();
    $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'SET UP PENJADWALAN PSIKOTEST', "INPUT DATA $kode", $this->session->user, "INPUT DATA PESERTA", "PENJADWALAN PSIKOTEST");
    redirect(base_url('ADMSeleksi/Penjadwalan'));
  }


  //================================= MONITORING PENJADWALAN PSIKOTEST ===========================================================================================
  public function Monitoring() // Monitorig Penjadwalan
  {
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Penjadwalan Psikotest - Quick ERP', 'Monitoring Penjadwalan Psikotest', 'Setting / Setup', 'Monitoring Penjadwalan');

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ADMSeleksi/Penjadwalan/V_Monitoring', $data);
    $this->load->view('V_Footer',$data);
  }

  public function search_monitoring(){
    $ket        = $this->input->post('ket');
    $data['id'] = $this->input->post('id');
    $getdata    = $this->M_penjadwalan->data_psikotest($ket);
    $kode = $datanya = array();
    foreach ($getdata as $key => $value) {
      $kodetgl = $value['kode_test'].'_'.DateTime::createFromFormat('Y-m-d', $value['tgl_test'])->format('dmy');
      if (!in_array($kodetgl, $kode)) {
        $nama = array();
        array_push($kode, $kodetgl);
        array_push($nama, $value['nama_peserta']);
        $datanya[$kodetgl] = $value;
        $datanya[$kodetgl]['peserta'][] = $value['nama_peserta'];
      }else {
        if (!in_array($value['nama_peserta'], $nama)) {
          $datanya[$kodetgl]['peserta'][] = $value['nama_peserta'];
          array_push($nama, $value['nama_peserta']);
        }
      }
    }
    // echo "<pre>";print_r($datanya);exit();
    $data['data'] = $datanya;
    $this->load->view('ADMSeleksi/Penjadwalan/V_Monitoring_Table', $data);
  }
  
  public function hapus_jadwal(){
    $this->M_penjadwalan->hapus_jadwal($this->input->post('kode'), $this->input->post('tgl'));
    $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "HAPUS JADWAL ".$this->input->post('kode').", TANGGAL ".$this->input->post('tgl')."", $this->session->user, "HAPUS DATA JADWAL PSIKOTEST", "PENJADWALAN PSIKOTEST");
  }

  public function edit_jadwal_psikotest($kode, $tgl){
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Penjadwalan Psikotest - Quick ERP', 'Edit Jadwal Psikotest', 'Setting / Setup', 'Monitoring Penjadwalan');
    
    $kode = str_replace('-','/',$kode);
    $tgltes = DateTime::createFromFormat('dmy', $tgl)->format('Y-m-d');
    $data['data']    = $this->M_penjadwalan->data_psikotest2($kode, $tgltes);
    $data['tes']    = $this->M_penjadwalan->data_tes($kode, $tgltes);
    // echo "<pre>";print_r($tes);exit();
    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('ADMSeleksi/Penjadwalan/V_Edit_Jadwal', $data);
    $this->load->view('V_Footer',$data);
  }
  
  // public function hapus_peserta2(){
  //   // $this->M_penjadwalan->hapus_peserta($this->input->post('kode'));
  //   $this->M_penjadwalan->hapus_peserta2($this->input->post('kode'));
  //   $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "HAPUS PESERTA ".$this->input->post('nama')."", $this->session->user, "HAPUS DATA PESERTA", "PENJADWALAN PSIKOTEST");
  // }

  public function save_edit(){
    $tipe           = $this->input->post('kode_akses_psikotest');
    $tanggal        = $this->input->post('tanggal_surat_psikotest');
    $kode           = $tipe.'_'.DateTime::createFromFormat('d/m/Y', $tanggal)->format('dmy');
    $tgl_tes        = $this->input->post('tanggal_psikotest');
    $waktu_mulai    = $this->input->post('waktu_mulai_psikotest');
    $waktu_selesai  = $this->input->post('waktu_selesai_psikotest');
    $zona           = $this->input->post('zona_psikotest');
    $nama_peserta   = $this->input->post('nama_peserta');
    $nama_tes       = $this->input->post('nama_test_psikotest');
    $nik            = $this->input->post('nik');
    $pendidikan     = $this->input->post('pendidikan');
    $no_hp          = $this->input->post('no_hp');
    $kode_akses     = $this->input->post('kode_akses');

    $datanya = array();
    for ($i=0; $i < count($nama_peserta); $i++) { 
      for ($t=0; $t < count($nama_tes) ; $t++) { 
        $cek = $this->M_penjadwalan->cek_jadwal($nama_tes[$t], $kode_akses[$i]);
        if (!empty($cek)) {
          $datanya = array( 'kode_test' => $kode,
                            'tgl_test' => DateTime::createFromFormat('d/m/Y', $tgl_tes)->format('Y-m-d'),
                            'waktu_mulai' => $waktu_mulai,
                            'waktu_selesai' => $waktu_selesai,
                            'zona' => $zona,
                            'id_test' => $nama_tes[$t],
                            'kode_akses' => $kode_akses[$i],
          );
          $this->M_penjadwalan->updatePesertaPsikotest($datanya);
        }else {
          $datanya = array( 'kode_test' => $kode,
                    'tgl_surat' => DateTime::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d'),
                    'tgl_test' => DateTime::createFromFormat('d/m/Y', $tgl_tes)->format('Y-m-d'),
                    'waktu_mulai' => $waktu_mulai,
                    'waktu_selesai' => $waktu_selesai,
                    'zona' => $zona,
                    'id_test' => $nama_tes[$t],
                    'nik' => $nik[$i],
                    'nama_peserta' => $nama_peserta[$i],
                    'pendidikan' => $pendidikan[$i],
                    'no_hp' => $no_hp[$i],
                    'kode_akses' => $kode_akses[$i],
                    'created_by' => $this->session->user,
                    'creation_date' => date('Y-m-d H:m:i')

          );
          $this->M_penjadwalan->savePesertaPsikotest($datanya);
        }
      }
    }
    $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "EDIT DATA $kode", $this->session->user, "EDIT DATA PESERTA", "PENJADWALAN PSIKOTEST");

    $peserta_hapus = $this->input->post('peserta_terhapus');
    $hapus = explode('+', $peserta_hapus);
    for ($i=0; $i < count($hapus) ; $i++) { 
        $namanya = explode('_',$hapus[$i]);
        // $this->M_penjadwalan->hapus_peserta($namanya[1]);
        $this->M_penjadwalan->hapus_peserta2($namanya[1]);
        $this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "HAPUS PESERTA ".$namanya[0]."", $this->session->user, "HAPUS DATA PESERTA", "PENJADWALAN PSIKOTEST");
    }


    redirect(base_url('ADMSeleksi/MonitoringPenjadwalan'));
  }
  

}