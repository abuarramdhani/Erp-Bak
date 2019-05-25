<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Sarana P2K3</b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">
                        <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3_V2/Order');?>">
                            <i class="icon-wrench icon-2x"></i>
                            <span><br/></span>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b></b></h1></div>
                        </div>
                        <div class="panel panel-primary" style="height: 110px;">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="control-label">Departement</label> <br>
                                            <label class="control-label">Bidang</label> <br>
                                            <label class="control-label">Unit</label> <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="control-label">: <?php echo $seksi[0]['dept']?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]['bidang']?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]['unit']?></label> <br>
                                        </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body"><b>PERHATIAN!!! <br>Pastikan order barang APD (Alat Perlindungan Diri) anda sudah di setujui oleh admin, silahkan hubungi admin masing-masing seksi agar segera disetujui dan dapat di proses. Terimakasih.</b></div>
                        </div>
                    </div>
                </div>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="height: 60px;">
                            </div>
                            <div class="box-body">
                                   
                                <div class="table-responsive">
                                    <table id="tb_p2k3" class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th width="5%" style="text-align: center">NO</th>
                                                <th width="13%" style="text-align: center">PERIODE</th>
                                                <th width="15%" style="text-align: center">TANGGAL KIRIM</th>
                                                <th style="text-align: center">STATUS</th>
                                                <th width="10%" style="text-align: center">DETAIL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1;
                                                foreach ($tampil_data as $row) {
                                                    $id_kebutuhan = $row['id_kebutuhan'];
                                            ?> 
                                             <tr>
                                                <td style="text-align: center;"><?php echo $no?></td>
                                                <td style="text-align: center;" name=""><?php echo date('F Y', strtotime($row['periode']));?></td>
                                                <td style="text-align: center;"><?php echo date('d F Y', strtotime($row['periode']));?></td>
                                                <td style="text-align: center;"> 
                                                    <?php if ($row['checked_status'] == "f") {
                                                        echo "Unchecked";
                                                        } else{
                                                            echo "Checked";
                                                            }?>
                                                </td>
                                                <td>
                                                    <center><input type="button" class="btn btn-info btn-sm view_data" value="View Info" id="<?php echo $row['id_kebutuhan']; ?>">
                                                    </center>
                                                </td>
                                            </tr>    
                                            <?php 
                                            $no++;
                                                }

                                            ?>
                                        </tbody>     
                                    </table>
                                </div>
                                    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
                                       <div class="modal-dialog modal-lg">
                                         <div class="modal-content">
                                           <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                             <h4 class="modal-title" id="myModalLabel">Item Details</h4>
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
                            </div>
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </div>
</section>
<script type="text/javascript">
     // Start jQuery function after page is loaded
        $(document).ready(function(){
         // Start jQuery click function to view Bootstrap modal when view info button is clicked
            $('.view_data').click(function(){
             // Get the id of selected phone and assign it in a variable called phoneData
                var phoneData = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                 // Path for controller function which fetches selected phone data
                    url: "<?php echo base_url() ?>P2K3_V2/Order/detail",
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
