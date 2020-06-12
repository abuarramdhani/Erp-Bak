<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&callback=initMap&libraries=&v=weekly" defer></script>
<style type="text/css">
    .panel-body div{
        padding: 0px;
    }
</style>
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
                            <form method="post" action="<?=base_url('PatroliSatpam/web/save_lokasi')?>">
                                    <div class="panel-body">
                                        <div class="col-md-12">                                        
                                            <div class="col-md-6 row">
                                                <div class="col-md-12">
                                                    <div class="col-md-3">
                                                        <label>Nama Lokasi</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input class="form-control" name="lokasi" placeholder="Nama Lokasi">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Latitude</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input id="pts_toSetlat" class="form-control" name="lat" placeholder="Latitude">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Longitude</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input id="pts_toSetlong" class="form-control" name="long" placeholder="Longitude">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="margin-top: 5px;">Pertanyaan</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select class="form-control pts_slcask" name="ask[]" multiple="" style="width: 100%">
                                                            <?php foreach ($ask as $key): ?>
                                                                <option value="<?=$key['id_pertanyaan']?>"><?=$key['pertanyaan']?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12" style="color: red; text-align: center;">
                                                    <label style="">Klik pada Map untuk Mendapatkan koordinat!</label>
                                                </div>
                                                <div id="pts_gMap" class="col-md-12" style="height: 300px">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 50px">
                                            <button class="btn btn-success">
                                                Simpan
                                            </button>
                                            <a class="btn btn-warning" href="<?=base_url('PatroliSatpam/web/slokasi')?>">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </form>
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
            zoom: 17,
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

            google.maps.event.addListener(map, 'click', (function(infowindow) {
                return function() {
                    infowindow.close();
                }
            })(infowindow));

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    var contentString = '<b>'+maker[i]['lokasi']+'</b>';
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        map.addListener('click', function(mapsMouseEvent) {
            // Close the current InfoWindow.
            infoWindow.close();

            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({position: mapsMouseEvent.latLng});
            var html = '<div style="cursor:pointer;" title="click to copy location" class="pts_copylatlong">'+mapsMouseEvent.latLng.toString()+'</div>';
            infoWindow.setContent(html);
            infoWindow.open(map);
            pts_setLatLong(mapsMouseEvent.latLng.toString());
        });
    }
    function pts_setLatLong(coordinate)
    {
        //ex "(123, 123)"
        coordinate = coordinate.replace('(', '');
        coordinate = coordinate.replace(')', '');
        coordinate = coordinate.split(', ');
        if (coordinate.length > 1) {
            $('#pts_toSetlat').val(coordinate[0]);
            $('#pts_toSetlong').val(coordinate[1]);
        }
    }

  exports.initMap = initMap;
})((this.window = this.window || {}));
</script>