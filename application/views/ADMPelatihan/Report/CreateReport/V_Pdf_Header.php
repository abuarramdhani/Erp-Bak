<?php foreach ($report as $rp) {?>
<table style="width:100%;border: 1px solid black; padding: 0px" class="table table-bordered">
    <tr>
    	<td style="width: 110px;height: 100px;border-right: 1px solid black" rowspan="7">
            <img style="height: 100px; width: 110px" src="<?php echo base_url('/assets/img/logo.png'); ?>" />
        </td>
        <td rowspan="5" style="text-align: center; width: 400px">
        	<h3 style="margin-bottom: 0; padding-bottom: 0;font-size: 21px;">
                FORM <br> LAPORAN HASIL TRAINING 
            </h3>
        </td>
        <td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Document No.</td>
        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"><?php echo $rp['doc_no']; ?></td>
    </tr>
    <tr>
    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Rev No.</td>
        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"><?php echo $rp['rev_no']; ?></td>
    </tr>
    <tr>
    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Rev Date.</td>
        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2">
        <?php 
			$date=$rp['rev_date']; 
			$newDate=date("d M Y", strtotime($date));
			$nulldate=$rp['rev_date'];
			if ($nulldate=='0001-01-01 BC' || $nulldate=='0001-01-01' || $nulldate=='1970-01-01') {
				$givenull='';
				$rp['rev_date']=$givenull;
				echo $givenull;
			}else{
				echo $newDate;
			}
		?>
        </td>
    </tr>
    <tr>
    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Page No.</td>
        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"></td>
    </tr>
    <tr>
    	<td style="width: 100px;border-left: 1px solid black;padding-left: 5px; font-size: 13px;">Rev Note.</td>
        <td style="width: 150px;border-left: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"><?php echo $rp['rev_note']; ?></td>
    </tr>
    <tr>
    	<td colspan="7" rowspan="2" style="border-top: 1px solid black;text-align: center; margin-bottom: 0; padding: 3;">
    		<div style=" font-size: 15px;">
    			CV KARYA HIDUP SENTOSA
    		</div> 
    		<div style="font-size: 14px;">
    			Jl. Magelang No. 144 Yogyakarta
    		</div>
    	</td>
    </tr>
    <tr>
    	<td>
    	</td>
    </tr>
</table>
<?php }?>