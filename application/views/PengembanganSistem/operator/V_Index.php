<?php echo $this->session->flashdata('notifikasi');?>
<style>
    .vel_ps{
        vertical-align : middle;
        text-align : center;
    }
    th{
        background: darkgray; color: white;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b>LAPORAN ADMINISTRASI PENGEMBANGAN SISTEM</b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="">
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
                           <form onkeydown="return event.key != 'Enter';" method="post" action="<?= base_url('PengembanganSistem/input_lkh_ps') ?>" class="form-horizontal" enctype="multipart/form-data">
                              <div class="box box-primary box-solid">
                                  <div class="box-header with-border">Input Laporan Kerja Harian</div>
                                  <div class="box-body">
                                      <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-6">
                                                  <div class="form-group row">
                                                      <label for="inputnumberfp" class="control-label col-lg-4">Hari Masuk Kerja</label>
                                                      <div class="col-lg-8">
                                                        <select name="hari_masuk" required="" id="hari_masuk" class="form-control select2" data-placeholder="Pilih Hari">
                                                            <option hidden=""></option>
                                                            <option>Senin</option>
                                                            <option>Selasa</option>
                                                            <option>Rabu</option>
                                                            <option>Kamis</option>
                                                            <option>Jum'at</option>
                                                            <option>Sabtu</option>
                                                            <option>Minggu</option>
                                                        </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="inputseksicw" class="control-label col-lg-4">Tgl. Masuk Kerja</label>
                                                      <div class="col-lg-8">
                                                         <input placeholder="dd-mm-yyyy" required="" type="text" onclick="datepsfunction()" name="date_masuk" id="date_masuk" class="form-control date_pengSistem" data-inputmask="'alias': 'dd-mm-yyyy'">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="cop_wi_cw" class="control-label col-lg-4">Uraian Pekerjaan :</label>
                                                      <div class="col-lg-8" data-placement="bottom" data-toggle="tooltip" title="Jika tanggal merah pastikan ketik (Libur) di awal kalimat, dan LIBUR untuk hari minggu">
                                                         <textarea required="" onchange="wekday()" name="uraian_pekerjaan" id="uraian_pekerjaan" placeholder="Input Uraian Pekerjaan" class="form-control"></textarea>    
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="seksicw" class="control-label col-lg-4">Kode Seksi:</label>
                                                      <div class="col-lg-8">
                                                        <input required="" type="text" id="kode_lkh_ps" autocomplete="off" onkeyup="kode_lkh()" maxlength="5" name="kode_seksi" class="form-control" placeholder="input kode">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="doc_cw" class="control-label col-lg-4">Target Waktu Kerja:</label>
                                                      <div class="col-lg-8">
                                                         <input type="text" class="form-control" autocomplete="off" name="total_target" id="total_target" onkeypress="return isNumberKey(event)" placeholder="otomatis">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-lg-6">
                                                  <div class="form-group row">
                                                      <label for="doc_cw" class="control-label col-lg-4">Waktu Mulai Kerja:</label>
                                                      <div class="col-lg-8">
                                                           <input type="text" onclick="timepickerPS()" autocomplete="off" name="waktu_mulai"  id="waktu_mulai" class="form-control timepickerPS" placeholder="jam masuk">
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="doc_cw" class="control-label col-lg-4">Waktu Selesai Kerja:</label>
                                                      <div class="col-lg-8">
                                                           <input type="text"  autocomplete="off" name="waktu_selesai"  id="waktu_selesai" class="form-control timepickerPS" placeholder="jam pulang">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="numberrev_cw" class="control-label col-lg-4">Total Waktu :</label>
                                                      <div class="col-lg-8">
                                                        <input type="text" readonly="" class="form-control" autocomplete="off" name="total_waktu" id="total_waktu" onkeypress="return isNumberKey(event)" placeholder="otomatis">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="pic_cw" class="control-label col-lg-4">IP% :</label>
                                                      <div class="col-lg-8">
                                                        <input type="text" id="persen_lkh" autocomplete="off" readonly="" name="persen" class="form-control" placeholder="otomatis">
                                                      </div>
                                                      <p style="margin-left: 14em;" id="demo_blink"></p>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label for="perse" class="control-label col-lg-4">Persetujuan Kualitas :</label>
                                                      <div class="col-lg-8">
                                                        <input type="text" class="form-control" placeholder="Persetujuan Kualitas" readonly="">
                                                      </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="" class="control-label col-lg-4">Keterangan :</label>
                                                    <div class="col-lg-8">
                                                        <div class="form-group clearfix">
                                                            <div class="icheck-primarys d-inline col-sm-1">
                                                               <input type="checkbox" id="t" name="t" value="V">
                                                                <label for="t">T</label>
                                                            </div>
                                                            <div class="icheck-primarys d-inline col-sm-1">
                                                               <input type="checkbox" id="i" name="i" value="V">
                                                                <label for="i">I</label>
                                                            </div>
                                                            <div class="icheck-primarys d-inline col-sm-1">
                                                             <input type="checkbox" id="m" name="m" value="V">
                                                               <label for="m">M</label>
                                                            </div>
                                                            <div class="icheck-primarys d-inline col-sm-1">
                                                               <input type="checkbox" id="sk" name="sk" value="V">
                                                              <label for="sk">SK</label>
                                                            </div>
                                                            <div class="icheck-primarys d-inline col-sm-1">
                                                                <input type="checkbox" id="ct" name="ct" value="V">
                                                                <label for="ct">CT</label>
                                                            </div>
                                                            <div class="icheck-primarys d-inline col-sm-1">
                                                                <input type="checkbox" id="ip" name="ip" value="V">
                                                                    <label for="ip">IP</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                          </div>
                                      <div class="panel-footer">
                                          <div class="row text-right">
                                              <button type="button" onclick="notif_input_lkh()" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-rect">Save Data</button>
                                          </div>
                                      </div>
                                  </div>
                                      <!--/.modal -->
                                      <div class="modal fade" id="modal-default">
                                      <div class="modal-dialog" style="width:80%;">
                                          <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title"><b> Perhatian !!! </b>, Pastikan Data Benar &hellip;</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                          <table id="table" border="1" class="dataTable" style="width:100%">
                                                                     <thead>
                                                                        <tr align="center">
                                                                            <th rowspan="2"><center>Hari Masuk Kerja</center></th>
                                                                            <th rowspan="2"><center>Tgl. Masuk Kerja</center></th>
                                                                            <th rowspan="2"><center>Uraian Pekerjaan</center></th>
                                                                            <th rowspan="2"><center>Kode Seksi</center></th>
                                                                            <th rowspan="2"><center>Target Waktu</center></th>
                                                                            <th colspan="2"><center>Waktu</center></th>
                                                                            <th rowspan="2"><center>Total Waktu</center></th>
                                                                            <th rowspan="2"><center>IP%</center></th>
                                                                            <th rowspan="2"><center>Persetujuan <br/> Kualitas</center></th>
                                                                            <th colspan="6"><center>KETERANGAN</center></th>
                                                                        </tr>
                                                                        <tr align="center">
                                                                            <th><center>Mulai</center></th>
                                                                            <th><center>Selesai</center></th>
                                                                            <th><center>T</center></th>
                                                                            <th><center>I</center></th>
                                                                            <th><center>M</center></th>
                                                                            <th><center>SK</center></th>
                                                                            <th><center>CT</center></th>
                                                                            <th><center>IP</center></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="lkh1"></td>
                                                                            <td class="lkh2"></td>
                                                                            <td class="lkh3"></td>
                                                                            <td class="lkh4"></td>
                                                                            <td class="lkh5"></td>
                                                                            <td class="lkh6"></td>
                                                                            <td class="lkh7"></td>
                                                                            <td class="lkh8"></td>
                                                                            <td class="lkh9"></td>
                                                                            <td class="lkh16"></td>
                                                                            <td class="lkh10"></td>
                                                                            <td class="lkh11"></td>
                                                                            <td class="lkh12"></td>
                                                                            <td class="lkh13"></td>
                                                                            <td class="lkh14"></td>
                                                                            <td class="lkh15"></td>
                                                                        </tr>
                                                                    </tbody>
                                          </table>
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">Save </button>
                                          </div>
                                          </div>
                                          <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                      </div>
                                      <!-- /.modal -->
                              </div>
                           </form>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h4 style="font-weight:bold;"><i class="fa fa-files-o"></i> Monitoring Laporan Kerja Harian</h4>
                                        <form method="post" action="<?php echo base_url('PengembanganSistem/lkh_ps');?>">
                                            <div class="from-group">
                                                <div class="col-sm-1">
                                                    <label for="">Bulan</label>
                                                </div>
                                                    <div class="col-sm-3 float-right">
                                                        <select name="bulan" onchange="this.form.submit()" class="form-control select2" data-placeholder="Pilih Bulan" required="">
                                                            <option></option>
                                                            <option value="01" <?php if ($bulan=="01") {echo "selected";}?> >Januari</option>
                                                            <option value="02" <?php if ($bulan=="02") {echo "selected";}?>>Februari</option>
                                                            <option value="03" <?php if ($bulan=="03") {echo "selected";}?> >Maret</option>
                                                            <option value="04" <?php if ($bulan=="04") {echo "selected";}?> >April</option>
                                                            <option value="05" <?php if ($bulan=="05") {echo "selected";}?> >Mei</option>
                                                            <option value="06" <?php if ($bulan=="06") {echo "selected";}?> >Juni</option>
                                                            <option value="07" <?php if ($bulan=="07") {echo "selected";}?> >Juli</option>
                                                            <option value="08" <?php if ($bulan=="08") {echo "selected";}?> >Agustus</option>
                                                            <option value="09" <?php if ($bulan=="09") {echo "selected";}?> >September</option>
                                                            <option value="10" <?php if ($bulan=="10") {echo "selected";}?> >Oktober</option>
                                                            <option value="11" <?php if ($bulan=="11") {echo "selected";}?> >November</option>
                                                            <option value="12" <?php if ($bulan=="12") {echo "selected";}?> >Desember</option>
                                                        </select>
                                                    </div>
                                                <div class="col-sm-1">
                                                    <label for="">Tahun</label>
                                                </div>
                                                <div class="col-sm-2 float-right">
                                                    <select name="tahun" class="form-control select2" data-placeholder="--pilih tahun--">
                                                        <option hidden=""></option>
                                                        <?php
                                                        $mulai=date('Y') - 50;
                                                        for ($i= $mulai; $i < $mulai + 100; $i++) { 
                                                            $sel = $i == date('Y') ? ' selected="selected"' : '';
                                                            echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-sm-1">
                                            <label for="" id="textkedip">Approver</label>
                                        </div>
                                            <form class="printexcel" action="<?php echo base_url('PengembanganSistem/print_lkh');?>" method="post">
                                                <div class="col-sm-2 float-right">
                                                    <select name="kasie" id="pilihkasie" class="form-control select2 input_selectps" data-placeholder="--pilih approver--">
                                                        <option hidden=""></option>
                                                      
                                                    </select>
                                                </div>
                                                <input type="text" name="data" value="<?php if(strlen($bulan)>1){echo $bulan.'-'.$tahun;} ?>" required="required" hidden="hidden">
                                                <div class="col-sm-4 center" style="float: right">
                                                        <button onclick="exspotexcel()" style="position: absolute;right: 7em;bottom: 0.5em;" class="btn btn-sm btn-success" formtarget="_blank" ><span style="font-size: 16px;" class="fa fa-file-excel-o"></span> - Excel </button>
                                                        <button onclick="exspotpdf()" style="position: absolute;right: 1em;bottom: 0.5em;" class="btn btn-sm btn-warning" formtarget="_blank" ><span style="font-size: 16px;" class="fa fa-file-pdf-o"></span> - Print </button>
                                                </div>
                                            </form>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-left " id="dataTables-PengSistem" style="font-size:12px; width:max-content;">
                                            <thead>
                                                <tr>
                                                    <th hidden="" rowspan="2">No</th>
                                                    <th rowspan="2">Hari</th>
                                                    <th rowspan="2">Tanggal</th>
                                                    <th rowspan="2">Uraian Pekerjaan</th>
                                                    <th rowspan="2">Kode</th>
                                                    <th rowspan="2">Target Waktu</th>
                                                    <th colspan="2" style="text-align: center">Waktu</th>
                                                    <th rowspan="2">Total Waktu</th>
                                                    <th rowspan="2">IP%</th>
                                                    <th rowspan="2">Persetujuan <br/> Kualitas</th>
                                                    <th colspan="6" style="text-align: center">KETERANGAN</th>
                                                    <th rowspan="2" class="action">Action</th>
                                                </tr>
                                                <tr>
                                                    <th>Mulai</th>
                                                    <th>Selesai</th>
                                                    <th>T</th>
                                                    <th>I</th>
                                                    <th>M</th>
                                                    <th>SK</th>
                                                    <th>CT</th>
                                                    <th>IP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($listdata_lkh as $row) { ?>
                                            <tr row-id="<?php echo $row['id']?>" class="ta-ta">
                                            <td hidden=""><?php echo $no++; ?></td>
                                            <td><?php echo $row["harimasuk"];?></td>
                                            <td><?php $datatanggal = explode("-", $row["tglmasuk"]);
                                                        $day = $datatanggal[2];
                                                        $bulan = $datatanggal[1];
                                                        $tahun = $datatanggal[0];
                                                        $hasil = $day."-".$bulan."-".$tahun;
                                                        echo $hasil; ?>
                                            </td>
                                            <td style="min-width: 20em;"><?php echo $row["uraian_pekerjaan"];?></td>
                                            <td><?php echo $row["kodesie"];?></td>
                                            <td><?php echo $row["targetjob"];?></td>
                                            <td><?php echo $row["waktu_mulai"];?></td>
                                            <td><?php echo $row["waktu_selesai"];?></td>
                                            <td><?php echo $row["total_waktu"];?></td>
                                            <td><?php echo $row["persen"];?></td>
                                            <td></td>
                                            <td><?php if ($row["t"]=='V') {echo "✓"; } ;?></td>
                                            <td><?php if ($row["i"]=='V') {echo "✓"; } ;?></td>
                                            <td><?php if ($row["m"]=='V') {echo "✓"; } ;?></td>
                                            <td><?php if ($row["sk"]=='V') {echo "✓"; } ;?></td>
                                            <td><?php if ($row["ct"]=='V') {echo "✓"; } ;?></td>
                                            <td><?php if ($row["ip"]=='V') {echo "✓"; } ;?></td>
                                            <td>
                                                <a class="btn btn-xs btn-danger" style="padding: 6px;" title="Delete" onclick="delete_lkh(<?= $row['id']?>)"><i class="fa fa-close"></i></a>
                                            </td>
                                            </tr>
                                            <?php } ?>
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