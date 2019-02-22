<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Upload Data</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('EmployeeRecruitment/Upload/index');?>">
                                    <i class="icon-upload icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Form Upload File Data
                            </div>
                            <div class="box-body">
                                <div class="row" style="font-size: 13px">
                                <form method="post" enctype="multipart/form-data" action="<?= base_url('EmployeeRecruitment/Upload/inputfile') ?>">

                                    <?php if (isset($resultload['error_msg'])) { ?>
                                    <div class="row"> <div class="col-md-6 col-md-offset-3 " style="margin-top: 20px">
                                       <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#e75151; text-align:center; color:white; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <?php echo $resultload['error_msg'];?> </div> 
                                        </div>
                                     </div>
                                    <?php } ?>

                                    <div class="col-lg-12" style="padding-top: 10px">
                                        <div class="form-group" style="margin: 8 auto">
                                            <label class="col-md-2 control-label">File Upload</label>
                                            <div class="col-md-4">
                                                <input required type="file" class="form-control" name="file_a">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding-top: 10px">
                                        <div class="form-group" style="margin: 8 auto">
                                            <label class="col-md-2 control-label">Jenis Soal</label>
                                            <div class="col-md-4">
                                                <select data-placeholder="-- Choose One --" required class="form-control select2" name="jenis" >
                                                    <option></option>
                                                    <?php foreach ($jenis_soal as $js) { ?>
                                                        <option value="<?php echo $js['jenis_soal'] ?>"><?php echo $js['jenis_soal'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="submit" class="btn btn-success " >
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                            
                                
                                <?php if (isset($resultload['warna'])) { ?>
                                <div class="col-lg-12" id="resLoad" style="padding-top: 10px">
                                    <hr>
                                    <label class="col-md-3 control-label">Tanggal Upload : <?php echo  date('d-m-Y') ?></label>
                                    <label class="col-md-2 control-label">Jumlah Error: 
                                            <span id="jmlError" style="color: <?php echo $resultload['error'] > 0 ? 'red' :'green'; ?>" ><?php echo $resultload['error'] ?> 
                                            </span>
                                            <span id="ErrDone" style="color: green"></span>
                                    </label>
                                     <label class="col-md-2 control-label">Jumlah Kosong: 
                                            <span id="jmlEmpty" style="color: <?php echo $resultload['kosong'] > 0 ? 'orange' :'green'; ?>" ><?php echo $resultload['kosong'] ?> 
                                            </span>
                                            <span id="EmpDone" style="color: green"></span>
                                    </label>
                                        <div class="" style="margin: 8 auto; width: 100%">
                                            <form method="post" action="<?= base_url('EmployeeRecruitment/Upload/process') ?>" >
                                            <input type="hidden" name="jenis" value="<?= $resultload['jenis']; ?>">
                                           <table id="tabletest" class=" table table-bordered" style="width:100%">
                                                <thead>
                                                <tr class="bg-blue">
                                                    <th >No</th>
                                                    <th>ID</th>
                                                    <th>Secondary_ID</th>
                                                    <th>Image Name</th>
                                                    <th>True</th>
                                                    <th>False</th>
                                                    <th>Score</th>
                                                    <th>Empty</th>
                                                    <?php for($x=1 ; $x < $resultload['kolom']+1 ;$x++) {?>
                                                    <th><center><?= $x; ?></center></th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no = 1; $s=0; 
                                                    foreach ($resultload['warna'] as $war) { ?>
                                                    
                                                    <tr>
                                                        <?php foreach ($war as $key => $value) { 
                                                            if ($key >= 8 && (is_array($value) == true)) {
                                                                $style = $value['sign'];
                                                            }else{
                                                                $style = '';
                                                            }
                                                            ?>
                                                                <td  class="<?= $style ?>" >
                                                                    <?php if (is_array($value)) {?>
                                                                    <input onkeyup="checkJawabERC(this)" data-rule="<?=$value['rule']?>" type="text" class="form-control" style="width: 60px" name="value[<?= $s; ?>][]" value="<?=$value['val']?>">
                                                                    <?php }else{ echo $value; ?>  
                                                                    <input type="hidden" name="value[<?= $s; ?>][]" value="<?= $value ?>">
                                                                    <?php } ?>
                                                                </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $s++; }
                                                 ?>
                                                </tbody>
                                            </table>
                                            <button id="processCor" class="btn btn-primary pull-right" type="submit" > Process Corection </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php }elseif ($result) {?>
                                   <div class="col-lg-12" style="padding-top: 10px">
                                    <hr>
                                        <div class="" style="margin: 8 auto; width: 100%">
                                            <form method="post" action="<?php echo base_url('EmployeeRecruitment/Upload/export') ?>" >
                                                <input type="hidden" name="batchnum" value="<?php echo $result[0]['batch']; ?>">
                                                <input type="hidden" name="jenis" value="<?php echo $result[0]['jenis_soal']; ?>">
                                            <button class="btn btn-success pull-right" > <i class="fa fa-file-excel-o"></i> Export </button>
                                            </form>
                                           <table  class="tabletest2 table table-bordered" style="width:100%">
                                                <thead>
                                                <tr class="bg-blue">
                                                    <th >No</th>
                                                    <th>ID</th>
                                                    <th>Batch Upload</th>
                                                    <th>Jenis Soal</th>
                                                    <th>Jawaban Benar</th>
                                                    <th>Jawaban Salah</th>
                                                    <th>Jawaban Kosong</th>
                                                    <th>Score</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no = 0; $i=0; 
                                                    foreach ($result as $res) { ?>
                                                    
                                                    <tr>
                                                        <td><?= $i+1 ?></td>
                                                        <td><?= $res['result'][1] ?></td>
                                                        <td><?=  $res['batch'] ?></td>
                                                        <td><?= $res['jenis_soal'] ?></td>
                                                        <td><?= $res['tot_betul'] ?></td>
                                                        <td><?= $res['tot_salah'] ?></td>
                                                        <td><?= $res['tot_kosong'] ?></td>
                                                        <td>
                                                            <center>
                                                            <b style="color: blue"><?= $res['score'] ?></b>
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                            <button data-toggle="modal" data-target="#detail<?= $i ?>" class="btn btn-xs btn-warning"  > Detail</button>
                                                            </center>
                                                            <div class="modal fade" id="detail<?= $i ?>">
                                                                <div class="modal-dialog" style="width: 1200px">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-primary">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title">Detail Jawaban</h4>
                                                                        </div>
                                                                        <div class="modal-body">
<!--  -->
<label class="col-md-2 control-label"><b>Hitam</b>  : Jawaban</label>
<label class="col-md-2 control-label"><b style="color: #0ada0a">Hijau</b> : Kunci</label>
<label class="col-md-2 control-label"><b style="color: blue">Biru</b> : Skor</label>
                                        <table class=" tabletest2 table table-bordered" >
                                                <thead>
                                                <tr class="bg-blue">
                                                    <th >No</th>
                                                    <th  style="min-width: 50px"><center>ID</center></th>
                                                    <th  style="min-width: 50px"><center>Jenis Soal</center></th>
                                                    <?php foreach ($res['sub_test'] as $key => $value) { ?>
                                                    <th style="min-width: 50px;background-color: #1abbb2"><center> Sub Test <?= $key; ?></center></th>
                                                    <?php } ?>
                                                    <th style="background-color: #1abbb2" ><center>Jawaban Benar</center></th>
                                                    <th style="background-color: #1abbb2" ><center>Jawaban Salah</center></th>
                                                    <th style="background-color: #1abbb2" ><center>Jawaban Kosong</center></th>
                                                    <th class="bg-green" ><center>Score</center></th>
                                                    <?php for($x=1 ; $x < count($res['result'])-7 ;$x++) {?>
                                                    <th valign="middle" class="bg-purple" style="min-width: 70px"><center><?= $x; ?></center></th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $i+1; ?></td>
                                                        <td><?php echo $res['result'][1]; ?></td>
                                                        <td><?php echo $res['jenis_soal']; ?></td>
                                                    <?php foreach ($res['sub_test'] as $key => $value) { ?>
                                                        <td><?= $value; ?></td>
                                                    <?php } ?>
                                                        <td><?= $res['tot_betul'] ?></td>
                                                        <td><?= $res['tot_salah'] ?></td>
                                                        <td><?= $res['tot_kosong'] ?></td>
                                                        <td>
                                                            <center>
                                                            <b style="color: blue"><?= $res['score'] ?></b>
                                                            </center>
                                                        </td>
                                                    <?php $no = 1; $s=0;
                                                        for ($x=8; $x < (count($res['result'])); $x++){
                                                            if ($res['result'][$x]['hasil'] == 'salah') {
                                                                $color = "#ffacac";
                                                            }elseif ($res['result'][$x]['hasil'] == 'kosong') {
                                                                $color = "#cacaca";
                                                            }else{
                                                                $color = "";
                                                            }
                                                         ?>
                                                            <td style="background-color: <?php echo $color?>" >
                                                                <center>
                                                                    <b style="color: black"><?= $res['result'][$x]['jawab'] ?></b> |
                                                                    <b style="color: #0ada0a"><?= $res['result'][$x]['kunci'] ?></b> |
                                                                    <b style="color: blue"><?= $res['result'][$x]['score'] ?> </b>                                                                    
                                                                </center>
                                                            </td>
                                                    <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
<!--  -->
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; }
                                                 ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>'
</script>
