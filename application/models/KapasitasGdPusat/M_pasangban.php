<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pasangban extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    
    public function getUsername($term){
        $sql = "SELECT DISTINCT noind, nama
        FROM hrd_khs.tpribadi 
        WHERE noind LIKE '%$term%'
        OR nama LIKE '%$term%'";
        // echo "<pre>";print_r($sql);exit();
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getLastID(){
        $sql = "SELECT TRIM (SUBSTR (ID, 1, INSTR (ID, '-') - 1)) ket,
        TRIM (SUBSTR (ID,
                      INSTR (ID, '-', 1, 1) + 1,
                      INSTR (ID, '-', 1, 2) - INSTR (ID, '-', 1, 1) - 1
                     )
             ) ban,
        TRIM (SUBSTR (ID,
                      INSTR (ID, '-', 1, 2) + 1,
                      LENGTH (ID) - INSTR (ID, '-', 1, 2)
                     )
             ) num
        FROM khs_inv_pasang_ban
        WHERE ID IS NOT NULL
        ORDER BY 3 DESC";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // $response = $this->oracle->query("SELECT TRIM (TO_CHAR (SYSDATE, 'RRMMDD') || LPAD (khs_inv_pasang_ban_s.NEXTVAL, 3, '0')) id
        // FROM DUAL")->row_array();
        // return $response['ID'];
    }

    public function getPasang($ket, $jenis_ban){
        $sql = "SELECT kipb.id, kipb.no_induk, kipb.nama, kipb.ket,
        TO_CHAR (kipb.mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
        TO_CHAR (kipb.mulai, 'HH24:MI:SS') jam_mulai, kipb.selesai, kipb.waktu,
        kipb.jumlah
   FROM khs_inv_pasang_ban kipb
  WHERE kipb.selesai IS NULL AND kipb.ket = '$ket' AND kipb.jenis_ban = '$jenis_ban'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getJamMulai($ket, $jenis_ban){
        $sql = "SELECT DISTINCT kipb.ket,
        TO_CHAR (kipb.mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
        TO_CHAR (kipb.mulai, 'HH24:MI:SS') jam_mulai, kipb.selesai, kipb.waktu,
        kipb.jumlah
   FROM khs_inv_pasang_ban kipb
  WHERE kipb.selesai IS NULL AND kipb.ket = '$ket' AND kipb.jenis_ban = '$jenis_ban'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function SaveMulai($data){
        $sql = "INSERT INTO khs_inv_pasang_ban
                 (id, no_induk, nama, ket, 
                 mulai, jenis_ban
                 )
         VALUES ('$data[ID]', '$data[NO_INDUK]', '$data[NAMA]', '$data[KET]', 
                TO_TIMESTAMP ('$data[DATE]', 'DD-MM-YYYY HH24:MI:SS'), '$data[JENIS_BAN]'
                 )";
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query("commit");
        echo $sql;
    }

    public function cekMulai($data){
        $sql = "SELECT kipb.*, TO_CHAR (kipb.mulai, 'YYYY-MM-DD HH24:MI:SS') AS jam_mulai
        FROM khs_inv_pasang_ban kipb
       WHERE kipb.id = '$data[ID]' AND kipb.no_induk = '$data[NO_INDUK]' AND kipb.ket = '$data[KET]'";
    //     $sql = "SELECT *
    //     FROM khs_inv_pasang_ban
    //    WHERE no_induk = '$data[NO_INDUK]' AND ket = '$data[KET]'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        echo $sql;
    }

    public function SaveSelesai($data, $slsh){
        $sql = "UPDATE khs_inv_pasang_ban
        SET selesai = TO_TIMESTAMP ('$data[DATE]', 'DD-MM-YYYY HH24:MI:SS'),
            jumlah = '$data[JUMLAH]',
            waktu = '$slsh'
      WHERE id = '$data[ID]' AND no_induk = '$data[NO_INDUK]' AND ket = '$data[KET]' AND jenis_ban = '$data[JENIS_BAN]'";
        $query = $this->oracle->query($sql);            
        $query2 = $this->oracle->query('commit');       
        echo $sql;
    }

    // public function SaveJumlah($data){
    //     $sql = "UPDATE khs_inv_pasang_ban
    //     SET jumlah = '$data[JUMLAH]'
    //   WHERE no_induk = '$data[NO_INDUK]' AND ket = '$data[KET]'";
    //     $query = $this->oracle->query($sql);            
    //     $query2 = $this->oracle->query('commit');       
    //     echo $sql;
    // }

    public function getAssy($jenis_ban){
        $sql = "SELECT kijb.kode_assy
        FROM khs_inv_jenis_ban kijb
       WHERE kijb.jenis_ban = '$jenis_ban'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function SaveTemp($data){
        $sql = "INSERT INTO wolc_tab
                 (item_name, req_qty, req_subinventory)
         VALUES ('$data[ASSY]', $data[QTY], '$data[SUBINV]')";
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query("commit");
        echo $sql;
    }

    public function DeleteTemp($data){
        $sql = "DELETE FROM wolc_tab
        WHERE item_name = '$data[ASSY]' AND req_qty = $data[QTY] AND req_subinventory = '$data[SUBINV]'";
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query("commit");
        echo $sql;
    }

    public function InsertMTI($user_id, $org_id, $source_code){
        // echo "<pre>";
        // echo ':P_PARAM1 = '.$user_id.'<br>'; 
        // echo ':P_PARAM2 = '.$org_id.'<br>';
        // echo ':P_PARAM3 = '.$source_code.'<br>';
        // exit();

        $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        $sql =  "BEGIN APPS.KHS_WOLC(:P_PARAM1,:P_PARAM2,:P_PARAM3); END;";

        //Statement does not change
        $stmt = oci_parse($conn,$sql);                     
        oci_bind_by_name($stmt,':P_PARAM1',$user_id);           
        oci_bind_by_name($stmt,':P_PARAM2',$org_id); 
        oci_bind_by_name($stmt,':P_PARAM3',$source_code);
        
        // But BEFORE statement, Create your cursor
        $cursor = oci_new_cursor($conn);
        
        // Execute the statement as in your first try
        oci_execute($stmt);
        
        // and now, execute the cursor
        oci_execute($cursor);
    }

    public function runAPI($user_id){
        $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
            
        $sql = "BEGIN APPS.KHS_RUN_FND (:P_USER_ID); END;";
  
        //Statement does not change
        $stmt = oci_parse($conn,$sql);                     
        oci_bind_by_name($stmt,':P_USER_ID',$user_id);           
        
        // But BEFORE statement, Create your cursor
        $cursor = oci_new_cursor($conn);
        
        // Execute the statement as in your first try
        oci_execute($stmt);
        
        // and now, execute the cursor
        oci_execute($cursor);
      }

}


?>