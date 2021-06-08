<?php
include('database_connection.php');
session_start();
if(!isset($_SESSION['user_email']))
header("Location:login.php");
use Phppot\DataSource;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
require_once ('./vendor/autoload.php');

if (isset($_POST["import"])) {

    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $targetPath = 'uploads/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        for ($i = 0; $i <= $sheetCount; $i ++) {
            $pName = "";
            if (isset($spreadSheetAry[$i][0])) {
                $pName = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
            }
            $month = "";
            if (isset($spreadSheetAry[$i][1])) {
                $month = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
            }
            $mEmail = "";
            if (isset($spreadSheetAry[$i][1])) {
                $mEmail = mysqli_real_escape_string($conn, $spreadSheetAry[$i][2]);
            }
            $cName = "";
            if (isset($spreadSheetAry[$i][1])) {
                $cName = mysqli_real_escape_string($conn, $spreadSheetAry[$i][3]);
            }
            $mName = "";
            if (isset($spreadSheetAry[$i][1])) {
                $mName = mysqli_real_escape_string($conn, $spreadSheetAry[$i][4]);
            }
            $contact = "";
            if (isset($spreadSheetAry[$i][1])) {
                $contact = mysqli_real_escape_string($conn, $spreadSheetAry[$i][5]);
            }
            $oAmount = "";
            if (isset($spreadSheetAry[$i][1])) {
                $oAmount = mysqli_real_escape_string($conn, $spreadSheetAry[$i][6]);
            }
            $cReceived = "";
            if (isset($spreadSheetAry[$i][1])) {
                $cReceived = mysqli_real_escape_string($conn, $spreadSheetAry[$i][7]);
            }
            $pMethod = "";
            if (isset($spreadSheetAry[$i][1])) {
                $pMethod = mysqli_real_escape_string($conn, $spreadSheetAry[$i][8]);
            }
            $pNumber = "";
            if (isset($spreadSheetAry[$i][1])) {
                $pNumber = mysqli_real_escape_string($conn, $spreadSheetAry[$i][9]);
            }
            $tID = "";
            if (isset($spreadSheetAry[$i][1])) {
                $tID = mysqli_real_escape_string($conn, $spreadSheetAry[$i][10]);
            }    
            $note = "";
            if (isset($spreadSheetAry[$i][1])) {
                $note = mysqli_real_escape_string($conn, $spreadSheetAry[$i][11]);
            }
            if (! empty($pName) || ! empty($month) || ! empty($mEmail) || ! empty($cName) || ! empty($mName) || ! empty($contact) || ! empty($oAmount) || ! empty($cReceived) || ! empty($pMethod) || ! empty($pNumber) || ! empty($tID) || ! empty($note)) {
                $query = "insert into commission(pName,month,mEmail,cName,mName,contact,oAmount,cReceived,pMethod,pNumber,tID,note) values('" . $pName . "','" . $month . "','" . $mEmail . "','" . $cName . "','" . $mName . "','" . $contact . "','" . $oAmount . "','" . $cReceived . "','" . $pMethod . "','" . $pNumber . "','" . $tID . "','" . $note . "')";
                $result = mysqli_query($conn, $query);
               
               
                if (empty($insertId)) {
                    $type = "success";
                    $message = "Excel Data Imported into the Database";
                } else {
                    $type = "error";
                    $message = "Problem in Importing Excel Data";
                }
            }
        }
    } else {
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
    }
}

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
  
    $query = "SELECT * FROM `commission` WHERE CONCAT(`pName`, `month`, `mEmail`, `cName`, `mName`, `contact`,`oAmount`, `cReceived`,`pMethod`,`pNumber`,`tID`,`note`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `commission`";
    $search_result = filterTable($query);
}


function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "commission");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}



?>

<!DOCTYPE html>
<html>
<head>
<title>Commission</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
         *{
			padding: 0;
			margin:0;
			box-sizing: border-box;
			
		}
		body{
			display:flex;
			align-items:center;
			flex-direction: column;
			font-family: "Raleway", sans-serif;
			background: #FBFCFC;
		}
		h1{
            text-align: center;
		       	margin-top: 24px;
            text-transform: uppercase;
			      font-weight: 300;
            color: white;
            font-size: 30px;
			      color: #000;
		}

    .outer-container {
     background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
	border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
	padding: 5px 20px;
	font-size: 0.9em;
}


#response {
	padding: 10px;
	margin-top: 10px;
	border-radius: 2px;
	display: none;
}

.success {
	background: #c7efd9;
	border: #bbe2cd 1px solid;
}

.error {
	background: #fbcfcf;
	border: #f3c6c7 1px solid;
}

div#response.display-block {
	display: block;
}

.log{
    align:right;
    padding-left: 1000px;
    
}

table,tr,th,td {
 border: 1px solid black;
 border-collapse: collapse;
}

table.center {
margin-left: auto; 
margin-right: auto;
 }

.input-group{
  width: 100%;
  position: relative;
  display: flex;
}



</style>
</head>

<body>
    <h1><u>Micromerchant Monthly Commission List</u></h1><br />
    <div class="log">
    <a href="logout.php"><input type="submit" name="logout" id="logout" class="btn-submit"  value="Logout" /></a>
  </div>
    <div class="outer-container">
        <form action="" method="post" name="frmExcelImport"
            id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel File</label> <input type="file"
                    name="file" id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>

            </div>

        </form>
       
    </div>
    <div id="response"
        class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
        <br/>
        <br/>
        <div class="box"> 
        <form action="dashboard.php" method="post">
        <div class="form-group">
				<div class="input-group">
					<input type="text" name="valueToSearch" id="search" placeholder="Search here"  class="form-control" />
          <br/>
          <input type="submit" name="search"  class="btn" value="Filter"><br><br>
        
         </div>
			</div>
      <div style="clear:both"></div>
		<br />
    </div>
    </div>
            <br/>
            <br/>
            
            <table class="center">
                <tr>
                <th>Partner Name</th>
                <th>Month</th>
                <th>Merchant e-mail address</th>
                <th>Center name</th>
                <th>Merchant Name</th>
                <th>Contact</th>
                <th>Order Amount</th>
                <th>Commission Received</th>
                <th>Payment Method</th>
                <th>Paid Number</th>
                <th>Transaction ID</th>
                <th>Note</th>
                </tr>

                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['pName'];?></td>
                    <td><?php echo $row['month'];?></td>
                    <td><?php echo $row['mEmail'];?></td>
                    <td><?php echo $row['cName'];?></td>
                    <td><?php echo $row['mName'];?></td>
                    <td><?php echo $row['contact'];?></td>
                    <td><?php echo $row['oAmount'];?></td>
                    <td><?php echo $row['cReceived'];?></td>
                    <td><?php echo $row['pMethod'];?></td>
                    <td><?php echo $row['pNumber'];?></td>
                    <td><?php echo $row['tID'];?></td>
                    <td><?php echo $row['note'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
</body>
</html>