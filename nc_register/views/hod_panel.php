
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Datatable</title>-->

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
<!--
</head>
<body>
-->


<div class="row-fluid" style="min-height: 220px; width: 1000px; margin-left: 10px;">
      <div class="box span12" style="margin: 40px;">
            <div class="box-header well">
                    <h2><i class="icon-bookmark"></i> Unclosed ticket against your department</h2>
                    <!--
                    <div class="box-icon">
                            <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
                            <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                            <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                    </div>
                    -->
            </div>
            <div class="box-content" style="min-height: 220px;">


<table id="example" style="width: 99%; margin-left: 5px;" class="table table-striped table-bordered table-condensed bootstrap-datatable datatable index_table">
        <thead>
            <tr>
                <th>Reference No.</th>
                <th>Objective</th>
                <th>Detail</th>
                <th>Impact</th>
                <th>Department</th>
                <th>Raised By</th>
                <th>Request to close</th>
                <th>Add comments</th>
            </tr>
        </thead>
 
        <tbody>
        <?php foreach($tickets as $ticket){?>
            <tr> 
                <td><?php echo $ticket['ref_num'];?></td>
                <td><?php echo $ticket['iso_title'];?></td>
                <td><?php echo $ticket['details'];?></td>
                <td><?php echo $ticket['impact'];?></td>
                <td><?php echo $ticket['department'];?></td>
                <td><?php echo $ticket['first_name']." ".$ticket['middle_name']." ".$ticket['last_name'];?></td>
                <td><a href="<?php echo base_url(); ?>nc_register/rtc/<?php echo $ticket['id']; ?>">Request to close</a></td>
                <td><a href="<?php echo base_url(); ?>nc_register/comments/<?php echo $ticket['id']; ?>">Comments</a></td>


            </tr>
        <?php }?>
           
        </tbody>
    </table>
</div>
</div>
</div>
<!--
</html>
-->

