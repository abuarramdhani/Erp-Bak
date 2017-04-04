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
                        <td style="width: 3%">1.</td>
                        <td style="width: 15%">Gaji Pokok</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 15%"><?php echo $row['gaji_pokok'];?></td>
                        <td style="width: 1%">:</td>
                        <td style="width: 15%"><?php echo $row['gaji_pokok'];?></td>
                        <td colspan="3"></td>
                        <td align="right" colspan="7"><b>LANJUTAN</b></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Ins. Prest. (OT)</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_insentif_prestasi'];?></td>
                        <td>:</td>
                        <td><?php echo $row['insentif_prestasi'];?></td>
                        <td style="width: 3%">15.</td>
                        <td style="width: 15%" colspan="3">Denda Ins. Kond.</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 15%" colspan="5">-</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 15%">-</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Ins. Pnj. (OT)</td>
                        <td>:</td>
                        <td>-</td>
                        <td>:</td>
                        <td>-</td>
                        <td>16.</td>
                        <td colspan="3">Pot. HTM</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['hitung_pot_htm'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_htm'];?></td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Ins. Kelebihan</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_insentif_kelebihan'];?></td>
                        <td>:</td>
                        <td><?php echo $row['insentif_kelebihan'];?></td>
                        <td>17.</td>
                        <td colspan="3">Pot. Lebih Bayar</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['pot_lebih_bayar'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_lebih_bayar'];?></td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Ins.Kondite</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_insentif_kondite'];?></td>
                        <td>:</td>
                        <td><?php echo $row['insentif_kondite'];?></td>
                        <td>18.</td>
                        <td colspan="3">Pot. GP</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['pot_gp'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_gp'];?></td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Ins. Khusus</td>
                        <td>:</td>
                        <td>-</td>
                        <td>:</td>
                        <td>-</td>
                        <td colspan="9"></td>
                        <td align="right">( - )</td>
                        <td></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>Ins.Ms.Sore/Mlm</td>
                        <td>:</td>
                        <td><?php echo '('.$row['hitung_ims'].") + (".$row['hitung_imm'].')';?></td>
                        <td>:</td>
                        <td><?php echo $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'];?></td>
                        <td colspan="4"></td>
                        <td align="right" colspan="6"><b>SUB TOTAL 1</b></td>
                        <td>:</td>
                        <td><?php echo $row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'] - $row['pot_htm'] - $row['pot_lebih_bayar'] - $row['pot_gp'];?></td>
                    </tr>
                    <tr>
                        <td>8.</td>
                        <td>U.B.T</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_ubt'];?></td>
                        <td>:</td>
                        <td><?php echo $row['ubt'];?></td>
                        <td colspan="12"></td>
                    </tr>
                    <tr>
                        <td>9.</td>
                        <td>U.P.A.M.K</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_upamk'];?></td>
                        <td>:</td>
                        <td><?php echo $row['upamk'];?></td>
                        <td>19.</td>
                        <td colspan="3">Uang DL</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['pot_uang_dl'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_uang_dl'];?></td>
                    </tr>
                    <tr>
                        <td>10.</td>
                        <td>Uang Lembur</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_uang_lembur'];?></td>
                        <td>:</td>
                        <td><?php echo $row['uang_lembur'];?></td>
                        <td>20.</td>
                        <td colspan="3">Pot. Pajak+SPT</td>
                        <td>:</td>
                        <td colspan="5">-</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>11.</td>
                        <td>Tamb.Kurang Byr.</td>
                        <td>:</td>
                        <td><?php echo $row['hitung_tambah_kurang_bayar'];?></td>
                        <td>:</td>
                        <td><?php echo $row['tambah_kurang_bayar'];?></td>
                        <td colspan="9"></td>
                        <td align="right">( - )</td>
                        <td></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                    </tr>
                    <tr>
                        <td>12.</td>
                        <td>Tamb.Lain</td>
                        <td>:</td>
                        <td><?php echo $row['tambah_lain'];?></td>
                        <td>:</td>
                        <td><?php echo $row['tambah_lain'];?></td>
                        <td colspan="4"></td>
                        <td align="right" colspan="6"><b>SUB TOTAL 2</b></td>
                        <td>:</td>
                        <td><?php echo $row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'] - $row['pot_htm'] - $row['pot_lebih_bayar'] - $row['pot_gp'] - $row['pot_uang_dl'];?></td>
                    </tr>
                    <tr>
                        <td>13.</td>
                        <td>Uand DL</td>
                        <td>:</td>
                        <td><?php echo $row['uang_dl'];?></td>
                        <td>:</td>
                        <td><?php echo $row['uang_dl'];?></td>
                        <td colspan="12"></td>
                    </tr>
                    <tr>
                        <td>14.</td>
                        <td>Tamb.Pajak+SPT</td>
                        <td>:</td>
                        <td>-</td>
                        <td>:</td>
                        <td>-</td>
                        <td>21.</td>
                        <td colspan="3">JKN+JHT+JP</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['jkn']." + ".$row['jht']." + ".$row['jp']; ?></td>
                        <td>:</td>
                        <td><?php echo $row['jkn'] + $row['jht'] + $row['jp']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" rowspan="5"></td>
                        <td>22.</td>
                        <td colspan="3">SPSI+Duka</td>
                        <td>:</td>
                        <td colspan="5">-</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>23.</td>
                        <td colspan="3">Pot. Koperasi</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['pot_koperasi'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_koperasi'];?></td>
                    </tr>
                    <tr>
                        <td>24.</td>
                        <td colspan="3">Pot. Hutang+Lain</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['pot_hutang_lain'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_hutang_lain'];?></td>
                    </tr>
                    <tr>
                        <td>25.</td>
                        <td colspan="3">Pot. DPLK</td>
                        <td>:</td>
                        <td colspan="5"><?php echo $row['pot_dplk'];?></td>
                        <td>:</td>
                        <td><?php echo $row['pot_dplk'];?></td>
                    </tr>
                    <tr>
                        <td>26.</td>
                        <td colspan="3">Tamb./Pot. TKP</td>
                        <td>:</td>
                        <td colspan="5">-</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td></td>
                        <td></td>
                        <td colspan="9"></td>
                        <td align="right">( - )</td>
                        <td></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="4">( + )</td>
                        <td></td>
                        <td><hr style="height: 2px; color: #000; background-color: #000; margin: 0; padding: 0;"></td>
                        <td colspan="4"></td>
                        <td align="right" colspan="6"><b>TERIMA BERSIH</b></td>
                        <td>:</td>
                        <td><?php echo $row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'] - $row['pot_htm'] - $row['pot_lebih_bayar'] - $row['pot_gp'] - $row['pot_uang_dl'] - ($row['jkn'] + $row['jht'] + $row['jp']) - $row['pot_koperasi'] - $row['pot_hutang_lain'] - $row['pot_dplk'];?></td>
                    </tr>
                    <tr>
                        <td colspan="5">Gajiku Berasal dari Uang Pelanggan</td>
                        <td><?php echo $row['gaji_pokok'] + $row['insentif_prestasi'] + $row['insentif_kelebihan'] + $row['insentif_kondite'] + $row['insentif_masuk_sore'] + $row['insentif_masuk_malam'] + $row['ubt'] + $row['upamk'] + $row['uang_lembur'] + $row['tambah_kurang_bayar'] + $row['tambah_lain'] + $row['uang_dl'];?></td>
                        <td colspan="10"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <pagebreak>
<?php

    }

?>