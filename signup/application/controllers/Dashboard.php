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

class Dashboard extends CI_Controller {

        function __construct()
        {
            parent::__construct();

            

        }


        public function dashboard()
        {       
        }


        function index()
        {
            $baseurl= $this->config->item('base_url'); 
            $data['baseurl']=$baseurl;
            
            $this->load->view('index',$data);
        }

        function UserStatus()
        {
            $baseurl= $this->config->item('base_url'); 
            $data['baseurl']=$baseurl;
            
            $query=$this->User_model->displayrecords();

            $data['EMPLOYEES'] = null;
            if($query){
            $data['EMPLOYEES'] =  $query;
            }
            //$this->load->view('display_records',$result);

            $this->load->view('user_status',$data);
        }
}

?>
    
