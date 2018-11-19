<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_layoutsurat extends CI_Model
	{
    	public function __construct()
	    {
	       parent::__construct();
	       $this->personalia	= 	$this->load->database('personalia', TRUE);
	    }

	    public function inputFormatSurat($inputFormat)
	    {
		    $this->personalia->insert('"Surat".tisi_surat', $inputFormat);
	    }

	    public function ambilLayoutSurat()
	    {
	    	$this->personalia->select('*');
	    	$this->personalia->from('"Surat".tisi_surat');
	    	$this->personalia->order_by('jenis_surat asc');

	    	return $this->personalia->get()->result_array();
	    }

	    public function ambilLayoutSuratDetail($id_isi_decode)
	    {
	    	$this->personalia->select('*');
	    	$this->personalia->from('"Surat".tisi_surat');
	    	$this->personalia->where('id_isi=', $id_isi_decode);

	    	return $this->personalia->get()->result_array();
	    }

	    public function updateLayoutSurat($updateLayoutSurat, $id_isi_decode)
	    {
	    	$this->personalia->where('id_isi=', $id_isi_decode);
	    	$this->personalia->update('"Surat".tisi_surat', $updateLayoutSurat);
	    }

	    public function deleteLayoutSurat($id_isi_decode)
	    {
	    	$this->personalia->where('id_isi=', $id_isi_decode);
	    	$this->personalia->delete('"Surat".tisi_surat');
	    }
 	}