<html>
    <head>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
    </head>
    <body>
        <div style='text-align: center'>
            <h3>Reff. Gaji Pekerja Keluar</h3>
        </div>
        <div>
        <table style="width:100%" class="table table-bordered table-hover table-striped dataTable">
                <thead class=" bg-primary">
                    <tr>
                        <th style="text-align: center;font-size: 8pt;width: 3%">No</th>
                        <th style="text-align: center;font-size: 8pt;width: 6%">Noind</th>
                        <th style="text-align: center;font-size: 8pt;width: 10%">Nama</th>
                        <th style="text-align: center;font-size: 8pt;width: 15%">Seksi</th>
                        <th style="text-align: center;font-size: 8pt;width: 8%">Tanggal Keluar</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IP</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IK</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UBT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UPAMK</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IF</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">LEMBUR</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">HTM</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">Tambahan</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UM Puasa</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IMS</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IMM</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">IPT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">UM Cabang</th>
                        <th style="text-align: center;font-size: 8pt;width: 8%">Pot. Seragam</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">JKN</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">JHT</th>
                        <th style="text-align: center;font-size: 8pt;width: 5%">JP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data) && !empty($data)) {
                        $angka = 1;
                        foreach ($data as $key) { ?>
                            <tr>
                                <td style="text-align: center;font-size: 8pt"><?=$angka ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['noind'] ?></td>
                                <td style="text-align: left;font-size: 8pt"><?=$key['nama'] ?></td>
                                <td style="text-align: left;font-size: 8pt"><?=$key['seksi'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?php $t = strtotime($key['tgl_keluar']); echo date('d/m/Y',$t); ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ip'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ik'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ubt'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['upamk'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['if'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['lembur'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['htm'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['tambahan'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['um_puasa'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ims'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['imm'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['ipt'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['um_cabang'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['pot_seragam'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jkn'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jht'] ?></td>
                                <td style="text-align: center;font-size: 8pt"><?=$key['jp'] ?></td>
                            </tr>
                        <?php $angka++;
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>