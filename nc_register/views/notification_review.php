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
 
 <!--<div class="nc_ticket_form"  style="margin:auto;width: 60%; padding: 10px;">-->



				 <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
					<tbody>
					  <tr>
						<td colspan="2">
							<div  style="background-color:  #E6E6E6;">
								<h3> NC ticket Review</h3>
							</div>
						</td>
					  </tr>
					 

					  <tr>
						<td><?php echo 'Review :';?></td>
						<td><?php echo $notification[0]['description']; ?></td>
					  </tr>


					  <tr>
						<td><?php echo 'Reason :';?></td>
						<td><?php echo $rejected_log[0]['comment']; ?></td>
					  </tr>

					  <tr>
						<td><?php echo 'By :';?></td>
						<td><?php echo $rejected_log[0]['first_name']." ".$rejected_log[0]['middle_name']." ".$rejected_log[0]['middle_name']; ?></td>
					  </tr>


					  <tr>
						<td><?php echo 'Date :';?></td>
						<td><?php echo date('H:i:a M-d',$rejected_log[0]['date']); ?></td>
					  </tr>
					</tbody>
				</table>
			

				
				 <table style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
					<tbody>
						<tr>
							<td colspan="2">
							  <div  style="background-color:  #E6E6E6;"><h3> NC ticket</h3></div>
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


<?php 
        if($ticket[0]['parent_id'] != 0) { ?>
              

               <button type="button" id="reject" class="btn btn-info btn-lg" data-toggle="modal" data-target="#acceptModal">Accept</button>
               <button type="button" id="reject" class="btn btn-info btn-lg" data-toggle="modal" data-target="#rejectModal">Reject</button>
               <button type="button" id="forwqard" class="btn btn-info btn-lg" data-toggle="modal" data-target="#forwardModal">Forward</button>

 

   <!-- Modal -->
  <div class="modal fade" id="rejectModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">NC Reject</h2>
        </div>

        <form action="<?php echo $this->config->base_url().'nc_register/reject'; ?>" method="post" style="margin-left: 20px;">


        <div class="control-group">
                        <label  class="control-label" for="ref_num">Comment</label>
                        <div class="controls">
                         <textarea rows="5" cols="4" id="ticket_comment" type="textarea" name="comment"  class="form-control" required ></textarea>
                        <input type="hidden" name="ticket_id"  value="<?php echo $ticket[0]['parent_id']?>"/>
                          <span class='error-message' id='comment-error'></span>
                      </div>
              </div>

    


        <div class="modal-footer">

        <input id="form_submit" type="submit" name="submit"/>
        <!-- <a href="<?php // echo $this->config->base_url().'nc_register';?>"><button type="button" >Submit</button></a>-->
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
      
    </div>
  </div>
  
</div>


  <!-- Modal -->
  <div class="modal fade" id="forwardModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">NC Forward</h2>
        </div>


         <form  action="<?php echo $this->config->base_url().'nc_register/forward'; ?>" method="post" style="margin-left: 20px;">


         <div class="control-group">
                        <label  class="control-label" for="comment">Comment</label>
                        <div class="controls">
                         <textarea rows="5" cols="4" id="ticket_comment1" name="comment"  class="form-control" required></textarea>
                        <input type="hidden" name="ticket_id"  value="<?php echo $ticket[0]['parent_id']?>"/>
                          <span class='error-message' id='comment1-error'></span>
                      </div>
              </div>




              <div class="control-group">
                        <label  class="control-label" for="to_dept">To department</label>
                        <div class="controls">
                         <select id="ticket_dept_id" name="to_dept" class="form-control" required>
                                <option value="">Please Select</option>
                                <?php foreach($departments as $row) { ?>
                                      
                                          <option value="<?php echo $row['dpt_id']; ?>"><?php echo $row['department_name']; ?></option>

                                <?php } ?>
                      </select>
                          <span class='error-message' id='to_dept-error'></span>
                      </div>
              </div>



        <div class="modal-footer">

        <input id="form_submit1" type="submit" name="submit"/>
        <!-- <a href="<?php // echo $this->config->base_url().'nc_register';?>"><button type="button" >Submit</button></a>-->
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
       
      
    </div>
  </div>






 <!-- Modal -->

  <div class="modal fade" id="acceptModal" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">NC Accept</h2>
        </div>


         <form  action="<?php echo $this->config->base_url().'nc_register/accept'; ?>" method="post" style="margin-left: 20px;">


          <div class="control-group">
                        <label  class="control-label" for="comment">Comment</label>
                        <div class="controls">
                        <textarea rows="5" cols="4" id="ticket_comment2" name="comment"  class="form-control" required></textarea>
                        <input type="hidden" name="ticket_id"  value="<?php echo $ticket[0]['parent_id']?>"/>
                          <span class='error-message' id='comment2-error'></span>
                      </div>
              </div>



        <div class="control-group">
                        <label  class="control-label" for="root_id">Root</label>
                        <div class="controls">
                         <input id="ticket_root_id" type="text" name="root_id"  class="input-large search-query" required/>
                           <span class='error-message' id='root_id-error'></span>
                      </div>
              </div>  

    


         <div class="control-group">
                          <label  class="control-label" for="commitment_time">Commitment Time</label>
                          <div class="controls">
                            <input type="text" id="ticket_commitment_time" name="commitment_time"  class="input-large search-query" required/>
                          <span class='error-message' id='commitment_time-error'></span>
                        </div>
                </div>

        <div class="modal-footer">

        <input id="form_submit2" type="submit" name="submit"/>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
       
      
    </div>
  </div>

<?php   } ?>


    </div>
  </div>



 

  <!-- Styles -->
  <style>
          
    .error{
      display: none;
      margin-left: 10px;
    }   
    
    .error_show{
      color: red;
      margin-left: 10px;
    }
    
    input[type="text"].invalid,select.invalid, textarea.invalid{
      border: 2px solid red;
    }
    
    input[type="text"].valid,select.valid, textarea.valid{
      border: 2px solid green;
    }
  </style>
    
    <script>
    $(document).ready(function() {




   /* $( "#ticket_commitment_time" ).datepicker({
  dateFormat: "yy-mm-dd"
});*/

 
 $( "#ticket_commitment_time" ).datetimepicker({
  dateFormat: "yy-mm-dd"
 });
      
      <!-- Real-time Validation -->
        <!--comment-->
        $('#ticket_comment').on('input', function() {
          var input=$(this);
          var is_comment=input.val();
          if(is_comment){
            input.removeClass("invalid").addClass("valid");
            producePrompt('Valid', 'comment-error', 'green');
            }
          else{
            input.removeClass("valid").addClass("invalid");
            producePrompt('Comment required', 'comment-error' , 'red');
            }
        });


         <!--comment1-->
        $('#ticket_comment1').on('input', function() {
          var input=$(this);
          var is_comment=input.val();
          if(is_comment){
            input.removeClass("invalid").addClass("valid");
            producePrompt('Valid', 'comment1-error', 'green');
            }
          else{
            input.removeClass("valid").addClass("invalid");
            producePrompt('Comment required', 'comment1-error' , 'red');
            }
        });


         <!--comment2-->
        $('#ticket_comment2').on('input', function() {
          var input=$(this);
          var is_comment=input.val();
          if(is_comment){
            input.removeClass("invalid").addClass("valid");
            producePrompt('Valid', 'comment2-error', 'green');
            }
          else{
            input.removeClass("valid").addClass("invalid");
            producePrompt('Comment required', 'comment2-error' , 'red');
            }
        });
        
        <!--root_id -->
        $('#ticket_root_id').on('input', function() {
          var input=$(this);
          var is_root_id=input.val();
          if(is_root_id!=""){
            input.removeClass("invalid").addClass("valid");
            producePrompt('Valid', 'root_id-error', 'green');
            
            
          }else{
            
            input.removeClass("valid").addClass("invalid");
                producePrompt('Enter Root Id', 'root_id-error', 'red');
          }
            
                    
        });
              
        
        <!--commitment_time -->
        $('#ticket_commitment_time').on('input', function() {
          var input=$(this);
          var details=input.val();
          
          if(details.length == 0) {
            
            input.removeClass("valid").addClass("invalid");
            producePrompt('Enter commitment time','commitment_time-error', 'red');
          
            }else{
            
          input.removeClass("invalid").addClass("valid");
            producePrompt('Valid', 'commitment_time-error', 'green');
          }
          
          
        });



        <!--dept_id -->
        $('#ticket_dept_id').on('input', function() {
          var input=$(this);
          var is_dept_id=input.val();
          if(is_dept_id!=""){
            input.removeClass("invalid").addClass("valid");
            producePrompt('Valid', 'dept_id-error', 'green');
            
            
          }else{
            
            input.removeClass("valid").addClass("invalid");
                producePrompt('Choose Department', 'dept_id-error', 'red');
          }
            
                    
        });
        
        
      <!-- After Form Submitted Validation-->
      $("#form_submit").click(function(event){
        
        
        var form_data=$("#ticket_reject").serializeArray();
        
        var error_free=true;
        for (var input in form_data){
          
          if(form_data[input]['name']!='_method'){
            var element=$("#ticket_"+form_data[input]['name']);
            var valid=element.hasClass("valid");
            var error_element=$("span", element.parent());
            if (!valid){
              error_element.removeClass("error").addClass("error_show");
              
              error_free=false;
              }
            else{
              error_element.removeClass("error_show").addClass("error");
              }
          }
        }
        if (!error_free){
          event.preventDefault(); 
        }
      });


       <!-- After Form Submitted Validation-->
      $("#form_submit1").click(function(event){
        
        
        var form_data=$("#ticket_forward").serializeArray();
        
        var error_free=true;
        for (var input in form_data){
          
          if(form_data[input]['name']!='_method'){
            var element=$("#ticket_"+form_data[input]['name']);
            var valid=element.hasClass("valid");
            var error_element=$("span", element.parent());
            if (!valid){
              error_element.removeClass("error").addClass("error_show");
              
              error_free=false;
              }
            else{
              error_element.removeClass("error_show").addClass("error");
              }
          }
        }
        if (!error_free){
          event.preventDefault(); 
        }
      });


       <!-- After Form Submitted Validation-->
      $("#form_submit2").click(function(event){
        
        
        var form_data=$("#ticket_accept").serializeArray();
        
        var error_free=true;
        for (var input in form_data){
          
          if(form_data[input]['name']!='_method'){
            var element=$("#ticket_"+form_data[input]['name']);
            var valid=element.hasClass("valid");
            var error_element=$("span", element.parent());
            if (!valid){
              error_element.removeClass("error").addClass("error_show");
              
              error_free=false;
              }
            else{
              error_element.removeClass("error_show").addClass("error");
              }
          }
        }
        if (!error_free){
          event.preventDefault(); 
        }
      });
      
      
      
      function jsShow(id) {
        document.getElementById(id).style.display = 'block';
      }
      
      function jsHide(id) {
        document.getElementById(id).style.display = 'none';
      }
      
      
      
      
      function producePrompt(message, promptLocation, color) {
        document.getElementById(promptLocation).innerHTML = message;
        document.getElementById(promptLocation).style.color = color;
      
      
      }

      
      
      
    });
  </script>  
       
 