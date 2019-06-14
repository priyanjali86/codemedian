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

	public function DoLoginAdmin()
	{
		
        $UserName = ""; 
        $Password = "";
        
        $MobileNo = "";
        $EmailID = "";
        $UserID = "";
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
				$userProfile=$this->User_model->can_login($UserName,$PasswordEncrypt);
				if($userProfile)
				{
					//alert("Successfully login");
					$ServiceStatus=1;
    				$ReturnMessage="Successfully login";
				}
				else
				{
					//alert("login Faild");
					$ServiceStatus=0;
    				$ReturnMessage="Invalied Username or Password";
				}
			}
			echo $ReturnMessage;

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
        $UserName = "";
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
            
                $UserName = $_POST['UserName']= !empty($this->input->post('username'))?$this->input->post('username'):"";
                $Password = $_POST['Password'] =  !empty($this->input->post('password'))?$this->input->post('password'):"";
            
                $MobileNo =$_POST['MobileNo'] =  !empty($this->input->post('mobileno'))?trim($this->input->post('mobileno')):""; 
                $EmailID =$_POST['EmailID'] =  !empty($this->input->post('email'))?$this->input->post('email'):""; 
            
            }
            else
            {
            
                $UserName=$_POST['UserName'] =  isset($request->UserName)?$request->UserName:"";
                $Password=$_POST['Password'] =  isset($request->Password)?$request->Password:"";
                $MobileNo=$_POST['MobileNo'] =  isset($request->MobileNo)?trim($request->MobileNo):"";
                $EmailID=$_POST['EmailID'] =  isset($request->EmailID)?$request->EmailID:"";    

            }

            $this->load->library('form_validation');

            $this->form_validation->set_rules('UserName','User Name','required|callback_is_unique|min_length[4]|max_length[25]',

        array(
            'required'      => 'UserName Required',
            'is_unique'     => 'Username already exists',
            'min_length'=>'Username min length 4',
            'max_length'=>'Username max length 25',
            ));

            $this->form_validation->set_rules('Password','PassWord','required|min_length[8]|max_length[25]',

        array(
            'required'      => 'Password not Required',
            'min_length'=>'Password min lenth 8',
            'max_length'=>'Password max lenth 25'

            ));

            $this->form_validation->set_rules('MobileNo','Mobile No','required|min_length[10]|max_length[10]',

        array(
            'required'      => 'MobileNo Required',
            'min_length'=>'MobileNo min lenth 8',
            'max_length'=>'MobileNo max lenth 25'
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

            $this->form_validation->set_error_delimiters('<p>','</p>');
               if($this->form_validation->run())     
            { 

                $params = array(
                    'CreatedDate' => date('Y-m-d H:i:sP'),
                    'Username' => $UserName,
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
                        'UserName'=>$UserName,
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

    function is_unique($username)
    {
    $this->db->select('Username');
    $this->db->from('tbl_user_information');
    $this->db->where('IsDeleted',0);
    $this->db->where('Username',$username);
    $data=$this->db->get();
    $result=$data->row();
    $Username1="";
    if(isset($result->Username))
        $Username1=$result->Username;
    if(empty($Username1))return true;
    else return false;
    }

}
