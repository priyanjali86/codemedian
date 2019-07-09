<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }

    // Access-Control headers are received during OPTIONS requests
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
          header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
      }

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	
	function __construct()
        {
          parent::__construct();
          $this->load->model('User_model');
          

        } 


	public function index()
	{
		$this->load->view('welcome_message');
	}

	function PostUserData()
	{
		

      $UserID=0;

      $Name="";
      $Mobile="";
      $Email="";
      $DOB="";
      $Nationality="";      

      $ServiceStatus = 0;
      $ReturnMessage = "";

      $postdata = file_get_contents("php://input");
      if (isset($postdata))
      {
        $request = json_decode($postdata);

          $UserID=$_POST['User_ID'] =  isset($request->UserID)?$request->UserID:"";

          $Name=$_POST['Name'] =  isset($request->Name)?$request->Name:"";
          $Mobile=$_POST['Mobile'] =  isset($request->Mobile)?$request->Mobile:"";
          $Email=$_POST['Email'] =  isset($request->Email)?$request->Email:"";
          $DOB=$_POST['DOB'] =  isset($request->DOB)?$request->DOB:"";
          $Nationality=$_POST['Nationality'] =  isset($request->Nationality)?$request->Nationality:"";


            if(empty($UserID))//add
            {   
              	$params=array(
                    'IsActive' => 1,
                    'IsDeleted' => 0,
                    'Name' => $Name,
                    'Mobile' => $Mobile,
                    'Email' => $Email,
                    'DOB' => $DOB,  
                    'Nationality' => $Nationality,
                            );
                $this->User_model->add_user($params);                

                 $ServiceStatus=1;
                 $ReturnMessage="User Profile Created";
               
             }
             else//update
             {
                
               $field=array('PK_UserID'=>$UserID);
               $user_profile=$this->User_model->get_all_user_by_field($field);
               if(empty($user_profile))
               {

                 $ServiceStatus=0;
                 $ReturnMessage="user profile does not exist";
               }
               else
               {               
                
                	$params=array(
                    'IsActive' => 1,
                    'IsDeleted' => 0,
                    'Name' => $Name,
                    'Mobile' => $Mobile,
                    'Email' => $Email,
                    'DOB' => $DOB,  
                    'Nationality' => $Nationality,
                            );
                $this->User_model->update_user($UserID,$params);
                
                //$this->edit_and_update($ClientID);
                
                $ServiceStatus=1;
                $ReturnMessage="user profile updated";
               }
             }

          

            $json = array();
            $jsonarray = array(
                                 
              'ServiceStatus'=>$ServiceStatus,
              'ReturnMessage'=>$ReturnMessage,
            );

            array_push($json, $jsonarray);   
            $jsonstring = json_encode($json);
            echo $jsonstring;
            die();
          
        }
		
	}

	function GetUserData()
	{


      $UserID = "";
      $Name="";
      $Mobile="";
      $Email="";
      $DOB="";
      $Nationality="";      

      $ServiceStatus = 0;
      $ReturnMessage = "";

      $postdata = file_get_contents("php://input");
      if (isset($postdata))
      {
        $request = json_decode($postdata);

        
        
        $UserID=$_POST['UserID'] =  isset($request->UserID)?$request->UserID:"";

        if(empty($UserID))
        {
          $ServiceStatus=0;
          
          $ReturnMessage="Invalid User";
        }
        else
        {
          $field=array('PK_UserID'=>$UserID);
          $user_profile=$this->User_model->get_all_user_by_field($field);
          if(!empty($user_profile))
          {
            $Name=$user_profile[0]['Name'];
            $Mobile=$user_profile[0]['Mobile'];
            $Email=$user_profile[0]['Email'];
            $DOB=$user_profile[0]['DOB'];
            $Nationality=$user_profile[0]['Nationality'];           

          $ServiceStatus=1;
          $ReturnMessage="User Profile";
          //$ReturnMessage="Worker Licence Details";
          }
          else
          {
            $ReturnMessage="user profile does not exits"; 
          }

        }

      $json = array();
      $jsonarray = array( 
      	'ServiceStatus'=>$ServiceStatus,
        'ReturnMessage'=>$ReturnMessage,                             
        'Name'=>$Name,
        'Mobile'=>$Mobile,
        'Email'=>$Email,
        'DOB'=>$DOB,
        'Nationality'=>$Nationality,
                    
      );

      array_push($json, $jsonarray);   
      $jsonstring = json_encode($json);
      echo $jsonstring;
      die();

    }
  }
	
}
