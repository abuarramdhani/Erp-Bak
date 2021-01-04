<?php

/**
 * Maybe will make load page slow
 * Try to refactor this if can
 * 
 */
class M_user extends CI_Model
{
	protected $current_slug = '';

	// array of user menu
	protected $arrayOfUserMenu = [];

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
		$this->load->library('session');
		$this->personalia = $this->load->database('personalia', true);

		// Get actual current slug
		$slug = str_replace(base_url(), '', current_url());
		$this->current_slug = trim(parse_url($slug, PHP_URL_PATH), '/');
		$this->user = $this->session->user;
	}

	public function getUser($user_id = FALSE)
	{
		if ($user_id === FALSE) {
			$sql = "select * from sys.vi_sys_user";
		} else {
			$sql = "select * from sys.vi_sys_user  where user_id=$user_id";
		}

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDataUpdatePassword($noind)
	{
		$sql = "SELECT trim(a.nama) nama,
							a.email_internal as email,
							(select seksi from hrd_khs.tseksi b where b.kodesie = a.kodesie) as seksi
					FROM hrd_khs.tpribadi a
					WHERE a.noind = '$noind'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCheckUser($text)
	{
		$sql = "select * from sys.vi_sys_user where user_name = '$text'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getCheckEmployee($text)
	{
		$sql = "select * from sys.vi_sys_user where employee_code = '$text'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function setUser($data)
	{
		return $this->db->insert('sys.sys_user', $data);
	}

	public function updateUser($data, $user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('sys.sys_user', $data);
	}

	public function setUserResponsbility($data)
	{
		return $this->db->insert('sys.sys_user_application', $data);
	}

	public function UpdateUserResponsbility($data, $user_application_id)
	{
		$this->db->where('user_application_id', $user_application_id);
		$this->db->update('sys.sys_user_application', $data);
	}

	public function DeleteUserResponsbility($user_application_id)
	{
		$this->db->delete('sys.sys_user_application', array('user_application_id' => $user_application_id));
	}

	public function getCustomerByName($id)
	{
		$sql = "select * from cr.vi_cr_customer where upper(customer_name) like '%$id%' order by customer_name limit 50";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOwnerByName($id)
	{
		$sql = "select * from cr.vi_cr_customer where owner='Y' and upper(customer_name) like '%$id%' order by customer_name limit 50";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getCustomerNoGroup($id)
	{
		$sql = "select cust.* from cr.vi_cr_customer cust where upper(cust.customer_name) like '%$id%' and cust.customer_id not in (select cust_group.customer_id from cr.vi_cr_customer_group_customers cust_group)order by cust.customer_name limit 50";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * Cari id responsbility berdasaran slug url
	 * @example /NamaAplikasi
	 * 
	 * @param  String   $slug
	 * @return Int/Null id
	 * 
	 * Todo:
	 * Make optimization
	 * 
	 * Bugs:
	 * This maybe make slower load page
	 */
	public function getResponsbilityIdBySlug($slug)
	{
		$sql = "SELECT 
							count(sugm.user_group_menu_id) count, 
							sugm.user_group_menu_id
						FROM sys.sys_user_group_menu sugm
							inner join sys.sys_menu_group_list smgl on smgl.group_menu_id = sugm.group_menu_id
							inner join sys.sys_menu sm on sm.menu_id = smgl.menu_id
							inner join sys.sys_user_application sua on sua.user_group_menu_id = sugm.user_group_menu_id
							inner join sys.sys_user su on su.user_id = sua.user_id
						-- where sugm.user_group_menu_id = '2745' -> example of id
						WHERE sm.menu_link like '$slug%' and su.user_name = '$this->user' 
						GROUP BY sugm.user_group_menu_id 
						ORDER BY 1 desc 
						LIMIT 1;";
		$objectOfSlug = $this->db->query($sql)->row();

		// slug is found
		if ($objectOfSlug) return $objectOfSlug->user_group_menu_id;

		// slug not found
		return null;
	}

	public function getUserResponsibility($user_id = FALSE, $responsbility_id = "", $user_application_id = "")
	{
		$and = '';
		$and1 = '';

		if ($responsbility_id != "") {
			$and = "AND sugm.user_group_menu_id = $responsbility_id";
		}

		if ($user_application_id != "") {
			$and1 = "AND sua.user_application_id = $user_application_id";
		}

		$sql = "SELECT 
							su.user_id, 
							sugm.user_group_menu_id, 
							sugm.user_group_menu_name, 
							smod.module_name, 
							smod.module_link, 
							sua.active, 
							sua.user_application_id, 
							sugm.org_id, 
							smod.module_image, 
							sua.lokal, 
							sua.internet,
							sugm.required_javascript
						FROM 
							sys.sys_user su,
							sys.sys_user_application sua,
							sys.sys_user_group_menu sugm,
							sys.sys_module smod
						WHERE 
							su.user_id = sua.user_id AND 
							sua.user_group_menu_id = sugm.user_group_menu_id AND 
							smod.module_id= sugm.module_id AND 
							su.user_id = $user_id
							$and $and1
						ORDER BY sugm.user_group_menu_name;
						";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getUserResponsibilityInternet($user_id = FALSE, $responsbility_id = "", $user_application_id = "")
	{
		$and = '';
		$and1 = '';

		if ($responsbility_id != "") {
			$and = "AND sugm.user_group_menu_id = $responsbility_id";
		}

		if ($user_application_id != "") {
			$and1 = "AND sua.user_application_id = $user_application_id";
		}

		$sql = "SELECT su.user_id,sugm.user_group_menu_id, sugm.user_group_menu_name, 
					smod.module_name,smod.module_link,sua.active,sua.user_application_id,sugm.org_id, smod.module_image,sua.lokal,sua.internet
					FROM sys.sys_user su,
					sys.sys_user_application sua,
					sys.sys_user_group_menu sugm,
					sys.sys_module smod
					WHERE 
					1 = 1
					AND sua.internet=1
					AND su.user_id = sua.user_id
					AND sua.user_group_menu_id = sugm.user_group_menu_id
					AND smod.module_id= sugm.module_id
					AND su.user_id=$user_id
					$and $and1
					order by sugm.user_group_menu_name;
					";

		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getUserReport($report_name = FALSE, $responsbility_id = "", $user_id = "")
	{
		$and = '';
		if ($responsbility_id) {
			$and = "AND sugm.user_group_menu_id = $responsbility_id";
		}

		$sql = "SELECT su.user_id, sugm.user_group_menu_name, sugm.user_group_menu_id,
					sr.report_id,sr.report_name,sr.report_link,sugm.org_id
					FROM sys.sys_user su,
					sys.sys_user_application sua,
					sys.sys_user_group_menu sugm,
					sys.sys_report sr,
					sys.sys_report_group_list srgl
					WHERE 
					1 = 1
					AND su.user_id = sua.user_id
					AND sua.user_group_menu_id = sugm.user_group_menu_id
					AND srgl.report_group_id = sugm.report_group_id
					AND sr.report_id = srgl.report_id
					AND upper(sr.report_name) like '%$report_name%'
					AND su.user_id = $user_id
					$and
					ORDER BY sugm.user_group_menu_name,sr.report_name
					limit 50;
					";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getUserMenu($user_id = FALSE, $user_group_menu_id = "")
	{
		$and = '';
		// menu id by slug
		// : TODO -> fix this, butuh eksperimen lebih mendalam agar tidak menyebabkan aplikasi lain tidak sesuai
		// $user_group_menu_id = $this->getResponsbilityIdBySlug($this->current_slug) ?: $user_group_menu_id;

		if ($user_group_menu_id) {
			$and = "AND sugm.user_group_menu_id = $user_group_menu_id";
		}

		$sql = "SELECT 
							su.user_id, 
							sugm.user_group_menu_name,
							sugm.user_group_menu_id,
							smgl.menu_sequence,
							smgl.group_menu_list_id,
							sm.menu_id,
							smgl.root_id,
							COALESCE(smgl.prompt,sm.menu_title) menu_title,
							COALESCE(sm.menu_title,smgl.prompt) menu,
							sm.menu_link,
							sugm.org_id,
							smgl.menu_level
						FROM sys.sys_user su,
						sys.sys_user_application sua,
						sys.sys_user_group_menu sugm,
						sys.sys_menu sm,
						sys.sys_menu_group_list smgl
						WHERE 
						1 = 1
						AND su.user_id = sua.user_id
						AND sua.user_group_menu_id = sugm.user_group_menu_id
						AND smgl.group_menu_id = sugm.group_menu_id
						AND sm.menu_id = smgl.menu_id
						AND su.user_id=$user_id
						$and
						ORDER BY sugm.user_group_menu_name,smgl.menu_level,smgl.menu_sequence
						";

		$query = $this->db->query($sql)->result_array();

		// set cache
		$this->arrayOfUserMenu = $query;

		// filter menu level = 1
		$query = array_filter($query, function ($item) {
			return $item['menu_level'] == 1;
		});

		return $query;
	}

	public function getMenuLv2($user_id = FALSE, $user_group_menu_id = "")
	{
		// use cache first
		if (count($this->arrayOfUserMenu)) {
			$menu_level_2 = array_filter($this->arrayOfUserMenu, function ($item) {
				return $item['menu_level'] == 2;
			});

			return $menu_level_2;
		}

		$and = '';
		if ($user_group_menu_id != "") {
			$and = "AND sugm.user_group_menu_id = $user_group_menu_id";
		}

		$sql = "SELECT su.user_id, sugm.user_group_menu_name,sugm.user_group_menu_id,smgl.group_menu_list_id,
						smgl.menu_sequence,	sm.menu_id,smgl.root_id,COALESCE(smgl.prompt,sm.menu_title) menu_title,COALESCE(sm.menu_title,smgl.prompt) menu,
						sm.menu_link,sugm.org_id
						FROM sys.sys_user su,
						sys.sys_user_application sua,
						sys.sys_user_group_menu sugm,
						sys.sys_menu sm,
						sys.sys_menu_group_list smgl
						WHERE 
						1 = 1
						AND su.user_id = sua.user_id
						AND sua.user_group_menu_id = sugm.user_group_menu_id
						AND smgl.group_menu_id = sugm.group_menu_id
						AND sm.menu_id = smgl.menu_id
						AND su.user_id=$user_id
						$and
						AND smgl.menu_level = 2
						ORDER BY sugm.user_group_menu_name,smgl.menu_level,smgl.menu_sequence
						";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMenuLv3($user_id = FALSE, $user_group_menu_id = "")
	{
		// use cache first
		if (count($this->arrayOfUserMenu)) {
			$menu_level_3 = array_filter($this->arrayOfUserMenu, function ($item) {
				return $item['menu_level'] == 3;
			});

			return $menu_level_3;
		}

		$and = '';
		if ($user_group_menu_id != "") {
			$and = "AND sugm.user_group_menu_id = $user_group_menu_id";
		}

		$sql = "SELECT su.user_id, sugm.user_group_menu_name,sugm.user_group_menu_id,smgl.menu_sequence,smgl.group_menu_list_id,
						sm.menu_id,smgl.root_id,COALESCE(smgl.prompt,sm.menu_title) menu_title,COALESCE(sm.menu_title,smgl.prompt) menu,sm.menu_link,sugm.org_id
						FROM sys.sys_user su,
						sys.sys_user_application sua,
						sys.sys_user_group_menu sugm,
						sys.sys_menu sm,
						sys.sys_menu_group_list smgl
						WHERE 
						1 = 1
						AND su.user_id = sua.user_id
						AND sua.user_group_menu_id = sugm.user_group_menu_id
						AND smgl.group_menu_id = sugm.group_menu_id
						AND sm.menu_id = smgl.menu_id
						AND su.user_id=$user_id
						$and
						AND smgl.menu_level = 3
						ORDER BY sugm.user_group_menu_name,smgl.menu_level,smgl.menu_sequence
						";

		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
