<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_datalkhseksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLKHSeksi($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_lkh_seksi');
    	} else {
    		$query = $this->db->get_where('pr.pr_lkh_seksi', array('lkh_seksi_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getLKHSeksiDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_lkh_seksi pls
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pls.noind
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getLKHSeksiSearch($searchValue)
    {
        $sql = "
            SELECT * FROM pr.pr_lkh_seksi pls
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pls.noind
            WHERE
                    pls.\"noind\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses\"  ILIKE '%$searchValue%'
                OR  pls.\"shift\"  ILIKE '%$searchValue%'
                OR  pls.\"status\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang_target_sementara\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses_target_sementara\"  ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  CAST(pls.\"jml_barang\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmat\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmch\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"repair\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"reject\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"setting_time\" AS TEXT) ILIKE '%$searchValue%'

                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getLKHSeksiOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    pls.\"noind\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses\"  ILIKE '%$searchValue%'
                OR  pls.\"shift\"  ILIKE '%$searchValue%'
                OR  pls.\"status\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_barang_target_sementara\"  ILIKE '%$searchValue%'
                OR  pls.\"kode_proses_target_sementara\"  ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  CAST(pls.\"jml_barang\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmat\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"afmch\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"repair\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"reject\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pls.\"setting_time\" AS TEXT) ILIKE '%$searchValue%'

            ";
        }
        $sql="
            SELECT * FROM pr.pr_lkh_seksi pls
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pls.noind

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function setLKHSeksi($data)
    {
        return $this->db->insert('pr.pr_lkh_seksi', $data);
    }

    public function updateKondite($data, $id)
    {
        $this->db->where('kondite_id', $id);
        $this->db->update('pr.pr_kondite', $data);
    }

    public function deleteKondite($id)
    {
        $this->db->where('kondite_id', $id);
        $this->db->delete('pr.pr_kondite');
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

    public function clearData($firstdate, $lastdate)
    {
        $sql = "
            DELETE

            FROM
                pr.pr_lkh_seksi pls

            WHERE
                pls.\"tgl\" BETWEEN '$firstdate' AND '$lastdate'
        ";

        $query = $this->db->query($sql);
        return;
    }

    public function get_ott_data($peroide,$condition)
    {
        if($condition == 1){
            $order ="left(es.section_code, 7), es.department_name, es.field_name, es.unit_name, es.section_name,
                eea.worker_status_code";
        }elseif($condition == 2){
            $order ="eea.worker_status_code, left(es.section_code, 7), es.department_name, es.field_name, es.unit_name, es.section_name";
        }else{
            $order ="date_part('month',pls.tgl), left(es.section_code, 7), es.department_name, es.field_name, es.unit_name, es.section_name";
        }

        $sql = "select eea.worker_status_code, date_part('month',pls.tgl) as bln, count( distinct pls.noind) as jumlah, 
                left(es.section_code, 7) as s_code, es.department_name, es.field_name, es.unit_name, es.section_name
            from pr.pr_lkh_seksi pls
            left join er.er_employee_all eea on eea.employee_code = pls.noind
            left join er.er_section es on es.section_code = eea.section_code
            where date_part('year',pls.tgl)='$peroide' and left(es.section_code, 7) in
                ('3250102','3040201','3020102','3020101','3020103','3020104','3020104','3020103','3020101','3020102','3040103',
                '3040101','3040102','3040301','3200104','3010101','3280101')
            group by eea.worker_status_code, date_part('month',pls.tgl), 
                left(es.section_code, 7), es.department_name, es.field_name, es.unit_name, es.section_name
            order by ".$order;
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_Cek_LKH($jenis, $bulan, $tahun)
    {
        if($jenis == 10){
            $clip_1 = "";
            $clip_2 = "left join pr.pr_lkh_seksi pls  on pls.noind=pa.noind_ and pls.tgl=pa.tgl_::date 
                       left join er.er_employee_all eea on pa.noind_=eea.employee_code
                       left join er.er_section es on eea.section_code=es.section_code
                       where date_part('year',pa.tgl_::date)='$tahun' and date_part('month',pa.tgl_::date)='$bulan' 
                        and left(pa.shift,1) != '.' and pls.noind is null order by pa.noind_, pa.tgl_";
        }elseif($jenis == 01){
            $clip_1 = "pr.pr_lkh_seksi pls left join ";
            $clip_2 = "on pls.noind=pa.noind_ and pls.tgl=pa.tgl_::date 
                       left join er.er_employee_all eea on pls.noind=eea.employee_code
                       left join er.er_section es on eea.section_code=es.section_code
                       where date_part('year',pls.tgl::date)='$tahun' and date_part('month',pls.tgl::date)='$bulan' 
                        and pa.noind_ is null order by pls.noind, pls.tgl";
        }else{
            $clip_1 = "";
            $clip_2 = "left join pr.pr_lkh_seksi pls  on pls.noind=pa.noind_ and pls.tgl=pa.tgl_::date
                       left join er.er_employee_all eea on pa.noind_=eea.employee_code
                       left join er.er_section es on eea.section_code=es.section_code
                       where date_part('year',pa.tgl_::date)='$tahun' and date_part('month',pa.tgl_::date)='$bulan' 
                        and left(pa.shift,1) = '.' order by pa.noind_, pa.tgl_";
        }

        if(strlen($bulan) == 1){
            $txt_bln = '0'.$bulan;
        }else{
            $txt_bln = $txt_bln;
        }

        $sql="
        select distinct pa.*, pls.tgl, pls.noind ,eea.employee_name, es.section_name
        from $clip_1
        (SELECT v.* from pr.pr_absensi p, LATERAL (
           VALUES
            (p.thn_gaji || '-' || '$txt_bln-' || '01', noind, \"HM01\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '02', noind, \"HM02\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '03', noind, \"HM03\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '04', noind, \"HM04\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '05', noind, \"HM05\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '06', noind, \"HM06\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '07', noind, \"HM07\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '08', noind, \"HM08\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '09', noind, \"HM09\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '10', noind, \"HM10\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '11', noind, \"HM11\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '12', noind, \"HM12\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '13', noind, \"HM13\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '14', noind, \"HM14\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '15', noind, \"HM15\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '16', noind, \"HM16\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '17', noind, \"HM17\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '18', noind, \"HM18\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '19', noind, \"HM19\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '20', noind, \"HM20\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '21', noind, \"HM21\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '22', noind, \"HM22\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '23', noind, \"HM23\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '24', noind, \"HM24\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '25', noind, \"HM25\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '26', noind, \"HM26\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '27', noind, \"HM27\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '28', noind, \"HM28\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '29', noind, \"HM29\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '30', noind, \"HM30\"),
            (p.thn_gaji || '-' || '$txt_bln-' || '31', noind, \"HM31\")
           ) v (tgl_, noind_, shift)) pa $clip_2";

        $query = $this->db->query($sql);
        return $query;
    }

}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */