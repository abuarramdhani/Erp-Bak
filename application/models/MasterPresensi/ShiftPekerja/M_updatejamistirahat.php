<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_updatejamistirahat extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);


	}

	
	public function shift(){
		$sql = "select trim(kd_shift) kd_shift,
						trim(shift) shift
				from \"Presensi\".tshift order by kd_shift";

		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function tampil($tanggal,$shiftpekerja){
		$sql = "select *
				from \"Presensi\".tshiftpekerja a 
                inner join \"Presensi\".tshift b 
                on a.kd_shift=b.kd_shift
                where a.tanggal::date='$tanggal' and b.shift='$shiftpekerja' order by noind ";
                // echo "<pre>";
                // print_r($sql);
                // die;
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function update($tanggal,$shift,$ist_mulai,$ist_selesai){
		$sql = "update \"Presensi\".tshiftpekerja 
                set ist_mulai='$ist_mulai', ist_selesai='$ist_selesai'
                where tanggal::date='$tanggal'and kd_shift='$shift'";

		return $this->personalia->query($sql);
	}

	public function CariKdShift($shift){
		$sql = "select kd_shift from \"Presensi\".tshift where trim(shift) = '$shift'";
		return $this->personalia->query($sql)->row()->kd_shift;
	}



};    




