<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/AllDoc');?>">
                                    <i class="icon-wrench icon-2x"></i>
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
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <center>
                                                    <select id="" name="" class="select2 col-lg-12 col-md-2" data-placeholder="BP - Business Process" required="">
                                                        <option></option>    
                                                    </select>
                                                    <select id="" name="" class="select2 col-lg-12 col-md-2" data-placeholder="CD - Context Diagram" required="">
                                                        <option></option>    
                                                    </select>
                                                    <select id="" name="" class="select2 col-lg-12 col-md-2" data-placeholder="SOP - Standard Operating Procedure" required="">
                                                        <option></option>    
                                                    </select>
                                                    <select id="" name="" class="select2 col-lg-12 col-md-2" data-placeholder="WI - Work Instructions" required="">
                                                        <option></option>    
                                                    </select>
                                                    <select id="DokumenPekerja-COP" name="COP" class="select2 col-lg-12 col-md-2" data-placeholder="COP - Code of Practice" required="">
                                                        <option></option>
                                                        <?php
                                                            foreach ($linkDokumenCOP as $linkCOP) 
                                                            {
                                                                echo '<option value="http://quick.com/erp/assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$linkCOP['link_dokumen'].'">'.$linkCOP['nama_dokumen'].'</option>';
                                                            }
                                                        ?> 
                                                    </select>
                                                </center>
                                            </div>
                                            <div class="col-lg-9">
                                                <iframe src="" id="DokumenPekerja-previewDokumen" class="col-lg-12" style="width: 100%; height: 350px" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
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