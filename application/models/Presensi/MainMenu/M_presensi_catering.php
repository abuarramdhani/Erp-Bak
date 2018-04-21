<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_presensi_catering extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	        $this->quickcom		=	$this->load->database('quickcom', TRUE);
	    }

	    public function ambilRiwayatTarikCatering($tanggal_pencarian)
	    {
	    	$ambilRiwayatTarikCatering			= "	SELECT 		log_cron.noind,
																/*sftpkj.kodesie,
																sftpkj.kd_shift,*/
																(SUBSTRING_INDEX(SUBSTRING_INDEX(log_cron.ket, '; ', 1), ': ', -1)) AS waktu_masuk,
																log_cron.waktu AS waktu_proses
													FROM 		fp_distribusi.tb_log_transaksi AS log_cron
																/*JOIN 	presensi.tshiftpekerja AS sftpkj
																		ON 	sftpkj.noind=log_cron.noind
																			AND	sftpkj.tanggal=DATE(log_cron.waktu)*/
													WHERE 		DATE(log_cron.waktu)='$tanggal_pencarian'
																AND 	log_cron.cronjob='cronjob.catering.tpresensigo'
													ORDER BY 	log_cron.waktu";
			$queryAmbilRiwayatTarikCatering 	=	$this->quickcom->query($ambilRiwayatTarikCatering);
			return $queryAmbilRiwayatTarikCatering->result_array();
	    }

	    public function ambilRiwayatProsesCatering($tanggal_pencarian)
	    {
	    	$ambilRiwayatProsesCatering 		= "	select 		tlog.wkt as waktu_proses,
																tlog.menu
													from 		hrd_khs.tlog as tlog
													where 		tlog.program='KATERING'
																and 	tlog.menu='PROSES PESANAN'
																and 	tlog.wkt::date='$tanggal_pencarian'";
			$queryAmbilRiwayatProsesCatering	=	$this->personalia->query($ambilRiwayatProsesCatering);
			return $queryAmbilRiwayatProsesCatering->result_array();
	    }
 	}