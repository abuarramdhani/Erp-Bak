<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Data Gajian Personalia</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/DataGajianPersonalia/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Data Gajian Personalia
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <?php if (validation_errors() <> '') {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4><i class="fa fa-times"></i> &nbsp; Error! Please check the following errors:</h4>';
                                echo validation_errors(); 
                                echo "</div>";
                            }
                                ?>
                                <div class="row">
									<div class="form-group">
	                                            <label for="txtTanggal" class="control-label col-lg-4">Tanggal</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggal" value="<?php echo $tanggal ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTanggal" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Noind" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdHubunganKerja" class="control-label col-lg-4">Kd Hubungan Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Hubungan Kerja" name="txtKdHubunganKerja" id="txtKdHubunganKerja" class="form-control" value="<?php echo $kd_hubungan_kerja; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdStatusKerja" class="control-label col-lg-4">Kd Status Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Status Kerja" name="txtKdStatusKerja" id="txtKdStatusKerja" class="form-control" value="<?php echo $kd_status_kerja; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdJabatan" class="control-label col-lg-4">Kd Jabatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Jabatan" name="txtKdJabatan" id="txtKdJabatan" class="form-control" value="<?php echo $kd_jabatan; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKodesie" class="control-label col-lg-4">Kodesie</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kodesie" name="txtKodesie" id="txtKodesie" class="form-control" value="<?php echo $kodesie; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIp" class="control-label col-lg-4">Ip</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ip" name="txtIp" id="txtIp" class="form-control" value="<?php echo $ip; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIk" class="control-label col-lg-4">Ik</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ik" name="txtIk" id="txtIk" class="form-control" value="<?php echo $ik; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIF" class="control-label col-lg-4">I F</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="I F" name="txtIF" id="txtIF" class="form-control" value="<?php echo $i_f; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIfHtgBlnLalu" class="control-label col-lg-4">If Htg Bln Lalu</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="If Htg Bln Lalu" name="txtIfHtgBlnLalu" id="txtIfHtgBlnLalu" class="form-control" value="<?php echo $if_htg_bln_lalu; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUbt" class="control-label col-lg-4">Ubt</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ubt" name="txtUbt" id="txtUbt" class="form-control" value="<?php echo $ubt; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUpamk" class="control-label col-lg-4">Upamk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Upamk" name="txtUpamk" id="txtUpamk" class="form-control" value="<?php echo $upamk; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUm" class="control-label col-lg-4">Um</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Um" name="txtUm" id="txtUm" class="form-control" value="<?php echo $um; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIms" class="control-label col-lg-4">Ims</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ims" name="txtIms" id="txtIms" class="form-control" value="<?php echo $ims; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtImm" class="control-label col-lg-4">Imm</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Imm" name="txtImm" id="txtImm" class="form-control" value="<?php echo $imm; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtLembur" class="control-label col-lg-4">Lembur</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Lembur" name="txtLembur" id="txtLembur" class="form-control" value="<?php echo $lembur; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtHtm" class="control-label col-lg-4">Htm</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Htm" name="txtHtm" id="txtHtm" class="form-control" value="<?php echo $htm; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIjin" class="control-label col-lg-4">Ijin</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ijin" name="txtIjin" id="txtIjin" class="form-control" value="<?php echo $ijin; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtHtmHtgBlnLalu" class="control-label col-lg-4">Htm Htg Bln Lalu</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Htm Htg Bln Lalu" name="txtHtmHtgBlnLalu" id="txtHtmHtgBlnLalu" class="form-control" value="<?php echo $htm_htg_bln_lalu; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIjinHtgBlnLalu" class="control-label col-lg-4">Ijin Htg Bln Lalu</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ijin Htg Bln Lalu" name="txtIjinHtgBlnLalu" id="txtIjinHtgBlnLalu" class="form-control" value="<?php echo $ijin_htg_bln_lalu; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPot" class="control-label col-lg-4">Pot</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Pot" name="txtPot" id="txtPot" class="form-control" value="<?php echo $pot; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtTambGaji" class="control-label col-lg-4">Tamb Gaji</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Tamb Gaji" name="txtTambGaji" id="txtTambGaji" class="form-control" value="<?php echo $tamb_gaji; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtHl" class="control-label col-lg-4">Hl</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Hl" name="txtHl" id="txtHl" class="form-control" value="<?php echo $hl; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtCt" class="control-label col-lg-4">Ct</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ct" name="txtCt" id="txtCt" class="form-control" value="<?php echo $ct; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPutkop" class="control-label col-lg-4">Putkop</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Putkop" name="txtPutkop" id="txtPutkop" class="form-control" value="<?php echo $putkop; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPlain" class="control-label col-lg-4">Plain</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Plain" name="txtPlain" id="txtPlain" class="form-control" value="<?php echo $plain; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPikop" class="control-label col-lg-4">Pikop</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Pikop" name="txtPikop" id="txtPikop" class="form-control" value="<?php echo $pikop; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPspsi" class="control-label col-lg-4">Pspsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Pspsi" name="txtPspsi" id="txtPspsi" class="form-control" value="<?php echo $pspsi; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPutang" class="control-label col-lg-4">Putang</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Putang" name="txtPutang" id="txtPutang" class="form-control" value="<?php echo $putang; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtDl" class="control-label col-lg-4">Dl</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Dl" name="txtDl" id="txtDl" class="form-control" value="<?php echo $dl; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtTkpajak" class="control-label col-lg-4">Tkpajak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Tkpajak" name="txtTkpajak" id="txtTkpajak" class="form-control" value="<?php echo $tkpajak; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtTtpajak" class="control-label col-lg-4">Ttpajak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ttpajak" name="txtTtpajak" id="txtTtpajak" class="form-control" value="<?php echo $ttpajak; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPduka" class="control-label col-lg-4">Pduka</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Pduka" name="txtPduka" id="txtPduka" class="form-control" value="<?php echo $pduka; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUtambahan" class="control-label col-lg-4">Utambahan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Utambahan" name="txtUtambahan" id="txtUtambahan" class="form-control" value="<?php echo $utambahan; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtBtransfer" class="control-label col-lg-4">Btransfer</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Btransfer" name="txtBtransfer" id="txtBtransfer" class="form-control" value="<?php echo $btransfer; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtDendaIk" class="control-label col-lg-4">Denda Ik</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Denda Ik" name="txtDendaIk" id="txtDendaIk" class="form-control" value="<?php echo $denda_ik; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPLebihBayar" class="control-label col-lg-4">P Lebih Bayar</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="P Lebih Bayar" name="txtPLebihBayar" id="txtPLebihBayar" class="form-control" value="<?php echo $p_lebih_bayar; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPgp" class="control-label col-lg-4">Pgp</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Pgp" name="txtPgp" id="txtPgp" class="form-control" value="<?php echo $pgp; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtTlain" class="control-label col-lg-4">Tlain</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Tlain" name="txtTlain" id="txtTlain" class="form-control" value="<?php echo $tlain; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtXduka" class="control-label col-lg-4">Xduka</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Xduka" name="txtXduka" id="txtXduka" class="form-control" value="<?php echo $xduka; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKet" class="control-label col-lg-4">Ket</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ket" name="txtKet" id="txtKet" class="form-control" value="<?php echo $ket; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtCicil" class="control-label col-lg-4">Cicil</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Cicil" name="txtCicil" id="txtCicil" class="form-control" value="<?php echo $cicil; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUbs" class="control-label col-lg-4">Ubs</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ubs" name="txtUbs" id="txtUbs" class="form-control" value="<?php echo $ubs; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUbsRp" class="control-label col-lg-4">Ubs Rp</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ubs Rp" name="txtUbsRp" id="txtUbsRp" class="form-control" value="<?php echo $ubs_rp; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPUmPuasa" class="control-label col-lg-4">P Um Puasa</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="P Um Puasa" name="txtPUmPuasa" id="txtPUmPuasa" class="form-control" value="<?php echo $p_um_puasa; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdJnsTransaksi" class="control-label col-lg-4">Kd Jns Transaksi</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Jns Transaksi" name="txtKdJnsTransaksi" id="txtKdJnsTransaksi" class="form-control" value="<?php echo $kd_jns_transaksi; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Petugas" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglJamRecord" class="control-label col-lg-4">Tgl Jam Record</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglJamRecord" value="<?php echo $tgl_jam_record ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglJamRecord" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtKdLogTrans" class="control-label col-lg-4">Kd Log Trans</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Log Trans" name="txtKdLogTrans" id="txtKdLogTrans" class="form-control" value="<?php echo $kd_log_trans; ?>"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtIdGajianPersonalia" value="<?php echo $id_gajian_personalia; ?>" /> </div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>