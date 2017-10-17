<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_codeofpractice extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getCodeOfPractice($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilCOP   = " select      cop.cop_id as kode_code_of_practice,
                                        cop.cop_name as nama_code_of_practice,
                                        cop.no_kontrol as nomor_dokumen,
                                        cop.no_revisi as nomor_revisi,
                                        to_char(cop.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                        cop.jml_halaman as jumlah_halaman,
                                        cop.cop_info as info,
                                        cop.dibuat as kode_pekerja_pembuat,
                                        (
                                            select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.dibuat
                                        ) as pekerja_pembuat,
                                        cop.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                        (
                                            select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.diperiksa_1
                                        ) as pekerja_pemeriksa_1,
                                        cop.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                        (
                                            select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.diperiksa_2
                                        ) as pekerja_pemeriksa_2,
                                        cop.diputuskan as kode_pekerja_pemberi_keputusan,
                                        (
                                            select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.diputuskan
                                        ) as pekerja_pemberi_keputusan,
                                        cop.cop_file as file,
                                        cop.tgl_insert as waktu_input,
                                        cop.tgl_upload as waktu_upload_file,
                                        cop.bp_id as kode_business_process,
                                        (
                                            select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                            from        ds.ds_business_process as bp
                                            where       bp.bp_id=cop.bp_id
                                        ) as nama_business_process,
                                        cop.cd_id as kode_context_diagram,
                                        (
                                            select      concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                            from        ds.ds_context_diagram as cd
                                            where       cd.cd_id=cop.cd_id
                                        ) as nama_context_diagram,
                                        cop.sop_id as kode_standard_operating_procedure,
                                        (
                                            select      concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name)
                                            from        ds.ds_standard_operating_procedure as sop
                                            where       sop.sop_id=cop.sop_id
                                        ) as nama_standard_operating_procedure          
                            from        ds.ds_code_of_practice as cop
                            order by    cop.cop_id, cop.tanggal desc;";

    		$query = $this->db->query($ambilCOP);
    	} else {
            $ambilCOP   = " select      cop.cop_id as kode_code_of_practice,
                                        cop.cop_name as nama_code_of_practice,
                                        cop.no_kontrol as nomor_dokumen,
                                        cop.no_revisi as nomor_revisi,
                                        to_char(cop.tanggal, 'DD-MM-YYYY') as tanggal_revisi,
                                        cop.jml_halaman as jumlah_halaman,
                                        cop.cop_info as info,
                                        cop.dibuat as kode_pekerja_pembuat,
                                        (
                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.dibuat
                                        ) as pekerja_pembuat,
                                        cop.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                        (
                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.diperiksa_1
                                        ) as pekerja_pemeriksa_1,
                                        cop.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                        (
                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.diperiksa_2
                                        ) as pekerja_pemeriksa_2,
                                        cop.diputuskan as kode_pekerja_pemberi_keputusan,
                                        (
                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from    er.er_employee_all as pkj
                                            where   pkj.employee_id=cop.diputuskan
                                        ) as pekerja_pemberi_keputusan,
                                        cop.cop_file as file,
                                        to_char(cop.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                        to_char(cop.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file,
                                        cop.bp_id as kode_business_process,
                                        (
                                            select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                            from        ds.ds_business_process as bp
                                            where       bp.bp_id=cop.bp_id
                                        ) as nama_business_process,
                                        cop.cd_id as kode_context_diagram,
                                        (
                                            select      concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                            from        ds.ds_context_diagram as cd
                                            where       cd.cd_id=cop.cd_id
                                        ) as nama_context_diagram,
                                        cop.sop_id as kode_standard_operating_procedure,
                                        (
                                            select      concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name)
                                            from        ds.ds_standard_operating_procedure as sop
                                            where       sop.sop_id=cop.sop_id
                                        ) as nama_standard_operating_procedure          
                            from        ds.ds_code_of_practice as cop
                            where       cop.cop_id=$id;";

    		$query = $this->db->query($ambilCOP);
    	}

    	return $query->result_array();
    }

    public function setCodeOfPractice($data)
    {
        return $this->db->insert('ds.ds_code_of_practice', $data);
    }

    public function updateCodeOfPractice($data, $id)
    {
        $this->db->where('cop_id', $id);
        $this->db->update('ds.ds_code_of_practice', $data);
    }

    public function deleteCodeOfPractice($id)
    {
        $this->db->where('cop_id', $id);
        $this->db->delete('ds.ds_code_of_practice');
    }
}

/* End of file M_codeofpractice.php */
/* Location: ./application/models/OTHERS/MainMenu/M_codeofpractice.php */
/* Generated automatically on 2017-09-14 11:02:21 */