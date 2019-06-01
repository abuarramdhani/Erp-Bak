<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Input Bon</b></h1>
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
                                    <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/inputBon'); ?>">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Periode : </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group col-md-12">
                                                <input required="" class="form-control monthPicker"  autocomplete="off" type="text" name="k3_periode" id="tanggal" value="<?php echo $pr; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Seksi : </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group col-md-12">
                                                <select required class="form-control k3_admin_standar" name="k3_adm_ks">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Lihat</button>
                                        </div>
                                    </form>
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/submitBon');?>" enctype="multipart/form-data">
                                        <table style="margin-top: 50px;" id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                        <caption style="color: #000;font-weight: bold;"><?php echo $seksi[0]['section_name']; ?></caption>
                                            <thead>
                                                <tr class="bg-info">
                                                    <th>No</th>
                                                    <th>APD</th>
                                                    <th>Jumlah Kebutuhan</th>
                                                    <th>Total Bon Terakhir</th>
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
                                                        <input hidden="" name="p2k3_apd[]" value="<?php echo $key['kode_item']; ?>">
                                                    </td>
                                                    <td>
                                                        <p><?php echo $key['0']; ?></p>
                                                        <input class="p2k3_inKeb" hidden="" name="p2k3_jmlKebutuhan[]" value="<?php echo $key['0']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $key['bon']; ?>
                                                        <input class="p2k3_bont" hidden="" value="<?php echo $key['bon']; ?>">
                                                    </td>
                                                    <td>
                                                        <input class="form-control p2k3_inBon" type="number" name="p2k3_jmlBon[]" required="" min="0">
                                                    </td>
                                                    <td>
                                                        <p style="font-weight: bold;" class="p2k3_pHasil"></p>
                                                        <input hidden="" type="text" class="p2k3_inHasil" name="p2k3_sisaSaldo[]" value="">
                                                    </td>
                                                </tr>
                                                <?php $a++; endforeach ?>
                                            </tbody>
                                        </table>
                                        <input hidden="" name="p2k3_pr" value="<?php echo $pri; ?>">
                                        <input hidden="" name="p2k3_ks" value="<?php echo $ks; ?>">
                                        <div class="col-md-3 pull-right text-right">
                                            <button <?php if ($a == 1) {
                                                echo "disabled";
                                            }else{ echo ""; } ?> type="submit" class="btn btn-success btn-lg" onclick="return confirm('Apa anda yakin Akan Input Bon?')">Input</button>
                                        </div>
                                    </form>
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
        $('tr.multiinput').each(function(){
            var gkeb = $(this).find('input.p2k3_inKeb').val();
            var gbon = $(this).find('input.p2k3_bont').val();
            var hit = Number(gkeb) - Number(gbon);
            $(this).find('input.p2k3_inHasil').val(hit);
            $(this).find('p.p2k3_pHasil').text(hit);
            if ($(this).find('input.p2k3_inHasil').val() < 0) {
                $(this).find('p.p2k3_pHasil').closest('td').css('background-color', '#da251d');
                $(this).find('p.p2k3_pHasil').closest('td').css('color', 'white');
            }else{
                $(this).find('p.p2k3_pHasil').closest('td').css('background-color', '');
                $(this).find('p.p2k3_pHasil').closest('td').css('color', 'black');
            }
        })

        $(".p2k3_inBon").bind("change paste keyup", function() {
            var keb = $(this).closest('tr').find('input.p2k3_inKeb').val();
            var bont = $(this).closest('tr').find('input.p2k3_bont').val();
            var bon = $(this).val();
            var cal = Number(keb) - Number(bont) - Number(bon);
            $(this).closest('tr').find('input.p2k3_inHasil').val(cal);
            $(this).closest('tr').find('p.p2k3_pHasil').text(cal);

            if ($(this).closest('tr').find('input.p2k3_inHasil').val() < 0) {
                $(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('background-color', '#da251d');
                $(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('color', 'white');
            }else{
                $(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('background-color', '');
                $(this).closest('tr').find('p.p2k3_pHasil').closest('td').css('color', 'black');
            }
        });
    });
</script>