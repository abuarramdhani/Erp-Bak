<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Data Masuk</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                <br>
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left p2k3_tbl_datamasuk" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th width="5%" style="text-align: center; vertical-align: middle;">NO</th>
                                                <th width="50%" style="text-align: center; vertical-align: middle;">Seksi</th>
                                                <th width="15%" style="text-align: center; vertical-align: middle;">Tanggal Input</th>
                                                <th width="20%" style="text-align: center; vertical-align: middle;">Tanggal Approve ASKANIT</th>
                                                <th style="text-align: center; width: 105px; vertical-align: middle;">ACTION</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($namaSeksi as $row) {
                                                $ks = $row['kodesie'];
                                                $pr = $row['periode'];
                                                $appr = str_replace(' ', '_', $row['tgl_approve_atasan']);
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $no; ?></td>
                                                    <td style="text-align: center;"><?php echo $row['section_name']; ?></td>
                                                    <td style="text-align: center;"><?php echo $row['periode']; ?></td>
                                                    <td style="text-align: center;"><?php echo $row['tgl_approve_atasan']; ?></td>
                                                    <td style="text-align: center;">
                                                        <center>
                                                            <a methode class="btn btn-default" href="<?php echo site_url('p2k3adm_V2/datamasuk/lihat?ks=' . $ks . '&pr=' . $pr . '&appr=' . $appr); ?>">Lihat</a>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>