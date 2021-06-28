<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_index extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getLastData(){
    	$sql = "select a.provinsi,a.kabupaten,a.zona,
			    	case when a.provinsi in ('DAERAH ISTIMEWA YOGYAKARTA','JAWA TENGAH') then 
				    	(
							select lower(d.tanggal_update)
							from si.si_covid d 
							where d.kabupaten = a.kabupaten 
							and d.provinsi = a.provinsi
							and d.zona = a.zona
							and d.created_timestamp <= a.created_timestamp
							and (
								select count(*)
								from si.si_covid c 
								where c.kabupaten = d.kabupaten
								and c.provinsi = c.provinsi
								and c.zona != d.zona
								and c.created_timestamp between d.created_timestamp and a.created_timestamp
							) = 0
							order by d.created_timestamp 
							limit 1
						)
					else 
						lower(a.tanggal_update)
					end as tanggal,
					case when a.provinsi in ('DAERAH ISTIMEWA YOGYAKARTA','JAWA TENGAH') then 
						(
							select (
								select e.zona 
								from si.si_covid e 
								where d.kabupaten = e.kabupaten
								and d.provinsi = e.provinsi
								and d.created_timestamp > e.created_timestamp
								order by e.created_timestamp desc 
								limit 1
							)
							from si.si_covid d 
							where d.kabupaten = a.kabupaten 
							and d.provinsi = a.provinsi
							and d.zona = a.zona
							and d.created_timestamp <= a.created_timestamp
							and (
								select count(*)
								from si.si_covid c 
								where c.kabupaten = d.kabupaten
								and c.provinsi = c.provinsi
								and c.zona != d.zona
								and c.created_timestamp between d.created_timestamp and a.created_timestamp
							) = 0
							order by d.created_timestamp
							limit 1
						) 
					else 
						'' 
					end as zona_sebelumnya
				from si.si_covid a
				where a.created_timestamp = (
					select max(created_timestamp)
					from si.si_covid b
					where a.kabupaten = b.kabupaten
					and a.provinsi = b.provinsi
				)
				order by a.provinsi,a.kabupaten";
		return $this->db->query($sql)->result_array();
    }

    function getStatusKondisi(){
    	$sql = "select *
				from si.si_covid_status";
		return $this->db->query($sql)->result_array();
    }

    function getDaerahKDU(){
    	$sql = "select * 
    			from si.si_covid_kdu";
		return $this->db->query($sql)->result_array();
    }

} ?>