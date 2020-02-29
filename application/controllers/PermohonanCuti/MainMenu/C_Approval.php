 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
/** this menu created by DK-PKL 2019
 *  ticket from EDP/reny sulistya
 *  sorry for bad code :(
 *  write : 6 agst 2019
 */
class C_Approval extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

        $this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PermohonanCuti/M_approval');
		$this->load->model('PermohonanCuti/M_permohonancuti');

    //------cek hak akses halaman-------//
		$this->load->library('access');
		$this->access->page();
		//---------------^_^----------------//
    $this->checkSession();
	}

	public function checkSession()
	{
		if(!$this->session->is_logged){
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Menu'] = 'Approval System';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    $data['Info'] = $this->M_permohonancuti->getPekerja($noind); // get information about logged user

    //special icon for Seksi edp login on approval
		if (strstr($kodesie, '4090101')){
			$data['user'] = "<span class='label label-success'><i class='fa fa-database'> EDP</i></span>";
      $data['count_inprocess'] = count($this->M_approval->getEDP('1'));
      $data['count_approved']  = count($this->M_approval->getEDP('2'));
      $data['count_rejected']  = count($this->M_approval->getEDP('3'));
		}else{
			$data['user'] = '';
      $data['count_inprocess'] = count($this->M_approval->getCuti($noind, '1'));
      $data['count_approved']  = count($this->M_approval->getCuti($noind, '2'));
      $data['count_rejected']  = count($this->M_approval->getCuti($noind, '3'));
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_Approval',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Inprocess(){
		$user_id = $this->session->userid;
		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;
		$status  = "1";

		$data['Title']      = 'Cuti Belum Diproses';
		$data['Menu']       = 'Approval';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info']           = $this->M_permohonancuti->getPekerja($noind);

		if (strstr($kodesie, '4090101')){ //this just user have that kodesie EDP (kasie)
			$data['Inprocess'] = $this->M_approval->getEDP($status);
		}else{
			$data['Inprocess'] = $this->M_approval->getCuti($noind, $status);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_Inprocess',$data);
		$this->load->view('V_Footer',$data);

	}

	public function Approved(){
		$user_id = $this->session->userid;
		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;
		$status  = "2"; //status code for approved cuti

		$data['Title']      = 'Cuti Disetujui';
		$data['Menu']       = 'Approval';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info']           = $this->M_permohonancuti->getPekerja($noind);

		if (strstr($kodesie, '4090101')){
			$data['Approved'] = $this->M_approval->getEDP($status);
		}else{
			$data['Approved'] = $this->M_approval->getCuti($noind, $status);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_Approved',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Rejected(){
		$user_id = $this->session->userid;
		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;
		$status  = "3"; //status code for rejected cuti

		$data['Title']      = 'Cuti Ditolak';
		$data['Menu']       = 'Approval';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info']           = $this->M_permohonancuti->getPekerja($noind);

		if (strstr($kodesie, '4090101')){
			$data['Rejected'] = $this->M_approval->getEDP($status);
		}else{
			$data['Rejected'] = $this->M_approval->getCuti($noind, $status);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_Rejected',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Canceled(){
		$user_id = $this->session->userid;
		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;
		$status  = "4"; //status code for canceled cuti

		$data['Title']      = 'Cuti Semua';
		$data['Menu']       = 'Approval';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info']           = $this->M_permohonancuti->getPekerja($noind);

		if (strstr($kodesie, '4090101')){
			$data['Canceled'] = $this->M_approval->getEDP($status);
		}else{
			$data['Canceled'] = $this->M_approval->getCuti($noind, $status);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_Canceled',$data);
		$this->load->view('V_Footer',$data);
	}

	public function All(){
		$user_id = $this->session->userid;
		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;
		$status  = "all";

		$data['Title']      = 'Cuti Semua';
		$data['Menu']       = 'Approval';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info']           = $this->M_permohonancuti->getPekerja($noind);

		if (strstr($kodesie, '4090101')){
			$data['All'] = $this->M_approval->getEDP($status);
		}else{
			$data['All'] = $this->M_approval->getCuti($noind, $status);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_All',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Detail($id){
		$user_id = $this->session->userid;
		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title']      = 'Detail Cuti';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info']           = $this->M_permohonancuti->getPekerja($noind);
		$data['kodesie']        = $kodesie;
		if (strstr($kodesie, '4090101')){
			$user = "EDP";
		}else{
			$user = $noind;
		}

		$data['Detail'] = $this->M_approval->getDetail($plaintext_string, $user); // get detail for cuti
    if (empty($data['Detail'])) { //if didnt found any cuti don't show detail page or error
      echo "<br><br><br><br><br><br><br><br><br><br><center><h2>Cuti telah dihapus</h2></center><br><center><h1>:(</h1><center><br><center><a href='".base_url('PermohonanCuti')."'>Redirect to Cuti Menu</a></center>";
      exit;
    }

		$data['DetailCutiPekerja'] = $this->M_permohonancuti->getPekerja($data['Detail']['0']['noind']);
		$data['ApproverStatus']    = $this->M_approval->ApproverStatus($user, $plaintext_string);
		$data['Thread']            = $this->M_permohonancuti->getDetailThread($plaintext_string);

		$data['TglAmbil']          = $this->M_permohonancuti->getDetailTglAmbil($plaintext_string);
		$tgl = array();
		for ($i=0; $i < count($data['TglAmbil']) ; $i++) {
			$tgl[$i] = date("d/M/Y",strtotime($data['TglAmbil'][$i]['tgl_pengambilan']));
		}
		$data['tglambil']    = implode(', ',$tgl);
		$data['banyakcuti']  = count($data['TglAmbil']);
		$data['tglambilhpl'] = date('d/M/Y',strtotime($data['TglAmbil']['0']['tgl_pengambilan'])).' - '.date("d/M/Y",strtotime(max($data['TglAmbil'])['tgl_pengambilan']));

    switch ($data['ApproverStatus']['0']['status']) { //Menu for title
      case '1':
        $data['Menu'] = 'Detail Cuti Belum di Proses';
        break;
      case '2':
        $data['Menu'] = 'Detail Cuti Disetujui';
        break;
      case '3':
        $data['Menu'] = 'Detail Cuti Ditolak';
        break;
      default:
        $data['Menu'] = 'Detail Cuti Dibatalkan';
        break;
    }

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/Approval/V_Detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Approve($id){
		date_default_timezone_set('Asia/Jakarta');
		$alasan  = ltrim($_GET['txtAlasan']);
		$approve = $_GET['approve'];

		$noind   = $this->session->user;
		$kodesie = $this->session->kodesie;

		$time = date('d-M-Y H:i:s');

		$id_cuti = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id_cuti = $this->encrypt->decode($id_cuti);

		$getapproval  = $this->M_permohonancuti->getApproval_cuti($id_cuti); // get approval from cuti
		$approval1    = $getapproval['0']['approver']; //this is first approval noind
		$approval2    = $getapproval['1']['approver']; //this is second approval noind
		$getnama      = $this->M_permohonancuti->getNama($noind); //get the fullname of user who login this erp
		$dataCuti     = $this->M_approval->getDataCuti($id_cuti); //get information about cuti
		$kdjabatanLv1 = $this->M_approval->getKdJbtn($approval1); //get kode jabatan approval 1

		if($approve == '2'){
      $status = "dapat";
			$ketentuan = 'Approved';
      $alasanThread = ".";
		}else if($approve == '3'){
      $status = "tidak dapat";
			$ketentuan = 'Rejected';
      $alasanThread    = ' dengan alasan "'.$alasan.'".';
		}

		if (strstr($kodesie, '4090101')){ //if session login edp
      $approverThread = "Seksi EDP - ".$getnama['0']['nama'];
      $level = "EDP";
		}else{ //else session is not edp
      $level = $this->M_approval->getApproverLevel($noind, $id_cuti); //get user(session login) level 1/2/3 from this cuti
      $approverThread = $getnama['0']['nama'];
		}

    $thread = array(
      'lm_pengajuan_cuti_id' => $id_cuti,
      'status' => $approve,
      'detail' => "(Approval $ketentuan) - $approverThread Telah memberikan keputusan pada Surat Permohonan Cuti ini".$alasanThread,
      'waktu'  => $time
    );

		$threadEDP = array( //if cuti need approval from edp -> insert this thread
			'lm_pengajuan_cuti_id' => $id_cuti,
			'status' => '0',
			'detail' => '(Waiting Approval) - Menunggu Approval dari seksi EDP (Electronic Data Processing)',
			'waktu'  => $time
		);

    $threadEnd = array( //if approval is end -> insert this thread
      'lm_pengajuan_cuti_id' => $id_cuti,
      'status' => '0',
      'detail' => '(Result Approval) - Cuti '.$status.' diambil, Approval Selesai',
      'waktu'  => $time
    );

        //insert to sys.log_activity
        $aksi = 'Permohonan Cuti';
        $detail = "Approve Cuti id=$id_cuti ketentuan=$ketentuan";
        $this->log_activity->activity_log($aksi, $detail);
        //

		$this->M_approval->updateApprove( //execution approval acc/reject, thread, and presense(if approval end)
        $id_cuti,
        $level,
        $approve,
        $thread,
        $alasan,
        $threadEDP,
        $threadEnd,
        $dataCuti['0']['tipe'],
        $dataCuti['0']['jenis'],
        $kdjabatanLv1,
        $dataCuti['0']['noind']
      );


		$detailCuti = $this->M_permohonancuti->getDetailPengajuan($id_cuti);

    //Notification cuti via internal mail//
		$id_cuti_enkripsi = $this->encrypt->encode($id_cuti);
		$link             = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_cuti_enkripsi);
		$linkApproval     = base_url('PermohonanCuti/Approval/Inprocess/Detail/'.$link);
    $linkDraft        = base_url('PermohonanCuti/DraftCuti/Detail/'.$link);

		if(empty($detailCuti['0']['kp'])){
			$keperluan = $detailCuti['0']['keperluan'];
		}else{
			$keperluan = $detailCuti['0']['kp'];
		}

		$jenis          = $detailCuti['0']['jenis'];
		$nextAppr       = '4,5,6,7';
		$mailAddressApp = $this->M_approval->getMail('user',$approval2)->row()->internal_mail;
    $mailAddressReq = $this->M_approval->getMail('user',$dataCuti['0']['noind'])->row()->internal_mail;
		$mailAddressEDP = $this->M_approval->getMail('edp')->result_array();

		$object         = $dataCuti['0']['nama'];

    $nextApprover   = $this->M_approval->getReadyNextApprover($level, $id_cuti);

		if($approve == '2'){
			if ($level == '1' && !strstr("02,03,04", $kdjabatanLv1) ){
				$this->sendMail($mailAddressApp, $dataCuti['0']['nama'], $object, $linkApproval, $keperluan, $jenis);
			} else {
				if (strstr($nextAppr, $dataCuti['0']['jenis']) && $level == '2') {
					for ($i=0; $i < count($mailAddressEDP) ; $i++) {
						$this->sendMail($mailAddressEDP[$i]['internal_mail'], 'Seksi EDP(Electronic Data Processing)', $object, $linkApproval, $keperluan, $jenis); //call send mail function
					}
				}
			}
		}
    $this->sendMailBack($approve, $nextApprover, $mailAddressReq, $keperluan, $jenis, $linkDraft, $getnama['0']['nama']); //Send feedback to requester if approval do approve/reject
    //end notification mail//
		redirect(site_url('PermohonanCuti/Approval/Inprocess'));
	}

	public function sendMail($address, $subject, $object, $link, $keperluan, $jenis){
    $now = date('d-m-y H:i:s');
		$Quick = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'mail.quick.com',
			'smtp_user' => 'no-reply@quick.com',
			'smtp_pass' => '123456',
      'priority'  => 1,
      'smtp_keepalive'=> true,
			'smtp_port' => 587,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];
		$this->load->library('email', $Quick);
		$this->email->from('no-reply', 'Email Sistem - Cuti');
    $this->email->to($address);
		$this->email->subject('Permintaan Approval Cuti');
		$this->email->message("
    <br>
      <b>Permintaan Approval Cuti Baru</b><br><br>
      <hr><br>
      Anda mendapat pengajuan approval cuti dari <b>".$object."</b>, dengan rincian : <br><br>
			Jenis Cuti   : ".$jenis." <br>
			Keperluan	   : ".($keperluan==null? "-" : $keperluan)." <br>
			Status cuti  : Menunggu Approval anda <br><br>
			Klik <a href=".$link.">Link</a> untuk Melihat detail Cuti disini
      <br>
      <br>
      <br>
      <small>Email ini digenerate melalui QuickERP pada {$now}.</small>
			");
		$this->email->send();
	}

  public function sendMailBack($approve, $nextApprover, $mailAddressReq, $keperluan, $jenis, $linkDraft, $approver){
    $now = date('d-m-y H:i:s');
    if($approve == '2'){
      if($nextApprover == '1'){ //ini error
        $status = "Menunggu Approval Selanjutnya";
      }else{
        $status = "Approval selesai, Cuti dapat diambil";
      }
      $title = "Cuti Telah di Approve";
      $message = "
        <br>
        Approval Cuti
        <br><br>
        <hr>
        Selamat ! Cuti anda telah di Setujui oleh <b>".$approver."</b>. Rincian Cuti : <br>
        Jenis Cuti   : ".$jenis." <br>
  			Keperluan	   : ".($keperluan==null? "-" : $keperluan)." <br>
  			Status cuti  : ".$status." <br><br>
        Klik <a href=".$linkDraft.">disini</a> untuk melihat detail cuti anda
        <br>
        <br>
        <br>
        <small>Email ini digenerate melalui QuickERP pada {$now}.</small>
      ";
    }else{
      $title = "Cuti Telah di Reject";
      $status = "Cuti tidak disetujui";
      $message = "
        <br>
        Approval Cuti
        <br><br>
        <hr>
        Maaf, cuti anda tidak disetujui oleh <b>".$approver."</b>. Rincian Cuti : <br>
        Jenis Cuti   : ".$jenis." <br>
        Keperluan	   : ".($keperluan==null? "-" : $keperluan)." <br>
        Status cuti  : ".$status." <br><br>
        Klik <a href=".$linkDraft.">disini</a> untuk melihat detail cuti anda
        <br>
        <br>
        <br>
        <small>Email ini digenerate melalui QuickERP pada {$now}.</small>
      ";
    }
    $Quick = [
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'protocol'  => 'smtp',
      'smtp_host' => 'mail.quick.com',
      'smtp_user' => 'no-reply@quick.com',
      'smtp_pass' => '123456',
      'smtp_keepalive'=> true,
      'priority'  => 1,
      'smtp_port' => 587,
      'crlf'      => "\r\n",
      'newline'   => "\r\n"
    ];
    $this->load->library('email', $Quick);
    $this->email->from('no-reply', 'Email Sistem - Cuti');
    $this->email->to($mailAddressReq);
    $this->email->subject($title);
    $this->email->message($message);
    $this->email->send();
  }

	public function CancelCuti(){
		$noind    = $_POST['noind'];
		$id_cuti  = $_POST['id_cuti'];
		$tipe     = $_POST['tipe'];
		$alasan   = $_POST['alasan'];

		$enc = $this->encrypt->encode($id_cuti);
		$dec = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc);

		$this->M_approval->cancelCuti($noind, $id_cuti, $tipe, $alasan);
        //insert to sys.log_activity
        $aksi = 'Permohonan Cuti';
        $detail = "Approval Cancel Cuti id=$id_cuti";
        $this->log_activity->activity_log($aksi, $detail);
        //
		echo $dec; //this is ecryption to link (ajax - js)
	}
}
