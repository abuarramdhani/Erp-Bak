<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pekerjaan extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);


	}
	public function lihat(){
		$sql = "select *,case when satuan='H' then 'Hari' when satuan='M' then'Minggu'else 'Bulan'end as waktu, 
		(select case when b.seksi != '-' then concat('Seksi;',b.seksi) when b.unit != '-' then concat('Unit;',b.unit)
         when b.bidang != '-' then concat('Bidang;',b.bidang) when b.dept != '-' then concat('Dept;',b.dept) end as seksi from hrd_khs.tseksi b where left(b.kodesie,7) = left(a.kdpekerjaan,7) order by b.kodesie limit 1) as seksi,case when jenispekerjaan='0' then'Direct Labour' else'Indirect Labour'end as jenis,case when status='0' then'Aktif' else'Tidak Aktif'end as status
		from hrd_khs.tpekerjaan a 
		order by kdpekerjaan asc";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	

	 public function input($input)
	 	{
	 		$this->personalia->insert('hrd_khs.tpekerjaan',$input);
	 	}


	    public function delete($id)
	    {
	    	$sql = "delete from hrd_khs.tpekerjaan where id_kdpekerjaan='$id'";
		$result = $this->personalia->query($sql);
		return $result;
	    }

	     public function GetPekerjaan($id)
	    {
	    	$sql = "select *,case when satuan='H' then 'Hari' when satuan='M' then'Minggu'else 'Bulan'end as waktu, 
		(select case when b.seksi != '-' then b.seksi when b.unit != '-' then b.unit
          when b.bidang != '-' then b.bidang when b.dept != '-' then b.dept end as seksi from hrd_khs.tseksi b where left(b.kodesie,7) = left(a.kdpekerjaan,7) order by b.kodesie limit 1),case when jenispekerjaan='0' then'Direct Labour' else'Indirect Labour'end as jenis,case when status='0' then'Aktif' else'Tidak Aktif'end as status
		from hrd_khs.tpekerjaan a  where id_kdpekerjaan='$id'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	    }

	    public function editSetupPekerjaan($id)
	    {
	    	$sql = "select *,case when satuan='H' then 'Hari' when satuan='M' then'Minggu'else 'Bulan'end as waktu, 
		(select b.dept as dept from hrd_khs.tseksi b where left(b.kodesie,7) = left(a.kdpekerjaan,7) order by b.kodesie limit 1),
		(select b.bidang as bidang from hrd_khs.tseksi b where left(b.kodesie,7) = left(a.kdpekerjaan,7) order by b.kodesie limit 1),
		(select b.unit as unit from hrd_khs.tseksi b where left(b.kodesie,7) = left(a.kdpekerjaan,7) order by b.kodesie limit 1),
		(select b.seksi as seksi from hrd_khs.tseksi b where left(b.kodesie,7) = left(a.kdpekerjaan,7) order by b.kodesie limit 1),case when jenispekerjaan='0' then'Direct Labour' else'Indirect Labour'end as jenis
		from hrd_khs.tpekerjaan a  where id_kdpekerjaan='$id'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	    }


	

	    public function update($id,$data)
	    {
			$this->personalia->where('id_kdpekerjaan', $id);
	    	$this->personalia->update('hrd_khs.tpekerjaan',$data);

	    }

	     public function updatepribadi($kdpekerjaan1,$kdpekerjaan2)
	    {
			$sql = "update hrd_khs.tpribadi set kd_pkj =$kdpekerjaan1 where kd_pkj =(select kdpekerjaan from hrd_khs.tpekerjaan where id_kdpekerjaan = $kdpekerjaan2)";
		$result = $this->personalia->query($sql);

		return $sql;
		

	    }
	    public function urut($kodesie){
	    	 $sql = "select coalesce((max(cast(kdPekerjaan as integer))+1)::varchar,concat('$kodesie','01')) as kodeselanjutnya 
	    	 	from hrd_khs.tpekerjaan where kdPekerjaan like '$kodesie%'";
	     $result = $this->personalia->query($sql);
		return $result;
	    }

	    public function ambilDepartemen()
		{
			$ambilDepartemen			= "	select distinct 	substring(tseksi.kodesie,1,1) as kode_departemen,
																rtrim(tseksi.dept) as nama_departemen
											from 				hrd_khs.tseksi as tseksi
											where 				rtrim(tseksi.kodesie)!='-'
																and 	rtrim(tseksi.dept)!='-'
											order by 			kode_departemen;";
			$queryAmbilDepartemen		=	$this->personalia->query($ambilDepartemen);
			return $queryAmbilDepartemen->result_array();
		}

		public function ambilBidang($departemen)
		{
			$ambilBidang 				= "	select distinct		substring(tseksi.kodesie,1,3) as kode_bidang,
																rtrim(tseksi.bidang) as nama_bidang
											from 				hrd_khs.tseksi as tseksi
											where 				rtrim(tseksi.kodesie)!='-'
																and 	rtrim(tseksi.bidang)!='-'
																and 	substring(tseksi.kodesie,1,1)='$departemen'
											order by 			kode_bidang;";
			$queryAmbilBidang 			=	$this->personalia->query($ambilBidang);
			return $queryAmbilBidang->result_array();
		}

		public function ambilUnit($bidang)
		{
			$ambilUnit			= "	select distinct 	substring(tseksi.kodesie,1,5) as kode_unit,
														rtrim(tseksi.unit) as nama_unit
									from 				hrd_khs.tseksi as tseksi
									where 				rtrim(tseksi.kodesie)!='-'
														and 	rtrim(tseksi.unit)!='-'
														and 	substring(tseksi.kodesie,1,3)='$bidang'			
									order by 			kode_unit;";
			$queryAmbilUnit 	=	$this->personalia->query($ambilUnit);
			return $queryAmbilUnit->result_array();
		}

		public function ambilSeksi($unit)
		{
			$ambilSeksi			= "	select distinct 	substring(tseksi.kodesie,1,7) as kode_seksi,
														rtrim(tseksi.seksi) as nama_seksi
									from 				hrd_khs.tseksi as tseksi
									where 				rtrim(tseksi.kodesie)!='-'
														and 	rtrim(tseksi.seksi)!='-'
														and 	substring(tseksi.kodesie,1,5)='$unit'				
									order by 			kode_seksi;";
			$queryAmbilSeksi	=	$this->personalia->query($ambilSeksi);
			return $queryAmbilSeksi->result_array();
		}

		public function tlogTambah($kdsie,$user)
		{
		 $sql = "insert into hrd_khs.tlog (wkt, menu, ket, noind, jenis,program) 
                                       values (now()
                                        ,'SETUP->PEKERJAAN','KDPEKERJAAN->($kdsie)','$user','TAMBAH','QUICK_ERP')";
        $this->personalia->query($sql);
		
		}

		public function tlogEdit($kdsie,$user)
		{
		 $sql = "insert into hrd_khs.tlog (wkt, menu, ket, noind, jenis,program) 
                                       values (now()
                                        ,'SETUP->PEKERJAAN','KDPEKERJAAN->($kdsie)','$user','EDIT','QUICK_ERP')";
        $this->personalia->query($sql);
		
		}

		public function tlogHapus($kdsie,$user)
		{
		 $sql = "insert into hrd_khs.tlog (wkt, menu, ket, noind, jenis,program) 
                                       values (now()
                                        ,'SETUP->PEKERJAAN','KDPEKERJAAN->($kdsie)','$user','HAPUS','QUICK_ERP')";
        $this->personalia->query($sql);
		
		}

		public function cekKodepekerjaan($kd_pkj){
			$sql = "select * from hrd_khs.tpekerjaan where kdpekerjaan = '$kd_pkj'";
			return $this->personalia->query($sql)->num_rows();
		}

		public function cariKodePekerjaan($id){
			$sql = "select kdpekerjaan from hrd_khs.tpekerjaan where id_kdpekerjaan = '$id'";
			return $this->personalia->query($sql)->row()->kdpekerjaan;
		}

};    




