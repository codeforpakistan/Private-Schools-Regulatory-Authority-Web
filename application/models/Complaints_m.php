<?php
/**
*
*/
class Complaints_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	public function get_complainent_list($role_id, $limit, $offset){

        $query = "SELECT 
                      `users`.`userId`,
                      `users`.`role_id`,
                      `users`.`userTitle`,
                      `users`.`userName`,
                      `users`.`userPassword`,
                      `users`.`userEmail`,
                      `users`.`user_password_reset_code`,
                      `users`.`userStatus`,
                      `users`.`gender`,
                      `users`.`cnic`,
                      `users`.`contactNumber`,
                      `users`.`district_id`,
                      `district`.`districtTitle`,
                      `users`.`createdDate`,
                      `users`.`address` 
                    FROM
                      `users` 
                      INNER JOIN `district` 
                        ON (
                          `users`.`district_id` = `district`.`districtId`
                        ) 
                    WHERE `users`.`role_id` = '".$role_id."'
                            ORDER BY `users`.`userId` DESC
                            LIMIT ".$limit." OFFSET ".$offset.";";
        return $this->db->query($query)->result();
        // var_dump($this->db->query($query)->result());
        // exit;
    }
    
    public function search_complainant_by_like_m($matchString){

        $query = "SELECT 
                      `users`.`userId`,
                      `users`.`role_id`,
                      `users`.`userTitle`,
                      `users`.`userName`,
                      `users`.`userPassword`,
                      `users`.`userEmail`,
                      `users`.`user_password_reset_code`,
                      `users`.`userStatus`,
                      `users`.`gender`,
                      `users`.`cnic`,
                      `users`.`contactNumber`,
                      `users`.`district_id`,
                      `district`.`districtTitle`,
                      `users`.`createdDate`,
                      `users`.`address` 
                    FROM
                      `users` 
                      INNER JOIN `district` 
                        ON (
                          `users`.`district_id` = `district`.`districtId`
                        ) 
                    WHERE `users`.`userTitle` LIKE '%$matchString%'";
        return $this->db->query($query)->result();
        // var_dump($this->db->query($query)->result());
        // exit;
    }
	
	function all_complaints_m($limit, $offset){
        $query = "SELECT
        `complains`.`user_id`
        , `users`.`userTitle`
        , `users`.`userEmail`
        , `users`.`cnic`
        , `users`.`contactNumber`
        , `district`.`districtTitle`
        , `complain_type`.`complainTypeTitle`
        , `complains`.`complain_type_id`
        , `complains`.`complainDetail`
        , `complains`.`complainFrom`
        , `complains`.`dated`
        , `complains`.`endDate`
        , `complains`.`updatedDate`
        , `complains`.`schoolAddress`
        , `complain_process_status`.`statusTitle`
        , `schools`.`schoolName`
        , `schools`.`telePhoneNumber`
        , `schools`.`schoolMobileNumber`
    FROM
        `complains`
        LEFT JOIN `users` 
            ON (`complains`.`user_id` = `users`.`userId`)
        LEFT JOIN `complain_process_status` 
            ON (`complains`.`status_id` = `complain_process_status`.`statusId`)
        LEFT JOIN `complain_type` 
            ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
        LEFT JOIN `schools` 
            ON (`complains`.`school_id` = `schools`.`schoolId`)
        LEFT JOIN `district` 
            ON (`users`.`district_id` = `district`.`districtId`)
             ORDER BY `complains`.`complain_id` DESC
        LIMIT ".$limit." OFFSET ".$offset.";";
        return $this->db->query($query)->result();
    }

        function get_complaint_id($complain_id){
            $query = "SELECT
            `complains`.`complain_id`
            ,`complains`.`user_id`
            ,`complains`.`status_id`
            , `users`.`userTitle`
            , `users`.`userEmail`
            , `users`.`cnic`
            , `users`.`contactNumber`
            , `district`.`districtTitle`
            , `complain_type`.`complainTypeTitle`
            , `complains`.`complain_type_id`
            , `complains`.`complainDetail`
            , `complains`.`complainFrom`
            , `complains`.`dated`
            , `complains`.`endDate`
            , `complains`.`updatedDate`
            , `complains`.`schoolAddress`
            , `complain_process_status`.`statusTitle`
            , `schools`.`schoolName`
            , `schools`.`telePhoneNumber`
            , `schools`.`schoolMobileNumber`
        FROM
            `complains`
            LEFT JOIN `users` 
                ON (`complains`.`user_id` = `users`.`userId`)
            LEFT JOIN `complain_process_status` 
                ON (`complains`.`status_id` = `complain_process_status`.`statusId`)
            LEFT JOIN `complain_type` 
                ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
            LEFT JOIN `schools` 
                ON (`complains`.`school_id` = `schools`.`schoolId`)
            LEFT JOIN `district` 
                ON (`users`.`district_id` = `district`.`districtId`)
                WHERE `complains`.`complain_id` = ".$complain_id.";";
            return $this->db->query($query)->result();
        }

    public function get_complaints_by_status_id($status_id, $limit, $offset)
    {
        $query = "SELECT
        `complains`.`complain_id`
        ,`complains`.`user_id`
        , `users`.`userTitle`
        , `users`.`userEmail`
        , `users`.`cnic`
        , `users`.`contactNumber`
        , `district`.`districtTitle`
        , `complain_type`.`complainTypeTitle`
        , `complains`.`complain_type_id`
        , `complains`.`complainDetail`
        , `complains`.`complainFrom`
        , `complains`.`dated`
        , `complains`.`status_2_date`
        , `complains`.`status_3_date`
        , `complains`.`status_4_date`
        , `complains`.`status_5_date`
        , `complains`.`status_6_date`
        , `complains`.`status_7_date`
        , `complains`.`status_8_date`
        , `complains`.`status_9_date`
        , `complains`.`endDate`
        , `complains`.`updatedDate`
        , `complains`.`schoolAddress`
        , `complain_process_status`.`statusTitle`
        , `schools`.`schoolName`
        , `schools`.`telePhoneNumber`
        , `schools`.`schoolMobileNumber`
    FROM
        `complains`
        LEFT JOIN `users` 
            ON (`complains`.`user_id` = `users`.`userId`)
        LEFT JOIN `complain_process_status` 
            ON (`complains`.`status_id` = `complain_process_status`.`statusId`)
        LEFT JOIN `complain_type` 
            ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
        LEFT JOIN `schools` 
            ON (`complains`.`school_id` = `schools`.`schoolId`)
        LEFT JOIN `district` 
            ON (`users`.`district_id` = `district`.`districtId`)
        WHERE `complains`.`status_id` = '".$status_id."'
        ORDER BY `complains`.`complain_id` DESC
        LIMIT ".$limit." OFFSET ".$offset.";";
        return $this->db->query($query)->result();
        // var_dump($this->db->query($query)->result());
        // exit;
    }


    //  my file uploads multiple method...
        public function upload_files($path, $title, $files)
        {
            $config = array(
                'upload_path'   => $path,
                'allowed_types' => 'jpg|gif|png|jpeg',
                'overwrite'     => 1,                       
            );

            $this->load->library('upload', $config);

            $images = array();

            foreach ($files['name'] as $key => $image) {
                $_FILES['images[]']['name']= $files['name'][$key];
                $_FILES['images[]']['type']= $files['type'][$key];
                $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
                $_FILES['images[]']['error']= $files['error'][$key];
                $_FILES['images[]']['size']= $files['size'][$key];

                $fileName = $title ."_".rand()."_". $image;

                $images[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('images[]')) {
                    $this->upload->data();
                } else {
                    return false;
                }
            }

            return $images;
        }
        
    // update status of compalain
    public function update_record($where, $table, $data){

	        $this->db->where($where);
	        $Update = $this->db->update($table, $data);
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
    }
    
        // delete record by id and pass table name with file name
    public function delete_record_by_id_m($where, $table, $file_column_name =''){
            if($file_column_name != ''){
            $attachment = $this->db->where($where)->get($table)->result()[0]->$file_column_name;
            unlink(FCPATH."uploads/images_uploaded_by_complainer/".$attachment);
            }
	        $this->db->where($where);
            $this->db->delete($table);
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
    }
    
    public function get_files_list_by_complain_id($complain_id){
        $query = "SELECT
                        `complain_status_wise_attachment`.`complain_status_wise_attachment_id`
                        , `complain_status_wise_attachment`.`process_file_name`
                        , `complain_status_wise_attachment`.`status_id`
                        , `complain_process_status`.`statusTitle`
                        , `complain_status_wise_attachment`.`complain_id`
                    FROM
                        `complain_process_status`
                        INNER JOIN `complain_status_wise_attachment` 
                            ON (`complain_process_status`.`statusId` = `complain_status_wise_attachment`.`status_id`)
                            WHERE `complain_id` = ".$complain_id.";";
        // $query = "SELECT * FROM `complain_status_wise_attachment`;";
        
            return $this->db->query($query)->result();
    }
    
    public function get_complainent_files_list_by_complain_id($complain_id){
        $query = "SELECT * FROM `complain_uploads` WHERE `complain_id` = ".$complain_id.";";
            return $this->db->query($query)->result();
    }
    
    
    public function get_total_number_of_complaints_type(){
        $complaint_type = $this->db->select("complainTypeId, complainTypeTitle")->get('complain_type')->result();
        foreach($complaint_type as $c_type){
            $query = "SELECT
                        COUNT(`complain_type_id`) AS complain_type_count
                    FROM
                        `complains`
                        WHERE `complain_type_id` = '".$c_type->complainTypeId."';";
                    $c_type->complain_type_count =  $this->db->query($query)->result()[0]->complain_type_count;
                    
            
        }
        return $complaint_type;

    }
    
        public function get_total_number_of_complaints_by_districts(){

        $districts_list = $this->db->select("districtId, districtTitle")->get('district')->result();
        foreach($districts_list as $district){
            $query = "SELECT
                        COUNT(`district_id`) AS district_count
                    FROM
                        `complains`
                        WHERE `district_id` = '".$district->districtId."';";
                    $district->district_count =  $this->db->query($query)->result()[0]->district_count;
                    
            
        }
        return $districts_list;

    }
    
    
    public function monthly_report(){

        
            $query = "SELECT 
                         `complain_type`.`complainTypeTitle`,
                          COUNT(`complain_id`) AS total_complaints,
                          `complain_type_id` 
                        FROM
                          `complains` 
                          INNER JOIN `complain_type` 
                        ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                        WHERE dated BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                          AND CURDATE() 
                          AND CURDATE() 
                        GROUP BY complain_type_id ;";
            return $this->db->query($query)->result();
    }
    
    
    public function daily_report_of_one_month(){

        
            $query = "SELECT 
                         `complain_type`.`complainTypeTitle`,
                          COUNT(`complain_id`) AS total_complaints,
                          `complain_type_id`,
                          DAYNAME(`dated`) AS day_name_here,
                          DATE(dated) AS date_figure 
                        FROM
                          `complains` 
                          INNER JOIN `complain_type` 
                        ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                        WHERE dated BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                          AND CURDATE() 
                        GROUP BY date_figure 
                        ORDER BY date_figure DESC;";
            return $this->db->query($query)->result();
    }
    
    public function current_year_report(){

        
            $query = "SELECT 
                      `complain_type`.`complainTypeTitle`,
                      COUNT(`complain_id`) AS total_complaints,
                      MONTHNAME(`dated`) as month_name,
                      `complain_type_id` 
                    FROM
                      `complains`
                    INNER JOIN `complain_type` 
                        ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                    WHERE dated BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01') 
                      AND CURDATE() 
                    GROUP BY month_name, `complains`.`complain_type_id` order by dated, `complains`.`complain_type_id` desc ;";
            return $this->db->query($query)->result();
    }
    
    public function last_seven_days(){

        
            $query = "SELECT 
                          `complain_type`.`complainTypeTitle`,
                          COUNT(`complain_id`) AS total_complaints,
                          `complain_type_id`,
                          DAYNAME(`dated`) AS day_name_here,
                          DATE(dated) AS date_figure 
                        FROM
                          `complains`
                        INNER JOIN `complain_type` 
                        ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                        WHERE dated >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
                        GROUP BY day_name_here 
                        ORDER BY date_figure DESC;";
            return $this->db->query($query)->result();
    }
    
    public function last_five_year(){

        
            $query = "SELECT 
                      `complain_type`.`complainTypeTitle`,
                      COUNT(`complain_id`) AS total_complaints,
                      `complain_type_id`,
                      YEAR(`dated`) AS year_of 
                    FROM
                      `complains`
                    INNER JOIN `complain_type` 
                    ON (`complains`.`complain_type_id` = `complain_type`.`complainTypeId`)
                    WHERE dated BETWEEN DATE_SUB(CURDATE(), INTERVAL 5 YEAR) 
                      AND CURDATE() 
                    GROUP BY year_of;";
            return $this->db->query($query)->result();
    }
    
    public function status_wise_report(){
        $get_status  = "SELECT 
                          `statusId`,
                          `statusTitle` 
                        FROM
                          `complain_process_status` 
                        WHERE statusId IN (1, 2, 3, 4, 5, 6, 7, 8, 9);";
        $status_list = $this->db->query($get_status)->result();
        foreach($status_list as $list_item){
            $query = "SELECT
                            `complains`.`status_id`
                            , COUNT(`complains`.`complain_id`) AS total_complaints_on_status
                        FROM
                            `complains`
                            INNER JOIN `complain_process_status` 
                                ON (`complains`.`status_id` = `complain_process_status`.`statusId`) WHERE `complains`.`status_id` = '". $list_item->statusId."';";
                                $query_result = $this->db->query($query)->result();

            $list_item->total_complaint = $query_result[0]->total_complaints_on_status;
        }
        //  var_dump($status_list);
        //  exit;
        return $status_list;
    }
    
      //  select `complain_type`.`complainTypeTitle`
	   //  INNER JOIN `complains` 
    //     ON (`complain_type`.`complainTypeId` = `complains`.`complain_type_id`);
    
    
    
    public function send_notification($gcm_id= "dqeWHpsMiVs:APA91bHx4M50Om3fRqGBF3b9dzjmMh1v6lTaHxcBb1oajkJo88M3mOZ0Aqqb2GVDK3jNm8Y4LW9mAWzCzPa-toL0hS4zkm6nY1z6Z0cQ0rwEh-nTk2IFaD25-JPld0wd-dffn4JmmH14", $complaint_id="1", $title="title", $message="msg"){

          define( 'API_ACCESS_KEY', 'AAAAHJlhfTw:APA91bFDv64vZkfKeDcfY0LNJnWpEmWXC5CqzkXDqpJLHhloamRLRDAT-Chrf1kD6BpRpgdbbfzR6kvfW5S4YGQPBfBwWyfvGqR7B8MIo-RH_JLu8ujy31vkO7O8jcpH2gf-yvY6clDN' );
          
          $query_for_sending_data_in_notification = "SELECT
                                                `complains`.`complain_id`
                                                , `complain_type`.`complainTypeTitle`
                                                , `complains`.`complainDetail`
                                                , `complain_process_status`.`statusTitle`
                                            FROM
                                                `complain_type`
                                                INNER JOIN `complains` 
                                                    ON (`complain_type`.`complainTypeId` = `complains`.`complain_type_id`)
                                                INNER JOIN `complain_process_status` 
                                                    ON (`complain_process_status`.`statusId` = `complains`.`status_id`)
                                                 WHERE `complains`.`complain_id` ='". $complaint_id ."';";
        $data = $this->db->query($query_for_sending_data_in_notification)->result()[0];
        //   $data = $this->db->where('complain_id', $complaint_id)->get('complains')->result()[0];
        date_default_timezone_set("Asia/Karachi");
        $dated = date('Y-m-d');
        $data->date = $dated;
        $data->complainDetail = "Your complaint has further processed.";
        $data->notificationId = mt_rand(1,999);
          $msg = array
          (
          'complain_data' => $data,
          'icon'    => 'myicon',/*Default Icon*/
          'sound' => 'mySound',/*Default sound*/
          'vibrate' => 1,
           // activity name which will be called after notify  
          'click_action' => 'DetailListActivity'
        
        //   //'icon'  => 'myicon',/*Default Icon*/
        
        //  //  'sound' => 'mySound'/*Default sound*/
        
            );
          
        //   $msg = array
        
        //          (
        
        //   'body'  => $message,
        
        //   'title' => $title,
        
        //   'post_id' => $post_id,
        
        //   //'icon'  => 'myicon',/*Default Icon*/
        
        //  //  'sound' => 'mySound'/*Default sound*/
        
        //          );
        
         $fields = array
        
             (
        
               'to'    => $gcm_id,
                       
                'msg'  => $message,
        
                'title' => $title,
        
                'data'  => $msg
        
             );
        
        
        
        
        
         $headers = array
        
             (
        
               'Authorization: key=' . API_ACCESS_KEY,
        
               'Content-Type: application/json'
        
             );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $fields;
                
                
    }
    
    
    
}
?>
