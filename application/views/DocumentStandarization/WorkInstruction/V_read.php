<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/WorkInstruction/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br />
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Work Instruction</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($WorkInstruction as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nama Work Instruction</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_work_instruction']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Business Process</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_business_process']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Context Diagram</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_context_diagram']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Standard Operating Procedure</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nama_standard_operating_procedure']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Dokumen</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_dokumen']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Revisi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_revisi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal Revisi</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tanggal_revisi']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Dibuat</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pekerja_pembuat']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Diperiksa 1</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pekerja_pemeriksa_1']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Diperiksa 2</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pekerja_pemeriksa_2']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Diputuskan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['pekerja_pemberi_keputusan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jumlah Halaman</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jumlah_halaman']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Catatan Revisi</strong></td>
                                                            <td style="border: 0"><?php echo $headerRow['info']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>File</strong></td>
                                                            <td style="border: 0">: <a class="btn btn-info" href="<?php echo base_url('assets/upload/IA/StandarisasiDokumen/').'/'.$headerRow['file'];?>" download="<?php echo str_replace('_', ' ', $headerRow['file']);?>"><?php echo $headerRow['file'];?></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Waktu Input</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['waktu_input']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Waktu Upload File</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['waktu_upload_file']; ?></td>
                                                        </tr>
													<?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
													</ul>
                                                    <div class="tab-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div align="right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>