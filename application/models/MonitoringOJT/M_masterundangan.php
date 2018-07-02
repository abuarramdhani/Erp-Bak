<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_masterundangan extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	    }

	    public function inputUndangan($inputUndangan)
	    {
	    	$this->db->insert('ojt.tb_memo', $inputUndangan);
	    	return $this->db->insert_id();
	    }
	    
	    public function inputUndanganHistory($inputUndanganHistory)
	    {
	    	$this->db->insert('ojt.tb_memo_history', $inputUndanganHistory);
	    }

	    public function ambilDaftarFormatUndangan($id_memo = FALSE, $keyword_support = FALSE)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_memo');
	    	
	    	if($id_memo !== FALSE)
	    	{
	    		$this->db->where('id_memo=', $id_memo);
	    	}

	    	if($keyword_support !== FALSE)
	    	{
	    		$this->db->like('judul', $keyword_support, 'both');
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function updateUndangan($updateUndangan, $id_memo_decode)
	    {
	    	$this->db->where('id_memo=', $id_memo_decode);
	    	$this->db->update('ojt.tb_memo', $updateUndangan);
	    }

	    public function updateUndanganHistory($updateUndanganHistory)
	    {
	    	$this->db->insert('ojt.tb_memo_history', $updateUndanganHistory);
	    }

	    public function deleteUndanganHistory($deleteUndanganHistory)
	    {
	    	$this->db->insert('ojt.tb_memo_history', $deleteUndanganHistory);
	    }

	    public function deleteUndangan($id_memo_decode)
	    {
	    	$this->db->where('id_memo=', $id_memo_decode);
	    	$this->db->delete('ojt.tb_memo');
	    }

	    public function ambilDaftarPenerimaUndangan()
	    {
	    	$ambilDaftarPenerimaUndangan 		= "	select 		berkas.*,
																concat
																(
																 	(
																 		case 	when 	berkas.hari is not null
																 						then 	'Hari H'
																 				when 	berkas.minggu is not null
																 						then 	'Minggu M'
																 				when 	berkas.bulan is not null
																 						then 	'Bulan B'
																 		end
																 	),
																 	(
																 		case 	when 	(
																 							(
																 								berkas.hari is not null
																 								and 	berkas.hari!=0
																 							) 
																 							or 	(
																 									berkas.minggu is not null
																 									and 	berkas.minggu!=0
																 								) 
																 							or 	(
																 									berkas.bulan is not null
																 									and 	berkas.bulan!=0
																 								)
																 						)
																		 				then 	(
																		 							case 	when 	berkas.urutan=false
																		 											then 	concat
																		 													(
																		 														'-',
																		 														(
																		 															case 	when 	berkas.hari is not null
																		 																			then 	berkas.hari
																		 																	when 	berkas.minggu is not null
																		 																			then 	berkas.minggu
																		 																	when 	berkas.bulan is not null
																		 																			then 	berkas.bulan
																		 															end
																		 														)
																		 													)
																		 									else 	concat
																		 											(
																		 												'+',
																		 												(
																		 													case 	when 	berkas.hari is not null
																		 																	then 	berkas.hari
																		 															when 	berkas.minggu is not null
																		 																	then 	berkas.minggu
																		 															when 	berkas.bulan is not null
																		 																	then 	berkas.bulan
																		 													end
																		 												)
																		 											)
																		 							end
																		 						)
																		 		when 	(
																		 					berkas.hari=0
																		 					or 	berkas.minggu=0
																		 					or 	berkas.bulan=0
																		 				)
																		 		then 	''
																		 end
																 	)
																) as waktu
													from 		ojt.tb_berkas as berkas";
			$queryAmbilDaftarPenerimaUndangan	=	$this->db->query($ambilDaftarPenerimaUndangan);
			return $queryAmbilDaftarPenerimaUndangan->result_array();
	    }


	    // --------------

	    public function undangan($id_undangan = FALSE)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_master_undangan');

	    	if ( $id_undangan !== FALSE )
	    	{
	    		$this->db->where('id_undangan =', $id_undangan);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function create($create_undangan)
	    {
	    	$this->db->insert('ojt.tb_master_undangan', $create_undangan);
	    	return $this->db->insert_id();
	    }

	    public function update($update_undangan, $id_undangan)
	    {
	    	$this->db->where('id_undangan =', $id_undangan);
	    	$this->db->update('ojt.tb_master_undangan', $update_undangan);
	    }

	    public function delete($id_undangan)
	    {
	    	$this->db->where('id_undangan =', $id_undangan);
	    	$this->db->delete('ojt.tb_master_undangan');
	    }
 	}