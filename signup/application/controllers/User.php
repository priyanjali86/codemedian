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
          $this->load->model('Bank_Details_model');
          

        } 


  public function index()
  {
    $baseurl= $this->config->item('base_url');   
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

  function UserProfileSave()
  {
      $UserID=0;
      $Mobile_Number="";
      $Email_Address="";
      $Full_Name="";
      $Address="";            

      $PictureFileBase64="";
      $FileName="";
      $IsUpdatePicture="";
      
      $ServiceStatus = 0;
      $ReturnMessage = "";

      $postdata = file_get_contents("php://input");
      if (isset($postdata))
      {
        $request = json_decode($postdata);


        $UserID=$_POST['FK_User_ID'] =  isset($request->UserID)?$request->UserID:"";
        $Mobile_Number=$_POST['Mobile_Number'] =  isset($request->MobileNumber)?$request->MobileNumber:"";
        $Email_Address=$_POST['Email_Address'] =  isset($request->EmailAddress)?$request->EmailAddress:"";
        $Full_Name=$_POST['Full_Name'] =  isset($request->FullName)?$request->FullName:"";            
        $Address=$_POST['Address'] =  isset($request->Address)?$request->Address:"";
        // $Bank_Name=$_POST['Bank_Name'] =  isset($request->BankName)?trim($request->BankName):"";
        // $Bank_Holder_Name=$_POST['Bank_Holder_Name'] =  isset($request->BankHolderName)?trim($request->BankHolderName):"";
        // $Account_Type=$_POST['Account_Type'] =  !empty($request->AccountType)?$request->AccountType:"";           
        // $Account_Number=$_POST['Account_Number'] =  !empty($request->AccountNumber)?$request->AccountNumber:"";
        // $IFSC_Code=$_POST['IFSC_Code'] =  !empty($request->IFSCCode)?$request->IFSCCode:"";
        

        $PictureFileBase64=isset($request->PictureFileBase64)?$request->PictureFileBase64:"";
        $FileName=isset($request->FileName)?$request->FileName:"";
        $IsUpdatePicture=isset($request->IsUpdatePicture)?$request->IsUpdatePicture:""; 

        $this->load->library('form_validation');

        $this->form_validation->set_rules('Mobile_Number','Mobile No','required|min_length[10]|max_length[10]',

        array(
            'required'      => 'MobileNo Required',
            'min_length'=>'MobileNo min lenth 10',
            'max_length'=>'MobileNo max lenth 10'
            ));

        $this->form_validation->set_rules('Email_Address','Email ID','valid_email',

           array(

             'valid_email'   => 'invalid email'

             ));

        // $this->form_validation->set_rules('Bank_Name','Bank Name','required',

        // array(
        //     'required'      => 'Bank Name Required'            
        //     ));

        // $this->form_validation->set_rules('Bank_Holder_Name','Bank Holder Name','required',

        // array(
        //     'required'      => 'Bank Holder Name Required'            
        //     ));

        // $this->form_validation->set_rules('Account_Type','Account Type','required',

        // array(
        //     'required'      => 'Account Type Required'            
        //     ));

        // $this->form_validation->set_rules('IFSC_Code','IFSC Code','required',

        // array(
        //     'required'      => 'IFSC Code Required'            
        //     ));

        $this->form_validation->set_error_delimiters('','');
               if($this->form_validation->run())     
            { 

              $fieldarray=array('PK_UserID'=>$UserID);
              $user=$this->User_model->get_all_tbl_user_profile_by_field($fieldarray);

              if(empty($user))
              {
                $ServiceStatus=0;
                $ReturnMessage="user does not exits";
              }
              else
              {
                $ServiceStatus=1;
                $params=array(
                  'FK_ModifyBy' => 1,
                  'ModifyDate' => date('Y-m-d H:i:sP'),
                  'Mobile_Number' => $Mobile_Number,
                  'Email_Address' => $Email_Address,
                  'Full_Name' => $Full_Name,
                  'Address' => $Address,
                  // 'Bank_Name' => $Bank_Name,
                  // 'Bank_Holder_Name' => $Bank_Holder_Name,
                  // 'Account_Type' => $Account_Type,
                  // 'Account_Number' => $Account_Number,
                  // 'IFSC_Code' => $IFSC_Code
                );

                $this->User_model->update_tbl_user_profile($UserID,$params);

                $ReturnMessage="User Profile Update Successfully";

                // $params1=array(
                //   'FK_UserID' => $UserID,                  
                //   'Bank_Name' => $Bank_Name,
                //   'Bank_Holder_Name' => $Bank_Holder_Name,
                //   'Account_Type' => $Account_Type,
                //   'Account_Number' => $Account_Number,
                //   'IFSC_Code' => $IFSC_Code
                // );

                // if(!empty($Bank_Name) || !empty($Bank_Holder_Name) || !empty($Account_Type) || !empty($Account_Number) || !empty($IFSC_Code))
                // {
                //   $fieldarray=array('FK_UserID'=>$UserID, 'Account_Number'=>$Account_Number, 'IFSC_Code'=>$IFSC_Code);
                //   $bank=$this->Bank_Details_model->get_all_tbl_user_bank_details_by_field($fieldarray);
                //   //echo $bank;
                //   if(empty($bank))
                //   {
                //     $this->Bank_Details_model->add_tbl_user_bank_details($params1);
                //     $ReturnMessage="User Profile Update Successfully";
                //   }
                //   else
                //   {
                //     $ReturnMessage="Bank Details Already exist";
                //   }
                // }
                if(!empty($IsUpdatePicture))
                 {
                  $this->update_profile_picture($UserID,$FileName,$PictureFileBase64); 
                }

                
              }


            }
            else
            {
              $ServiceStatus=0;
              $ReturnMessage = validation_errors();
            }

            $json = array();
            $jsonarray = array(
                        'UserID'=>$UserID,                                              
                        'ServiceStatus'=>$ServiceStatus,                       
                        'ReturnMessage'=>$ReturnMessage,                        
                        );
            array_push($json, $jsonarray);   
            $jsonstring = json_encode($json);
            echo $jsonstring;
            die();

      }
  }


       function update_profile_picture($UserID,$FileName,$Base64File)
     {



       $params=array('PK_UserID'=>$UserID,'IsActive'=>1,'IsDeleted'=>0);
       $user=$this->User_model->get_all_tbl_user_profile_by_field($params);         

       $OutputFileName=$UserID.''.$user[0]['Username'];    
       //echo $OutputFileName
       
       $col1=date('YmdHis').''.$OutputFileName;    
       $col2=preg_replace('/\\s/','',$col1);

       $current_date=date(DATE_ATOM, time());
       $current_date_str=explode("-",substr($current_date,0,10));

       $year=$current_date_str[0];
       $month=$current_date_str[1];
       $day=$current_date_str[2];

       $dir = $year;       
       if (!is_dir('./Resources/'.$dir)) 
       {
        mkdir('./Resources/' . $dir, 0777, TRUE);
       }
        $dir = $dir."/".$UserID;
        if (!is_dir('./Resources/'.$dir)) 
        {
          mkdir('./Resources/' . $dir, 0777, TRUE);
        }
        $dir = $dir."/User";
        if (!is_dir('./Resources/'.$dir)) 
        {
          mkdir('./Resources/' . $dir, 0777, TRUE);
        }
        $dir = $dir."/ProfilePic";
        if (!is_dir('./Resources/'.$dir)) 
        {
          mkdir('./Resources/' . $dir, 0777, TRUE);
        }


     if(!empty($Base64File))
     {
      $FileName = "abc.jpg";
      $extension=explode(".",$FileName);
      $file_save_name=$col2.".".$extension[1];  

      $pic=str_replace(" ", "+",$Base64File);
      $output_file="./Resources/".$dir."/".$file_save_name;
      $ifp = fopen( $output_file, 'wb' ); 


      // if($DeviceType == "App")
      // {
       $data = explode( ',', $pic );   
       fwrite( $ifp, base64_decode($data[1]));    
       fclose( $ifp );
    //  }
    //  else
    //  {
    //   $data = explode( ',', $pic );   
    //   fwrite( $ifp, base64_decode($data[0]));    
    //   fclose( $ifp );
    // }
  }
  else
  {
    $output_file="";
  }
  $params=array('Profile_Picture_Path'=>$output_file);
  $this->User_model->update_tbl_user_profile($UserID,$params);
}

function UserFriendList()
{
  $UserID=0;
  $FriendList="";

  $ServiceStatus = 0;
  $ReturnMessage = "";

  $postdata = file_get_contents("php://input");
      if (isset($postdata))
      {
        $request = json_decode($postdata);

        $UserID=$_POST['FK_User_ID'] =  isset($request->UserID)?$request->UserID:"";

        $fieldarray=array('PK_UserID'=>$UserID);
        $user=$this->User_model->get_all_tbl_user_profile_by_field($fieldarray);

        if(empty($user))
        {
          $ServiceStatus=0;
          $ReturnMessage="user does not exits";
        }
        else
        {
          $ServiceStatus=1;
          $ReturnMessage="Show User Friend List";
          //$fieldarray1=array('PK_UserID'=>$UserID);
          $userfriendlist=$this->User_model->get_all_tbl_user_friend_list_by_field($UserID);
          $FriendList=array();

          foreach ($userfriendlist as $row)
          {

              $Friend_UserID=$row['PK_UserID'];
              $Friend_UserName=$row['Username'];
              $Friend_MobileNo=$row['Mobile_Number'];
              $Friend_Email=$row['Email_Address'];
              $Friend_Full_Name=$row['Full_Name'];
              $Friend_Address=$row['Address'];
              $Friend_Profile_Picture=$row['Profile_Picture_Path'];
                $jsonarray = array(
                    'FriendUserID' => $Friend_UserID,
                    'FriendUserName' => $Friend_UserName,
                    'FriendMobileNo' => $Friend_MobileNo,
                    'FriendEmail' => $Friend_Email,
                    'FriendFullName' => $Friend_Full_Name,
                    'FriendAddress' => $Friend_Address,
                    'FriendProfilePicture' => $Friend_Profile_Picture,
                );
              array_push($FriendList, $jsonarray);       
        
          }
          
        }

        $json = array();
      $jsonarray = array( 
        'ServiceStatus'=>$ServiceStatus,
        'ReturnMessage'=>$ReturnMessage,                             
        'UserFriendList'=>$FriendList                   
      );

      array_push($json, $jsonarray);   
      $jsonstring = json_encode($json);
      echo $jsonstring;
      die();

      }

}

function getProfile()
{
      $UserID = "";

      //$Username="";
      $MobileNumber="";
      $EmailAddress=""; 
      $FullName="";
      $Address="";
      $ProfilePicturePath="";

      //$BankDetailsList="";          

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
          $baseurl= $this->config->item('base_url');
          //echo $baseurl;
          $field=array('PK_UserID'=>$UserID);
          $user_profile=$this->User_model->get_all_tbl_user_profile_by_field($field);
          if(!empty($user_profile))
          {
            //$Username=$user_profile[0]['Username'];
            $MobileNumber=$user_profile[0]['Mobile_Number'];
            $EmailAddress=$user_profile[0]['Email_Address'];
            $FullName=$user_profile[0]['Full_Name'];
            $Address=$user_profile[0]['Address'];
            $ProfilePicturePath=$user_profile[0]['Profile_Picture_Path'];
            $ProfilePicturePath=$ProfilePicturePath == "" ? "":$baseurl."".$ProfilePicturePath;


//$baseurl."".
            // $field1=array('FK_UserID'=>$UserID);
            // $query=$this->Bank_Details_model->get_all_tbl_user_bank_details_by_field($field1);
            // $BankDetailsList=array();

            // foreach ($query as $row)
            // {
            //   $Bank_DetailsID=$row['PK_User_Bank_DetailsID'];
            //   $Bank_Name=$row['Bank_Name'];
            //   $Bank_Holder_Name=$row['Bank_Holder_Name'];
            //   $Account_Type=$row['Account_Type'];
            //   $Account_Number=$row['Account_Number'];
            //   $IFSC_Code=$row['Bank_Name'];
            //     $jsonarray = array(
            //         'BankDetailsID' => $Bank_DetailsID,
            //         'BankName' => $Bank_Name,
            //         'BankHolderName' => $Bank_Holder_Name,
            //         'AccountType' => $Account_Type,
            //         'AccountNumber' => $Account_Number,
            //         'IFSCCode' => $IFSC_Code,
            //     );
            //   array_push($BankDetailsList, $jsonarray);  
            // }          

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
        //'UserName'=>$Username,
        'MobileNumber'=>$MobileNumber,
        'EmailAddress'=>$EmailAddress,
        'FullName'=>$FullName,
        'Address'=>$Address,
        'ProfilePicturePath'=>$ProfilePicturePath,
        //'BankDetails'=>$BankDetailsList,
                    
      );

      array_push($json, $jsonarray);   
      $jsonstring = json_encode($json);
      echo $jsonstring;
      die();

    }
}
  
}
