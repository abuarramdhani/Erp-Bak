<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kaizentks extends CI_Model
{

  private $_tableKaizen = "si.si_kaizen_tks";
  private $_tableLog = "hrd_khs.tlog";

  public $kaizen_id;
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
    $searchUp = strtoupper($search);

    $query = $this->erp->query("select trim(eea.employee_code) as noind, 
    trim(employee_name) as name, 
    trim(ees.section_code) as section_code, 
    trim(ees.unit_name) as unit_name, 
    trim(ees.section_name) as section_name
    from er.er_employee_all eea 
    	inner join er.er_section ees on ees.section_code = eea.section_code
   where eea.section_code in ('325020100',
	'320010100',
	'329010103',
	'329030100',
	'330100701',
	'330101103',
	'325010805',
	'322010101',
	'321010300',
	'328010305',
	'323020101',
	'323010100',
	'323030102',
	'331010103',
	'326010100',
	'324010101') and to_char(eea.resign_date, 'YYYY-MM') >= to_char(current_date,'YYYY-MM')  and eea.employee_code like '%$searchUp%'");

    return $query->result_array();
  }

  // function getAllKaizen()
  // {
  //   // $query = $this->erp->select("*")
  //   //   ->from("si.si_kaizen_tks");
  //   // $query->get()->result_array();
  //   return $this->erp->query("SELECT * from si.si_kaizen_tks")->result_array(); //seharus e ngene ki we gelem ki la iyo
  //   // print("<pre>");
  //   // print_r($query);
  //   // die;

  //   // return $query;
  // }

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
  function kaizenCategory()
  {
    $category =  array(
      "Process",
      "Quality",
      "Handling",
      "5S",
      "Safety",
      "Yokoten"
    );
    return $category;
  }

  function saveKaizen($user)
  {
    $randomId = abs(crc32(uniqid()));
    $post = $this->input->post();
    $this->kaizen_id = $randomId;
    $this->no_ind = $post["slcNoind"];
    $this->name = $post["employeeName"];
    $this->kaizen_title = $post["kaizenTitle"];
    $this->kaizen_category = $post["slcKaizenCategory"];
    $this->kaizen_file = $this->uploadImage($post["slcNoind"], $randomId);
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
    if (base_url("assets/upload/uploadKaizenTks/" . $file)) {
      unlink(FCPATH . "assets/upload/uploadKaizenTks/" . $file);
      echo json_encode(array(
        "statusCode" => 200
      ));
    } else {
      echo "gagal menghapus";
    }
    $this->erp->delete($this->_tableKaizen, array("kaizen_id" => $id));
  }

  function uploadImage($user, $id)
  {
    $config['upload_path'] = './assets/upload/uploadKaizenTks/';
    $config['allowed_types'] = 'jpg|png|pdf|jpeg';
    $config['file_name']  = $user . "_" . $id;
    $config['overwrite'] = true;
    $config['max_size'] = 3048;
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
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
  }
}
