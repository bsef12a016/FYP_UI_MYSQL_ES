<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->ci = & get_instance();
        $this->load->model('user_model');
        $this->load->model('login_model');
    }

    //*********************************
    //***********************************************
    //Login Page of jErrors
    //***********************************************    
    public function login() {
        $this->session->set_userdata(SIGNIN_ERROR, "");
        $this->load->view('User/login');
    }

    //***********************************************
    //Signup Page of jErrors
    //***********************************************    
    public function signup() {
        $this->load->view('User/signup');
    }

    //***********************************************
    //Beta Version, Signup Invitation Page of jErrors
    //***********************************************    
    public function comming_soon() {
        $this->load->view('User/comming_soon');
    }

    //***********************************************
    //Checking whether login request is valid or not    
    //***********************************************    
    public function usr_login() {
        $userName = $this->input->post('u_name');
        $password = $this->input->post('password');
        $user_info = array(
            'username' => $userName,
            'password' => $password,
        );
        $result = $this->user_model->login_user(json_encode($user_info));
        if ($result == "INVALID") {
            $this->session->set_userdata(SIGNIN_ERROR, SIGNIN_ERROR);
            $this->load->view('User/login');
        } else {
            $this->session->set_userdata([USER_NAME => $userName]);
            $this->session->set_userdata([USER_ID => $result]);
            $this->session->set_userdata([USER_DATA_SOURCE => MYSQL_DATA_SOURCE]);

//                $loginDate = date("Y-m-d h:i:sa");
//                $ip = $this->getIP();
            //***********************************************
            //Checking whethr login request is come from
            //client or administrator    
            //***********************************************    
            if ($userName == ADMINISTRATOR_CREDENTIAL_NAME) {
                $this->session->set_userdata(ADMINISTRATOR_CREDENTIAL_STATUS, ADMINISTRATOR_CREDENTIAL_STATUS_TRUE);
                $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_FLASE);
                //COOKIE
                $cookie_user = array(
                    'name' => LOGIN_STATUS,
                    'value' => LOGIN_STATUS_FLASE,
                    'expire' => '7200',
                );
                $this->input->set_cookie($cookie_user);
                $cookie_admin = array(
                    'name' => ADMINISTRATOR_CREDENTIAL_STATUS,
                    'value' => ADMINISTRATOR_CREDENTIAL_STATUS_TRUE,
                    'expire' => '7200',
                );
                $this->input->set_cookie($cookie_admin);

                //***********************************************
                //Redirecting to Admindashboard Page 
                //***********************************************    

                redirect('AdminDashboard/adminDashboard');
            } else {
                //LATER
//                    $this->user_model->setStatus(['ip' => $ip,
//                        'lastLogin' => $loginDate,
//                        'status' => 1]);
                $this->session->set_userdata(ADMINISTRATOR_CREDENTIAL_STATUS, ADMINISTRATOR_CREDENTIAL_STATUS_FALSE);
                $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_TRUE);
                //COOKIE
                $cookie_user = array(
                    'name' => LOGIN_STATUS,
                    'value' => LOGIN_STATUS_TRUE,
                    'expire' => '7200',
                );
                $this->input->set_cookie($cookie_user);
                $cookie_admin = array(
                    'name' => ADMINISTRATOR_CREDENTIAL_STATUS,
                    'value' => ADMINISTRATOR_CREDENTIAL_STATUS_FALSE,
                    'expire' => '7200',
                );
                $this->input->set_cookie($cookie_admin);

                //***********************************************
                //Redirecting to Client Dashboard Page 
                //***********************************************    
                redirect('Dashboard/projects');
            }
        }
    }

    //***********************************************
    //Signing Up the new user //DONE_REST_API
    //***********************************************    
    public function user_signup() {

        $id = md5(uniqid('', TRUE));
        $fname = $this->input->post('firstname');
        $lname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $userName = $this->input->post('u_name');
        $password = $this->input->post('password');
        $lastIP = $this->ci->input->ip_address();
        $created = date('Y-m-d H:i:s');
        $last_login = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

        $user_info = array(
            'id' => $id,
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => $email,
            'username' => $userName,
            'password' => $password,
            'last_ip' => $lastIP,
            'created' => $created,
            'last_login' => $last_login,
            'modified' => $modified
        );
        json_encode($user_info);
        $result = $this->user_model->register_user(json_encode($user_info));
        if ($result == PROCEED) {
            //COOKIE
            $cookie = array(
                'name' => LOGIN_STATUS,
                'value' => LOGIN_STATUS_TRUE,
                'expire' => '7200',
            );
            $this->input->set_cookie($cookie);
            $this->session->set_userdata([USER_ID => $id]);
            $this->session->set_userdata([USER_NAME => $userName]);
            $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_TRUE);
            $this->session->set_userdata(ADMINISTRATOR_CREDENTIAL_STATUS, ADMINISTRATOR_CREDENTIAL_STATUS_FALSE);
            redirect('Dashboard/selectDataSource');
        } else {
            $this->load->view('User/signup');
        }
    }

    public function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    }

}
