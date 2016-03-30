<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
         $this->load->model('home_model');
        $session=  $this->session->all_userdata();
        if($this->input->cookie(LOGIN_STATUS,TRUE)){
            $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_TRUE);            
            $this->session->set_userdata(ADMINISTRATOR_CREDENTIAL_STATUS, ADMINISTRATOR_CREDENTIAL_STATUS_FALSE);            
        }
        else if($this->input->cookie(ADMINISTRATOR_CREDENTIAL_STATUS,TRUE)){
            $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_FLASE);            
            $this->session->set_userdata(ADMINISTRATOR_CREDENTIAL_STATUS, ADMINISTRATOR_CREDENTIAL_STATUS_TRUE);            
        }
        else {
            $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_FLASE);            
            $this->session->set_userdata(ADMINISTRATOR_CREDENTIAL_STATUS, ADMINISTRATOR_CREDENTIAL_STATUS_FALSE);            
        }
        
        
        
//        try {
//            if($session[LOGIN_STATUS] !== LOGIN_STATUS_TRUE){
//                $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_FLASE);            
//            }
//        } catch (Exception $e) {
//            $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_FLASE);            
//        }
        
        

    }

    //***********************************************
    //Main Page of jErrors
    //***********************************************
    public function index() {
        $this->load->view('Home/header');
        $this->load->view('Home/index');
        $this->load->view('Home/footer');
    }
    
    //***********************************************
    //Pricing Page of jErrors
    //***********************************************    
    public function pricing() {
        $this->load->view('Home/header');
        $this->load->view('Home/pricing');
        $this->load->view('Home/footer');
    }
    
    //***********************************************
    //Tour Page of jErrors
    //***********************************************    
    public function tour() {
        $this->load->view('Home/header');
        $this->load->view('Home/tour');
        $this->load->view('Home/footer');      
    }
    
    //***********************************************
    //Features Page of jErrors
    //***********************************************    
    public function features() {
        $this->load->view('Home/header');
        $this->load->view('Home/features');
        $this->load->view('Home/footer');    
    }
    
    //***********************************************
    // Docs Page of jErrors
    //***********************************************    
    public function docs() {
        $this->load->view('Home/header');
        $this->load->view('Home/docs');
        $this->load->view('Home/footer');    
    }
    
    //***********************************************
    //About Page of jErrors
    //***********************************************    
    public function about() {
        $this->load->view('Home/header');
        $this->load->view('Home/about');
        $this->load->view('Home/footer');   
    }
    
    //***********************************************
    //Cotact Page of jErrors
    //***********************************************    
    public function contact() {
        $this->load->view('Home/header');
        $this->load->view('Home/contact');
        $this->load->view('Home/footer');   
    }
    
    //***********************************************
    //Contact Success Page of jErrors
    //***********************************************    
    public function contactSuccess() {
        $this->load->view('Home/header');
        $this->load->view('Home/contactSuccess');
        $this->load->view('Home/footer'); 
    }
    
    //***********************************************
    //Saving Visitor Mail in database
    //***********************************************    
    public function sendMail() {
        $name = $this->input->post("name");
        $subject = $this->input->post('subject');
        $emailFrom = $this->input->post('email');
        $message = $this->input->post('message');
        $date = date("m/d/Y h:i:sa");
        $result = $this->home_model->insertVisitorMail([
                    'Name' => $name,
                    'Subject' => $subject,
                    'from' => $emailFrom,
                    'date' => $date,
                    'message' => $message
                ]);
        redirect('Home/contactSuccess');       
    }
}