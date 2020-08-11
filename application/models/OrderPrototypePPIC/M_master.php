<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getSeksi($value='')
    {
      $res = $this->personalia->distinct()
                              ->select('kodesie, unit, seksi')
                              ->where('')
    }

}
