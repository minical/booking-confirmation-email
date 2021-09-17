<?php

class Company_model extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function get_company($company_id, $filter = null)
	{
        if(isset($filter['get_last_action']) && $filter['get_last_action'])
        {
            $this->db->select('(DATEDIFF(NOW(), IF(la.last_action IS NULL, capi.creation_date, la.last_action))) as idle',FALSE);
            $this->db->join("(SELECT
                            b.company_id,
                            MAX(bl.date_time) as last_action
                        FROM
                            booking as b, booking_log as bl
                        WHERE
                            b.booking_id = bl.booking_id
                        GROUP BY b.company_id) as la "
                        , "la.company_id = c.company_id", "left");
        }
		$this->db->select('c.*, capi.*, up.*, cs.subscription_level, cs.limit_feature, cs.subscription_state, cs.payment_method, cs.subscription_id, cs.balance, u.email as owner_email, p.*, count(DISTINCT r.room_id) as number_of_rooms_actual,c.partner_id,IFNULL(wp.username,"Minical") as partner_name, cpg.selected_payment_gateway',FALSE);
		$this->db->from('company as c');
		$this->db->join('company_admin_panel_info as capi', 'c.company_id = capi.company_id', 'left');
		$this->db->join('company_subscription as cs', 'c.company_id = cs.company_id', 'left');
        $this->db->join('company_payment_gateway as cpg', 'cpg.company_id = c.company_id', 'left');
		$this->db->join('user_permissions as up', "c.company_id = up.company_id and up.permission = 'is_owner'", 'left');
		$this->db->join('room as r', "r.company_id = c.company_id AND r.is_deleted != 1", 'left');
		$this->db->join('users as u', "up.user_id = u.id", 'left');
		$this->db->join('whitelabel_partner wp',"c.partner_id = wp.id",'left');
		$this->db->join('user_profiles as p', 'up.user_id = p.user_id', 'left');
        $this->db->where('c.company_id', $company_id);
		$query = $this->db->get();

		if ($query->num_rows >= 1)
		{
			$result = $query->result_array();
			$result[0]['company_id'] = $company_id;
			return $result[0];
		}

		return NULL;
	}

    
	function update_company($company_id, $data)
	{
		$data = (object) $data;
		$this->db->where('company_id', $company_id);
		$this->db->update("company", $data);
	}
} 