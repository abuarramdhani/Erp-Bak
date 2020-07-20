<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_usialanjut extends CI_Model
	{
    	public function __construct()
	    {
	       parent::__construct();
	       $this->personalia 	= 	$this->load->database('personalia', TRUE);
	    }

	 	public function ambilLayoutSuratUsiaLanjut()
	 	{
	 		$this->personalia->where('jenis_surat=', 'USIALANJUT');
			$this->personalia->select('isi_surat');
			$this->personalia->from('"Surat".tisi_surat"');

			return $this->personalia->get()->result_array();
	 	}

	 	public function ambilDaftarSuratUsiaLanjut()
	 	{
	 		$ambilDaftarSuratUsiaLanjut 		= "SELECT *,(select seksi from hrd_khs.tseksi b where b.kodesie = a.kodesie  ) seksi  from \"Surat\".tsurat_usialanjut a where deleted_date is null";

			$query 	= $this->personalia->query($ambilDaftarSuratUsiaLanjut);
			return $query->result_array();
	 	}

	 	public function ambilDaftarPekerjaUsiaLanjut()
	 	{
	 		$ambilDaftarPekerjaUsiaLanjut 	="SELECT distinct
	 												(select noind from \"Surat\".tsurat_usialanjut b 
	 												where a.noind = b.noind
	 												order by noind
	 											) tc, c.nama,c.noind,c.tgllahir,c.kodesie,(select seksi from hrd_khs.tseksi b where b.kodesie = c.kodesie  )seksi,c.kd_jabatan,c.tglkeluar,c.sebabklr
	 											FROM \"Surat\".tsurat_usialanjut a right join hrd_khs.tpribadi c on a.noind= c.noind
	 											where age(tgllahir) > '50 year' and keluar = '0' and sebabklr = 'USIA LANJUT' order by c.tgllahir";

			$query 	=	$this->personalia->query($ambilDaftarPekerjaUsiaLanjut);
			return $query->result_array();
	 	}

	 	public function ambilPekerjaUsiaLanjut($noind)
	 	{
	 		$ambilPekerjaUsiaLanjut 	= "	SELECT rtrim(nama) nama,noind,tgllahir,kodesie,(select seksi from hrd_khs.tseksi b where b.kodesie = a.kodesie  )seksi,kd_jabatan,tglkeluar,sebabklr FROM hrd_khs.tpribadi a 
	 		where age(tgllahir) > '50 year' 
	 		and keluar = '0' and sebabklr = 'USIA LANJUT' and noind = '$noind'";

			$query 	=	$this->personalia->query($ambilPekerjaUsiaLanjut);
			return $query->result_array();
	 	}

	 	public function ambilseksiatasan($noind)
	 	{
	 		$ambilseksiatasan 	= "	SELECT rtrim(nama) nama,noind,kodesie,(select seksi from hrd_khs.tseksi b where b.kodesie = a.kodesie  )seksi,(select unit from hrd_khs.tseksi b where b.kodesie = a.kodesie  )unit, (select bidang from hrd_khs.tseksi b where b.kodesie = a.kodesie  )bidang, (select dept from hrd_khs.tseksi b where b.kodesie = a.kodesie  )departemen, kd_jabatan, jabatan,(select jabatan from hrd_khs.torganisasi b where b.kd_jabatan = a.kd_jabatan)jbtn FROM hrd_khs.tpribadi a 
	 		where noind = '$noind'";

			$query 	=	$this->personalia->query($ambilseksiatasan);
			return $query->result_array();
	 	}

	 	public function ambilgenderpekerja($noind)
	 	{
	 		$ambilgenderpekerja 	= "SELECT rtrim(jenkel) jenkel FROM hrd_khs.tpribadi a 
	 		where noind = '$noind'";

			$query 	=	$this->personalia->query($ambilgenderpekerja);
			return $query->row()->jenkel;
	 	}

	 	public function inputSuratUsiaLAnjut($inputSuratUsiaLAnjut)
		{
			$this->personalia->insert('"Surat".tsurat_usialanjut', $inputSuratUsiaLAnjut);
		}

		public function inputNomorSurat($inputNomorSurat)
		{
			$this->personalia->insert('"Surat".t_arsip_nomor_surat', $inputNomorSurat);
		}


		public function ambilIsiSuratUsiaLanjut($noind)
		{
	 		$ambilIsiSuratUsiaLanjut = "SELECT *,(select nama from hrd_khs.tpribadi b where b.noind = a.atasan_1  ) namaatasan1,(select nama from hrd_khs.tpribadi b where b.noind = a.atasan_2  ) namaatasan2  from \"Surat\".tsurat_usialanjut a where noind = '$noind'";

			$query 	= $this->personalia->query($ambilIsiSuratUsiaLanjut);
			return $query->result_array();
		}

		public function updateSuratUsiaLanjut($updateSuratUsiaLanjut, $noind)
		{
			$this->personalia->where('noind', $noind);
			$this->personalia->update('"Surat".tsurat_usialanjut', $updateSuratUsiaLanjut);
		}

		public function UpdateNomorSurat($UpdateNomorSurat, $noind)
		{
			$this->personalia->where('noind', $noind);
			$this->personalia->where('jenis_surat', 'USIALANJUT');
			$this->personalia->update('"Surat".t_arsip_nomor_surat', $UpdateNomorSurat);
		}

		public function deleteSuratUsiaLanjut($noind)
		{
			$this->personalia->where('noind', $noind);
			$this->personalia->set('deleted_by', $this->session->user);
			$this->personalia->set('deleted_date', date('Y-m-d H:i:s'));
			$this->personalia->update('"Surat".tsurat_usialanjut');
		}

		public function deleteArsipSuratUsiaLanjut($bulan_surat, $kode_surat, $no_surat)
		{
			$this->personalia->where('bulan_surat', $bulan_surat);
			$this->personalia->where('kode_surat', $kode_surat);
			$this->personalia->where('nomor_surat', $no_surat);
			$this->personalia->delete('"Surat".t_arsip_nomor_surat');
		}
 	}

