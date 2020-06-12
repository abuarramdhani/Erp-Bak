<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw&callback=initMap&libraries=&v=weekly" defer></script>
<div class="col-md-12" style="height: 100%" id="pts_gMap2">
    
</div>
<script>
  (function(exports) {
    "use strict";
    var map, marker;
    var lmaker = <?=$lokasi_json?>;
    var id = <?=$id?>;
    console.log(lmaker);


    function initMap() {
        map = new google.maps.Map(document.getElementById("pts_gMap2"), {
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
        var i, icon;
        for(i = 0; i < maker.length; i++) {
            var obj = maker[i];
            var myLatLng = {lat: parseFloat(obj.latitude), lng: parseFloat(obj.longitude)};
            if (obj.id == id) {
                icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
            }else{
                icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
            }

            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: icon,
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
            $('#pts_mdl_lat').val(coordinate[0]);
            $('#pts_mdl_long').val(coordinate[1]);
        }
    }

  exports.initMap = initMap;
})((this.window = this.window || {}));
</script>
