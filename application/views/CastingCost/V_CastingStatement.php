
		<div class="row" >			
				<div class="form-group" style="padding-top: 15px " >
				<div style="text-align: right;">
				<p> No. Dokumen: ESTCAST/<?php echo date('ymd').'/'.$data_casting['no_document'] ?></p>
				</div>
				<table style="width: 100%; border:1px solid #333 " >
					<thead>
						<tr style="text-align: center; height: 100px"  >
							<td style="width: 80px;border:1px solid #333; text-align: center;" >  <img style="height: 65px; width: auto;" src="<?php echo base_url('assets/img/logo.png'); ?>"> </td>
							<td style="text-align: center;"><h2><strong>ESTIMASI DATA CASTING</strong></h2></td>
							<td style="border:1px solid #333;text-align: center;height: 80px; width: 100px"> <img style="height: 65px; width: auto;" src="<?php echo base_url('assets/img/up2l.png'); ?>"> </td>
						</tr>	
					</thead>
				</table>
				<table style="width: 100% ;border-right: 1px solid #333; border-left: 1px solid #333;" >
					<thead>
						<tr  style=" height: 25px">
							<td  style="padding-left: 5px"> Nama Komp. </td>
							<td style="padding: 5px ; ">:</td>
							<td style="padding: 5px"> <?php echo $data_casting['description']; ?></td>
							<td style="padding: 5px"> Pemesan : <?php echo $data_casting['orderer']; ?> </td>
						</tr>	
						<tr  style=" height: 25px">
							<td style="padding: 5px"> Kode Part</td>
							<td style="padding: 5px">:</td>
							<td style="padding: 5px">
							<?php if($data_casting['part_number'] != ''){echo $data_casting['part_number'];}  
							else{ echo "-";}
							?>
							</td>
							<td style="padding: 5px"> Tanggal : <?php echo $data_casting['date_template']; ?> </td>
						</tr>
					</thead>
				</table>
				<table border="1px" style="width: 100% ;border: 1px solid #333; height: 100%" >
						<thead>
						<tr style="border:1px solid #333; height: 25px">
							<td width="10px" style="border:1px solid #333; padding: 5px" > No.</td>
							<td style="border:1px solid #333;height: 25px; padding: 5px">Spesifikasi</td>
							<td style="border:1px solid #333; padding: 5px"> Nilai </td>
							<td style="border:1px solid #333; padding: 5px"> Keterangan </td>
						</tr>	
						</thead>
						<tbody>
						<tr style="border:1px solid #333">
							<td style="border:1px solid #333 ; padding: 5px">1</td>
							<td style="border:1px solid #333 ;padding: 5px;">  Material Casting</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['material_casting']; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">2</td>
							<td style="border:1px solid #333 ;padding: 5px"> Berat Casting</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php if($data_casting['casting_weight'] != ''){echo $data_casting['casting_weight'].' Kg';}  
									else{ echo "-";}
							?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">3</td>
							<td style="border:1px solid #333 ;padding: 5px"> Berat Remelt</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['remelt_weight'].' Kg'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">4</td>
							<td style="border:1px solid #333 ;padding: 5px"> Berat Cairan	</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['liquid_weight'].' Kg'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">5</td>
							<td style="border:1px solid #333 ;padding: 5px"> Yield Casting	</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['yield_casting'].' %'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">6</td>
							<td style="border:1px solid #333 ;padding: 5px"> Scrap	</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;">
							 <?php echo $data_casting['scrap_reject'].' %'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">7</td>
							<td style="border:1px solid #333 ;padding: 5px">Basic Tonage</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['basic_tonage'].' Kg/Shift '; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">8</td>
							<td style="border:1px solid #333 ;padding: 5px"> Material Inti</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php if($data_casting['material_core'] != ''){echo $data_casting['material_core'];}  
									else{ echo "-";}
							?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">9</td>
							<td style="border:1px solid #333 ;padding: 5px"> Berat Inti</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php if($data_casting['core_weight'] != ''){echo $data_casting['core_weight'].' Kg';}  
									else{ echo "-";}
							?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">10</td>
							<td style="border:1px solid #333 ;padding: 5px"> Target Pembuatan Inti</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;0"> 
							<?php if($data_casting['target_core'] != ''){echo $data_casting['target_core'].' Pieces/Shift';}  
									else{ echo "-";}
							?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">11</td>
							<td style="border:1px solid #333 ;padding: 5px">Mesin Shelcore</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php if($data_casting['shelcore_machine'] != ''){echo $data_casting['shelcore_machine'];}  
									else{ echo "-";}
							?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">12</td>
							<td style="border:1px solid #333 ;padding: 5px">Mesin Molding</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> <?php echo $data_casting['molding_machine']; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">13</td>
							<td style="border:1px solid #333 ;padding: 5px">Target Cetak/Shift</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['target_mold_pieces'].' Pieces/Shift'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">14</td>
							<td style="border:1px solid #333 ;padding: 5px"> Cavity per Flask</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['cavity'].' cavity'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">15</td>
							<td style="border:1px solid #333 ;padding: 5px">Target Cetak/Shift</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['target_mold_flask'].' Flask/Shift'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">16</td>
							<td style="border:1px solid #333 ;padding: 5px">Berat Pasir Cetak</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['sand_mold_weight'].' Kg'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">17</td>
							<td style="border:1px solid #333 ;padding: 5px">Konsumsi Batu Gerinda / Pcs</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;">
							 <?php echo $data_casting['grindstone'].' Pieces'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">18</td>
							<td style="border:1px solid #333 ;padding: 5px">Target Grinding / Shift</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php echo $data_casting['target_grinding'].' Pieces'; ?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						<tr style="border:1px solid #333 ;padding: 5px">
							<td style="border:1px solid #333 ;padding: 5px">19</td>
							<td style="border:1px solid #333 ;padding: 5px">Waktu Pembuatan Pola</td>
							<td style="border:1px solid #333 ;padding: 5px; text-align: center;"> 
							<?php if($data_casting['time_making'] != ''){echo $data_casting['time_making'].' Jam';}  
									else{ echo "-";}
							?></td>
							<td style="border:1px solid #333 ;padding: 5px"></td>
						</tr>
						</tbody>
				</table>
				<table style="width: 100%; border: 1px solid #333">
					<thead>
						<tr>
							<td style="text-align: center; padding-top: 10px">Ka. Dept. Produksi</td>
							<td style="text-align: center; padding-top: 10px">Ka. Unit UP2L</td>
							<td style="text-align: center; padding-top: 10px">Kasie. Pola</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="height: 60px"></td>
							<td></td>
							<td></td>
						</tr>
					<tr>
						<td style="text-align: center; padding-bottom: 10px"><b>Sugeng Sutanto</b></td>
						<td style="text-align: center; padding-bottom: 10px"><b>Sukardi</b></td>
						<td style="text-align: center; padding-bottom: 10px"><b>Abdul Kafi</b></td>
					</tr>
					</tbody>
				</table>
				
				</div>
			