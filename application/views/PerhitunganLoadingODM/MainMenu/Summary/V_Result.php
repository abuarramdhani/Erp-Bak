<style type="text/css">
	.form-control{
		border-radius: 20px;
	}

    .tbl-content {
    height: 450px;
    width: 100%;
    overflow: auto;
    /* margin-top: 0px;
    border: 1px solid #b5b5b5; */
    }

	.hh {
		text-align: right;
	}

	textarea.form-control{
		border-radius: 10px;
	}
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	.select2-selection{
		border-radius: 20px !important;
	}

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	input.select2-search__field{
		border-radius: 20px !important;
	}

	span.select2-dropdown{
		border-radius: 20px !important;
	}

	.loadOSIMG{
		width: 30px;
		height: auto;
	}
	.btn {
		border-radius: 20px !important;
	}
	
</style>

<!-- <div class="box box-primary box-solid"> -->
    <div class="box-body">
		<div class="table-responsive" >
			<table id="tbl-content" class="table table-striped table-bordered table-responsive table-hover no-footertable text-left" style="font-size: 13px;">
				<thead class="bg-primary">
                    <tr>
                        <th style="text-align: center; vertical-align: middle;">NO.</th>
                        <th style="text-align: center; vertical-align: middle;">RESOURCES</th>
                        <th style="text-align: center; vertical-align: middle;">DESKRIPSI</th>
                        <th style="text-align: center; vertical-align: middle;">KODE</th>
                        <th style="text-align: center; vertical-align: middle;">DESKRIPSI ITEM</th>
                        <th style="text-align: center; vertical-align: middle;">CYCLE TIME</th>
                        <th style="text-align: center; vertical-align: middle;">QTY OP</th>
                        <th style="text-align: center; vertical-align: middle;">TGT/SHIFT</th>
                        <th style="text-align: center; vertical-align: middle;">NEEDS (PCS)</th>
                        <th style="text-align: center; vertical-align: middle;">NEED (SHIFT)</th>
                        <th style="text-align: center; vertical-align: middle;">TOTAL NEED SHIFT</th>
                        <th style="text-align: center; vertical-align: middle;">AVAILABLE OP</th>
                        <th style="text-align: center; vertical-align: middle;">AVAILABLE SHIFT</th>
                        <th style="text-align: center; vertical-align: middle;">LOADING(%)</th>
                        <th style="text-align: center; vertical-align: middle;">NEEDS OP</th>
                    </tr>
				</thead>
                <tbody>                    
                    <?php $no=1; foreach ($dataform as $databr) {?>                    
                    <tr>                        
                    <td style="text-align: center; vertical-align: middle;"><?= $no++; ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="resources[]" value="<?= $databr['RESOURCES'] ?>"><?= $databr['RESOURCES'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="resource_desc[]"value="<?= $databr['RESOURCE_DESC'] ?>"><?= $databr['RESOURCE_DESC'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="item_code[]" value="<?= $databr['ITEM_CODE'] ?>"><?= $databr['ITEM_CODE'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="item_desc[]"value="<?= $databr['ITEM_DESCRIPTION'] ?>"><?= $databr['ITEM_DESCRIPTION'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="cycle_time[]"value="<?= $databr['CYCLE_TIME'] ?>"><?= $databr['CYCLE_TIME'] ?></td>                
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="qty_op[]"value="<?= $databr['QTY_OP'] ?>"><?= $databr['QTY_OP'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="tgt_shift[]"value="<?= $databr['TGT_SHIFT'] ?>"><?= $databr['TGT_SHIFT'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="needs[]" value="<?= $databr['NEEDS'] ?>"><?= $databr['NEEDS'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="need_shift[]" value="<?= $databr['NEEDS_SHIFT'] ?>"><?= $databr['NEEDS_SHIFT'] ?></td>   
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="total_need_shift[]" value="<?= $databr['TOTAL_NEEDS_SHIFT'] ?>"><?= $databr['TOTAL_NEEDS_SHIFT'] ?></td>                     
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="available_op[]" value="<?= $databr['AVAILABLE_OP'] ?>"><?= $databr['AVAILABLE_OP'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="available_shift[]" value="<?= $databr['AVAILABLE_SHIFT'] ?>">
                    <?php 
                    $cek = explode('.', $databr['AVAILABLE_SHIFT']);
                    if(sizeof($cek) == 1){
                        echo $databr['AVAILABLE_SHIFT'];
                    } else {
                        echo number_format((float)$databr['AVAILABLE_SHIFT'], 2, '.', '');
                    }
                    ?>
                    </td>     
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="loading[]" value="<?= $databr['LOADING'] ?>"><?= $databr['LOADING'] ?></td>                        
                    <td style="text-align: center; vertical-align: middle;"><input type="hidden" name="needs_op[]" value="<?= $databr['NEEDS_OP'] ?>"><?= $databr['NEEDS_OP'] ?></td>                   
                    </tr>                    
                    <?php } ?>                
                </tbody>
			</table>
		</div>
</div>