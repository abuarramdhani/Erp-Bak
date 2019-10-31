<?php defined('BASEPATH') or die('No direct script access allowed');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 0); // for infinite time of execution 
class M_importcomponent extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db = $this->load->database('default', TRUE);
        }

    public function checkcomponent($drw_code, $rev){
		// echo"<pre>";print_r($code);exit;
        $sql = "SELECT * from fpd.khs_component where drw_code='$drw_code' 
        and rev='$rev'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function insertproduct($id,$product,$drw_group,$drw_code,$drw_description,$drw_date,$drw_material,$rev,$weight,$status,$changing_ref_doc,$changing_ref_explanation)
    {
        $sql = "INSERT INTO fpd.khs_component (product_id, product, drw_group, drw_code,drw_description, drw_date, drw_material, rev, weight, status, changing_ref_doc, changing_ref_expl) 
                VALUES ('$id','$product', '$drw_group', '$drw_code',
                '$drw_description', '$drw_date', '$drw_material', '$rev', '$weight', '$status', '$changing_ref_doc', '$changing_ref_explanation')";
        $query = $this->db->query($sql);
        // return $sql;
    }

    public function updateproduct($id, $product,$drw_group,$drw_code,$drw_description,$drw_date,$drw_material,$rev,$weight, $status,$changing_ref_doc,$changing_ref_explanation)
    {
        $sql="UPDATE fpd.khs_component 
                set product_id='$id' ,
                product ='$product',
                drw_group='$drw_group', 
                drw_description='$drw_description', 
                drw_date='$drw_date', 
                drw_material='$drw_material',
                weight='$weight', 
                status='$status', 
                changing_ref_doc='$changing_ref_doc', 
                changing_ref_expl='$changing_ref_explanation'
                where drw_code='$drw_code' 
                and rev='$rev'";
        $query= $this->db->query($sql);
    }
    
    public function getid($product){
        // echo"<pre>";print_r($code);exit;
        $sql = "SELECT product_id from fpd.khs_product where product_name='$product'";
        $query = $this->db->query($sql);
        // echo"<pre>";print_r($code);exit;
        // if ($query =! null) {
            return $query->result_array();
        // } else {
            // return $query[0]['product_id'];
        // }
        
    }
}