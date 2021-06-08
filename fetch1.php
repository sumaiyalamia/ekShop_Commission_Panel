<?php
if(isset($_POST['filter_month'], $_POST['filter_contact']) && $_POST['filter_month'] != '' && $_POST['filter_contact'] != '')
{
 $connect = mysqli_connect("localhost", "root", "", "commission");
 $query = "SELECT * FROM commission WHERE month = '".$_POST["filter_month"]."' AND contact like '%".$_POST["filter_contact"]."'";
 $result = mysqli_query($connect, $query);
 while($row = mysqli_fetch_array($result))
 {
  $data["month"] = $row["month"];
  $data["mName"] = $row["mName"];
  $data["contact"] = $row["contact"];
  $data["cReceived"] = $row["cReceived"];
  $data["oAmount"] = $row["oAmount"];
  $data["pNumber"] = $row["pNumber"];
  $data["pMethod"] = $row["pMethod"];
  $data["tID"] = $row["tID"];
  $data["pName"] = $row["pName"];
  $data["note"] = $row["note"];
}

 echo json_encode($data);
}
?>