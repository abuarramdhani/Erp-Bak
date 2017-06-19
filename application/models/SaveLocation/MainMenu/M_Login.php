<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_Login extends CI_Model
{
	public function __construct()
	    {
	        parent::__construct();
	    }

	public function data_login($username, $password)
        {
                $sql=" select * from FND_USER WHERE USER_NAME = '$username' AND XXTA_GET('APPS',ENCRYPTED_USER_PASSWORD) = '$password'";
                $query=$this->db->query($sql);
                return $query;
        }
}

