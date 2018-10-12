<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_DataKomputerServer extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function serverlist()
	{
		$sql = 'select * from sc.sc_komp_server';
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function daftar_lokasi($text, $keyword)
	{
		$sql = "select * from sc.sc_ruang_server where ruang_server_name like '%$keyword%' or sc_ruang_server_id::text like '%$keyword%'";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function input($host, $ip, $lokasi)
	{
		$sql = "insert into sc.sc_komp_server
				(hostname_server, ip_server, id_lokasi_server)
				values ('$host','$ip','$lokasi')";

		$query = $this->db->query($sql);
	}
}