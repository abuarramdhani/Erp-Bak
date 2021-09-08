<br>
<div class="table-responsive">
  <table class="table table-bordered tbl-agt-timer-andon text-center" style="width:100%">
    <thead>
      <tr class="bg-primary">
        <td style="width:5%;vertical-align:middle">No</td>
        <td style="width:20%;vertical-align:middle">Hari</td>
        <td style="width:35%;vertical-align:middle">Start Time</td>
        <td style="width:35%;vertical-align:middle">Stop Time</td>
        <td> <button class="btn btn-default btn-sm" onclick="btnPlusTimerAndon()"><i class="fa fa-plus"></i></button> </td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value){ ?>
        <tr>
          <td><?php echo $key + 1 ?></td>
          <td>
            <select class="s_andon andon_hari" name="" style="width:120px">
              <option value="MonThu" <?php echo $value['HAR'] == 'MonThu' ? 'selected' : '' ?>>Senin-Kamis</option>
              <option value="Fri" <?php echo $value['HAR'] == 'Fri' ? 'selected' : '' ?>>Jum'at</option>
              <option value="Sat" <?php echo $value['HAR'] == 'Sat' ? 'selected' : '' ?>>Sabtu</option>
            </select>
          </td>
          <td>
            <center>
            <div style="display:flex;width:80%">
                <select class="s_andon start_andon_jam" name="" style="width:30%">
                  <?php
                    for ($i=1; $i <= 12; $i++) {
                      $jam_ = strlen($i) == 1 ? '0'.$i : $i;
                      $selected = explode(':', $value['TIME_START'])[0] == $jam_ ? 'selected' : '';
                      echo '<option value="'.$jam_.'" '.$selected.'>'.$jam_.'</option>';
                    }
                  ?>
                </select>
                <select class="s_andon start_andon_menit" name="" style="width:30%">
                  <?php
                    for ($i=0; $i <= 59; $i++) {
                      $menit_ = strlen($i) == 1 ? '0'.$i : $i;
                      $selected = explode(':', $value['TIME_START'])[1] == $menit_ ? 'selected' : '';
                      echo '<option value="'.$menit_.'" '.$selected.'>'.$menit_.'</option>';
                    }
                  ?>
                </select>
                <select class="s_andon start_andon_am_pm" name="" style="width:30%">
                  <option value="AM" <?php echo explode(' ', $value['TIME_START'])[1] == 'AM' ? 'selected' : '' ?>>AM</option>
                  <option value="PM" <?php echo explode(' ', $value['TIME_START'])[1] == 'PM' ? 'selected' : '' ?>>PM</option>
                </select>
            </div>
           </center>
          </td>
          <td>
            <center>
            <div style="display:flex;width:80%">
                <select class="s_andon stop_andon_jam" name="" style="width:30%">
                  <?php
                    for ($i=1; $i <= 12; $i++) {
                      $jam_ = strlen($i) == 1 ? '0'.$i : $i;
                      $selected = explode(':', $value['TIME_STOP'])[0] == $jam_ ? 'selected' : '';
                      echo '<option value="'.$jam_.'" '.$selected.'>'.$jam_.'</option>';
                    }
                  ?>
                </select>
                <select class="s_andon stop_andon_menit" name="" style="width:30%">
                  <?php
                    for ($i=0; $i <= 59; $i++) {
                      $menit_ = strlen($i) == 1 ? '0'.$i : $i;
                      $selected = explode(':', $value['TIME_STOP'])[1] == $menit_ ? 'selected' : '';
                      echo '<option value="'.$menit_.'" '.$selected.'>'.$menit_.'</option>';
                    }
                  ?>
                </select>
                <select class="s_andon stop_andon_am_pm" name="" style="width:30%">
                  <option value="AM" <?php echo explode(' ', $value['TIME_STOP'])[1] == 'AM' ? 'selected' : '' ?>>AM</option>
                  <option value="PM" <?php echo explode(' ', $value['TIME_STOP'])[1] == 'PM' ? 'selected' : '' ?>>PM</option>
                </select>
            </div>
          </center>
          </td>
          <td>
            <button class="btn btn-default btn-sm" onclick="btnMinTimerAndon(this)">
              <i class="fa fa-minus"></i>
            </button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<center>
  <button type="button" class="btn btn-primary text-bold mb-4" name="button" onclick="andon_save_timer()"> <i class="fa fa-save"></i> Simpan Perubahan</button>
</center>

<script type="text/javascript">
  // let d = new Date();
  //
  // let hour = d.getHours();
  // let minute = d.getMinutes();
  //
  // let now = hour+':'+minute;
function master_timer_andon(no) {
  return  `<tr>
            <td>${no}</td>
            <td>
              <select class="s_andon andon_hari" name="" style="width:120px">
                <option value="MonThu">Senin-Kamis</option>
                <option value="Fri">Jum'at</option>
                <option value="Sat">Sabtu</option>
              </select>
            </td>
            <td>
              <center>
              <div style="display:flex;width:80%">
                  <select class="s_andon start_andon_jam" name="" style="width:30%">
                    <option value="01" selected>01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                  <select class="s_andon start_andon_menit" name="" style="width:30%">
                    <option value="00" selected="selected">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                  </select>
                  <select class="s_andon start_andon_am_pm" name="" style="width:30%">
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                  </select>
              </div>
             </center>
            </td>
            <td>
              <center>
              <div style="display:flex;width:80%">
                <select class="s_andon stop_andon_jam" name="" style="width:30%">
                  <option value="01" selected>01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
                <select class="s_andon stop_andon_menit" name="" style="width:30%">
                  <option value="00" selected="selected">00</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                  <option value="32">32</option>
                  <option value="33">33</option>
                  <option value="34">34</option>
                  <option value="35">35</option>
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
                  <option value="43">43</option>
                  <option value="44">44</option>
                  <option value="45">45</option>
                  <option value="46">46</option>
                  <option value="47">47</option>
                  <option value="48">48</option>
                  <option value="49">49</option>
                  <option value="50">50</option>
                  <option value="51">51</option>
                  <option value="52">52</option>
                  <option value="53">53</option>
                  <option value="54">54</option>
                  <option value="55">55</option>
                  <option value="56">56</option>
                  <option value="57">57</option>
                  <option value="58">58</option>
                  <option value="59">59</option>
                </select>
                <select class="s_andon stop_andon_am_pm" name="" style="width:30%">
                  <option value="AM">AM</option>
                  <option value="PM">PM</option>
                </select>
              </div>
            </center>
            </td>
            <td>
              <button class="btn btn-default btn-sm" onclick="btnMinTimerAndon(this)">
                <i class="fa fa-minus"></i>
              </button>
            </td>
          </tr>`;
}

$('.tbl-agt-timer-andon').DataTable({
  ordering:false
});

$('.s_andon').select2();

function btnPlusTimerAndon() {
  let no = Number($('.tbl-agt-timer-andon tbody tr').length) + 1;
  $('.tbl-agt-timer-andon tbody').append(master_timer_andon(no));
  $('.s_andon').select2();
}

function btnMinTimerAndon(th) {
  let this_elem = $(th).parent().parent().remove();
  $('.tbl-agt-timer-andon tbody tr').each((index,value) => {
    $(value).find('td:first').text(Number(index) + 1);
  })
}

function andon_save_timer() {
  let tampung = [];

  let stop_andon_menit = $('.stop_andon_menit').map((_, el) => el.value).get();
  let stop_andon_am_pm = $('.stop_andon_am_pm').map((_, el) => el.value).get();

  let start_andon_jam = $('.start_andon_jam').map((_, el) => el.value).get();
  let start_andon_menit = $('.start_andon_menit').map((_, el) => el.value).get();
  let start_andon_am_pm = $('.start_andon_am_pm').map((_, el) => el.value).get();

  let hari_andon = $('.andon_hari').map((i, el) => el.value).get();
  $('.stop_andon_jam').each((i,v)=>{
    let stop_jam = $(v).val();
    tampung.push({
      hari : hari_andon[i],
      stop_time : `${stop_jam}:${stop_andon_menit[i]}:00 ${stop_andon_am_pm[i]}`,
      start_time : `${start_andon_jam[i]}:${start_andon_menit[i]}:00 ${start_andon_am_pm[i]}`
    })
  })
  console.log(tampung);

 $.ajax({
   url: baseurl + 'CompletionAssemblyGearTrans/action/save_timer',
   type: 'POST',
   dataType: 'JSON',
   data: {
     data_timer: tampung,
   },
   cache:false,
   beforeSend: function() {
     swalAGTLoading('Sedang menyimpan data');
   },
   success: function(result) {
     if (result == 1) {
       swalAGT('success', 'Berhasil memperbarui data');
     }else {
       swalAGT('warning', 'Gagal memperbarui data, harap coba lagi');
     }
   },
   error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan...');
    console.error();
   }
 })
}

</script>
