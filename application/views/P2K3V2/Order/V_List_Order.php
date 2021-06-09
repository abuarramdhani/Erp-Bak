<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>List Order Kebutuhan APD</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b></b></h1></div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="control-label">Departement</label> <br>
                                            <label class="control-label">Bidang</label> <br>
                                            <label class="control-label">Unit</label> <br>
                                            <label class="control-label">Seksi</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="control-label">: <?php echo $seksi[0]["dept"] ?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]["bidang"] ?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]["unit"] ?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]["section"] ?></label> <button class="btn btn-xs p2k3_detail_seksi" value="<?php echo $seksi[0]['section_code'] ?>">Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="height: 60px;">
                                <!-- <div id="p2k3_addPkj" style="float:right;margin-right:1%;margin-top:0px; margin-bottom: 5px;" alt="Add New" title="Add New">
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </div> -->
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <script>
                                        var jmlOrder = '<?php echo $jmlOrder; ?>';
                                    </script>
                                    <table class="datatable table table-striped table-bordered table-hover text-center tb_p2k3" style="font-size:12px; overflow-x: scroll;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>NO</th>
                                                <th>jumlah Pekerja (STAFF)</th>
                                                <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                <th>Jumlah Pekerja (<?php echo $key['pekerjaan'];?>)</th>
                                                <?php } ?>
                                                <th width="15%">Tanggal Input</th>
                                                <th>Status</th>
                                                <th>Periode</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $a=1; foreach ($tampil_data as $key) { 
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
                                                } 
                                                ?>
                                                <tr>
                                                    <td><?php echo $a; ?></td>
                                                    <td><?php echo $key['jml_pekerja_staff']; ?></td>
                                                    <?php $jml = explode(',', $key['jml_pekerja']);
                                                    if (!empty(trim($key['jml_pekerja']))) {
                                                    foreach ($jml as $row) { ?>
                                                    <td><?php echo $row; ?></td>
                                                    
                                                    <?php }  } ?>
                                                    <td><?php echo $key['tgl_input']; ?></td>
                                                    <td><?php echo $status; ?></td>
                                                    <td><?php echo $key['periode']; ?></td>
                                                    <script>
                                                        var kodesie = '<?php echo $key['kodesie']; ?>';
                                                        // var periode = '<?php echo $key['periode']; ?>';
                                                    </script>
                                                    <!-- <td>
                                                        <button class="btn btn-primary btn-sm p2k3_lihat_detail">Lihat</button>
                                                    </td> -->
                                                    <?php $a++; } ?>
                                                </tr>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>    
            </div>
        </div>
    </section>
    <div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
        <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
    </div>
    <div class="modal fade" id="p2k3_detail_pekerja" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detail Pekerja</h4>
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

    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
     <div class="modal-dialog modal-lg">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h4 class="modal-title" id="myModalLabel">Item Details</h4>
       </div>
       <div class="modal-body">
        <!-- Place to print the fetched phone -->
        <div id="phone_result2"></div>
    </div>
    <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
</div>
</div>
</div>
<!-- modal -->
<div class="modal fade centered-modal" tabindex="-1" role="dialog" id="p2k3_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p id="p2k3_mb">One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
     $(document).ready(function(){
         $('.p2k3_lihat_detail').click(function(){
            $('#surat-loading').attr('hidden', false);
            var periode = $(this).closest('tr').find('td#periode').text();
                $.ajax({
                 url: "<?php echo base_url() ?>P2K3_V2/Order/modal",
                    method: "POST",
                    data: {ks:kodesie,
                        pr:periode},
                    success: function(data){
                     $('#phone_result2').html(data);
                        $('#phoneModal').modal('show');
                        $('#surat-loading').attr('hidden', true);
                    }
                });
         });
     });  
 </script>
