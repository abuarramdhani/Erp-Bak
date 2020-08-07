<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_penjadwalancatering extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia =$this->load->database('personalia',TRUE);
	}

	public function getCatering(){
		$sql = "select * from \"Catering\".tkatering where fb_status='1'";
		$result= $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringBykd($kd){
		$sql = "select * from \"Catering\".tkatering where fb_status='1' and fs_kd_katering = '$kd'";
		$result= $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJadwalCatering($data){
		$kd = $data['kode'];
		$tgl = $data['periode'];
		$sql = "update \"Catering\".tjadwal tj 
				set fb_tanda = '0' 
				where tj.fs_kd_katering = '$kd' 
					and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
					and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))";
		$this->personalia->query($sql);

		$sql = "select 	to_char(tj.fd_tanggal, 'd') hari,
						to_char(tj.fd_tanggal, 'dd') tanggal,
						to_char(tj.fd_tanggal, 'month YYYY') bulan,
						cast(tj.fd_tanggal as date) fd_tanggal,
						tk.fs_kd_katering, 
						tk.fs_nama_katering, 
						tj.fs_tujuan_shift1, 
						tj.fs_tujuan_shift2, 
						tj.fs_tujuan_shift3  
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
						on tk.fs_kd_katering = tj.fs_kd_katering 
				where 	tj.fb_tanda = '0' 
						and tj.fs_kd_katering = '$kd' 
						and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
						and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))
				order by fd_tanggal";
				// echo $sql;exit();
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJadwalCateringDistribusi($data){
		$kd = $data['kode'];
		$tgl = $data['periode'];
		$sql = "update \"Catering\".tjadwal tj 
				set fb_tanda = '0' 
				where tj.fs_kd_katering = '$kd' 
					and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
					and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))";
		$this->personalia->query($sql);

		$sql = "select 	to_char(tj.fd_tanggal, 'd') hari,
						to_char(tj.fd_tanggal, 'dd') tanggal,
						to_char(tj.fd_tanggal, '/mm/YYYY') bulan,
						cast(tj.fd_tanggal as date) fd_tanggal,
						tk.fs_kd_katering, 
						tk.fs_nama_katering, 
						tj.fs_tujuan_shift1, 
						tj.fs_tujuan_shift2, 
						tj.fs_tujuan_shift3  
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
						on tk.fs_kd_katering = tj.fs_kd_katering 
				where 	tj.fb_tanda = '0' 
						and tj.fs_kd_katering = '$kd' 
						and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
						and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))
				order by fd_tanggal";
				// echo $sql;exit();
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJadwalCateringAkhir($data){
		$kd = $data['kode'];
		$tgl = $data['periode'];
		$sql = "update \"Catering\".tjadwal tj 
				set fb_tanda = '0' 
				where tj.fs_kd_katering = '$kd' 
					and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
					and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))";
		$this->personalia->query($sql);

		$sql = "select 	to_char(tj.fd_tanggal, 'd') hari,
						to_char(tj.fd_tanggal, 'dd') tanggal,
						to_char(tj.fd_tanggal, 'month YYYY') bulan,
						cast(tj.fd_tanggal as date) fd_tanggal,
						tk.fs_kd_katering, 
						tk.fs_nama_katering, 
						tj.fs_tujuan_shift1, 
						tj.fs_tujuan_shift2, 
						tj.fs_tujuan_shift3  
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
						on tk.fs_kd_katering = tj.fs_kd_katering 
				where 	tj.fb_tanda = '0' 
						and tj.fs_kd_katering = '$kd' 
						and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
						and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))
				order by fd_tanggal desc limit 1;";
				// echo $sql;exit();
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	public function getJadwalCateringAkhirDistribusi($data){
		$kd = $data['kode'];
		$tgl = $data['periode'];
		$sql = "update \"Catering\".tjadwal tj 
				set fb_tanda = '0' 
				where tj.fs_kd_katering = '$kd' 
					and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
					and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))";
		$this->personalia->query($sql);

		$sql = "select 	to_char(tj.fd_tanggal, 'd') hari,
						to_char(tj.fd_tanggal, 'dd') tanggal,
						to_char(tj.fd_tanggal, '/mm/YYYY') bulan,
						cast(tj.fd_tanggal as date) fd_tanggal,
						tk.fs_kd_katering, 
						tk.fs_nama_katering, 
						tj.fs_tujuan_shift1, 
						tj.fs_tujuan_shift2, 
						tj.fs_tujuan_shift3  
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
						on tk.fs_kd_katering = tj.fs_kd_katering 
				where 	tj.fb_tanda = '0' 
						and tj.fs_kd_katering = '$kd' 
						and date_part('month',tj.fd_tanggal) = date_part('month',cast('".$tgl." 01' as date))
						and date_part('year',tj.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))
				order by fd_tanggal desc limit 1;";
				// echo $sql;exit();
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJadwalCateringHplus($data){
		$tanggal = $data['tanggal'];
		$kd = $data['katering'];
		$s1 = $data['s1'];
		$s2 = $data['s2'];
		$s3 = $data['s3'];

		if ($s1 == 't') {
			$s1 = '1';
		}else{
			$s1 = '0';
		}
		if ($s2 == 't') {
			$s2 = '1';
		}else{
			$s2 = '0';
		}
		if ($s3 == 't') {
			$s3 = '1';
		}else{
			$s3 = '0';
		}

		$sql = "select 	to_char(tj.fd_tanggal, 'd') hari,
						to_char(tj.fd_tanggal, 'dd') tanggal,
						to_char(tj.fd_tanggal, 'month YYYY') bulan,
						cast(tj.fd_tanggal as date) fd_tanggal,
						tk.fs_kd_katering, 
						tk.fs_nama_katering, 
						tj.fs_tujuan_shift1, 
						tj.fs_tujuan_shift2, 
						tj.fs_tujuan_shift3  
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
						on tk.fs_kd_katering = tj.fs_kd_katering 
				where 	tj.fb_tanda = '0'
						and fs_tujuan_shift1 ='$s1' 
						and fs_tujuan_shift2 ='$s2' 
						and fs_tujuan_shift3 = '$s3' 
						and tj.fs_kd_katering = '$kd' 
						and fd_tanggal = (cast('$tanggal' as date) + interval '1 day')
				order by fd_tanggal";
				// echo $sql;exit();
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getHariLibur($tanggal){
		$sql = "select tanggal 
				 from \"Dinas_Luar\".tlibur 
				 where tanggal = '$tanggal' ";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getHariLiburHplus($tanggal){
		$sql = "select tanggal 
				 from \"Dinas_Luar\".tlibur 
				 where tanggal = (cast('$tanggal' as date) + interval '1 day') ";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getMonth($periode){
		$sql = "select to_char(((cast('01 ".$periode."' as date)+ interval '1 month')- interval '1 day'),'DD month YYYY') tanggal;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	public function getMonth2($periode){
		$sql = "select to_char(cast('$periode' as date), 'month YYYY') tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCheckJadwalCatering($periode,$kd){
		$sql = "select to_char(cast(fd_tanggal as date),'dd month yyyy') as fd_tanggal,fs_kd_katering,fs_tujuan_shift1,fs_tujuan_shift2,fs_tujuan_shift3 from \"Catering\".tjadwal where fd_tanggal between '".$periode['0']."' and '".$periode['1']."' and fs_kd_katering = '".$kd."'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertJadwalCatering($data){
		$x = explode(" ", $data['awal']);
		$y = explode(" ", $data['akhir']);

		for ($i=$x['0']; $i <= $y['0']; $i++) { 
			$sql = "insert into \"Catering\".tjadwal
			(fd_tanggal, fs_kd_katering, fs_tujuan_shift1, fs_tujuan_shift2, fs_tujuan_shift3) 
			values(cast('".$i." ".$x['1']." ".$x['2']."' as timestamp),'".$data['kd']."','".$data['s1']."','".$data['s2']."','".$data['s3']."')";
			$this->personalia->query($sql);
		}
	}

	public function updateJadwalCatering($data){
		$sql = "update \"Catering\".tjadwal set fs_tujuan_shift1 = '".$data['s1']."', fs_tujuan_shift2 = '".$data['s2']."', fs_tujuan_shift3 = '".$data['s3']."'
			where fd_tanggal between cast('".$data['awal']."' as timestamp) and cast('".$data['akhir']."' as timestamp) and fs_kd_katering = '".$data['kd']."';";
			$this->personalia->query($sql);
	}

	public function insertTampilPesanan($data){
		$this->personalia->insert("\"Catering\".ttampilpesanan",$data);
	
	}

	public function deleteTampilPesanan($periode,$kd){
		$periode = explode(" ",$periode);
		$sql = "delete from \"Catering\".ttampilpesanan 
				where right(fs_tanggal,7) = to_char(cast('01 ".$periode['0']." ".$periode['1']."' as date), 'MM/YYYY') 
				and fs_kd_katering = '$kd'";
		
		$this->personalia->query($sql);
	}

	public function deleteJadwalCatering($data){
		$sql = "delete from \"Catering\".tjadwal where fs_kd_katering = '".$data['kd']."' and fd_tanggal between '".$data['awal']."' and '".$data['akhir']."' and fs_tujuan_shift1 = '".$data['s1']."' and fs_tujuan_shift2 = '".$data['s2']."' and fs_tujuan_shift3 = '".$data['s3']."'";
		$this->personalia->query($sql);
	}

	public function getKateringLokasiByKodeKatering($kode_katering){
		$sql = "select lokasi_kerja
				from \"Catering\".tkatering
				where fs_kd_katering = ?";
		return $this->personalia->query($sql,array($kode_katering))->row()->lokasi_kerja;
	}
}
?>