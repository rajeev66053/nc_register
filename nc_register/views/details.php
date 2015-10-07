<style>
td {
	padding:5px 10px 5px 5px;
}
</style>
<?php //echo '<pre>';
         //print_r($ticket);
         //echo '</pre>';
         ?>

      <div class="row-fluid" style="min-height: 220px; width: 1000px; margin-left: 10px;">
      <div class="box span12"  style="margin: 40px;">
            <div class="box-header well">
                    <h2><i class="icon-bookmark"></i>Details</h2>
                   
            </div>
            <div class="box-content" style="min-height: 220px;">
			
			


<table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
	<tbody>
	<tr>
          <td colspan="2">
          <div  style="background-color: #E6E6E6;"><h3 style="text-align: center;"> NC ticket Details</h3>
          </div>
          </td>
          </tr>

 <!-- 
<tr>
<td>
<p class="TableHeading10"><span><b>Title</b></span></p>
</td>
<td>
<p class="TableHeading10"><span><b>Description</b></span></p>
</td>
</tr>

-->

<?php foreach ($ticket as $ticket_details){ 

//echo '<pre>';
//print_r($ticket_details);
//echo '</pre>';die;


  ?> 
<tr>
  <td><?php echo 'Reference Number:';?></td>
  <td><?php echo $ticket_details['ref_num']; ?></td>
</tr>

<tr>
  <td><?php echo 'Ticket Objective:';?></td>
  <td><?php echo $ticket_details['iso_title']; ?></td>
</tr>

<tr>
  <td><?php echo 'Ticket Details:';?></td>
  <td><?php echo $ticket_details['details']; ?></td>
</tr>

<tr>
  <td><?php echo 'Impact:';?></td>
  <td><?php echo $ticket_details['impact']; ?></td>
</tr>

<tr>
  <td><?php echo 'Ticket Raised By:';?></td>
  <td><?php echo $ticket_details['first_name']." ".$ticket_details['middle_name']." ".$ticket_details['last_name']; ?></td>
</tr>


<tr>
  <td><?php echo 'Ticket Raised By(Department):';?></td>
  <td><?php echo $ticket_details['from_department']; ?></td>
</tr>

<tr>
  <td><?php echo 'Ticket Raised To:';?></td>
  <td><?php echo $ticket_details['department']; ?></td>
</tr>


<tr>
  <td><?php echo 'Ticket Raised On:';?></td>
  <td><?php echo date('H:i:a d-M',$ticket_details['date']); ?></td>
</tr>
<tr>
<td><?php echo 'Verified Log:';?>
</td>
<td >

<?php if($ticket_details['is_verified']=='1'){ ?>

      <?php if($ticket_details['verified_log']){?>

            <?php
            foreach ($ticket_details['verified_log'] as $ticket_details_verify){ 

             //echo '<pre>';
            //print_r($ticket_details_verify);
            //echo '</pre>';die; ?> 

<div style="padding:10px;">
            <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
            <tbody>

                <tr>
                  <td><?php echo 'Verified:';?></td>
                  <td><?php echo ($ticket_details_verify['type']=='1')?'yes':'No'; ?></td>
                </tr>

                <tr>
                  <td><?php echo 'Verified By:';?></td>
                  <td><?php echo $ticket_details_verify['first_name']." ".$ticket_details_verify['middle_name']." ".$ticket_details_verify['last_name']; ?></td>
                </tr>


                <?php if($ticket_details_verify['comment']){ ?>
                    <tr>
                      <td><?php echo 'Comment:';?></td>
                      <td><?php echo $ticket_details_verify['comment']; ?></td>
                    </tr>

                <?php } ?>

                <tr>
                  <td><?php echo 'Verified Date:';?></td>
                  <td><?php echo date('H:i:a d-M',$ticket_details_verify['date']); ?></td>
                </tr>
				</tbody>
                </table>
                </div>
             <?php } ?>

    <?php } ?>
 <?php } ?>
 </td>
</tr>


<tr>
<td><?php echo 'Rejected Log:';?></td>
<td >


 <?php if($ticket_details['is_rejected']=='1'){ ?>

      <?php if($ticket_details['rejected_log']){ ?>

              <?php foreach ($ticket_details['rejected_log'] as $ticket_details_rejected){  ?> 

               <div style="padding:10px;">
            <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
            <tbody>

                <tr>
                  <td><?php echo 'Rejected By:';?></td>
                  <td><?php echo $ticket_details_rejected['first_name']." ".$ticket_details_rejected['middle_name']." ".$ticket_details_rejected['last_name']; ?></td>
                </tr>


                <?php if($ticket_details_rejected['comment']){ ?>
                    <tr>
                      <td><?php echo 'Comment:';?></td>
                      <td><?php echo $ticket_details_rejected['comment']; ?></td>
                    </tr>

                <?php } ?>

                <tr>
                  <td><?php echo 'Rejected Date:';?></td>
                  <td><?php echo date('H:i:a d-M',$ticket_details_rejected['date']); ?></td>
                </tr>
                

            </tbody>
        </table>

          <?php } ?>
      <?php } ?>
<?php } ?>
</td>
</tr>



<tr>
<td><?php echo 'Accepted Log:';?></td>
<td >

<?php if($ticket_details['is_accepted']=='1'){ ?>

      <?php if($ticket_details['accepted_log']){ ?>

       <?php foreach ($ticket_details['accepted_log'] as $ticket_details_accepted){  ?> 
        <?php if($ticket_details_accepted['is_verified'] == 1 && $ticket_details_accepted['accept_type'] == 1 ){ ?>
       <div style="padding:10px;">
            <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
            <tbody>

               <tr>
                  <td><?php echo 'Root Id:';?></td>
                  <td><?php echo $ticket_details_accepted['root_id']; ?></td>
                </tr>

                <tr>
                  <td><?php echo 'Accepted By:';?></td>
                  <td><?php echo $ticket_details_accepted['first_name']." ".$ticket_details_accepted['middle_name']." ".$ticket_details_accepted['last_name']; ?></td>
                </tr>
  
                <?php if($ticket_details['accepted_log'][0]['comment']){ ?>

                     <tr>
                      <td><?php echo 'Comment:';?></td>
                      <td><?php echo $ticket_details_accepted['comment']; ?></td>
                    </tr>

                <?php } ?>

                <tr>
                      <td><?php echo 'Accepted Time:';?></td>
                      <td><?php echo $ticket_details_accepted['commitment_time'];//date('H:i:a',$ticket_details_accepted['commitment_time']); ?></td>
                    </tr>


            </tbody>
        </table>

               <?php } ?>            
          <?php } ?>

     <?php } ?>
<?php } ?>
</td>
</tr>


 <?php if($ticket_details['is_closed']=='1'){ ?>

    <?php if($ticket_details['closed_log']){ ?>

                    <tr>
                  <td><?php echo 'Closed By:';?></td>
                  <td><?php echo $ticket_details['closed_log'][0]['first_name']." ".$ticket_details['closed_log'][0]['middle_name']." ".$ticket_details['closed_log'][0]['last_name']; ?></td>
                </tr>
   
                
     <?php } ?>
<?php } ?>

                      

<?php } ?>

</tbody>
</table>


<?php if($ticket_details['parent_log']){ ?>
<table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
<tbody>
<tr>
          <td colspan="2">
          <div  style="background-color: #E6E6E6;"><h3 style="text-align: center;">NC Parent ticket Details</h3>
          </div>
          </td>
          </tr>

<?php foreach ($ticket_details['parent_log'] as $ticket_details){ 

//echo '<pre>';
//print_r($ticket_details);
//echo '</pre>';die;


  ?> 
<tr>
  <td><label  class="control-label" for="ref_num">Reference Number:</label></td>
  <td><?php echo $ticket_details['ref_num']; ?></td>
</tr>

<tr>
  <td><label  class="control-label" for="ref_num">Ticket Objective:</label></td>
  <td><?php echo $ticket_details['iso_title']; ?></td>
</tr>

<tr>
  <td><label  class="control-label" for="ref_num">Ticket Details:</label></td>
  <td><?php echo $ticket_details['details']; ?></td>
</tr>

<tr>
  <td><label  class="control-label" for="ref_num">Impact:</label></td>
  <td><?php echo $ticket_details['impact']; ?></td>
</tr>

<tr>
  <td><label  class="control-label" for="ref_num">Ticket Raised By:</label></td>
  <td><?php echo $ticket_details['first_name']." ".$ticket_details['middle_name']." ".$ticket_details['last_name']; ?></td>
</tr>


<tr>
<td><label  class="control-label" for="ref_num">Ticket Raised By(Department):</label></td>
  <td><?php echo $ticket_details['from_department']; ?></td>
</tr>

<tr>
<td><label  class="control-label" for="ref_num">Ticket Raised To:</label></td>
  <td><?php echo $ticket_details['department']; ?></td>
</tr>


<tr>

  <td><label  class="control-label" for="ref_num">Ticket Raised On:</label></td>
  <td><?php echo date('H:i:a d-M',$ticket_details['date']); ?></td>
</tr>


<?php } ?>

</tbody>
</table>

<?php } ?>






            </div>
         </div>
     </div>


 