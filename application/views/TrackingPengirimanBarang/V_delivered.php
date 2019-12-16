

   <style>
       .circleWhiteCaption {
        height: 15px;
        width: 15px;
        background-color: #607d8b;
        /*border: 1px solid black;*/
        border-radius: 50%
      }
      .Center {
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      .chartWrapper {
        position: relative;
      }
      .chartWrapper>canvas {
        position: absolute;
        left: 0;
        top: 0;
        pointer-events: none;
      }
      .chartAreaWrapper {
        overflow-x: scroll;
        position: relative;
        width: 100%;
      }
      .chartAreaWrapper2 {
        position: relative;
        height: 300px;
      }
      thead.toscahead tr th {
        background-color: #607d8b;
      }

      .itsfun1 {
        border-top-color: #607d8b;
      }
    </style>

    <!-- Content Header (Page header) -->
<head> 
  <meta http-equiv="refresh" content="60"/> 
  <meta name="viewport" content="initial-scale=1"/>
</head>
    <section class="content-header">
      <h1>
        Delivered
        </div>
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box itsfun1">
            <div class="box-header with-border" style="text-align: center">
              <h3 class="box-title">
                <b> DASHBOARD TRACKING PENGIRIMAN BARANG</b><br>
              </h3><br>
              <span style="font-family: sans-serif" class=""></span>
              <p class=""></p>
              <br>
              <table align="center">
                <tr>
                  <td><span style="font-family: sans-serif; font-size: 14px;background-color:#607d8b;" class="label"> <i class="fa fa-check"></i> Delivered&nbsp;<br></span></td>
                </tr>
              </table><br><br>
            </div>
            <div class="box-body">
              <table style="width: 100%;" id="tbListSubmit_unit" class="tb_dash_unit table table-striped table-bordered table-hover text-center">
                  <thead class="toscahead">
                    <tr class="bg-primary">
                      <th class="text-center" style="width: 5%">No</th>
                      <th class="text-center" style="width: 10%">No SPB/DO</th>
                      <th class="text-center" style="width: 20%">ID Kurir</th>
                      <th class="text-center" style="width: 15%">Kendaraan</th>
                      <th class="text-center" style="width: 10%">Start Date</th>
                      <th class="text-center" style="width: 10%">End Date</th>
                      <th class="text-center" style="width: 15%">Penerima</th>
                      <th class="text-center" style="width: 5%">Detail SPB</th>
                      <th class="text-center" style="width: 5%">Delete SPB</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach($dua as $n) { ?>
                      <tr>
                      <td><?php echo $no ?> </td>
                      <td><?php echo  $n['no_spb'] ?></td>
                      <td><?php echo  $n['username'] ?> - <?php echo  $n['nama_pekerja'] ?></td>
                      <td><?php echo  $n['kendaraan'] ?></td>
                      <td><?php echo  $n['start_date'] ?></td>
                      <td><?php echo  $n['end_date'] ?></td>
                      <td><?php echo  $n['penerima'] ?></td>
                      <td><a title="detail..." rownum="<?php echo $no ?>" class="btn btn-warning btn-sm" data-target="MdlTPBNol" data-toggle="modal" onclick="OpenDetailSatu(<?php echo $n['no_spb'];?>)"><i class="fa fa-hand-pointer-o"></i></a></td>
                      <td><a title="delete..." rownum="<?php echo $no ?>" class="btn btn-danger btn-sm" onclick="deleteData(<?php echo $n['no_spb'];?>)"><i class="fa fa-trash"></i></a></td>
                      </tr>
                    <?php $no++; } ?> 
                  </tbody>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
     <div class="modal fade MdlTPBNol"  id="MdlTPBNol" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body" style="width: 100%;">
                  <div class="modal-tabel" >
                    </div>
                      <div class="modal-footer">
                        <div class="col-md-2 pull-left">
                        </div>
                      </div>
                </div>
            </form>
        </div>
    </div>
</div>