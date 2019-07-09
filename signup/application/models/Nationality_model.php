<?php

 
class Nationality_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get tbl_gw_master_milestone by PK_MilestoneID
     */
    function get_nationality($PK_NationalityID)
    {
        return $this->db->get_where('nationality',array('PK_NationalityID'=>$PK_NationalityID))->row_array();
    }


    function get_all_nationality_by_field($fieldarray)
    {
    return $this->db->get_where('nationality',$fieldarray)->result_array();
    }
        
    /*
     * Get all tbl_gw_master_milestone
     */
    function get_all_nationality()
    {
        $this->db->order_by('PK_NationalityID', 'desc');
        return $this->db->get('nationality')->result_array();
    }
        
    /*
     * function to add new tbl_gw_master_milestone
     */
    function add_nationality($params)
    {
        $this->db->insert('nationality',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update tbl_gw_master_milestone
     */
    function update_nationality($PK_NationalityID,$params)
    {
        $this->db->where('PK_NationalityID',$PK_NationalityID);
        return $this->db->update('nationality',$params);
    }
    
    /*
     * function to delete tbl_gw_master_milestone
     */
    function delete_nationality($PK_NationalityID)
    {
        return $this->db->delete('nationality',array('PK_NationalityID'=>$PK_NationalityID));
    }
}
