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
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblDataAbsensi" style="font-size:12px;min-width: 100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th class="text-center" width="100px">No Induk</th>
												<th class="text-center" width="100px">Nama</th>
                                                <th class="text-center" width="100px">Kodesie</th>
                                                <th class="text-center" width="100px">Nama Unit</th>
                                                <th class="text-center" width="100px">Bulan Gaji</th>
                                                <th class="text-center" width="100px">Tahun Gaji</th>
                                                <th class="text-center" width="50px">HM01</th>
                                                <th class="text-center" width="50px">HM02</th>
                                                <th class="text-center" width="50px">HM03</th>
                                                <th class="text-center" width="50px">HM04</th>
                                                <th class="text-center" width="50px">HM05</th>
                                                <th class="text-center" width="50px">HM06</th>
                                                <th class="text-center" width="50px">HM07</th>
                                                <th class="text-center" width="50px">HM08</th>
                                                <th class="text-center" width="50px">HM09</th>
                                                <th class="text-center" width="50px">HM10</th>
                                                <th class="text-center" width="50px">HM11</th>
                                                <th class="text-center" width="50px">HM12</th>
                                                <th class="text-center" width="50px">HM13</th>
                                                <th class="text-center" width="50px">HM14</th>
                                                <th class="text-center" width="50px">HM15</th>
                                                <th class="text-center" width="50px">HM16</th>
                                                <th class="text-center" width="50px">HM17</th>
                                                <th class="text-center" width="50px">HM18</th>
                                                <th class="text-center" width="50px">HM19</th>
                                                <th class="text-center" width="50px">HM20</th>
                                                <th class="text-center" width="50px">HM21</th>
                                                <th class="text-center" width="50px">HM22</th>
                                                <th class="text-center" width="50px">HM23</th>
                                                <th class="text-center" width="50px">HM24</th>
                                                <th class="text-center" width="50px">HM25</th>
                                                <th class="text-center" width="50px">HM26</th>
                                                <th class="text-center" width="50px">HM27</th>
                                                <th class="text-center" width="50px">HM28</th>
                                                <th class="text-center" width="50px">HM29</th>
                                                <th class="text-center" width="50px">HM30</th>
                                                <th class="text-center" width="50px">HM31</th>
                                                <th class="text-center" width="100px">Jam Lembur</th>
                                                <th class="text-center" width="50px">HMP</th>
                                                <th class="text-center" width="50px">HMU</th>
                                                <th class="text-center" width="50px">HMS</th>
                                                <th class="text-center" width="50px">HMM</th>
                                                <th class="text-center" width="50px">HM</th>
                                                <th class="text-center" width="100px">UBT</th>
                                                <th class="text-center" width="100px">HUPAMK</th>
                                                <th class="text-center" width="100px">IK</th>
                                                <th class="text-center" width="100px">IKSKP</th>
                                                <th class="text-center" width="100px">IKSKU</th>
                                                <th class="text-center" width="100px">IKSKS</th>
                                                <th class="text-center" width="100px">IKSKM</th>
                                                <th class="text-center" width="100px">IKJSP</th>
                                                <th class="text-center" width="100px">IKJSU</th>
                                                <th class="text-center" width="100px">IKJSS</th>
                                                <th class="text-center" width="100px">IKJSM</th>
                                                <th class="text-center" width="100px">ABS</th>
                                                <th class="text-center" width="100px">T</th>
                                                <th class="text-center" width="100px">SKD</th>
                                                <th class="text-center" width="100px">cuti</th>
                                                <th class="text-center" width="100px">HL</th>
                                                <th class="text-center" width="100px">PT</th>
                                                <th class="text-center" width="100px">PI</th>
                                                <th class="text-center" width="100px">PM</th>
                                                <th class="text-center" width="100px">DL</th>
                                                <th class="text-center" width="100px">Tambahan</th>
                                                <th class="text-center" width="100px">Duka</th>
                                                <th class="text-center" width="100px">Potongan</th>
                                                <th class="text-center" width="100px">HC</th>
                                                <th class="text-center" width="100px">Jumlah UM</th>
                                                <th class="text-center" width="100px">Cicil</th>
                                                <th class="text-center" width="100px">Potongan Koperasi</th>
                                                <th class="text-center" width="100px">UBS</th>
                                                <th class="text-center" width="100px">UM Puasa</th>
                                                <th class="text-center" width="100px">SK CT</th>
                                                <th class="text-center" width="100px">POT 2</th>
                                                <th class="text-center" width="100px">TAMB 2</th>
                                                <th class="text-center" width="100px">Kode Lokasi</th>
                                                <th class="text-center" width="100px">Jml Izin</th>
                                                <th class="text-center" width="100px">Jml Mangkir</th>
											</tr>
                                        </thead>
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