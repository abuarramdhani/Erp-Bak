<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_businessprocess extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getBusinessProcess($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilBusinessProcess   = " select      bp.bp_id as kode_business_process,
                                                    bp.bp_name as nama_business_process,
                                                    bp.no_kontrol as nomor_kontrol,
                                                    bp.no_revisi as nomor_revisi,
                                                    to_char(bp.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                                    bp.jml_halaman as jumlah_halaman,
                                                    bp.dibuat as kode_pekerja_pembuat,
                                                    bp.bp_info as info,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.dibuat
                                                    ) as pekerja_pembuat,
                                                    bp.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.diperiksa_1
                                                    ) as pekerja_pemeriksa_1,
                                                    bp.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.diperiksa_2
                                                    ) as pekerja_pemeriksa_2,
                                                    bp.diputuskan as kode_pekerja_pemberi_keputusan,        
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.diputuskan
                                                    ) as pekerja_pemberi_keputusan,
                                                    bp.bp_file as file,
                                                    to_char(bp.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                                    to_char(bp.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                        from        ds.ds_business_process as bp
                                        order by    bp.bp_id asc, bp.tanggal desc;";
    		$query = $this->db->query($ambilBusinessProcess);
    	} else {
            $ambilBusinessProcess   = " select      bp.bp_id as kode_business_process,
                                                    bp.bp_name as nama_business_process,
                                                    bp.no_kontrol as nomor_kontrol,
                                                    bp.no_revisi as nomor_revisi,
                                                    to_char(bp.tanggal, 'DD-MM-YYYY') as tanggal_revisi,
                                                    bp.jml_halaman as jumlah_halaman,
                                                    bp.dibuat as kode_pekerja_pembuat,
                                                    bp.bp_info as info,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.dibuat
                                                    ) as pekerja_pembuat,
                                                    bp.diperiksa_1 as kode_pekerja_pemeriksa_1,                                                 
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.diperiksa_1
                                                    ) as pekerja_pemeriksa_1,
                                                    bp.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.diperiksa_2
                                                    ) as pekerja_pemeriksa_2,
                                                    bp.diputuskan as kode_pekerja_pemberi_keputusan,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=bp.diputuskan
                                                    ) as pekerja_pemberi_keputusan,
                                                    bp.bp_file as file,
                                                    to_char(bp.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                                    to_char(bp.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                        from        ds.ds_business_process as bp
                                        where       bp.bp_id=$id;";
    		$query = $this->db->query($ambilBusinessProcess);
    	}

    	return $query->result_array();
    }

    public function setBusinessProcess($data)
    {
        return $this->db->insert('ds.ds_business_process', $data);
    }

    public function updateBusinessProcess($data, $id)
    {
        $this->db->where('bp_id', $id);
        $this->db->update('ds.ds_business_process', $data);
    }

    public function deleteBusinessProcess($id)
    {
        $this->db->where('bp_id', $id);
        $this->db->delete('ds.ds_business_process');
    }

    public function ambilDataLama($id)
    {
        $ambilDataLamaBusinessProcess       = " select  *
                                                from    ds.ds_business_process
                                                where   bp_id=$id";
        $queryAmbilDataLamaBusinessProcess  =   $this->db->query($ambilDataLamaBusinessProcess);
        return $queryAmbilDataLamaBusinessProcess->result_array();
    }

    public function inputDataLamakeHistory($recordLama)
    {
        return $this->db->insert('ds.ds_history', $recordLama);
    }
}

/* End of file M_businessprocess.php */
/* Location: ./application/models/OTHERS/MainMenu/M_businessprocess.php */
/* Generated automatically on 2017-09-14 10:57:11 */