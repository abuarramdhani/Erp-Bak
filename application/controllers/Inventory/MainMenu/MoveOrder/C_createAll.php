<?php
		$nama_satu = '';
		$nama_dua = '';
		$ip_address =  $this->input->ip_address();
		$no_job 	= $this->input->post('no_job');
		$qty 	  = $this->input->post('qty');
		$invID 		  = $this->input->post('invID');
		$uom 		  = $this->input->post('uom');
		$job_id 	  = $this->input->post('job_id');
		$subinv_to 	  = $this->input->post('subinvto');
		$locator_to 	  = $this->input->post('locatorto');
		$subinv_from 	  = $this->input->post('subinvfrom');
		$locator_from 	  = $this->input->post('locatorfrom');
		$selected = $this->input->post('selectedPicklistIMO');
		$arraySelected = explode('+', $selected);
		$array_mo = array();

		foreach ($no_job as $key => $value) {
			if (strpos($value, '<>') !== false ) {
				$no_job2		= explode('<>', $no_job[$key]);
				$qty2			= explode('<>', $qty[$key]);
				$invID2			= explode('<>', $invID[$key]);
				$uom2			= explode('<>', $uom[$key]);
				$job_id2		= explode('<>', $job_id[$key]);
				$subinv_to2		= explode('<>', $subinv_to[$key]);
				$locator_to2	= explode('<>', $locator_to[$key]);
				$subinv_from2	= explode('<>', $subinv_from[$key]);
				$locator_from2	= explode('<>', $locator_from[$key]);
				$i =1;
				if (in_array($no_job2[0], $arraySelected)){
					$checkPicklist = $this->M_MoveOrder->checkPicklist($no_job2[0]);
					if (count($checkPicklist) > 0) {
						foreach ($checkPicklist as $keymo => $valuemo) {
							$no_mo = $valuemo['REQUEST_NUMBER'];
							array_push($array_mo, $no_mo);
						}
					} else {
						$data = array();
						//CHECK QTY VS ATR
						$getQuantityActual = $this->M_MoveOrder->getQuantityActual($no_job2[0]);
						$errQty = array();
						foreach ($getQuantityActual as $kQty => $vQty) {
							if ($vQty['REQ'] > $vQty['ATR']){
								$err = 1;
							}else{
								$err = 0;
							}
							$errQty[] = $err;
						}

						if (in_array(1, $errQty)) {
							// START
								foreach ($no_job2 as $k => $v) {
									$data[$subinv_from2[$k]][] = array('NO_URUT' => '',
													'INVENTORY_ITEM_ID' => $invID2[$k],
													'QUANTITY' => $qty2[$k],
													'UOM' => $uom2[$k],
													'IP_ADDRESS' => $ip_address,
													'JOB_ID' => $job_id2[$k]);
									$data2[$subinv_from2[$k]] = $locator_from2[$k];

								}
								
								foreach ($data as $kSub => $vSub) {
									$i = 1; 
									foreach ($vSub as $key2 => $value2) {
										$dataNew = $value2;
										$dataNew['NO_URUT'] = $i;
										//create TEMP
										$this->M_MoveOrder->createTemp($dataNew);
										$i++;
									}
										//create MO         
										$this->M_MoveOrder->createMO($ip_address,$job_id2[0],$subinv_to2[0],$locator_to2[0],$kSub,$data2[$kSub]);


										//delete
										$this->M_MoveOrder->deleteTemp($ip_address,$job_id2[0]);
								}
							// END

								$checkPicklist = $this->M_MoveOrder->checkPicklist($job_id2[0]);
								foreach ($checkPicklist as $keymo => $valuemo) {
									$no_mo = $valuemo['REQUEST_NUMBER'];
									array_push($array_mo, $no_mo);
								}
							}
						}
					}
			}else{
				if (in_array($value, $arraySelected)){
					$checkPicklist = $this->M_MoveOrder->checkPicklist($value);
					if (count($checkPicklist) > 0) {
						foreach ($checkPicklist as $keymo => $valuemo) {
							$no_mo = $valuemo['REQUEST_NUMBER'];
							array_push($array_mo, $no_mo);
						}
					} else {
						//CHECK QTY VS ATR
						$getQuantityActual = $this->M_MoveOrder->getQuantityActual($value);
						$errQty = array();
						foreach ($getQuantityActual as $kQty => $vQty) {
							if ($vQty['REQ'] > $vQty['ATR']){
								$err = 1;
							}else{
								$err = 0;
							}
							$errQty[] = $err;
						}

						if (!in_array(1, $errQty)) {
							$data = array('NO_URUT' => 1,
									'INVENTORY_ITEM_ID' => $invID[$key],
									'QUANTITY' => $qty[$key],
									'UOM' => $uom[$key],
									'IP_ADDRESS' => $ip_address,
									'JOB_ID' => $job_id[$key]);
							// $data2[$subinv_from2[$k]] = $locator_from2[$k];
							//create TEMP


							$this->M_MoveOrder->createTemp($data);

							//create MO
							$this->M_MoveOrder->createMO($ip_address,$job_id[$key],$subinv_to[$key],$locator_to[$key],$subinv_from[$key],$locator_from[$key]);

							//delete
							$this->M_MoveOrder->deleteTemp($ip_address,$job_id[$key]);

							$checkPicklist = $this->M_MoveOrder->checkPicklist($value);
							foreach ($checkPicklist as $keymo => $valuemo) {
								$no_mo = $valuemo['REQUEST_NUMBER'];
								array_push($array_mo, $no_mo);
							}
						}
					}
				}
			}
		}

		

		if ($array_mo) {
			$this->pdf($array_mo,$nama_satu,$nama_dua);
		}else{
			exit('Terjadi Kesalahan :(');
		}


	}
?>