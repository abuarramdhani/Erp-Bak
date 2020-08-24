<style>
.btn_areashaft {
  background-color: #91071D; 
  color: white; 
  border: 2px solid #4CAF50;
}
.btn_areashaft:hover {
  background-color: #71071D;
  color: white;
}

</style>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <h2 style="font-weight:bold;text-align:center"><i class="fa fa-home"></i> LAYOUT LANTAI 2</h2>
                            </div>
                            <div class="box-body">
                                <form method="post" target="_blank">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <table class="table" style="width:100%">
                                            <tr>
                                                <td  colspan="2" style="width:50px">
                                                    <!-- <button class="btn" style="background-color:#B5BAB9;height:180px;width:400px;color:grey;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-C-K")?>"></button><br>
                                                    <button class="btn" style="background-color:#B5BAB9;height:440px;width:60%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-C-K")?>">A-C-K</button> -->
                                                    <a href="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-C-K")?>" target="_blank">
                                                        <img style="max-width: 700px;max-height: 700px;margin-bottom:-17px;" class="gambar" src="<?php echo base_url("assets/img/atas.png")?>" 
                                                            onmouseover="hover1()"
                                                            onmouseout="hover2()">
                                                    </a></td>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr style="height:10px;">
                                            <td rowspan="9" colspan="2" style="width:50px">
                                                    <a href="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-C-K")?>" target="_blank">
                                                        <img style="max-width: 700px;max-height: 700px;" class="gambar" src="<?php echo base_url("assets/img/bawah.png")?>"
                                                            onmouseover="hover1()"
                                                            onmouseout="hover2()">
                                                    </a></td>
                                                <td colspan="3"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold;" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R01")?>">A-B-R1</button></td>
                                            </tr>
                                            <?php  $a = 2; $b = 12;for ($i=0; $i < 8; $i++) { 
                                                $c =  sprintf("%02d", $a);
                                                echo '<tr style="height:10px">
                                                <td colspan="2"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="'. base_url("StockGdSparepart/RakLantai2/Detail/A-B-R".$c."").'">A-B-R'.$a.'</button></td>
                                                <td style="width:250px"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="'. base_url("StockGdSparepart/RakLantai2/Detail/A-B-R".$b."").'">A-B-R'.$b.'</button></td>
                                            </tr>';
                                            $a++; $b++;
                                            } ?>
                                            <tr style="height:10px;">
                                                <td style="width:270px"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R15")?>">A-C-R15</button></td>
                                                <td></td>
                                                <td colspan="2"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R10")?>">A-B-R10</button></td>
                                                <td><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R20")?>">A-B-R20</button></td>
                                            </tr>
                                            <tr style="height:10px"><!--background-color:#91071D; -->
                                                <td rowspan="2"><button class="btn btn_areashaft" style="width:100%;border-color:black;height:80px;color:white;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/AREA SHAFT")?>">AREA SHAFT</button></td>
                                                <td rowspan="2"></td>
                                                <td colspan="2"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R11")?>">A-B-R11</button></td>
                                                <td><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R21")?>">A-B-R21</button></td>
                                            </tr>
                                            <tr style="height:10px">
                                                <td colspan="2"><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-RS")?>">A-B-RS</button></td>
                                                <td><button class="btn btn-info" style="border-color:black;width:100%;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-B-R22")?>">A-B-R22</button></td>
                                            </tr>
                                            <tr style="height:10px">
                                                <td colspan="2"></td>
                                                <td colspan="3"><button class="btn bg-orange" style="border-color:black;width:100%;height:80px;color:black;font-weight:bold" formaction="<?php echo base_url("StockGdSparepart/RakLantai2/Detail/A-ANCAK")?>">A-ANCAK</button></td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


