<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_ajax extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);    
        $this->personalia = $this->load->database('personalia',true);    
    }

    public function getComponent($term = FALSE)
    {
        if ($term==FALSE) {
            $where = "";
        }else{
            $where = "AND msib.SEGMENT1 LIKE '%$term%'";
        }

        $sql = "SELECT msib.SEGMENT1,
                       msib.DESCRIPTION
                FROM mtl_system_Items_b msib
                WHERE (msib.segment1 LIKE '%R1'
                       OR msib.segment1 LIKE '%P1')
                  $where";

        $query = $this->oracle->query($sql);
    	return $query->result_array();
    }

    public function getEmployee()
    {
        $sql = "SELECT tp.noind,
                       tp.nama
                FROM hrd_khs.tpribadi tp
                LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
                WHERE ts.dept LIKE '%PRODUKSI%'
                  AND ts.bidang LIKE '%PRODUKSI PENGECORAN LOGAM%'
                  AND ts.bidang NOT LIKE '%PRODUKSI PENGECORAN LOGAM - TKS%'
                  AND (tp.lokasi = 'AA'
                       OR tp.lokasi_kerja = '01')
                ORDER BY tp.noind";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
}