<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('login_model');
        $this->load->model('user_model');
    }

    public function selectDataSource() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE &&
                $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/selectDataSource');
            $this->load->view('Dashboard/footer_dashboard');
        } else {
            redirect('Home/index');
        }
    }

    public function saveDataSource() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $dataSource = $this->input->post('dataSource');
            $user_info = array(
                'id' => $session[USER_ID],
                'dataSource' => $dataSource,
            );
            $result = $this->dashboard_model->saveDataSource(json_encode($user_info));
            if ($result == PROCEED) {
                redirect('Dashboard/addProject');
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Adding New Project.
    //***********************************************
    public function addProject() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/addProject');
            $this->load->view('Dashboard/footer_dashboard');
        } else {
            redirect('Home/index');
        }
    }

    public function creatingProject() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $projectName = $this->input->post('projectName');
            $projecturl = $this->input->post('projecturl');
            $session = $this->session->all_userdata();
            $api_key = $this->getApiKey();
            $this->session->set_userdata([PROJECT_APIKEY => $api_key]);
            $user_info = array(
                'id' => md5(uniqid('', TRUE)),
                'projectName' => $projectName,
                'project_url' => $projecturl,
                'api_key' => $api_key,
                'errors' => 0,
                'userID' => $session[USER_ID],
                'created_at' => date('Y-m-d H:i:s')
            );

//            if (!$this->dashboard_model->chekProjectName($pass)) {
            $result = $this->dashboard_model->insert_project(json_encode($user_info));
            if ($result == PROCEED) {
                redirect('Dashboard/projectIntegration');
            } else {
                $this->addProject();
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Project Integration Page
    //***********************************************
    public function projectIntegration() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/projectIntegration');
            $this->load->view('Dashboard/footer_dashboard');
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Fetching All projects 
    //***********************************************
    public function projects() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE &&
                $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $data['projects'] = $this->dashboard_model->get_projects($session[USER_ID]);
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/projects', $data);
            $this->load->view('Dashboard/footer_dashboard');
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //User Dashboard
    //***********************************************
    public function errors($userID, $projectID, $api_key) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE &&
                $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE &&
                $projectID != NULL && $userID != NULL && $api_key != NULL) {

            if ($session[USER_ID] == $userID) {
                $data['errors'] = $this->dashboard_model->get_errors($api_key);
                $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
                $this->session->set_userdata(PROJECT_ID, $projectID);
                $this->load->view('Dashboard/header_dashboard');
                $this->load->view('Dashboard/errors', $data);
                $this->load->view('Dashboard/footer_dashboard');
            } else {
                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //User Dashboard
    //***********************************************
    public function events($userID, $errorID, $api_key) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE &&
                $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE &&
                $errorID != NULL && $userID != NULL && $api_key != NULL) {

            if ($session[USER_ID] == $userID) {
                $data['events'] = $this->dashboard_model->get_events($api_key,  $errorID);
                $data['error'] = $this->dashboard_model->get_error_by_id($api_key, $errorID);



                $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
                $this->session->set_userdata(PROJECT_ID, $errorID);
                $this->load->view('Dashboard/header_dashboard');
                $this->load->view('Dashboard/events', $data);
                $this->load->view('Dashboard/footer_dashboard');
            } else {
                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Fetching Error details, against recieving 
    //ID, Project Id, User ID.
    //***********************************************
    public function events_details($user_id = NULL, $event_id = NULL, $api_key = NULL) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && 
                $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE && 
                $user_id != NULL && $api_key != NULL && $event_id != NULL) {
            if ($session[USER_ID] == $user_id) {
                $data['event'] = $this->dashboard_model->get_event_details($api_key, $event_id);
                if ($data['event']) {
                    $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
//                    $this->session->set_userdata(PROJECT_ID, $projID);
                    $this->load->view('Dashboard/header_dashboard');
                    $this->load->view('Dashboard/events_details', $data);
                    $this->load->view('Dashboard/footer_dashboard');
                } else {
                    redirect('Dashboard/projects');
                }
            } else {
//                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //***********************************************
    //Fetching Errors count against project ID
    //***********************************************
    public function geterr() {
        $session = $this->session->all_userdata();
        $q = $this->dashboard_model->get_errorsprproj($session[PROJECT_ID]);
        echo json_encode($q);
    }

    //***********************************************
    //User Dashboard
    //***********************************************
    public function userDashboard($u_id, $projID) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE && $projID != NULL && $u_id != NULL) {
            if ($session[USER_ID] == $u_id) {
                $data['errors'] = $this->dashboard_model->get_errors($u_id, $projID);
                if ($data['errors'] != "empty") {
                    $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
                    $this->session->set_userdata(PROJECT_ID, $projID);
                    $this->load->view('Dashboard/header_dashboard');
                    $this->load->view('Dashboard/userDashboard', $data);
                    $this->load->view('Dashboard/footer_dashboard');
                } else {
                    redirect('Dashboard/projects');
                }
            } else {
                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    
    //***********************************************
    //Settings Page of a project
    //***********************************************
    public function settings($u_id = NULL, $projID = NULL) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            if ($session[USER_ID] == $u_id) {
                $data['projects'] = $this->dashboard_model->get_projectsID($u_id, $projID);
                if ($data['projects']) {
                    $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
                    $this->session->set_userdata(PROJECT_ID, $projID);
                    $this->load->view('Dashboard/header_dashboard');
                    $this->load->view('Dashboard/settings', $data);
                    $this->load->view('Dashboard/footer_dashboard');
                } else {
                    redirect('Dashboard/projects');
                }
            } else {
                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Logging out
    //***********************************************
    public function logout() {
        delete_cookie(LOGIN_STATUS);
        delete_cookie(ADMINISTRATOR_CREDENTIAL_STATUS);
        $session = $this->session->all_userdata();
        $this->session->set_userdata(LOGIN_STATUS, LOGIN_STATUS_FLASE);
        if ($session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $logoutDate = date("Y-m-d h:i:sa");
            $this->user_model->setStatusLogout(['lastLogout' => $logoutDate,
                'status' => 0]);
        }
        $this->session->sess_destroy();
        redirect('Home/index');
    }

    //***********************************************
    //Account Settings Page
    //***********************************************
    public function accountSettings() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/accountSettings');
            $this->load->view('Dashboard/footer_dashboard');
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Redirect to Project Graphs page
    //***********************************************
    public function projectGraph($u_id, $projID) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE && $projID != NULL && $u_id != NULL) {
            if ($session[USER_ID] == $u_id) {
                $data['errors'] = $this->dashboard_model->get_errors($u_id, $projID);
                $data["noprojectmessage"] = NULL;
                //proceed if project with id $projID contains atleast 1 error
                if (!empty(($data['errors']))) {
                    $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
                    $this->session->set_userdata(PROJECT_ID, $projID);
                    $errors = $this->dashboard_model->get_errorsByProjectId($projID);
                    $this->session->set_userdata(['projid' => $projID]);
                    $lastOccur = array();
                    //retrieving the date/time of occurance of all errors from result
                    foreach ($errors as $value) {
                        $lastOccur[] = $value->lastOccurence;
                    }
                    $dates = array();
                    foreach ($lastOccur as $s) {
                        if (ord($s[0]) >= 48 && ord($s[0]) <= 57) {
                            $dates[] = date('d/M/Y', strtotime($s));      //changing string to date/time
                        } else if ($s[0] == '?') {
                            $p = explode("?", $s); // breaks the string $s in array. Delimiter '?' is used to split te string 
                            $d = implode($p);     //join array elements 
                            $date = date('d/M/Y', strtotime($d));
                            $dates[] = $date;
                        } else {
                            $p = explode(" ", $s);
                            $d = $p[1] . " " . $p[2] . " " . $p[3];
                            $date = date('d/M/Y', strtotime($d));
                            $dates[] = $date;
                        }
                    }
                    $data['lastOccur'] = $dates;
                    $today = date("m/d/Y");
                    $date_today = date('d/M/Y', strtotime($today));
                    $date = date('Y-m-d', strtotime($today));
                    $date = date_create($date);
                    $last_12days = array();
                    for ($i = 0; $i <= 11; $i++) {
                        $last_12days[$i] = $date->format('d/M/Y');
                        date_modify($date, '-1 day');              //decrement a date 
                    }
                    $last_12_days = array();
                    for ($i = sizeof($last_12days) - 1; $i > -1; $i--) {
                        $last_12_days[] = $last_12days[$i];
                    }
                    $data["last_12days"] = $last_12_days;

                    $count = array();
                    $i = 0;
                    $last_12_days_errorMessages = array();
                    $ReferenceError_Count = array(
                        array(0));
                    $SyntaxError_Count = array(
                        array(0));
                    $failedToLoadResource_Count = array(
                        array(0));
                    $TypeError_Count = array(
                        array(0));
                    $ScriptError_Count = array(
                        array(0));
                    $others_Count = array(
                        array(0));


                    foreach ($last_12_days as $value) {
                        $count[$i] = 0;
                        $temp = true;
                        $k = 0;
                        $ReferenceError_Count[$i][0] = 0;
                        $failedToLoadResource_Count[$i][0] = 0;
                        $ScriptError_Count[$i][0] = 0;
                        $SyntaxError_Count[$i][0] = 0;
                        $TypeError_Count[$i][0] = 0;
                        $others_Count[$i][0] = 0;
                        foreach ($dates as $v) {
                            if ($value === $v) {
                                $last_12_days_errorMessages[$i] = $errors[$k]->message;
                                if (strpos($last_12_days_errorMessages[$i], 'ReferenceError') !== false) {
                                    $ReferenceError_Count[$i][0] ++;
                                } else if (strpos($last_12_days_errorMessages[$i], 'SyntaxError') !== false) {
                                    $SyntaxError_Count[$i][0] ++;
                                } else if (strpos($last_12_days_errorMessages[$i], '404') !== false) {
                                    $failedToLoadResource_Count[$i][0] ++;
                                } elseif (strpos($last_12_days_errorMessages[$i], 'TypeError') !== false) {
                                    $TypeError_Count[$i][0] ++;
                                } elseif (strpos($last_12_days_errorMessages[$i], 'Script error') !== false) {
                                    $ScriptError_Count[$i][0] ++;
                                } else {
                                    $others_Count[$i][0] ++;
                                }
                                $count[$i] ++;
                            }
                            $k++;
                        }
                        $i++;
                    }

                    $data["count"] = $count;
                    $data["ReferenceError_Count"] = $ReferenceError_Count;
                    $data["SyntaxError_Count"] = $SyntaxError_Count;
                    $data["failedToLoadResource_Count"] = $failedToLoadResource_Count;
                    $data["TypeError_Count"] = $TypeError_Count;
                    $data["ScriptError_Count"] = $ScriptError_Count;
                    $data["others_Count"] = $others_Count;

                    //********************************************************************
                    //all $data[""] object above contains data needed for the 2nd graph 
                    //containing comparison of different types of errors for the last 
                    //12 days passed including the current date 
                    //********************************************************************

                    $browser = array();
                    foreach ($errors as $value) {
                        $browser[] = $value->browswer;
                    }
                    $chromeCount = 0;
                    $mozillaCount = 0;
                    $safariCount = 0;
                    $ieCount = 0;
                    $othersCount = 0;
                    foreach ($browser as $value) {
                        if ($value === 'Chrome') {
                            $chromeCount++;
                        } elseif ($value === 'Mozilla') {
                            $mozillaCount++;
                        } elseif ($value === 'Safari') {
                            $safariCount++;
                        } elseif ($value === 'IE') {
                            $ieCount++;
                        } else {
                            $othersCount++;
                        }
                    }
                    $total = $chromeCount + $mozillaCount + $safariCount + $ieCount + $othersCount;
                    $browser_percentage = array();
                    $browser_percentage['chrome'] = ($chromeCount / $total) * 100;
                    $browser_percentage['mozila'] = ($mozillaCount / $total) * 100;
                    $browser_percentage['safari'] = ($safariCount / $total) * 100;
                    $browser_percentage['ie'] = ($ieCount / $total) * 100;
                    $browser_percentage['others'] = ($othersCount / $total) * 100;
                    $data['browser_percentage'] = $browser_percentage;

                    //********************************************************************
                    //$data['browser_percentage'] object above contains data needed for 
                    //the pie chart comparing the percentage usage of different type
                    //of browsers 
                    //********************************************************************

                    $err_message = array();
                    foreach ($errors as $value) {
                        $err_message[] = $value->message;
                    }
                    $ReferenceErrorCount = 0;
                    $SyntaxErrorCount = 0;
                    $failedToLoadResourceCount = 0;
                    $TypeErrorCount = 0;
                    $ScriptErrorCount = 0;
                    $othersCount = 0;
                    foreach ($err_message as $value) {
                        if (strpos($value, 'ReferenceError') !== false) {
                            $ReferenceErrorCount++;
                        } else if (strpos($value, 'SyntaxError') !== false) {
                            $SyntaxErrorCount++;
                        } else if (strpos($value, '404') !== false) {
                            $failedToLoadResourceCount++;
                        } elseif (strpos($value, 'TypeError') !== false) {
                            $TypeErrorCount++;
                        } elseif (strpos($value, 'Script error') !== false) {
                            $ScriptErrorCount++;
                        } else {
                            $othersCount++;
                        }
                    }
                    $total = $ReferenceErrorCount + $SyntaxErrorCount + $failedToLoadResourceCount + $TypeErrorCount + $ScriptErrorCount + $othersCount;
                    $errMessage = array();
                    $errMessage['ReferenceError'] = ($ReferenceErrorCount / $total) * 100;
                    $errMessage['SyntaxError'] = ($SyntaxErrorCount / $total) * 100;
                    $errMessage['failedToLoadResource'] = ($failedToLoadResourceCount / $total) * 100;
                    $errMessage['TypeError'] = ($TypeErrorCount / $total) * 100;
                    $errMessage['ScriptError'] = ($ScriptErrorCount / $total) * 100;
                    $errMessage['others'] = ($othersCount / $total) * 100;
                    $data['errMessage'] = $errMessage;

                    //***********************************************************************
                    //$data['errMessage'] object above contains data needed for the bar chart 
                    //comparing the percentage of occurance of different types of errors 
                    //***********************************************************************
                } else {
                    $data["noprojectmessage"] = "No Error's have been recieved yet.";
                }
                $this->load->view('Dashboard/header_dashboard');
                $this->load->view('Dashboard/projectGraph', $data);
                $this->load->view('Dashboard/footer_dashboard');
            } else {
                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Regenerating API Key
    //***********************************************
    public function regenerateApiKey($u_id, $projectID, $apiKey) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $val = md5(uniqid(rand(), true));
            $result = $this->dashboard_model->updateapikey($u_id, ['apikey' => $val], $projectID);
            if ($result) {
                echo json_encode($val);
            } else {
                echo json_encode("Key Is not Regenerated. Try again later.");
            }
        } else {
            redirect('Home/index');
        }
    }

    //***********************************************
    //Deleting Project
    //***********************************************
    public function deleteProject($u_id, $projectID) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE && $projectID != NULL && $u_id != NULL) {
            if ($session[USER_ID] == $u_id) {
                $d = $this->dashboard_model->deleteproject($u_id, $projectID);
            }
            if ($d) {
                $val = "deleted";
            }
            echo json_encode($val);
        }
    }

    //***********************************************
    //User's Countact us Page
    //***********************************************
    public function contactus() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_FALSE);
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/contactus');
            $this->load->view('Dashboard/footer_dashboard');
        }
    }

    //***********************************************
    //Showing Success message
    //***********************************************
    public function contactusSuccess() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $this->load->view('Dashboard/header_dashboard');
            $this->load->view('Dashboard/contactusSuccess');
            $this->load->view('Dashboard/footer_dashboard');
        }
    }

    //***********************************************
    //Tabular view of errors
    //***********************************************
    public function tabularview($u_id, $projID) {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE && $projID != NULL && $u_id != NULL) {
            if ($session[USER_ID] == $u_id) {
                $data['errors'] = $this->dashboard_model->get_errors($u_id, $projID);
                if ($data['errors'] != "empty") {
                    $this->session->set_userdata(PROJECT_OPEN_STATUS, PROJECT_OPEN_STATUS_TRUE);
                    $this->session->set_userdata(PROJECT_ID, $projID);
                    $this->load->view('Dashboard/header_dashboard');
                    $this->load->view('Dashboard/tabularview', $data);
                    $this->load->view('Dashboard/footer_dashboard');
                } else {
                    redirect('Dashboard/projects');
                }
            } else {
                redirect('Dashboard/projects');
            }
        } else {
            redirect('Home/index');
        }
    }

    public function uploadpic() {
        $config = array(
            'upload_path' => "./images/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "768",
            'max_width' => "1024"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
            $data['img'] = array('upload_data' => $this->upload->data());
            $this->load->view('t', $data);
        } else {
            echo $this->upload->display_errors();
        }
    }

    public function sucess() {
        $this->load->view('Dashboard/sucess', array('error' => ' '));
    }

    //***********************************************
    //Sending Mail to admin
    //***********************************************
    public function sendMail() {
        $session = $this->session->all_userdata();
        if ($session[LOGIN_STATUS] == LOGIN_STATUS_TRUE && $session[ADMINISTRATOR_CREDENTIAL_STATUS] == ADMINISTRATOR_CREDENTIAL_STATUS_FALSE) {
            $name = $this->input->post("name");
            $subject = $this->input->post('subject');
            $emailFrom = $this->input->post('email');
            $message = $this->input->post('message');
            $date = date("Y-m-d h:i:sa");
            $result = $this->dashboard_model->insertUserMail([
                'Name' => $name,
                'Subject' => $subject,
                'from' => $emailFrom,
                'date' => $date,
                'message' => $message
            ]);
            redirect('Dashboard/contactusSuccess');
        }
    }

    //***********************************************
    //Re-setting Password
    //***********************************************
    public function repwd() {
        $q = null;
        $s = null;
        $session = $this->session->all_userdata();
        $old = $this->input->post('old');
        $new = $this->input->post('New');
        $data['user'] = $this->login_model->get($session[USER_NAME], $old);
        $data1 = array(
            'username' => null
        );
        if ($data['user']) {
            $this->session->set_userdata(['changed' => 'true']);
            $q = $this->login_model->updatelogin([
                'password' => $new], $session[USER_ID]);
            $s = "password has been changed";
        }
        echo json_encode($s);
    }

    //***********************************************
    //Re-setting Email ID
    //***********************************************
    public function reemail() {
        $s1 = null;
        $email = $this->input->post('email');
        $session = $this->session->all_userdata();
        if ($email) {
            $s1 = "data";
            $q = $this->user_model->update([
                'email' => $email], $session[USER_ID]);
            $this->session->set_userdata(['email' => $email]);
        }
        echo json_encode($s1);
    }

    //***********************************************
    //Re-Setting User name
    //***********************************************
    public function redata() {
        $s = null;
        $session = $this->session->all_userdata();
        $name = $this->input->post('name');
        if ($name) {
            $q = $this->login_model->updatelogin([
                'username' => $name], $session[USER_ID]);
            $s = "data";
            $this->session->set_userdata([USER_NAME => $name]);
        }
        echo json_encode($name);
    }

    public function getApiKey() {
        $session = $this->session->all_userdata();
        $apikey = md5(uniqid(uniqid('', TRUE)));
        if ($session[USER_DATA_SOURCE] == MYSQL_DATA_SOURCE) {
            if ($apikey[31] == 'f') {
                mt_srand(mktime());
                $random_value = mt_rand(0, 14);
                if ($random_value == 10) {
                    $apikey[31] = 'a';
                } elseif ($random_value == 11) {
                    $apikey[31] = 'b';
                } elseif ($random_value == 12) {
                    $apikey[31] = 'c';
                } elseif ($random_value == 13) {
                    $apikey[31] = 'd';
                } elseif ($random_value == 14) {
                    $apikey[31] = 'e';
                }
                $apikey[31] = $random_value;
            }
        } else {
            $apikey[31] = 'f';
        }
        return $apikey;
    }

}
