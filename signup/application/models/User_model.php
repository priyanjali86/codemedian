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



    

    // function can_login($username,$password)

    // {

    //     $this->db->where('Username',$username);

    //     $this->db->where('Password',$password);

    //     $this->db->where('IsActive', 1);

    //     $this->db->where('IsDeleted', 0);



    //     $query=$this->db->get('tbl_user_information');



    //     if($query->num_rows() > 0)

    //     {

    //         return true;

    //     }

    //     else

    //     {

    //         return false;

    //     }

    // }



    function can_Adminlogin($username,$password)

    {

        $this->db->where('UserName',$username);

        $this->db->where('Password',$password);



        $query=$this->db->get('tbl_admin');



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

function add_tbl_chat_history($params)

    {

        $this->db->insert('tbl_chat_history',$params);

        return $this->db->insert_id();

    }

    function displayrecords()

    {

        $this->db->select("Username,IsActive,Email_Address");

        $this->db->from('tbl_user_information');

        $query = $this->db->get();

        return $query->result();

    }



    function get_all_tbl_user_profile_by_field($fieldarray)

    {

    return $this->db->get_where('tbl_user_information',$fieldarray)->result_array();

    }

 function get_all_chat_data_by_id($fieldarray1,$fieldarray2)

    {

$sql="SELECT * FROM `tbl_chat_history`  WHERE `user_id`= $fieldarray1 and `friend_id` = $fieldarray2 OR `user_id`= $fieldarray2 and `friend_id` = $fieldarray1 ORDER BY `id` ASC";

   return $this->db->query($sql)->result_array();


    }


    function update_tbl_user_profile($PK_UserID,$params)

    {

        $this->db->where('PK_UserID',$PK_UserID);

        return $this->db->update('tbl_user_information',$params);

    }



    /*

     * function to login user start

     */



    function get_login_user_info_by_field($fieldarray)

    {

    return $this->db->get_where('tbl_user_information',$fieldarray)->result_array();

    }



    /*

     * function to login user end

     */



    function get_all_tbl_user_friend_list_by_field($fieldarray)

    {

    
   //$sql="SELECT * FROM `tbl_user_information` INNER JOIN `tbl_confirm_friend_list` ON `tbl_user_information`.`PK_UserID` = `tbl_confirm_friend_list`.`FriendUserID` WHERE `tbl_confirm_friend_list`.`FK_UserID`= $fieldarray  and `tbl_confirm_friend_list`.`Status` = 'confirm'";
   $sql="SELECT * FROM `tbl_user_information` INNER JOIN `tbl_confirm_friend_list` ON `tbl_user_information`.`PK_UserID` = `tbl_confirm_friend_list`.`FriendUserID` OR `tbl_user_information`.`PK_UserID` = `tbl_confirm_friend_list`.`FK_UserID` WHERE (`tbl_confirm_friend_list`.`FK_UserID`= $fieldarray OR `tbl_confirm_friend_list`.`FriendUserID`= $fieldarray)  and `tbl_confirm_friend_list`.`Status` = 'confirm' and `tbl_user_information`.`PK_UserID` != $fieldarray";
        return $this->db->query($sql)->result_array();



    }



}

