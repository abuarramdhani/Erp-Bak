<section id="content">
	
  <!-- Content Header (Page header) -->
  <section class="content">
      <div class="inner" >
        <div class="box box-header"  style="padding-left:20px">
          <h3 class="pull-left"><strong>Sales Order</strong> - Detail Transaction</h3>
        </div>
      </div>
      <div class="panel box-body">
      <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">No SO &emsp;&emsp;&emsp;&nbsp;: <? if(isset($detail[0]['ORDER_NUMBER'])) echo $detail[0]['ORDER_NUMBER'] ?></h3>
                </div>        
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="do_done" class="table table-bordered table-striped">
                    <thead style="background-color:#367FA9; color:white">
                        <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 0;
                        foreach($detail as $key => $do){
                        $no++;
                      ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= $do['KODE_BARANG'] ?></td>
                          <td><?= $do['NAMA_BARANG'] ?></td>
                          <td><?= $do['QTY'] ?></td>
                          <td><?= $do['UOM'] ?></td>
                          <td><?= $do['LOKASI'] ?></td>
                        </tr>
                      <?php
                        }
                      ?>
                      
                    </tbody>
                  </table>
                  <a href="javascript:history.go(-1)" class="btn btn-primary" style="margin-top: 10px;">Back</a>
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








