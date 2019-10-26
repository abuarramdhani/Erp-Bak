<section class="content">
    <div class="inner" >
        <div class="row">
         <form enctype="multipart/form-data" id="" method="post" action="<?php echo site_url('PolaShiftSeksi/ImportPolaShift/DocumentProcess');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/ImportPolaShift');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border"></div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalCetak" class="col-lg-4 control-label">Periode Shift</label>
                                                        <div class="col-lg-8">
                                                           <input class="form-control importpola_periode"  autocomplete="off" type="text" name="periodeshift" id="yangPentingtdkKosong" placeholder="Masukkan Periode" value=""/>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="txtKodesieBaru" class="col-lg-4 control-label">Seksi</label>
                                                        <div class="col-lg-8">
                                                            <select required name="kodeseksi" class="select2" id="ImportPola-DaftarSeksi" style="width: 100%">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="lb_approval" class="control-label col-lg-4">Import Document</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group ">
                                                                    <input type="file" name="importdocument" class="form-control" />
                                                                </div>
                                                            </div>
                                                                
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-lg-12 text-center">
                                                                <button type="submit" class="btn btn-primary">Process Document</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
	                                 <table class="table table-striped table-bordered table-hover tabel_polashift">
	                                <thead>
	                                  <tr class="">
					                    <th class="text-center" style="vertical-align: middle;" rowspan="2">No</th>
					                    <th class="text-center" style="vertical-align: middle;" rowspan="2">Noind</th>
					                    <th class="text-center" style="vertical-align: middle;" colspan="31">Tanggal</th>
					                  </tr>
					                  <tr class="">
					                    <th class="text-center" style="vertical-align: middle;">01</th>
					                    <th class="text-center" style="vertical-align: middle;">02</th>
					                    <th class="text-center" style="vertical-align: middle;">03</th>
					                    <th class="text-center" style="vertical-align: middle;">04</th>
					                    <th class="text-center" style="vertical-align: middle;">05</th>
					                    <th class="text-center" style="vertical-align: middle;">06</th>
					                    <th class="text-center" style="vertical-align: middle;">07</th>
					                    <th class="text-center" style="vertical-align: middle;">08</th>
					                    <th class="text-center" style="vertical-align: middle;">09</th>
					                    <th class="text-center" style="vertical-align: middle;">10</th>
					                    <th class="text-center" style="vertical-align: middle;">11</th>
					                    <th class="text-center" style="vertical-align: middle;">12</th>
					                    <th class="text-center" style="vertical-align: middle;">13</th>
					                    <th class="text-center" style="vertical-align: middle;">14</th>
					                    <th class="text-center" style="vertical-align: middle;">15</th>
					                    <th class="text-center" style="vertical-align: middle;">16</th>
					                    <th class="text-center" style="vertical-align: middle;">17</th>
					                    <th class="text-center" style="vertical-align: middle;">18</th>
					                    <th class="text-center" style="vertical-align: middle;">19</th>
					                    <th class="text-center" style="vertical-align: middle;">20</th>
					                    <th class="text-center" style="vertical-align: middle;">21</th>
					                    <th class="text-center" style="vertical-align: middle;">22</th>
					                    <th class="text-center" style="vertical-align: middle;">23</th>
					                    <th class="text-center" style="vertical-align: middle;">24</th>
					                    <th class="text-center" style="vertical-align: middle;">25</th>
					                    <th class="text-center" style="vertical-align: middle;">26</th>
					                    <th class="text-center" style="vertical-align: middle;">27</th>
	                 				 </tr>
	                                </thead>
	                                <tbody>
	                                  <?php $no = 1;
	                                  foreach ($polashift as $key) {   
	                                    ?>
	                                    <tr>
	                                    	<td style="text-align: center;"><?php echo $no; ?></td>
	                                    	<td><?php echo $key[0]['noind']; ?></td>
	                                    	<?php foreach ($key as $tgl) { ?>
	                                    		
	                                    	<td><?php echo $tgl['inisial']; ?></td>
	                                    	<?php } ?>
	                                    </tr> 
	                                    <?php
	                                    $no++;
	                                  }
	                                  ?>
	                                </tbody>
	                              </table>
                            	</div>
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                    <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>