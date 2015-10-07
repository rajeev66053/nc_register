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
                    <h2><i class="icon-bookmark"></i>NC Ticket</h2>
                   
            </div>
            <div class="box-content" style="min-height: 220px;">
			
			
			
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
				
							<a href="<?php echo base_url().'nc_register/ticket_verification/'.$ticket[0]['id'].'/1'?>" class="btn " role="button">Accept</a>
							<a href="<?php echo base_url().'nc_register/ticket_verification/'.$ticket[0]['id'].'/0'?>" class="btn " role="button">Reject</a>
			
 
<!--
<form>
<div class="form-group">
    <label for="ref_num">Reference No.</label>
    <input type="text" name="ref_num" class="form-control" value ='<?php //echo $ticket[0]['ref_num']; ?>' readonly />
   </div>
   <div class="form-group"> 
    <label for="objective_id" >Objective</label>
  
    <input type="text" name="objective_id" class="form-control" value ='<?php //echo $ticket[0]['iso_title']; ?>' readonly />
</div>

<div class="form-group">
    <label for="details">Details</label>
    <input type="textarea" name="details" value ='<?php //echo $ticket[0]['details']; ?>' class="form-control" readonly/>
   </div>
   
   <div class="form-group"> 
    <label for="impact">Impact</label>
    <input type="textarea" name="impact" class="form-control" value ='<?php //echo $ticket[0]['impact']; ?>' readonly/>
</div>

 <div class="form-group"> 
    <label for="dept_id"> To Department</label>
   
    <input type="text" name="dept_id" class="form-control" value ='<?php //echo $ticket[0]['department']; ?>' readonly/> 
</div>
<div class="form-group"> 
    <label for="dept_id"> Ticket Raiser</label>
   
    <input type="text" class="form-control" value ='<?php //echo $ticket[0]['first_name']." ".$ticket[0]['middle_name']." ".$ticket[0]['last_name']; ?>' readonly/> 
</div>
 
       <a href="<?php //echo base_url().'nc_register/ticket_verification/'.$ticket[0]['id'].'/1'?>">Accept</a>||
       <a href="<?php //echo base_url().'nc_register/ticket_verification/'.$ticket[0]['id'].'/0'?>">Reject</a>
    


</form>-->


    </div>
  </div>
</div>