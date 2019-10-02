<section id="content">
	
  <!-- Content Header (Page header) -->
  <section class="content">
      <div class="inner" >
        <div class="box box-header"  style="padding-left:20px">
          <h3 class="pull-left"><strong> Penjualan Cast And Carry </strong>- KHS Pusat</h3>
        </div>
      </div>
      <div class="panel box-body">
      <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">SO Done</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="do_done" class="table table-bordered table-striped">
                    <thead style="background-color:#367FA9; color:white">
                        <tr>
                        <th>No</th>
                        <th>No Sales Order</th>
                        <th>Last Update Date</th>
                        <th>Finished Date</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      foreach($do_done as $key => $done){
                      $no++
                      ?>
                        <tr onclick="document.location = '<?php echo base_url('MonitoringSalesOrder/C_MonitoringSalesOrder/do_detail_done/'.$done['ORDER_NUMBER']);?>';">
                          <td><?= $no ?></td>
                          <td><?= $done['ORDER_NUMBER'] ?></td>
                          <td><?= $done['LAST_UPDATE_DATE'] ?></td>
                          <td><?= $done['CREATION_DATE'] ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
      </div>
    </section>

</section>



