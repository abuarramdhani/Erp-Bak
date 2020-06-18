<?php
class M_general extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->personalia = $this->load->database ( 'personalia', TRUE );
    }
	
    public function ambilDaftarSeksi($keywordSeksi)
    {
    	$ambilDaftarSeksi 		= 	"	select 		substring(seksi.kodesie,1,7) as kodesie,
													seksi.seksi as nama_seksi
										from 		hrd_khs.tseksi as seksi
										where 		seksi.kodesie!='-'
													and 	rtrim(seksi.seksi)!='-'
													and 	substring(seksi.kodesie,8,2)='00'
													and 	(
																seksi.kodesie like '%".$keywordSeksi."%'
																or 	seksi.seksi like '%".$keywordSeksi."%'
															)
										order by 	kodesie;";
		$queryAmbilDaftarSeksi 	= 	$this->personalia->query($ambilDaftarSeksi);
		return $queryAmbilDaftarSeksi->result_array();
    }

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}