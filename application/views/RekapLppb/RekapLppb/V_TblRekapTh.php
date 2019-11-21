<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
        //  $(document).ready(function () {
            // $('.datepickRekap').datepicker({
            //     autoclose: true,
            //     todayHighlight: true,
            //     dateFormat: 'yy-mm-dd',
            // });
        //     $('.tblRkapLppb').dataTable({
        //         "scrollX": false,
        //         "paging":false,
        //     });
            
        //  });
    </script>
<div class="table-responsive" id="tb_rekapTh">
<table class="table table-striped table-bordered table-responsive table-hover text-center tblRkapLppb" style="font-size:14px;">
<thead class="bg-primary">
<tr>
    <td>Bulan</td>
    <td>Jumlah Belum Deliver</td>
    <td>Action</td>
</tr>
</thead>
<tbody>
<tr>
    <td><input type="hidden" id="bulan<?= $no['0']?>" value="<?= $bulan['11']?>">January</td>
    <td><?= $selisih['11']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['11'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr>
<tr>
    <td><input type="hidden" id="bulan<?= $no['1']?>" value="<?= $bulan['10']?>">February</td>
    <td><?= $selisih['10']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['10'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['2']?>" value="<?= $bulan['9']?>">March</td>
    <td><?= $selisih['9']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['9'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['3']?>" value="<?= $bulan['8']?>">April</td>
    <td><?= $selisih['8']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['8'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['4']?>" value="<?= $bulan['7']?>">May</td>
    <td><?= $selisih['7']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['7'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['5']?>" value="<?= $bulan['6']?>">June</td>
    <td><?= $selisih['6']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['6'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['6']?>" value="<?= $bulan['5']?>">July</td>
    <td><?= $selisih['5']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['5'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['7']?>" value="<?= $bulan['4']?>">August</td>
    <td><?= $selisih['4']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['4'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['8']?>" value="<?= $bulan['3']?>">September</td>
    <td><?= $selisih['3']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['3'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['9']?>" value="<?= $bulan['2']?>">October</td>
    <td><?= $selisih['2']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['2'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['10']?>" value="<?= $bulan['1']?>">November</td>
    <td><?= $selisih['1']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['1'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr><tr>
    <td><input type="hidden" id="bulan<?= $no['11']?>" value="<?= $bulan['0']?>">December</td>
    <td><?= $selisih['0']?></td>
    <td>
    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['0'].'/'.$io)?>" >
    <button type="button" class="btn btn-xs btn-success">klik</button>
    </a></td>
</tr>
</tbody>
</table>
</div>
