<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Perhitungan APD</b></h1>
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
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/perhitungan');?>" enctype="multipart/form-data">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Periode : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group col-md-12">
                                                <input required="" class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" value="<?php echo $pr; ?>"/>
                                            </div>
                                            <script>
                                                var period = '<?php echo $pr; ?>';
                                                var judul = 'Perhitungan APD periode '+period;
                                            </script>
                                        </div>
                                        <div class="col-md-2">
                                            <button name="validasi" type="submit" class="btn btn-primary" value="hitung">Lihat</button>
                                        </div>
                                    </form>
                                    <div style="height: 50px"></div>
                                    <?php if ($run == '1'): ?>
                                        <h3 style="text-align: center;">Perhitungan APD Selain Tuksono</h3>
                                        <table class="table table-striped table-bordered table-hover text-center p2k3_perhitungan">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th scope="col">No</th>
                                                    <th scope="col">Kode Item</th>
                                                    <th scope="col">APD</th>
                                                    <th scope="col">Jumlah Kebutuhan</th>
                                                    <th scope="col">Outstanding Bon</th>
                                                    <th scope="col">Transact</th>
                                                    <th scope="col">Non Bon</th>
                                                    <th scope="col">Stock Gudang</th>
                                                    <th scope="col">Outstanding PO</th>
                                                    <th scope="col">PO Number</th>
                                                    <th scope="col">Jumlah PP</th>
                                                </tr>
                                            </thead>
                                            <tbody id="DetailInputKebutuhanAPD">
                                                <?php $a = 1; foreach ($toHitung as $key): ?>
                                                <tr style="color: #000;" class="multiinput">
                                                    <td id="nomor"><?php echo $a; ?></td>
                                                    <td>
                                                        <a style="cursor:pointer;" class="p2k3_to_input"><?= $key['item_kode'] ?></a>
                                                        <input hidden="" value="<?= $key['item_kode'] ?>" class="p2k3_see_apd">
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $key['item']; ?></a>
                                                        <input hidden="" class="p2k3_item" type="text" value="<?php echo $key['item']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['jml_kebutuhan']; ?>
                                                        <input hidden="" class="p2k3_kebutuhan" type="text" value="<?php echo $key['jml_kebutuhan']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['outBon']; ?>
                                                        <input hidden="" class="p2k3_ob" type="text" value="<?php echo $key['outBon']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['transact']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($key['jml_kebutuhan']-$key['outBon']); ?>
                                                    </td>
                                                    <td class="p2k3_stok">
                                                        <?php echo $key['stokg']; ?>
                                                    </td>
                                                    <td>
                                                        <p class="p2k3_jpo"><?= $key['po'] ?></p>
                                                    </td>
                                                    <td>
                                                       <?= empty($key['ponum']) ? '-':$key['ponum'] ?>
                                                    </td>
                                                    <td>
                                                        <p class="p2k3_pjpp"><?= $key['jpp'] ?></p>
                                                        <input class="p2k3_ijpp" hidden="" type="text">
                                                    </td>
                                                </tr>
                                                <?php $a++; endforeach ?>
                                            </tbody>
                                        </table>
                                        <div style="height: 50px;"></div>
                                         <h3 style="text-align: center;">Perhitungan APD Tuksono</h3>
                                        <table class="table table-striped table-bordered table-hover text-center p2k3_perhitungan">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th scope="col">No</th>
                                                    <th scope="col">Kode Item</th>
                                                    <th scope="col">APD</th>
                                                    <th scope="col">Jumlah Kebutuhan</th>
                                                    <th scope="col">Outstanding Bon</th>
                                                    <th scope="col">Transact</th>
                                                    <th scope="col">Non Bon</th>
                                                    <th scope="col">Stock Gudang</th>
                                                    <th scope="col">Outstanding PO</th>
                                                    <th scope="col">PO Number</th>
                                                    <th scope="col">Jumlah PP</th>
                                                </tr>
                                            </thead>
                                            <tbody id="DetailInputKebutuhanAPD">
                                                <?php $a = 1; foreach ($toHitung2 as $key): ?>
                                                <tr style="color: #000;" class="multiinput">
                                                    <td id="nomor"><?php echo $a; ?></td>
                                                    <td>
                                                        <a style="cursor:pointer;" class="p2k3_to_input"><?= $key['item_kode'] ?></a>
                                                        <input hidden="" value="<?= $key['item_kode'] ?>" class="p2k3_see_apd">
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $key['item']; ?></a>
                                                        <input hidden="" class="p2k3_item" type="text" value="<?php echo $key['item']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['jml_kebutuhan']; ?>
                                                        <input hidden="" class="p2k3_kebutuhan" type="text" value="<?php echo $key['jml_kebutuhan']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['outBon']; ?>
                                                        <input hidden="" class="p2k3_ob" type="text" value="<?php echo $key['outBon']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['transact']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($key['jml_kebutuhan']-$key['outBon']); ?>
                                                    </td>
                                                    <td class="p2k3_stok">
                                                        <?php echo $key['stokg']; ?>
                                                    </td>
                                                    <td>
                                                        <p class="p2k3_jpo"><?= $key['po'] ?></p>
                                                    </td>
                                                    <td>
                                                       <?= empty($key['ponum']) ? '-':$key['ponum'] ?>
                                                    </td>
                                                    <td>
                                                        <p class="p2k3_pjpp"><?= $key['jpp'] ?></p>
                                                        <input class="p2k3_ijpp" hidden="" type="text">
                                                    </td>
                                                </tr>
                                                <?php $a++; endforeach ?>
                                            </tbody>
                                        </table>
                                   <!--  <button class="btn btn-primary p2k3_exp_perhitungan">
                                        Export CSV
                                    </button>
                                    <button class="btn btn-primary p2k3_exp_perhitungan_pdf">
                                        Export PDF
                                    </button> -->
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
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    $(document).ready(function(){
        var table_p2k3 = $('.p2k3_perhitungan').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            dom: '<"top"i>rt<"bottom"flpB><"clear">',
            buttons: [
            {
                extend: 'excelHtml5',
                title: judul
            },
            {
                extend: 'pdfHtml5',
                title: judul,
                customize: function(doc) {
                    doc.defaultStyle.alignment = 'center';
                    doc.defaultStyle.fontSize = 9;
                } 
            }
            ]
        });
    });
</script>