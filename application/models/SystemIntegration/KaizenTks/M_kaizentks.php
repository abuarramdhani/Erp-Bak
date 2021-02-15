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
    $query = $this->erp->select("
    trim(eea.employee_code) as noind, 
    trim(employee_name) as name, 
    trim(ees.section_code) as section_code, 
    trim(ees.unit_name) as unit_name, 
    trim(ees.section_name) as section_name
    ")
      ->from("er.er_employee_all eea ")
      ->join("er.er_section ees", "ees.section_code = eea.section_code");
    if ($search != "") {
      $query->like("eea.employee_code", "$searchUp");
    }
    return $query->get()->result_array();
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
    $this->kaizen_file = $this->uploadImage();
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

  // function updateKaizen()
  // {
  //   $post = $this->input->post();
  //   $this->kaizen_id = $post["id"];
  //   $this->no_ind = $post["no_ind"];
  //   $this->name = $post["name"];
  //   $this->kaizen_title = $post["title"];
  //   $this->kaizen_category = $post["category"];

  //   if (!empty($_FILES['inputFile']["kaizen_file"])) {
  //     $this->kaizen_file = $this->uploadImage();
  //   } else {
  //     $this->kaizen_file = $post['old_image'];
  //   }

  //   $this->created_by = $post["user"];
  //   $this->section = $post["section"];
  //   $this->unit = $post["unit"];

  //   return $this->erp->update($this->_tableKaizen, $this, array('kaizen_id' => $post['id']));
  // }

  //gae update i ngene uduk ? ntah aku ra apal syntax e
  function updateKaizen($data, $id)
  {
    $this->erp->where('kaizen_id', $id);
    $this->erp->update($this->_tableKaizen, $data);
  }

  function deleteKaizen($id, $file)
  {
    // print("<pre>");
    // print_r($file);
    // die;
    $this->load->helper('file');
    if (base_url("assets/upload/uploadKaizenTks/" . $file)) {
      unlink(FCPATH . "assets/upload/uploadKaizenTks/" . $file);
      echo FCPATH . "assets/upload/uploadKaizenTks/" . $file;
      // die;
    } else {
      echo "hemmm";
      // die;
    }
    $this->erp->delete($this->_tableKaizen, array("kaizen_id" => $id));
  }

  function uploadImage()
  {

    $config['upload_path'] = './assets/upload/uploadKaizenTks/';
    $config['allowed_types'] = 'jpg|png|pdf';
    $config['file_name']  = $this->kaizen_id;
    $config['overwrite'] = true;
    $config['max_size'] = 3048;

    $this->load->library('upload', $config);

    if ($config['allowed_types'] && $this->upload->do_upload('inputFile')) {
      return $this->upload->data("file_name");
    } else {
      return "gagal";
    }
  }
}
