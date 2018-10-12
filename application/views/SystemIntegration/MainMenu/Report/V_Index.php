<style>
* {box-sizing: border-box}
/*body {font-family: "Lato", sans-serif;}*/

/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 15%;
    height: 350px;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 10px 8px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 85%;
    border-left: none;
    height: 350px;
}
</style>

<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-bar-chart"></i> Grafik Kaizen</h3>
    </div>
    <div class="box-body">
      <h3>Grafik Kaizen Seksi : <b><?= $seksi ?></b> </h3>

      <div class="tab">
        <button class="tablinks active"  onclick="openTabSI(this,'seksi')" id="defaultOpen">Seksi</button>
        <button class="tablinks" onclick="openTabSI(this,'pekerja')">Pekerja</button>
      </div>

      <div id="seksi" class="tabcontent" style="display: block; padding: 5px">
        <div style="overflow: auto; height: 100%">
          <?php $widthuwu = 0; foreach ($data_seksi as $key => $value) {
            $widthuwu += 160;
          } ?>
          <div id="chartContainer" style="height: 300px; width: <?= $widthuwu ?>px"></div>
        </div>
      </div>

      <div id="pekerja" class="tabcontent" style="display: none">
        <h3>Per Pekerja</h3>
        <p>Untuk data kaizen per pekerja bisa dilihat di tab seksi.</p> 
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>

</section>