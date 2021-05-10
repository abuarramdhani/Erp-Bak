<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_simulasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    function getKendaraan()
    {
        $sql = "SELECT DISTINCT KENDARAAN
        FROM KHS_SIMUL_TRUK 
        ORDER BY (
        CASE kendaraan
        WHEN 'Engkel' THEN 0
        WHEN 'Rhino' THEN 1
        WHEN 'Fuso6-7M' THEN 2
        WHEN 'Tronton10M' THEN 3
        WHEN 'Fuso8M/Tronton9M' THEN 4
        WHEN 'Container20' THEN 5
        WHEN 'Container40' THEN 6
        END 
        )";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    public function getProduk()
    {
        $sql = "SELECT DISTINCT MUATAN FROM KHS_SIMUL_TRUK where JENIS_MUATAN is not null";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getProduk2()
    {
        $sql = "SELECT DISTINCT MUATAN FROM KHS_SIMUL_TRUK where JENIS_MUATAN is null";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getDatabyProduk($p, $k)
    {
        $sql = "SELECT DISTINCT MUATAN ,JENIS_MUATAN ,KENDARAAN ,PROSENTASE 
        FROM KHS_SIMUL_TRUK 
        WHERE MUATAN = '$p'
        AND KENDARAAN = '$k'
        ORDER BY (
        CASE kendaraan
        WHEN 'Engkel' THEN 0
        WHEN 'Rhino' THEN 1
        WHEN 'Fuso6-7M' THEN 2
        WHEN 'Tronton10M' THEN 3
        WHEN 'Fuso8M/Tronton9M' THEN 4
        WHEN 'Container20' THEN 5
        WHEN 'Container40' THEN 6
        END 
        ) ,(
        CASE JENIS_MUATAN 
        WHEN 'Body' THEN 0
        WHEN 'Kopel' THEN 1
        WHEN 'Peti' THEN 2
        WHEN NULL THEN 3
        END 
        )";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}
