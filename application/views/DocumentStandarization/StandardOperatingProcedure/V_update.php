<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/SOP/update/'.$id);?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/SOP/');?>">
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
                                <div class="box-header with-border">Update Standard Operating Procedure</div>
                                <?php
                                    foreach ($StandardOperatingProcedure as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtSopNameHeader" class="control-label col-lg-4">Nama SOP</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtSopNameHeader" id="txtSopNameHeader" class="form-control bubbletip-character sensitive-input" value="<?php echo $headerRow['nama_sop'];?>"  style="text-transform: uppercase" required=""/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbContextDiagram" class="control-label col-lg-4">Context Diagram</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbContextDiagram" name="cmbContextDiagram" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($daftarContextDiagram as $CD) 
                                                            {
                                                                $status_data = ' ';
                                                                if($CD['id_context_diagram']==$headerRow['kode_context_diagram'])
                                                                {
                                                                    echo $status_data = 'selected';
                                                                }
                                                                echo '  <option value="'.$CD['id_context_diagram'].'" '.$status_data.'>'
                                                                            .$CD['daftar_context_diagram'].
                                                                        '</option>';
                                                            }
                                                        ?>
                                                    </select>                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtNoDocHeader" class="control-label col-lg-4">Nomor Dokumen</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtNoDocHeader" id="txtNoDocHeader" class="form-control bubbletip-character sensitive-input" value="<?php echo $headerRow['nomor_dokumen'];?>"  style="text-transform: uppercase" required=""/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtNoRevisiHeader" class="control-label col-lg-4">Nomor Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtNoRevisiHeader" id="txtNoRevisiHeader" class="form-control bubbletip-character sensitive-input" value="<?php echo $headerRow['nomor_revisi'];?>"  style="text-transform: uppercase" required=""/>
                                                    <input class="hidden" type="text" name="txtNoRevisiLamaHeader" class="form-control" style="text-transform: uppercase;" value="<?php echo $headerRow['nomor_revisi'];?>" readonly >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTanggalHeader" class="control-label col-lg-4">Tanggal Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d-m-Y')?>" name="txtTanggalHeader" class="date form-control daterangepickersingledate" data-date-format="dd-mm-yyyy" id="txtTanggalHeader" data-inputmask="'alias': 'dd-mm-yyyy'" value="<?php echo $headerRow['tanggal_revisi'];?>"/>
                                                    <input class="hidden" type="text" name="txtTanggalLamaHeader" class="form-control" style="text-transform: uppercase;" value="<?php echo $headerRow['tanggal_revisi'];?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtJmlHalamanHeader" class="control-label col-lg-4">Jumlah Halaman</label>
                                                <div class="col-lg-4">
                                                    <input type="number" min="0" name="txtJmlHalamanHeader" id="txtJmlHalamanHeader" class="form-control" value="<?php echo $headerRow['jumlah_halaman'];?>" required=""/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDibuatHeader" class="control-label col-lg-4">Dibuat</label>
                                                <div class="col-lg-4">
                                                     <select id="cmbPekerjaPembuat" name="cmbPekerjaDibuat" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <option value="<?php echo $headerRow['kode_pekerja_pembuat'];?>" selected><?php echo $headerRow['pekerja_pembuat'];?></option>
                                                        <?php
                                                        /*
                                                            foreach ($pekerjaAll as $Pekerja) 
                                                            {
                                                                echo '  <option value="'.$Pekerja['id_pekerja'].'">'.$Pekerja['daftar_pekerja'].'</option>';
                                                            }
                                                        */
                                                        ?>
                                                    </select>                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDiperiksa1Header" class="control-label col-lg-4">Diperiksa 1</label>
                                                <div class="col-lg-4">
                                                     <select id="cmbPekerjaPemeriksa1" name="cmbPekerjaDiperiksa1" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <option value="<?php echo $headerRow['kode_pekerja_pemeriksa_1'];?>" selected><?php echo $headerRow['pekerja_pemeriksa_1'];?></option>
                                                        <?php
                                                        /*
                                                            foreach ($pekerjaAll as $Pekerja) 
                                                            {
                                                                echo '  <option value="'.$Pekerja['id_pekerja'].'">'.$Pekerja['daftar_pekerja'].'</option>';
                                                            }
                                                        */
                                                        ?>
                                                    </select>                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDiperiksa2Header" class="control-label col-lg-4">Diperiksa 2</label>
                                                <div class="col-lg-4">
                                                     <select id="cmbPekerjaPemeriksa2" name="cmbPekerjaDiperiksa2" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="<?php echo $headerRow['kode_pekerja_pemeriksa_2'];?>" selected><?php echo $headerRow['pekerja_pemeriksa_2'];?></option>
                                                        <?php
                                                        /*
                                                            foreach ($pekerjaAll as $Pekerja) 
                                                            {
                                                                echo '  <option value="'.$Pekerja['id_pekerja'].'">'.$Pekerja['daftar_pekerja'].'</option>';
                                                            }
                                                        */
                                                        ?>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDiputuskanHeader" class="control-label col-lg-4">Diputuskan</label>
                                                <div class="col-lg-4">
                                                     <select id="cmbPekerjaPemberiKeputusan" name="cmbPekerjaDiputuskan" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <option value="<?php echo $headerRow['kode_pekerja_pemberi_keputusan'];?>" selected><?php echo $headerRow['pekerja_pemberi_keputusan'];?></option>
                                                        <?php
                                                        /*
                                                            foreach ($pekerjaAll as $Pekerja) 
                                                            {
                                                                echo '  <option value="'.$Pekerja['id_pekerja'].'">'.$Pekerja['daftar_pekerja'].'</option>';
                                                            }
                                                        */
                                                        ?>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txaSopInfoHeader" class="control-label col-lg-4">Catatan Revisi</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaSopInfoHeader" id="txaSopInfoHeader" class="form-control ckeditor" ><?php echo $headerRow['info'];?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group hidden">
                                                <label for="txaSopTujuanHeader" class="control-label col-lg-4">Tujuan</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaSopTujuanHeader" id="txaSopTujuanHeader" class="ckeditor form-control" ><?php echo $headerRow['tujuan_sop'];?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group hidden">
                                                <label for="txaSopRuangLingkupHeader" class="control-label col-lg-4">Ruang Lingkup</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaSopRuangLingkupHeader" id="txaSopRuangLingkupHeader" class="ckeditor form-control" ><?php echo $headerRow['ruang_lingkup_sop'];?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group hidden">
                                                <label for="txaSopReferensiHeader" class="control-label col-lg-4">Referensi</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaSopReferensiHeader" id="txaSopReferensiHeader" class="ckeditor form-control" ><?php echo $headerRow['referensi_sop'];?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group hidden">
                                                <label for="txaSopDefinisiHeader" class="control-label col-lg-4">Definisi</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaSopDefinisiHeader" id="txaSopDefinisiHeader" class="ckeditor form-control" ><?php echo $headerRow['definisi_sop'];?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtSopFileHeader" class="control-label col-lg-4">Upload File</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="txtSopFileHeader" id="txtSopFileHeader" class="form-control" />
                                                    <a target="_blank" href="<?php echo base_url('assets/upload/PengembanganSistem/StandarisasiDokumen/'.$headerRow['file']);?>"><?php echo $headerRow['file'];?></a>
                                                    <input type="text" name="DokumenAwal" id="DokumenAwal" hidden="" value="<?php echo $headerRow['file'];?>">
                                                    <input type="text" name="WaktuUpload" id="WaktuUpload" hidden="" value="<?php echo $headerRow['waktu_upload_file'];?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="checkboxRevisi" class="control-label col-lg-4">Revisi Baru</label>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" id="bubbletip-checkboxRevisi" name="checkboxRevisi" value="1">
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
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>