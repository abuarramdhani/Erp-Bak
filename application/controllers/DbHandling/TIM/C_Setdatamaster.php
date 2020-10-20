<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Setdatamaster extends CI_Controller
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
        $this->load->model('DbHandling/M_dbhandling');

        $this->checkSession();
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('index');
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Setting Data Master';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('DbHandling/TIM/V_SetDataMaster');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function loadviewmasterhandling()
    {
        $masterhandling = $this->M_dbhandling->selectmasterhandling();
        // echo "<pre>";
        // print_r($masterhandling);
        // exit();
        $data['masterhandling'] = $masterhandling;
        $this->load->view('DbHandling/TIM/V_TblMasterHandling', $data);
    }
    public function loadviewmasterproseksi()
    {
        $masterproseksi = $this->M_dbhandling->selectmasterprosesseksi();
        // echo "<pre>";
        // print_r($masterproseksi);
        // exit();
        $data['masterproseksi'] = $masterproseksi;
        $this->load->view('DbHandling/TIM/V_TblMasterProSeksi', $data);
    }
    public function loadviewreqmashand()
    {
        $req = $this->M_dbhandling->selectreqmasterhandlingbystatus();
        $data['req'] = $req;
        $this->load->view('DbHandling/TIM/V_TblReqMastHand', $data);
    }
    public function loadviewmasterstatkomp()
    {
        $dataa = $this->M_dbhandling->selectstatuskomp();
        // echo "<pre>";
        // print_r($dataa);
        // exit();
        $data['dataa'] = $dataa;
        $this->load->view('DbHandling/TIM/V_TblMasterStatKomp', $data);
    }
    public function tambahmasterhandling()
    {
        $tambahmasterhandling = '
                <div class="panel-body">                            
                    <div class="col-md-5" style="text-align: right;"><label>Nama Handling</label></div>                                        
                    <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" name="namahandling" id="namahandling" class="form-control" /></div>
                </div>
                <div class="panel-body">                            
                    <div class="col-md-5" style="text-align: right;"><label>Kode Handling</label></div>                                        
                    <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" name="kodehandling" id="kodehandling" class="form-control" /><span style="display:none;color:red;font-size:9pt" id="keterangansimbol">*Kode Handling tersebut sudah digunakan</span></div>
                    <div class="col-md-2" style="text-align: left;"id="simbolverifykode" ></div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="text-align:right"><button class="btn btn-success buttonsave" disabled="disabled">Save</button></div>
                </div>';

        echo $tambahmasterhandling;
    }
    public function editmasterhandling()
    {
        $id = $this->input->post('id');
        $dataa = $this->M_dbhandling->selectdatatoedit($id);

        // echo "<pre>";
        // print_r($dataa);
        // exit();

        $editmasterhandling = '
            <div class="panel-body">                            
                <div class="col-md-5" style="text-align: right;"><label>Nama Handling</label></div>                                        
                    <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" id="namahandlingedit" name="namahandling" value="' . $dataa[0]['nama_handling'] . '" /></div>
                    <input type="hidden" name="idhandling" id="idhandlingedit" value="' . $id . '"/>
                </div>
                <div class="panel-body">                            
                    <div class="col-md-5" style="text-align: right;"><label>Kode Handling</label></div>                                        
                    <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" class="form-control" name="kodehandling" id="kodehandlingedit" value="' . $dataa[0]['kode_handling'] . '" /><span style="display:none;color:red;font-size:9pt" id="keterangansimbol2">*Kode Handling tersebut sudah digunakan</span></div>
                    <div class="col-md-2" style="text-align: left;"id="simbolverifykode2" ></div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="text-align:right"><button class="btn btn-success button-save-edit">Save</button></div>
                </div>';

        echo $editmasterhandling;
    }
    public function tambahmasterprosesseksi()
    {

        $tambahmasterprosesseksi = '
            <div class="panel-body">            
                <div class="panel-body col-md-12">                            
                    <div class="col-md-4" style="text-align: right;"><label>Identitas</label></div>                                        
                    <div class="col-md-8" style="text-align: left;">
                        <div class="col-md-6">
                            <select class="form-control select2 idseksi" id="identitasseksi" required="required" data-placeholder ="Select" style="width:100%" name="identitasseksi">
                                <option></option>
                                <option value="UPPL">UPPL</option>
                                <option value="Sheet Metal">Sheet Metal</option>
                                <option value="Machining">Machining</option>
                                <option value="Perakitan">Perakitan</option>
                                <option value="PnP">PnP</option>
                                <option value="Gudang">Gudang</option>
                                <option value="Subkon">Subkon</option>
                            </select>
                        </div> 
                        <div class="col-md-2">
                            <div style="background-color:white;color:white; width:100%;height:33px;" id="simbolwarnaidentitasseksi">aa</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body col-md-12">                            
                    <div class="col-md-4" style="text-align: right;"><label>Seksi</label></div>                                        
                    <div class="col-md-8" style="text-align: left;">
                        <div class="col-md-8"><select style="width:100%" class="form-control select2" id="namaseksi" name="namaseksi" data-placeholder="Select"><option></option></select></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="text-align:right"><button class="btn btn-success btn-save-proses">Save</button></div>
                </div>';

        echo $tambahmasterprosesseksi;
    }
    public function suggestseksi()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_dbhandling->select2_seksi($term);
        echo json_encode($data);
    }
    public function editmasterprosesseksi()
    {
        $id = $this->input->post('id');
        $datauntukedit = $this->M_dbhandling->selectdatatoedit2($id);

        $option = ['UPPL', 'Sheet Metal', 'Machining', 'Perakitan', 'PnP', 'Gudang', 'Subkon'];

        // echo "<pre>";
        // print_r($option);
        // exit();
        $opt = '';
        for ($i = 0; $i < sizeof($option); $i++) {
            if ($datauntukedit[0]['identitas_seksi'] != $option[$i]) {
                $opt .= '<option value="' . $option[$i] . '">' . $option[$i] . '</option>';
            }
        }


        if ($datauntukedit[0]['identitas_seksi'] == 'Machining') {
            $warna = '#ffff00';
        } else if ($datauntukedit[0]['identitas_seksi'] == 'Gudang') {
            $warna = '#cccccc';
        } else if ($datauntukedit[0]['identitas_seksi'] == 'PnP') {
            $warna = '#ff8080';
        } else if ($datauntukedit[0]['identitas_seksi'] == 'Sheet Metal') {
            $warna = '#94bd5e';
        } else if ($datauntukedit[0]['identitas_seksi'] == 'UPPL') {
            $warna = '#ff00ff';
        } else if ($datauntukedit[0]['identitas_seksi'] == 'Perakitan') {
            $warna = '#99ccff';
        } else if ($datauntukedit[0]['identitas_seksi'] == 'Subkon') {
            $warna = '#ffcc99';
        }
        $editmasterprosesseksi = '
                <div class="panel-body col-md-12">                            
                    <div class="col-md-4" style="text-align: right;"><label>Identitas</label></div>                                        
                    <div class="col-md-8" style="text-align: left;">
                        <div class="col-md-6">
                        <select class="form-control select2 idseksii" required="required" id="identitasseksi2" style="width:100%" name="identitasseksii">
                            <option value="' . $datauntukedit[0]['identitas_seksi'] . '">' . $datauntukedit[0]['identitas_seksi'] . '</option>
                            ' . $opt . '
                        </select>
                        </div> 
                        <div class="col-md-2">
                            <div style="background-color:' . $warna . ';color:' . $warna . '; width:100%;height:33px;" id="simbolwarnaa">aa</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body col-md-12">                            
                    <div class="col-md-4" style="text-align: right;"><label>Seksi</label></div>                                        
                    <div class="col-md-8" style="text-align: left;">
                        <div class="col-md-8"><input type="text" required="required" autocomplete="off" value="' . $datauntukedit[0]['seksi'] . '" class="form-control" id="seksieya" name="seksieya" /></div>
                    </div>
                    <input type="hidden" name="idmastprosseksi" id="idmastprosseksi" value="' . $datauntukedit[0]['id_proses_seksi'] . '"/>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="text-align:right"><button class="btn btn-success btn-save-proses-edit">Save</button></div>
                </div>';

        echo $editmasterprosesseksi;
    }
    public function insertmasterhandling()
    {
        $namahandling = $this->input->post('namahandling');
        $kodehandling = $this->input->post('kodehandling');

        $this->M_dbhandling->insertmasterhandling($namahandling, $kodehandling);


        // redirect(base_url('DbHandling/SetDataMaster'));
    }
    public function updatemasterhandling()
    {
        $id = $this->input->post('id');
        $namahandling = $this->input->post('namahandling');
        $kodehandling = $this->input->post('kodehandling');

        $this->M_dbhandling->updatemasterhandling($id, $namahandling, $kodehandling);


        // redirect(base_url('DbHandling/SetDataMaster'));
    }
    public function insertmasterprosesseksi()
    {
        $identitasseksi = $this->input->post('identitasseksi');
        $namaseksi = $this->input->post('namaseksi');
        $this->M_dbhandling->insertmasterprosesseksi($identitasseksi, $namaseksi);


        // redirect(base_url('DbHandling/SetDataMaster'));
    }
    public function updatemasterprosesesseksi()
    {
        $identitasseksi = $this->input->post('identitasseksi');
        $namaseksi = $this->input->post('namaseksi');
        $id = $this->input->post('id');

        $this->M_dbhandling->updatemasterprosesseksi($identitasseksi, $namaseksi, $id);

        // redirect(base_url('DbHandling/SetDataMaster'));
    }
    public function checkkodehandling()
    {
        $kode = $this->input->post('kode');
        $checkkode = $this->M_dbhandling->checkkodehandling($kode);

        if ($checkkode == null) {
            echo "0";
        } else {
            echo "1";
        }
    }
    public function checkkodehandling2()
    {
        $kode = $this->input->post('kode');
        $id = $this->input->post('id');

        $checkkode = $this->M_dbhandling->checkkodehandling($kode);
        $checkdata = $this->M_dbhandling->selectdatatoedit($id);

        if ($checkkode == null) {
            echo "0";
        } else {
            if ($kode == $checkdata[0]['kode_handling']) {
                echo "0";
            } else {
                echo "1";
            }
        }
    }
    public function hapusdatamasterhandling()
    {
        $id = $this->input->post('id');
        $this->M_dbhandling->hapusdatamasterhandling($id);
    }
    public function hapusdatamasterproses()
    {
        $id = $this->input->post('id');
        $this->M_dbhandling->hapusdatamasterproses($id);
    }
    public function tambahmasterstatkomp()
    {
        $input = '
        <div class="panel-body">                            
            <div class="col-md-5" style="text-align: right;"><label>Nama Status</label></div>                                        
            <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" id="namastat" class="form-control" /></div>
        </div>
        <div class="panel-body">                            
            <div class="col-md-5" style="text-align: right;"><label>Kode Status</label></div>                                        
            <div class="col-md-4" style="text-align: left;"><input oninput="this.value = this.value.toUpperCase()" maxlength="1" type="text" autocomplete="off" required="required" id="kodestat" class="form-control" /><span style="display:none;color:red;font-size:9pt" id="keterangansimboll">*Kode Status tersebut sudah digunakan</span></div>
            <div class="col-md-2" style="text-align: left;"id="simbolverifykodee"></div>
        </div>
        <div class="panel-body">
            <div class="col-md-12" style="text-align:right"><button class="btn btn-success buttonsavestat" disabled="disabled">Save</button></div>
        </div>';

        echo $input;
    }
    public function checkkodestatkomp()
    {
        $kode = $this->input->post('kode');
        $checkkode = $this->M_dbhandling->checkkodestatus($kode);

        if ($checkkode == null) {
            echo "0";
        } else {
            echo "1";
        }
    }
    public function addmasterstatkomp()
    {
        $status = $this->input->post('nama');
        $kode = $this->input->post('kode');
        $cekid = $this->M_dbhandling->selectstatuskomp();


        // echo "<pre>";
        // print_r($cekurut);
        // exit();

        if ($cekid == null) {
            $id = 1;
        } else {
            $cekurut = array();
            $i = 0;
            foreach ($cekid as $value) {
                $cekurut[$i] = $value['id_status_komponen'];
                $i++;
            }
            rsort($cekurut);
            $id = $cekurut[0] + 1;
        }

        $this->M_dbhandling->insertstatkomp($status, $kode, $id);
    }
    public function editmasterstatkomp()
    {
        $id = $this->input->post('id');
        $dataedit = $this->M_dbhandling->selectstatuskompbyid($id);
        $input = '
        <div class="panel-body">                            
            <div class="col-md-5" style="text-align: right;"><label>Nama Status</label></div>                                        
            <div class="col-md-4" style="text-align: left;"><input type="text" autocomplete="off" required="required" id="namastatedit" value="' . $dataedit[0]['status'] . '" class="form-control" /></div>
        </div>
        <div class="panel-body">                            
            <div class="col-md-5" style="text-align: right;"><label>Kode Status</label></div>                                        
            <div class="col-md-4" style="text-align: left;"><input oninput="this.value = this.value.toUpperCase()" value="' . $dataedit[0]['kode_status'] . '" maxlength="1" type="text" autocomplete="off" required="required" id="kodestatedit" class="form-control" /><span style="display:none;color:red;font-size:9pt" id="keterangansimbolll">*Kode Status tersebut sudah digunakan</span></div>
            <div class="col-md-2" style="text-align: left;"id="simbolverifykodeee"></div>
        </div>
        <div class="panel-body">
            <div class="col-md-12" style="text-align:right"><button class="btn btn-success buttonsavestatedit">Save</button></div>
        </div>';

        echo $input;
    }
    public function checkkodestatkomp2()
    {
        $kode = $this->input->post('kode');
        $id = $this->input->post('id');

        $checkkode = $this->M_dbhandling->checkkodestatus($kode);
        $cekkodeinput = $this->M_dbhandling->selectstatuskompbyid($id);

        if ($checkkode == null) {
            echo "0";
        } else {
            if ($kode == $cekkodeinput[0]['kode_status']) {
                echo "0";
            } else {
                echo "1";
            }
        }
    }
    public function updatestatkomp()
    {
        $kode = $this->input->post('kode');
        $nama = $this->input->post('nama');
        $id = $this->input->post('id');

        $this->M_dbhandling->updatestatkomp($nama, $kode, $id);
    }
    public function deletestatkomp()
    {
        $id = $this->input->post('id');
        $this->M_dbhandling->deletestatkomp($id);
    }
    public function accreqmasthand()
    {
        $id = $this->input->post('id');
        $datatoinsert = $this->M_dbhandling->selectreqmasterhandlingbyid($id);
        $this->M_dbhandling->insertmasterhandling($datatoinsert[0]['nama'], $datatoinsert[0]['kode']);
        $tgl_acc = date('Y-m-d');
        $this->M_dbhandling->updatereqmasstatusacc($tgl_acc, $id);
    }
    public function rejectreqmasthand()
    {
        $id = $this->input->post('id');
        $this->M_dbhandling->updatereqmasstatusrej($id);
    }
}
