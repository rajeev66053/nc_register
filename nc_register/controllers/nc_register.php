<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class nc_register extends MX_Controller {

    public $data;
	function __construct(){
	       

	        parent::__construct();
            $this->load->model('nc_register_model');
            $this->load->model('ppo/ppo_model');
            $this->load->model('staff/staff_model');
            $this->load->model('department/department_model');

	        $this->load->helper(array(
	            'form'
	        ));

	        $this->data['global_notification'] = $this->nc_register_model->get_notification(array('user_id' => $this->session->userdata('staff_id'),'limit'=> 10));
	       $this->data['unseen_notification'] = $this->nc_register_model->get_notification(array('user_id' => $this->session->userdata('staff_id'),'seen'=> 0));
		      $this->data['unseen'] = count($this->data['unseen_notification']);
	}

  public function index(){
          
           $this->data['tickets'] = $this->nc_register_model->get_ticket(array('is_verified'=> 1,'is_closed'=> 0));
       
           $this->data['template'] = 'nc_register/index';	
	         $this->load->view('common/nc_main',$this->data);

    }


  public function nc_ticket_raise(){

	  	
	        
		    $this->data['department'] = $this->department_model->get_departments();
		    $this->data['objective']  = $this->ppo_model->get_all_iso();
		    $this->data['template'] = 'nc_register/nc_ticket_add';	
		    $this->load->view('common/nc_main',$this->data);
  }


   public function nc_ticket_add(){

			$data = array(
					'ref_num' => $this->input->post('ref_num'),
					'objective_id' => $this->input->post('objective_id'),
					'details' => $this->input->post('details'),
					'impact' => $this->input->post('impact'),
					'user_id' =>$this->session->userdata('staff_id'),
					'is_accepted' => 0,
					'is_closed' => 0,
					'is_verified' => 0,
					'is_rejected' =>0,
					'is_forwarded' => 0,
					'parent_id' => 0,
					'dept_id' => $this->input->post('dept_id'),
					'date' => time()
			);
			
			$this->db->insert('nc_ticket',$data);
            $last_insert_id = $this->db->insert_id();
 		    

 		    //get the staff info of the department head
            $staff_info = $this->staff_model->get_staffs_official_information(array('staff_id'=>$this->session->userdata('staff_id')));
            
            //get the department head_id
            $department_head = $this->department_model->get_departments(array('dpt_id' => $staff_info[0]['department_id']));
 				
            //add the notification for verfication
			$notification=array(
			    
			    'ticket_id' => $last_insert_id,
				'user_id' =>$department_head[0]['hod'],
				'description'=>'There is an NC ticket for verification',
				'seen' => 0,
				'type' =>0,
				'date' => time()
		    );

 			$this->db->insert('nc_ticket_notification',$notification);
      redirect('nc_register');

			

  }
     public function notification($id=null){

     		    //update the notification to seen
 		        $this->db->where('id',$id);
 		        $this->db->update('nc_ticket_notification',array('seen'=>1));

 		        //get the notification information from the notification id
 		        $notification= $this->nc_register_model->get_notification(array('id' => $id ));

 		        //get the ticket info from the $notification
 		        $this->data['ticket'] =  $this->nc_register_model->get_ticket(array('id'=>$notification[0]['ticket_id']));
            $this->data['notification'] = $notification;
            if($notification[0]['type'] == 0){
 		           
                $this->data['template'] = "nc_register/notification_verify";
 		        
            }
 		        elseif($notification[0]['type'] == 1){
                      
                $this->data['departments'] = $this->department_model->get_departments();
                $parent_ticket = $this->nc_register_model->get_ticket(array('id' => $this->data['ticket'][0]['parent_id']));
                if(!empty($parent_ticket)){

                      $this->data['forward_log'] = $this->nc_register_model->get_nc_ticket_forwarded(array('ticket_id'=>$parent_ticket[0]['id']));

                }
               /* echo '<pre>'; 
                print_r($this->data);
                echo '</pre>';*/
 		        	  $this->data['template'] = "nc_register/notification_commit";

 		        }
 		        elseif($notification[0]['type'] == 2){
                      
                $this->data['rejected_log'] =  $this->nc_register_model->get_nc_ticket_rejected(array('ticket_id'=>$notification[0]['ticket_id']));
 		        	  $this->data['template'] = "nc_register/notification_review";
            
            }
            elseif($notification[0]['type'] == 3){

                $this->data['accepted_log'] = $this->nc_register_model->get_nc_ticket_accepted(array('ticket_id'=>$notification[0]['ticket_id']));
                $this->data['template'] = "nc_register/notification_accept_verify";
            }
            elseif($notification[0]['type'] == 4){
                      
                $this->data['accepted_log'] = $this->nc_register_model->get_nc_ticket_accepted(array('ticket_id'=>$notification[0]['ticket_id']));
                $this->data['template'] = "nc_register/notification_accept";
                     
            }
            elseif($notification[0]['type'] == 5){
                      
                $this->data['accepted_log'] = $this->nc_register_model->get_nc_ticket_accepted(array('ticket_id'=>$notification[0]['ticket_id']));
                $this->data['template'] = "nc_register/notification_user";
            }        
 		        $this->load->view('common/nc_main',$this->data);
 		       

     }

    public function ticket_verification($id=null , $status=null){

     	

     	    //get the ticket info
            $ticket =  $this->nc_register_model->get_ticket(array('id'=>$id));
			if($ticket[0]['is_verified'] == 1){

				  die('Ticket has been already verified');
			}
			//data for ack
			$ack = array('ticket_id'=>$ticket[0]['id'],'seen'=> 0,'type'=> 5,'user_id'=>$ticket[0]['user_id'],'date'=>time());
			
			//update the ticket status anad keep its log
			$this->db->where('id',$id);
			if($status){
              
               $this->db->update('nc_ticket',array('is_verified' => 1));
               $data = array('ticket_id' => $id ,'date'=> time(), 'user_id'=>$this->session->userdata('staff_id'),'type'=>1);

               //send notification to all the user of the claimed department
               $this->send_notification($ticket[0]);

               $ack['description'] = "Your raise for nc ticket verification has been approved by Hod";
			}
			else{
               
                $data = array('ticket_id' => $id ,'date'=> time(), 'user_id'=>$this->session->userdata('staff_id'),'type'=>0);

                $ack['description'] = "Your raise for nc ticket verification has been declined by Hod";

			}

			$this->db->insert('nc_ticket_verified_by_hod',$data);
			$this->db->insert('nc_ticket_notification',$ack);
			redirect(base_url().'nc_register');



 	}

    public function send_notification($ticket=array()){

      	
            
 			      $users = $this->staff_model->get_staffs_official_information(array('department_id'=> $ticket['dept_id']));
            foreach($users as $row){

            	 $data =  array('ticket_id'=>$ticket['id'],'type'=> 1,'seen'=>0,'user_id'=>$row['staff_id'],'date'=>time(),'description'=>'There is a nc ticket issued for your department');
            	 $this->db->insert('nc_ticket_notification',$data);

            }


    }

    public function accept(){

            //get the ticket info
	        $ticket =  $this->nc_register_model->get_ticket(array('id'=>$_POST['ticket_id']));
          
          if($ticket[0]['parent_id'] != 0){

                //its a child ticket
                //update the is forwarded to )
                $this->db->where('id',$ticket[0]['parent_id']);
                $this->db->update('nc_ticket',array('is_forwarded'=> 0));
          }	        
	        //check if any action  is already perfored in the nc_ticket , commint only if no action is performed
	        if($ticket[0]['is_rejected'] == 1 || $ticket[0]['is_accepted'] == 1 || $ticket[0]['is_forwarded'] == 1){

	        	   die("Ticket is already committed");
	        }


            //insert into accept log
            $data = array('ticket_id'=>$_POST['ticket_id'],'user_id'=>$this->session->userdata('staff_id'),'comment'=>$_POST['comment'],'date'=>time(),'root_id'=>$_POST['root_id'],'commitment_time'=>$_POST['commitment_time'],'is_verified'=>0);
            $this->db->insert('nc_accept_ticket', $data); 

           
            //send for the verfication
            $staff_info = $this->staff_model->get_staffs_official_information(array('staff_id'=>$this->session->userdata('staff_id')));
            
            //get the department head_id
            $department_head = $this->department_model->get_departments(array('dpt_id' => $staff_info[0]['department_id']));
 				
            //add the notification for verfication
      			$notification=array(
      			    
      			    'ticket_id' => $ticket[0]['id'],
      				  'user_id' =>$department_head[0]['hod'],
      				  'description'=>'There is an verification for accept of NC ticket raise against your department',
      				  'seen' => 0,
      				  'type' => 3,
      				  'date' => time()
      		    );

 			$this->db->insert('nc_ticket_notification', $notification);
       redirect('nc_register');

            

    }

    public function ticket_accept_verification($ticket_id,$accept_log_id,$status){
           
          //ticket info
          $ticket =  $this->nc_register_model->get_ticket(array('id'=>$ticket_id));

          //check if the ticket is_accepted aleready set
          if($ticket[0]['is_accepted'] == 1 || $ticket[0]['is_rejected'] == 1 || $ticket[0]['is_forwarded'] == 1){

          	   die('This ticket is already committed');
          }
          
          //acceptLog info
          $accept_log = $this->nc_register_model->get_nc_ticket_accepted(array('id'=>$accept_log_id));


          // data for ack
           $ack =  array(
			    
				    'ticket_id' => $ticket[0]['id'],
					  'user_id' => $accept_log[0]['user_id'],
					  'seen' => 0,
					  'date' => time()
		    );

          //data for accept_verify_log
          $verify_data =  array('ticket_id'=>$ticket_id,'user_id'=>$this->session->userdata('staff_id'),'accept_id'=>$accept_log_id,'date'=>time());  
          

          
          
    	  if($status == 1){
    	  	   
               //set the is_accepted of the ticket
               $this->db->where('id',$ticket[0]['id']);
               $this->db->update('nc_ticket',array('is_accepted'=> 1));

    	  	   //update the accept log
    	  	   $this->db->where('id',$accept_log_id);
    	  	   $this->db->update('nc_accept_ticket',array('is_verified' => 1));
               
               $verify_data['type'] = 1;
               $ack['type'] = 5;
               $ack['description'] = "Your verification for accept of  nc ticket has been accepted by Department head";

               //send notification to the ticket raiser for the accept
	           $notification=array(
				    
				    'ticket_id' => $ticket[0]['id'],
  					'user_id' =>$ticket[0]['user_id'],
  					'description'=>'Your nc ticket has been accepted',
  					'seen' => 0,
  					'type' => 4,
  					'date' => time()
			   );

	 			$this->db->insert('nc_ticket_notification', $notification);
      
    	  }
    	  else{

    	  	   $verify_data['type'] = 0;
    	  	   $ack['type'] = 1;
    	  	   $ack['description'] = "Your verification for accept of  nc ticket has been declined by Department head";
    	  }
          
          //insert into the accept verify log
    	  $this->db->insert('nc_accept_ticket_verify',$verify_data);
          
          //send notification for ack for verification
          $this->db->insert('nc_ticket_notification', $ack);
          
            redirect('nc_register');
        }

    public function forward(){
      
        //get the ticket info
        $ticket =  $this->nc_register_model->get_ticket(array('id'=>$_POST['ticket_id']));
        
        //check if any action  is already perfored in the nc_ticket , commint only if no action is performed
        if($ticket[0]['is_rejected'] == 1 || $ticket[0]['is_accepted'] == 1 || $ticket[0]['is_forwarded'] == 1){

        	   die("Ticket is already committed");
        }

        //update the ticket forwarded 
        $this->db->where('id',$_POST['ticket_id']);
        $this->db->update('nc_ticket',array('is_forwarded'=> 1));

        //insert into forward log
        $data = array('ticket_id'=>$_POST['ticket_id'],'user_id'=>$this->session->userdata('staff_id'),'comment'=>$_POST['comment'],'date'=>time(),'to_dept'=>$_POST['to_dept']);
        $this->db->insert('nc_ticket_forward',$data);

        //create a new ticket with parent id as the orginal ticket
        $newticketdata = array(
                        					
                                  'ref_num' => $ticket[0]['ref_num'],
                        					'objective_id' => $ticket[0]['objective_id'],
                        					'details' => $ticket[0]['details'],
                        					'impact' => $ticket[0]['impact'],
                        					'user_id' =>$this->session->userdata('staff_id'),
                        					'is_accepted' => 0,
                        					'is_closed' => 0,
                        					'is_verified' => 1,
                        					'is_rejected' =>0,
                        					'is_forwarded' => 0,
                        					'parent_id' => $ticket[0]['id'],
                        					'dept_id' => $_POST['to_dept'],
                        					'date' => time()
		  
      );
		  
      $this->db->insert('nc_ticket',$newticketdata);

		   //send a notification to the new department
  		$newticketdata['id'] = $this->db->insert_id();
  		$this->send_notification($newticketdata);
      redirect('nc_register');
    
    
    }

    public function reject(){

        //get the ticket info
        $ticket =  $this->nc_register_model->get_ticket(array('id'=>$_POST['ticket_id']));

        if($ticket[0]['parent_id'] != 0){

                //its a child ticket
                //update the is forwarded to )
                $this->db->where('id',$ticket[0]['parent_id']);
                $this->db->update('nc_ticket',array('is_forwarded'=> 0));
        }         

        //check if any action  is already perfored in the nc_ticket , commint only if no action is performed
        if($ticket[0]['is_rejected'] == 1 || $ticket[0]['is_accepted'] == 1 || $ticket[0]['is_forwarded'] == 1){

        	   die("Ticket is already committed");
        }
        
        //update the ticket_nfo to rejected
        $this->db->where('id',$_POST['ticket_id']);
        $this->db->update('nc_ticket',array('is_rejected'=>1));

        //insert into the rejected log
        $data = array('ticket_id'=>$_POST['ticket_id'],'user_id'=>$this->session->userdata('staff_id'),'comment'=>$_POST['comment'],'date'=>time());
        $this->db->insert('nc_ticket_rejected', $data);
        

        //send notification to the ticket generator for the rejection
        $notification_data = array('user_id'=> $ticket[0]['user_id'] ,'date'=>time(),'description'=>'Your ticket raise for claimed department has been rejected','type'=>2,'seen'=> 0,'ticket_id'=>$_POST['ticket_id']);
        $this->db->insert('nc_ticket_notification',$notification_data);
        
        //set a flash msg

        //redirect
        redirect(base_url().'nc_register'); 

    }

    public function notifications(){

            $user_id =  $this->session->userdata('staff_id');
            $this->data['all_notifications'] = $this->nc_register_model->get_notification(array('user_id'=>$user_id));
            $this->data['template'] = 'nc_register/all_notifications';
            $this->load->view('common/nc_main',$this->data);

    }

    public function hod_panel(){
            
             $staff_info = $this->staff_model->get_staffs_official_information(array('staff_id'=>$this->session->userdata('staff_id')));
             $department_head = $this->department_model->get_departments(array('dpt_id' => $staff_info[0]['department_id']));
             if($department_head[0]['hod'] == $this->session->userdata('staff_id')){

                      //get all the ticket that has not been closed raised to my department
                      $this->data['tickets'] = $this->nc_register_model->get_ticket(array('is_closed'=> 0,'dept_id'=>$staff_info[0]['department_id'],'is_verified'=>1));
                      $this->data['template'] = 'nc_register/hod_panel';
                      $this->load->view('common/nc_main',$this->data);
                      
             
             }
             else{
                    
                      //unauhorized access
                      die("Aunthorized access");

             }
            
           
    }

    public function comments($ticket_id){
         
         if(isset($_POST['comment'])){

                $this->db->insert('nc_ticket_comment',array('ticket_id'=>$ticket_id,'user_id'=>$this->session->userdata('staff_id'),'comment'=>$_POST['comment'],'date'=>time()));
         }
         
         $this->data['comments'] = $this->nc_register_model->get_nc_ticket_comment(array('ticket_id'=>$ticket_id));
         $this->data['template'] = "nc_register/comments";
         $this->load->view('common/nc_main',$this->data);

      

    }

    public function rtc($ticket_id){
          
         
         $ticket =  $this->nc_register_model->get_ticket(array('id'=>$ticket_id));
         
         //insert into reuest to close log
         $this->db->insert('nc_request_to_close',array('ticket_id'=>$ticket_id,'user_id'=>$this->session->userdata('staff_id'),'date'=>time()));

         //send notification to user
         $notification=array(
                
                'ticket_id' => $ticket_id,
                'user_id' =>$ticket[0]['user_id'],
                'description'=>'There is request for you to close a ticket hat yor generated',
                'seen' => 0,
                'type' => 4,
                'date' => time()
          );

         $this->db->insert('nc_ticket_notification',$notification);
         redirect(base_url().'nc_register');

    }


    public function close($ticket_id){

          $ticket =  $this->nc_register_model->get_ticket(array('id'=>$ticket_id));

          //update the ticket table
          $this->db->where('id',$ticket_id);
          $this->db->update('nc_ticket',array('is_closed' => 1));

          //keep its log
          $this->db->insert('nc_close_ticket',array('ticket_id'=>$ticket_id,'user_id'=>$this->session->userdata('staff_id'),'date'=>time()));
          redirect(base_url().'nc_register');


    }

    public function my_ticket(){

         //tickets published by me
         $this->data['tickets'] = $this->nc_register_model->get_ticket(array('user_id'=>$this->session->userdata('staff_id')));
         $this->data['template'] = "nc_register/my_ticket";
         $this->load->view('common/nc_main',$this->data);

    }

    public function details($ticket_id){

         $ticket = $this->nc_register_model->get_ticket(array('id' => $ticket_id));
         $ticket[0]['verified_log'] = $this->nc_register_model->get_nc_ticket_verified(array('ticket_id'=>$ticket_id));
         $ticket[0]['accepted_log'] = $this->nc_register_model->get_nc_ticket_accepted(array('ticket_id'=>$ticket_id));
         $ticket[0]['rejected_log'] = $this->nc_register_model->get_nc_ticket_rejected(array('ticket_id'=>$ticket_id));
         $ticket[0]['closed_log'] = $this->nc_register_model->get_nc_ticket_closed(array('ticket_id'=>$ticket_id));
         $ticket[0]['parent_log'] = $this->nc_register_model->get_ticket(array('id' => $ticket[0]['parent_id']));
         $this->data['ticket'] =  $ticket;
         $this->data['template'] = "nc_register/details";
         $this->load->view('common/nc_main',$this->data);
         
    }



 



     
	
}