<script>
        $(document).ready(function () {
        $('.tblMonMng').dataTable({
            "scrollX": true,
            paging : false,
        });
        
        });
</script>
<style>
table{
    font-size: 12px;
}
</style>
<div class="table-responsive ">
<table class="table table-hover text-center" style="width: 100%;">
    <thead class="bg-primary">
        <tr class="text-nowrap text-center">
            <th><i class="fa fa-plus" aria-hidden="true"></i></th>
            <th>Bom Level</th>
            <th>Component Code</th>
            <th></th><th></th>
            <th>Description</th>
            <th></th><th></th>
            <th>QTY/Unit</th>
            <th>Seksi</th>
            <th></th>
            <th></th>
            <?php 
            if ($bulan == 'Jan' || $bulan == 'Mar' ||$bulan == 'May' || $bulan == 'Jul' || $bulan == 'Ags' || $bulan == 'Oct' || $bulan == 'Dec') {
                for ($i=1; $i < 32; $i++) { 
                    echo ("<th>$i</th>");
                }
            }elseif ($bulan == 'Apr' || $bulan == 'Jun' || $bulan == 'Sep' || $bulan == 'Nov') {
                for ($i=1; $i < 31; $i++) { 
                    echo ("<th>$i</th>");
                }
            }elseif ($bulan == 'Feb') {
                if ($tahun%4 == 0) {
                    for ($i=1; $i < 30; $i++) { 
                        echo ("<th>$i</th>");
                    }
                }else {
                    for ($i=1; $i < 29; $i++) { 
                        echo ("<th>$i</th>");
                    }
                }
            }
            ?>
            <th>Total</th>
            <th>Presentase</th>
        </tr>
    </thead>
    <?php 
        echo '<div class="just-padding">';
        echo $htmllist;
        echo '</div>';
                // echo "<pre>";
                // print_r($Tree);
                // print_r($BOM);
                // print_r($List);
                // exit();
    ?>
</table>
</div>


<div class="modal fade" id="mdlaktual" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align:center;"><b>Konfirmasi Penerimaan Komponen</b></h3>
			</div>
			<div class="modal-body">
                <div id="tglaktual"></div>
		    </div>
		</div>
	</div>
</div>