<!-- Main content -->
<section class="content" style="background: url({BaseUrl}assets/img/3.jpg); background-size: cover;">
    <div class="row">
        <div class="col-md-1"></div>
        <!-- /.col -->
        <div class="col-md-10">
                <div class="box box-primary container-fluid">
                    <div class="box-header with-border text-center">
                        <h4><b>JADWAL PENDAMPINGAN PELAPORAN SPT TAHUNAN 2019 ORANG PRIBADI</b></h3>
                        <h5>- KHUSUS UNTUK PEKERJA CV. KARYA HIDUP SENTOSA YANG MEMILIKI NPWP -</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-body">
                            <div class="form-group">
                                <div class="col-sm-1"></div>
                                <label for="slcPSPTSearchBy" class="col-sm-2 control-label">Cari Berdasarkan</label>
                                <div class="input-group col-sm-6">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-search"></i></span>
                                    <select id="slcPSPTSearchBy" class="form-control" style="width: 35%;">
                                        <option>Nama</option>
                                        <option>No. Pendaftaran</option>
                                        <option>Seksi</option>
                                    </select>
                                    <input id="txtPSPTSearchBy" type="text" class="form-control pull-right" style="width: 65%">
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
                                        <table id="tblPSPTSchedule" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr height="50px">
                                                    <th class="bg-primary text-center text-nowrap">No.</th>
                                                    <th class="bg-primary text-center text-nowrap">Lokasi</th>
                                                    <th class="bg-primary text-center text-nowrap">No. Pendaftaran</th>
                                                    <th class="bg-primary text-center text-nowrap">Status Pekerja</th>
                                                    <th class="bg-primary text-center text-nowrap">Nama</th>
                                                    <th class="bg-primary text-center text-nowrap">Seksi</th>
                                                    <th class="bg-primary text-center text-nowrap">Tanggal Pendampingan</th>
                                                    <th class="bg-primary text-center text-nowrap">Ruangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {ScheduleSPTList}
                                                    <tr>
                                                        <td class="text-right">{no}</td>
                                                        <td class="text-left">{lokasi_kerja}</td>
                                                        <td class="text-left">{nomor_pendaftaran}</td>
                                                        <td class="text-left">{status_pekerja}</td>
                                                        <td class="text-left">{nama}</td>
                                                        <td class="text-left">{seksi}</td>
                                                        <td class="text-right">{jadwal}</td>
                                                        <td class="text-left">{lokasi}</td>
                                                    </tr>
                                                {/ScheduleSPTList}
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