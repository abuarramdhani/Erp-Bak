<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Monitoring APD TIM</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body" style="overflow-x: scroll;">
                                    <div class="col-md-1 text-left" align="right">
                                        <label for="lb_periode" class="control-label">Periode : </label>
                                    </div>
                                    <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/monitoring');?>" enctype="multipart/form-data">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" style="width: 200px" placeholder="Masukkan Periode" value="<?php echo $pr; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button name="p2k3_admin_monitor" value="1" type="submit" class="btn btn-primary btn-md">Lihat</button>
                                        </div>
                                    </form>
                                    <?php if ($sub == '1'): ?>
                                    <table style="margin-top: 50px;" id="tb_InputKebutuhanAPDs" class="table table-striped table-bordered table-hover text-center">
                                        <caption style="color: #000; font-weight: bold;"><?php 
                                        if ($jumlah[0]['count'] == '0') {
                                            $persen = '0.00';
                                        }else{
                                            $persen = number_format(($jumlahDepan/$jumlah[0]['count']*100), 2);
                                        }
                                         echo $jumlahDepan.' dari '.$jumlah[0]['count'].' seksi yang telah input Order ('.$persen.'%)'; ?>
                                            <button <?php if (strlen($pr) < 1){echo "disabled";} ?> class="btn btn-xs p2k3_btn_sSeksi">Detail</button>
                                        </caption>
                                        <thead>
                                            <tr class="bg-info">
                                                <th>No</th>
                                                <th>Seksi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="DetailInputKebutuhanAPD">
                                            <?php $a=1; foreach ($listOrder as $key) { 
                                                $status = $key['status'];
                                                if ($status == '0') {
                                                    $status = 'Pending';
                                                }else if ($status == '1') {
                                                    $status = 'Approved Atasan';
                                                }else if ($status == '2'){
                                                    $status = 'Reject Atasan';
                                                }else if ($status == '3'){
                                                    $status = 'Approved TIM';
                                                }else{
                                                    $status = 'Reject TIM';
                                                } ?>
                                                <tr style="color: #000;">
                                                    <td id="nomor"><?php echo $a; ?></td>
                                                    <td>
                                                        <?php echo $key['section_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $status; ?>
                                                    </td>
                                                </tr>
                                                <?php $a++; } ?>
                                            </tbody>
                                        </table>
                                    <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Seksi yang Belum Order di Periode Ini</h4>
                </div>
                <div class="modal-body">
                    <!-- Place to print the fetched phone -->
                    <div id="phone_result"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
     // Start jQuery function after page is loaded
     $(document).ready(function(){
         // Start jQuery click function to view Bootstrap modal when view info button is clicked
         $('.p2k3_btn_sSeksi').click(function(){
             // Get the id of selected phone and assign it in a variable called phoneData
             var phoneData = $('#yangPentingtdkKosong').val();
                // Start AJAX function
                $.ajax({
                 // Path for controller function which fetches selected phone data
                 url: "<?php echo base_url() ?>p2k3adm_V2/Admin/detail_seksi",
                    // Method of getting data
                    method: "POST",
                    // Data is sent to the server
                    data: {phoneData:phoneData},
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data){
                     // Print the fetched data of the selected phone in the section called #phone_result 
                     // within the Bootstrap modal
                     $('#phone_result').html(data);
                        // Display the Bootstrap modal
                        $('#phoneModal').modal('show');
                    }
                });
             // End AJAX function
         });
     });  
 </script>