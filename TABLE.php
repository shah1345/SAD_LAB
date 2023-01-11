<?php

include 'config.php';


//https://binimoy.shahxauto.com/TableApi.php?Query=Paid

$Type= $_GET["Query"];

$Device = $_GET["Type"]; 

/*
'<td><a href="process.php?delete='.$row['Sl'].'" class="btn btn-outline-primary">Received</a></td>
                        <td><button type="button" class="btn btn-outline-primary editbtn"  onclick="EditeButton(this)"> EDIT </button></td>
                      </tr>';

*/


if($Type=="Pending"){

$query = "SELECT `Sl`, `D_ID`, `Nozzle`, Q_RPM, `Q_L`, `Q_P`, `TimeStemp`, `Time_NF`,Status, `FirmwareVer`,Tran_ID FROM `AutoMotion` WHERE Status = 'Pending' AND D_ID = $Device";
} else if($Type=="Paid") {
    
  $limit= $_GET["lim"];  
    
    $query = "SELECT `Sl`, `D_ID`, `Nozzle`, Q_RPM, `Q_L`, `Q_P`, `TimeStemp`, `Time_NF`,Status, `FirmwareVer`,Tran_ID , POSOperator FROM `AutoMotion` WHERE Status = 'Paid'  ORDER By Sl DESC LIMIT  $limit" ;
    
  
}


//echo $query;
if (!$result = mysqli_query($conn, $query)) {
    exit(mysqli_error($conn));
    //echo mysqli_error($con);
}// else echo "Failed";


if($Type=="Pending"){
 $users = '
                    <table class="table table-striped">
                      <tr>
                      
                      
                         <th class="text-center">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                              class="custom-control-input" id="checkbox-all">
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                        </th>
                        
                        
                        
                        
                        <th>#NO</th>
                        <th>Fuel Pump</th>
                        <th>Nozzle</th>
                        <th>Liter</th>
                        <th>Price</th>
                        <th>Status</th>
                         <th>Transaction ID</th>
                        <th>Date</th>
                        <th  colspan="3">Action</th>
                         
                      </tr>';
  $badge= "badge badge-danger";                    
} else {
    
     $users = '
                    <table class="table table-striped">
                      <tr>
                        <th class="text-center">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                              class="custom-control-input" id="checkbox-all">
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                        </th>
                        <th>#NO</th>
                        <th>Fuel Pump</th>
                        <th>Nozzle</th>
                        <th>Liter</th>
                        <th>Price</th>
                        <th>Status</th>
                         <th>Transaction ID</th>
                        <th>Date</th>
                        <th>POS Operator</th>
                         
                      </tr>';
   $badge= "badge badge-success";
    
    
}                   
                      
if (mysqli_num_rows($result) > 0) {
    $number = 1;
   
    


    
    while ($row = mysqli_fetch_assoc($result)) {  
      //  $value =$row['amount'] / 170 ;
      
      $String =" L";
      

    //  SELECT `Sl`, `D_ID`, `Nozzle`, `Q_L`, `Q_P`, `TimeStemp`, `Time_NF` 
    
      if($row['Nozzle']=="A"){
          $NoZZ=" A1";
          
      } else  $NoZZ="A2";
    
    
    
  $daten= date('m/d/Y H:i:s', $row['TimeStemp']);
    
   $IST = new DateTime($daten, new DateTimeZone('UTC')); // change the timezone of the object without changing it's time
    $IST->setTimezone(new DateTimeZone('Asia/Dhaka')); // format the datetime 
   // echo $IST->format('Y-m-d h:i:s a T');
    
$Tnid= str_pad($row['Tran_ID'],4,"0",STR_PAD_LEFT) ;



$Q_L = round(($row['Q_RPM'] * 0.016820292),2) ;       //0.0168202920002691 0.01685


$whole = intval($Q_L); // 1234
$decimal1 = $Q_L - $whole; // 0.44000000000005 uh oh! that's why it needs... (see next line)
$decimal2 = round($decimal1, 2); // 0.44 this will round off the excess numbers
$decimal = substr($decimal2, 2); // 44 this removed the first 2 characters

if($decimal!="")
$lastDigit_L = ($decimal % 10);
if($lastDigit_L==9){
   $Q_L+=0.01;
  
  
}
 else if($lastDigit_L>=8){
 $Q_L= round($Q_L,PHP_ROUND_HALF_UP);
}


$Q_P = $Q_L * 89;



   $Q_FP = round($Q_P,0,PHP_ROUND_HALF_UP);
$lastDigit = $Q_FP % 10;
if($lastDigit==9){
   $Q_FP= round($Q_P,0,PHP_ROUND_HALF_UP)+1;
    
} else if($lastDigit==1){
     $Q_FP= round($Q_P,0,PHP_ROUND_HALF_UP)-1;
}

//$Q_FL = round($Q_FP/89,2 );  

/*

      <td>'.number_format(($Q_FP/89), 2, '.', '').$String.'</td>
                        <td>'.$Q_FP. " Tk".'</td>

*/


if($row['D_ID']==10001){
    $D_Name="Octane";
  
    
} else $D_Name="Diesel";

        $users .= ' <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-'.$number.'">
                            <label for="checkbox-'.$number.'" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        
                        
                        
        
        <td>'.$number.'</td>
                        <td > '.$D_Name.'</td>
                        <td>'.$NoZZ.'</td>
                        <td>'.$row['Q_L'].$String.'</td>
                        <td>'.$row['Q_P']. " Tk".'</td>
                        <td>
                          
                         <div class="'.$badge.'">'.$row['Status'].'</div>
                        </td>
                          <td>'.$IST->format('Y-m-d')."-".$Tnid. '</td>
                          <td>'. $IST->format('Y-m-d h:i:s a') .'</td>
  ';
      if($Type=="Pending"){
        $users .= '<td><button type="button" class="btn btn-outline-primary rechbtn"  onclick="RecBut(this)">Received</a></td>
        <td><button type="button" class="btn btn-outline-primary editbtn"  onclick="EditeButton(this)"> POST </button></td>
                        <td><button type="button" class="btn btn-outline-primary fixbtn"  onclick="FixBut(this)"> Fixed </button></td>
                           
          
           
                      </tr>';
        
      } else {
               $users .= '<td>'.$row['POSOperator'].'</td>
                      </tr>';   
          
      }
        
        
        
        
        $number++;
    }
    $users .= '</table>';
}



if($users!='')echo $users ;


?>



           <!--    
           
            <td><button type="button" class="btn btn-outline-primary editbtn"  onclick="EditeButton(this)"> EDIT </button></td>
           
           
           <table class="table table-striped">
                      <tr>
                        <th class="text-center">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                              class="custom-control-input" id="checkbox-all">
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                        </th>
                        <th>#NO</th>
                        <th>Device ID</th>
                        <th>Nozzle</th>
                        <th>Liter</th>
                        <th>Price</th>
                        <th>Status</th>
                         <th>Transaction ID</th>
                        <th>Date</th>
                        <th  colspan="2">Action</th>
                         
                      </tr>
                     


                          
                           <?php //if($users!='')echo $users ;?> 
                          
                          
                          
                          
                      
                    </table>
-->


