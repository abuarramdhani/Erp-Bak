<?php

class M_masterdata extends CI_model
{
    public function __construct() {
        parent::__construct();
        $this->personalia = $this->load->database('personalia', true);
        $this->load->database();
    }

    function ajaxShowMaster(){
        $sql = "select tm.id, tm.id_master, tm.keterangan, (select string_agg(kodesie, ',') from ps.tappr where id_master = tm.id_master) approval from ps.tmaster tm";
        $result = $this->db->query($sql)->result_array();

        for($i=0; $i < count($result); $i++){
            $app = $result[$i]['approval'];
            $kodesie = explode(',', $app);
            $j = 1;
            foreach($kodesie as $item){
                if($item != 'kosong'){
                    $selectSeksi = "select distinct trim(seksi) seksi from hrd_khs.tseksi where kodesie like '$item%' and trim(seksi) <> '-'";
                    $seksi = $this->personalia->query($selectSeksi)->row()->seksi;

                    $result[$i]['kodesie'.$j] = $item;
                    $result[$i]['seksi'.$j]   = $seksi;
                }else{
                    $result[$i]['kodesie'.$j] = 'a';
                    $result[$i]['seksi'.$j]   = '';
                }

                $j++;
            }
            unset($result[$i]['approval']);
        }
        // echo "<pre>";print_r($result);die;
        return $result;
    }

    function ajaxSeksi(){
        $sql = "SELECT distinct substring(kodesie, 0, 8) kodesie, seksi 
                FROM hrd_khs.tseksi 
                WHERE trim(seksi) not in('-') order by 2";        
        $result = $this->personalia->query($sql)->result_array();
        return $result;
    }

    function ajaxInsertMaster($id,$ket,$lv1,$lv2){
        if($lv2 == null||$lv2===''){
            $approval = [$lv1, 'kosong'];
        }else{
            $approval = [$lv1, $lv2];
        }

        $master = array(
            'id_master'  => $id,
            'keterangan' => $ket
        );

        $this->db->insert('ps.tmaster', $master);
        
        $id_tmaster = $this->db->insert_id();

        $i=1;
        foreach($approval as $item){
            $appr = array(
                'id' => $id_tmaster,
                'id_master'=> $id,
                'kodesie' => $item,
                'tingkat' => $i
            );
            
            $this->db->insert('ps.tappr', $appr);
            $i++;
        }
    }

    function ajaxUpdateMaster($id,$code,$ket,$lv1,$lv2){
        $approval = [$lv1, $lv2];

        $lv = 1;
        $sqlUpdate = '';
        foreach($approval as $item){
            $sqlUpdate .= "UPDATE ps.tappr set id_master = '$code', kodesie='$item' WHERE tingkat='$lv' AND id='$id';";
            $lv++;
        }

        $sqlUpdate .= "UPDATE ps.tmaster set id_master = '$code', keterangan='$ket' WHERE id='$id';";
        //echo $sqlUpdate;die;
        $this->db->query($sqlUpdate);
    }

    function ajaxDeleteMaster($id){
        //cari di tdata. ada tidak ?
        $sqlselect = "SELECT id_data from ps.tdata where id_master = '$id'";
        $result = $this->db->query($sqlselect)->result_array();

        if(count($result) > 0){
            echo 'failed';
        }else{
            //del data
            $sqldelete = "DELETE FROM ps.tmaster WHERE id='$id';";
            $sqldelete .= "DELETE FROM ps.tappr WHERE id='$id';";

            $this->db->query($sqldelete);
            echo 'ok';
        }
    }
}
