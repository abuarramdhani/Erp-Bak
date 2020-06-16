<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw -->
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #legend {
        font-family: Arial, sans-serif;
        background: #fff;
        padding: 10px;
        margin: 10px;
        border: 3px solid #000;
      }
      #legend h3 {
        margin-top: 0;
      }
      #legend img {
        vertical-align: middle;
      }
    </style>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw0IlgLwNcUk4v1Zl0HkB9NCY70jEy6uw">
    </script>
    <script>
      var overlay;
      var overlays = [];
      USGSOverlay.prototype = new google.maps.OverlayView();
      var map;
      function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: {lat: -7.333465, lng: 109.790425},
        mapTypeId: 'satellite',
        style: [
          {
            "elementType": "labels",
            "styler": [
              {
                visibility: "off"
              }
            ]
          }
        ]
          });

          var icons = {
            himu: {
              name: '0-10',
              color: '#2ecc71'
            },
            hitu: {
              name: '11-20',
              color: '#27ae60'
            },
            kuni: {
              name: '21-30',
              color: '#f1c40f'
            },
            oran: {
              name: '31-40',
              color: '#f39c12'
            },
            memu: {
              name: '41-50',
              color: '#e74c3c'
            },
            metu: {
              name: '51-100',
              color: '#c0392b'
            },
            mema: {
              name: '>100',
              color: '#800000'
            }
          };

          var legend = document.getElementById('legend');
          for (var key in icons) {
            var type = icons[key];
            var name = type.name;
            var color = type.color;
            var div = document.createElement('div');
            div.innerHTML = '<input type="checkbox" id="' + key + '" checked onchange="toggleChange()"><span style="color: ' + color + '">■</span> ' + name;
            legend.appendChild(div);
          }

          map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

          // NOTE: This uses cross-domain XHR, and may not work on older browsers.
          map.data.loadGeoJson(
              'http://192.168.8.66/kabupaten.json'
          );
          
          setStyle();

          var infowindow = new google.maps.InfoWindow();

          map.data.addListener('click', function(event) {
           let kab = event.feature.getProperty("NAME_2");
               var isColorful  = event.feature.getProperty('isColorful');
               var rawat = "-";
               if (isColorful) {
                 rawat = event.feature.getProperty("dirawat");
               }else{
                 rawat = "-";
               }
           let html = kab + "(" + rawat + ")";
           infowindow.setContent(html); // show the html variable in the infowindow
           infowindow.setPosition(event.latLng); // anchor the infowindow at the marker
           infowindow.open(map);
          });

          map.data.addListener('mouseover', function(event) {
               map.data.revertStyle();
               map.data.overrideStyle(event.feature, {strokeWeight: 3});
          });

          map.data.addListener('mouseout', function(event) {
           map.data.revertStyle();
          });

          google.maps.event.addListener(map.data,'addfeature',function(e){
            if (e.feature.getGeometry() !== null && e.feature.getGeometry().getType() === 'Polygon') {
              //initialize the bounds
              var bounds= new google.maps.LatLngBounds();

              //iterate over the paths
              e.feature.getGeometry().getArray().forEach(function(path){

                 //iterate over the points in the path
                 path.getArray().forEach(function(latLng){

                   //extend the bounds
                   bounds.extend(latLng);
                 });

              });
              var himu = document.getElementById('himu').checked;
              var hitu = document.getElementById('hitu').checked;
              var kuni = document.getElementById('kuni').checked;
              var oran = document.getElementById('oran').checked;
              var memu = document.getElementById('memu').checked;
              var metu = document.getElementById('metu').checked;
              var mema = document.getElementById('mema').checked;
              var jumlah = 0;
              var isColorful  = e.feature.getProperty('isColorful');
               if (isColorful) {
                jumlah = e.feature.getProperty("dirawat");
                var text = e.feature.getProperty("NAME_2") + "<br>" + jumlah;
                if (jumlah >= 0 && jumlah <= 10) {
                 color = "#2ecc71";
                 if (himu) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }else if (jumlah >= 11 && jumlah <= 20) {
                 color = "#27ae60";
                 if (hitu) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }else if (jumlah >= 21 && jumlah <= 30) {
                 color = "#f1c40f";
                 if (kuni) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }else if (jumlah >= 31 && jumlah <= 40) {
                 color = "#f39c12";
                 if (oran) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }else if (jumlah >= 41 && jumlah <= 50) {
                 color = "#e74c3c";
                 if (memu) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }else if (jumlah >= 51 && jumlah <= 100) {
                 color = "#c0392b";
                 if (metu) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }else if (jumlah >100) {
                 color = "#800000";
                 if (mema) {
                  overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                 }
                }
               }
            }else{
              if (e.feature.getGeometry() !== null && e.feature.getGeometry().getType() === 'MultiPolygon'){
                var bounds= new google.maps.LatLngBounds();
                var array = e.feature.getGeometry().getArray();
                array.forEach(function(item,i){

                  var coords= item.getAt(0).getArray();
                  var poly = new google.maps.Polygon({
                    paths: coords
                  });
                   coords.forEach(function(latLng){

                       //extend the bounds
                       bounds.extend(latLng);

                  });

                });
                var himu = document.getElementById('himu').checked;
                var hitu = document.getElementById('hitu').checked;
                var kuni = document.getElementById('kuni').checked;
                var oran = document.getElementById('oran').checked;
                var memu = document.getElementById('memu').checked;
                var metu = document.getElementById('metu').checked;
                var mema = document.getElementById('mema').checked;
                var jumlah = 0;
                var isColorful  = e.feature.getProperty('isColorful');
                 if (isColorful) {
                  jumlah = e.feature.getProperty("dirawat");
                  var text = e.feature.getProperty("NAME_2") + "<br>" + jumlah;
                  if (jumlah >= 0 && jumlah <= 10) {
                   color = "#2ecc71";
                   if (himu) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }else if (jumlah >= 11 && jumlah <= 20) {
                   color = "#27ae60";
                   if (hitu) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }else if (jumlah >= 21 && jumlah <= 30) {
                   color = "#f1c40f";
                   if (kuni) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }else if (jumlah >= 31 && jumlah <= 40) {
                   color = "#f39c12";
                   if (oran) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }else if (jumlah >= 41 && jumlah <= 50) {
                   color = "#e74c3c";
                   if (memu) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }else if (jumlah >= 51 && jumlah <= 100) {
                   color = "#c0392b";
                   if (metu) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }else if (jumlah >100) {
                   color = "#800000";
                   if (mema) {
                    overlay = new USGSOverlay(bounds, text, jumlah, map);
                    overlays.push(overlay);
                   }
                  }
                 }
              }else{
                console.log(e.feature.getProperty("NAME_2") + "-");
              }
            }
          })
      }

      function setStyle(){
        map.data.setStyle(function(feature){
           var color = "black";
           var border = "black";
           var isColorful  = feature.getProperty('isColorful');
           if (isColorful) {
           // 0-10 -> Hijau muda
          // 11-20 -> Hijau tua
          // 21-30 -> kuning
          // 31-40 -> oranye
          // 41-50 -> merah muda
          // 51-100 -> merah tua
          // >100 -> merah maron
            var himu = document.getElementById('himu').checked;
            var hitu = document.getElementById('hitu').checked;
            var kuni = document.getElementById('kuni').checked;
            var oran = document.getElementById('oran').checked;
            var memu = document.getElementById('memu').checked;
            var metu = document.getElementById('metu').checked;
            var mema = document.getElementById('mema').checked;

            var jumlah = feature.getProperty('dirawat');
            if (jumlah >= 0 && jumlah <= 10) {
             color = "#2ecc71";
             if (!himu) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }else if (jumlah >= 11 && jumlah <= 20) {
             color = "#27ae60";
             if (!hitu) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }else if (jumlah >= 21 && jumlah <= 30) {
             color = "#f1c40f";
             if (!kuni) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }else if (jumlah >= 31 && jumlah <= 40) {
             color = "#f39c12";
             if (!oran) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }else if (jumlah >= 41 && jumlah <= 50) {
             color = "#e74c3c";
             if (!memu) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }else if (jumlah >= 51 && jumlah <= 100) {
             color = "#c0392b";
             if (!metu) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }else if (jumlah >100) {
             color = "#800000";
             if (!mema) {
              return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })
             }
            }

             return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 1,
               strokeWeight: 0.4,
               title: color
             })
           }else{
             return ({
               fillColor: color,
               strokeColor: border,
               fillOpacity: 0,
               strokeWeight: 0,
               title: color
             })

           }
          })
      }

      function toggleChange(){
        for(var i=0;i<overlays.length;i++) {
          overlays[i].setMap(null);
        }
        map.data.forEach(function(feature) {
          map.data.remove(feature);
        });
        map.data.loadGeoJson(
            'http://192.168.8.66/kabupaten.json'
        );
        setStyle();
      }

      /** @constructor */
      function USGSOverlay(bounds, text, value, map) {

        // Now initialize all properties.
        this.bounds_ = bounds;
        this.map_ = map;
        this.text_ = text;
        this.value_ = value;
        // We define a property to hold the image's div. We'll
        // actually create this div upon receipt of the onAdd()
        // method so we'll leave it null for now.
        this.div_ = null;

        // Explicitly call setMap on this overlay
        this.setMap(map);
        // overlay = new USGSOverlay(bounds, map);
      }

      USGSOverlay.prototype.onAdd = function() {

        // Note: an overlay's receipt of onAdd() indicates that
        // the map's panes are now available for attaching
        // the overlay to the map via the DOM.

        // Create the DIV and set some basic attributes.
        var div = document.createElement('div');
        div.style.borderStyle = 'solid';
        div.style.borderWidth = '0px';
        div.style.borderColor = '#FFF';
        div.style.color = '#FFF';
        div.style.position = 'absolute';
        div.style.zIndex = 9000;

        // Create an IMG element and attach it to the DIV.
        div.innerHTML= this.text_;
        // console.log(this.text_);
        // Set the overlay's div_ property to this DIV
        this.div_ = div;

        // We add an overlay to a map via one of the map's panes.
        // We'll add this overlay to the overlayLayer pane.
        var panes = this.getPanes();
        panes.overlayLayer.appendChild(div);
      }

      USGSOverlay.prototype.draw = function() {

        // Size and position the overlay. We use a southwest and northeast
        // position of the overlay to peg it to the correct position and size.
        // We need to retrieve the projection from this overlay to do this.
        var overlayProjection = this.getProjection();

        // Retrieve the southwest and northeast coordinates of this overlay
        // in latlngs and convert them to pixels coordinates.
        // We'll use these coordinates to resize the DIV.
        var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
        var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

        // Resize the image's DIV to fit the indicated dimensions.
        var div = this.div_;
        div.style.left = sw.x + 'px';
        div.style.top = ne.y + ((sw.y - ne.y)/2) + 'px';
        div.style.width = (ne.x - sw.x) + 'px';
        div.style.height = (sw.y - ne.y) + 'px';
        div.style.textAlign = 'center';
      }

      USGSOverlay.prototype.onRemove = function() {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
      }

      google.maps.event.addDomListener(window, 'load', initMap); 
    </script>
</head>
<body>
  <div id="map"></div>
  <div id="legend"><h3>Legend</h3></div>
</body>
</html>