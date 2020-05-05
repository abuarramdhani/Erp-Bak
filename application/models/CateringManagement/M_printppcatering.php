<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_printppcatering extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getPrintpp($id = FALSE)
    {
    	if ($id === FALSE) {
            $sql = "select * from ga.ga_printpp where pp_catering_lokasi is not null order by tgl_buat desc";
    		// $query = $this->db->get('ga.ga_printpp');
            $query = $this->db->query($sql);
    	} else {
    		// $query = $this->db->get_where('ga.ga_printpp', array('pp_id' => $id));
    		$query = $this->db->query("
    			select
					pp.*,
					er1.employee_name as kadept,
					er2.employee_name as direksi,
					er3.employee_name as kasie,
					er4.employee_name as kaunit,
					er5.employee_name as siepembelian
				from
					ga.ga_printpp pp
				left join er.er_employee_all er1 on er1.employee_id = cast(pp.pp_kadept as integer)
				left join er.er_employee_all er2 on er2.employee_id = cast(pp.pp_direksi as integer)
				left join er.er_employee_all er3 on er3.employee_id = cast(pp.pp_kasie as integer)
				left join er.er_employee_all er4 on er4.employee_id = cast(pp.pp_kaunit as integer)
				left join er.er_employee_all er5 on er5.employee_id = cast(pp.pp_siepembelian as integer)
				where
					pp.pp_id = '".$id."' order by pp.tgl_buat desc"
    		);
    	}

    	return $query->result_array();
    }

    public function getPrintppDetail($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_printpp_detail');
    	} else {
    		$query = $this->db->get_where('ga.ga_printpp_detail', array('pp_id' => $id));
    	}

    	return $query->result_array();
    }

    public function createPrintpp($temp)
    {
        return $this->db->insert('ga.ga_printpp', $temp);
    }

    public function createPrintppDetail($lines)
    {
        return $this->db->insert('ga.ga_printpp_detail', $lines);
    }

    public function updatePrintpp($temp, $id)
    {
        $this->db->where('pp_id', $id);
        $this->db->update('ga.ga_printpp', $temp);
    }

    public function updatePrintppDetail($lines, $id)
    {
        $this->db->where('pp_detail_id', $id);
        $this->db->update('ga.ga_printpp_detail', $lines);
    }

    public function deletePrintpp($id)
    {
        $this->db->where('pp_id', $id);
        $this->db->delete('ga.ga_printpp');

        $this->db->where('pp_id', $id);
        $this->db->delete('ga.ga_printpp_detail');

    }

    public function deletePrintppDetail($id)
    {
    	$this->db->where('pp_detail_id', $id);
        $this->db->delete('ga.ga_printpp_detail');
    }

    public function deleteDetailNotInIDAll($pp_detail_id,$pp_id){
        $sql = "delete from ga.ga_printpp_detail
                where pp_id = $pp_id 
                and pp_detail_id not in ($pp_detail_id)";
        $this->db->query($sql);
    }

	public function getSection()
	{
		$query = $this->db->query("select er_section_id,section_name from er.er_section where job_name='-' and section_name not in ('-')");

		return $query->result_array();
	}


	public function getEmployeeAll($key)
	{
		// $query = $this->db->get_where('er.er_employee_all', array('employee_name' => $key));
		$query = $this->db->query("SELECT * from er.er_employee_all where upper(employee_name) like upper('%".$key."%') and resign='0'");
		return $query->result_array();
	}

	public function getEmployeeSelected()
	{
		$query = $this->db->get('er.er_employee_all');
		return $query->result_array();
	}

	public function getBranch()
	{
		$query = $this->db->get('ga.ga_branch');

		return $query->result_array();
	}

	public function getCostCenter()
	{
		$query = $this->db->get('ga.ga_cost_center');

		return $query->result_array();
	}

    public function kodeItem()
    {
        $query = $this->db->get('ga.ga_master_item');

        return $query->result_array();
    }

    public function kodeItem2($key)
    {
        $sql = "select * from ga.ga_master_item where kode_item like '%$key%'";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    public function namaItem($key)
    {
        $sql = "select * from ga.ga_master_item where kode_item = '$key'";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getCateringKode($id){
        $sql = "select *
                from cm.cm_catering
                where catering_id = ?";
        $result = $this->db->query($sql,array($id))->row();
        if (!empty($result)) {
            return $result->catering_code;
        }else{
            return 'nan';
        }
    }

    public function getDeptQty($tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan){
        $sql = "select dept,
                    fs_nama_katering as katering,
                    sum(jumlah) as jumlah,
                    case when '1' = ? then 
                        'AA'
                    when '2' = ? then 
                        'AC'
                    end as branch,
                    case when dept = 'KEUANGAN' then 
                        '1Z01'
                    when dept = 'PEMASARAN' then 
                        '3Z01'
                    when dept = 'PRODUKSI' then 
                        case when '1' = ? then 
                            '5Z01'
                        when '2' = ? then 
                            '7Z01'
                        end
                    when dept = 'PERSONALIA' then 
                        '2Z01'
                    end as cc,
                    case when '1' = ? then 
                        'JASA24'
                    when '0' = ? then 
                        'JASA02'
                    end as kode,
                    'PCS' as satuan,
                    case when '1' = ? then 
                        'JASA NASI BOX CATERING '
                    when '0' = ? then 
                        'JASA BOGA (NON NASI BOX CATERING)'
                    end as nama,
                    ?::date as awal,
                    ?::date as akhir
                from (
                    select tph.fs_tempat_makan,
                        sum(fn_jumlah_pesan) as jumlah,
                        coalesce((
                            select
                                trim(ts.dept) as dept
                            from hrd_khs.tpribadi tp
                            left join hrd_khs.tseksi ts
                            on tp.kodesie = ts.kodesie
                            where tp.keluar = '0'
                            and tp.lokasi_kerja in ('01','02','03','04')
                            and trim(tp.tempat_makan) = trim(tph.fs_tempat_makan)
                            group by trim(tp.tempat_makan),trim(ts.dept)
                            order by 1 desc 
                            limit 1
                        ), 'PERSONALIA')::varchar as dept,
                    tuk.fs_nama_katering
                    from \"Catering\".tpesanan_history tph 
                    inner join \"Catering\".turutankatering tuk
                    on tph.fd_tanggal = tuk.fd_tanggal
                    and tph.fs_tanda = tuk.fn_urutan::varchar
                    inner join \"Catering\".ttempat_makan ttm 
                    on tph.fs_tempat_makan = ttm.fs_tempat_makan
                    where tph.fd_tanggal between ? and ?
                    and tph.lokasi = ?
                    and tph.jenis_pesanan = ?
                    group by tph.fs_tempat_makan,tuk.fs_nama_katering
                ) as tbl 
                group by dept,fs_nama_katering
                order by fs_nama_katering,dept,3";
        $this->personalia = $this->load->database('personalia', true);
        return $this->personalia->query($sql,array($lokasi,$lokasi,$lokasi,$lokasi,$jenis_pesanan,$jenis_pesanan,$jenis_pesanan,$jenis_pesanan,$tgl_awal,$tgl_akhir,$tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan))->result_array();
    }
}

/* End of file M_printpp.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */