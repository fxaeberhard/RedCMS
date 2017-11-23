
<div class="map">
  <div id="map"></div>
</div>

@push('scripts')
  <script>
  function initMap() {
    var center = new google.maps.LatLng(46.521676, 6.637344),
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: center,
        scrollwheel: false,
        // mapTypeControl: true,
        // mapTypeControlOptions: {
        //   style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        //   position: google.maps.ControlPosition.TOP_LEFT
        // },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [{
          stylers: [{ saturation: -80 }]
          }]
      }),
      markerImage = new google.maps.MarkerImage('images/map_marker.png', new google.maps.Size(34, 30), new google.maps.Point(0, 0), new google.maps.Point(17, 30)),
      marker = new google.maps.Marker({
        position: center,
        map: map,
        icon: markerImage,
        title: 'Samir Alaoui Architecture'
      }),
      infowindow = new google.maps.InfoWindow({
        content: "<h2>Samir Alaoui Architecte</h2>Saint-Martin, 22<br>1003 Lausanne"
      });;
    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });
  }

  $(window).on('load', function() {
    $.getScript("http://maps.google.com/maps/api/js?language=fr&key=AIzaSyBYWXn3DFrqEKpX_EISeCP-2F-n6i-ZVxo&callback=initMap")
  })
  </script>
  <!-- <script async defer src="http://maps.google.com/maps/api/js?language=fr&key=AIzaSyBYWXn3DFrqEKpX_EISeCP-2F-n6i-ZVxo&callback=initMap"></script> -->
@endpush