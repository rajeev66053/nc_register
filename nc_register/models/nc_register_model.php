<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class nc_register_model extends CI_Model {

	
	public function __construct()
	{
		parent::__construct();
	}
	

	function get_department() {
	    $return[''] = 'please select';
	    $this->db->order_by('department_name', 'asc'); 
	    $query = $this->db->get('ag_department'); 
	    foreach($query->result_array() as $row){
	        $return[$row['dpt_id']] = $row['department_name'];
	    }
    return $return;
}

function get_objective(){
	    $return[''] = 'please select';
	    $query  = $this->db->get('iso_ppo');
	    foreach($query->result_array() as $row){
	        $return[$row['id']] = $row['title'];
	    }
    return $return;
}

/*
		 $query  = $this->db->get_where('ag_staff_official_status', array('department_id' => $user_id));
		 return $query->row_array();
}

function get_userid_by_department($department){

		 $query  = $this->db->get_where('ag_staff_official_status', array('id' => $user_id));
		 return $query->row_array();
}*/

function department($filter=array()){



				
			         if(isset($filter['department_id'])){

			         	 $this->db->where('department_id',$filter['department_id']);
			         }
			         if(isset($filter['staff_id'])){
			           
			             $this->db->where('staff_id',$filter['staff_id']);
			         }


			         $this->db->select('*');
						$this->db->from('ag_staff_official_status');
						$this->db->join('ag_department', 'ag_department.dpt_id = ag_staff_official_status.department_id');
								
						$sql = $this->db->get();
						$result=$sql->result_array();
						

						/*echo '<pre>';
		 				print_r($result);
		 				echo '</pre>';die;*/

			         
			       /*  $this->db->select('*');
			         $this->db->from('ag_staff_official_status');
			         $query = $this->db->get();
			         $result = $query->result();*/

			         //	print_r($result);die; 

			         return $result;

}


function get_user_details($filter=array()){

				/*	echo '<pre>';
		 				print_r($filter);
		 				echo '</pre>';die;*/


				
			         if(isset($filter['staff_id'])){

			         	 $this->db->where('staff_id',$filter['staff_id']);
			         }
			       
 

			         	/*$this->db->select('S.*,L.*');
						$this->db->from('ag_staff_official_status as S');
						$this->db->join('ag_staff_login as L', 'L.staff_user_id = S.staff_id');*/


						 $this->db->select('*');
						$this->db->from('ag_staff_official_status');
						//$this->db->join('ag_staff_login', 'ag_staff_login.staff_user_id = ag_staff_official_status.staff_id');
								
						$sql = $this->db->get();
						$result=$sql->result_array();
						

						/*echo '<pre>';
		 				print_r($result);
		 				echo '</pre>';die;*/

			         
			       /*  $this->db->select('*');
			         $this->db->from('ag_staff_official_status');
			         $query = $this->db->get();
			         $result = $query->result();*/

			         //	print_r($result);die; 

			         return $result;

}






function get_ticket_data($id=null){
	
			        $this->db->select('*');
		  	  		$this->db->where('user_id',$this->session->userdata('staff_id'));
		  	  		$this->db->where('id',$id);
		  	  		$this->db->where('seen','0');
					$this->db->from('nc_ticket_notification');
				    $sql = $this->db->get();
					$result=$sql->result_array();
						
			            return $result;

}


function get_ticket($filter=array()){
	
			        if(isset($filter['id'])){

			         	 $this->db->where('T.id', $filter['id']);
			        
			        }
			        if(isset($filter['user_id'])){

			         	 $this->db->where('T.user_id', $filter['user_id']);
			        
			        }
			        if(isset($filter['is_closed'])){

			        	 
			        	 $this->db->where('T.is_closed', $filter['is_closed']);
			        
			        }
			        if(isset($filter['dept_id'])){

			        	 
			        	 $this->db->where('T.dept_id', $filter['dept_id']);
			        
			        }
                    if(isset($filter['is_verified'])){

			        	 
			        	 $this->db->where('T.is_verified', $filter['is_verified']);
			        
			        }
			        if(isset($filter['is_closed'])){

			        	 
			        	 $this->db->where('T.is_closed', $filter['is_closed']);
			        
			        }
		           
		        	$this->db->select('T.*,I.title as iso_title,D.department_name as department, S.first_name,S.middle_name,S.last_name,F.department_name as from_department');
					$this->db->from('nc_ticket as T');
					$this->db->join('iso as I','T.objective_id = I.id','left');
					$this->db->join('ag_department as D','T.dept_id = D.dpt_id','left');
					$this->db->join('ag_personal_info as S','T.user_id = S.staff_id','left');
					$this->db->join('ag_staff_official_status as O','T.user_id = O.staff_id','left');
                    $this->db->join('ag_department as F','O.department_id = F.dpt_id','left');
                    $sql = $this->db->get();
					$result=$sql->result_array();
                    return $result;

}


function get_notification($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('id',$filter['id']);
        }
        if(isset($filter['seen'])){

        	$this->db->where('seen',$filter['seen']); 
        }
        if(isset($filter['user_id'])){

        	$this->db->where('user_id',$filter['user_id']);
        }
        if(isset($filter['limit'])){

        	$this->db->limit($filter['limit']);
        }
        $this->db->order_by('id','DESC');
		$this->db->select('*');
  	    $this->db->from('nc_ticket_notification');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;

}

public function get_nc_ticket_rejected($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('R.id',$filter['id']);
        }
        if(isset($filter['ticket_id'])){

        	$this->db->where('R.ticket_id',$filter['ticket_id']); 
        }
        if(isset($filter['user_id'])){

        	$this->db->where('R.user_id',$filter['user_id']);
        }
		$this->db->select('R.*,S.first_name,S.middle_name,S.last_name');
  	    $this->db->from('nc_ticket_rejected as R');
        $this->db->join('ag_personal_info as S','R.user_id = S.staff_id','left');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;


}

public function get_nc_ticket_forwarded($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('R.id',$filter['id']);
        }
        if(isset($filter['ticket_id'])){

        	$this->db->where('R.ticket_id',$filter['ticket_id']); 
        }
        if(isset($filter['user_id'])){

        	$this->db->where('R.user_id',$filter['user_id']);
        }
		$this->db->select('R.*,S.first_name,S.middle_name,S.last_name');
  	    $this->db->from('nc_ticket_forward as R');
        $this->db->join('ag_personal_info as S','R.user_id = S.staff_id','left');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;


}

public function get_nc_ticket_accepted($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('R.id',$filter['id']);
        }
        if(isset($filter['ticket_id'])){

        	$this->db->where('R.ticket_id',$filter['ticket_id']); 
        }

        if(isset($filter['user_id'])){

        	$this->db->where('R.user_id',$filter['user_id']);
        }
		$this->db->select('R.*,S.first_name,S.middle_name,S.last_name,V.type as accept_type');
  	    $this->db->from('nc_accept_ticket as R');
        $this->db->join('ag_personal_info as S','R.user_id = S.staff_id','left');
        $this->db->join('nc_accept_ticket_verify as V','R.id = V.accept_id','left');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;


}

public function get_nc_ticket_comment($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('R.id',$filter['id']);
        }
        if(isset($filter['ticket_id'])){

        	$this->db->where('R.ticket_id',$filter['ticket_id']); 
        }
        if(isset($filter['user_id'])){

        	$this->db->where('R.user_id',$filter['user_id']);
        }
		$this->db->select('R.*,S.first_name,S.middle_name,S.last_name,D.department_name');
  	    $this->db->from('nc_ticket_comment as R');
        $this->db->join('ag_personal_info as S','R.user_id = S.staff_id','left');
        $this->db->join('ag_staff_official_status as O','R.user_id = O.staff_id','left');
        $this->db->join('ag_department as D','O.department_id = D.dpt_id','left');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;
 

}

public function get_nc_ticket_verified($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('R.id',$filter['id']);
        }
        if(isset($filter['ticket_id'])){

        	$this->db->where('R.ticket_id',$filter['ticket_id']); 
        }
        if(isset($filter['user_id'])){

        	$this->db->where('R.user_id',$filter['user_id']);
        }
		$this->db->select('R.*,S.first_name,S.middle_name,S.last_name');
  	    $this->db->from('nc_ticket_verified_by_hod as R');
        $this->db->join('ag_personal_info as S','R.user_id = S.staff_id','left');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;


}

public function get_nc_ticket_closed($filter = array()){

        if(isset($filter['id'])){
            
             $this->db->where('R.id',$filter['id']);
        }
        if(isset($filter['ticket_id'])){

        	$this->db->where('R.ticket_id',$filter['ticket_id']); 
        }
        if(isset($filter['user_id'])){

        	$this->db->where('R.user_id',$filter['user_id']);
        }
		$this->db->select('R.*,S.first_name,S.middle_name,S.last_name');
  	    $this->db->from('nc_close_ticket as R');
        $this->db->join('ag_personal_info as S','R.user_id = S.staff_id','left');
	    $sql = $this->db->get();
		$notification=$sql->result_array();
		return $notification;


}
	
}
