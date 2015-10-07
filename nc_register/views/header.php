
 <div class="row-fluid" style="position: relative; top:9px">
                         
                      
                        
                        
                       
                        <div  class="btn-group pull-right theme-container" style="margin: 0px;" >
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="notification red"><?php echo $unseen;?></span><i class="icon-wrench"></i><span class="hidden-phone"><strong style="color: #DD4814;" >Notification</strong></span>
                                    <span class="caret"></span>
                            </a>
 <?php /* echo '<pre>';
 var_dump($notification);
 echo '</pre>';die;*/ ?>
                                                                
                            <ul class="dropdown-menu" id="themes1" style="color: #DD4814;">

                              <?php  //var_dump($row);die;

                               if(!empty($notification) && is_array($notification)) {

                                   foreach($notification as $row) { 
                                    
                                              ?>
                                    

                                    <li > 
                                   <a  href="<?php echo base_url() ?>nc_register/notification/<?php echo $row['id']; ?>"><?php echo $row['description']; ?>
                                         <p><?php echo $row['date']; ?></p>
                                        </a> 
                                    </li>
                                  


                                  <?php }  } ?> 

                                 
                                  
                            </ul>
                        </div>
                       
                        
                         <div  class="btn-group pull-right theme-container" style="margin: 0px;">
                                <a class="btn dropdown-toggle"  href="<?php echo base_url(); ?>nc_register/nc_ticket_raise">
                                        <i class="icon-edit"></i><span class="hidden-phone"><strong style="color: #DD4814;" >NC ticket Raise</strong></span> 
                                </a>
                        </div>
                        
                        
                       
                 </div>
