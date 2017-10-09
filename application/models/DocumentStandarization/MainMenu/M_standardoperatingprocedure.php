<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_standardoperatingprocedure extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getStandardOperatingProcedure($id = FALSE)
    {
    	if ($id === FALSE) {

            $ambilSOP   = " select      sop.sop_id as kode_sop,
                                        sop.sop_name as nama_sop,
                                        sop.no_kontrol as nomor_dokumen,
                                        sop.no_revisi as nomor_revisi,
                                        to_char(sop.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                        sop.jml_halaman as jumlah_halaman,
                                        sop.sop_info as info,
                                        sop.dibuat as kode_pekerja_pembuat,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.dibuat
                                        ) as pekerja_pembuat,
                                        sop.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.diperiksa_1
                                        ) as pekerja_pemeriksa_1,
                                        sop.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.diperiksa_2
                                        ) as pekerja_pemeriksa_2,
                                        sop.diputuskan as kode_pekerja_pemberi_keputusan,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.diputuskan
                                        ) as pekerja_pemberi_keputusan,
                                        sop.sop_file as file,
                                        sop.sop_tujuan as tujuan_sop,
                                        sop.sop_ruang_lingkup as ruang_lingkup_sop,
                                        sop.sop_referensi as referensi_sop,
                                        sop.sop_definisi as definisi_sop,
                                        sop.bp_id as kode_business_process,
                                        (
                                            select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                            from        ds.ds_business_process as bp
                                            where       bp.bp_id=sop.bp_id
                                        ) as nama_business_process,
                                        sop.cd_id as kode_context_diagram,
                                        (
                                            select      concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                            from        ds.ds_context_diagram as cd
                                            where       cd.cd_id=sop.cd_id
                                        ) as nama_context_diagram,
                                        to_char(sop.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                        to_char(sop.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file       
                            from        ds.ds_standard_operating_procedure as sop
                            order by    sop.sop_id, sop.tanggal desc;";
    		$query = $this->db->query($ambilSOP);
    	} else {
            $ambilSOP   = " select      sop.sop_id as kode_sop,
                                        sop.sop_name as nama_sop,
                                        sop.no_kontrol as nomor_dokumen,
                                        sop.no_revisi as nomor_revisi,
                                        to_char(sop.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                        sop.jml_halaman as jumlah_halaman,
                                        sop.sop_info as info,
                                        sop.dibuat as kode_pekerja_pembuat,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.dibuat
                                        ) as pekerja_pembuat,
                                        sop.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.diperiksa_1
                                        ) as pekerja_pemeriksa_1,
                                        sop.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.diperiksa_2
                                        ) as pekerja_pemeriksa_2,
                                        sop.diputuskan as kode_pekerja_pemberi_keputusan,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=sop.diputuskan
                                        ) as pekerja_pemberi_keputusan,
                                        sop.sop_file as file,
                                        sop.sop_tujuan as tujuan_sop,
                                        sop.sop_ruang_lingkup as ruang_lingkup_sop,
                                        sop.sop_referensi as referensi_sop,
                                        sop.sop_definisi as definisi_sop,
                                        sop.bp_id as kode_business_process,
                                        (
                                            select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                            from        ds.ds_business_process as bp
                                            where       bp.bp_id=sop.bp_id
                                        ) as nama_business_process,
                                        sop.cd_id as kode_context_diagram,
                                        (
                                            select      concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                            from        ds.ds_context_diagram as cd
                                            where       cd.cd_id=sop.cd_id
                                        ) as nama_context_diagram,
                                        to_char(sop.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                        to_char(sop.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file  
                            from        ds.ds_standard_operating_procedure as sop
                            where       sop.sop_id=$id;";
    		$query = $this->db->query($ambilSOP);
    	}

    	return $query->result_array();
    }

    public function setStandardOperatingProcedure($data)
    {
        return $this->db->insert('ds.ds_standard_operating_procedure', $data);
    }

    public function updateStandardOperatingProcedure($data, $id)
    {
        $this->db->where('sop_id', $id);
        $this->db->update('ds.ds_standard_operating_procedure', $data);
    }

    public function deleteStandardOperatingProcedure($id)
    {
        $this->db->where('sop_id', $id);
        $this->db->delete('ds.ds_standard_operating_procedure');
    }
}

/* End of file M_standardoperatingprocedure.php */
/* Location: ./application/models/OTHERS/MainMenu/M_standardoperatingprocedure.php */
/* Generated automatically on 2017-09-14 11:01:16 */