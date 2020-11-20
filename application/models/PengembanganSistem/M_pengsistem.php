<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class M_pengsistem extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function responsibility_penomoran($action)
	{
		$query = $this->db->query("select * from saps.akses_penomoran where kode_akses = '".$action."' ");
		return $query->result_array();
	}

    public function ambilSemuaPekerja()
    {
        $ambilSemuaPekerja  =   "   select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       /*pkj.resign='0'
                                                and    */pkj.employee_code!='Z0000'
                                    order by    pkj.employee_code;";
        $queryAmbilSemuaPekerja     =   $this->db->query($ambilSemuaPekerja);
        return $queryAmbilSemuaPekerja->result_array();
    }

	public function seksiunit($search)
	{
		$query = $this->db->query("select * from saps.sie_departemen where singkat = '".$search."' ");
		return $query->result_array();
	}
	public function input_select_seksi($data)
	{
		$query = $this->db->query("select * from saps.sie_departemen where singkat = '".$data."' order by seksi asc");
		return $query->result_array();
	}

	public function select_seksi()
	{
		$query = $this->db->query("select * from saps.sie_departemen order by seksi asc");
		return $query->result_array();
	}

	public function set_total_fp($data,$a)
	{
	
		$query = $this->db->query("select max (*) from saps.doc_flowproses where seksi_pengguna = '".$data."' and doc = '".$a."' ");
		return $query->result_array();
	}

	public function hitung_data_seksi_fp($data,$a)
	{
	
		$query = $this->db->query("select * from saps.doc_flowproses where seksi_pengguna = '".$data."' and doc = '".$a."' ");
		return $query->result_array();
	}

	public function cek_data_nomor_fp($data)
	{
		$query = $this->db->query("select max (nomor_flow) from saps.doc_flowproses where seksi_pengguna = '$data'");
		return $query->result_array();
	}

	public function get_inputdata_fp($data)
	{
		$this->load->database();
		$this->db->insert('saps.doc_flowproses',$data);
	}

	public function list_edit_fp($data)
	{
		$query = $this->db->query("select * from saps.doc_flowproses where nomor_doc = '".$data."' ");

		return $query->result_array();
	}

	public function list_data_fp()
	{
		$query = $this->db->query("select * from saps.doc_flowproses order by nomor_doc asc ");

		return $query->result_array();
	}

	public function update_flow_fp($data,$id)
	{
		$this->db->where('nomor_doc',$id);
		$this->db->update('saps.doc_flowproses',$data);
	}

	public function upload_file_fp($data,$id)
	{
		$this->db->where('nomor_doc',$id);
		$this->db->update('saps.doc_flowproses',$data);
	}

	public function delete_flow($data)
	{
		$_id = $this->db->get_where('saps.doc_flowproses',['nomor_doc' => $data])->row();
		$query = $this->db->delete('saps.doc_flowproses',['nomor_doc'=>$data]);
		
		if($query){
			unlink("assets/upload/Peng.Sistem/fp/".$_id->file);
		}
	}

	//CODE OF PRACTICE / WI
	

	public function list_data_copwi()
	{
		$query = $this->db->query("select * from saps.doc_cop_wi order by nomor_doc asc ");

		return $query->result_array();
	}

	public function set_total_copwi($seksi,$number,$doc)
	{
		$query = $this->db->query("select count (*) from saps.doc_cop_wi where seksi_sop = '".$seksi."' and number_sop = '".$number."' and doc = '".$doc."' ");
		return $query->result_array();
	}

	public function set_number_copwi($seksi,$number,$doc)
	{
		$query = $this->db->query("select max (nomor_copwi) from saps.doc_cop_wi where seksi_sop = '".$seksi."' and number_sop = '".$number."' and doc = '".$doc."' ");
		return $query->result_array();
	}

	public function cek_data_nomor_copwi($doc,$seksi,$number_sop)
	{
		$query = $this->db->query("select max (nomor_copwi) from saps.doc_cop_wi where doc = '".$doc."' and seksi_sop = '".$seksi."' and number_sop = '".$number_sop."'");
		return $query->result_array();
	}

	public function get_inputdata_copwi($data)
	{
		$this->load->database();
		$this->db->insert('saps.doc_cop_wi',$data);
	}

	public function list_edit_copwi($data)
	{
		$query = $this->db->query("select * from saps.doc_cop_wi where nomor_doc = '".$data."' ");

		return $query->result_array();
	}

	public function update_cope($data,$id)
	{
		$this->db->where('nomor_doc',$id);
		$this->db->update('saps.doc_cop_wi',$data);
	}

	public function upload_file_copwi($data,$id)
	{
		$this->db->where('nomor_doc',$id);
		$this->db->update('saps.doc_cop_wi',$data);
	}

	public function delete_copwi($data)
	{
		$_id = $this->db->get_where('saps.doc_cop_wi',['nomor_doc' => $data])->row();
		$query = $this->db->delete('saps.doc_cop_wi',['nomor_doc'=>$data]);
		
		if($query){
			unlink("assets/upload/Peng.Sistem/copwi/".$_id->file);
		}
	}

	//User Manual
	

	public function list_data_um()
	{
		$query = $this->db->query("select * from saps.doc_usermanual order by nomor_doc asc ");

		return $query->result_array();
	}

	public function set_total_um($seksi,$number,$doc)
	{
		$query = $this->db->query("select count (*) from saps.doc_usermanual where seksi_sop = '".$seksi."' and number_sop = '".$number."' and doc = '".$doc."' ");
		return $query->result_array();
	}

	public function set_number_um($seksi,$number,$doc)
	{
		$query = $this->db->query("select max (nomor_um) from saps.doc_usermanual where seksi_sop = '".$seksi."' and number_sop = '".$number."' and doc = '".$doc."' ");
		return $query->result_array();
	}

	public function get_inputdata_um($data)
	{
		$this->load->database();
		$this->db->insert('saps.doc_usermanual',$data);
	}

	public function list_edit_um($data)
	{
		$query = $this->db->query("select * from saps.doc_usermanual where nomor_doc = '".$data."' ");

		return $query->result_array();
	}

	public function update_data_um($data,$id)
	{
		$this->db->where('nomor_doc',$id);
		$this->db->update('saps.doc_usermanual',$data);
	}

	public function cek_data_nomor_um($data)
	{
		$query = $this->db->query("select * from saps.doc_usermanual where nomor_doc = '$data' ");
		return $query->result_array();
	}

	public function upload_file_um($data,$id)
	{
		$this->db->where('nomor_doc',$id);
		$this->db->update('saps.doc_usermanual',$data);
	}

	public function delete_um($data)
	{
		$_id = $this->db->get_where('saps.doc_usermanual',['nomor_doc' => $data])->row();
		$query = $this->db->delete('saps.doc_usermanual',['nomor_doc'=>$data]);
		
		if($query){
			unlink("assets/upload/Peng.Sistem/um/".$_id->file);
		}
	}

	//Penomoran Memo


	public function list_data_memo()
	{
		$query = $this->db->query("select * from saps.doc_penomoran_memo order by date_doc desc ");
		
		return $query->result_array();
	}

	public function list_edit_memo($data)
	{
		$query = $this->db->query("select * from saps.doc_penomoran_memo where id = '".$data."' ");

		return $query->result_array();
	}

	public function getCountData($date,$kode)
	{
	
		$query = $this->db->query("select count (*) from saps.doc_penomoran_memo where date_doc between '".$date."-01' and '".$date."-".date('t')."' and kode_doc = '".$kode."' ");
		return $query->result_array();
	}

	public function get_kode($data)
	{
		$this->load->database();
		$this->db->insert('saps.doc_penomoran_memo', $data);
	}

	public function total_data($date,$kode)
	{
	
		$query = $this->db->query("select count (*) from saps.doc_penomoran_memo where date_doc between '".$date."-01' and '".$date."-".date('t')."' and kode_doc ='".$kode."' ");
		return $query->result_array();
	}

	public function get_update_code($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('saps.doc_penomoran_memo',$data);
	}

	public function upload_file_code($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('saps.doc_penomoran_memo',$data);
	}

	public function delete_code($data)
	{
		$_id = $this->db->get_where('saps.doc_penomoran_memo',['id' => $data])->row();
		$query = $this->db->delete('saps.doc_penomoran_memo',['id'=>$data]);
		
		if($query){
			unlink("assets/upload/Peng.Sistem/memo/".$_id->file);
		}
	}

	//Laporan Kerja Harian

	public function list_data_lkh()
	{
		$query = $this->db->query("select * from saps.lkh_operator_ps order by tglmasuk desc ");
		
		return $query->result_array();
	}

	public function set_lkh($param,$user)
	{
		$query = $this->db->query("select * from saps.lkh_operator_ps where bulan = '".$param."' and pic = '".$user."' order by tglmasuk asc ");

		return $query->result_array();
	}

	public function set_lkh1($user)
	{
		$query = $this->db->query("select * from saps.lkh_operator_ps where bulan = '".date('m-Y')."' and pic = '".$user."' order by tglmasuk asc ");

		return $query->result_array();
	}

	public function get_lkh_input($data)
	{
		$this->load->database();
		$this->db->insert('saps.lkh_operator_ps', $data);
	}

	public function delete_lkh_get($data)
	{
		$this->db->where('id',$data);
		$this->db->delete('saps.lkh_operator_ps');
	}

	public function setdata($all,$user)
	{
			$this->db->select('*');
			$this->db->from('saps.lkh_operator_ps');
			$this->db->where('bulan',$all);
			$this->db->like('pic',$user);
			$this->db->order_by('tglmasuk');
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function cek_data_lkh($data)
	{
		$query = $this->db->query("select * from saps.lkh_operator_ps where tglmasuk = '$data'");
		return $query->result_array();
	}


}