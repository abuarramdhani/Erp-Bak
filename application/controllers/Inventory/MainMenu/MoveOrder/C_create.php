<?php
$ip_address =  $this->input->ip_address();
		$job = $this->input->post('no_job');
		$err = $this->input->post('error_exist');
		
		$departement = $this->input->post('departement');
		if ($departement == 'SUBKT') {
			$nama_satu = $this->input->post('namaSatu');
			$nama_dua = $this->input->post('namaDua');
		} else {
			$nama_satu = '';
			$nama_dua = '';
		}

		$checkPicklist = $this->M_MoveOrder->checkPicklist($job);
		$array_mo = array();

		if (count($checkPicklist) > 0) {
			foreach ($checkPicklist as $key => $value) {
				$no_mo = $value['REQUEST_NUMBER'];
				array_push($array_mo, $no_mo);
				//tinggal cetak jika sudah ada mo
			}
		// 	//pdfoutput
			$this->pdf($array_mo, $nama_satu, $nama_dua);
		} else {
			$qty 	  = $this->input->post('qty');
			$invID = $this->input->post('invID');
			$uom 		  = $this->input->post('uom');
			$job_id 	  = $this->input->post('job_id');
			$subinv_to 	  = $this->input->post('subinvto');
			$locator_to 	  = $this->input->post('locatorto');
			$subinv_from 	  = $this->input->post('subinvfrom');
			$locator_from 	  = $this->input->post('locatorfrom');



			//CHECK QTY VS ATR
			$getQuantityActual = $this->M_MoveOrder->getQuantityActual($job);
			
			$errQty = array();

			foreach ($getQuantityActual as $kQty => $vQty) {
				if ($vQty['REQ'] > $vQty['ATR']){
					$err = 1;
				}else{
					$err = 0;
				}
				$errQty[] = $err;
			}
			
			//Seharusnya (!in_array(1,$errQty))
			if (!in_array(1, $errQty)) {
					foreach ($invID as $key => $value) {
						$data[$subinv_from[$key]][] = array('NO_URUT' => '',
										'INVENTORY_ITEM_ID' => $value,
										'QUANTITY' => $qty[$key],
										'UOM' => $uom[$key],
										'IP_ADDRESS' => $ip_address,
										'JOB_ID' => $job_id[$key]);
						$data2[$subinv_from[$key]] = $locator_from[$key];

					}
					
					
					foreach ($data as $key => $value) {
						$i = 1; 
						// echo "PROSES SUB INV $key { ";
						foreach ($value as $key2 => $value2) {
							$dataNew = $value2;
							$dataNew['NO_URUT'] = $i;
							//create TEMP
							$this->M_MoveOrder->createTemp($dataNew);
							$i++;

						}
							//create MO         
							$this->M_MoveOrder->createMO($ip_address,$job_id[0],$subinv_to[0],$locator_to[0],$key,$data2[$key]);

							//delete
							$this->M_MoveOrder->deleteTemp($ip_address,$job_id[0]);
					}

					$checkPicklist = $this->M_MoveOrder->checkPicklist($job);
					foreach ($checkPicklist as $key => $value) {
						$no_mo = $value['REQUEST_NUMBER'];
						array_push($array_mo, $no_mo);
					}
			}
			
			if ($array_mo) {
				$this->pdf($array_mo, $nama_satu, $nama_dua);
			}else{
				exit('Terjadi Kesalahan :(');
			}

		
		}
	}
?>