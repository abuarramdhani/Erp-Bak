<?php
    
    foreach ($strukData as $row) {
?>
    <div style="margin-left:20px;margin-right:20px;padding-top:10px;">
        <div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
            <table style="margin: 0 auto;width: 100%">
                <tr>
                    <td style="width: 5%"><img src="<?php echo base_url('assets/img/logo.png')?>" style="width:60px;"></td>
                    <td style="width: 1%">&nbsp;&nbsp;</td>
                    <td style="width: 44%">
                        <h3><b>CV. KARYA HIDUP SENTOSA</b><br>
                        <small style="font-size:12px;">Jl. Magelang No. 144 Yogyakarta 55241</small><br>
                        <small style="font-size:12px;">Telp: (0274)512095,563217 Fax: (0274) 563523</small>
                        </h3>
                    </td>
                    <td align="right">
                        <span style="color: #fff; background-color: #000; padding: 10px;">PRIBADI DAN RAHASIA</span>
                        <br>
                        <br>
                        <small style="font-size:12px;">YANG BERHAK MEMBUKA HANYA YANG NAMANYA TERCANTUM PADA SLIP INI</small>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
            <table style="margin: 0 auto;width: 100%;">
                <tbody>
                    <tr>
                        <td colspan="5" rowspan="3"></td>
                        <td colspan="2">Tgl. Pembayaran</td>
                        <td colspan="4">: <?php echo date('d-m-Y', strtotime($row['tgl_pembayaran']));?></td>
                        <td>Via</td>
                        <td style="width: 1%">:</td>
                        <td>-</td>
                        <td colspan="2">Dept</td>
                        <td colspan="2">: <?php echo $row['department_name'];?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Nama</td>
                        <td colspan="7">: <?php echo $row['noind'].' - '.$row['employee_name'];?></td>
                        <td colspan="2">Unit</td>
                        <td colspan="2">: <?php echo $row['unit_name'];?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Sub.Seksi</td>
                        <td colspan="7">: -</td>
                        <td colspan="2">Seksi</td>
                        <td colspan="2">: <?php echo $row['section_name'];?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="10"></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;width: 3%">1.</td>
                        <td style="vertical-align: top;width: 15%">Gaji Pokok</td>
                        <td style="vertical-align: top;width: 1%">:</td>
                        <td style="vertical-align: top;width: 15%"><?php echo number_format($row['gaji_pokok'], 0, '', '.');?></td>
                        <td style="vertical-align: top;width: 1%">:</td>
                        <td style="vertical-align: top;width: 15%"><?php echo number_format($row['gaji_pokok'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="3"></td>
                        <td style="vertical-align: top;" align="right" colspan="7"><b>LANJUTAN</b></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">2.</td>
                        <td style="vertical-align: top;">Ins. Prest. (OT)</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_insentif_prestasi'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['insentif_prestasi'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;width: 3%">15.</td>
                        <td style="vertical-align: top;width: 15%" colspan="3">Denda Ins. Kond.</td>
                        <td style="vertical-align: top;width: 1%">:</td>
                        <td style="vertical-align: top;width: 15%" colspan="5">-</td>
                        <td style="vertical-align: top;width: 1%">:</td>
                        <td style="vertical-align: top;width: 15%">-</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">3.</td>
                        <td style="vertical-align: top;">Ins. Pnj. (OT)</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">16.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. HTM</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo $row['hitung_pot_htm'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_htm'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">4.</td>
                        <td style="vertical-align: top;">Ins. Kelebihan</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_insentif_kelebihan'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['insentif_kelebihan'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;">17.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. Lebih Bayar</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo $row['pot_lebih_bayar'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_lebih_bayar'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">5.</td>
                        <td style="vertical-align: top;">Ins.Kondite</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_insentif_kondite'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['insentif_kondite'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;">18.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. GP</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo $row['pot_gp'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_gp'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">6.</td>
                        <td style="vertical-align: top;">Ins. Khusus</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;" colspan="9"></td>
                        <td style="vertical-align: top;" align="right">( - )</td>
                        <td style="vertical-align: top;"></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">7.</td>
                        <td style="vertical-align: top;">Ins.Ms.Sore/Mlm</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo '('.$row['hitung_ims'].") + (".$row['hitung_imm'].')';?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['insentif_masuk_sore'] + $row['insentif_masuk_malam'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="4"></td>
                        <td style="vertical-align: top;" align="right" colspan="6"><b>SUB TOTAL 1</b></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'] - $row['pot_htm'] - $row['pot_lebih_bayar'] - $row['pot_gp'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">8.</td>
                        <td style="vertical-align: top;">U.B.T</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_ubt'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['ubt'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="12"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">9.</td>
                        <td style="vertical-align: top;">U.P.A.M.K</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_upamk'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['upamk'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;">19.</td>
                        <td style="vertical-align: top;" colspan="3">Uang DL</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo number_format($row['pot_uang_dl'], 0, '', '.');?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_uang_dl'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">10.</td>
                        <td style="vertical-align: top;">Uang Lembur</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_uang_lembur'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['uang_lembur'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;">20.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. Pajak+SPT</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5">-</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">11.</td>
                        <td style="vertical-align: top;">Tamb.Kurang Byr.</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo $row['hitung_tambah_kurang_bayar'];?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['tambah_kurang_bayar'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="9"></td>
                        <td style="vertical-align: top;" align="right">( - )</td>
                        <td style="vertical-align: top;"></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">12.</td>
                        <td style="vertical-align: top;">Tamb.Lain</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['tambah_lain'], 0, '', '.');?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['tambah_lain'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="4"></td>
                        <td style="vertical-align: top;" align="right" colspan="6"><b>SUB TOTAL 2</b></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'] - $row['pot_htm'] - $row['pot_lebih_bayar'] - $row['pot_gp'] - $row['pot_uang_dl'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">13.</td>
                        <td style="vertical-align: top;">Uand DL</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['uang_dl'], 0, '', '.');?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['uang_dl'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="12"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">14.</td>
                        <td style="vertical-align: top;">Tamb.Pajak+SPT</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">21.</td>
                        <td style="vertical-align: top;" colspan="3">JKN+JHT+JP</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo number_format($row['jkn'], 0, '', '.')." + ".number_format($row['jht'], 0, '', '.')." + ".number_format($row['jp'], 0, '', '.'); ?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['jkn'] + $row['jht'] + $row['jp'], 0, '', '.').",-"; ?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" colspan="6" rowspan="5"></td>
                        <td style="vertical-align: top;">22.</td>
                        <td style="vertical-align: top;" colspan="3">SPSI+Duka</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5">-</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">23.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. Koperasi</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo number_format($row['pot_koperasi'], 0, '', '.');?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_koperasi'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">24.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. Hutang+Lain</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo number_format($row['pot_hutang_lain'], 0, '', '.');?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_hutang_lain'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">25.</td>
                        <td style="vertical-align: top;" colspan="3">Pot. DPLK</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5"><?php echo number_format($row['pot_dplk'], 0, '', '.');?></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['pot_dplk'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">26.</td>
                        <td style="vertical-align: top;" colspan="3">Tamb./Pot. TKP</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;" colspan="5">-</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">-</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" colspan="4"></td>
                        <td style="vertical-align: top;"></td>
                        <td style="vertical-align: top;"></td>
                        <td style="vertical-align: top;" colspan="9"></td>
                        <td style="vertical-align: top;" align="right">( - )</td>
                        <td style="vertical-align: top;"></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" align="right" colspan="4">( + )</td>
                        <td style="vertical-align: top;"></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                        <td style="vertical-align: top;" colspan="4"></td>
                        <td style="vertical-align: top;" align="right" colspan="6"><b>TERIMA BERSIH</b></td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'] - $row['pot_htm'] - $row['pot_lebih_bayar'] - $row['pot_gp'] - $row['pot_uang_dl'] - ($row['jkn'] + $row['jht'] + $row['jp']) - $row['pot_koperasi'] - $row['pot_hutang_lain'] - $row['pot_dplk'], 0, '', '.').",-";?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" colspan="5">Gajiku Berasal dari Uang Pelanggan</td>
                        <td style="vertical-align: top;"><?php echo number_format($row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'], 0, '', '.').",-";?></td>
                        <td style="vertical-align: top;" colspan="10"></td>
                        <td style="vertical-align: top;"></td>
                        <td style="vertical-align: top;"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <pagebreak>
<?php

    }

?>