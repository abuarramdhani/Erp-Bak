<div class="table-responsive">
        <table class="table table-stripped table-hovered text-center" style="width:100%">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Jenis Kemasan</td>
                    <td>Berat (KG)</td>
                </tr>
            </thead>
            <tbody id="tambahbrt">
                <?php $no = 1; foreach ($data as $key => $val) { 
				if ($val['kode_packing'] == 1) {
					$kemasan = 'KARDUS KECIL';
				}elseif ($val['kode_packing'] == 2) {
					$kemasan = 'KARDUS SEDANG';
				}elseif ($val['kode_packing'] == 3) {
					$kemasan = 'KARDUS PANJANG';
				}elseif ($val['kode_packing'] == 4) {
					$kemasan = 'KARUNG';
				}elseif ($val['kode_packing'] == 5) {
					$kemasan = 'PETI';
				}?>
                    <tr>
							<td><?= $no?>
								<input type="hidden" id="no_spb<?= $no?>" value="<?= $nospb?>">
							</td>
							<td><select class="form-control select2" id="jenis_kemasan<?= $no?>" name="jenis_kemasan" style="width:100%" data-placeholder="pilih kemasan" onchange="gantikemasan(<?= $no?>)">
								<option value="<?= $val['kode_packing']?>"><?= $kemasan?></option>
								<option value="1">KARDUS KECIL</option>
								<option value="2">KARDUS SEDANG</option>
								<option value="3">KARDUS PANJANG</option>
								<option value="4">KARUNG</option>
								<option value="5">PETI</option>
								</select>
							</td>
							<td><input type="text" class="form-control" id="berat<?= $no?>" name="berat" value="<?= $val['berat']?>" onchange="gantikemasan(<?= $no?>)"></td>
						</tr>
                <?php $no++; }?>
                <tr>
					<td><?= $no?>
						<input type="hidden" id="no_spb<?= $no?>" value="<?= $nospb?>">
					</td>
					<td><select class="form-control select2" id="jenis_kemasan<?= $no?>" name="jenis_kemasan" style="width:100%" data-placeholder="pilih kemasan">
						<option></option>
						<option value="1">KARDUS KECIL</option>
						<option value="2">KARDUS SEDANG</option>
						<option value="3">KARDUS PANJANG</option>
						<option value="4">KARUNG</option>
						<option value="5">PETI</option>
						</select>
					</td>
					<td><input type="text" class="form-control" id="berat<?= $no?>" name="berat" placeholder="masukkan berat (KG)" onchange="saveBeratPack(<?= $no?>)"></td>
				</tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="jenis" value="<?= $jenis?>">
    <input type="hidden" id="no_spb" value="<?= $nospb?>">
    <input type="hidden" id="no" value="<?= $nomor?>">
	<?php if ($ket == 'packing') { ?>
		<input type="hidden" id="date" value="<?= $date?>">
		<input type="hidden" id="mulai" value="<?= $mulai?>">
		<input type="hidden" id="selesai" value="<?= $selesai?>">
		<input type="hidden" id="pic" value="<?= $pic?>">
	<?php }?>