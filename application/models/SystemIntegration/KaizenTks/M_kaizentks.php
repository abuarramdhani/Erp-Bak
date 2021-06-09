<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kaizentks extends CI_Model
{

  private $_tableKaizen = "si.si_kaizen_tks";
  private $_tableLog = "hrd_khs.tlog";

  public $no_ind;
  public $name;
  public $kaizen_title;
  public $kaizen_category;
  public $kaizen_file;
  public $created_by;
  public $section;
  public $section_code;
  public $unit;
  public $updated_at;
  public $updated_by;

  private $_location_code_tuksono = '02';

  public $kaizenCategory = array(
    "Process",
    "Quality",
    "Handling",
    "5S",
    "Safety",
    "Yokoten"
  );

  function __construct()
  {
    parent::__construct();
    $this->erp = $this->load->database('erp_db', true);
    $this->personalia = $this->load->database('personalia', true);
  }

  public function rules()
  {
    return [
      [
        'field' => 'kaizenTitle',
        'label' => 'kaizenTitle',
        'rules' => 'required'
      ],

      [
        'field' => 'slcKaizenCategory',
        'label' => 'slcKaizenCategory',
        'rules' => "required"
      ],
    ];
  }

  function getEmployees($search)
  {
    // to uppercase
    $searchUp = strtoupper($search);

    $queryTpribadi = "
      SELECT
        tp.noind,
        tp.nama as name,
        tp.kodesie as section_code,
        ts.seksi as section_name,
        ts.unit as unit_name
      FROM
        hrd_khs.tpribadi tp 
          inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie
      WHERE
        tp.keluar = false
        and tp.kd_jabatan in ('10', '11', '12', '13', '15', '17', '18', '20', '21', '23', '22', '24') -- operator, supervisor, kasie utama, madya, pratama
        and tp.lokasi_kerja = '$this->_location_code_tuksono'
        and (tp.noind like '$searchUp%' or upper(tp.nama) like '%$searchUp%')
      LIMIT 30;
    ";

    $sql = $this->personalia->query($queryTpribadi);

    return $sql->result_array();
  }

  function getCountKaizen()
  {
    return $this->erp->query("SELECT distinct on (st.no_ind) *, 
    count(*) over (partition by st.no_ind) as total
    from si.si_kaizen_tks st")->result_array();
  }

  function getKaizenByNoind($noind)
  {
    return $this->erp->query("SELECT * from si.si_kaizen_tks where no_ind = '$noind'")->result_array();
  }
  function getEmployee($id)
  {
    return $this->erp->get_where($this->_tableKaizen, ["kaizen_id" => $id])->row();
  }

  function saveKaizen($user)
  {
    $post = $this->input->post();

    $this->no_ind = $post["slcNoind"];
    $this->name = $post["employeeName"];
    $this->kaizen_title = $post["kaizenTitle"];
    $this->kaizen_category = $post["slcKaizenCategory"];
    $this->kaizen_file = $this->uploadImage($post["slcNoind"]);
    $this->created_by = $user;
    $this->section = $post["employeeSection"];
    $this->section_code = $post["sectionCode"];
    $this->unit = $post["employeeUnit"];

    if ($this->kaizen_file == "gagal") {
      return "gagal";
    } else {
      $this->erp->insert($this->_tableKaizen, $this);
    }
  }

  function saveTlog($user)
  {
    $dataLog = array(
      "wkt" =>  date('Y-m-d H:i:s'),
      "menu" => "KaizenGeneratorTKS -> InputKaizen",
      "ket" => "Noind -> " . $user,
      "noind" => $user,
      "jenis" => "Insert Kaizen Pekerja",
      "program" => "ERP -> Kaizen Pekerja Tks",
    );

    return $this->personalia->insert($this->_tableLog, $dataLog);
  }

  function updateKaizen($user)
  {
    $post = $this->input->post();
    $id = $post['id'];
    $kaizenTitle = $post['title'];
    $kaizenCategory = $post['kategori'];
    $old_file = $post['old_file'];

    if (!empty($_FILES['file'])) {
      unlink(FCPATH . "assets/upload/uploadKaizenTks/" . $old_file);
      $kaizenFile = $this->uploadImage($user, $id);
    } else {
      $kaizenFile = $post['old_file'];
    }
    if (!empty($id)) {
      $data = array(
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $user,
        'kaizen_title' => $kaizenTitle,
        'kaizen_category' => $kaizenCategory,
        'kaizen_file' => $kaizenFile
      );

      $this->erp->where('kaizen_id', $id);
      $this->erp->update($this->_tableKaizen, $data);

      echo json_encode(array(
        "statusCode" => 200
      ));
    } else {
      echo json_encode(array(
        "statusCode" => 201
      ));
    }
  }

  function deleteKaizen($id, $file)
  {
    $this->load->helper('file');
    try {

      if (base_url("assets/upload/uploadKaizenTks/" . $file)) {
        unlink(FCPATH . "assets/upload/uploadKaizenTks/" . $file);
      }

      $this->erp->delete($this->_tableKaizen, array("kaizen_id" => $id));

      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  function uploadImage($user)
  {
    $config['upload_path'] = './assets/upload/uploadKaizenTks/';
    $config['allowed_types'] = 'jpg|png|pdf|jpeg';
    $config['file_name']  = $user . "_" . time();
    $config['overwrite'] = true;
    $config['max_size'] = 4096; // 4 Mb

    $this->load->library('upload', $config);

    if ($config['allowed_types'] && $this->upload->do_upload('file')) {
      return $this->upload->data("file_name");
    } else {
      return "gagal";
    }
  }

  function tgl_indo($tanggal)
  {
    $bulan = array(
      1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

    // Array destructor
    list($tanggal, $month, $tahun) = explode('-', $tanggal);

    return $tahun . ' ' . $bulan[(int)$month] . ' ' . $tanggal;
  }
}
