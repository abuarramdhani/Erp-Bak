<?php $x=1; foreach ($list as $key): ?>
	<label><?=$x.'. '.$key['pertanyaan'];  ?></label>
	<br>
	<select class="form-control pts_slcajz" name="jawaban[]" style="width: 300px;">
		<option <?=($key['jawaban'] == '1') ? 'selected':'' ?> value="1">Ya</option>
		<option <?=($key['jawaban'] == '0') ? 'selected':'' ?> value="0">Tidak</option>
	</select>
	<input hidden="" name="id_pertanyaan[]" value="<?=$key['id_pertanyaan']?>">
	<br>
<?php $x++; endforeach ?>