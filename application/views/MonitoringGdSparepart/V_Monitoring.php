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
                                            <option value="belumterlayani">Belum Terlayani</option>
                                            <option value="export" id="slcExMGS">Export Excel</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3" style="display:none" id="slcnodoc">
                                        <label >No Dokumen</label>
                                            <input id="no_document" name="no_document" class="form-control" style="width:100%;" placeholder="No Dokumen">
                                    </div>
                                    <div class="col-md-3" style="display:none" id="slcjenis">
                                        <label class="control-label">Jenis Dokumen </label>
                                            <select id="jenis_dokumen" name="jenis_dokumen" class="form-control select2 select2-hidden-accessible" style="width:100%;" data-placeholder="Pilih Jenis Dokumen">
                                            <option></option>
                                            <option value="IO">IO</option>
                                            <option value="KIB">KIB</option>
                                            <option value="LPPB">LPPB</option>
                                            <!-- <option value="FPB">FPB</option> -->
                                            </select>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcTgl">
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Awal</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAwal" name="tglAwal" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Akhir</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAkhir" name="tglAkhir" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcPIC">
                                    <div class="col-md-3">
                                        <label class="control-label">PIC</label>
                                        <select id="pic" name="pic" class="form-control select2 select2-hidden-accessible picGDSP" style="width:100%;" required>
                                            <option></option>
                                        </select>
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
                                        <form method="post" id="frmMGS" action="<?= base_url('MonitoringGdSparepart/Monitoring/getUpdate'); ?>">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped text-center" id="tblMGS" style="width: 100%; table-layout:fixed;">
                                                        <thead class="bg-primary">
                                                            <tr class="text-center">
                                                                <th width="5%">No</th>
                                                                <th>Jenis Dokumen</th>
                                                                <th>No Dokumen</th>
                                                                <th>Tanggal</th>
                                                                <th>Jam Input</th>
                                                                <th>PIC</th>
                                                                <th>Asal</th>
                                                                <th>Keterangan</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $no=1; foreach ($value as $k => $row) { ?>
                                                            <tr class="text-center">
                                                                <td width="5%"><?= $no; ?></td>
                                                                <td><?= $row['header']['JENIS_DOKUMEN'] ?></td>
                                                                <td><?= $row['header']['NO_DOCUMENT'] ?></td>
                                                                <td><?= $row['header']['CREATION_DATE'] ?></td>
                                                                <td><?= $row['header']['JAM_INPUT'] ?></td>
                                                                <td><?= $row['header']['PIC'] ?></td>
                                                                <td><?= $row['header']['gd_asal'] ?></td>
                                                                <td><?= $row['header']['statusket']  ?></td>
                                                                <td><span class="btn btn-success" onclick="addDetailMGS(this, <?= $no ?>)" >Detail</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="8" >
                                                                    <div id="detail<?= $no ?>" style="display:none">
                                                                        <table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%; border: 2px solid #ddd;">
                                                                            <thead class="bg-teal">
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Item</th>
                                                                                    <th>Deskripsi</th>
                                                                                    <th>Jumlah</th>
                                                                                    <th width="10%">OK</th>
                                                                                    <th width="10%">NOT OK</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $nomor=1; foreach ($row['body'] as $v) { ?>
                                                                                <tr>
                                                                                    <td><?= $nomor++ ?>
                                                                                        <input type="hidden" name="doc[]" id="doc<?=$no?><?= $nomor ?>" value="<?= $v['NO_DOCUMENT'] ?>"/>
                                                                                        <input type="hidden" name="jenis[]" value="<?= $v['JENIS_DOKUMEN'] ?>"/>
                                                                                        <input type="hidden" name="uom[]" value="<?= $v['UOM'] ?>"/>
                                                                                        <input type="hidden" name="tanggal[]" value="<?= $v['CREATION_DATE'] ?>"/>
                                                                                        <input type="hidden" name="ktrgn[]" value="<?= $row['header']['statusket'] ?>"/>
                                                                                    </td>
                                                                                    <td style="text-align:left"><input type="hidden" name="item[]" id="item<?=$no?><?= $nomor ?>" value="<?= $v['ITEM'] ?>"/><?= $v['ITEM'] ?></td>
                                                                                    <td style="text-align:left"><input type="hidden" name="nama_brg[]" value="<?= $v['DESCRIPTION'] ?>"/><?= $v['DESCRIPTION'] ?></td>
                                                                                    <td><input type="hidden" name="qty[]" value="<?= $v['QTY'] ?>"/><?= $v['QTY'] ?></td>
                                                                                    <td><input type="text" style="width:100%; text-align:center" name="qty_ok[]" id="jml_ok<?=$no?><?= $nomor ?>" onchange="saveJmlOk(<?=$no?>,<?= $nomor ?>)" value="<?= $v['JML_OK'] ?>"
                                                                                    <?php if($row['header']['statusket']== 'Sudah terlayani') 
                                                                                            { ?>
                                                                                            readonly
                                                                                            <?php }else{
                                                                                                echo '';
                                                                                            } ?>
                                                                                    /></td>
                                                                                    <td><input type="text" style="width:100%; text-align:center" name="qty_not[]" id="jml_not_ok<?=$no?><?= $nomor ?>" onchange="saveNotOk(<?=$no?>,<?= $nomor ?>)" value="<?= $v['JML_NOT_OK'] ?>"
                                                                                    <?php if($row['header']['statusket']== 'Sudah terlayani') 
                                                                                            { ?>
                                                                                            readonly
                                                                                            <?php }else{
                                                                                                echo '';
                                                                                            } ?>
                                                                                    /></td>
                                                                                    <td style="text-align:left"><input type="text" style="width:100%" name="ketr[]" id="keterangan<?=$no?><?= $nomor ?>" onchange="saveKetr(<?=$no?>,<?= $nomor ?>)" value="<?= $v['KETERANGAN'] ?>"
                                                                                    <?php if($row['header']['statusket']== 'Sudah terlayani') 
                                                                                            { ?>
                                                                                           readonly
                                                                                            <?php }else{
                                                                                                echo '';
                                                                                            } ?>
                                                                                    /></td>
                                                                                    <td style="text-align:left"><input type="text" style="width:100%" name="action[]" id="action<?=$no?><?= $nomor ?>" onchange="saveAction(<?=$no?>,<?= $nomor ?>)" value="<?= $v['ACTION'] ?>"
                                                                                    <?php if($row['header']['statusket']== 'Sudah terlayani') 
                                                                                            { ?>
                                                                                           readonly
                                                                                            <?php }else{
                                                                                                echo '';
                                                                                            } ?>
                                                                                    /></td>
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
                                                        <input type="submit" class="btn btn-lg btn-success" name="action" style="display:none" id="btnExMGS" value="Export">
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