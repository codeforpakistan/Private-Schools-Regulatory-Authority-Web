<?php  

/**
*	Dashboard  
*/

class Complaints extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		// if ($this->session->userdata('validated') != TRUE) {
		// 	redirect(base_url().'LoginController');
		// }
		$this->load->model('complaints_m');

		
	}
	
	public function authorization(){
	    		if($this->session->userdata("userId") == NULL){
		         redirect("Complaints/login");
		        }
	}

	public function index(){
	    $this->authorization();
		$this->all_complaints();
		

	}
	
	
	public function complainants($id = 0){
	    $this->authorization();
		$per_page = 10;
		$function_name = __FUNCTION__;


        $this->db->where('role_id', 100);
		$query = $this->db->get('users');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "Complainants";

		$data['complainents_list'] = $this->complaints_m->get_complainent_list($role_id = 100, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/complainent_list_view', $data);
		$this->load->view('components/footer');

	}
	
	public function search_complainant_by_like(){
        $matchString = $this->input->post('matchString');
        $this->data['complainents_list'] = $this->complaints_m->search_complainant_by_like_m($matchString);
        // var_dump($this->data['$complainents_list']);
        // exit;
        $this->load->view('complaints/complainant_list_load_in_ajax', $this->data);
    }
	
	public function change_user_status($user_id, $status, $page_offset){
	     $update_data=array('userStatus'=> $status);
         $this->db->where('userId', $user_id);
         $this->db->update('users', $update_data);
         $affected_rows = $this->db->affected_rows();
         if($affected_rows > 0){
            $this->session->set_flashdata('msg_success', 'Complainent status successfully changed.');
	        redirect("Complaints/complainents/$page_offset");
        }else{
            $this->session->set_flashdata('msg_error', 'Complainent status udpate error, try again.');
	        redirect("Complaints/complainents/$page_offset");
        }
      
      
	}
	
	public function delete_complainent($user_id, $page_offset){

	    if(!empty($user_id)){
	        $this->db->delete('users', array('userId' => $user_id));
    	    $affected_rows = $this->db->affected_rows();
    	    if($affected_rows > 0){
                $this->session->set_flashdata('msg_success', 'Complainent successfully deleted.');
    	        redirect("Complaints/complainents/$page_offset");
            }else{
                $this->session->set_flashdata('msg_error', 'Complainent deletion error, try again.');
    	        redirect("Complaints/complainents/$page_offset");
            }
	    }else{
	           $this->session->set_flashdata('msg_error', 'Internal server error, try again.');
    	       redirect("Complaints/complainents/0");
	    }
	    
	}
	
// 	user portion starts here...
// **** user portion contains login and other tasks related to user... ****
    
    public function login(){
        $this->load->view('complaints/login');
    }

	public function login_process(){
	   
	   $validations = array(
	       array(
	           'field' =>  'userName',
	           'label' =>  'User Name',
	           'rules' =>  'required'
	       ),
	       array(
	           'field' =>  'password',
	           'label' =>  'Password',
	           'rules' =>  'required'
	       )
	   );

	   $this->form_validation->set_rules($validations);
	   if($this->form_validation->run() === TRUE){
	       
	       $input_values = array(
	           'userName' => $this->input->post("userName"),
	           'userPassword' => $this->input->post("password"),
	           'userStatus' => 1
	       );
	       
	       $user = $this->db->where($input_values)->get('users')->result();

	       if(count($user) > 0){  
	           $user = $user[0];
	           $user_data = array(
	               "userId" => $user->userId,
	               "userTitle" => $user->userTitle,
	               "userEmail" => $user->userEmail,
	               "gender" => $user->gender,
	               "role_id" => $user->role_id,
	               "logged_in" => TRUE,
	               'district_id' => $user->district_id,
	               'cnic' => $user->cnic,
	               'createdDate' => $user->createdDate,
	               'contactNumber' => $user->contactNumber	              
	           );
	           //add to session
	           $this->session->set_userdata($user_data);
	           $this->session->set_flashdata('msg_success', "<strong>".$user->userTitle.'</strong><br/><i>welcome to admin panel</i>');
	           redirect("Complaints");
	       }else{

	           $this->session->set_flashdata('msg_error', 'User-Name or password is incorrect, Please try again.');
	           redirect("Complaints/login");
	       }
	   }else{
	       $this->data['title'] = "Login to dashboard";
	       $this->load->view("Complaints/login", $this->data);
	   }
	}

	public function logout(){
	   $this->session->sess_destroy();
	   redirect("Complaints/login");
	}
// 	user portion ends here


	public function all_complaints($id = 0)
	{
	    $this->authorization();
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();

		// pagination code is executed and dispaly pagination in view
		$this->load->library('pagination');
			$config = [
				'base_url'  =>  base_url('Complaints/all_complaints'),
				'per_page'  =>  10,
				'total_rows' => $number_of_rows,
				'full_tag_open' =>  '<ul class="pagination pagination-sm">',
				'full_tag_close'  =>    '</ul>',
				'first_tag_open'    =>  '<li>',
				'first_tag_close'  =>   '</li>',
				'last_tag_open' =>  '<li>',
				'last_tag_close'  =>    '</li>',
				'next_tag_open' =>  '<li>',
				'next_tag_close'  =>    '</li>',
				'prev_tag_open' =>  '<li>',
				'prev_tag_close'  =>    '</li>',
				'num_tag_open'  =>  '<li>',
				'num_tag_close'  => '</li>',
				'cur_tag_open'  =>  '<li class="active"><a>',
				'cur_tag_close'  => '</a></li>'
			];
	  
		$this->pagination->initialize($config);
		// this if is used for after deletion redirect...
		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	  
		$data['complaints'] = $this->complaints_m->all_complaints_m($config['per_page'], $offset);
        $data['title'] = "All Complaints";
	    $data['desc'] = "";
		$this->load->view('components/header');
		$this->load->view('complaints/all_complaints', $data);
		$this->load->view('components/footer');

	}

	private function paginations_for_fun($number_of_rows, $per_page, $function_name)
	{

		// pagination code is executed and dispaly pagination in view
		$this->load->library('pagination');
			$config = [
				'base_url'  =>  base_url('Complaints/').$function_name,
				'per_page'  =>  $per_page,
				'total_rows' => $number_of_rows,
				'full_tag_open' =>  '<ul class="pagination pagination-sm">',
				'full_tag_close'  =>    '</ul>',
				'first_tag_open'    =>  '<li>',
				'first_tag_close'  =>   '</li>',
				'last_tag_open' =>  '<li>',
				'last_tag_close'  =>    '</li>',
				'next_tag_open' =>  '<li>',
				'next_tag_close'  =>    '</li>',
				'prev_tag_open' =>  '<li>',
				'prev_tag_close'  =>    '</li>',
				'num_tag_open'  =>  '<li>',
				'num_tag_close'  => '</li>',
				'cur_tag_open'  =>  '<li class="active"><a>',
				'cur_tag_close'  => '</a></li>'
			];
	  
		$this->pagination->initialize($config);
	}

	public function received($id = 0)
	{	
	    $this->authorization();
		$status_id = 1;
		$per_page = 10;
		$function_name = __FUNCTION__;


        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "Recieved";
	    $data['desc'] = "";
	    $data['db_column_name'] = "firstLetterSentDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_1_complaints', $data);
		$this->load->view('components/footer');
		// var_dump($data['complaints']);
		
	}

	public function first_letter($id = 0)
	{
	    $this->authorization();
		$status_id = 2;
		$per_page = 10;
		$function_name = __FUNCTION__;

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "First Letter";
	    $data['desc'] = "";
	    $data['db_column_name'] = "finalNoticeSentDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_2_complaints', $data);
		$this->load->view('components/footer');
		
	}
	public function second_letter($id = 0)
	{
        $this->authorization();
		$status_id = 3;
		$per_page = 10;
		$function_name = __FUNCTION__;

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);


		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
		
	    $data['title'] = "Second Letter";
	    $data['desc'] = "";
	    $data['db_column_name'] = "summonIssuedDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_3_complaints', $data);
		$this->load->view('components/footer');
	}
	public function summon($id = 0)
	{
        $this->authorization();
		$status_id = 4;
		$per_page = 10;
		$function_name = __FUNCTION__;


        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);


		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "Summon Issued";
	    $data['desc'] = "";
	  	$data['db_column_name'] = "resolvedDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_4_complaints', $data);
		$this->load->view('components/footer');
	}

	public function fine($id = 0)
	{
	    $this->authorization();
	    $status_id = 6;
		$per_page = 10;
		$function_name = __FUNCTION__;

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "Fine";
	    $data['desc'] = "";
	    $data['db_column_name'] = "bankAccountSealedDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_5_complaints', $data);
		$this->load->view('components/footer');
	}
	
		public function second_fine($id = 0)
	{
	    $this->authorization();
		$status_id = 5;
		$per_page = 10;
		$function_name = __FUNCTION__;
		$columnDate = "fineDate";

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "Second Fine";
	    $data['desc'] = "";
	  	$data['db_column_name'] = "fineDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_6_complaints', $data);
		$this->load->view('components/footer');
	}
	public function fine_collections($id = 0)
	{
	    $this->authorization();
	    $status_id = 7;
		$per_page = 10;
		$function_name = __FUNCTION__;

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    $data['title'] = "Fine Collections and Requisition";
	    $data['desc'] = "";
	    $data['db_column_name'] = "registrationCancelledDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_7_complaints', $data);
		$this->load->view('components/footer');
	}

	public function registration_cancelled($id = 0)
	{
	    $this->authorization();
	    $status_id = 8;
		$per_page = 10;
		$function_name = __FUNCTION__;

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
		
	  	$data['title'] = "Registration Cancelled";
	    $data['desc'] = "";
	    $data['db_column_name'] = "noResponseDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_8_complaints', $data);
		$this->load->view('components/footer');
	}

	public function resolved($id = 0)
	{
	    $this->authorization();
		$status_id = 9;
		$per_page = 10;
		$function_name = __FUNCTION__;

        $this->db->where('status_id', $status_id);
		$query = $this->db->get('complains');
		$number_of_rows = $query->num_rows();
		$this->paginations_for_fun($number_of_rows, $per_page, $function_name);

		if(empty($id)){
			$offset = $this->uri->segment(3,0);
		}else{
			$offset = $id;
		}
	    
	    $data['title'] = "Resolved";
	    $data['desc'] = "";
	    $data['db_column_name'] = "firstLetterSentDate";
		$data['complaints'] = $this->complaints_m->get_complaints_by_status_id($status_id, $per_page, $offset);
        $data['func_name'] = __FUNCTION__;
		$this->load->view('components/header');
		$this->load->view('complaints/status_9_complaints', $data);
		$this->load->view('components/footer');
	}


	public function change_status()
	{	
		$complain_id =  $this->input->post('id');
		$this->data['func_name'] = $this->input->post('func_name');
		$this->data['db_column_name'] = $this->input->post("db_column_name");
		$this->data['statuses'] = $this->db->where('statusId >', 1)->get('complain_process_status')->result();
// 		var_dump($this->data['statuses']);
// 		exit;
		$feedbacks = $this->db->where('complain_id', $complain_id)->get('feedback_of_complains')->result();
		$complain_details = $this->complaints_m->get_complaint_id($complain_id)[0];
		$complain_details->feedback = $feedbacks; 
		$this->data['comp'] = $complain_details;
		$this->load->view('complaints/complaint_process_modal_view', $this->data);
	}

	public function change_status_process()
	{	
	    $days = $this->input->post('complainent_feedback_day');
	    date_default_timezone_set("Asia/Karachi");
	    $dated = date('Y-m-d H:i:s');
	    
	    $feedback_date=date_create($dated);
        $feedback_date = date_add($feedback_date,date_interval_create_from_date_string("$days days"));
        $feedback_date = date_format($feedback_date,"Y-m-d H:i:s");

	    $db_column_name = $this->input->post('db_column_name');
        $status_id = $this->input->post('status_id');
        $complain_id = $this->input->post('complain_id');
        $function_redirection = $this->input->post('function_redirection');
        
		if(isset($_FILES['files'])){
			$path = './uploads/images_uploaded_by_complainer/';
			$title = "user_id";
			$files = $_FILES['files'];
			$uploads = $this->complaints_m->upload_files($path, $title, $files);
			
	        // end upload process
	        foreach($uploads as $upload => $value){
	            $this->db->insert("complain_status_wise_attachment", array("status_id"=> $status_id,"process_file_name"=>$value, "complain_id"=>$complain_id));
	        }
	        $insert_id = $this->db->insert_id();
	        if($insert_id){
                $data = array(
                    "status_".$status_id."_date" => $dated,
                    'status_id' => $status_id,
                    'updatedDate' => $feedback_date
                );
                
                $where = array('complain_id'=> $complain_id);
                $affected_rows = $this->complaints_m->update_record($where, $table ="complains", $data);
                if($affected_rows){
                    // notification code start ...
                    $user_id = $this->db->where('complain_id', $complain_id)->get('complains')->result()[0]->user_id;
                    $token_key = $this->db->where('userId', $user_id)->get('users')->result()[0]->token_key;
                    $this->complaints_m->send_notification($token_key, $complain_id, $title ="title", $message ="msg");
                    // end notification ...
                    $this->session->set_flashdata('msg_success', "Complain processed successfully.");
                    redirect("Complaints/$function_redirection");
                }else{
                $this->session->set_flashdata('msg_error', "unable to process complaint.");
                redirect("Complaints/$function_redirection");
                $arr["status"] = FALSE;
                $arr['msg'] = "<strong class='text-center'></strong>";
                }
                    // $arr["msg"] = validation_errors();

	        }else{
	            $arr["status"] = FALSE;
                $arr['msg'] = "<strong class='text-center'>Files uploading error occured.</strong>";
	        }

	    
		}else{
		    $arr['msg'] = "<strong class='text-center text-danger'>file uploading is failed.</strong>";
		}
        
        echo json_encode($arr);
        exit();
	}
	
	public function get_attachments_by_complain_id(){
	    $complain_id = $this->input->post('id');
	    $this->data['complainent_files_list'] = $this->complaints_m->get_complainent_files_list_by_complain_id($complain_id);
	    $this->data['attachments'] = $this->complaints_m->get_files_list_by_complain_id($complain_id);
	    
	   // $this->data['attachments'];
	    $this->load->view('complaints/load_attachment_in_modal_view', $this->data);
	}
	
	
	public function delete_record_by_id(){

            $id = $this->input->post('id');
            $id_column_name= $this->input->post('column_id_name');
            $table = $this->input->post('table');
            $file_column_name = $this->input->post('file_column_name');
            
            $where = array("$id_column_name" => $id);
            $affected_rows = $this->complaints_m->delete_record_by_id_m($where, $table, $file_column_name);
            if($affected_rows > 0){
                $arr["status"] = TRUE;
                $arr['msg'] = "<strong class='text-center'></strong>";
                // $arr["msg"] = validation_errors();

	        }else{
	            $arr["status"] = FALSE;
                $arr['msg'] = "<strong class='text-center'>Files uploading error occured.</strong>";
                
            }
            echo json_encode($arr);
            exit();
	}
	
	public function insert_dummy_data_in_complaints_table(){
	    echo "reached...";
	    exit;
	    date_default_timezone_set("Asia/Karachi");
	    $date = date('Y-m-d H:i:s');

        $date = strtotime($date);
        // $minus_year = mt_rand(0,5);
        // $minus_days = mt_rand(1,28);
        // $newdate = date('Y-m-d H:i:s',strtotime("-$minus_year year",$date));
        // echo $newdate;
        // exit;
        // $dated = $newdate;
	   // $dated = date("d-m-Y h:i:sa");
	    
	    
	    for($i = 0; $i<8000; $i++){
	   // $minus_year = mt_rand(0,5);
	    $minus_days = mt_rand(1,600);
        $dated = date('Y-m-d H:i:s',strtotime("-$minus_days day",$date));
	    $complain_type_random_id = mt_rand(1,6);
	    $district_id = mt_rand(1,32);
	    $status_id = mt_rand(2,9);
	    $user_id = mt_rand(16, 119);
	    $school_id = mt_rand(1,222);
	    $rand_array =  mt_rand(0,1);
        $arr = array("Mobile","Website");
	    $complaint_from = $arr[$rand_array];
	    $data = array(
	        "complain_type_id" => $complain_type_random_id,
	        "complainDetail" => "Details",
	        "user_id" => $user_id,
	        "school_id"=>$school_id,
	        "status_id"=>$status_id,
	        "dated"=>$dated,
	        "endDate"=>$dated,
	        "complainFrom"=>$complaint_from,
	        "district_id"=> $district_id,
	        "schoolAddress"=>"school address",
	        "status_".$status_id."_date"=> $dated
	        
	        );
	   $this->db->insert('complains', $data);
	}
	
	}
	
	public function dashboard(){
	    $this->authorization();
	    $data['title'] = "Dashboard";
	    $data['desc'] = "";
	    $data['total_complaints'] = $this->db->count_all('complains');
	    $data['total_complaints_by_type'] = $this->complaints_m->get_total_number_of_complaints_type();
	    $data['total_complaints_by_district'] = $this->complaints_m->get_total_number_of_complaints_by_districts();
	    
	    $data['last_five_year'] = $this->complaints_m->last_five_year();
	    $data['last_seven_days'] = $this->complaints_m->last_seven_days();
	    $data['current_year_report'] = $this->complaints_m->current_year_report();
	    $data['daily_report_of_one_month'] = $this->complaints_m->daily_report_of_one_month();
	    $data['monthly_report'] = $this->complaints_m->monthly_report();
	    $data['status_wise'] = $this->complaints_m->status_wise_report();
	   // echo "<pre />";
	   // var_dump($data);
	   // exit;
	   // whole month record by complaint_type
	   //SELECT COUNT(`complain_id`) AS total_complaints, `complain_type_id` FROM `complains` WHERE  dated between  DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND CURDATE() AND CURDATE( ) GROUP BY complain_type_id;
	   
	   //whole month record by daily complaints list
	   //SELECT COUNT(`complain_id`) AS total_complaints, `complain_type_id`, DAYNAME(`dated`) AS day_name_here, DATE(dated) AS date_figure FROM `complains` WHERE dated between DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND CURDATE() GROUP BY date_figure ORDER BY date_figure DESC
	   
	   //whole year
	   //SELECT COUNT(`complain_id`) AS total_complaints, `complain_type_id` FROM `complains` WHERE  dated between  DATE_FORMAT(CURDATE() ,'%Y-01-01') AND CURDATE() GROUP BY complain_type_id;
	   
	   //last 7 days complaints list 
	   //SELECT COUNT(`complain_id`) AS total_complaints, `complain_type_id`, DAYNAME(`dated`) AS day_name_here, DATE(dated) AS date_figure FROM `complains` WHERE dated >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY day_name_here ORDER BY date_figure DESC
	
	   // last five year 
	   //SELECT COUNT(`complain_id`) AS total_complaints, `complain_type_id`, YEAR(`dated`) AS day_name_here FROM `complains` WHERE dated BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 5 YEAR ) AND CURDATE( ) GROUP BY day_name_here ORDER BY date_figure DESC
	   
	    $this->load->view('components/header');
		$this->load->view('complaints/dashboard', $data);
		$this->load->view('components/footer');
	}
	
	
	public function send_notify(){
	    $token_key = $this->input->post('token_key');
	    echo json_encode($this->complaints_m->send_notification($token_key));
	    exit;
	}


	
}

?>