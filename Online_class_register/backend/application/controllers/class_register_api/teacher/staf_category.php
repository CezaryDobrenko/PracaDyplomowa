<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class staf_category extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/teacher/staf_grades_category_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }


    //Read grades_category
    public function read_category_get(){
        if(staf_category::tokenAccessValidation("Teacher","Headmaster")){
            $grade_category_data = $this->staf_grades_category_model->get_category();
            if(count($grade_category_data) > 0){
                $this->response(array("message" => "Category list", "data" => $grade_category_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Token validation
    public function tokenAccessValidation($role, $role2){

        $headers = $this->input->request_headers();
        $token = $headers['Authorization'];
        $current_time = time();

        try{
            $isAuth = authorization::validateToken($token);
            if($isAuth){
                if($isAuth->exp > $current_time){
                    if(($isAuth->data->user_role == $role) || ($isAuth->data->user_role == $role2)){
                        return true;
                    } else {
                        $this->response(array("message" => "Permmision denied"), parent::HTTP_FORBIDDEN);
                    }
                } else {
                    $this->response(array("message" => "Token expired"), parent::HTTP_UNAUTHORIZED);
                }
            } else {
                $this->response(array("message" => "Unauthorize access"), parent::HTTP_UNAUTHORIZED);
            }
        }catch(Exception $ex){
            $this->response(array("message" => $ex->getMessage()), parent::HTTP_INTERNAL_SERVER_ERROR);
        }
        return false;
    }

    //Input validation
    public function validateInput($input_data){

        foreach ($input_data as &$value) {
            if ($this->security->xss_clean($value, TRUE) === FALSE)
                return false;
            if($value != html_escape($value))
                return false;
        }
        return true;
    }
        
}

?>