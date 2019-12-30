<?php

class M_splpersonalia extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->spl = $this->load->database('spl_db',true);
		$this->prs = $this->load->database('personalia', true);
	}

	function getAllAccessSection(){
		$sql = "SELECT distinct ts.noind, (select group_concat(kodesie separator ', ') from splseksi.takses_seksi where noind = ts.noind) as kodesie from splseksi.takses_seksi ts where substring(ts.kodesie,8,9) = '00' order by 1";
		$sql_access = $this->spl->query($sql)->result_array();

		$newarr = [];
		$i = 0;
		foreach ($sql_access as $item) {
			$noind = $item['noind'];

			$pgsql = "SELECT tp.noind, trim(tp.nama) nama, ts.seksi FROM hrd_khs.tpribadi tp inner join hrd_khs.tseksi ts on ts.kodesie = tp.kodesie where tp.noind = '$noind' and trim(ts.seksi) <> '-' and tp.keluar = '0'";
			$human = $this->prs->query($pgsql);

			if($human->num_rows() < 1){
				continue;
			}

			$human = $human->row();

			$newarr[$i]['noind'] = $human->noind;
			$newarr[$i]['nama'] = $human->nama;
			$newarr[$i]['seksi'] = $human->seksi;
			$kodesie = explode(', ', $item['kodesie']);

			$seksi = [];
			foreach($kodesie as $kd){
				$nama_seksi = $this->getSection(substr($kd,0,7));
				$seksi[] = !empty($nama_seksi) ? $nama_seksi[0]['nama'] : 'seksi tidak diketahui';
			}
			$newarr[$i]['kodesie'] = $item['kodesie'];
			$newarr[$i]['nama_seksi'] = implode('|', $seksi);

			$i++;
		}
		// foreach ($newarr as $key) {
		// 	$count = explode()
		// }

		return $newarr;
	}

	function addAccessSection($noind, $section){
		$this->spl->delete('splseksi.takses_seksi', ['noind'=>$noind]);
		foreach ($section as $kodesie) {
			$data = array(
				'noind' => $noind,
				'kodesie' => $kodesie
			);
			$this->spl->insert('splseksi.takses_seksi', $data);
		}

	}

	function showpekerja($key){
		$sql = "SELECT noind, nama FROM hrd_khs.tpribadi WHERE nama like '$key%' OR noind like '$key%' and keluar='0'";
		return $this->prs->query($sql)->result_array();
	}

	function getSection($key){
		$sql = "SELECT kodesie, coalesce(nullif(trim(seksi), '-'), nullif(trim(unit),'-'), nullif(trim(bidang),'-'), dept) as nama
				from hrd_khs.tseksi
				where substr(kodesie,0,8) like '$key%' order by 1 limit 1";
		return $this->prs->query($sql)->result_array();
	}

	function getAllSection($key){
		$sql = "select kodesie, coalesce(nullif(trim(seksi), '-'), nullif(trim(unit),'-'), nullif(trim(bidang),'-'), dept) as nama from hrd_khs.tseksi where substring(kodesie, 8,11) = '00' and (kodesie like '$key%' OR seksi like '$key%' OR unit like '$key%' OR bidang like '$key%' OR dept like '$key%') order by 1";

		return $this->prs->query($sql)->result_array();
	}

	function ajaxGetInfoNoind($noind){
		$sql = "SELECT distinct noind, kodesie from splseksi.takses_seksi where noind = '$noind'";
		$data = $sql_access = $this->spl->query($sql)->result_array();

		$i = 0;
		foreach($data as $key){
			$nama_seksi = $this->getSection(substr($key['kodesie'],0,7));
			$data[$i]['nama_seksi'] = !empty($nama_seksi) > 0 ? $nama_seksi['0']['nama'] : 'seksi tidak diketahui';
			$i++;
		}

		return $data;
	}

	function ajaxDeleteAccess($noind){
		$sql = "DELETE FROM splseksi.takses_seksi where noind = '$noind'";
		$data = $sql_access = $this->spl->query($sql);
	}

}
