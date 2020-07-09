<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Riwayat Order</b></h1>
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
                                        <label for="lb_periode" class="control-label">Seksi : </label>
                                    </div>
                                    <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/RiwayatOrder');?>" enctype="multipart/form-data">
                                        <div class="col-md-5">
                                            <div class="input-group col-md-12">
                                                <select required class="form-control k3_admin_standar" name="k3_adm_ks" placeholder="Masukkan Periode">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-md">Tampilkan</button>
                                        </div>
                                    </form>
                                    <div style="margin-top: 20px;" class="col-md-12 text-center">
                                        <h4 style="color: #000; font-weight: bold;">
                                            <?php  if (!empty($seksi) || !isset($seksi)) {
                                               echo $seksi[0]['section_name'];
                                           } ?>
                                       </h4>
                                   </div>
                                   <table class="datatable table table-striped table-bordered table-hover text-center tb_p2k3" style="font-size:12px; overflow-x: scroll;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>NO</th>
                                            <th style="min-width: 90px;">Action</th>
                                            <th>jumlah Pekerja (STAFF)</th>
                                            <?php foreach ($daftar_pekerjaan as $key) { ?>
                                            <th>Jumlah Pekerja (<?php echo $key['pekerjaan'];?>)</th>
                                            <?php } ?>
                                            <th width="15%">Tanggal Input</th>
                                            <th>Status</th>
                                            <th>Periode</th>
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
                                                <script>
                                                    var kodesie = '<?php echo $key['kodesie']; ?>';
                                                </script>
                                                <td>
                                                    <button class="btn btn-primary btn-sm p2k3_lihat_detail">Lihat</button>
                                                    <a class="btn btn-danger btn-sm" style="margin-right:4px" href="<?php echo site_url('p2k3adm_V2/Admin/hapusRiwayatOrder/'.$key['id'].'/'.$key['kodesie']); ?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="Hapus" onclick="return confirm('Apa anda yakin ingin Menghapus data order ini?')">
                                                        <span class="fa fa-trash"></span>
                                                    </a>
                                                </td>
                                                <td><?php echo $key['jml_pekerja_staff']; ?></td>
                                                <?php $jml = explode(',', $key['jml_pekerja']);
                                                foreach ($jml as $row) { if($row == '') continue; ?>
                                                <td><?php echo $row; ?></td>
                                                <?php  } ?>
                                                <td><?php echo $key['tgl_input']; ?></td>
                                                <td><?php echo $status; ?></td>
                                                <td id="periode"><?php echo $key['periode']; ?></td>
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
    <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
       <div class="modal-dialog modal-lg">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title" id="myModalLabel">Item Details</h4>
         </div>
         <div class="modal-body">
            <div id="phone_result"></div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
 </div>
</div>
</div>
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
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
                     $('#phone_result').html(data);
                        $('#surat-loading').attr('hidden', true);
                        $('#phoneModal').modal('show');
                    }
                });
         });
     });  
 </script>