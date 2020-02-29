   <style>
       .circleWhiteCaption {
        height: 15px;
        width: 15px;
        background-color: #43a047;
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
        background-color: #43a047;
      }

      .itsfun1 {
        border-top-color: #43a047;
      }
           .blink_me {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
    </style>

    <!-- Content Header (Page header) -->
<head> 
  <meta http-equiv="refresh" content="180"/> 
  <meta name="viewport" content="initial-scale=1"/>
</head>
    <section class="content-header">
      <h1>
        On Process
        </div>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box itsfun1">


            <div class="box-header with-border" style="text-align: center">

              <h3 class="box-title">
                <b> DASHBOARD TRACKING PENGIRIMAN BARANG</b>
              </h3><br><br>
              <span style="font-family: sans-serif"></span>

              <table align="center">
                <tr>
                    <td><span style="font-family: sans-serif; font-size: 14px;background-color:#43a047;" class="label"><i class="fa fa-refresh"></i> On Process&nbsp;<br></span></td>
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
                      <th class="text-center" style="width: 10%">Kendaraan</th>
                      <th class="text-center" style="width: 10%">Last Update Date</th>
                      <th class="text-center" style="width: 10%">Detail SPB</th>
                      <th class="text-center" style="width: 10%">Status SPB</th>
                    </tr>
                  </thead>
                  <tbody id="blinking_td">
                    <?php $no=1; foreach($satu as $n) { ?>
                      <tr>
                      <td><?php echo $no ?> </td>
                      <td><?php echo  $n['no_spb'] ?></td>
                      <td><?php echo  $n['username'] ?> - <?php echo  $n['nama_pekerja'] ?></td>
                      <td><?php echo  $n['kendaraan'] ?></td>
                      <td><?php echo  $n['last_update_date'] ?></td>
                      <td> 
                        <button title="detail..." rownum="<?php echo $no ?>" class="btn btn-warning btn-sm" style="width: 100px" data-target="MdlTPBNol" data-toggle="modal" onclick="OpenDetailSatu(<?php echo $n['no_spb'];?>)"><i class="fa fa-mouse-pointer"></i> Detail</button>
                        <!-- <a target="_blank" title="confirmation..." class="btn btn-primary btn-sm" href="<?php echo base_url('TrackingPengirimanBarang/OnProcess/Confirmation/'.$n['no_spb']) ?>"><i class="fa fa-check"></i> Confirm</a> -->
                      </td>
                       <td>
                      <?php if ($n['confirmation'] == NULL) { ?>
                       <span class="label label-danger">Belum Terkonfirmasi &nbsp;<br></span>
                      <?php }else if ($n['confirmation'] !== NULL) { ?>
                       <span class="label label-success">Sudah Terkonfirmasi &nbsp;<br></span>
                      <?php } ?>
                      </td>
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