<style type="text/css">
    @media print {
        .header-print {
            display: table-header-group;
        }
    }
    .dataTables_wrapper .dataTables_processing {
        position: absolute;
        margin-top: 20px;
        padding-top: 16px;
        padding-bottom: 40px;
        text-align: center;
        font-size: 1.2em;
        z-index: 999;
    }
    #datepicker, #filterPeriode {
        cursor: pointer;
    }
    input, td.input-frame, td.fade-transition {
        -webkit-transition: background-color 250ms linear;
        -moz-transition: background-color 250ms linear;
        -o-transition: background-color 250ms linear;
        -ms-transition: background-color 250ms linear;
        transition: background-color 250ms linear;
    }
    input.uppercase {
        text-transform: uppercase;
    }
    .dataTable_Button {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-bottom: 1px;
    }
    .dataTable_Filter {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-bottom: 1px;
    }
    .dataTable_Information {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-top: 7px;
    }
    .dataTable_Pagination {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-top: 14px;
    }
    .dataTable_Processing {
        z-index: 999;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-8">
                            <div class="text-left">
                                <h1><b><?= $Title ?></b></h1>
                                <h2 style="margin-top: -4px;"><?= $EmployeeInfo ?></h2>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-right">
                                <h1 style="visibility: hidden;">-</h1>
                                <h3><b>Status: </b><span 
                                <?php
                                    switch(strtolower($type)) {
                                        case 'unapproved':
                                            echo 'style="color: #ffb74d"';
                                            break;
                                        case 'approved':
                                            echo 'style="color: #4CAF50"';
                                            break;
                                        case 'rejected':
                                            echo 'style="color: #FF5252"';
                                            break;
                                    }
                                ?>
                                ><?= ($type == 'unapproved') ? 'Request Approval' : $type ?></span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <div class="col-lg-9" style="display: flex; justify-content: flex-start;">
                                    <div class="col-md-2">
                                        <label style="margin-top: 6px;" class="control-label">Pilih Periode :</label>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group date" id="datepicker" data-provide="datepicker" data-date="<?= $filterPeriode ?>" style="width: 300px;">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                            <input id="filterPeriode" type="text" class="form-control" placeholder="Periode" value="<?= $filterPeriode ?>" readonly/>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                $(document).off('.datepicker.data-api');
                                                $('#datepicker').datepicker({
                                                    format: 'mm/yyyy',
                                                    minViewMode: 'months'
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="col-md-1">
                                        <form id="formFilterLkhPekerja" action="<?= base_url('LkhPekerjaBatch/TargetWaktu/Detail'); ?>" method="POST">
                                            <input id="currentLkhPekerjaData1" value="<?= $filterPeriode; ?>" hidden/>
                                            <input id="currentLkhPekerjaData2" name="filterPekerja" value="<?= $filterPekerja; ?>" hidden/>
                                            <input id="formFilterLkhPekerjaData1" name="filterPeriode" hidden/>
                                            <button style="margin-top: 2px;" class="btn btn-default btn-sm" type="submit">Tampilkan</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div>
                                        <a onclick="javascript:location.reload();" data-toggle="tooltip" data-placement="left" style="float:right;margin-top:-0.5%;" alt="Refresh Halaman" title="Refresh Data">
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh fa-2x"></i></button>
                                        </a>
                                        <form action="<?= base_url('LkhPekerjaBatch/TargetWaktu/'.$listType); ?>" method="POST">
                                            <input type="text" name="filterPeriode" value="<?= $filterPeriode; ?>" hidden />
                                            <a type="submit" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:3%;margin-top:-0.5%;" alt="Kembali ke halaman sebelumnya" title="Kembali ke halaman sebelumnya">
                                                <button class="btn btn-default btn-sm"><i class="fa fa-arrow-left fa-2x"></i></button>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="info-box" style="padding: 16px; display: none;">
                                <i id="info-box-icon" aria-hidden="true" class="fa
                                <?php
                                    switch(strtolower($type)) {
                                        case 'unapproved':
                                            echo 'fa-pencil-square';
                                            break;
                                        case 'approved':
                                            echo 'fa-check';
                                            break;
                                        case 'rejected':
                                            echo 'fa-ban';
                                            break;
                                    }
                                ?>"></i>
                                <b id="info-box-text" style="margin-left: 8px">
                                <?php
                                    switch(strtolower($type)) {
                                        case 'unapproved':
                                            echo 'LKH Pekerja sudah di kirim ke atasan. Anda tidak bisa mengubahnya sebelum di periksa oleh atasan.';
                                            break;
                                        case 'approved':
                                            echo 'LKH Pekerja sudah di approve oleh atasan. Anda sudah tidak bisa mengubahnya.';
                                            break;
                                        case 'rejected':
                                            echo 'LKH Pekerja di tolak oleh atasan. Mohon untuk merevisi data lkh.';
                                            break;
                                    }
                                ?>
                                </b>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left table-responsive" id="tblLkhPekerjaDetail" style="width: 100%;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align: center;" title="Nomor">No</th>
                                                <th style="text-align: center;" title="Tanggal Absen">Tanggal</th>
                                                <th class="text-center" title="Kegiatan atau pekerjaan yang dilakukan">Kegiatan</th>
                                                <th class="text-center" title="Target / Tidak Target">T / TT</th>
                                                <th class="text-center" title="Target dalam menit">Target (Menit)</th>
                                                <th class="text-center" title="Aktual dalam menit">Aktual (Menit)</th>
                                                <th class="text-center" title="Rerata aktual dalam persen">Aktual %</th>
                                                <th class="text-center" title="Nilai kondite MK (Mulai Kerja)">MK</th>
                                                <th class="text-center" title="Nilai kondite I (Istirahat)">I</th>
                                                <th class="text-center" title="Nilai kondite BK (Berhenti Kerja)">BK</th>
                                                <th class="text-center" title="Nilai kondite TK (Tindak tanduk dan Kepatuhan)">TK</th>
                                                <th class="text-center" title="Nilai kondite KP (Kebersihan dan Perawatan)">KP</th>
                                                <th class="text-center" title="Nilai kondite KS (Kerja Sama)">KS</th>
                                                <th class="text-center" title="Nilai kondite KK (Kemauan Kerja)">KK</th>
                                                <th class="text-center" title="Nilai kondite PK (Prestasi Kerja)">PK</th>
                                                <th class="text-center" title="Golongan kondite">Gol.</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(isset($dateList)) {
                                                    if(empty($dataList)) {
                                                        for($i = 0; $i < count($dateList); $i++) {
                                                            echo('<tr>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">'.($i + 1).'.</div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center; width: 110px;">'.$dateList[$i]['formatted_date'].'</div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">Tidak ada data absen</div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                            echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                            echo('</tr>');
                                                        }
                                                    } else {
                                                        $count = 0;
                                                        for($i = 0; $i < count($dateList); $i++) {
                                                            if(!empty($dataList[$count]['date']) && $dataList[$count]['date'] == $dateList[$i]['date']) {
                                                                switch(strtolower($type)) {
                                                                    case 'draft':
                                                                    case 'rejected':
                                                                        echo('<span id="lkh-id-row-'.$count.'" style="display: none;">'.$dataList[$count]['lkh_id'].'</span>');
                                                                        echo('<tr>');
                                                                        echo('<td><div style="text-align: center;">'.($i + 1).'.</div></td>');
                                                                        echo('<td style="width: 110px;"><div style="text-align: center;">'.$dateList[$i]['formatted_date'].'</div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input type="text" onfocusin="onFocusIn($(this));" onfocusout="onFocusOut($(this));" data-row="'.$count.'" data-column="uraian_pekerjaan" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)" style="width: 140px;" value="'.$dataList[$count]['uraian_pekerjaan'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input type="text" onfocusin="onFocusIn($(this));" onfocusout="onFocusOut($(this));" data-row="'.$count.'" data-column="status_target" maxlength="2" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" value="'.$dataList[$count]['status_target'].'"/></div></td>');
                                                                        echo('<td><div style="text-align: center;">'.$dataList[$count]['target'].'</div></td>');
                                                                        echo('<td><div style="text-align: center;">'.$dataList[$count]['aktual'].'</div></td>');
                                                                        echo('<td><div style="text-align: center;">'.$dataList[$count]['aktual_persen'].'</div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_mk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_mk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_i" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_i'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_bk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_bk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_tk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_tk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_kp" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_kp'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_ks" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_ks'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_kk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_kk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_pk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_pk'].'"/></div></td>');
                                                                        echo('<td class="fade-transition"><div style="text-align: center;"><b id="gol-kondite-'.$dataList[$count]['lkh_id'].'">'.$dataList[$count]['gol_kondite'].'</b></div></td>');
                                                                        echo('</tr>');
                                                                        break;
                                                                    case 'unapproved':
                                                                    case 'approved':
                                                                        echo('<span id="lkh-id-row-'.$count.'" style="display: none;">'.$dataList[$count]['lkh_id'].'</span>');
                                                                        echo('<tr>');
                                                                        echo('<td><div style="text-align: center;">'.($i + 1).'.</div></td>');
                                                                        echo('<td style="width: 110px;"><div style="text-align: center;">'.$dateList[$i]['formatted_date'].'</div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled type="text" data-row="'.$count.'" data-column="uraian_pekerjaan" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)" style="width: 140px;" value="'.$dataList[$count]['uraian_pekerjaan'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled type="text" data-row="'.$count.'" data-column="status_target" maxlength="2" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" value="'.$dataList[$count]['status_target'].'"/></div></td>');
                                                                        echo('<td><div style="text-align: center;">'.$dataList[$count]['target'].'</div></td>');
                                                                        echo('<td><div style="text-align: center;">'.$dataList[$count]['aktual'].'</div></td>');
                                                                        echo('<td><div style="text-align: center;">'.$dataList[$count]['aktual_persen'].'</div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_mk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_mk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_i" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_i'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_bk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_bk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_tk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_tk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_kp" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_kp'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_ks" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_ks'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_kk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_kk'].'"/></div></td>');
                                                                        echo('<td class="input-frame"><div style="text-align: center;"><input disabled data-row="'.$count.'" data-column="kondite_pk" maxlength="1" oninput="this.value = this.value.toUpperCase()" style="width: 25px; text-align: center;" type="text" value="'.$dataList[$count]['kondite_pk'].'"/></div></td>');
                                                                        echo('<td class="fade-transition"><div style="text-align: center;"><b id="gol-kondite-'.$dataList[$count]['lkh_id'].'">'.$dataList[$count]['gol_kondite'].'</b></div></td>');
                                                                        echo('</tr>');
                                                                        break;
                                                                }
                                                                $count++;
                                                            } else {
                                                                echo('<tr>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">'.($i + 1).'.</div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center; width: 110px;">'.$dateList[$i]['formatted_date'].'</div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">Tidak ada data absen</div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;"><input style="width: 25px;" type="text" disabled/></div></td>');
                                                                echo('<td style="background-color: #FFA000; font-weight: bold;"><div style="text-align: center;">-</div></td>');
                                                                echo('</tr>');
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<div style="padding: 12px 18px 4px 18px; background-color: #3C8DBC; color: white;" class="box-footer" <?= (empty($recordPekerjaan) && empty($rerataGolonganKondite) && empty($warningSP)) ? 'hidden' : ''; ?>>
								<b style="font-size: 1.6rem;">Kesimpulan :</b>
								<ul style="margin-top: 6px;">
									<?= (empty($recordPekerjaan)) ? '' : '<li id="txt-record-pekerjaan"><b>Record Pekerjaan : </b>'.$recordPekerjaan.'</li>'; ?>
									<?= (empty($nilaiInsentifKondite)) ? '' : '<li id="txt-rerata-golkondite"><b>Penilaian Insentif Kondite : </b>'.$nilaiInsentifKondite.'</li>'; ?>
									<?= (empty($warningSP)) ? '' : '<li style="color: red;" id="txt-warning-sp"><b>Mendapat SP Bawah Prestasi karena pada tanggal '.$warningSP.' tidak mencapai target.</b></li>'; ?>
								<ul>
							</div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>
<script type="text/javascript">
    var employee_name = '<?= trim($EmployeeName) ?>';
    var employee_code = '<?= trim($filterPekerja) ?>';
    var stringCache = '';
    <?php
        switch(strtolower($type)) {
            case 'draft':
                echo '$("#info-box").hide();';
                break;
            case 'unapproved':
                echo '$("#info-box").css({"padding": "16px", "background-color": "#ffb74d"});';
                echo '$("#info-box").show();';
                break;
            case 'approved':
                echo '$("#info-box").css({"padding": "16px", "background-color: "#4CAF50", "color": "white"});';
                echo '$("#info-box").show();';
                break;
            case 'rejected':
                echo '$("#info-box").css({"padding": "16px", "background-color: "#FF5252", "color": "white"});';
                echo '$("#info-box").show();';
                break;
        }
    ?>
	$(function() {
		$('#tblLkhPekerjaDetail').DataTable({
            dom: '<"dataTable_Button"B><"dataTable_Filter"f>rt<"dataTable_Information"i><"dataTable_Pagination"p>',
			buttons: [
				{
					extend: 'collection',
					text: 'Ekspor Data',
					buttons: [
						{
							extend: 'copyHtml5',
							title: 'Detail Data LKH Pekerja \n' + employee_name.trim() + ' - ' + employee_code.trim(),
							exportOptions: {
								format: { body: function (data, column, row, node) { var val = $(node).find('input').val(); return (val === undefined) ? $(data).text() : val; } }
							}
						},
						{
                            extend: 'excelHtml5',
                            title: '',
							filename: 'Detail Data LKH Pekerja ' + employee_name.trim() + ' - ' + employee_code.trim(),
                            messageTop: employee_name.trim() + ' - ' + employee_code.trim(),
                            messageBottom: function() {
                                return  '<?= (empty($recordPekerjaan)) ? '' : $recordPekerjaan ?>' +
                                        '<?= (empty($nilaiInsentifKondite)) ? '' : ' | '.$nilaiInsentifKondite ?>' +
                                        '<?= (empty($warningSP)) ? '' : ' | '.$warningSP ?>';
                            },
							exportOptions: {
								format: {
                                    body: function (data, row, column, node) {
                                        var val = $(node).find('input').val();
                                        return (val === undefined) ? $(data).text() : val;
                                    } 
                                }
                            }
						},
						{
							extend: 'csvHtml5',
							title: 'Detail Data LKH Pekerja \n' + employee_name.trim() + ' - ' + employee_code.trim(),
							exportOptions: {
								format: { body: function (data, column, row, node) { var val = $(node).find('input').val(); return (val === undefined) ? $(data).text() : val; } }
							}
						},
						{
							extend: 'pdfHtml5',
							title: 'Detail Data LKH Pekerja \n' + employee_name.trim() + ' - ' + employee_code.trim(),
							header: true,
							footer: false,
							exportOptions: {
								format: { body: function (data, column, row, node) { var val = $(node).find('input').val(); return (val === undefined) ? $(data).text() : val; } }
							}
						},
						{
							extend: 'print',
							title: 'Detail Data LKH Pekerja ' + employee_name.trim() + ' - ' + employee_code.trim(),
							autoPrint: true,
							header: true,
							footer: false,
							customize: function (win) {
								$(win.document.body).find('h1').css('font-size', '2rem').css('text-align', 'center').css('padding-bottom', '12px');
								$(win.document.body).find('th').css('font-size', '1rem').css('text-align', 'center');
								$(win.document.body).find('td').css('font-size', '1rem').css('text-align', 'center');
								$(win.document.body).find('div').removeAttr('style');
							},
							exportOptions: {
								format: {
                                    body: function (data, column, row, node) { var val = $(node).find('input').val(); return (val === undefined) ? $(data).text() : val; }
							    },
								modifier: {
									page: 'current'
                                }
							}
						}
					]
				}
			],
			language: {
				"processing":       "Memuat data...",
				"loadingRecords":   "Memuat...",
				"search":           "Cari : ",
				"lengthMenu":       "Menampilkan _MENU_ baris per halaman",
				"emptyTable":       "Belum ada data",
				"zeroRecords":      "Tidak ada data yang sesuai dengan kata kunci",
				"infoEmpty":        "Data tidak tersedia",
				"infoFiltered":     "(di filter dari _MAX_ total data)",
				"info":             "Menampilkan data ke _START_ sampai _END_ dari _TOTAL_ data",
				"paginate": {
					"first":        "Pertama",
					"last":         "Terakhir",
					"next":         "Selanjutnya",
					"previous":     "Sebelumnya"
				},
				"aria": {
					"sortAscending":    ": aktifkan untuk mengurutkan data secara ascending",
					"sortDescending":   ": aktifkan untuk mengurutkan data secara descending"
				},
				"buttons": {
					"pageLength": {
						_: "Menampilkan %d baris",
						'-1': "Tampilkan semua"
					}
				}
			},
			searching: true,
			scrollX: true,
			responsive: true,
			paging: false,
			info: false,
			columnDefs: [
				{"targets": [0], "searchable": false, "orderable": true, "visible": true},
				{"targets": [1], "searchable": true,  "orderable": true, "visible": true},
				{"targets": [2], "searchable": true,  "orderable": true, "visible": true},
				{"targets": [3], "searchable": true,  "orderable": true, "visible": true},
				{"targets": [4], "searchable": true,  "orderable": true, "visible": true},
				{"targets": [5], "searchable": true,  "orderable": true, "visible": true},
				{"targets": [6], "searchable": true,  "orderable": true, "visible": true},
				{"targets": [7], "searchable": true,  "orderable": false, "visible": true},
				{"targets": [8], "searchable": true,  "orderable": false, "visible": true},
				{"targets": [9], "searchable": true,  "orderable": false, "visible": true},
				{"targets": [10],"searchable": true,  "orderable": false, "visible": true},
				{"targets": [11],"searchable": true,  "orderable": false, "visible": true},
				{"targets": [12],"searchable": true,  "orderable": false, "visible": true},
				{"targets": [13],"searchable": true,  "orderable": false, "visible": true},
				{"targets": [14],"searchable": true,  "orderable": false, "visible": true}
            ],
            order: [
                [1, "asc"]
            ],
		});
	});
    $('input').off('keydown').keydown(function(e) {
        switch(e.keyCode) {
            case 8: case 9: case 16: case 17: case 18: case 20: case 33: case 34: case 45: case 46: case 116:
                return true;
            case 13:
                var focusable = $('input,a,select,button,textarea').filter(':visible'); focusable.eq(focusable.index(this) + 1).select();
                return true;
            default:
                switch($(this).data('column')) {
                    case 'status_target':
                        switch(e.keyCode) { case 84: return true; default: $.toaster('Anda hanya dapat memasukkan nilai T atau TT', '', 'danger'); return false; }
                    case 'kondite_mk':
                        switch(e.keyCode) { case 65: case 66: case 67: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, atau C', '', 'danger'); return false; }
                    case 'kondite_i':
                        switch(e.keyCode) { case 65: case 66: case 67: case 68: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, C, atau D', '', 'danger'); return false; }
                    case 'kondite_bk':
                        switch(e.keyCode) { case 65: case 66: case 67: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, atau C', '', 'danger'); return false; }
                    case 'kondite_tk':
                        switch(e.keyCode) { case 65: case 66: case 67: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, atau C', '', 'danger'); return false; }
                    case 'kondite_kp':
                        switch(e.keyCode) { case 65: case 66: case 67: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, atau C', '', 'danger'); return false; }
                    case 'kondite_ks':
                        switch(e.keyCode) { case 65: case 66: case 67: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, atau C', '', 'danger'); return false; }
                    case 'kondite_kk':
                        switch(e.keyCode) { case 65: case 66: case 67: case 68: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, C, atau D', '', 'danger'); return false; }
                    case 'kondite_pk':
                        switch(e.keyCode) { case 65: case 66: case 67: case 68: case 69: return true; default: $.toaster('Anda hanya dapat memasukkan nilai A, B, C, D atau E', '', 'danger'); return false; }
                }
                break;
        }
    });
    $('input').off('focusin').focusin(function() { $(this).css("background-color", "#eeeeee"); $(this).select(); });
    $('input').off('focusout').focusout(function() { $(this).css("background-color", "white"); });
    function onFocusIn(input) { stringCache = input.val(); }
    function onFocusOut(input) { if(stringCache != input.val()) updateDataDetailLkh($('#lkh-id-row-' + input.data('row')).text(), input.data('column'), input.val(), input); }
    function updateDataDetailLkh(lkh_id, column, value, input) {
        input.parent().parent().css("background-color", "#bdbdbd");
        $.ajax({
            url: '<?= base_url("LkhPekerjaBatch/TargetWaktu/Detail/getData"); ?>',
            async: true,
            type: 'POST',
            dataType: 'json',
            data: { 'lkh_id': lkh_id, 'column': column, 'value': value },
            success: function(response) {
                input.removeAttr("data-toggle");
                input.removeAttr("data-placement");
                input.removeAttr("data-original-title");
                input.parent().parent().css("background-color", "#4CAF50");
                setTimeout(function(){ input.parent().parent().css("background-color", "white"); }, 1000);
                switch(column) {
                    case 'kondite_mk':
                    case 'kondite_i':
                    case 'kondite_bk':
                    case 'kondite_tk':
                    case 'kondite_kp':
                    case 'kondite_ks':
                    case 'kondite_kk':
                    case 'kondite_pk':
                        $.ajax({
                            url: '<?= base_url("LkhPekerjaBatch/TargetWaktu/Detail/getGolKondite"); ?>',
                            async: true,
                            type: 'POST',
                            dataType: 'JSON',
                            data: { 'lkh_id': lkh_id },
                            success: function(response) {
                                $('#gol-kondite-' + lkh_id).text(response.gol_kondite);
                                $('#gol-kondite-' + lkh_id).removeAttr("data-toggle");
                                $('#gol-kondite-' + lkh_id).removeAttr("data-placement");
                                $('#gol-kondite-' + lkh_id).removeAttr("data-original-title");
                                $('#gol-kondite-' + lkh_id).parent().parent().css("background-color", "#ffb74d");
                                setTimeout(function(){ $('#gol-kondite-' + lkh_id).parent().parent().css("background-color", "white"); }, 1000);
                            },
                            error: function(response) {
                                $('#gol-kondite-' + lkh_id).attr("data-toggle", "tooltip");
                                $('#gol-kondite-' + lkh_id).attr("data-placement", "bottom");
                                $('#gol-kondite-' + lkh_id).attr("data-original-title", "Data ini tidak sinkron!");
                                $('#gol-kondite-' + lkh_id).parent().parent().css("background-color", "#FF5252");
                                $.toaster('Terjadi kesalahan saat mengambil data terbaru', '', 'danger');
                                console.log('Terjadi kesalahan saat mengambil data terbaru.\nERROR_CODE: ' + response.status);
                            }
                        });
                        break;
                }
            },
            error: function(response) {
                input.attr("data-toggle", "tooltip");
                input.attr("data-placement", "bottom");
                input.attr("data-original-title", "Data ini belum tersimpan!");
                input.parent().parent().css("background-color", "#FF5252");
                $.toaster('Terjadi kesalahan saat memperbarui data', '', 'danger');
                console.log('Terjadi kesalahan saat memperbarui data.\nERROR_CODE: ' + response.status);
            }
        });
    }
</script>