<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/clear_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Kosongkan Data" title="Kosongkan Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Tambah Data" title="Tambah Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/download_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Download Data From Database" title="Download Data From Database" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-database fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblDataAbsensi" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
												<th>No Induk</th>
                                                <th>Kodesie</th>
                                                <th>Bulan Gaji</th>
                                                <th>Tahun Gaji</th>
                                                <th>HM01</th>
                                                <th>HM02</th>
                                                <th>HM03</th>
                                                <th>HM04</th>
                                                <th>HM05</th>
                                                <th>HM06</th>
                                                <th>HM07</th>
                                                <th>HM08</th>
                                                <th>HM09</th>
                                                <th>HM10</th>
                                                <th>HM11</th>
                                                <th>HM12</th>
                                                <th>HM13</th>
                                                <th>HM14</th>
                                                <th>HM15</th>
                                                <th>HM16</th>
                                                <th>HM17</th>
                                                <th>HM18</th>
                                                <th>HM19</th>
                                                <th>HM20</th>
                                                <th>HM21</th>
                                                <th>HM22</th>
                                                <th>HM23</th>
                                                <th>HM24</th>
                                                <th>HM25</th>
                                                <th>HM26</th>
                                                <th>HM27</th>
                                                <th>HM28</th>
                                                <th>HM29</th>
                                                <th>HM30</th>
                                                <th>HM31</th>
                                                <th>Jam Lembur</th>
                                                <th>HMP</th>
                                                <th>HMU</th>
                                                <th>HMS</th>
                                                <th>HMM</th>
                                                <th>HM</th>
                                                <th>UBT</th>
                                                <th>HUPAMK</th>
                                                <th>IK</th>
                                                <th>IKSKP</th>
                                                <th>IKSKU</th>
                                                <th>IKSKS</th>
                                                <th>IKSKM</th>
                                                <th>IKJSP</th>
                                                <th>IKJSU</th>
                                                <th>IKJSS</th>
                                                <th>IKJSM</th>
                                                <th>ABS</th>
                                                <th>T</th>
                                                <th>SKD</th>
                                                <th>cuti</th>
                                                <th>HL</th>
                                                <th>PT</th>
                                                <th>PI</th>
                                                <th>PM</th>
                                                <th>DL</th>
                                                <th>Tambahan</th>
                                                <th>Duka</th>
                                                <th>Potongan</th>
                                                <th>HC</th>
                                                <th>Jumlah UM</th>
                                                <th>Cicil</th>
                                                <th>Potongan Koperasi</th>
                                                <th>UBS</th>
                                                <th>UM Puasa</th>
                                                <th>SK CT</th>
                                                <th>POT 2</th>
                                                <th>TAMB 2</th>
                                                <th>Kode Lokasi</th>
                                                <th>Jml Izin</th>
                                                <th>Jml Mangkir</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($Absensi as $row):
                                                $encrypted_string = $this->encrypt->encode($row['absensi_id']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td><?php echo $row['noind'] ?></td>
                                                <td><?php echo $row['kodesie'] ?></td>
                                                <td><?php echo $row['bln_gaji'] ?></td>
                                                <td><?php echo $row['thn_gaji'] ?></td>
                                                <td><?php echo $row['HM01'] ?></td>
                                                <td><?php echo $row['HM02'] ?></td>
                                                <td><?php echo $row['HM03'] ?></td>
                                                <td><?php echo $row['HM04'] ?></td>
                                                <td><?php echo $row['HM05'] ?></td>
                                                <td><?php echo $row['HM06'] ?></td>
                                                <td><?php echo $row['HM07'] ?></td>
                                                <td><?php echo $row['HM08'] ?></td>
                                                <td><?php echo $row['HM09'] ?></td>
                                                <td><?php echo $row['HM10'] ?></td>
                                                <td><?php echo $row['HM11'] ?></td>
                                                <td><?php echo $row['HM12'] ?></td>
                                                <td><?php echo $row['HM13'] ?></td>
                                                <td><?php echo $row['HM14'] ?></td>
                                                <td><?php echo $row['HM15'] ?></td>
                                                <td><?php echo $row['HM16'] ?></td>
                                                <td><?php echo $row['HM17'] ?></td>
                                                <td><?php echo $row['HM18'] ?></td>
                                                <td><?php echo $row['HM19'] ?></td>
                                                <td><?php echo $row['HM20'] ?></td>
                                                <td><?php echo $row['HM21'] ?></td>
                                                <td><?php echo $row['HM22'] ?></td>
                                                <td><?php echo $row['HM23'] ?></td>
                                                <td><?php echo $row['HM24'] ?></td>
                                                <td><?php echo $row['HM25'] ?></td>
                                                <td><?php echo $row['HM26'] ?></td>
                                                <td><?php echo $row['HM27'] ?></td>
                                                <td><?php echo $row['HM28'] ?></td>
                                                <td><?php echo $row['HM29'] ?></td>
                                                <td><?php echo $row['HM30'] ?></td>
                                                <td><?php echo $row['HM31'] ?></td>
                                                <td><?php echo $row['jam_lembur'] ?></td>
                                                <td><?php echo $row['HMP'] ?></td>
                                                <td><?php echo $row['HMU'] ?></td>
                                                <td><?php echo $row['HMS'] ?></td>
                                                <td><?php echo $row['HMM'] ?></td>
                                                <td><?php echo $row['HM'] ?></td>
                                                <td><?php echo $row['UBT'] ?></td>
                                                <td><?php echo $row['HUPAMK'] ?></td>
                                                <td><?php echo $row['IK'] ?></td>
                                                <td><?php echo $row['IKSKP'] ?></td>
                                                <td><?php echo $row['IKSKU'] ?></td>
                                                <td><?php echo $row['IKSKS'] ?></td>
                                                <td><?php echo $row['IKSKM'] ?></td>
                                                <td><?php echo $row['IKJSP'] ?></td>
                                                <td><?php echo $row['IKJSU'] ?></td>
                                                <td><?php echo $row['IKJSS'] ?></td>
                                                <td><?php echo $row['IKJSM'] ?></td>
                                                <td><?php echo $row['ABS'] ?></td>
                                                <td><?php echo $row['T'] ?></td>
                                                <td><?php echo $row['SKD'] ?></td>
                                                <td><?php echo $row['cuti'] ?></td>
                                                <td><?php echo $row['HL'] ?></td>
                                                <td><?php echo $row['PT'] ?></td>
                                                <td><?php echo $row['PI'] ?></td>
                                                <td><?php echo $row['PM'] ?></td>
                                                <td><?php echo $row['DL'] ?></td>
                                                <td><?php echo $row['tambahan'] ?></td>
                                                <td><?php echo $row['duka'] ?></td>
                                                <td><?php echo $row['potongan'] ?></td>
                                                <td><?php echo $row['HC'] ?></td>
                                                <td><?php echo $row['jml_UM'] ?></td>
                                                <td><?php echo $row['cicil'] ?></td>
                                                <td><?php echo $row['potongan_koperasi'] ?></td>
                                                <td><?php echo $row['UBS'] ?></td>
                                                <td><?php echo $row['UM_puasa'] ?></td>
                                                <td><?php echo $row['SK_CT'] ?></td>
                                                <td><?php echo $row['POT_2'] ?></td>
                                                <td><?php echo $row['TAMB_2'] ?></td>
                                                <td><?php echo $row['kode_lokasi'] ?></td>
                                                <td><?php echo $row['jml_izin'] ?></td>
                                                <td><?php echo $row['jml_mangkir'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
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