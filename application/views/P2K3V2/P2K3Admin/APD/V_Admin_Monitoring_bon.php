<style>
    .table-sm td,
    .table-sm th{padding:.1rem}
    td.details-control {
        background: url('../../assets/img/icon/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../../assets/img/icon/details_close.png') no-repeat center center;
    }
    div.slider {
        display: none;
    }

    table.dataTable tbody td.no-padding {
        padding: 0;
    }
    #p2k3_img{
        transition: transform 0.8s;
    }
    #p2k3_img:hover{
     transform: rotate(180deg);
 }
</style>
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
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/monitoringBon');?>" enctype="multipart/form-data">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Seksi : </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group col-md-12">
                                                <select required class="form-control k3_admin_monitorbon" name="k3_adm_ks">
                                                    <option value="semua" selected="">SEMUA SEKSI</option>
                                                    <!-- <option value="semua">SEMUA SEKSI</option> -->
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
                                    <div style="margin-top: 50px;"></div>
                                    <script>
                                        var kodes = '<?php echo $kodesie; ?>';
                                        var period = '<?php echo $period; ?>';
                                    </script>
                                    <table style="margin-top: 50px; width: 100%;" class="table table-striped table-bordered table-hover text-center p2k3_monitoringbon">
                                        <caption style="color: #000; font-weight: bold;"><?php echo $seksi[0]['section_name']; ?></caption>
                                        <thead class="bg-primary">
                                            <tr>
                                                <th></th>
                                                <!-- <th>No</th> -->
                                                <th>Nomor Bon</th>
                                                <th>Tanggal Bon</th>
                                                <th>Seksi pengebon</th>
                                                <th>Gudang</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="DetailInputKebutuhanAPD">
                                            <?php $a=1; foreach ($monitorbon as $key): ?>
                                            <tr style="color: #000;" class="multiinput">
                                                <td>
                                                    <a class="p2k3_row_swow" href="#"><img class="1" id="p2k3_img" src="../../assets/img/icon/details_open.png"></a>
                                                    <input hidden="" value="<?php echo $a; ?>">
                                                </td>
                                                <!-- <td id="nomor"><?php echo $a; ?></td> -->
                                                <td>
                                                    <?php echo $key['no_bon']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['tgl_bon']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['seksi_pengebon']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['tujuan_gudang']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['keterangan']; ?>
                                                </td>
                                            </tr>
                                            <?php $clas = 'p2k3_row'.$a; ?>
                                            <tr>
                                                <td style="padding: 0px;" colspan="7">
                                                    <div hidden="" class="<?php echo $clas; ?>">
                                                        <table class="table table-xs table-bordered">
                                                            <thead class="bg-info">
                                                                <tr>
                                                                    <td>No</td>
                                                                    <td>Kode Item</td>
                                                                    <td>Nama Item</td>
                                                                    <td>Jumlah Bon</td>
                                                                    <td>Satuan</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php   $kode = explode(',', $key['kode_barang']);
                                                                $apd = explode(',', $key['nama_apd']);
                                                                $jml = explode(',', $key['jml_bon']);
                                                                $satuan = explode(',', $key['satuan']); 
                                                                $lim = count($kode); ?>
                                                                <?php for ($i=0; $i < $lim; $i++) { ?>
                                                                <tr>
                                                                    <td><?php echo ($i+1); ?></td>
                                                                    <td><?php echo $kode[$i]; ?></td>
                                                                    <td><?php echo $apd[$i]; ?></td>
                                                                    <td><?php echo $jml[$i]; ?></td>
                                                                    <td><?php echo $satuan[$i]; ?></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
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