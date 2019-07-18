<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dataabsensi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAbsensi($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_absensi');
    	} else {
    		$query = $this->db->get_where('pr.pr_absensi', array('absensi_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getAbsensiDatatables($dataFilter = False)
    {
        $filter = "";
        if ($dataFilter !== FALSE && trim($dataFilter) !== "") {
           $dt = explode("-", $dataFilter);
            $filter = "where pab.bln_gaji = '".$dt[0]."' and pab.thn_gaji = '".$dt[1]."' and trim(pab.ket) = trim('".$dt[2]."')";
        }
        $sql = "
            SELECT * FROM pr.pr_absensi pab
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pab.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pab.kodesie  $filter      
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAbsensiSearch($searchValue,$datafilter)
    {
        $filter = "";
        if (!empty($datafilter) && trim($datafilter) !== "") {
            $dt = explode("-", $datafilter);
            $filter = "and pab.bln_gaji = '".$dt[0]."' and pab.thn_gaji = '".$dt[1]."' and trim(pab.ket) = trim('".$dt[2]."')";
        }
        $sql = "
            select * from pr.pr_absensi pab
            left join er.er_employee_all eea on eea.employee_code = pab.noind
            left join (select distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) from er.er_section where unit_name != '-') as t(section_code_substr, unit_name) on section_code_substr = pab.kodesie
            where
                (
                    pab.noind ilike '%$searchValue%'
                or  pab.kodesie ilike '%$searchValue%'
                or  pab.hm01 ilike '%$searchValue%'
                or  pab.hm02 ilike '%$searchValue%'
                or  pab.hm03 ilike '%$searchValue%'
                or  pab.hm04 ilike '%$searchValue%'
                or  pab.hm05 ilike '%$searchValue%'
                or  pab.hm06 ilike '%$searchValue%'
                or  pab.hm07 ilike '%$searchValue%'
                or  pab.hm08 ilike '%$searchValue%'
                or  pab.hm09 ilike '%$searchValue%'
                or  pab.hm10 ilike '%$searchValue%'
                or  pab.hm11 ilike '%$searchValue%'
                or  pab.hm12 ilike '%$searchValue%'
                or  pab.hm13 ilike '%$searchValue%'
                or  pab.hm14 ilike '%$searchValue%'
                or  pab.hm15 ilike '%$searchValue%'
                or  pab.hm16 ilike '%$searchValue%'
                or  pab.hm17 ilike '%$searchValue%'
                or  pab.hm18 ilike '%$searchValue%'
                or  pab.hm19 ilike '%$searchValue%'
                or  pab.hm20 ilike '%$searchValue%'
                or  pab.hm21 ilike '%$searchValue%'
                or  pab.hm22 ilike '%$searchValue%'
                or  pab.hm23 ilike '%$searchValue%'
                or  pab.hm24 ilike '%$searchValue%'
                or  pab.hm25 ilike '%$searchValue%'
                or  pab.hm26 ilike '%$searchValue%'
                or  pab.hm27 ilike '%$searchValue%'
                or  pab.hm28 ilike '%$searchValue%'
                or  pab.hm29 ilike '%$searchValue%'
                or  pab.hm30 ilike '%$searchValue%'
                or  pab.hm31 ilike '%$searchValue%'
                or  pab.kode_lokasi ilike '%$searchValue%'
                or  eea.employee_name ilike '%$searchValue%'
                or  unit_name ilike '%$searchValue%'
                or  cast(pab.bln_gaji as text) ilike '%$searchValue%'
                or  cast(pab.thn_gaji as text) ilike '%$searchValue%'
                or  cast(pab.jam_lembur as text) ilike '%$searchValue%'
                or  cast(pab.hmp as text) ilike '%$searchValue%'
                or  cast(pab.hmu as text) ilike '%$searchValue%'
                or  cast(pab.hms as text) ilike '%$searchValue%'
                or  cast(pab.hmm as text) ilike '%$searchValue%'
                or  cast(pab.hm as text) ilike '%$searchValue%'
                or  cast(pab.ubt as text) ilike '%$searchValue%'
                or  cast(pab.hupamk as text) ilike '%$searchValue%'
                or  cast(pab.ik as text) ilike '%$searchValue%'
                or  cast(pab.ikskp as text) ilike '%$searchValue%'
                or  cast(pab.iksku as text) ilike '%$searchValue%'
                or  cast(pab.iksks as text) ilike '%$searchValue%'
                or  cast(pab.ikskm as text) ilike '%$searchValue%'
                or  cast(pab.ikjsp as text) ilike '%$searchValue%'
                or  cast(pab.ikjsu as text) ilike '%$searchValue%'
                or  cast(pab.ikjss as text) ilike '%$searchValue%'
                or  cast(pab.ikjsm as text) ilike '%$searchValue%'
                or  cast(pab.abs as text) ilike '%$searchValue%'
                or  cast(pab.t as text) ilike '%$searchValue%'
                or  cast(pab.skd as text) ilike '%$searchValue%'
                or  cast(pab.cuti as text) ilike '%$searchValue%'
                or  cast(pab.hl as text) ilike '%$searchValue%'
                or  cast(pab.pt as text) ilike '%$searchValue%'
                or  cast(pab.pi as text) ilike '%$searchValue%'
                or  cast(pab.pm as text) ilike '%$searchValue%'
                or  cast(pab.dl as text) ilike '%$searchValue%'
                or  cast(pab.tambahan as text) ilike '%$searchValue%'
                or  cast(pab.duka as text) ilike '%$searchValue%'
                or  cast(pab.potongan as text) ilike '%$searchValue%'
                or  cast(pab.hc as text) ilike '%$searchValue%'
                or  cast(pab.jml_um as text) ilike '%$searchValue%'
                or  cast(pab.cicil as text) ilike '%$searchValue%'
                or  cast(pab.potongan_koperasi as text) ilike '%$searchValue%'
                or  cast(pab.ubs as text) ilike '%$searchValue%'
                or  cast(pab.um_puasa as text) ilike '%$searchValue%'
                or  cast(pab.sk_ct as text) ilike '%$searchValue%'
                or  cast(pab.pot_2 as text) ilike '%$searchValue%'
                or  cast(pab.tamb_2 as text) ilike '%$searchValue%'
                or  cast(pab.jml_izin as text) ilike '%$searchValue%'
                or  cast(pab.jml_mangkir as text) ilike '%$searchValue%'
                ) 
                $filter

        ";
        // echo $sql;exit();
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAbsensiOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset, $dataFilter = FALSE){
        $filter = "";
        if ($dataFilter !== FALSE && trim($dataFilter) !== "") {
            $dt = explode("-", $dataFilter);
            if ($searchValue == NULL || $searchValue == "") {
                $filter = "where pab.bln_gaji = '".$dt[0]."' and pab.thn_gaji = '".$dt[1]."' and trim(pab.ket) = trim('".$dt[2]."')";
            }else{
                $filter = "and pab.bln_gaji = '".$dt[0]."' and pab.thn_gaji = '".$dt[1]."' and trim(pab.ket) = trim('".$dt[2]."')";  
            }
        }
        if ($searchValue == NULL || $searchValue == "") {
            $condition = $filter;
        }
        else{
            $condition = "
                where
                    (pab.noind ilike '%$searchValue%'
                or  pab.kodesie ilike '%$searchValue%'
                or  pab.hm01 ilike '%$searchValue%'
                or  pab.hm02 ilike '%$searchValue%'
                or  pab.hm03 ilike '%$searchValue%'
                or  pab.hm04 ilike '%$searchValue%'
                or  pab.hm05 ilike '%$searchValue%'
                or  pab.hm06 ilike '%$searchValue%'
                or  pab.hm07 ilike '%$searchValue%'
                or  pab.hm08 ilike '%$searchValue%'
                or  pab.hm09 ilike '%$searchValue%'
                or  pab.hm10 ilike '%$searchValue%'
                or  pab.hm11 ilike '%$searchValue%'
                or  pab.hm12 ilike '%$searchValue%'
                or  pab.hm13 ilike '%$searchValue%'
                or  pab.hm14 ilike '%$searchValue%'
                or  pab.hm15 ilike '%$searchValue%'
                or  pab.hm16 ilike '%$searchValue%'
                or  pab.hm17 ilike '%$searchValue%'
                or  pab.hm18 ilike '%$searchValue%'
                or  pab.hm19 ilike '%$searchValue%'
                or  pab.hm20 ilike '%$searchValue%'
                or  pab.hm21 ilike '%$searchValue%'
                or  pab.hm22 ilike '%$searchValue%'
                or  pab.hm23 ilike '%$searchValue%'
                or  pab.hm24 ilike '%$searchValue%'
                or  pab.hm25 ilike '%$searchValue%'
                or  pab.hm26 ilike '%$searchValue%'
                or  pab.hm27 ilike '%$searchValue%'
                or  pab.hm28 ilike '%$searchValue%'
                or  pab.hm29 ilike '%$searchValue%'
                or  pab.hm30 ilike '%$searchValue%'
                or  pab.hm31 ilike '%$searchValue%'
                or  pab.kode_lokasi ilike '%$searchValue%'
                or  eea.employee_name ilike '%$searchValue%'
                or  unit_name ilike '%$searchValue%'
                or  cast(pab.bln_gaji as text) ilike '%$searchValue%'
                or  cast(pab.thn_gaji as text) ilike '%$searchValue%'
                or  cast(pab.jam_lembur as text) ilike '%$searchValue%'
                or  cast(pab.hmp as text) ilike '%$searchValue%'
                or  cast(pab.hmu as text) ilike '%$searchValue%'
                or  cast(pab.hms as text) ilike '%$searchValue%'
                or  cast(pab.hmm as text) ilike '%$searchValue%'
                or  cast(pab.hm as text) ilike '%$searchValue%'
                or  cast(pab.ubt as text) ilike '%$searchValue%'
                or  cast(pab.hupamk as text) ilike '%$searchValue%'
                or  cast(pab.ik as text) ilike '%$searchValue%'
                or  cast(pab.ikskp as text) ilike '%$searchValue%'
                or  cast(pab.iksku as text) ilike '%$searchValue%'
                or  cast(pab.iksks as text) ilike '%$searchValue%'
                or  cast(pab.ikskm as text) ilike '%$searchValue%'
                or  cast(pab.ikjsp as text) ilike '%$searchValue%'
                or  cast(pab.ikjsu as text) ilike '%$searchValue%'
                or  cast(pab.ikjss as text) ilike '%$searchValue%'
                or  cast(pab.ikjsm as text) ilike '%$searchValue%'
                or  cast(pab.abs as text) ilike '%$searchValue%'
                or  cast(pab.t as text) ilike '%$searchValue%'
                or  cast(pab.skd as text) ilike '%$searchValue%'
                or  cast(pab.cuti as text) ilike '%$searchValue%'
                or  cast(pab.hl as text) ilike '%$searchValue%'
                or  cast(pab.pt as text) ilike '%$searchValue%'
                or  cast(pab.pi as text) ilike '%$searchValue%'
                or  cast(pab.pm as text) ilike '%$searchValue%'
                or  cast(pab.dl as text) ilike '%$searchValue%'
                or  cast(pab.tambahan as text) ilike '%$searchValue%'
                or  cast(pab.duka as text) ilike '%$searchValue%'
                or  cast(pab.potongan as text) ilike '%$searchValue%'
                or  cast(pab.hc as text) ilike '%$searchValue%'
                or  cast(pab.jml_um as text) ilike '%$searchValue%'
                or  cast(pab.cicil as text) ilike '%$searchValue%'
                or  cast(pab.potongan_koperasi as text) ilike '%$searchValue%'
                or  cast(pab.ubs as text) ilike '%$searchValue%'
                or  cast(pab.um_puasa as text) ilike '%$searchValue%'
                or  cast(pab.sk_ct as text) ilike '%$searchValue%'
                or  cast(pab.pot_2 as text) ilike '%$searchValue%'
                or  cast(pab.tamb_2 as text) ilike '%$searchValue%'
                or  cast(pab.jml_izin as text) ilike '%$searchValue%'
                or  cast(pab.jml_mangkir as text) ilike '%$searchValue%')  
                $filter
            ";
        }
        $sql="
            SELECT * FROM pr.pr_absensi pab
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pab.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pab.kodesie

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function cek_absensi($where){
        $this->db->where($where);
        $query = $this->db->get('pr.pr_absensi');
        return $query->num_rows();
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('pr.pr_absensi', $data);
    }

    public function updateAbsensi($data,$where){
        $this->db->where($where);
        $this->db->delete('pr.pr_absensi',$data);
    }

    public function clearAbsensi($data)
    {
        $this->db->where($data);
        $this->db->delete('pr.pr_absensi');
    }

	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}


	public function getSection()
	{
		$query = $this->db->get('er.er_section');

		return $query->result_array();
	}

    public function setProgress($type,$progress,$user){
        $sql = "insert into pr.pr_progress 
                (type_progress,percentage_progress,user_progress)
                values
                ('$type',$progress,'$user')";
        $this->db->query($sql);
    }

    public function updateProgress($type,$progress,$user){
        $sql = "update pr.pr_progress
                set percentage_progress = '$progress'
                where user_progress = '$user'
                and type_progress = '$type'
                and timestamp_progress::date = current_date";
        $this->db->query($sql);
    }

    public function getProgress($user,$type){
        $sql = "select percentage_progress 
                from pr.pr_progress
                where user_progress = '$user'
                and type_progress = '$type'
                and timestamp_progress::date = current_date
                order by timestamp_progress desc 
                limit 1";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $array = $result->result_array();
            return $array['0']['percentage_progress'];
        }else{
            return 0;
        }
        
    }

    public function check_connection(){
        return $this->db->initialize();
    }

    public function getDataPresensi(){
        $sql = "select thn_gaji,bln_gaji,ket, count(thn_gaji) jumlah
                from pr.pr_absensi
                where thn_gaji is not null
                or bln_gaji is not null
                group by thn_gaji,bln_gaji,ket
                order by bln_gaji,thn_gaji,ket";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getDetailDataPresensi($bulan,$tahun,$ket){
        $sql = "select pa.*,eea.employee_name 
                from pr.pr_absensi pa 
                inner join er.er_employee_all eea 
                on eea.employee_code = pa.noind
                where pa.thn_gaji = '$tahun'
                and pa.bln_gaji = '$bulan'
                and pa.ket = '$ket'";
        $result = $this->db->query($sql);
        return $result->result_array();       
    }
}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */