<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&callback=initMap&libraries=&v=weekly" defer></script>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                        <a class="btn btn-success" href="<?= base_url('PatroliSatpam/web/add_lokasi') ?>">
                                            <i class="fa fa-plus"></i>
                                            Tambah
                                        </a>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 50px;overflow-x:scroll">
                                        <table class="table table-hover table-striped table-bordered pts_tblask">
                                            <thead class="bg-primary">
                                                <th style="text-align: center;">No</th>
                                                <th style="text-align: center;">Pos</th>
                                                <th style="text-align: center;">Lokasi</th>
                                                <th style="text-align: center;">Latitude</th>
                                                <th style="text-align: center;">Longitude</th>
                                                <th style="text-align: center;">Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $x=1; foreach ($lokasi as $key): ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $x ?></td>
                                                    <td style="text-align: center;"><?= $key['id'] ?></td>
                                                    <td ><?= $key['lokasi'] ?></td>
                                                    <td style="text-align: center;"><?= $key['latitude'] ?></td>
                                                    <td style="text-align: center;"><?= $key['longitude'] ?></td>
                                                    <td style="text-align: center;">
                                                        <input id="what" hidden="" value="<?=$key['list_pertanyaan']?>">
                                                        <a href="<?= base_url('PatroliSatpam/web/cetak_qr_patroli?id='.$key['id']) ?>" class="btn btn-info" target="_blank">
                                                            <i class="fa fa-qrcode"></i>
                                                        </a>
                                                        <button value="<?=$key['id']?>" class="btn btn-primary pts_btn_edlokasi" title="Edit" data-toggle="modal" data-target="#pts_mdl_editlokasi">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button value="<?=$key['id']?>" class="btn btn-danger pts_btn_todelok">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $x++; endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="pts_gMap" class="col-md-12 text-center" style="height: 500px; border: 1px solid black;">
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<div class="modal fade" id="pts_mdl_editlokasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('PatroliSatpam/web/update_lokasi'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Edit Lokasi</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Lokasi</label>
                    <input class="form-control" name="lokasi">
                    <div class="col-md-5" style="padding: 0px;">
                        <label>Latitude</label>
                        <input id="pts_mdl_lat" class="form-control" name="lat">
                    </div>
                    <div class="col-md-1">
                        
                    </div>
                    <div class="col-md-6" style="padding: 0px;">
                        <label>Longitude</label>
                        <input id="pts_mdl_long" class="form-control" name="long">
                    </div>
                    <label>Pertanyaan</label>
                    <br>
                    <select class="form-control pts_slcask" name="pertanyaan[]" multiple="" style="width: 100%">
                        <?php foreach ($ask as $key): ?>
                            <option value="<?=$key['id_pertanyaan']?>"><?=$key['pertanyaan']?></option>
                        <?php endforeach ?>
                    </select>
                    <div style="width: 100%; text-align: center; color: red">
                        <label style="">Klik pada Map untuk Mendapatkan koordinat!</label>
                    </div>
                    <div style="height: 300px;" id="pts_gMap_modal">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="pts_lokid" name="id" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
  (function(exports) {
    "use strict";
    var map, marker;
    var lmaker = <?=$lokasi_json?>;
    console.log(lmaker);


    function initMap() {
        map = new google.maps.Map(document.getElementById("pts_gMap"), {
            center: {
                lat: -7.775280,
                lng: 110.362571
            },
            zoom: 18,
            mapTypeId: 'satellite'
        });

        setMaker(lmaker);
    }

    function setMaker(maker)
    {
        var infowindow = new google.maps.InfoWindow();
        var infoWindow = new google.maps.InfoWindow();
        var i;
        for(i = 0; i < maker.length; i++) {
            var obj = maker[i];
            var myLatLng = {lat: parseFloat(obj.latitude), lng: parseFloat(obj.longitude)};

            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                label: obj.id,
                title: obj.lokasi
            });

            // google.maps.event.addListener(map, 'click', (function(infowindow) {
            //     return function() {
            //         infowindow.close();
            //     }
            // })(infowindow));

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    var contentString = '<b>'+maker[i]['lokasi']+'</b>';
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }

  exports.initMap = initMap;
})((this.window = this.window || {}));
</script>
