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
<!--                                 <form method="post" action="<?php echo base_url('DokumenPekerja/DokumenCari/Cari');?>">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <center>
                                                <div class="form-group">
                                                    <select id="DokumenPekerja-cmbPencarianDokumenBerdasarkan" name="DokumenPekerja-cmbPencarianDokumenBerdasarkan" class="select2" data-placeholder="Cari WI/COP berdasarkan" required="" autofocus="" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="ALL">Semua Dokumen</option>
                                                        <option value="BP">Business Process</option>
                                                        <option value="CD">Context Diagram</option>
                                                        <option value="SOP">Standard Operating Procedure</option>
                                                        <option value="WI">Work Instruction</option>
                                                        <option value="COP">Code of Practice</option>
                                                    </select>
                                                </div>
                                            </center>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="DokumenPekerja-txtKataKunciPencarianDokumen" id="DokumenPekerja-txtKataKunciPencarianDokumen" class="col-lg-3 form-control" style="text-transform: uppercase" placeholder="Kata Kunci" required=""/>
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-success">Cari</button>
                                                    </span>
                                                </div>                                                  
                                            </div>
                                        </div>
                                    </div>
                                </form> -->
                                <div>
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-DokumenPekerja-cariDokumen" style="font-size:12px;">
                                        <thead>
                                            <tr>
                                            <!-- <th>No</th> -->
                                                <th>Business Process</th>
                                                <th>Context Diagram</th>
                                                <th>Standard Operating Procedure</th>
                                                <th>Work Instruction</th>
                                                <th>Code of Practice</th>
                                            </tr>
                                        </thead>
                                       <tfoot style="display: table-header-group;">
                                            <tr>
                                                <!-- <th>No</th> -->
                                                <th>Business Process</th>
                                                <th>Context Diagram</th>
                                                <th>Standard Operating Procedure</th>
                                                <th>Work Instruction</th>
                                                <th>Code of Practice</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                foreach ($daftarDokumen as $dokumen) 
                                                {
                                            ?>
                                            <tr>
                                                <!-- <td><?php echo $no++;?></td> -->
                                                <td>
                                                    <?php
                                                        if($dokumen['link_bp']=='#')
                                                        {
                                                    ?>
                                                    <?php echo $dokumen['business_process'];?>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <a href="<?php echo base_url($direktoriUpload.$dokumen['link_bp']);?>">
                                                        <?php echo $dokumen['business_process'];?>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($dokumen['link_cd']=='#')
                                                        {
                                                    ?>
                                                    <?php echo $dokumen['context_diagram'];?>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <a href="<?php echo base_url($direktoriUpload.$dokumen['link_cd']);?>">
                                                        <?php echo $dokumen['context_diagram'];?>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($dokumen['link_sop']=='#')
                                                        {
                                                    ?>
                                                    <?php echo $dokumen['standard_operating_procedure'];?>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <a href="<?php echo base_url($direktoriUpload.$dokumen['link_sop']);?>">
                                                        <?php echo $dokumen['standard_operating_procedure'];?>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($dokumen['link_wi']=='#')
                                                        {
                                                    ?>
                                                    <?php echo $dokumen['work_instruction'];?>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <a href="<?php echo base_url($direktoriUpload.$dokumen['link_wi']);?>">
                                                        <?php echo $dokumen['work_instruction'];?>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($dokumen['link_cop']=='#')
                                                        {
                                                    ?>
                                                    <?php echo $dokumen['code_of_practice'];?>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <a href="<?php echo base_url($direktoriUpload.$dokumen['link_cop']);?>">
                                                        <?php echo $dokumen['code_of_practice'];?>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>