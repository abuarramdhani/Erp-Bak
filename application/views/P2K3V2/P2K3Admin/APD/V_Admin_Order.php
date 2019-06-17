<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Kebutuhan Order</b></h1>
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
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/order');?>" enctype="multipart/form-data">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Seksi : </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group col-md-12">
                                                <select disabled="" required class="form-control k3_admin_monitorbon" name="k3_adm_ks">
                                                    <option value="semua">SEMUA SEKSI</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Periode : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group col-md-12">
                                                <input required="" class="form-control monthPicker"  autocomplete="off" type="text" name="k3_periode" id="tanggal" value="<?php echo $pr; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Lihat</button>
                                        </div>
                                    </form>
                                    <table style="margin-top: 50px;" id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                        <caption style="color: #000; font-weight: bold;"><?php echo $seksi[0]['section_name']; ?></caption>
                                        <thead>
                                            <tr class="bg-info">
                                                <th>No</th>
                                                <th>APD</th>
                                                <th>Kode Barang</th>
                                                <th>Jumlah Kebutuhan</th>
                                                <th>Jumlah Bon</th>
                                                <th>Sisa Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="DetailInputKebutuhanAPD">
                                            <?php $a=1; foreach ($listtobon as $key): ?>
                                            <tr style="color: #000;" class="multiinput">
                                                <td id="nomor"><?php echo $a; ?></td>
                                                <td>
                                                    <?php echo $key['item']; ?>
                                                </td>
                                                <td>
                                                <?php echo $key['item_kode']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['jml_kebutuhan']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['ttl_bon']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['sisa_saldo']; ?>
                                                </td>
                                            </tr>
                                            <?php $a++; endforeach ?>
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
<script>
    $(document).ready(function(){
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