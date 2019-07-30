<?php

 
class Bank_Details_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }   
   
    
    function update_tbl_user_bank_details($BankID,$params)
    {
        $this->db->where('PK_User_Bank_DetailsID',$BankID);
        return $this->db->update('tbl_user_bank_details',$params);
    }

    function add_tbl_user_bank_details($params)
    {
        $this->db->insert('tbl_user_bank_details',$params);
        return $this->db->insert_id();
    }

    function get_all_tbl_user_bank_details_by_field($fieldarray)
    {
    return $this->db->get_where('tbl_user_bank_details',$fieldarray)->result_array();
    }

}
