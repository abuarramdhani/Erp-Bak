<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_workinstruction extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getWorkInstruction($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilWI    = " select      wi.wi_id as kode_work_instruction,
                                        wi.wi_name as nama_work_instruction,
                                        wi.no_kontrol as nomor_dokumen,
                                        wi.no_revisi as nomor_revisi,
                                        to_char(wi.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                        wi.jml_halaman as jumlah_halaman,
                                        wi.wi_info as info,
                                        wi.dibuat as kode_pekerja_pembuat,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.dibuat
                                        ) as pekerja_pembuat,
                                        wi.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.diperiksa_1
                                        ) as pekerja_pemeriksa_1,
                                        wi.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.diperiksa_2
                                        ) as pekerja_pemeriksa_2,
                                        wi.diputuskan as kode_pekerja_pemberi_keputusan,
                                        (
                                            select      concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.diputuskan
                                        ) as pekerja_pemberi_keputusan,
                                        wi.wi_file as file,
                                        wi.tgl_insert as waktu_input,
                                        wi.tgl_upload as waktu_upload_file,
                                        wi.bp_id as kode_business_process,
                                        (
                                            select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                            from        ds.ds_business_process as bp
                                            where       bp.bp_id=wi.bp_id
                                        ) as nama_business_process,
                                        wi.cd_id as kode_context_diagram,
                                        (
                                            select      concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                            from        ds.ds_context_diagram as cd
                                            where       cd.cd_id=wi.cd_id
                                        ) as nama_context_diagram,
                                        wi.sop_id as kode_standard_operating_procedure,
                                        (
                                            select      concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name)
                                            from        ds.ds_standard_operating_procedure as sop
                                            where       sop.sop_id=wi.sop_id
                                        ) as nama_standard_operating_procedure
                            from        ds.ds_work_instruction as wi
                            order by    wi.wi_id,wi.tanggal desc;";

    		$query = $this->db->query($ambilWI);
    	} else {
            $ambilWI    = " select      wi.wi_id as kode_work_instruction,
                                        wi.wi_name as nama_work_instruction,
                                        wi.no_kontrol as nomor_dokumen,
                                        wi.no_revisi as nomor_revisi,
                                        to_char(wi.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                        wi.jml_halaman as jumlah_halaman,
                                        wi.wi_info as info,
                                        wi.dibuat as kode_pekerja_pembuat,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.dibuat
                                        ) as pekerja_pembuat,
                                        wi.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.diperiksa_1
                                        ) as pekerja_pemeriksa_1,
                                        wi.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.diperiksa_2
                                        ) as pekerja_pemeriksa_2,
                                        wi.diputuskan as kode_pekerja_pemberi_keputusan,
                                        (
                                            select      concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                            from        er.er_employee_all as pkj
                                            where       pkj.employee_id=wi.diputuskan
                                        ) as pekerja_pemberi_keputusan,
                                        wi.wi_file as file,
                                        to_char(wi.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                        to_char(wi.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file,
                                        wi.bp_id as kode_business_process,
                                        (
                                            select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                            from        ds.ds_business_process as bp
                                            where       bp.bp_id=wi.bp_id
                                        ) as nama_business_process,
                                        wi.cd_id as kode_context_diagram,
                                        (
                                            select      concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                            from        ds.ds_context_diagram as cd
                                            where       cd.cd_id=wi.cd_id
                                        ) as nama_context_diagram,
                                        wi.sop_id as kode_standard_operating_procedure,
                                        (
                                            select      concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name)
                                            from        ds.ds_standard_operating_procedure as sop
                                            where       sop.sop_id=wi.sop_id
                                        ) as nama_standard_operating_procedure
                            from        ds.ds_work_instruction as wi
                            where       wi.wi_id=$id;";

    		$query = $this->db->query($ambilWI);
    	}

    	return $query->result_array();
    }

    public function setWorkInstruction($data)
    {
        return $this->db->insert('ds.ds_work_instruction', $data);
    }

    public function updateWorkInstruction($data, $id)
    {
        $this->db->where('wi_id', $id);
        $this->db->update('ds.ds_work_instruction', $data);
    }

    public function deleteWorkInstruction($id)
    {
        $this->db->where('wi_id', $id);
        $this->db->delete('ds.ds_work_instruction');
    }
}

/* End of file M_workinstruction.php */
/* Location: ./application/models/OTHERS/MainMenu/M_workinstruction.php */
/* Generated automatically on 2017-09-14 11:01:40 */