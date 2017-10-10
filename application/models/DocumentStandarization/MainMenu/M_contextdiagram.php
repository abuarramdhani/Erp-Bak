<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_contextdiagram extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getContextDiagram($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilContextDiagram    = " select      cd.cd_id as kode_context_diagram,
                                                    cd.cd_name as nama_context_diagram,
                                                    cd.no_kontrol as nomor_kontrol,
                                                    cd.no_revisi as nomor_revisi,
                                                    to_char(cd.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                                    cd.jml_halaman as jumlah_halaman,
                                                    cd.cd_info as info,
                                                    cd.dibuat as kode_pekerja_pembuat,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.dibuat
                                                    ) as pekerja_pembuat,
                                                    cd.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.diperiksa_1
                                                    ) as pekerja_pemeriksa_1,
                                                    cd.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.diperiksa_2
                                                    ) as pekerja_pemeriksa_2,
                                                    cd.diputuskan as kode_pekerja_pemberi_keputusan,
                                                    (
                                                        select  concat_ws('<br/>', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.diputuskan
                                                    ) as pekerja_pemberi_keputusan,
                                                    cd.cd_file as file,
                                                    to_char(cd.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                                    to_char(cd.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file,
                                                    cd.bp_id as kode_business_process,
                                                    (
                                                        select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                                        from        ds.ds_business_process as bp
                                                        where       bp.bp_id=cd.bp_id
                                                    ) as nama_business_process
                                        from        ds.ds_context_diagram as cd
                                        order by    cd.cd_id, cd.tanggal desc;";

    		$query = $this->db->query($ambilContextDiagram);
    	} else {
            $ambilContextDiagram    = " select      cd.cd_id as kode_context_diagram,
                                                    cd.cd_name as nama_context_diagram,
                                                    cd.no_kontrol as nomor_kontrol,
                                                    cd.no_revisi as nomor_revisi,
                                                    to_char(cd.tanggal, 'DD-MM-YYYY') as tanggal_revisi,
                                                    cd.jml_halaman as jumlah_halaman,
                                                    cd.cd_info as info,
                                                    cd.dibuat as kode_pekerja_pembuat,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.dibuat
                                                    ) as pekerja_pembuat,
                                                    cd.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.diperiksa_1
                                                    ) as pekerja_pemeriksa_1,
                                                    cd.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.diperiksa_2
                                                    ) as pekerja_pemeriksa_2,
                                                    cd.diputuskan as kode_pekerja_pemberi_keputusan,
                                                    (
                                                        select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                        from    er.er_employee_all as pkj
                                                        where   pkj.employee_id=cd.diputuskan
                                                    ) as pekerja_pemberi_keputusan,
                                                    cd.cd_file as file,
                                                    to_char(cd.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                                    to_char(cd.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file,
                                                    cd.bp_id as kode_business_process,
                                                    (
                                                        select      concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                                        from        ds.ds_business_process as bp
                                                        where       bp.bp_id=cd.bp_id
                                                    ) as nama_business_process
                                        from        ds.ds_context_diagram as cd
                                        where       cd.cd_id=$id;";

    		$query = $this->db->query($ambilContextDiagram);
    	}

    	return $query->result_array();
    }

    public function setContextDiagram($data)
    {
        return $this->db->insert('ds.ds_context_diagram', $data);
    }

    public function updateContextDiagram($data, $id)
    {
        $this->db->where('cd_id', $id);
        $this->db->update('ds.ds_context_diagram', $data);
    }

    public function deleteContextDiagram($id)
    {
        $this->db->where('cd_id', $id);
        $this->db->delete('ds.ds_context_diagram');
    }
}

/* End of file M_contextdiagram.php */
/* Location: ./application/models/OTHERS/MainMenu/M_contextdiagram.php */
/* Generated automatically on 2017-09-14 11:00:26 */