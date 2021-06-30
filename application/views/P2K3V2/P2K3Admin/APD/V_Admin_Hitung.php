<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Hitung Kebutuhan APD</b></h1>
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
                            <div class="box-body">
                                <div class="panel-body" style="">
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/hitung');?>" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Periode</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group col-md-12">
                                                <input placeholder="Masukan Periode" required="" class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" value="<?php echo $pr; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-center" align="right">
                                            <label for="lb_periode" class="control-label">Seksi</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group col-md-12">
                                                <select class="form-control k3_admin_monitorbon" name="k3_seksi" disabled="">
                                                    <option value="">SEMUA SEKSI</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-1 text-left" align="right">
                                        <label for="lb_periode" class="control-label">APD</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group col-md-12">
                                                <select class="form-control select2" name="k3_apd[]" multiple="" data-placeholder="kosongkan untuk semua APD">
                                                    <?php foreach ($master_apd as $key): ?>
                                                        <option value="<?=$key['kode_item']?>"><?=$key['item']?></option>   
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button style="cursor: not-allowed" name="validasi" type="button" class="btn btn-primary p2k3_submit_hitung" value="hitung" data-toggle="tooltip" data-placement="top" title="Silahkan klik button Cek terlebih dahulu">Hitung</button>
                                            <button style="margin-left: 10px;" type="button" class="btn btn-primary p2k3_cek_hitung" disabled="">Cek</button>
                                        </div>
                                    </div>
                                    </form>
                                    <?php if ($run == '1') { ?>
                                    <?php $a = 0; foreach ($listHitung as $key): ?>
                                    <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                        <caption style="color: #000; font-weight: bold;"><?php echo $allKs[$a]['section_name'].' - '.$allKs[$a]['kodesie']; ?>
                                        <button class="p2k3_detail_seksi_hitung btn btn-xs" value="<?php echo $allKs[$a]['kodesie']; ?>">Detail</button> </caption>
                                        <thead>
                                            <tr class="bg-info" style="font-weight: bold;">
                                                <td width="15%">Periode</td>
                                                <td width="15%">Kode Item</td>
                                                <td width="55%">Nama APD</td>
                                                <td width="15%">Jumlah kebutuhan</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($key as $row): ?>
                                                <tr>
                                                    <td><?php echo $pr; ?></td>
                                                    <td>
                                                        <a style="cursor:pointer;" class="p2k3_to_input"><?php echo $row['kode_item']; ?></a>
                                                        <input hidden="" value="<?php echo $row['kode_item']; ?>" class="p2k3_see_apd">
                                                    </td>
                                                    <td>
                                                        <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $row['item']; ?></a>
                                                    </td>
                                                    <td><?php echo $row['0']; ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <?php $a++; endforeach ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="p2k3_cekError" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div style="width: 80%;" class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data yang Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="p2k3_result"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="p2k3_detail_seksi_hitung" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detail Pekerja</h4>
            </div>
            <div class="modal-body">
                <!-- Place to print the fetched phone -->
                <div id="phone_result_seksi_hitung"></div>
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
        $('.p2k3_tanggal_periode').change(function(){
            if ($(this).val().length > 8) {
                $('.p2k3_cek_hitung').attr('disabled', false);
            }else{
                $('.p2k3_cek_hitung').attr('disabled',true);
            }

            $('.p2k3_submit_hitung').css('cursor', 'not-allowed');
            $('.p2k3_submit_hitung').attr('data-original-title', 'Silahkan klik button Cek terlebih dahulu');
            $('.p2k3_submit_hitung').attr('type', 'button');
        });
        $('.k3_admin_monitorbon').change(function(){
            $('.p2k3_cek_hitung').attr('disabled', false);
            
            $('.p2k3_submit_hitung').css('cursor', 'not-allowed');
            $('.p2k3_submit_hitung').attr('data-original-title', 'Silahkan klik button Cek terlebih dahulu');
            $('.p2k3_submit_hitung').attr('type', 'button');
        });
        setTimeout(function(){
            $('.p2k3_tanggal_periode').focus();
        }, 200);
    
        $.ajax({
            type:'POST',
            data:{lokasi_id:'value'},
            url:baseurl+'p2k3adm_V2/Admin/getSeksiAprove2',
            success:function(result)
            {
                $(".k3_admin_monitorbon").prop("disabled",false).html(result);
                $('#surat-loading').attr('hidden', true);
            }
        });
    });
</script>