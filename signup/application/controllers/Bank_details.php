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

class Bank_details extends CI_Controller {

	
	function __construct()
        {
          parent::__construct();
          $this->load->model('User_model');
          $this->load->model('Bank_Details_model');
          

        } 


	public function index()
	{
		$this->load->view('welcome_message');
	}

	function getBankDetails()
  {
    $UserID = "";
    $BankID = "";

    $BankDetailsList="";

    $ServiceStatus = 0;
    $ReturnMessage = "";

      $postdata = file_get_contents("php://input");
      if (isset($postdata))
      {
        $request = json_decode($postdata);        
        
        $UserID=$_POST['UserID'] =  isset($request->UserID)?$request->UserID:"";
        $BankID=$_POST['BankID'] =  isset($request->BankID)?$request->BankID:"";

        if(empty($UserID) || empty($BankID))
        {
          $ServiceStatus=0;
          
          $ReturnMessage="Invalid UserId or BankID";
        }
        else
        {
          $field=array('FK_UserID'=>$UserID,'PK_User_Bank_DetailsID'=>$BankID);
          $bank_details=$this->Bank_Details_model->get_all_tbl_user_bank_details_by_field($field);
          if(!empty($bank_details))
          {
            $BankDetailsList=array();

            foreach ($bank_details as $row)
            {
              $Bank_DetailsID=$row['PK_User_Bank_DetailsID'];
              $Bank_Name=$row['Bank_Name'];
              $Bank_Holder_Name=$row['Bank_Holder_Name'];
              $Account_Type=$row['Account_Type'];
              $Account_Number=$row['Account_Number'];
              $IFSC_Code=$row['Bank_Name'];
                $jsonarray = array(
                    'BankDetailsID' => $Bank_DetailsID,
                    'BankName' => $Bank_Name,
                    'BankHolderName' => $Bank_Holder_Name,
                    'AccountType' => $Account_Type,
                    'AccountNumber' => $Account_Number,
                    'IFSCCode' => $IFSC_Code,
                );
              array_push($BankDetailsList, $jsonarray);  
            }

            $ServiceStatus=1;
            $ReturnMessage="Bank Details";        
          }
          else
          {
            $ServiceStatus=0;
            $ReturnMessage="BankID or UserID does not exits";
          }
        }
        $json = array();
      $jsonarray = array( 
        'ServiceStatus'=>$ServiceStatus,
        'ReturnMessage'=>$ReturnMessage,           
        
        'BankDetails'=>$BankDetailsList,
                    
      );

      array_push($json, $jsonarray);   
      $jsonstring = json_encode($json);
      echo $jsonstring;
      die();
      }
  }

  function postBankDetails()
  {
    $UserID = "";
    $BankID = "";

    $Bank_Name = "";
    $Bank_Holder_Name ="";
    $Account_Type="";
    $Account_Number="";
    $IFSC_Code="";

    $ServiceStatus = 0;
    $ReturnMessage = "";

    $postdata = file_get_contents("php://input");
      if (isset($postdata))
      {
        $request = json_decode($postdata);

        $UserID=$_POST['UserID'] =  isset($request->UserID)?$request->UserID:"";
        $BankID=$_POST['BankID'] =  isset($request->BankID)?$request->BankID:"";

        $Bank_Name=$_POST['Bank_Name'] =  isset($request->BankName)?trim($request->BankName):"";
        $Bank_Holder_Name=$_POST['Bank_Holder_Name'] =  isset($request->BankHolderName)?trim($request->BankHolderName):"";
        $Account_Type=$_POST['Account_Type'] =  !empty($request->AccountType)?$request->AccountType:"";         
        $Account_Number=$_POST['Account_Number'] =  !empty($request->AccountNumber)?$request->AccountNumber:"";
        $IFSC_Code=$_POST['IFSC_Code'] =  !empty($request->IFSCCode)?$request->IFSCCode:"";

        if(empty($BankID))//add
        {
          $field=array('PK_UserID'=>$UserID);
          $user_profile=$this->User_model->get_all_tbl_user_profile_by_field($field);
          if(empty($user_profile))
          {

            $ServiceStatus=0;
            $ReturnMessage="user profile does not exist";
          }
          else
          {
                $ServiceStatus=1;
                $params=array(
                  'FK_UserID' => $UserID,                  
                  'Bank_Name' => $Bank_Name,
                  'Bank_Holder_Name' => $Bank_Holder_Name,
                  'Account_Type' => $Account_Type,
                  'Account_Number' => $Account_Number,
                  'IFSC_Code' => $IFSC_Code
                );

                if(!empty($Bank_Name) && !empty($Bank_Holder_Name) && !empty($Account_Type) && !empty($Account_Number) && !empty($IFSC_Code))
                {
                  $fieldarray=array('FK_UserID'=>$UserID, 'Account_Number'=>$Account_Number, 'IFSC_Code'=>$IFSC_Code);
                  $bank=$this->Bank_Details_model->get_all_tbl_user_bank_details_by_field($fieldarray);
                  //echo $bank;
                  if(empty($bank))
                  {
                    $this->Bank_Details_model->add_tbl_user_bank_details($params);
                    $ReturnMessage="Bank Details Add Successfully";
                  }
                  else
                  {
                    $ReturnMessage="Bank Details Already exist";
                  }
                }
          }   
        }
        else //update
        {
          $field=array('FK_UserID'=>$UserID,'PK_User_Bank_DetailsID'=>$BankID);
          $bank_details=$this->Bank_Details_model->get_all_tbl_user_bank_details_by_field($field);
          if(!empty($bank_details))
          {
            $params=array(                                   
                  'Bank_Name' => $Bank_Name,
                  'Bank_Holder_Name' => $Bank_Holder_Name,
                  'Account_Type' => $Account_Type,
                  'Account_Number' => $Account_Number,
                  'IFSC_Code' => $IFSC_Code
                );
            $this->Bank_Details_model->update_tbl_user_bank_details($BankID,$params);
            $ServiceStatus=1;
            $ReturnMessage="Bank Details Update Successfully";
          }
          else
          {
            $ServiceStatus=0;
            $ReturnMessage="BankID or UserID does not exits";
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
	
}
