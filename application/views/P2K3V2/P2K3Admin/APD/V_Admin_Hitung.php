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
                                <div class="panel-body" style="overflow-x: scroll;">
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/hitung');?>" enctype="multipart/form-data">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Periode : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group col-md-12">
                                                <input required="" class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" value="<?php echo $pr; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button name="validasi" type="submit" class="btn btn-primary" value="hitung">Hitung</button>
                                        </div>
                                    </form>
                                    <?php if ($run == '1') { ?>
                                    <?php $a = 0; foreach ($listHitung as $key): ?>
                                    <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                        <caption style="color: #000; font-weight: bold;"><?php echo $allKs[$a]['section_name'].' - '.$allKs[$a]['kodesie']; ?></caption>
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
                                                    <td><?php echo $row['kode_item']; ?></td>
                                                    <td><?php echo $row['item']; ?></td>
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