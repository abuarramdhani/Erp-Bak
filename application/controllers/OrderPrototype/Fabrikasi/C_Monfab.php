<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monfab extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		

		
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderPrototype/M_order');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){
			
		} else {
			redirect('index');
		}
	}

	public function index()
	{

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Order';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderPrototype/Fabrikasi/V_MonitoringFabrikasi');
		$this->load->view('V_Footer',$data);
	}

	public function loadview()
	{

		$monitor = $this->M_order->monitoringorder();

		// echo "<pre>";print_r($monitor);exit();

		$data['monitor']= $monitor;

		$this->load->view('OrderPrototype/Fabrikasi/V_TblMonitoringFabrikasi',$data);

	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
		public function sugestpic()
	{	
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_order->getNama($term);

		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function lihatgambar()
	{
		$no_order = $this->input->post('no_order');

		$img = '<center><img style="width:50%" src="'.base_url('/img/'.$no_order.'.png?t=' . time()).'"></center>';

		echo $img;
		
	}

		public function lihatprogress()
	{
		$no_order = $this->input->post('no_order');

		$progress = $this->M_order->progress($no_order);


		$arrayprogress= array();
		$i=0;
		foreach ($progress as $pro) {
			$nama_proses = $this->M_order->nama_proses($pro['id_proses']);

			$arrayprogress[$i]['urutan'] = $pro['urutan'];
			$arrayprogress[$i]['nama_proses'] = $nama_proses[0]['nama_proses'];
			$arrayprogress[$i]['done'] = $pro['done'];		
			$i++;
		}

		// echo "<pre>";print_r($arrayprogress);exit();

		$tbody = '';
		$h=0;
		foreach ($arrayprogress as  $pro) {
			if ($pro['done']== 'N') {
				$fa = '<i style="color: red" class="fa fa- fa-remove fa-2x">';
				$back = 'bg-danger';
				$pilih = '<select style="width:100%;" class="form-control select2 maudiapain" id="action'.$h.'" onchange="ubahsimboldanback('.$h.')" name="actionpro[]" data-placeholder="Action">
		<option></option>
		<option value="P">Progress</option>
		</select>';

			}else if ($pro['done'] == 'P') {
				$fa='<i style="color: black" class="fa fa-  fa-clock-o fa-2x">';
				$back='bg-warning';
				$pilih = '<select style="width:100%;" class="form-control select2 maudiapain" id="action'.$h.'" onchange="ubahsimboldanback('.$h.')" name="actionpro[]" data-placeholder="Action">
		<option value="P">Progress</option>
		<option value="Y">Finish</option>
		</select>';
			} else {
				$fa = '<i style="color: green" class="fa fa- fa-check fa-2x"></i>';
				$back = 'bg-success';
				$pilih = 'Done <input type="hidden" value="Y" name="actionpro[]"/>';

			}

			$tbody .= '
		<tr id="rowpro'.$h.'" class="'.$back.'">
		<input type="hidden" id="warna'.$h.'" value="'.$back.'">
		<td class="text-center"><input type="hidden" name="urutanpro[]" value="'.$pro['urutan'].'">'.$pro['urutan'].'</td>
		<td class="text-center"><input type="hidden" name="namapro[]" value="'.$pro['nama_proses'].'">'.$pro['nama_proses'].'</td>
		<td class="text-center" id="simboldong'.$h.'">'.$fa.'</td>
		<td class="text-center">'.$pilih.'</td>

		</tr>';

		$h++;
		}

		$tabelprogress = '<form name="Orderform" enctype="multipart/form-data" action="'.base_url('OrderFab/monorderfab/updateprogress').'" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
		<table class="table table-bordered">
		<thead class="bg-yellow">
		<tr>
		<input type="hidden" name="no_order" value="'.$no_order.'">
		<th class="text-center">Urutan</th>
		<th class="text-center">Nama Proses</th>
		<th class="text-center">Done</th>
		<th class="text-center">Action</th>
		</tr>
		</thead>
		<tbody>'.$tbody.'
		</tbody>
		</table>
		<div style="text-align:right"><button class="btn btn-primary">Update</button></div>
		</form>';

		echo $tabelprogress;
		
	}

	public function kirim()
	{
		$no_order = $this->input->post('no_order');
		date_default_timezone_set('Asia/Jakarta');
		$datetime = date("d-M-Y H:i:s");

		$this->M_order->kirim($no_order,$datetime);
	}

	public function edit()
	{
		$no_order = $this->input->post('no_order');
		$datatoedit = $this->M_order->dataedit($no_order);
		$proses = $this->M_order->selectproses();


		$progress = $this->M_order->progress($no_order);


		$arrayprogress= array();
		$i=0;
		foreach ($progress as $pro) {
			$nama_proses = $this->M_order->nama_proses($pro['id_proses']);

			$arrayprogress[$i]['urutan'] = $pro['urutan'];
			$arrayprogress[$i]['nama_proses'] = $nama_proses[0]['nama_proses'];
			$arrayprogress[$i]['id_proses'] = $pro['id_proses'];
			$arrayprogress[$i]['no_order'] = $pro['no_order'];


			$i++;
		}

		if ($datatoedit[0]['no_order'] == $arrayprogress[0]['no_order']) {
			$datatoedit[0]['proses'] = $arrayprogress;
		}

		// echo "<pre>";print_r($datatoedit);
		// echo "<pre>";print_r($proses);exit();




		if ($datatoedit[0]['tgl_kirim_material']== null) {
			$datatoedit[0]['asal_material'] = 'Tuksono';
			$opet='Pusat';
			$disable = 'disabled ="disabled"';
			$vulue ='';
		} else {
			$datatoedit[0]['asal_material'] = 'Pusat';
			$opet='Tuksono';
			$disable = '';
			$vulue = date('d-M-Y',strtotime($datatoedit[0]['tgl_kirim_material']));
		}

		// echo "<pre>";print_r($value);exit();
		$select='';
		for ($i=0; $i < count($datatoedit[0]['proses']); $i++) { 
		$option='';
			foreach ($proses as $value) {
				if ($datatoedit[0]['proses'][$i]['nama_proses'] != $value['nama_proses']) {
					$option.='<option value="'.$value['id_proses'].'">'.$value['nama_proses'].'</option>';
				}
			}
			$select .='<div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;"><label>Proses</label></div>
			<div class="col-md-1">
			<input class="form-control" type="text" name="urutan[]" value="'.$datatoedit[0]['proses'][$i]['urutan'].'" readonly="readonly">
			</div>
			<div class="col-md-5" style="text-align: left;">
				<select style="width:100%;" class="form-control select2 proses_order" id="proses_order" name="proses_order[]">
						<option value="'.$datatoedit[0]['proses'][$i]['id_proses'].'">'.$datatoedit[0]['proses'][$i]['nama_proses'].'</option>
						'.$option.'
				</select><br>
			</div><div class="col-md-1" style="text-align:left"><a class="btn btn-danger btn-sm hpsbtnnn"><i class="fa fa-minus"></i></a></div></div>';
		}

		// echo "<pre>";print_r($op);exit();


        $input='<form name="Orderform" enctype="multipart/form-data" action="'.base_url('OrderPro/monorderpro/update').'" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
       
                <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>No Order</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				 <input type="text" class="form-control" name="no_order" value="'.$no_order.'" readonly="readonly">
			</div>
        </div>
         <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Kode Komponen</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control" name="kode_komponen" value ="'.$datatoedit[0]['kode_komponen'].'"  >
			</div>
        </div>
          <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Nama Komponen</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control" name="nama_komponen" value ="'.$datatoedit[0]['nama_komponen'].'"  >
			</div>
        </div>
         <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Asal Material</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<select style="width:100%;" class="form-control select2 asal_material" id="asal_material" name="asal_material">
						<option value="'.$datatoedit[0]['asal_material'].'">'.$datatoedit[0]['asal_material'].'</option>
						<option value="'.$opet.'">'.$opet.'</option>
				</select>
			</div>
        </div>
           <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Tanggal Kirim Material</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control tanggaledit" '.$disable.' id="tanggaledit" name="tgl_kirim_material" value='.$vulue.'  >
			</div>
        </div>
        <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Due Date</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control duedate" id="duedate" name="due_date" value ="'.date('d-M-Y',strtotime($datatoedit[0]['dd_order'])).'"  >
			</div>
        </div>
    
        <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Type</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control" name="type" value ="'.$datatoedit[0]['type'].'"  >
			</div>
        </div>
        <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Qty</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control" name="qty" value ="'.$datatoedit[0]['qty'].'"  >
			</div>
        </div>
         <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Keterangan</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input type="text"class="form-control" name="keterangann" value ="'.$datatoedit[0]['keterangan'].'"  >
			</div>
        </div>
        <div id="kanann">
           '.$select.'
           <div id="tambah_proses2"></div>
         </div>
         <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
			</div>
			<div class="col-md-6" style="text-align: right;">
				<a id="buttontambahproses" onclick="nambahproses()" class="btn btn-primary btn-sm">Tambah Proses</a>
			</div>	
        </div>
         <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
				<label>Gambar Kerja</label>
			</div>
			<div class="col-md-6" style="text-align: left;" id="preview1">
				<center><img  style="width:100%" src="'.base_url('/img/'.$no_order.'.png?t='. time()).'"></center>
			</div>
			<div class="col-md-6" style="text-align: left; display:none;" id="previewgambarpilih">
			<center><img id="previewgambar" style="width:100%;"></center>
			</div>
        </div>
        <div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
        	<label>Update Gambar Kerja</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input autocomplete="off" class="form-control" type="file" name="img_order" id="img_orderr" accept=".png, .jpeg, .jpg" />
			</div>
        </div>
        <div class ="panel-body">
        	<div class="col-md-12" style="text-align: right;">
				<button class="btn btn-success">Update</button>
			</div>
        </div>
        </form>
        ';

        echo $input;
	}

	public function update()
	{
		$no_order = $this->input->post('no_order');
		$due_date = $this->input->post('due_date');
		$tgl_kirim_material = $this->input->post('tgl_kirim_material');
		$kode_komponen = $this->input->post('kode_komponen');
		$nama_komponen = $this->input->post('nama_komponen');
		$type = $this->input->post('type');
		$qty = $this->input->post('qty');
		$keterangan = $this->input->post('keterangann');
		$urutan = $this->input->post('urutan[]');
		$proses_order = $this->input->post('proses_order[]');

		$batasupdate = count($urutan);

		$dataasli= $this->M_order->progress($no_order);

		$aslinya = count($dataasli);

		// echo "<pre>";print_r($aslinya);print_r($batasupdate);print_r($proses_order);print_r($urutan);exit();


		if ($aslinya > $batasupdate) {
			for ($i=0; $i < $aslinya ; $i++) { 

				if ($i < $batasupdate) {
					$this->M_order->update_proses_order($urutan[$i],$proses_order[$i],$no_order);
				} else{
					$this->M_order->hapusprosess($no_order, $dataasli[$i]['urutan']);
				}

			}
		} else{

			for ($i=0; $i < $batasupdate ; $i++) { 

				$cekcek = $this->M_order->cek_urutan($no_order, $urutan[$i]);

				if (!empty($cekcek)) {
					$this->M_order->update_proses_order($urutan[$i],$proses_order[$i],$no_order);
				} else{
					$this->M_order->insertorderproses($no_order ,$proses_order[$i], $urutan[$i]);
				}

			}

		}

		if ($tgl_kirim_material != null) {
			$this->M_order->update($no_order,$due_date,$tgl_kirim_material,$kode_komponen,$nama_komponen,$type,$qty,$keterangan);
		
		} else{
			$this->M_order->update2($no_order,$due_date,$kode_komponen,$nama_komponen,$type,$qty,$keterangan);

		}

	

		if(!is_dir('./img')) 
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}

		$filename = "img/".$no_order.'.png'; 
		$temp_name = $_FILES['img_order']['tmp_name'];

		// echo "<pre>";print_r($_FILES);exit();

		// Check if file already exists
		if (file_exists($filename)) {
			move_uploaded_file($temp_name,$filename); 
		}else{
			move_uploaded_file($temp_name,$filename); 
				
			}

		redirect(base_url('OrderPro/monorderfab'));
	}

	public function sugestproses()
	{
		$data = $this->M_order->selectproses();
		echo json_encode($data);
	}

	public function terimamaterial()
	{
		date_default_timezone_set('Asia/Jakarta');

		$no_order = $this->input->post('no_order');
		$datetime = date("d-M-Y H:i:s");

		// echo "<pre>";print_r($datetime);exit();

		$this->M_order->update_tanggal_terima($no_order,$datetime);
	}

	public function inputtgljob()
	{
		$no_order = $this->input->post('no_order');

		$input = '
		<form name="Orderform" enctype="multipart/form-data" action="'.base_url('OrderFab/monorderfab/updatetgljob').'" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
		<input type="hidden" value="'.$no_order.'" name="no_order"/>
		<div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
        	<label>Tanggal</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input autocomplete="off" style="width:80%" placeholder="Tanggal" name="tgl_job" class="form-control" id="job_turun" type="text" required="required"/>
			</div>
        </div>
        <div class ="panel-body">
        <div class="col-md-12" style="text-align:right;"><button class="btn btn-primary">Insert</button></div>
        </div>
        </form>
        ';

		echo $input;
	}

	public function updatetgljob()
	{
		$tgl_job = $this->input->post('tgl_job');
		$no_order = $this->input->post('no_order');

		$this->M_order->updatetgljob($no_order, $tgl_job);

		redirect(base_url('OrderFab/monorderfab'));
	}

		public function inputqtyfinish()
	{
		$no_order = $this->input->post('no_order');

		$input = '
		<form name="Orderform" enctype="multipart/form-data" action="'.base_url('OrderFab/monorderfab/updateqtyfinish').'" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
		<input type="hidden" value="'.$no_order.'" name="no_order"/>
		<div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
        	<label>Qty</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
				<input autocomplete="off" style="width:80%" placeholder="Qty" name="qty_finish" class="form-control qty_finish" id="qty_finishh" type="text" required="required"/>
			</div>
        </div>
        <div class ="panel-body">
        <div class="col-md-12" style="text-align:right;"><button class="btn btn-primary">Insert</button></div>
        </div>
        </form>
        ';

		echo $input;
	}

		public function updateqtyfinish()
	{
		$qty_finish = $this->input->post('qty_finish');
		$no_order = $this->input->post('no_order');

		$this->M_order->updateqtyfinish($no_order, $qty_finish);

		redirect(base_url('OrderFab/monorderfab'));
	}

	public function updateprogress()
	{
	$urutanpro = $this->input->post('urutanpro[]');
	$actionpro = $this->input->post('actionpro[]');
	$no_order = $this->input->post('no_order');
	date_default_timezone_set('Asia/Jakarta');
	$date = date("d-M-Y");
	$time = date("H:i:s");

	// echo "<pre>";print_r($urutanpro);print_r($actionpro);print_r($no_order);print_r($date);print_r($time);exit();

	for ($i=0; $i < sizeof($urutanpro) ; $i++) { 
		if ($actionpro[$i]== null) {
			$actionpro[$i] = 'N';
		}
		$this->M_order->updateprogress($urutanpro[$i],$actionpro[$i],$no_order);
	}
		$this->M_order->updatelastup($date,$time,$no_order);

	redirect(base_url('OrderFab/monorderfab'));


	}
			public function inputpicfabrikasi()
	{
		$no_order = $this->input->post('no_order');

		$input = '
		<form name="Orderform" enctype="multipart/form-data" action="'.base_url('OrderFab/monorderfab/updatepicfabrikasi').'" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
		<input type="hidden" value="'.$no_order.'" name="no_order"/>
		<div class ="panel-body">
        	<div class="col-md-4" style="text-align: right;">
        	<label>PIC</label>
			</div>
			<div class="col-md-6" style="text-align: left;">
					<select style="width:100%;" class="form-control select2 pic_fab" id="pic_fab" name="pic_fab" data-placeholder="PIC Fabrikasi" required="required">
						<option></option>
				</select>
			</div>
        </div>
        <div class ="panel-body">
        <div class="col-md-12" style="text-align:right;"><button class="btn btn-primary">Insert</button></div>
        </div>
        </form>
        ';

		echo $input;
	}
	public function updatepicfabrikasi()
	{
		$no_order = $this->input->post('no_order');
		$pic_fab = $this->input->post('pic_fab');

		$this->M_order->updatePIC($no_order,$pic_fab);

		redirect(base_url('OrderFab/monorderfab'));
	}


}

