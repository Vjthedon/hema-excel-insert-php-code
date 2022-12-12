<?php



include '../../include/shi-config.php';

include '../../include/functions.php';

if(isset($_POST['data_inp'])){

   
     $originalDate = $_POST['data_inp'];
     $sp = date("Y-m-d", strtotime($originalDate));
    // echo json_encode($sp);
    // exit;

    if($sp != ""){

        $contype = "`date` = '$sp'";
     }else{
        $now =date("d-m-Y");
       $contype = "`date` LIKE '%$now%'";
    
     }

// OVERALL
    $conditions = $contype;

    $Overall_data =select_query($con, "`sms_report1`", "`overall_total`",$conditions,'', '');
 
       if($Overall_data['nr'] > 0){
              
         $ov = $Overall_data['nr'];
                   
       } else {
         $ov =  0;       
       }

// DELIVERED

// SELECT *  FROM `sms_report1` WHERE `date` = '2022-12-11' AND `overall_total` LIKE 'Delivered'

    $conditions_delivered = "$contype AND `overall_total` = 'Delivered'";

   $delivered_data =select_query($con, "`sms_report1`", "`overall_total`",$conditions_delivered,'', '');

      if($delivered_data['nr'] > 0){
             
        $de = $delivered_data['nr'];
                  
      } else {
        $de =  0;
       
      }


//TOTAL SENT

      $conditions_total_sent = "$contype AND `overall_total` = 'Sent'";

   $total_sent_data =select_query($con, "`sms_report1`", "`overall_total`",$conditions_total_sent,'', '');

      if($total_sent_data['nr'] > 0){
             
          $se = $total_sent_data['nr'];
                          
      } else {
        $se =  0;
       
      }

      // UN DELIVERED
      $conditions_total_undelivered = "$contype AND `overall_total` = 'Undelivered'";

   $total_undelivered_data =select_query($con, "`sms_report1`", "`overall_total`",$conditions_total_undelivered,'', '');

      if($total_undelivered_data['nr'] > 0){
             
          $un = $total_undelivered_data['nr'];
                 
      } else {
        $un =  0;      
      }


      $final_data = array("overall"=>$ov,"delivered"=>$de,"total_sent"=>$se,"total_undelivered"=>$un,"date"=>$originalDate); 
      echo json_encode($final_data);
      
} else {
    $op ="";
    echo $op;
}

?>

