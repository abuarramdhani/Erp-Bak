        <div class="row">
            <table class="table table-bordered" style="font-size:11px;">
                <tr>
                    <td rowspan="4">
                        <img src="<?php echo base_url('assets/img/logo.png')?>" style="width:70px;"/>
                    </td>
                    <td rowspan="4" style="width: 300px; padding-left: 5px; padding-right: 5px;">
                        <h4><b>CV. KARYA HIDUP SENTOSA</b></h4>
                        <small>Jl. Magelang No. 144 Yogyakarta 55241</small>
                        <br>
                            <small>
                                Phone: (0274) 563217, 556923, 513025, 584874, 512095 (hunting)
                            </small>
                            <br>
                                <small>
                                    Email: operator1@quick.co.id
                                </small>
                                <br>
                                    <small>
                                        Fax: (0274) 563523
                                    </small>
                                    <br>
                    </td>
                    <td colspan="2" style="padding: 5px; text-align: center;">
                        <h5><b>CORRECTIVE ACTION REQUEST (CAR)</b></h5>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">CAR Number
                    </td>
                    <td style="padding: 5px;"><?php echo $head[0]['non_conformity_num']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">CAR Type
                    </td>
                    <td style="padding: 5px;"><input name="CLAIM" type="checkbox" class="form-control"> CLAIM<input name="COMPLAIN" type="checkbox" class="form-control"> COMPLAIN
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px;">NC Scope
                    </td>
                    <td style="padding: 5px;"><input name="Delivery" type="checkbox" class="form-control">&nbsp;Delivery<input name="Quality" type="checkbox" class="form-control">&nbsp;Quality<input name="Quantity" type="checkbox" class="form-control">&nbsp;Quantity<input name="Other" type="checkbox" class="form-control">&nbsp;Other
                    </td>
                </tr>
            </table>
            <h5 style="margin-bottom: 0;">
                <b>
                    Filled by CV. KHS
                </b>
            </h5>
        </div>
        <div class="col-md-12">
        	<hr style="margin-bottom: 5px;">
        	<table class="table" style="font-size:12px;">
        		<?php foreach ($head as $hd) { ?>
	        	<tr><td colspan="4" style="padding-left: 5px;"><h5><b>Requested to</b></h5></td></tr>
    	    	<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Company name</td><td colspan="3">: <?php echo $hd['supplier']; ?></td></tr>
        		<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Company address</td><td colspan="3">: <?php echo $hd['supplier_address']; ?></td></tr>
	        	<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Attendance name</td><td colspan="3">: <?php echo $hd['person_in_charge']; ?></td></tr>
    	    	<tr><td colspan="4"><hr style="margin-bottom: 5px;"></td></tr>
        		<tr><td colspan="4" style="padding-left: 5px;"><h5><b>Description of Complained/Claimed Product</b></h5></td></tr>
        		<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Item name</td><td colspan="3" colspan="3">: <?php $resultstr = array(); foreach ($item as $key => $itemData) { ?>
                    <?php $resultstr[] = $itemData['item_description']; ?>
                <?php } echo implode(", ",$resultstr);?></td></tr>
        		<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Related PO</td><td colspan="3">: <?php $resultstr = array(); foreach ($item as $key => $itemData) { ?>
                    <?php $resultstr[] = $itemData['no_po'].'('.$itemData['line'].')'; ?>
                <?php } echo implode(", ",$resultstr)?></td></tr>
	        	<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Quantity Problem</td><td colspan="3">: <?php $resultstr = array(); foreach ($item as $key => $itemData) { ?>
                    <?php $resultstr[] = $itemData['quantity_problem']; ?>
                <?php } echo implode(", ",$resultstr)?></td></tr>
    	    	<tr><td style="width: 150px; vertical-align:top;padding-left: 5px;">Related form</td><td colspan="3">: <?php echo $hd['packing_list']; ?></td></tr>
	        	<tr><td colspan="4"><hr style="margin-bottom: 5px;"></td></tr>
    	    	<tr><td colspan="4" style="padding-left: 5px;"><h5><b>Description of Fact Finding</b></h5></td></tr>
        		<tr>
        			<td colspan="2" rowspan="4" style="vertical-align:top; padding-left: 5px; padding-right: 5px;">
                        <?php 
                            // $case_description = '';
                            // $description = '';
                            // $remark = '';
                            // if (!$lines[0]['case_description'] == NULL || !$lines[0]['case_description'] == '') {
                            //     $case_description = ', '.$lines[0]['case_description'];
                            // }
                            // if (!$lines[0]['description'] == NULL || !$lines[0]['description'] == '') {
                            //     $description = ', '.$lines[0]['description'];
                            // }
                            // if (!$lines[0]['remark'] == NULL || !$lines[0]['remark'] == '') {
                            //     $remark = ', '.$lines[0]['remark'];
                            // }
                        foreach ($lines as $key => $linesData) {
                            echo $linesData['case_name'].' ,';
                        }echo $lines[0]['description'];
                         ?>
                    </td>
        			<td style="width: 120px; background-color: lightgrey; padding: 3px; border: 1px solid lightgrey;">Approved by,</td>
        			<td style="width: 120px; background-color: lightgrey; padding: 3px; border: 1px solid lightgrey;">Made by,</td>
        		</tr>
	        	<tr><td style="border: 1px solid lightgrey;"><br><br><br><br><br></td><td style="border: 1px solid lightgrey;"></td></tr>
    	    	<tr><td style="padding: 3px; border: 1px solid lightgrey;">M. ARY PAMUJO</td><td style="padding: 3px; border: 1px solid lightgrey;"><?php echo strpbrk($hd['buyer'], ' '); ?></td></tr>
        		<tr><td style="padding: 3px; border: 1px solid lightgrey;">Date: </td><td style="padding: 3px; border: 1px solid lightgrey;">Date: </td></tr>
        		<?php } ?>
        	</table>
        </div>
        <div class="row">
            <h5 style="margin-bottom: 0;"><b>Filled by Vendor</b></h5>
        </div>
        <div class="col-md-12" style="margin-top: 0; padding-top: 0">
        	<hr style="margin-bottom: 5px;">
        	<table class="table" style="font-size:12px;">
        		<tr><td colspan="4"><h5><b>&nbsp;Rootcause Analysis</b></h5></td></tr>
        		<tr><td colspan="4"><br><br><br><br></td></tr>
        		<tr><td colspan="4"><hr style="margin-bottom: 5px;"></td></tr>
        		<tr><td colspan="4"><h5><b>&nbsp;Corrective Action</b></h5></td></tr>
        		<tr><td colspan="4"><br><br><br><br></td></tr>
        		<tr>
        			<td rowspan="4" style="vertical-align: bottom;">Plan start date: </td>
        			<td rowspan="4" style="vertical-align: bottom;">Target Completion Date: </td>
        			<td style="width: 120px; background-color: lightgrey; padding: 3px; border: 1px solid lightgrey;">Approved by,</td>
        			<td style="width: 120px; background-color: lightgrey; padding: 3px; border: 1px solid lightgrey;">Made by,</td>
        		</tr>
	        	<tr><td style="border: 1px solid lightgrey;"><br><br><br><br><br></td><td style="border: 1px solid lightgrey;"></td></tr>
    	    	<tr><td style="padding: 3px; border: 1px solid lightgrey;"><br><br></td><td style="padding: 3px; border: 1px solid lightgrey;"></td></tr>
        		<tr><td style="padding: 3px; border: 1px solid lightgrey;">Date: </td><td style="padding: 3px; border: 1px solid lightgrey;">Date: </td></tr>
        		<tr><td colspan="4"><hr></td></tr>
        	</table>
        </div>
        <div class="row">
            <h5 style="margin-bottom: 0;"><b>Filled by CV. KHS</b></h5>
        </div>
        <div class="col-md-12">
        	<hr style="margin-bottom: 5px;">
        	<table class="table" style="font-size:12px;">
        		<tr><td colspan="4"><h5><b>&nbsp;Verification</b></h5></td></tr>
        		<tr><td colspan="4"><br><br><br><br></td></tr>
        		<tr>
        			<td rowspan="4" colspan="2" style="vertical-align: bottom;">Action effectiveness : <input name="" type="checkbox" class="form-control"> Effective  <input name="" type="checkbox" class="form-control"> Need more improvement</td>
        			<td style="width: 120px; background-color: lightgrey; padding: 3px; border: 1px solid lightgrey;">Approved by,</td>
        			<td style="width: 120px; background-color: lightgrey; padding: 3px; border: 1px solid lightgrey;">Made by,</td>
        		</tr>
	        	<tr><td style="border: 1px solid lightgrey;"><br><br><br><br><br></td><td style="border: 1px solid lightgrey;"></td></tr>
    	    	<tr><td style="padding: 3px; border: 1px solid lightgrey;"><br><br></td><td style="padding: 3px; border: 1px solid lightgrey;"></td></tr>
        		<tr><td style="padding: 3px; border: 1px solid lightgrey;">Date: </td><td style="padding: 3px; border: 1px solid lightgrey;">Date: </td></tr>
        	</table>
        </div>
        <div class="row" style="font-size:12px;">
        	<hr style="margin-bottom: 5px; margin-top: 5px;">
        	Vendor must give their respond maximum 6 days from the date of this CAR
        </div>