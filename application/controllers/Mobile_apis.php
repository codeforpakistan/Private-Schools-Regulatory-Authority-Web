<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_apis extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		// $this->load->library('email');
		$this->load->model('common_model');
	}
	
	public function index()
	{
		 $this->load->library('email');
           //SMTP & mail configuration
     $config = array(
         'protocol'  => 'smtp',
         'smtp_host' => 'ssl://www.rayeorah.com',
         'smtp_port' => 465,
         'smtp_user' => 'complaint@psra.gkp.pk',
         'smtp_pass' => 'bl.creativeon.net'
          ,'mailtype'  => 'html',
          'charset'   => 'utf-8'
     );
     $this->email->set_mailtype("html");
     $this->email->set_newline("\r\n");
     $subject = "subject"; // $this->input->post('subject');
     $description = "description";// $this->input->post('description');
         $name = "M.kamran";
         $to = "muhammad.kamran.5711@gmail.com";
         $this->email->from('complaint@psra.gkp.pk', 'Private School Regulatory Athority');
         $this->email->to($to);
         $this->email->subject($subject);
         $this->email->message("<h3>Greetings ".$name.",</h3>\r\n".$description);
         $this->email->send();


	}

//  1 = pass,insrtion fail = 2,  already existed data = 3,  missing post data = 0
	public function registration(){
	    date_default_timezone_set("Asia/Karachi");
	   // $dated = date('Y-m-d H:i:s');
        $dated = date("d-m-Y h:i:sa");
		$userTitle	= $this->input->post('userTitle');
		$userPassword 	= $this->input->post('userPassword');
		$userEmail  = $this->input->post('userEmail');
		$cnic        = $this->input->post('cnic');
		$contactNumber        = $this->input->post('contactNumber');
		$district_id        = $this->input->post('district_id');
		$address        = $this->input->post('address');
		$gender        = $this->input->post('gender');
		$token_key = $this->input->post('token_key');
// 		$dated = date("d-m-Y h:i:sa");
		$varification_code = mt_rand(1000, 9999);
		
		$formatted_cnic = substr($cnic, 0,5).'-'.substr($cnic, 5, 7).'-'.substr($cnic, 12, 1);
        $cnic = $formatted_cnic;
        
        $formatted_contactNumber = substr($contactNumber, 0, 4).'-'.substr($contactNumber, 4, 7);
        $contactNumber = $formatted_contactNumber;
		
		if (!empty($userTitle) && !empty($userPassword) && !empty($userEmail) && !empty($cnic) && !empty($contactNumber) && !empty($district_id) && !empty($address) && !empty($gender)) {
			$varify = $this->common_model->getAllData('users','*', array("cnic"=>$cnic));
			if($varify){
				$response = array(
					"success"=> 3,
					"message"=>$cnic." is already registered."
				);
			}else{
				$result = $this->common_model->InsertData("users",
				                array("userTitle"=>$userTitle,
    									"userPassword"=>$userPassword,
    									"userEmail"=>$userEmail,
    									"cnic"=>$cnic,
    									"contactNumber"=>$contactNumber,
    									"district_id"=>$district_id,
    									"address"=>$address,
    									"gender"=>$gender,
    									"role_id"=>100,
    									"user_password_reset_code" => $varification_code,
    									"userName"=> $cnic,
    									"createdDAte"=> $dated,
    									"token_key" => $token_key)
											);
				if($result){
				    
				    $user_id = $result;
			    	$this->load->library('email');
                    $url = base_url("mobile_apis/varify_account_by_code/".$user_id."/".$varification_code);
                    //SMTP & mail configuration
                    $config = array(
                        'protocol'  => 'smtp',
                        'smtp_host' => 'ssl://www.psra.gkp.pk',
                        'smtp_port' => 465,
                        'smtp_user' => 'complaint@psra.gkp.pk',
                        'smtp_pass' => 'bl.creativeon.net'
                        ,'mailtype'  => 'html',
                        'charset'   => 'utf-8'
                    );
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");
                    $subject = "Varification Code"; // $this->input->post('subject');
                    $url = base_url("mobile_apis/varify_account_by_code/".$user_id."/".$varification_code);
                    $body='Your Activation Code is '.$varification_code.' Or Click On This link to activate  your account. <a href="'.$url.'">Varification link</a>';
                    $name = $userTitle;
                    $to = $userEmail;
                    


                    $this->email->from('complaint@psra.gkp.pk', 'Private School Regulatory Athority');
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message("<h3>Greetings ".$name.",</h3>\r\n".$body);
                    $this->email->send();
				    // $send = mail($userEmail, "Varification Code", "Please enter this code:".$varification_code);
	    			$response=array(
	    			    "userId" =>$result,
						"success"=>1,
						"Message"=>"Succesfully Registered"
					);
				}else{
				    $response=array(
						"success"=>2,
						"Message"=>"Registration error occured, try again."
					);
				}
			    
			}
			
		}else{
		    $response=array(
				"success"=>0,
				"Message"=>"Kindly fill the registration form completely."
			);
		}
		echo json_encode(array($response));
	}

//  1 = pass,insrtion fail = 2,  already existed data = 3,  missing post data = 0
	public function userUpdate(){
	    date_default_timezone_set("Asia/Karachi");
	    $userId = $this->input->post("userId");
		$userTitle	= $this->input->post('userTitle');
		$userPassword 	= $this->input->post('userPassword');
// 		$userEmail  = $this->input->post('userEmail');
// 		$cnic        = $this->input->post('cnic');
		$contactNumber        = $this->input->post('contactNumber');
// 		$district_id        = $this->input->post('district_id');
		$address        = $this->input->post('address');
// 		$gender        = $this->input->post('gender');

		$dated = date("d-m-Y h:i:sa");
// 		if (!empty($userTitle) && !empty($userPassword) && !empty($userEmail) && !empty($contactNumber) && !empty($district_id) && !empty($address) && !empty($gender) && !empty($userId)) {

		if (!empty($userTitle) && !empty($userPassword)  && !empty($contactNumber)  && !empty($address)  && !empty($userId)) {
                $userRecord = array("userTitle"=>$userTitle,
    									"userPassword"=>$userPassword,
    								// 	"userEmail"=>$userEmail,
    									"contactNumber"=>$contactNumber,
    								// 	"district_id"=>$district_id,
    									"address"=>$address
    								// 	,"gender"=>$gender
    									);
				$result = $this->common_model->UpdateDB("users",array("userId"=>$userId), $userRecord);
				
				if($result){
				    //  $userinfo = $this->common_model->DJoin("userId, userTitle, userPassword, userEmail, cnic, contactNumber, districtTitle, address, gender", "users", "district", "users.district_id = district.districtId",'', array("userId"=>$userId));
	
	    			$response=array(
						"success"=>1,
						"Message"=>"Your profile is successfully Updated."
					);
				}else{
				    $response=array(
						"success"=>2,
						"Message"=>"Profile updation error occure., try again."
					);
				}

			
		}else{
		    $response=array(
				"success"=>0,
				"Message"=>"Kindly fill the profile updation form completely."
			);
		}
		echo json_encode(array($response));
	}
	
	public function varify_user_account(){
	    $varification_code = $this->input->post('varification_code');
	    $user_id = $this->input->post('user_id');
	    $user_password_reset_code = $this->db->where('userId', $user_id)->get('users')->result()[0]->user_password_reset_code;
	    if($user_password_reset_code == $varification_code){
	        $updateData = array(
                'userStatus' => 1
            );
	        $this->db->where('userId', $user_id);
            $this->db->update('users', $updateData);
            $affected = $this->db->affected_rows();
            if($affected){
                $response=array(
					"success"=>1,
					"Message"=>"Account successfully verified."
				);
				echo json_encode(array($response));
				exit;
            }
	    }else{
	            $response=array(
					"success"=>0,
					"Message"=>"The code you have entered is not match with email code, Try again."
				);
				echo json_encode(array($response));
				exit;
	    }
	    
	}

	public function login(){
		$userPassword 	= $this->input->post('userPassword');
		$cnic        = $this->input->post('cnic');
		
		$formatted_cnic = substr($cnic, 0,5).'-'.substr($cnic, 5, 7).'-'.substr($cnic, 12, 1);
        $cnic = $formatted_cnic;
		
		if (!empty($userPassword) && !empty($cnic)) {
		    $this->db->where('cnic', $cnic);
		    $this->db->where('userPassword', $userPassword);
		    $userStatus = $this->db->get('users')->result()[0]->userStatus;
            
            if($userStatus == 0){
                $response=array(
					"success"=>2,
					"Message"=>"Kindly check your email and verify your account first then login."
				);
				echo json_encode(array($response));
				exit;
            }

			$varify = $this->common_model->Authentication('users', array("cnic"=>$cnic, "userPassword"=>$userPassword));
			if($varify){
				$userInfo =  $this->common_model->DJoin("userId, userTitle, userPassword, userEmail, cnic, token_key, contactNumber, districtTitle, address, gender", "users", "district", "users.district_id = district.districtId",'', array("cnic"=>$cnic, "userPassword"=> $userPassword));
				if($this->input->post('token_key')  != null){
				    $value=array('token_key'=> $this->input->post('token_key'));
				    $this->db->where('userId', $userInfo[0]->userId)->update('users', $value);
				    $userInfo[0]->token_key = $this->input->post('token_key');
				}

				$response = array(
					"success"=> 1,
					"Message"=>"Successfully logged in."
				);
				$response['userInfoList'] = $userInfo;
				echo json_encode($response);
			}else{
			
				$response=array(
					"success"=>0,
					"Message"=>"Invalid cnic or password, try again."
				);
				echo json_encode(array($response));
			}
			
		}
	}

	// get conmplain prerequesite data
	public function get_data_require_for_complain(){
	    header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
	    $district_id = $this->input->post('district_id');
	    $tehsil_id = $this->input->post('tehsil_id');
	    $uc_id = $this->input->post('uc_id');
		$response = array();
		//get complains type
		if( empty($district_id) && empty($tehsil_id) && empty($uc_id)){
		$complainType = $this->common_model->getAllData('complain_type','complainTypeId, complainTypeTitle');
		$response["complainTypesList"] = $complainType;
		
	    $school_type = $this->common_model->getAllData('school_type','typeId, typeTitle');
		$response["school_type"] = $school_type;
		$levelofinstitute = $this->common_model->getAllData('levelofinstitute','levelofInstituteId, levelofInstituteTitle');
		$response["levelofinstitute"] = $levelofinstitute;
		$genderofschool = $this->common_model->getAllData('genderofschool','genderOfSchoolId, genderOfSchoolTitle');
		$response["genderofschool"] = $genderofschool;

		// get district  list
		$districtlist = $this->common_model->getAllData('district','districtId, districtTitle');
		$response["districtlist"]= $districtlist;
		echo json_encode($response);
		exit();
		}
        
        if(!empty($district_id)){
        $tehsils_list = $this->common_model->getAllData('tehsils','tehsilId, tehsilTitle', array('district_id' => $district_id));
		$response["tehsils_list"]= $tehsils_list;
        }
        if(!empty($tehsil_id)){
        $tehsils_list = $this->common_model->getAllData('uc','ucId, ucTitle', array('tehsil_id'=>$tehsil_id));
		$response["uc_list"]= $tehsils_list;
        }
       $this->db->select("schoolId, schoolName");
       $this->db->from("schools");

       if(!empty($district_id) && $district_id !=0)
       {
          $this->db->where('schools.district_id', $district_id);
       }
       if(!empty($tehsil_id) && $tehsil_id != 0)
       {
            $this->db->where('schools.tehsil_id', $tehsil_id);
       }
       if(!empty($uc_id) && $uc_id != 0)
       {
          $this->db->where('schools.uc_id' ,$uc_id);
       }
       $q=$this->db->get();
       $response['schoolslist'] =  $q->result();

       if( $q->num_rows() > 0 ){
           
           		$response["success"]= 1;
           	
       }else{
           	$response["success"]= 0;
       }
	   echo json_encode($response);

	}
// below function is used for filing complain...
	public function file_complain(){

		date_default_timezone_set("Asia/Karachi");
        $dated = date('Y-m-d H:i:s');
		$complain_type_id	= $this->input->post('complain_type_id');
		$complainDetail 	= $this->input->post('complainDetail');
		$user_id  = $this->input->post('user_id');
		$school_id        = $this->input->post('school_id');
		$district_id        = $this->input->post('district_id');
		$complainFrom        = 'mobile';
		$schoolAddress        = $this->input->post('schoolAddress');

		if (!empty($complain_type_id) && !empty($user_id) && !empty($school_id) && !empty($district_id) ) {

				$result = $this->common_model->InsertData("complains",array(
						"complain_type_id"=>$complain_type_id,
						"complainDetail"=>$complainDetail,
						"user_id"=>$user_id,
						"school_id"=>$school_id,
						"district_id"=>$district_id,
						"complainFrom"=>$complainFrom,
						"schoolAddress"=>$schoolAddress,
						"dated" => $dated
						)
					);
				if($result){
            	// upload process start...
            	if(isset($_FILES['files'])){
            		$path = './uploads/images_uploaded_by_complainer/';
            		$title = $user_id;
            		$files = $_FILES['files'];
            		$uploads = $this->common_model->upload_files($path, $title, $files);
                    // end upload process
                    foreach($uploads as $upload => $value){
                        $this->common_model->InsertData("complain_uploads", array("complainUploadName"=>$value, "complain_id"=>$result));
                    }
                
            	}
                
				$response=array(
					"success"=>1,
					"Message"=>"You have succesfully Registered the complain."
				);
				}else{
					$response=array(
						"success"=>2,
						"Message"=>"Server error, please try later."
					);
				}
				
			}else{
				$response=array(
					"success"=>0,
					"Message"=>"Kindly fill the complain form carefully."
				);
			}
			echo json_encode(array($response));
			
		}
	
	// below function is used for getting filed complain...
	public function get_complain_list(){
        $userId = $this->input->post("userId");
        // $userId = $user_id;

		if (!empty($userId)) {
                $get_complains_list = "SELECT
                                        `complains`.`complain_id`
                                        , `complains`.`complain_type_id`
                                        , `complain_type`.`complainTypeTitle`
                                        , `complains`.`complainDetail`
                                        , `complains`.`school_id`
                                        , `schools`.`schoolName`
                                        , `complains`.`status_id`
                                        , `complain_process_status`.`statusTitle`
                                        , `complains`.`dated`
                                        , `complains`.`updatedDate`
                                        , `complains`.`district_id`
                                        , `district`.`districtTitle`
                                        , `complains`.`user_id`
                                    FROM
                                        `complains`
                                        LEFT JOIN `complain_type` 
                                            ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                                        LEFT JOIN `district` 
                                            ON (`complains`.`district_id` = `district`.`districtId`)
                                        LEFT JOIN `complain_process_status` 
                                            ON (`complains`.`status_id` = `complain_process_status`.`statusId`)
                                        LEFT JOIN `schools` 
                                            ON (`complains`.`school_id` = `schools`.`schoolId`)
                                        WHERE `complains`.`user_id`= '".$userId."'";
				$result = $this->common_model->runQuery($get_complains_list);
				if(count($result) > 0){
				date_default_timezone_set("Asia/Karachi");
        	    $dated = date('Y-m-d H:i:s');
				    foreach($result as $re){
				        $update_data = $re->updatedDate;
                        $now    = new DateTime();
                        $future = new DateTime($update_data);
                        $re->show = 0;
				        if($future < $now){
				            $re->show = 1;
				        }
				    }
				$response=array(
					"success"=>1,
					"complains_list"=> $result
				);
				}else{
					$response=array(
						"success"=>2,
						"Message"=>"You didn't filed complain yet."
					);
				}
			}else{
				$response=array(
					"success"=>0,
					"Message"=>"Internal server error."
				);
			}
			echo json_encode(array($response));
			
		}
		public function forgot_password(){
		    $cnic = $this->input->post('cnic');
            $get_email_query = 
                        "SELECT
                            `userEmail`
                            , `cnic`
                            , `userPassword`
                        FROM
                            `users`
                            WHERE `users`.`cnic` = '".$cnic."'";
				$result = $this->common_model->runQuery($get_email_query);

		    if(count($result) > 0){	
		        $result[0]->userEmail;
		        
		  //  echo json_encode(array($result[0]->userEmail));
		  //  exit;
		  		$send = mail($result[0]->userEmail,"Email containing password","your password is:".$result[0]->userPassword);
		  		if($send){
    		  		$response=array(
    					"success"=>1,
    					"Message"=> "Kindly check your email, We have send your password."
    				);
		  		}else{
		  		    $response=array(
    					"success"=>2,
    					"Message"=> "Internal server error."
    				);
		  		}

				}else{
					$response=array(
						"success"=>0,
						"Message"=>"We don't any account registered with cnic number:".$cnic
					);
				}
			echo json_encode(array($response));
		}
		
		public function add_feedback_of_complains(){
		  //  fields are  ....  complain_id, agree_or_not_agree, details
		    $posts = $this->input->post();
		    date_default_timezone_set("Asia/Karachi");
           	$dated = date('Y-m-d H:i:s');
		    $posts['date'] = $dated;
		    $this->db->insert('feedback_of_complains', $posts);
		    $insert_id = $this->db->insert_id();
            if($insert_id > 0){
    		  		$response=array(
    					"success"=>1,
    					"Message"=> "We have recived your feedback thank you."
    				);
		  		}else{
		  		    $response=array(
    					"success"=>2,
    					"Message"=> "Internal server error, try again"
    				);
		  		}
			echo json_encode(array($response));
		}
		
		public function about_us(){
		    $response=array(
    					"heading"=>"heading goes here",
    					"details"=> "text goes here...."
    				);
		  	
			echo json_encode(array($response));
		    
		}
		
		
    // 	website part api
    // in  below fucntion we are checking if exist then return true else false....
    public function complainant_exists_or_not(){
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            $cnic = $this->input->post('cnic');
            $result = $this->db->where('cnic', $cnic)->get('users')->result();
            if(count($result) > 0){
            $user_id = $result[0]->userId;
                // pass
                $response=array(
    				"user_id"=> $user_id,
    				"status"=> 1
    			);
            }else{
                // fail
                $response=array(
    				"status"=> 0
    				);
            }

		  	
			echo json_encode($response);
			exit;
        // $this->input->
    }
    public function user_registration_and_filing_complaint(){

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
        // var_dump($_FILES);
        // var_dump($this->input->post());
        // exit;

        // get user data through post...
        $response = array();
        $user_id = $this->input->post('user_id');
        
        date_default_timezone_set("Asia/Karachi");
        $dated = date("d-m-Y h:i:sa");
        
        if($this->input->post('user_id') == ''){
        
        $cnic = $this->input->post("cnic");
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $gender = $this->input->post('gender');
        $contactNumber = $this->input->post('contactNumber');
        $email = $this->input->post('email');
        $user_district = $this->input->post('user_district');
        $address = $this->input->post('address');
        
        $varification_code = mt_rand(1000, 9999);
        
        // preparing array for insertion in user table...
        $user_data = array (
            "role_id"=> 100,
            "userTitle"=> $name,
            "userPassword"=> $password,
            "userEmail"=> $email,
            "gender"=> $gender,
            "userName"=> $cnic,
            "cnic"=> $cnic,
            "user_password_reset_code" => $varification_code,
            "contactNumber"=> $contactNumber,
            "district_id"=> $user_district,
            "address"=> $address,
            "createdDate"=>$dated
            );
        // var_dump($this->input->post());
        // echo "<br />";
        // var_dump($user_data);
        // exit;
        $this->db->insert('users', $user_data);
        $user_id = $this->db->insert_id();
            if($user_id){
                // To send HTML mail, the Content-type header must be set
                // $headers  = 'MIME-Version: 1.0' . "\r\n";
                // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                // $url = base_url("mobile_apis/varify_account_by_code/".$user_id."/".$varification_code);
                // $body='Your Activation Code is '.$varification_code.' Please Click On This link to activate  your account. <a href="'.$url.'">Varification link</a>';
                // $send = mail($email, "Varify Your Account", $body, $headers);
                
		    	$this->load->library('email');
                $url = base_url("mobile_apis/varify_account_by_code/".$user_id."/".$varification_code);
                //SMTP & mail configuration
                $config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'ssl://www.psra.gkp.pk',
                    'smtp_port' => 465,
                    'smtp_user' => 'complaint@psra.gkp.pk',
                    'smtp_pass' => 'bl.creativeon.net'
                    ,'mailtype'  => 'html',
                    'charset'   => 'utf-8'
                );
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $subject = "Varification Code"; // $this->input->post('subject');
                $url = base_url("mobile_apis/varify_account_by_code/".$user_id."/".$varification_code);
                $body='Your Activation Code is: '.$varification_code.' Or Click On This link to activate  your account. <a href="'.$url.'">Varification link</a>';
                $to = $email;
                


                $this->email->from('complaint@psra.gkp.pk', 'Private School Regulatory Athority');
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message("<h3>Greetings ".$name.",</h3>\r\n".$body);
                $send = $this->email->send();

                if($send){
                    $response=array(
    						"email_msg"=>"You have successfully registered, Please check your email."
    					);
                }
            }
        }
        $dated = date('Y-m-d H:i:s');
        // get complaint data through post...
        $school_district_id = $this->input->post('school_district_id');
        $school_tehsil_id = $this->input->post('school_tehsil_id');
        $school_uc_idt = $this->input->post('school_uc_id');
        
        $school_id = $this->input->post('school_id');
        $complaint_details = $this->input->post('complaint_details');
        $complaint_type_id = $this->input->post('complaint_type_id');
        $schoolAddress = $this->input->post('schoolAddress');
        
        $complaint_data = array(
            "complain_type_id"=> $complaint_type_id,
            "complainDetail"=> $complaint_details,
            "user_id"=> $user_id,
            "school_id"=> $school_id,
            "status_id"=> 1,
            "dated"=> $dated,
            "complainFrom"=> 'Website',
            "district_id"=> $school_district_id,
            "schoolAddress"=> $schoolAddress
            );
        
        $this->db->insert('complains', $complaint_data);
        $comlaint_id = $this->db->insert_id();
        if($comlaint_id){

            // file uplaoding...
            if($_FILES['files']['size'][0] != 0){
                // var_dump();
                // exit;
        		$path = './uploads/images_uploaded_by_complainer/';
        		$title = $user_id;
        		$files = $_FILES['files'];
        		$uploads = $this->common_model->upload_files($path, $title, $files);
                // end upload process
                if(count($uploads) > 0){
                    foreach($uploads as $upload => $value){
                        $this->common_model->InsertData("complain_uploads", array("complainUploadName"=>$value, "complain_id"=>$comlaint_id));
                    }
                }
        	}
        // ends here
            
            $response["comlaint_msg"] = "You have successfully complained againt the school.";
        }
        
        echo json_encode($response);
        exit;
        
        
    }
    
        public function varify_account_by_code($user_id, $varification_code){
        $response = array();
	    $user_password_reset_code = $this->db->where('userId', $user_id)->get('users')->result()[0]->user_password_reset_code;
    	    if($user_password_reset_code == $varification_code){
    	        $updateData = array(
                    'userStatus' => 1
                );
    	        $this->db->where('userId', $user_id);
                $this->db->update('users', $updateData);
                $affected = $this->db->affected_rows();
                if($affected){
                    $response=array(
    					"success"=>1
    				);

                }else{
                    $response=array(
    					"success"=>0
    				
    				);
                }
    	    }else{
    	            $response=array(
    					"success"=>0
    				);

    	    }
            $this->load->view('mobile_apis/varify_account_by_code_view', $response);
        }
        public function get_complaint_list_by_cnic(){

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $cnic = $this->input->post('cnic');
        $data = array();
        $get_complains_list_by_cnic = "SELECT
                                        `complains`.`complain_id`
                                        , `complains`.`complain_type_id`
                                        , `complain_type`.`complainTypeTitle`
                                        , `complains`.`complainDetail`
                                        , `complains`.`school_id`
                                        , `schools`.`schoolName`
                                        , `complains`.`status_id`
                                        , `complain_process_status`.`statusTitle`
                                        , `complains`.`dated`
                                        , `complains`.`updatedDate`
                                        , `complains`.`district_id`
                                        , `district`.`districtTitle`
                                        , `complains`.`user_id`
                                    FROM
                                        `complains`
                                        LEFT JOIN `complain_type` 
                                            ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                                        LEFT JOIN `district` 
                                            ON (`complains`.`district_id` = `district`.`districtId`)
                                        LEFT JOIN `complain_process_status` 
                                            ON (`complains`.`status_id` = `complain_process_status`.`statusId`)
                                        LEFT JOIN `schools` 
                                            ON (`complains`.`school_id` = `schools`.`schoolId`)
                                        LEFT JOIN `users` 
                                            ON (`complains`.`user_id` = `users`.`userId`)
                                        WHERE `users`.`cnic`= '".$cnic."'";
				$result = $this->common_model->runQuery($get_complains_list_by_cnic);
                $data['cnic'] = $cnic;
                $data['complaint_list'] = $result;
                $this->load->view('mobile_apis/complaint_list_by_cnic', $data);
    }
    
    public function view_full_details_by_complaint_id(){

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        echo json_encode($this->input->post());
        exit;

    }
    
    public function add_feed_back_by_complaint_id(){

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $complaint_id = $this->input->post('complaint_id');
        $data = array();
        $data['complaint_id'] = $complaint_id;
        $this->load->view('mobile_apis/add_feedback_on_complaint', $data);

    }
    
    public function add_feed_back_by_complaint_id_process(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
        date_default_timezone_set("Asia/Karachi");
        $dated = date('Y-m-d H:i:s');
        $feedback = $this->input->post("feedback");
        $complaint_id = $this->input->post("complaint_id");
        $resolve_or_not = $this->input->post("resolve_or_not");

        $feedback_data = array(
            "complain_id"=> $complaint_id,
            "agree_or_not_agree"=> $resolve_or_not,
            "details"=> $feedback,
            "date"=> $dated
        );
        $this->db->insert("feedback_of_complains", $feedback_data);
        $data_inserted = $this->db->insert_id();
        $arr = array();
        if($data_inserted){
                $arr["status"] = TRUE;
                $arr['msg'] = '<div class="alert alert-success"><strong>Feedback Successfully Submitted.</strong>';
	        }else{
	            $arr["status"] = FALSE;
                $arr['msg'] = "<strong class='text-center'>Feedback Submission Error Try Again.</strong>";
                
            }
            echo json_encode($arr);
            exit();
    }
    
		
}

/* End of file Pos_apis.php */
/* Location: ./application/controllers/Pos_apis.php */