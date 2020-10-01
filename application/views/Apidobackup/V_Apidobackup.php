<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">API DO BACKUP</h4>
        </div>
        <div class="box-body">
          <div class="row">
          <!-- <div class="col-md-3"></div> -->
         <div class="col-md-12">
         <div class="table-responsive text-nowrap">
                <table class=" table table-striped table-bordered table-hover datatable-ADB" style="width: 100%;">
                    <thead class="bg-primary">
                        <tr>
                            <th style="width: 10%;"><center>No</center></th>
                            <th style="width: 30%;"><center>DO SPB</center></th>
                            <th style="width: 40%;"><center>CREATED DATE</center></th>
                            <th style="width: 20%;"><center>ACTION</center></th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php $link = "http://produksi.quick.com/api-do-backup/assets/img/DO_SPB_TAMPUNG/"?>
                        <?php foreach($param as $key => $value) : ?>
                        <tr>
                            <td><center><?= $key + 1; ?></center></td>
                            <td><center><?= $value['DO_SPB'] ?></center></td>
                            <td><center><?= $value['CREATED_DATE'] ?></center></td>
                            
                            
                            <td>
                            <center>
                            <a class="btn btn-success" target="_blank" href="<?= $link.$value['DO_SPB'].".pdf" ?>">Download</a>
                            </center>
                            </td>

                            
                          
                        </tr>
                        <?php endforeach ?>
                            
                        
                       
                    </tbody>
                </table>
              
            </div>
            <!-- <div class="col-md-3"></div> -->
         </div>
        </div>
      </div>
    </div>
  </div>
</div>