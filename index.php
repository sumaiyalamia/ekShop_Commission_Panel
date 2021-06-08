<?php

include('database_connection.php');

$month = '';
$query = "SELECT DISTINCT month FROM commission ORDER BY month ASC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
 $month .= '<option value="'.$row['month'].'">'.$row['month'].'</option>';
}

?>

<html>
 <head>
  <title>Commission</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>


body {
  font-family: Arial;
  margin: 0;
  background: #e4eefa;
}

.column {
  float: left;
  width: 40%;
  height: 12%;
}

.header {
  padding: 15px;
  background: #fff;
}
.header img {
  text-align: left;
  margin-top:-20px;
  margin-left: 10px;
  
}

.header h1{
  color: #000;
  font-size: 30px;
  padding-top: 10px;
}

 .footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   height: 13%;
   background-color: white;
}

.copyright{
    padding-top: 50px;
    padding-left: 30px;
}

.hr5{
    color:black;
}

.img{
    text-align: right;
    padding-top: 2px;
    padding-bottom: 2px;
    padding-right: 30px;
    
}

.column1 {
  float: left;
  width: 50%;
  padding: 5px;
}


</style>
  
 </head>
 <body>
 <div class="header">
 <div class="row">
  <div class="column" style="background-color:white;">
<img src="img/3.png" alt="logo" width="160" 
     height="160" />
     </div>
  <div class="column" style="background-color:white;">
   <h1><strong>Agent Commission</strong></h1>
   </div>
   </div>
   </div>
   <br />
<br/>
   <div class="container box">
   <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
     <div class="form-group">
      <select name="filter_month" id="filter_month" class="form-control" required>
       <option value="">Select Month</option>
       <?php echo $month; ?>
      </select>
     </div>
     <div class="form-group">
      <input type="text" name="filter_contact" id="filter_contact" class="form-control"  placeholder="Enter Phone Number"  required>
     </div>
     <div class="form-group" align="center">
      <input type="submit" name="filter" id="filter" class="btn btn-info"></input>
      </div>
    </div>
    </div>
    </div>
    <div class="container box">
    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
   <div class="table-responsive" id="customer_data" style="display:none">
   <table class="table table-bordered">
   <tr>
     <td width="10%" align="center"><b>Month</b></td>
     <td width="10%" align="center"><span id="customer_month"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Name</b></td>
     <td width="10%" align="center"><span id="customer_name"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Phone Number</b></td>
     <td width="10%" align="center"><span id="customer_number"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Commission Received</b></td>
     <td width="10%" align="center"><span id="customer_commission"></span></td>
    </tr>
    <tr>
     <td  width="10%" align="center"><b>Order Amount</b></td>
     <td width="10%" align="center"><span id="customer_amount"></span></td>
    </tr>
     <td width="10%" align="center"><b>Paid Number</b></td>
     <td width="10%" align="center"><span id="customer_pnumber"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Payment Method</b></td>
     <td width="10%" align="center"><span id="customer_pmethod"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Transaction ID</b></td>
     <td width="10%" align="center"><span id="customer_tid"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Partner Name</b></td>
     <td width="10%" align="center"><span id="customer_pname"></span></td>
    </tr>
    <tr>
     <td width="10%" align="center"><b>Note</b></td>
     <td width="10%" align="center"><span id="customer_note"></span></td>
    </tr>
   </table>
   </diV>
   </div>
   </div>
   <br/>
   <br/>
   <br/>
   <br/>
   <br/>
   <div class="container box">
   <div class="footer">
   <div class="row">
  <div class="column1" style="background-color:white;">
  <p class="copyright"><a class="hr5"><strong>&copy; 2021 ekShop. All Rights Reserved</strong></a></p>
  </div>
  <div class="column1" style="background-color:white;">
  <p class="img"><img src="img/4.png" alt="logo" width="400" 
     height="100" /></p>
  </div>
</div>
</div>
 </body>
</html>

<script>
$(document).ready(function(){
  $('#filter').click(function(){
  var filter_month = $('#filter_month').val();
   var filter_contact = $('#filter_contact').val();
   if(filter_month != '' && filter_contact != '')
  {
   $.ajax({
    url:"fetch1.php",
    method:"POST",
    data:{filter_month:filter_month, filter_contact:filter_contact},
    dataType:"JSON",
    success:function(data)
    {
     $('#customer_data').css("display", "block");
     $('#customer_month').text(data.month);
     $('#customer_name').text(data.mName);
     $('#customer_number').text(data.contact);
     $('#customer_commission').text(data.cReceived);
     $('#customer_amount').text(data.oAmount);
     $('#customer_pnumber').text(data.pNumber);
     $('#customer_pmethod').text(data.pMethod);
     $('#customer_tid').text(data.tID);
     $('#customer_pname').text(data.pName);
     $('#customer_note').text(data.note);
    },
    error:function(data){
      alert('No record found');
    }
   })
  }
  });
 });
</script>
