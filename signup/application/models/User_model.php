<?php

 
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get tbl_gw_master_milestone by PK_MilestoneID
     */
    function get_user($PK_UserID)
    {
        return $this->db->get_where('usersdata',array('PK_UserID'=>$PK_UserID))->row_array();
    }


    function get_all_user_by_field($fieldarray)
    {
    return $this->db->get_where('usersdata',$fieldarray)->result_array();
    }
        
    /*
     * Get all tbl_gw_master_milestone
     */
    function get_all_user()
    {
        $this->db->order_by('PK_UserID', 'desc');
        return $this->db->get('usersdata')->result_array();
    }
        
    /*
     * function to add new tbl_gw_master_milestone
     */
    function add_user($params)
    {
        $this->db->insert('usersdata',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update tbl_gw_master_milestone
     */
    function update_user($PK_UserID,$params)
    {
        $this->db->where('PK_UserID',$PK_UserID);
        return $this->db->update('usersdata',$params);
    }
    
    /*
     * function to delete tbl_gw_master_milestone
     */
    function delete_user($PK_UserID)
    {
        return $this->db->delete('usersdata',array('PK_UserID'=>$PK_UserID));
    }

    /*
     * function to login user
     */
    function can_login($username,$password)
    {
        $this->db->where('Username',$username);
        $this->db->where('Password',$password);

        $query=$this->db->get('tbl_user_information');

        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function add_tbl_user_information($params)
    {
        $this->db->insert('tbl_user_information',$params);
        return $this->db->insert_id();
    }

}
