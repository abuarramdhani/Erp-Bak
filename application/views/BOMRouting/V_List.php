
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1>
                  <b>
                    <?php echo $Title ?>
                  </b>
                </h1>
              </div>
            </div>
            <div class="col-lg-1 ">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/MasterItem');?>">
                  <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                  </i>
                  <span>
                    <br />
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />
        <br />

        <div class="row">
            <div class="col-md-12">
              <button type="button" onclick="Refresh()" class="btn btn-info btn-circle btn-sm" style="color:white">
                <i class="fa fa-refresh"></i> Refresh
              </button>
              <br><br>
              <div class="box box-primary box-solid">
                <div class="panel-body">

              <table class="table table-bordered" id="dataTablePBR" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nomor Dokumen</th>
                    <th>Tanggal Pembuatan</th>
                    <th>Kode Item</th>
                    <th>Nama Barang</th>
                    <th>Seksi</th>
                    <th>IO</th>
                    <th>Tanggal Berlaku</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
                    <th>No</th>
										<th>Nomor Dokumen</th>
                    <th>Tanggal Pembuatan</th>
                    <th>Kode Item</th>
                    <th>Nama Barang</th>
                    <th>Seksi</th>
                    <th>IO</th>
                    <th>Tanggal Berlaku</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>

            </div>
          </div>
        </div>
      </div>



      </div>
    </div>
  </div>
</section>
