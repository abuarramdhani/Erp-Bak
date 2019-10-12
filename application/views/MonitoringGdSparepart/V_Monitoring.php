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
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('MonitoringGdSparepart/Monitoring/');?>">
                                    <i class="icon-wrench icon-2x">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Monitoring</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-left">
                                      <label class="control-label"><?php echo date("l, d F Y") ?></label>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="control-label">Search by </label>
                                            <select id="search_by" name="search_by" class="form-control select2 select2-hidden-accessible" style="width:100%;" data-placeholder="Cari berdasarkan">
                                            <option></option>
                                            <option value="dokumen">Dokumen</option>
                                            <option value="tanggal">Tanggal</option>
                                            <option value="pic">PIC</option>
                                            <option value="item">Item</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcDokumen">
                                    <div class="col-md-3" >
                                        <label >No Dokumen</label>
                                            <input id="no_document" name="no_document" class="form-control" style="width:100%;" placeholder="No Dokumen">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Jenis Dokumen </label>
                                            <select id="jenis_dokumen" name="jenis_dokumen" class="form-control select2 select2-hidden-accessible" style="width:100%;" data-placeholder="Pilih Item">
                                            <option></option>
                                            <option value="IO">IO</option>
                                            <option value="KIB">KIB</option>
                                            <option value="LPPB">LPPB</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcTgl">
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Awal</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAwal" name="tglAwal" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Akhir</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAkhir" name="tglAkhir" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcPIC">
                                    <div class="col-md-3">
                                        <label class="control-label">PIC</label>
                                        <input id="pic" name="pic" class="form-control" autocomplete="off" style="width:100%;" placeholder="Nama PIC">
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcItem">
                                    <div class="col-md-3">
                                        <label class="control-label">Item</label>
                                        <input id="item" name="item" class="form-control" autocomplete="off" style="width:100%;" placeholder="Item">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <button onclick="getMGS(this)" class="btn btn-success" id="btnfind" title="search"><i class="fa fa-search"></i> Find</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel-body">
                                <div class="col-md-12" ></div>
                                    <div class="box box-primary box-solid">
                                        <div class="box-header with-border"><b>Hasil</b></div>
                                        <div class="box-body">
                                        <form method="post" action="<?= base_url('MonitoringGdSparepart/Monitoring/getUpdate'); ?>">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed;">
                                                        <thead class="bg-primary">
                                                            <tr class="text-center">
                                                                <th width="3%">No</th>
                                                                <th>Jenis Dokumen</th>
                                                                <th>No Dokumen</th>
                                                                <th>Tanggal</th>
                                                                <th>Jam Input</th>
                                                                <th>PIC</th>
                                                                <th>Keterangan</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $no=1; foreach ($value as $k => $row) { ?>
                                                            <tr class="text-center">
                                                                <td width="3%"><?= $no; ?></td>
                                                                <td><?= $row['header']['JENIS_DOKUMEN'] ?></td>
                                                                <td><?= $row['header']['NO_DOCUMENT'] ?></td>
                                                                <td><?= $row['header']['CREATION_DATE'] ?></td>
                                                                <td><?= $row['header']['JAM_INPUT'] ?></td>
                                                                <td><?= $row['header']['PIC'] ?></td>
                                                                <td><?= $row['header']['statusket']  ?></td>
                                                                <td><span class="btn btn-success" onclick="addDetailMGS(this, <?= $no ?>)" >Detail</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="7" >
                                                                    <div id="detail<?= $no ?>" style="display:none">
                                                                        <table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%; border: 2px solid #ddd;">
                                                                            <thead class="bg-teal">
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Item</th>
                                                                                    <th>Deskripsi</th>
                                                                                    <th>Jumlah</th>
                                                                                    <th>OK</th>
                                                                                    <th>NOT OK</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Edit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $nomor=1; foreach ($row['body'] as $v) { ?>
                                                                                <tr>
                                                                                    <td><?= $nomor++ ?>
                                                                                        <input type="hidden" name="doc[]" value="<?= $v['NO_DOCUMENT'] ?>"/></td>
                                                                                    <td style="text-align:left"><input type="hidden" name="item[]" value="<?= $v['ITEM'] ?>"/><?= $v['ITEM'] ?></td>
                                                                                    <td style="text-align:left"><?= $v['DESCRIPTION'] ?></td>
                                                                                    <td><?= $v['QTY'] ?></td>
                                                                                    <td><?= $v['JML_OK'] ?></td>
                                                                                    <td><?= $v['JML_NOT_OK'] ?></td>
                                                                                    <td style="text-align:left"><?= $v['KETERANGAN'] ?></td>
                                                                                    <!-- <td><button type="button" class="btn btn-warning" onclick="btnEdit(this, <?=$no?>,<?=$nomor?>)">Edit</button></td> -->
                                                                                    <td><input type="button" value="Edit" class="btn btn-warning" 
                                                                                            <?php if($row['header']['statusket']== 'Sudah terlayani') 
                                                                                            {
                                                                                                echo ' disabled=disabled ';
                                                                                            }else{
                                                                                                echo '';
                                                                                            }?>
                                                                                            onclick="btnEditMGS(this, <?=$no?>,<?=$nomor?>)" /></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td colspan="6">
                                                                                        <div id="edit<?=$no?><?= $nomor ?>" style="display:none">
                                                                                            <table class="table table-bordered table-hover text-center table-responsive" id="myTable" style="width: 100%; border: 2px solid #ddd">
                                                                                            <thead class="bg-yellow">
                                                                                                <tr>
                                                                                                    <th>Status</th>
                                                                                                    <th width="20%">Jumlah</th>
                                                                                                    <th>Keterangan</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>OK</td>
                                                                                                    <td><input type="number" name="jml_ok[]" class="form-control" placeholder="*Pastikan terisi"/></td>
                                                                                                    <td></td>
                                                                                                </tr>    
                                                                                                <tr>
                                                                                                    <td>NOT OK</td>
                                                                                                    <td><input type="number" name="jml_not_ok[]" class="form-control" placeholder="*Pastikan terisi"/></td>
                                                                                                    <td><input  name="keterangan[]" class="form-control" placeholder="*Pastikan terisi"/></td>
                                                                                                </tr>    
                                                                                            </tbody>                                   
                                                                                            </table>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                            </tbody>                                        
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php $no++;} ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="panel-heading text-right">
                                                        <button type="submit" class="btn btn-lg btn-danger" title="save"> Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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