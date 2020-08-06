<form method="post" id="pts_frmrute" target="_blank" action="<?= base_url('PatroliSatpam/web/export_rekap_data'); ?>">
    <div id="pts_gMap" class="col-md-12 text-center" style="height: 500px; border: 1px solid black;">
    </div>
    <input name="poto" id="frm_cvmap" hidden="">
    <input name="pr" id="frm_idpr" hidden="" value="<?= $pr ?>">
    <button hidden="" id="pts_frm_btnsm" type="submit"></button>
</form>
<div class="col-md-12">
    <label>Keterangan :</label>
</div>
<div class="col-md-2">
    <div style="width: 20px;height: 20px; background-color: #fc0303; float: left"></div>
    <label style="margin-left: 5px;">Ronde 1</label>
</div>
<div class="col-md-2">
    <div style="width: 20px;height: 20px; background-color: #f4fc03; float: left"></div>
    <label style="margin-left: 5px;">Ronde 2</label>
</div>
<div class="col-md-2">
    <div style="width: 20px;height: 20px; background-color: #03fc24; float: left"></div>
    <label style="margin-left: 5px;">Ronde 3</label>
</div>
<div class="col-md-2">
    <div style="width: 20px;height: 20px; background-color: #0320fc; float: left"></div>
    <label style="margin-left: 5px;">Ronde 4</label>
</div>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&callback=initMap&libraries=&v=weekly" defer></script>
<script>
  (function(exports) {
    // "use strict";
    var map, marker;
    var lmaker = <?=$pos?>;
    var lrute = <?=$rute?>;
    // console.log(lmaker);

    function initMap() {
        map = new google.maps.Map(document.getElementById("pts_gMap"), {
            center: {
                lat: -7.775280,
                lng: 110.362571
            },
            zoom: 18,
            mapTypeId: 'satellite'
        });

        setPoly(lrute);
        setMaker(lmaker);
    }

    function setPoly(rute)
    {
        var color = ['#fc0303','#f4fc03','#03fc24', '#0320fc'];
        var tebal = [11,8,5,2]
        for(i of rute.indek){
            var coord = [];
            for(j of rute[i]){
                var arr = j.split(',')
                coord.push({lat: parseFloat(arr[0]), lng: parseFloat(arr[1])})
            }
            var flightPath = new google.maps.Polyline({
                path: coord,
                geodesic: true,
                strokeColor: color[i-1],
                strokeOpacity: 1.0,
                strokeWeight: tebal[i-1]
              });

              flightPath.setMap(map);
        }
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