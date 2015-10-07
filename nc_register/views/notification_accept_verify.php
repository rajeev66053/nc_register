<?php 
    
    $latest_accepted_log = count($accepted_log) - 1;


?> 
 <style>
  td{

  padding: 5px 10px 5px 5px;
  }
  h2 {
  font-size: 24px;
  line-height: 36px;
  text-align: center;
}
  </style>
  <div class="row-fluid" style="min-height: 220px; width: 1000px; margin-left: 10px;">
      <div class="box span12"  style="margin: 40px;">
            <div class="box-header well">
                    <h2><i class="icon-bookmark"></i>Notification</h2>
                   
            </div>
            <div class="box-content" style="min-height: 220px;">
			
			


				 <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
					<tbody>
					  <tr>
						<td colspan="2">
							<div  style="background-color: #E6E6E6;">
								<h3 style="text-align: center;"> NC ticket Accept</h3>
							</div>
						</td>
					  </tr>
					

					  <tr>
						<td><?php echo 'Review :';?></td>
						<td><?php echo $notification[0]['description']; ?></td>
					  </tr>


					  <tr>
						<td><?php echo 'Comment :';?></td>
						<td><?php echo $accepted_log[$latest_accepted_log]['comment']; ?></td>
					  </tr>

					  <tr>
						<td><?php echo 'Root Cause :';?></td>
						<td><?php echo $accepted_log[$latest_accepted_log]['root_id']; ?></td>
					  </tr>
					  
					  <tr>
						<td><?php echo 'By :';?></td>
						<td><?php echo $accepted_log[$latest_accepted_log]['first_name']." ".$accepted_log[$latest_accepted_log]['middle_name']." ".$accepted_log[$latest_accepted_log]['middle_name']; ?></td>
					  </tr>
					  
					  <tr>
						<td><?php echo 'Commitment Time :';?></td>
						<td><?php echo $accepted_log[$latest_accepted_log]['commitment_time']; ?></td>
					  </tr>
					  
					  <tr>
						<td><?php echo 'Date :';?></td>
						<td><?php echo date('H:i:a M-d',$accepted_log[$latest_accepted_log]['date']); ?></td>
					  </tr>
					  
					  <tr>
					  <td colspan="2">
					  <a href="<?php echo base_url().'nc_register/ticket_accept_verification/'.$ticket[0]['id'].'/'.$accepted_log[$latest_accepted_log]['id'].'/1'; ?>" class="btn " role="button">Accept</a>
					  
					  <a href="<?php echo base_url().'nc_register/ticket_accept_verification/'.$ticket[0]['id'].'/'.$accepted_log[$latest_accepted_log]['id'].'/0'; ?>" class="btn " role="button">Reject</a>
					  </td>
					  </tr>
					 
					</tbody>
				</table>

				 <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
					<tbody>
						<tr>
							<td colspan="2">
							  <div  style="background-color: #E6E6E6;"><h3 style="text-align: center;"> NC ticket</h3></div>
							</td>
						</tr>

						<tr>
						  <td><label  class="control-label" for="ref_num">Reference No.</label></td>
						  <td><?php echo $ticket[0]['ref_num']; ?></td>
						</tr>

						<tr>
						  <td><label  class="control-label" for="ref_num">Objective</label></td>
						  <td><?php echo $ticket[0]['iso_title']; ?></td>
						</tr>


						<tr>
						  <td><label  class="control-label" for="ref_num">Details</label></td>
						  <td><?php echo $ticket[0]['details']; ?></td>
						</tr>

						<tr>
						  <td><label  class="control-label" for="ref_num">Impact</label></td>
						  <td><?php echo $ticket[0]['impact']; ?></td>
						</tr>

						<tr> 
						  <td><label  class="control-label" for="ref_num">To Department</label></td>
						  <td><?php echo $ticket[0]['department']; ?></td>
						</tr>

						<tr> 
						  <td><label  class="control-label" for="ref_num"> Ticket Raiser</label></td>
						  <td><?php echo $ticket[0]['first_name']." ".$ticket[0]['middle_name']." ".$ticket[0]['last_name']; ?></td>
						</tr>
					</tbody>
				</table>

    </div>
  </div>
</div>
 