<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class dashboard_model extends CI_Model {

    private $MAIN_URL = "http://localhost:8000/";
    private $HTTP_HEADER_JSON = 'Content-Type: application/json';

    public function saveDataSource($data) {
        $curl = curl_init('http://localhost:8000/saveDataSource');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array($this->HTTP_HEADER_JSON));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  // Insert the data
        // Send the request
        $result = curl_exec($curl);

        // Free up the resources $curl is using
        curl_close($curl);

        return $result;
    }

    public function insert_project($data) {
        $curl = curl_init($this->MAIN_URL . "addProject");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array($this->HTTP_HEADER_JSON));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  // Insert the data
        // Send the request
        $result = curl_exec($curl);

        // Free up the resources $curl is using
        curl_close($curl);

        return $result;
    }

    public function get_projects($userID) {
        $curl = curl_init($this->MAIN_URL . "getProjects/" . $userID);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);
        return json_decode($result, TRUE);
    }

    public function get_errors($api_key = NULL) {
        if ($api_key == NULL) {
            return "empty";
        } else {
            $curl = curl_init($this->MAIN_URL . "getErrors/" . $api_key);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            // Send the request
            $result = curl_exec($curl);
            // Free up the resources $curl is using
            curl_close($curl);
            return json_decode($result, TRUE);
        }
    }

    public function get_events($api_key = NULL, $errorID = NULL) {
        if ($api_key == NULL) {
            return "empty";
        } else {
            $curl = curl_init($this->MAIN_URL . "getEvents/" . $api_key . '/' . $errorID);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            // Send the request
            $result = curl_exec($curl);
            // Free up the resources $curl is using
            curl_close($curl);
            return json_decode($result, TRUE);
        }
    }

    public function get_error_by_id($api_key = NULL, $error_id = NULL) {
        if ($api_key == NULL) {
            return "empty";
        } else {
            $url = $this->MAIN_URL . "getErrorByID/" . $api_key . '/' . $error_id;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            // Send the request
            $result = curl_exec($curl);
            // Free up the resources $curl is using
            curl_close($curl);
            return json_decode($result, TRUE);
        }
    }

    public function get_event_details($api_key = NULL, $event_id = NULL) {
        if ($api_key == NULL) {
            return "empty";
        } else {
            $url = $this->MAIN_URL . "getEventByID/" . $api_key . '/' . $event_id;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            // Send the request
            $result = curl_exec($curl);
            // Free up the resources $curl is using
            curl_close($curl);
            return json_decode($result, TRUE);
        }
    }

    public function chekProjectName($projNmae) {
        if ($projNmae != null) {
            $this->db->where(['name' => $projNmae]);
            $q = $this->db->get('project');
        }
        return $q->result();
    }

    public function getUser($u_id) {
        $this->db->where(['id' => $u_id]);
        $q = $this->db->get('user');
        return $q->result();
    }

    public function updateapikey($u_id, $apikey, $projectID) {
        if ($this->projectExistenceCheck($u_id, $projectID)) {
            $this->db->where(['id' => $projectID]);
            $this->db->update('project', $apikey);
            return $this->db->affected_rows();
        } else {
            return NULL;
        }
    }

    public function get_projectsID($u_id, $projectID) {
        $session = $this->session->all_userdata();
        $this->db->where(['id' => $projectID, 'u_id' => $u_id]);
        $q = $this->db->get('project');
        if ($q) {
            return $q->result();
        } else {
            return NULL;
        }
    }

//
//    public function get_errors($u_id = NULL, $proj_id = NULL) {
//        if ($proj_id == NULL && $u_id == NULL) {
//            return "empty";
//        } else {
//            if ($this->projectExistenceCheck($u_id, $proj_id)) {
//                $this->db->where(['project_id' => $proj_id]);
//                $this->db->order_by("lastOccurence", "desc");
//                $q = $this->db->get('error_metadata');
//                if (empty($q)) {
//                    return "empty";
//                } else {
//                    return $q->result();
//                }
//            } else {
//                return "empty";
//            }
//        }
//    }

    public function get_errorsByProjectId($proj_id) {
        $this->db->where(['project_id' => $proj_id]);
        $q = $this->db->get('error_metadata');
        return $q->result();
    }

    public function get_errorsprproj($proj_id = NULL) {
        $this->db->where(['project_id' => $proj_id]);
        $q = $this->db->get('error_metadata');
        $s = $q->num_rows();
        return $s;
    }

    public function projectExistenceCheck($u_id, $projectID) {
        $this->db->where(['u_id' => $u_id]);
        $this->db->where(['id' => $projectID]);
        $result = $this->db->get('project');
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function deleteproject($u_id, $projectID) {
        $session = $this->session->all_userdata();
        $this->db->where(['id' => $projectID, 'u_id' => $u_id]);
        $result = $this->db->get('project');
        if ($result) {
            $this->db->where(['id' => $projectID]);
            $this->db->delete('project');
            return $this->db->affected_rows();
        }
    }

    public function insertUserMail($data) {
        $this->db->insert('user_mails', $data);
        return $this->db->insert_id();
    }

}
