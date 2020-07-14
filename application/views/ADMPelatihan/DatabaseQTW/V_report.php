<style>
    .ui-datepicker-calendar{
        display: none;
    }
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11 text-right"><h1>Report Kalender QTW</h1></div>
                <div class="col-lg-1" style="margin-top: 10px;"><span class="fa fa-3x fa-calendar"></span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-2">
                                    <label for=""><span class="fa fa-check-square-o"></span>&emsp;Jenis Report:</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="radio" name="radioReport_qtw" class="radioReport_qtw" value="1">&emsp;Tahunan<br><br>
                                    <input type="radio" name="radioReport_qtw" class="radioReport_qtw" value="2" checked>&emsp;Bulanan
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-2">
                                    <label for=""><span class="fa fa-calendar"></span>&emsp;Range:</label>
                                </div>
                                <div class="col-lg-3 hide hiddenTahun_rangeQtw">
                                    <input type="text" class="form-control forDatePickerThn_qtw">
                                    <p style="color: red;">*) Kosongkan untuk menampilkan semua data</p>
                                </div>
                                <div class="col-lg-5 hiddenRange_qtw" style="margin-left: -15px">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control forDatePicker_qtw" id="getValueStart_rangeQtw">
                                    </div>
                                    <p class="col-lg-1 text-center" style="margin-left: -10px; margin-top: 5px;">s/d</p>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control forDatePicker_qtw" id="getValueEnd_rangeQtw">
                                    </div>
                                    <div class="col-lg-12"><p style="color: red;">*) Kosongkan untuk menampilkan semua data</p></div>
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-primary" onclick="show_report_qtw(1)"><span class="fa fa-search">&nbsp;Show Data</span></button>
                                </div>
                                <div class="col-lg-1" style="margin-left: 10px;">
                                    <button class="btn btn-danger" onclick="show_report_qtw(2)"><span class="fa fa-file-pdf-o">&nbsp;Export PDF</span></button>
                                </div>
                                <div class="col-lg-1" style="margin-left: 10px;">
                                    <button class="btn btn-success" onclick="show_report_qtw(3)"><span class="fa fa-file-excel-o">&nbsp;Export Excel</span></button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row hide" id="munculSetelahGenerate">
                            <div class="col-lg-12">
                                <div class="box">
                                    <div class="box-header with-border"><h5><span class="fa fa-file-text-o"></span>&emsp;PREVIEW DATA</h5></div>
                                    <div class="box-body" id="loading">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>