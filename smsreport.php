<?php

include '../../include/shi-config.php';
include '../../include/functions.php';

$pageTitle = "SMS Reports";

?>
<style>
    input,
    select {
        border: 1px solid #CCC;
        /* width: 250px; */
    }
    .file {
        border: 0;
    }

    input,
    button {
        height: 35px;
        margin: 0;
        padding: 6px 12px;
        border-radius: 2px;
        font-family: inherit;
        font-size: 100%;
        color: inherit;
    }
</style>

<!--app-content open-->
<div class="main-content app-content mt-0">
    <div class="side-app">
        <input type="hidden" id="tabID" value="agents">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header">
                <h1 class="page-title"><a href="javascript:void(0)" class="back-arrow-btn"><i class="fa fa-chevron-left" onclick="history.go(-1)" aria-hidden="true"></i></a><?= ucwords($pageTitle); ?></h1>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= ucwords($pageTitle); ?></li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->

                <?php 

                if(isset($_POST["submit"]))
                                {
                                if($_FILES['excel']['name'])
                                {
                                $filename = explode(".", $_FILES['excel']['name']);
                                if($filename[1] == 'csv')
                                {
                                $handle = fopen($_FILES['excel']['tmp_name'], "r");

                            
                                while($data = fgetcsv($handle))
                                {

                                    $orgDate = $data[10];
                                    $date = str_replace('/', '-', $orgDate);
                                    $newDate = date("Y-m-d", strtotime($date));
                                    // echo "New date format is: ";

                                                $item1 = mysqli_real_escape_string($con, $newDate);  
                                                $item2 = mysqli_real_escape_string($con, $data[6]);
                                              
                                               

                                                
                                                                                                
                                $sql = "INSERT INTO `sms_report1`(`date`,`overall_total`) VALUES ('$item1','$item2')";
                                                
                                                mysqli_query($con, $sql);
                                                //  if(mysqli_query($con, $sql)) {
                                                //      echo "success";
                                                //  } else {
                                                //      echo "not success";
                                                //  }
                                }
                                fclose($handle);
                                 echo '<div class="container mt-3"><div class="alert alert-info alert-dismissible fade show" role="alert">
                                 <strong>Success!</strong> Data inserted.  </div>
                                 </div>
                                 ';
                                
                                }
                                }
                                }
                ?> 


         

            <!-- ROW-1 -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="mt-2">
                                <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row d-flex">
                                                <div class="col-6">
                                                    <span class="font-weight-bold"></span><span class="ms-4 text-danger">* CSV Files only</span>
                                                    <input class="file form-select" type="file" name="excel" id="agdate" placeholder="upload">                         
                                                </div>   
                                                
                                                <div class="col-4 mt-5">
                                                    <button class="btn btn-info px-4" type="submit" name ="submit" id="import">Upload</button>                                                   
                                                </div>
                                            </div>


                                            <br>
                                            <!-- <div class="row">
                                                <div class="col-4">
                                                    <button class="btn btn-info " type="submit" name ="submit" id="import">Insert</button>                                                   
                                                </div>
                                               
                                            </div> -->
                                </form>
                                                
                                                 <div class="row d-flex">
                                                     <div class="col-4 mt-4">
                                                     <input type="date" id="sdate" name="agdate" class="form-select" max="<?php echo date("Y-m-d"); ?>">
                                                     </div>
                                                     <div class="col-6 mt-4 offset-md-2">
                                                        <button class="btn btn-primary" name="show" id="show" onclick="preview()">Go</button>
                                                     </div>
                                                </div>

                                                <!-- <div class="row">
                                                     <div class="col-4 mt-4">
                                                        <button class="btn btn-primary" name="show" id="show" onclick="Summa()">Preview</button>
                                                     </div>
                                                </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW-1 END -->


          
            <!-- ROW-4 -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">

                            <div class="col-lg-4">
                                <h3 class="card-title"><strong>SMS Report</strong></h3>
                            </div>
                            <div class="col-lg-8">
                            </div>

                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap border-bottom" id="ticket_report" style="width:100%;">
                               
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">Date</th>
                                            <!-- <th class="wd-15p border-bottom-0">Time</th> -->
                                            <th class="wd-15p border-bottom-0">Overall total</th>
                                            <th class="wd-20p border-bottom-0">Delivered</th>
                                            <th class="wd-15p border-bottom-0">Total Sent</th>
                                            <th class="wd-15p border-bottom-0">Total Undelivered</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>                                   
                                        <tr>
                                        <td class="wd-15p border-bottom-0" id = "selected_date"></td>
                                        <!-- <td class="wd-15p border-bottom-0" id = "time_btw"></td> -->
                                        <td class="wd-15p border-bottom-0" id = "overall_total"></td>
                                        <td class="wd-20p border-bottom-0" id = "delivered"></td>
                                        <td class="wd-25p border-bottom-0" id=  "total_sent"></td>
                                        <td class="wd-25p border-bottom-0" id = "total_undelivered"></td>                                     
                                                                                                            
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW-4 END -->
        </div>
        <!-- CONTAINER END -->
    </div>
</div>



<!--app-content close-->

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="../../js/common(sp).js"></script>


<script>

   let selected_date = document.getElementById("selected_date");
//    let selected_time = document.getElementById("time_btw");
   let overall_total = document.getElementById("overall_total");
   let success = document.getElementById("delivered");
   let fail = document.getElementById("total_sent");
   let await = document.getElementById("total_undelivered");
    var select_date = document.getElementById("sdate");
   


// $(document).ready(function() {

// $('#import').click(function(e) {
//   e.preventDefault();
//   });
// });

  

    function preview() {
                 selected_date.innerHTML = "";
                //  selected_time.innerHTML = "";
                 overall_total.innerHTML ="";
                 delivered.innerHTML ="";
                 total_sent.innerHTML ="";
                 total_undelivered.innerHTML ="";
              
                 


        var origin = window.location.origin;

        var url = origin + "/ajax/service/sms_ajax.php";

        var in_value = select_date.value; 

        var post_data = {data_inp:in_value};

        console.log(post_data);

        var onsuccess = function(data) {

            var response = JSON.parse(data);
            console.log(response);

          
            overall_total.innerHTML = "" ;
            selected_date.innerHTML = response.date;
            // selected_time.innerHTML = "00:00:00 - 23:59:59";
            overall_total.innerHTML = response.overall;
            delivered.innerHTML = response.delivered;
            total_sent.innerHTML = response.total_sent;
            total_undelivered.innerHTML = response.total_undelivered;
     



            selected_date.innerHTML = response.date;

            
          


        }

        do_ajax_call(post_data, onsuccess, url);

    }

</script>
  <script>
//     var origin = window.location.origin;
//     var url = origin + "/ajax/service/report_services.php";





//     function searchTicket() {
//         var table = $('#ticket_report').DataTable();
//         table.destroy();

//         document.getElementById('searcherr').innerHTML = '';
//         let draw_new_id = $('#draw_new_id').val();
        
//         let agdate = $('#agdate').val();
//         if (draw_new_id != '') {
//             table = $("#ticket_report").DataTable({
//                 pageLength: 10,
//                 order: [],
//                 paging: true,
//                 searching: true,
//                 info: true,
//                 ajax: {
//                     url: url,
//                     method: "POST",
//                     dataSrc: "",
//                     data: {
//                         method: 'searchTicket',
//                         draw_id: draw_new_id,
//                         agdate: agdate
//                     }
//                 },
//                 dom: 'Bfrtip',
//                 buttons: [
//                     'pageLength',
//                     'copy',


//                     {
//                         extend: 'csvHtml5',
//                         title: 'Ticket Reports - ( ' + draw_new_id + '  ' + ticket_name + '  ' + agdate + ' )'
//                     },

//                     {
//                         extend: 'excelHtml5',
//                         title: 'Ticket Reports - ( ' + draw_new_id + '  ' + ticket_name + '  ' + agdate + ' )'
//                     },
//                     {
//                         extend: 'pdfHtml5',
//                         orientation: 'landscape',
//                         pageSize: 'LEGAL',
//                         title: 'Ticket Reports - ( ' + draw_new_id + '  ' + ticket_name + ' ' + agdate + ' )'
//                     }, 'print',

//                 ],
//                 columns: [{
//                         data: "ticketno"
//                     },
//                     {
//                         data: "cusname"
//                     },
//                     {
//                         data: "mobile"
//                     },

//                     {
//                         data: "email"
//                     }
//                     // {
//                     //     data: "My3Numbers"
//                     // },
//                     // {
//                     //     data: "transaction_id"
//                     // },
//                     // {
//                     //     data: "RaffleID"
//                     // },

//                     // {
//                     //     data: "proamt"
//                     // },


//                     // {
//                     //     data: 'agentname'
//                     // },

//                     // {
//                     //     data: "purdate"
//                     // }
//                 ],
//                 footerCallback: function(row, data, start, end, display) {
//                     var api = this.api();

//                     // Remove the formatting to get integer data for summation
//                     var intVal = function(i) {
//                         return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
//                     };

//                     // Total over all pages
//                     total = api
//                         .column(7)
//                         .data()
//                         .reduce(function(a, b) {
//                             return intVal(a) + intVal(b);
//                         }, 0);

//                     // Total over this page
//                     pageTotal = api
//                         .column(7, {
//                             page: 'current'
//                         })
//                         .data()
//                         .reduce(function(a, b) {
//                             return intVal(a) + intVal(b);
//                         }, 0);

//                     // Update footer
//                     $(api.column(7).footer()).html('' + pageTotal + ' ( ' + total + ' total)');
//                 },
//             });
//         } else {
//             // document.getElementById('searcherr').innerHTML = '<div class="alert alert-danger" role="alert">Please Select Draw</div>';
//             toast('error', 'Please Select Draw');
//         }

//     }


//     function paymentSuccess(icon, titlestr) {
//         Swal.fire({
//             title: titlestr,
//             icon: icon,
//             confirmButtonColor: '#3085d6',
//             confirmButtonText: 'OKAY',
//             allowOutsideClick: false
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 agentEarning();
//             }
//         })
//     }

//     function toast(icon, message) {
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 5000,
//             timerProgressBar: true,
//             didOpen: (toast) => {
//                 toast.addEventListener('mouseenter', Swal.stopTimer)
//                 toast.addEventListener('mouseleave', Swal.resumeTimer)
//             }
//         })

//         Toast.fire({
//             icon: icon,
//             title: message
//         })

//     }
 </script> 