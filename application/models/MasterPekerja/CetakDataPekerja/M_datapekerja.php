<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_datapekerja extends CI_Model
{
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	function getPetugas($keyword){
		$this->personalia->select('noind, nama');
		$this->personalia->like('nama',$keyword,'both');
		$this->personalia->where('kodesie','401010100');
		$this->personalia->where('keluar','0');
		return $this->personalia->get('hrd_khs.tpribadi')->result();
	}

	function getLokasiKerja($keyword){
		$this->personalia->like('lokasi_kerja',$keyword, 'both');
		return $this->personalia->get('hrd_khs.tlokasi_kerja')->result();
	}

	function getPekerjaMasuk($tanggalAwal,$tanggalAkhir,$lokasi){
		$sql1		= "SELECT COUNT(*) FROM hrd_khs.tpribadi WHERE masukkerja BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND lokasi_kerja='$lokasi' AND noind LIKE ANY ('{A%,B%,D%,E%,H%,J%,T%}') ";
		$result = $this->personalia->query($sql1);
		if($result > 0){
			$sql2		= "SELECT * FROM hrd_khs.tpribadi WHERE masukkerja BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND lokasi_kerja='$lokasi' AND noind LIKE ANY ('{A%,B%,D%,E%,H%,J%,T%}') ORDER BY masukkerja ";
			return $this->personalia->query($sql2)->result();
		}else{
			return false;
		}

		
	}

	function getPekerjaKeluar($tanggalAwal,$tanggalAkhir,$lokasi){
		$sql1		= "SELECT COUNT(*) FROM hrd_khs.tpribadi WHERE tglkeluar BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND keluar='1' AND lokasi_kerja='$lokasi' AND noind LIKE ANY ('{A%,B%,D%,E%,H%,J%,T%}') AND sebabklr NOT LIKE '%NO INDUK%' ";
		$result = $this->personalia->query($sql1);
		if($result > 0){
			$sql2 = "SELECT * FROM hrd_khs.tpribadi WHERE tglkeluar BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND keluar='1' AND lokasi_kerja='$lokasi' AND noind LIKE ANY ('{A%,B%,D%,E%,H%,J%,T%}') AND sebabklr NOT LIKE '%NO INDUK%' ORDER BY tglkeluar";
			return $this->personalia->query($sql2)->result();
		}else{
			return false;
		}
		
	}
}
