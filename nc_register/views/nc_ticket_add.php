<style>
button:hover{
background: #B9B4B4;
}

</style>


  <div class="row-fluid" style="min-height: 220px; width: 890px; margin-left: -10px;">
      <div class="box span12" style="margin: 40px;">
            <div class="box-header well">
                    <h2><i class="icon-info-sign"></i>Raise NC Ticket</h2>
            </div>
            <div class="box-content">



                <form id="ticket_add" class="form-horizontal" action="<?php echo base_url(); ?>nc_register/nc_ticket_add" method="post" autocomplete="off">

                <div class="control-group">
                    <label  class="control-label" for="ref_num">Reference No.</label>
                    <div class="controls">
                      <input id="ticket_ref_num" name="ref_num" type="text" class="input-large search-query" required>
                     <span class='error-message' id='ref_num-error'></span>
                    </div>
                  </div>


                  <div class="control-group">
                    <label class="control-label" for="objective_id">Objective</label>
                    <div class="controls">
                       <select id="ticket_objective_id" name="objective_id" class="input-large" style="border linear 0.2s, box-shadow linear 0.2s;width: 220px;">
                           <option value="">Please Select</option>
                           <?php foreach($objective as $row){ ?>
                                   
                                   <option value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>

                           <?php } ?>
                      </select>
                      	<span class='error-message' id='objective_id-error'></span>
                    </div>
                  </div>




                   <div class="control-group">
                    <label class="control-label" for="details">Details</label>
                    <div class="controls">
                      <textarea cols="4" rows="5" id="ticket_details" name="details"  class="form-control" required=""></textarea>
                     
					<span class='error-message' id='details-error'></span>
                    </div>
                  </div>




                  <div class="control-group">
                    <label class="control-label" for="impact">Impact</label>
                    <div class="controls">
                      <textarea cols="4" rows="5" id="ticket_impact" name="impact"  class="form-controls" required=""></textarea>
                     <span class='error-message' id='impact-error'></span>
                    </div>
                  </div>



                   <div class="control-group">
                    <label class="control-label" for="dept_id">To Department</label>
                    <div class="controls">
                       <select id="ticket_dept_id" name="dept_id" class="input-large" style="border linear 0.2s, box-shadow linear 0.2s;width: 220px;">
                           <option value="">Please Select</option>
                           <?php foreach($department as $row){ ?>
                   
                                   <option value="<?php echo $row['dpt_id']; ?>"><?php echo $row['department_name']; ?></option>

                           <?php } ?>
                      </select>
                      <span class='error-message' id='dept_id-error'></span>
                    </div>
                  </div>


                   <div class="control-group">
                    <label class="control-label" for="add_ticket"></label>
                    <div class="controls">
                      <button type="submit" id="add_ticket" name="add_ticket">Submit</button>
                    </div>
                  </div>



                  </form>
            </div>
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
			<!-- Real-time Validation -->
				<!--ref_num-->
				$('#ticket_ref_num').on('input', function() {
					var input=$(this);
					var is_ref_num=input.val();
					if(is_ref_num){
						input.removeClass("invalid").addClass("valid");
						producePrompt('Valid', 'ref_num-error', 'green');
						}
					else{
						input.removeClass("valid").addClass("invalid");
						producePrompt('Reference number is required', 'ref_num-error' , 'red');
						}
				});
				
				<!--objective_id -->
				$('#ticket_objective_id').on('input', function() {
					var input=$(this);
					var is_objective_id=input.val();
					if(is_objective_id!=""){
						input.removeClass("invalid").addClass("valid");
						producePrompt('Valid', 'objective_id-error', 'green');
						
						
					}else{
						
						input.removeClass("valid").addClass("invalid");
      					producePrompt('Choose Objective.', 'objective_id-error', 'red');
						
					}
						
										
				});
							
				
				<!--details -->
				$('#ticket_details').on('input', function() {
					var input=$(this);
					var details=input.val();
					
					if(details.length == 0) {
						
						input.removeClass("valid").addClass("invalid");
						producePrompt('Enter details','details-error', 'red');
					
					  }else{
						
					input.removeClass("invalid").addClass("valid");
						producePrompt('Valid', 'details-error', 'green');
					}
					
					
				});
				
				<!--impact -->
				$('#ticket_impact').on('input', function() {
					var input=$(this);
					var impact=input.val();
					
					if(impact.length == 0) {
						
						input.removeClass("valid").addClass("invalid");
						producePrompt('Enter details','impact-error', 'red');
					
					  }else{
						
					input.removeClass("invalid").addClass("valid");
						producePrompt('Valid', 'impact-error', 'green');
					}
					
					
				});
				
				<!--dept_id -->
				$('#ticket_dept_id').on('change', function() {
					var input=$(this);
					var is_dept_id=input.val();
					if(is_dept_id!=""){
						input.removeClass("invalid").addClass("valid");
						producePrompt('Valid', 'dept_id-error', 'green');
						
						
					}else{
						
						input.removeClass("valid").addClass("invalid");
      					producePrompt('Choose Department.', 'dept_id-error', 'red');
					}
						
										
				});
				
				
		
			<!-- After Form Submitted Validation-->
			$("#form_submit").click(function(event){
				
				
				var form_data=$("#ticket_add").serializeArray();
				
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
				/*else{
					alert('No errors: Form will be submitted');
				}*/
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
			 
 
 
 
 