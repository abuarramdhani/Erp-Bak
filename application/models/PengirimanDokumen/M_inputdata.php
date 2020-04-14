<?php

class M_inputdata extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->personalia = $this->load->database('personalia', true);
        $this->load->database();
    }

    function ajaxShowInput($kodesie){
        $sql = "SELECT td.id_data, 
                     td.noind, trim(emp.employee_name) nama, 
                        (select to_char(tgl_update, 'YYYY-MM-DD HH24:MI:SS') 
                         from ps.triwayat 
                         where id_data = td.id_data and status='0'
                         ) 
                     tgl_input,
                     tm.keterangan,
                     td.tanggal_start::date,
                     td.tanggal_end::date, 
                     td.status,
                     (select tgl_update from ps.triwayat where id_data = td.id_data and status = td.status limit 1) app_time,
                     td.alasan,
                     (select string_agg(kodesie, '|') from ps.tappr where id = tm.id) as approval
                FROM ps.tdata td 
                    inner join er.er_employee_all emp on td.noind = emp.employee_code 
                    inner join ps.tmaster tm on tm.id = td.id_master
                    inner join ps.triwayat tr on td.id_data = tr.id_data
                WHERE ('$kodesie' = tr.seksi OR substring(emp.section_code,0,8) = '$kodesie') and tr.status = '0' 
                ORDER BY td.id_data";

        $result = $this->db->query($sql)->result_array();

        $i = 0;
        foreach($result as $res){
            $approval = explode('|', $res['approval']);
            $approver1= $this->getNameSeksi($approval['0']);
            $result[$i]['approver1'] = $approver1;
            $result[$i]['app_time']  = date('d/m/Y H:i:s', strtotime($res['app_time']));
            $result[$i]['tgl_input'] = date('d/m/Y H:i:s', strtotime($res['tgl_input']));
            $result[$i]['tanggal_start'] = date('d/m/Y', strtotime($res['tanggal_start']));
            $result[$i]['tanggal_end']   = date('d/m/Y', strtotime($res['tanggal_end']));

            if($approval['1'] !== 'kosong'){
                $approver2= $this->getNameSeksi($approval['1']);
                $result[$i]['approver2'] = $approver2;
            }else{
                $result[$i]['approver2'] = '';
            }

            $i++;
        }

        return $result;
    }

    function ajaxNoind($params){
        $kodesie = substr($this->session->kodesie,0,7);
        $queryNoind  = "SELECT trim(tp.nama) nama,
                         tp.noind,
                         ts.seksi 
                        FROM hrd_khs.tpribadi tp 
                            inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie 
                        WHERE tp.noind like '$params%' AND tp.keluar='0' limit 20";
        $result     = $this->personalia->query($queryNoind)->result_array();
        return $result;
    }

    function ajaxListMaster(){
        $sql = "SELECT id, id_master, keterangan 
                FROM ps.tmaster";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    function ajaxInputData($noind,$id_master,$date, $lokasi){
        $inputData = array(
            'noind'         => $noind,
            'id_master'     => $id_master,
            'tanggal_start' => $date['0'],
            'tanggal_end'   => $date['1'],
            'lokasi'        => $lokasi
        );

        $this->db->insert('ps.tdata', $inputData);

        $inputriwayat = array(
            'id_data' => $this->db->insert_id(),
            'status'  => '0',
            'user'    => $this->session->user,
            'level'   => '0',
            'seksi'   => substr($this->session->kodesie,0,7)
        );

        $this->db->insert('ps.triwayat', $inputriwayat);
    }

    function ajaxUpdateData($id, $noind,$id_master,$date, $lokasi){
        $updateData = array(
            'noind'         => $noind,
            'id_master'     => $id_master,
            'tanggal_start' => $date['0'],
            'tanggal_end'   => $date['1'],
            'lokasi'        => $lokasi
        );

        $this->db->set($updateData);
        $this->db->where('id_data', $id);
        $this->db->update('ps.tdata');
    }

    function getNameSeksi($kodesie){
        $sql = "SELECT distinct seksi FROM hrd_khs.tseksi where substr(kodesie,0,8) = '$kodesie'";
        return $this->personalia->query($sql)->row()->seksi;
    }

    function getNameSeksiByNoind($noind){
        $sql = "SELECT kodesie FROM hrd_khs.tpribadi WHERE noind ='$noind' and keluar='0'";
        $kodesie = substr($this->personalia->query($sql)->row()->kodesie, 0, 7);

        $sql = "SELECT distinct seksi FROM hrd_khs.tseksi where substr(kodesie,0,8) = '$kodesie'";
        return $this->personalia->query($sql)->row()->seksi;
    }

    function ajaxShowDetail($id){
        $sql = "SELECT id_riwayat, id_data, status, tgl_update, level, 
        (case when level = '0' then (select noind from ps.tdata where id_data = tr.id_data) else tr.user end ) as user,
        (select id_master from ps.tdata where id_data = tr.id_data) as id_master
        FROM ps.triwayat tr WHERE id_data='$id' order by level";

        return $this->db->query($sql)->result_array();
    }

    function getNameByNoind($noind){
        $sql = "SELECT nama from hrd_khs.tpribadi where noind = '$noind' and keluar='0'";
        return $this->personalia->query($sql)->row()->nama;
    }

    function countApproval($id){
        $sql ="SELECT kodesie from ps.tappr where id='$id' and kodesie <> 'kosong'";
        return $this->db->query($sql)->num_rows();
    }

    function ajaxShowData($id){
        $sql = "SELECT td.id_data, td.noind, (select trim(employee_name) from er.er_employee_all where employee_code = td.noind) as name, td.id_master, td.tanggal_start, td.tanggal_end, td.lokasi
                FROM ps.tdata td
                WHERE id_data = '$id'";
        $data = $this->db->query($sql)->result_array();

        $data[0]['seksi'] = $this->getNameSeksiByNoind($data['0']['noind']);
        $data[0]['tanggal_start'] = date('Y/m/d', strtotime($data[0]['tanggal_start']));
        $data[0]['tanggal_end'] = date('Y/m/d', strtotime($data[0]['tanggal_end']));

        return $data;
    }

    function ajaxDeleteData($id){
        $this->db->delete('ps.tdata', array('id_data' => $id));
        $this->db->delete('ps.triwayat', array('id_data' => $id));

        return true;
    }

    public function getAllLoksi()
    {
        $sql = "SELECT * from hrd_khs.tlokasi_kerja";
        return $this->personalia->query($sql)->result_array();
    }

    public function getLokasi2()
    {
        $sql = "SELECT * from hrd_khs.tlokasi_kerja where id_ in('01','02')";
        return $this->personalia->query($sql)->result_array();
    }
}
