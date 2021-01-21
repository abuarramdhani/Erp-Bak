<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_settingdata extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->personalia = $this->load->database('personalia', true);
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function getseksiunit($user){
        $sql = "select ts.seksi, ts.unit, tp.nama
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function dataseksi($term){
        $sql = "select * from khs_pmi_seksi $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


    public function saveseksi($id, $kode, $seksi){
        $sql = "insert into khs_pmi_seksi (id_seksi, kode_seksi, nama_seksi)
                values($id, '$kode', '$seksi')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function datauom($term){
        $sql = "select * 
                from khs_pmi_uom 
                $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function saveuom($id, $kode, $uom){
        $sql = "insert into khs_pmi_uom (id_uom, kode_uom, uom)
                values($id, '$kode', '$uom')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function dataorg($term){
        $sql = "select * 
                from khs_pmi_org_group
                $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        $query = $this->oracle->query('commit');
    }
    
    public function saveorg($id, $nama, $list){
        $sql = "insert into khs_pmi_org_group (id_org, group_name, org_assign)
                values($id, '$nama', '$list')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function updateorg($id, $nama, $list){
        $sql = "update khs_pmi_org_group set org_assign = '$list'
                where id_org = $id 
                and group_name = '$nama'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function delseksi($id, $kode){
        $sql = "delete from khs_pmi_seksi 
                where id_seksi = $id 
                and kode_seksi = '$kode'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function deluom($id, $kode){
        $sql = "delete from khs_pmi_uom
                where id_uom = $id 
                and kode_uom = '$kode'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function delorg($id, $kode){
        $sql = "delete from khs_pmi_org_group 
                where id_org = $id 
                and group_name = '$kode'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function getseksi($user){
        $sql = "select distinct seksi from hrd_khs.tseksi ts 
                where seksi != '-'
                and seksi != '-                                                 '
                and seksi like '%$user%'                                                
                order by seksi";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }   

    
    public function cekemail($noind){
        $sql = "select * 
                from khs_pmi_email 
                where username ='$noind' 
                order by id_email desc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function cekemail2($username, $email){
        $sql = "select * 
                from khs_pmi_email 
                where username ='$username' 
                and email ='$email' 
                order by id_email desc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataEmail($param){
        $sql = "select * 
                from khs_pmi_email 
                $param 
                order by id_email desc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function saveEmail($id, $user, $email){
        $sql = "insert into khs_pmi_email (id_email, username, email)
                values($id, '$user', '$email')";
        $query = $this->oracle->query($sql);
    }
    
    public function deleteEmail($id){
        $sql = "delete from khs_pmi_email where id_email ='$id'";
        $query = $this->oracle->query($sql);
    }


}
