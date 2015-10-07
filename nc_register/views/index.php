<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<link href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.css" rel="stylesheet">
<script>
$(document).ready(function() {
    $('#example').dataTable( {
        "order": [[ 3, "desc" ]], //third column descending order
        /* "paging":   false,        
        "ordering": false,
        "info":     false,*/
        
    } );
} );
</script>
<style>
th {
    background: #E6E6E6;
}
</style>


<div class="row-fluid" style="min-height: 220px; width: 1000px; margin-left: 10px;">
      <div class="box span12"  style="margin: 40px;">
            <div class="box-header well">
                    <h2><i class="icon-bookmark"></i> Dashboard</h2>
                   
            </div>
            <div class="box-content" style="min-height: 220px;">

<!-- class="display" cellspacing="0" width="100%" -->
<table id="example"  style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Ref Id</th>
                <th>Title</th>
                <th>From Department</th>
                <th>To Department</th>
                <th>Status</th>
                <th>Comments</th>
                <th>Raised By</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
        </thead>
 
        <tbody>
        <?php $i =1; foreach($tickets as $ticket){
		
		//echo '<pre>';
		//print_r($ticket);
		//echo '</pre>';?>
            <tr> 
                
                <td><?php echo $i; ?></td>
                <td><?php echo $ticket['ref_num']  ;?></td>
                <td><?php echo $ticket['iso_title'] ;?></td>
                <td><?php echo $ticket['from_department']; ?></td>
                <td><?php echo $ticket['department']; ?></td>
                <td><?php if($ticket['is_accepted']){ echo "Accepted"; } else if($ticket['is_rejected']){ echo "Rejected"; } else { echo "Pending";}?></td>
                <td><a href="<?php echo base_url(); ?>nc_register/comments/<?php echo $ticket['id']; ?>">Comments</a></td>
                <td><?php echo $ticket['first_name']." ".$ticket['middle_name']." ".$ticket['last_name'];?></td>
                <td><?php echo date('H:i:a d-M',$ticket['date']); ?></td>
                <td><a href="<?php echo base_url(); ?>nc_register/details/<?php echo $ticket['id']; ?>">Details</a></td>
            
            </tr>
        <?php $i++; } ?>
           
        </tbody>
 </table>
</div>
</div>
</div>

