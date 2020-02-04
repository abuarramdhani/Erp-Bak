<!-- Custom Style -->
<style>
    label {
        font-weight: normal;
    }
    .form-group {
        margin-bottom: 3px !important;
    }    
    .swal-font-small {
        font-size: 1.5rem !important;
    }
    .tooltip {
        position: fixed;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Pendampingan SPT <small> <span class="spnPSPTDate"></span></small></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
                <div class="box box-primary container-fluid ">
                    <div class="box-header with-border text-center">
                        <h4><b>DATA PENDAFTAR PENDAMPINGAN SURAT PAJAK TAHUNAN</b></h3>
                        <h5>- PEKERJA CV. KARYA HIDUP SENTOSA YANG MEMILIKI NPWP -</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-body">
                            <div class="form-group">
                                <label for="slcPSPTDataWorkerStats" class="col-sm-2 control-label">Status Pekerja</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                    <select id="slcPSPTDataWorkerStats" class="form-control" style="width: 100%;" required>
                                        <option value="">All</option>
                                        <option value="STAFF">Staff</option>
                                        <option value="NON">Non Staff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slcPSPTDataWorkLocation" class="col-sm-2 control-label">Lokasi Kerja</label>
                                <div class="input-group col-sm-5">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-map-marker"></i></span>
                                    <select id="slcPSPTDataWorkLocation" class="form-control" style="width: 100%;" required>
                                        <option value="">All</option>
                                        <option value="PUSAT">Pusat</option>
                                        <option value="TUKSONO">Tuksono</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><i class="fa fa-th-list"></i><b> Data List</b></p>
                                </div>
                                <div class="panel-body">
                                    <label class="control-label col-sm-12 text-center lblPSPTLoading">
                                        <p><i class="fa fa-spinner fa-spin"></i> Sedang Memproses </p> 
                                    </label>
                                    <div class="divPSPTTableContent" style="display: none;">
                                        <table id="tblPSPTList" class="table table-bordered table-hover table-striped" style="width: 170%;">
                                            <thead>
                                                <tr height="50px">
                                                <th class="bg-info text-center text-nowrap">No.</th>
                                                <th class="bg-info text-center text-nowrap">No. Pendaftaran</th>
                                                <th class="bg-info text-center text-nowrap">Lokasi</th>
                                                <th class="bg-info text-center text-nowrap">Status Pekerja</th>
                                                <th class="bg-info text-center text-nowrap">No. NPWP</th>
                                                <th class="bg-info text-center text-nowrap">Nama</th>
                                                <th class="bg-info text-center text-nowrap">Seksi</th>
                                                <th class="bg-primary text-center text-nowrap">Jadwal</th>
                                                <th class="bg-primary text-center text-nowrap">Ruangan</th>
                                                <th class="bg-primary text-center text-nowrap">EFIN</th>
                                                <th class="bg-primary text-center text-nowrap">Email</th>
                                                <th class="bg-primary text-center text-nowrap">Tanggal Lapor</th>
                                                <th class="bg-primary text-center no-orderable">Action</th>
                                                <th class="text-center text-nowrap hidden ">Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($RegisteredSPTList as $key => $val) : ?>
                                                    <tr>
                                                        <td class="text-right"><?= $key+1 ?></td>
                                                        <td class="text-left"><?= $val['nomor_pendaftaran'] ?></td>
                                                        <td class="text-left"><?= $val['lokasi_kerja'] ?></td>
                                                        <td class="text-left"><?= $val['status_pekerja'] ?></td>
                                                        <td class="text-right"><?= $val['nomor_npwp'] ?></td>
                                                        <td class="text-left"><?= $val['nama'] ?></td>
                                                        <td class="text-left"><?= $val['seksi'] ?></td>
                                                        <td class="text-right"><?= $val['jadwal'] ?></td>
                                                        <td class="text-left"><?= $val['lokasi'] ?></td>
                                                        <td class="text-left text-nowrap"><?= $val['efin'] ?></td>
                                                        <td class="text-left"><?= $val['email'] ?></td>
                                                        <td class="text-right"><?= $val['tanggal_lapor'] ?></td>
                                                        <td class="text-center" style="padding: 1.25rem;">
                                                            <form action="<?= "${BaseURL}PendampinganSPT/Data/Edit" ?>" method="post" target="_blank">
                                                                <input type="hidden" name="data-id" value="<?= $val['id'] ?>">
                                                                <button data-toggle="tooltipPSPT" data-placement="top" title="Edit" class="btn btn-success"><i class="fa fa-edit"></i></button>
                                                                <!-- <button type="button" data-toggle="tooltipPSPT" data-placement="top" title="Delete" class="btn btn-danger btnPSPTDelete"><i class="fa fa-remove"></i></button> -->
                                                            </form>
                                                        </td>
                                                        <td class="text-left hidden">
                                                            <?php if ( strpos($val['status_pekerja'], 'NON') ) :
                                                                echo 'NON';
                                                            elseif ( strpos($val['status_pekerja'], 'STAF') ) :
                                                                echo 'STAFF';
                                                            endif ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<div id="mdlPSPTImportExcel" class="modal fade" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-slg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-cloud-upload"></i> Import Document</h4>
            </div>
            <div class="modal-body" style="word-wrap: break-word">
                <div class="form-group">
                    <label for="filePSPTImportExcel" class="col-sm-3 control-label">Pilih File Excel</label>
                    <div class="input-group col-sm-7">
                        <span class="input-group-addon"><i class="fa fa-file-excel-o"></i></span>
                        <input type="file" class="form-control" placeholder="Pilih File" id="filePSPTImportExcel">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                <button type="button" class="btn btn-primary btnPSPTImportExcel"><i class="fa fa-upload"></i> Upload</button>
            </div>
        </div>
    </div>
</div>
