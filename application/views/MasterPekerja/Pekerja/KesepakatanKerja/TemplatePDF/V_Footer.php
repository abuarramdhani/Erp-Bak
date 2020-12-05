<footer>
  <div class="col-12 text-center">
    <span>{PAGENO}/{nb}</span>
  </div>
  <div class="col-12">
    <div class="col-6">
      <small style="font-size: 9px; font-style: italic;"><?= @ucwords(strtolower($worker->nama)) . " " . $worker->noind ?></small><br>
      <small style="font-size: 9px; font-style: italic;"><?= @ucwords(strtolower($worker->seksi)) . " - " . $orientasi_type ?></small><br>
      <small style="font-size: 9px; font-style: italic;"><?= @$loker_name ?></small><br>
    </div>
    <div class="col-6">
      <!-- <div style="border: 1px solid black; float: right; width: 150px;">
          <div class="col-12">
            <div class="col-6">1</div>
            <div class="col-6" style="border-left: 1px solid black;">2</div>
          </div>
        </div> -->
      <div style="width: 150px; float: right;">
        <table border=" 1" style="width: 100%;">
          <tr>
            <td class="text-center text-bottom" style="height: 35px;">
              <span style="font-size: 10px;">PIHAK 1</span>
            </td>
            <td class="text-center text-bottom">
              <span style="font-size: 10px;">PIHAK 2</span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</footer>