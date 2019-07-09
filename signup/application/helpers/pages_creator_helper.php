<?php

  function create_new_page($page_name, $class_name, $controller_name){

  // Create Controller
  $controller = fopen(APPPATH.'controllers/'.$controller_name.'.php', "a")
  or die("Unable to open file!");

  $controller_content ="<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class $class_name extends MY_Controller  {

  public function __construct()
  {
    parent::__construct();

   }
  public function index()
   {
    \$this->data['site_title'] = '$page_name';
    \$this->twig->display('$page_name',\$this->data);

   }

   }";
  fwrite($controller, "\n". $controller_content);
  fclose($controller);

  // Create Model
  $model = fopen(APPPATH.'models/'.$class_name.'_model'.'.php', "a") 
  or die("Unable to open file!");

   $model_content ="<?php if ( ! defined('BASEPATH')) exit('No direct script 
   access allowed');

   class ".$class_name."_model"." extends CI_Model
  {
  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }

  }
  ";
  fwrite($model, "\n". $model_content);
  fclose($model);

  // Create Twig Page

  $page = fopen(APPPATH.'views/'.$page_name.'.php', "a") or die("Unable to    
  open file!"); 

  $page_content ='{% extends "base.twig" %}
  {% block content %}

  <div class="row">
    <div class="col-md-12">
        <h1>TO DO {{ site_title }}</h1>

    </div>
    <!-- /.col -->
  </div>

   {% endblock %}';
  fwrite($page, "\n". $page_content);
  fclose($page);
   }
   ?>