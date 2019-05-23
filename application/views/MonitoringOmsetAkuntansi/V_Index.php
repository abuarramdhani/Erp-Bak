
    <section class="content-header">
    <h1><b>
        MONITORING OMSET AKUNTANSI</b>
        <small>              
        <p id="date"></p>
          <script>
            n =  new Date();
            y = n.getFullYear();
            m = n.getMonth() + 1;
            d = n.getDate();
            document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
          </script>  
        </small>
      </h1>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
 

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tabel Monitoring Omset Akuntansi</h3> 
              <label style="float: right;" >
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-success" ><i class="fa fa-search"></i> &nbsp; &nbsp; &nbsp; Filter &nbsp; &nbsp; </button>
              
            </label>

              
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Order Number</th>
                  <th>DPP</th>
                  <th>Max Amount</th>
                  <th style="text-align: center;" class="slsh">Selisih</th>
                  <th>Keterangan</th>
                  
                </tr>
                </thead>
                <tbody>

                <?php         
                    $color='';
                    $class='';
                    $font='';
                    $num=0;
                    $button='';
                    $stat='';
                    $selisih='';

                  foreach ($order as $key => $grouping) {
                    $num++;
                    $q = $grouping[0];
                    
  
                    if($q['MAX_AMOUNT']>$q['DPP'])
                    {
                      $selisih=$q['MAX_AMOUNT']-$q['DPP'];
                    }
                    else {
                      $selisih=$q['DPP']-$q['MAX_AMOUNT'];
                    }
                  
                  if($selisih>1000)
                    {
                    $color="red";
                    $class="callout callout-danger";
                    $button="btn-default";
                    $stat="!";
                    $fontstat="bold";
                    $target="#modal-danger-".$q['ORDER_NUMBER'];
                    }

                  else {
                    $color="black";
                    $class="";
                    $button="btn-primary";
                    $stat="";
                    $fontstat="";
                    $target="#modal-default-".$q['ORDER_NUMBER'];
                    }
                ?>

            <tr class="<?php echo $class ?>" style="color: <?php echo $color ?>; ">
                <td>
                    <?php echo $num ?>
                </td>
                <td>
                    <?php echo $q['HEADER_ID'] ?>
                </td>
                <td>
                    <?php echo $q['ORDER_NUMBER'] ?> 
                </td>
                <td>
                    <?php echo $q['DPP'] ?> 
                </td>
                <td>
                    <?php echo $q['MAX_AMOUNT'] ?> 
                </td>
                <td style="font-weight: <?php echo $fontstat ?>;text-align:center;">
                    <?php echo $selisih ?>
                </td>
                <td align="center" >
                    <button type="button" class="btn <?php echo $button ?>" 
                        style="font-weight: <?php echo $fontstat ?>;"
                        data-toggle="modal" 
                        data-target="<?php echo $target ?>"
                    >

                    
                      Detail <?php echo $stat ?>
                    </button>
                </td>

            </tr>
            <?php     } ?>

                </tbody>
              </table>

              <label>
              <a href="<?php echo base_url('MonitoringOmsetAkuntansi/Monitoring/print_mntrgomst') ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print All</a>
              </label>

              <form id="printfltr" action="<?php echo base_url('MonitoringOmsetAkuntansi/Monitoring/print_mntrgomst_fltr') ?>" method="post" target="_blank" >
              <button onclick="prnt_ftr()" type="submit" class="btn btn-default" id="btn_fltr" ><i class="fa fa-search"></i>&nbsp;<i class="fa fa-print"></i> Print Filtered</button>
            


        <div class="modal modal-default fade" id="modal-success">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Filter Berdasarkan</h4>
              </div>
              <div class="modal-body">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"><b>Order Number</b></h3>
                  </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                    <div class="box-body">
                      <div class="row">
                        <div class="col-xs-5">
                          <input type="text" class="form-control" placeholder="Dari ..." name="minCompletionIA" id="minCompletionIA">
                        </div>
                        
                        <div class="col-xs-5">
                          <input type="text" class="form-control" placeholder="Hingga ..." name="maxCompletionIA" id="maxCompletionIA">
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal" onclick="searchPreContractIndexTable(event)" >Simpan perubahan</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </form>
         
        <div class="modal fade" id="modal-alert">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-yellow color-palette">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button> -->
                  <h4 class="modal-title">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    &nbsp;&nbsp;Peringatan
                  </h4>
              </div>
              <div class="modal-body">
                <p>&nbsp;Anda belum memfilter apapun !&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
            </div>
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->

          <?php
              foreach ($order as $key => $grouping) {
              $q = $grouping[0];      
          ?>

          <div class="modal fade" id="modal-default-<?php echo $q['ORDER_NUMBER']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button> -->
                <h4 class="modal-title">Detail Order</h4>
              </div>
              <div class="modal-body">
                <!-- <p>One fine body&hellip;</p> -->
                  <table border="1" class="table table-bordered table-striped">
                      <tr>
                        <th align="center">No</th>
                        <th align="center">Nama Item</th>
                        <th align="center">Order Item</th>
                        <th align="center">Price Unit</th>
                        <th align="center">Creation Date</th>
                        <!-- <th align="center">Status</th> -->
                      </tr>

                      <?php
                          $nomer="0" ;
                          foreach ($grouping as $key => $test) {
                          $nomer++;
                      ?>
                      <tr>
                        <td align="center"><?php echo $nomer ?> </td>
                        <td><?php echo $test['DESCRIPTION']   ?></td>
                        <td><?php echo $test['ORDERED_ITEM']   ?></td>
                        <td><?php echo $test['PRICE_UNIT']   ?></td>
                        <td><?php echo $test['CREATION_DATE']   ?></td>
                        <!-- <td><span id="setatus">ORDERNUM</span></td>     -->
                      </tr>
                      <?php } ?>
                  </table>       
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

                      
          <div class="modal fade" id="modal-danger-<?php echo $q['ORDER_NUMBER']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-red-active color-palette">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button> -->
                <h4 class="modal-title">Detail Order</h4>
              </div>


              <div class="modal-body">
                <!-- <p>One fine body&hellip;</p> -->
                  <table border="1" class="table table-bordered table-striped">
                      <tr>
                        <th align="center">No</th>
                        <th align="center">Nama Item</th>
                        <th align="center">Order Item</th>
                        <th align="center">Price Unit</th>
                        <th align="center">Creation Date</th>
                        <!-- <th align="center">Status</th> -->
                      </tr>

                      <?php
                          $nomer="0" ;
                          foreach ($grouping as $key => $test) {
                          $nomer++;
                      ?>
                      <tr>
                        <td><?php echo $nomer ?> </td>
                        <td><?php echo $test['DESCRIPTION']   ?></td>
                        <td><?php echo $test['ORDERED_ITEM']   ?></td>
                        <td><?php echo $test['PRICE_UNIT']   ?></td>
                        <td><?php echo $test['CREATION_DATE']   ?></td>
                        <!-- <td><span id="setatus">ORDERNUM</span></td>     -->
                      </tr>
                      <?php } ?>
                  </table>    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      <?php } ?>

