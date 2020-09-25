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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PurchaseManagement/NonConformity');?>">
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
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblPoOracleNonConfirmityHeaders" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="width:20px" class="text-center">No</th>
                                                <th class="text-center">Action</th>
                                                <th style="min-width: 100px" class="text-center">Conformity Number</th>
												<th class="text-center">Creation Date</th>
												<th class="text-center">Po Number</th>
												<th class="text-center">Delivery Date</th>
												<th class="text-center">Packing List</th>
												<th class="text-center">Verificator</th>
												<th class="text-center">Buyer</th>
												<th class="text-center">Supplier</th>
												<th>Case Name</th>
                                                <th>Description</th>
												<th class="text-center">Problem Completion</th>
                                                <th>Last Menu</th>
                                                <th>Last Update</th>
                                                <th>Last Updated By</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            	$no = 1; 
                                            	foreach($PoOracleNonConformityHeaders as $row):
                                            	$encrypted_string = $this->encrypt->encode($row['header_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php echo base_url('PurchaseManagementGudang/NonConformity/readFinishedOrder/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $row['non_conformity_num'] ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($row['creation_date'])) ?></td>
                                                <?php 
                                                    $headerId = $row['header_id'];
                                                    $poNumber = $this->M_nonconformity->detailPOListdata($headerId);
                                                    $case = $this->M_nonconformity->getCs($headerId);
                                                
                                                    if (count($poNumber)==0) {
                                                        echo '<td><span style="color: red"><i class="fa fa-warning"></i>Belum diset</span></td>';
                                                    }else {
                                                       echo'<td>';
                                                        foreach ($poNumber as $key => $poNum) {
                                                            echo $poNum['no_po'].'('. $poNum['line'].')<br>';
                                                        }
                                                        '</td>';
                                                    }
                                                ?>
												<!-- <td><?php foreach ($poNumber as $key => $poNum) { ?>
                                                    <?php echo $poNum['no_po'].'('.$poNum['line'].')<br>' ?>
                                                <?php }?></td> -->
												<td><?php echo $row['delivery_date'] ?></td>
												<td><?php echo $row['packing_list'] ?></td>
												<td><?php echo $row['verificator'] ?></td>
												<td><?php echo strpbrk($row['buyer'], ' ') ?></td>
												<td><?php echo $row['supplier'] ?></td>
												<td><?php $no1 = 0; foreach ($case as $key => $cs) {$no1++;
                                                    
                                                    echo $no1.'. '.$cs['case_name'].'<br>';
                                                }?></td>
                                                <td><?php $headerId = $row['header_id']; 
                                                $des = $this->M_nonconformity->getDesc($headerId); 
                                                foreach ($des as $key => $desc) {
                                                    echo $desc['description'];
                                                }?></td>
                                                <td><?php echo $row['problem_completion'] ?></td>
                                                <td><?php echo $row['last_menu'] ?></td>
                                                <td><?php echo $row['last_update_date'] ?></td>
                                                <td><?php echo $row['last_updated_by'] ?></td>
											</tr>
                                            <?php endforeach; ?>
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