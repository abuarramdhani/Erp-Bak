<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Moulding'); ?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br />
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
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/Moulding/view_create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                              <div class="form-group">
                                <div class="box box-default box-solid">
                                    <div class="box-header with-border">Search</div>
                                    <div class="box-body">
                                        <div class="col-lg-2"></div>
                                            <div class="col-lg-3">
                                                <form autocomplete="off" method="POST" action="<?//= base_url('ManufacturingOperationUP2L/Moulding/search')?>">
                                                <label for="">Bulan</label>
                                                <input type="text" required="" name="bulan" id="sea_month" class="form-control selectM" onclick="up2l_moulding_m()" placeholder="Pilih Bulan" />
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="">Tanggal</label>
                                                <input type="text" required="" name="tanggal" id="sea_date" class="form-control SelectD tanggal-up2l" onclick="up2l_moulding_d()" placeholder="Pilih Tanggal" />
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="" style="color: transparent">Search & Refresh Disini</label>
                                                <button type="button" onclick="filter_mould()" class="btn btn-primary"> <i class="fa fa-search"></i></button>
                                                <button type="button" onclick="ref_mould()" class="btn btn-success"> <i class="fa fa-refresh"></i></button>
                                                </form>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="area_mould">
                                  <div class="table-responsive">
                                      <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMoulding2021" style="font-size:12px;">
                                          <thead class="bg-primary">
                                              <tr>
                                                  <th style="text-align:center; width:30px">No</th>
                                                  <th style="text-align:center; min-width:80px">Action</th>
                                                  <th style="text-align:center">Component Code</th>
                                                  <th style="text-align:center">Component Description</th>
                                                  <th style="text-align:center">Production Date</th>
                                                  <th style="text-align:center">Kode Cetak</th>
                                                  <th style="text-align:center">Shift</th>
                                                  <th style="text-align:center">Komponen (pcs)</th>
                                                  <th style="text-align:center">Kode</th>
                                                  <th style="text-align:center">Jumlah Pekerja</th>
                                                  <th style="text-align:center">Bongkar Qty</th>
                                                  <th style="text-align:center">Scrap Qty</th>
                                                  <th style="text-align:center">Hasil Baik</th>
                                              </tr>
                                          </thead>
                                          <tbody>

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
    </div>
    </div>
</section>
