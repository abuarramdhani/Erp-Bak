<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>HARI EFEKTIF BULANAN</center></b></h2>
			</div>
            <div class="box-body">
                <form method="post" id="formlimit" action="<?php echo base_url('SettingMinMax/SaveHariEffektif')?>">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-2" style="text-align: right;">
                                <label>Tahun : </label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="tahun" id="tahun" style="width: 250px">
                                <?php 
                                    for ($i=0; $i < sizeof($optionTahun); $i++) { 
                                        if ($i === 10) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="'.$optionTahun[$i].'"'.$selected.'>'.$optionTahun[$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <p style="color:red; font-size:10px;">*Pilih Tahun yang Sudah Ada Untuk Update</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-6" style="text-align: right;">
                                <label>Januari : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="januari" name="januari" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Februari : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="februari" name="februari" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Maret : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="maret" name="maret" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>April : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="april" name="april" style="width:100px;" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        
                        <div class="col-md-6" style="text-align: right;">
                                <label>Mei : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="mei" name="mei" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Juni : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="juni" name="juni" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Juli : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="juli" name="juli" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Agustus : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="agustus" name="agustus" style="width:100px;" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        
                        <div class="col-md-6" style="text-align: right;">
                                <label>September : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="september" name="september" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Oktober : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="oktober" name="oktober" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>November : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="november" name="november" style="width:100px;" value="0"/>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                                <label>Desember : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="desember" name="desember" style="width:100px;" value="0"/>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5" style="text-align: right;">
                            <input type="hidden" id="user" name="user" value="<?= $user ?>">
                            <button class="btn btn-success" type="submit"><span class="fa fa-save"></span> SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-body">
                <div class="col-md-12">
                        <table class="tbleffectiveDays table table-striped table-bordered table-hover" id="tbleffectiveDays" style="width:100%">
                            <thead class="">
                                <tr style="font-size: 12px; background-color: #EF8455; color: white; text-align: center;">
                                    <th rowspan="2" style="text-align: center;">NO</th>
                                    <th rowspan="2" style="text-align: center;">TAHUN</th>
                                    <th colspan="12" style="text-align: center;">BULAN</th>
                                    <th rowspan="2" style="text-align: center;">LAST UPDATE</th>
                                    <th rowspan="2" style="text-align: center;">LAST UPDATE BY</th>
                                    <!-- <th style="text-align: center;">ACTION</th> -->
                                </tr>
                                <tr style="font-size: 12px; background-color: #EF8455; color: white; text-align: center;">
                                <th style="text-align: center;">JANUARI</th>
                                    <th style="text-align: center;">FEBRUARI</th>
                                    <th style="text-align: center;">MARET</th>
                                    <th style="text-align: center;">APRIL</th>
                                    <th style="text-align: center;">MEI</th>
                                    <th style="text-align: center;">JUNI</th>
                                    <th style="text-align: center;">JULI</th>
                                    <th style="text-align: center;">AGUSTUS</th>
                                    <th style="text-align: center;">SEPTEMBER</th>
                                    <th style="text-align: center;">OKTOBER</th>
                                    <th style="text-align: center;">NOVEMBER</th>
                                    <th style="text-align: center;">DESEMBER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=0; $i < sizeof($HariEfektif); $i++) { ?>
                                    <tr style="font-size: 12px; text-align: center;">
                                        <td><?= $i+1 ?></td>
                                        <td><?=$HariEfektif[$i]['TAHUN'] ?></td>
                                        <td><?=$HariEfektif[$i]['JANUARI'] ?></td>
                                        <td><?=$HariEfektif[$i]['FEBRUARI'] ?></td>
                                        <td><?=$HariEfektif[$i]['MARET'] ?></td>
                                        <td><?=$HariEfektif[$i]['APRIL'] ?></td>
                                        <td><?=$HariEfektif[$i]['MEI'] ?></td>
                                        <td><?=$HariEfektif[$i]['JUNI'] ?></td>
                                        <td><?=$HariEfektif[$i]['JULI'] ?></td>
                                        <td><?=$HariEfektif[$i]['AGUSTUS'] ?></td>
                                        <td><?=$HariEfektif[$i]['SEPTEMBER'] ?></td>
                                        <td><?=$HariEfektif[$i]['OKTOBER'] ?></td>
                                        <td><?=$HariEfektif[$i]['NOVEMBER'] ?></td>
                                        <td><?=$HariEfektif[$i]['DESEMBER'] ?></td>
                                        <td><?=$HariEfektif[$i]['LAST_UPDATE'] ?></td>
                                        <td><?=$HariEfektif[$i]['LAST_UPDATE_BY'] ?></td>
                                        <!-- <td><span class="btn btn-primary">Edit</span></td> -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
	</div>
</section>