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

class Login extends CI_Controller 
{

            function __construct()
        {
            parent::__construct();

            $this->load->model('User_model');
            
        } 

    public function index()
    {
        $baseurl= $this->config->item('base_url'); 
        $data['baseurl']=$baseurl;
        $this->load->view('login',$data);
    }

    public function DoLoginUser()
    {
        
        //$UserName = ""; 
        $Password = "";       
        $PasswordEncrypt="";
              
        $UserID="";
        $MobileNumber="";
        $EmailAddress="";
        $FullName="";
        $Address="";
        // $BankName="";
        // $BankHolderName="";
        // $AccountType="";
        // $AccountNumber="";
        // $IFSCCode="";
        $ProfilePicturePath="";


        $ServiceStatus = 0;        
        $ReturnMessage = "";        

        $postdata = file_get_contents("php://input");

        if (isset($postdata))
        {
            $request = json_decode($postdata);
        
            if(empty($request))
            {
                $DeviceType = "Web";    
                
                $MobileNumber =  !empty($this->input->post('MobileNumber'))?$this->input->post('MobileNumber'):"";
                $Password =  !empty($this->input->post('Password'))?$this->input->post('Password'):"";
            
            }
            else
            {
                
                $MobileNumber =  isset($request->MobileNumber)?$request->MobileNumber:"";
                $Password =  isset($request->Password)?$request->Password:"";
                
            }

            $PasswordEncrypt=md5($Password);

            if(empty($MobileNumber)||empty($Password))
            {
                $ServiceStatus=0;
                $ReturnMessage="Mobile Number or Password Blank";
            }
            else
            {
                //echo $MobileNumber;
                //echo $PasswordEncrypt;
                $params=array('Mobile_Number'=>$MobileNumber,'Password'=>$PasswordEncrypt,'IsActive'=>1,'IsDeleted'=>0);
                $userProfile=$this->User_model->get_login_user_info_by_field($params);   
                //$userProfile=$this->User_model->can_login($UserName,$PasswordEncrypt);
                if($userProfile)
                {

                    //echo $userProfile[0]['Profile_Picture_Path'];
                    $UserID=$userProfile[0]['PK_UserID'];
                    //$UserName=$userProfile[0]['Username'];
                    $MobileNumber=$userProfile[0]['Mobile_Number'];
                    $EmailAddress=$userProfile[0]['Email_Address'];
                    $FullName=$userProfile[0]['Full_Name'];
                    $Address=$userProfile[0]['Address'];
                    // $BankName=$userProfile[0]['Bank_Name'];
                    // $BankHolderName=$userProfile[0]['Bank_Holder_Name'];
                    // $AccountType=$userProfile[0]['Account_Type'];
                    // $AccountNumber=$userProfile[0]['Account_Number'];
                    // $IFSCCode=$userProfile[0]['IFSC_Code'];
                    $ProfilePicturePath=$userProfile[0]['Profile_Picture_Path'];
                    //alert($userProfile);
                    $ServiceStatus=1;
                    $ReturnMessage="Successfully login";
                    
                }
                else
                {
                    //alert("login Faild");
                    $ServiceStatus=0;
                    $ReturnMessage="Invalied Mobile Number or Password";
                }
            }
            //echo $ReturnMessage;

            $json = array();
            $jsonarray = array(
                'ServiceStatus'=>$ServiceStatus,
                'ReturnMessage'=>$ReturnMessage, 
                'UserID'=>$UserID,
                //'UserName'=>$UserName,
                'MobileNo'=>$MobileNumber,
                'EmailAddress'=>$EmailAddress,
                'FullName'=>$FullName,
                'Address'=>$Address,
                // 'BankName'=>$BankName,
                // 'BankHolderName'=>$BankHolderName,
                // 'AccountType'=>$AccountType,
                // 'AccountNumber'=>$AccountNumber,
                // 'IFSCCode'=>$IFSCCode,
                'ProfilePicturePath'=>$ProfilePicturePath                   
                );

            array_push($json, $jsonarray);   
            $jsonstring = json_encode($json);
            echo $jsonstring;
            die();

        }
        
    }

    public function DoLoginAdmin()
    {
        $UserName = ""; 
        $Password = "";       
        $PasswordEncrypt="";
              

        $ServiceStatus = 0;
        
        $ReturnMessage = "";        

        $postdata = file_get_contents("php://input");

        if (isset($postdata))
        {
            $request = json_decode($postdata);
        
            if(empty($request))
            {
                $DeviceType = "Web";    
                
                $UserName =  !empty($this->input->post('UserName'))?$this->input->post('UserName'):"";
                $Password =  !empty($this->input->post('Password'))?$this->input->post('Password'):"";
            
            }
            else
            {
                
                $UserName =  isset($request->UserName)?$request->UserName:"";
                $Password =  isset($request->Password)?$request->Password:"";
                
            }

            $PasswordEncrypt=md5($Password);

            if(empty($UserName)||empty($Password))
            {
                $ServiceStatus=0;
                $ReturnMessage="UserName or Password Blank";
            }
            else
            {
                $userProfile=$this->User_model->can_Adminlogin($UserName,$PasswordEncrypt);
                if($userProfile)
                {
                    //alert("Successfully login");
                    $ServiceStatus=1;
                    $ReturnMessage="Successfully login";
                    redirect('Dashboard', 'refresh');
                }
                else
                {
                    
                    $ServiceStatus=0;
                    $ReturnMessage="Invalied Username or Password";
                    
                    ?>
                    <script type="text/javascript">
                    alert("Invalied Username or Password");
                    </script>
                    <?php
                    redirect('loginPage', 'refresh');
                 //alert("Invalied Username or Password");
                }
            }
            //echo $ReturnMessage;

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

    public function show_sign_up()
    {
        $baseurl= $this->config->item('base_url'); 
        $data['baseurl']=$baseurl;
        $this->load->view('register',$data);
    }

    public function Signup()
    {
        $FullName = "";
        $Password = "";
        $MobileNo = "";
        $EmailID = "";

        $ServiceStatus = 0;    
        $ReturnMessage = "";
        $UserID=0;

        $postdata = file_get_contents("php://input");
        if (isset($postdata))
        {
            $request = json_decode($postdata);

            if(empty($request))
            {           
            
                $FullName = $_POST['FullName']= !empty($this->input->post('fullname'))?$this->input->post('fullname'):"";
                $Password = $_POST['Password'] =  !empty($this->input->post('password'))?$this->input->post('password'):"";
            
                $MobileNo =$_POST['MobileNo'] =  !empty($this->input->post('mobileno'))?trim($this->input->post('mobileno')):""; 
                $EmailID =$_POST['EmailID'] =  !empty($this->input->post('email'))?$this->input->post('email'):""; 
            
            }
            else
            {
            
                $FullName=$_POST['FullName'] =  isset($request->FullName)?$request->FullName:"";
                $Password=$_POST['Password'] =  isset($request->Password)?$request->Password:"";
                $MobileNo=$_POST['MobileNo'] =  isset($request->MobileNo)?trim($request->MobileNo):"";
                $EmailID=$_POST['EmailID'] =  isset($request->EmailID)?$request->EmailID:"";    

            }

            $this->load->library('form_validation');

            $this->form_validation->set_rules('MobileNo','Mobile No','required|callback_is_unique|min_length[10]|max_length[10]',

        array(
            'required'      => 'MobileNo Required',
            'is_unique'     => 'MobileNo already exists',
            'min_length'=>'MobileNo min lenth 10',
            'max_length'=>'MobileNo max lenth 10'
            ));

            $this->form_validation->set_rules('FullName','Full Name','required|min_length[4]|max_length[25]',

        array(
            'required'      => 'FullName Required',
            //'is_unique'     => 'Username already exists',
            'min_length'=>'FullName min length 4',
            'max_length'=>'FullName max length 25',
            ));

            $this->form_validation->set_rules('Password','PassWord','required|min_length[8]|max_length[25]',

        array(
            'required'      => 'Password not Required',
            'min_length'=>'Password min lenth 8',
            'max_length'=>'Password max lenth 25'

            ));



            $this->form_validation->set_rules('EmailID','Email ID','valid_email',

           array(

             'valid_email'   => 'invalid email'

             ));


            // if(empty($UserName)||empty($Password))
            // {
            //     $ServiceStatus=0;
            //     $ReturnMessage="UserName or Password Blank";
            // }
            // else
            // {

            $this->form_validation->set_error_delimiters('','');
               if($this->form_validation->run())     
            { 

                $params = array(
                    'CreatedDate' => date('Y-m-d H:i:sP'),
                    'Full_Name' => $FullName,
                    'Password' => md5($Password),   
                    'Mobile_Number' => $MobileNo,
                    'Email_Address' => $EmailID,        

                );

                $UserID= $this->User_model->add_tbl_user_information($params);   

                $ServiceStatus=1;
                $ReturnMessage="Successfully Register";

            //}
            }
            else
            {         
                $ServiceStatus=0;
                $ReturnMessage = validation_errors();

            }
                   
            $json = array();
            $jsonarray = array(
                        'UserID'=>$UserID,                        
                        'FullName'=>$FullName,
                        'MobileNo'=>$MobileNo,
                        'EmailID'=>$EmailID,                        
                        'ServiceStatus'=>$ServiceStatus,                       
                        'ReturnMessage'=>$ReturnMessage,                        
                        );
            array_push($json, $jsonarray);   
            $jsonstring = json_encode($json);
            echo $jsonstring;
            die();
        }

    }

    function is_unique($mobileno)
    {
        //echo $mobileno;
    $this->db->select('Mobile_Number');
    $this->db->from('tbl_user_information');
    $this->db->where('IsDeleted',0);
    $this->db->where('Mobile_Number',$mobileno);
    $data=$this->db->get();
    
    $result=$data->row();
    //print_r($result);
    $MobileNo1="";
    if(isset($result->Mobile_Number))
        $MobileNo1=$result->Mobile_Number;
    if(empty($MobileNo1))return true;
    else return false;
    }

}
