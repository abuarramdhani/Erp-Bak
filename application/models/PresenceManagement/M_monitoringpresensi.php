<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_monitoringpresensi extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();

	        $this->quick 	=	$this->load->database('quick', TRUE);
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	    }

	    public function history($schema_name, $table_name, $history)
 		{
 			$this->quick->insert($schema_name.".".$table_name."_history", $history);
 		}

 		//	Monitoring
 		//	{
 				public function device_user_list($id_lokasi_decode)
 				{
 					$this->quick->select('
 												useraccess.*,
 												tpribadi.nama,
 												tpribadi.noind,
 												tpribadi.kodesie,
 												tpribadi.keluar,
 												tpribadi.id_lokasi_kerja,
 												coalesce(tlokasi_kerja.lokasi_kerja, "BELUM TERDAFTAR") nama_lokasi_kerja
 											');
 					$this->quick->from('db_datapresensi.tb_user_access useraccess');
 					$this->quick->join('db_datapresensi.vi_tpribadi tpribadi', 'tpribadi.noind = useraccess.noind', 'left');
			    	$this->quick->join('hrd_khs.tlokasi_kerja tlokasi_kerja', 'tlokasi_kerja.id_ = tpribadi.id_lokasi_kerja', 'left');

 					$this->quick->where('id_lokasi =', $id_lokasi_decode);

 					$this->quick->order_by('noind');
 					return $this->quick->get()->result_array();
 				}

 				public function registered_user($keyword)
 				{
 					$this->quick->select('
 												user.*
 											');
 					$this->quick->from('db_datapresensi.tb_user user');
 					$this->quick->group_start();
 						$this->quick->like('user.noind_baru', $keyword, 'after');
 						$this->quick->or_like('user.noind', $keyword, 'after');
 						$this->quick->or_like('user.nama', $keyword);
 					$this->quick->group_end();

 					$this->quick->order_by('user.noind');
 					return $this->quick->get()->result_array();
 				}

 				public function user_access_get($id_user_access = FALSE, $where = FALSE)
 				{
 					$this->quick->select('
 											user_access.*,
 											device.device_sn,
 											device.server_ip,
 											device.server_port
 										');
 					$this->quick->from('db_datapresensi.tb_user_access user_access');
 					$this->quick->join('db_datapresensi.tb_device device', 'device.id_lokasi = user_access.id_lokasi');

 					if ( $id_user_access !== FALSE )
 					{
 						$this->quick->where('id_user_access =', $id_user_access);
 					}

 					if ( $where !== FALSE )
 					{
 						$this->quick->where($where);
 					}
 					

 					return $this->quick->get()->result_array();
 				}

 				public function user_access_exist_check($noind_baru, $id_lokasi)
 				{
 					$this->quick->from('db_datapresensi.tb_user_access');
 					$this->quick->where('noind_baru =', $noind_baru);
 					$this->quick->where('id_lokasi =', $id_lokasi);

 					return $this->quick->count_all_results();
 				}

 				public function user_access_insert($user_access_insert)
 				{
 					$this->quick->insert('db_datapresensi.tb_user_access', $user_access_insert);
 					return $this->quick->insert_id();
 				}

 				public function user_access_update($user_access_update, $where)
 				{
 					$this->quick->where($where);
 					$this->quick->update('db_datapresensi.tb_user_access', $user_access_update);
 				}

 				public function user_access_jari_ref_exist_check($id_user_access, $kode_finger)
 				{
 					$this->quick->from('db_datapresensi.tb_user_access_jari_ref');
 					$this->quick->where('id_user_access =', $id_user_access);
 					
 					if ( $kode_finger !== FALSE AND $kode_finger == 'DEFAULT' )
 					{
 						$kode_finger_array 	=	array('0', '1', '2', '3');
 						$this->quick->where_in('kode_finger', $kode_finger_array);
 					}
 					elseif ( $kode_finger !== FALSE AND is_array($kode_finger) )
 					{
 						$this->quick->where_in('kode_finger', $kode_finger);
 					}

 					return $this->quick->count_all_results();
 				}

 				public function user_access_delete($id_user_access)
 				{
 					$this->quick->where('id_user_access =', $id_user_access);
 					$this->quick->delete('db_datapresensi.tb_user_access');
 				}

 				public function user_finger_template($noind_baru, $kode_finger = FALSE, $count_all_results = FALSE)
 				{
 					$this->quick->select('*');
 					$this->quick->from('db_datapresensi.tb_jari');
 					$this->quick->where('noind_baru =', $noind_baru);

 					if ( $kode_finger !== FALSE AND $kode_finger == 'DEFAULT' )
 					{
 						$kode_finger_array 	=	array('0', '1', '2', '3');
 						$this->quick->where_in('kode_finger', $kode_finger_array);
 					}
 					elseif ( $kode_finger !== FALSE AND is_array($kode_finger) )
 					{
 						$this->quick->where_in('kode_finger', $kode_finger);
 					}

 					$this->quick->order_by('kode_finger');
 					return $this->quick->get()->result_array();
 				}

 				public function user_access_jari_ref_insert($user_access_jari_ref_insert)
 				{
 					$this->quick->insert('db_datapresensi.tb_user_access_jari_ref', $user_access_jari_ref_insert);
 					return $this->quick->insert_id();
 				}

 				public function user_access_jari_ref_check_exist($id_user_access, $kode_finger)
 				{
 					$this->quick->from('db_datapresensi.tb_user_access_jari_ref');
 					$this->quick->where('id_user_access =', $id_user_access);
 					$this->quick->where('kode_finger =', $kode_finger);

 					return $this->quick->count_all_results();
 				}

 				public function user_access_jari_ref_delete($id_user_access)
 				{
 					$this->quick->where('id_user_access =', $id_user_access);
 					$this->quick->delete('db_datapresensi.tb_user_access_jari_ref');
 				}
 		//	}

 		//	Scanlog
 		//	{
 				public function scanlog_exist_check($device_sn, $scan_date, $noind_baru)
 				{
 					$this->quick->from('db_datapresensi.tb_scanlog');
 					$this->quick->where('sn =', $device_sn);
 					$this->quick->where('scan_date =', $scan_date);
 					$this->quick->where('noind_baru =', $noind_baru);

 					return $this->quick->count_all_results();
 				}

 				public function scanlog_update($scanlog, $device_sn, $scan_date, $noind_baru)
 				{
 					$this->quick->where('sn =', $device_sn);
 					$this->quick->where('scan_date =', $scan_date);
 					$this->quick->where('noind_baru =', $noind_baru);

 					$this->quick->update('db_datapresensi.tb_scanlog', $scanlog);
 				}

 				public function scanlog_insert($scanlog)
 				{
 					$this->quick->insert('db_datapresensi.tb_scanlog', $scanlog);
 					return $this->quick->insert_id();
 				}

 				public function scanlog_insert_backup($scanlog)
 				{
 					$this->quick->insert('db_datapresensi.tb_scanlog_backup', $scanlog);
 					return $this->quick->insert_id();
 				}

 				public function scanlog_get($transfer = FALSE)
 				{
 					$this->quick->select('*');
 					$this->quick->from('db_datapresensi.vi_datapresensi');

 					if ( $transfer !== FALSE )
 					{
 						$this->quick->where('transfer =', $transfer);
 					}

 					return $this->quick->get()->result_array();
 				}
 		//	}

	    //	Device Management
	    //	{
			    public function device_fingerprint($id_lokasi = FALSE)
			    {
			    	$this->quick->select('
			    								device.*,
			    								lokasi_kerja.lokasi_kerja
			    							');
			    	$this->quick->from('db_datapresensi.tb_device device');
			    	$this->quick->join('hrd_khs.tlokasi_kerja lokasi_kerja', 'device.office = lokasi_kerja.id_');

			    	if ( $id_lokasi !== FALSE )
			    	{
			    		$this->quick->where('id_lokasi =', $id_lokasi);
			    	}

			    	return $this->quick->get()->result_array();
			    }

			    public function id_lokasi_terakhir()
			    {
			    	$this->quick->select_max('substr(id_lokasi, 3, 2)', 'id_lokasi');
			    	$this->quick->from('db_datapresensi.tb_device');

			    	return $this->quick->get()->result_array();
			    }

			    public function device_create($device_create)
			    {
			    	$this->quick->insert('db_datapresensi.tb_device', $device_create);
			    	return $this->quick->insert_id();
			    }

			    public function device_update($device_update, $id_lokasi)
			    {
			    	$this->quick->where('id_lokasi =', $id_lokasi);
			    	$this->quick->update('db_datapresensi.tb_device', $device_update);
			    }
	    //	}

		//	User Management
		//	{
			    public function user_list($noind_baru = FALSE)
			    {
			    	$this->quick->select('
			    							user.*,
			    							tpribadi.nama,
											tpribadi.noind,
											tpribadi.kodesie,
											tpribadi.keluar,
											tpribadi.id_lokasi_kerja,
											coalesce(tlokasi_kerja.lokasi_kerja, "BELUM TERDAFTAR") nama_lokasi_kerja
			    						');
			    	$this->quick->from('db_datapresensi.tb_user user');
			    	$this->quick->join('db_datapresensi.vi_tpribadi tpribadi', 'tpribadi.noind = user.noind', 'left');
			    	$this->quick->join('hrd_khs.tlokasi_kerja tlokasi_kerja', 'tlokasi_kerja.id_ = tpribadi.id_lokasi_kerja', 'left');

			    	if ( $noind_baru !== FALSE )
			    	{
			    		$this->quick->where_in('user.noind_baru', $noind_baru);
			    	}

			    	return $this->quick->get()->result_array();
			    }

			    public function user_cek($noind_baru)
			    {
			    	$this->quick->from('db_datapresensi.tb_user');

			    	$this->quick->where('noind_baru =', $noind_baru);

			    	return $this->quick->count_all_results();
			    }

			    public function user_create($user_create)
			    {
			    	$this->quick->insert('db_datapresensi.tb_user', $user_create);
			    	return $this->quick->insert_id();
			    }

			    public function user_update($user_update, $user_noind_baru)
			    {
			    	$this->quick->where('noind_baru =', $user_noind_baru);
			    	$this->quick->update('db_datapresensi.tb_user', $user_update);
			    }

			    public function jari_cek($jari_noind_baru, $jari_kode_finger)
			    {
			    	$this->quick->from('db_datapresensi.tb_jari');
			    	$this->quick->where('noind_baru =', $jari_noind_baru);
			    	$this->quick->where('kode_finger =', $jari_kode_finger);

			    	return $this->quick->count_all_results();
			    }

			    public function jari_create($jari_create)
			    {
			    	$this->quick->insert('db_datapresensi.tb_jari', $jari_create);
			    	return $this->quick->insert_id();
			    }

			    public function jari_update($jari_update, $jari_noind_baru, $jari_kode_finger)
			    {
			    	$this->quick->where('noind_baru =', $jari_noind_baru);
			    	$this->quick->where('kode_finger =', $jari_kode_finger);
			    	$this->quick->update('db_datapresensi.tb_jari', $jari_update);
			    }
		//	}

		//	Distribusi Presensi
		//	{
			    public function insert_presensi($table_schema, $table_name, $insert)
			    {
			    	$this->personalia->insert($table_schema.".".$table_name, $insert);
			    }
		//	}

	    public function lokasi_kerja($keyword = FALSE)
	    {
	    	$this->personalia->select('*');
	    	$this->personalia->from('hrd_khs.tlokasi_kerja');

	    	if ( $keyword !== FALSE )
	    	{
	    		$this->personalia->like('id_', $keyword);
		    	$this->personalia->or_like('lokasi_kerja', $keyword);
	    	}

			$this->personalia->order_by('id_');

			return $this->personalia->get()->result_array();
	    }

	    public function pekerja($keyword = FALSE)
	    {
	    	$this->personalia->select('
	    								noind_baru,
	    								noind,
	    								nama,
	    								nik,
	    								tgllahir
	    							');
	    	$this->personalia->from('hrd_khs.v_hrd_khs_tpribadi');
	    	$this->personalia->where('keluar =', FALSE);

	    	if ( $keyword !== FALSE )
	    	{
	    		$this->personalia->group_start();
			    	$this->personalia->like('noind_baru', $keyword);
			    	$this->personalia->or_like('noind', $keyword, 'after');
			    	$this->personalia->or_like('nama', $keyword);
		    	$this->personalia->group_end();
	    	}

	    	return $this->personalia->get()->result_array();
	    }

	    public function finger_reference($keyword = FALSE)
	    {
	    	$this->quick->select('*');
	    	$this->quick->from('db_datapresensi.tb_jari_ref');

	    	if ( $keyword !== FALSE )
	    	{
	    		$this->quick->group_start();
	    			$this->quick->like('nama_jari', $keyword);
	    			$this->quick->or_like('kode_finger', $keyword);
	    		$this->quick->group_end();
	    	}

	    	$this->quick->order_by('kode_finger');
	    	return $this->quick->get()->result_array();
	    }
 	}