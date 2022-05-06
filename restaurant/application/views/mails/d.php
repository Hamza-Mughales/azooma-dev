<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq3C6MH2XjShVLm07FYuisLUV59LHyzNU&signed_in=true&language=<?= (sys_lang() == 'english') ? 'en' : 'ar'; ?>&callback=initMap"></script>
   
   <?php
   if ((isset($branch)) && ($branch['latitude'] != "") && ($branch['longitude'] != "")) {
   ?>
       <script type="text/javascript">
          var geocoder = new google.maps.Geocoder();

           function geocodePosition(pos) {
               geocoder.geocode({
                   latLng: pos
               }, function(responses) {

               });
           }

           function updateMarkerPosition(latLng) {
               document.getElementById("latitude").value = latLng.lat();
               document.getElementById("longitude").value = latLng.lng();
           }

           function initialize() {
               var latLng = new google.maps.LatLng('<?php echo $branch['latitude']; ?>', '<?php echo $branch['longitude']; ?>');
               var map = new google.maps.Map(document.getElementById('map'), {
                   zoom: 8,
                   center: latLng,
                   mapTypeId: google.maps.MapTypeId.ROADMAP
               });
               var marker = new google.maps.Marker({
                   draggable: true,
                   position: latLng,
                   title: 'drag to select postion',
                   map: map
               });

               updateMarkerPosition(latLng);
               geocodePosition(latLng);

               google.maps.event.addListener(marker, 'drag', function() {
                   updateMarkerPosition(marker.getPosition());
               });
           }
       </script>
   <?php
   } else {
   ?>
       <script type="text/javascript">
           var geocoder = new google.maps.Geocoder();

           function geocodePosition(pos) {
               geocoder.geocode({
                   latLng: pos
               }, function(responses) {

               });
           }

           function updateMarkerPosition(latLng) {
               document.getElementById("latitude").value = latLng.lat();
               document.getElementById("longitude").value = latLng.lng();
           }

           function initialize() {
               var latt = ''; //23.885942
               var lngg = ''; //45.079162
               var address = 'Saudi Arabia';
               geocoder.geocode({
                   'address': address
               }, function(results, status) {
                   if (status == google.maps.GeocoderStatus.OK) {
                       latt = results[0].geometry.location.lat().toString().substr(0, 12);
                       lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                       loadmap(latt, lngg)
                   } else {
                       alert('error: ' + status);
                   }
               });
           }

           function loadmap(latt, lngg) {
               var latLng = new google.maps.LatLng(latt, lngg);
               var map = new google.maps.Map(document.getElementById('map'), {
                   zoom: 8,
                   center: latLng,
                   mapTypeId: google.maps.MapTypeId.ROADMAP
               });
               var marker = new google.maps.Marker({
                   draggable: true,
                   position: latLng,
                   title: 'drag to select postion',
                   map: map
               });

               updateMarkerPosition(latLng);
               geocodePosition(latLng);

               google.maps.event.addListener(marker, 'drag', function() {
                   updateMarkerPosition(marker.getPosition());
               });
           }

           function getDistrictMap(id) {
               var district = $('#' + id + ' option:selected').text();
               var city = $("#city_ID option:selected").text();
               var address = city + " " + district;
               geocoder.geocode({
                   'address': address
               }, function(results, status) {
                   if (status == google.maps.GeocoderStatus.OK) {
                       latt = results[0].geometry.location.lat().toString().substr(0, 12);
                       lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                       loadmap(latt, lngg)
                   } else {
                       alert('error: ' + status);
                   }
               });
           }

           function selectcity() {
               var city = $("#city_ID").val();
               $(".district").addClass('invisible');
               $("#district_" + city).removeClass('invisible');
               $("#cityCode option[data-city='" + city + "']").attr('selected', true);
               var cityname = $("#city_ID option:selected").text();

               geocoder.geocode({
                   'address': cityname
               }, function(results, status) {
                   if (status == google.maps.GeocoderStatus.OK) {
                       latt = results[0].geometry.location.lat().toString().substr(0, 12);
                       lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                       loadmap(latt, lngg)
                   } else {
                       console.log('error: ' + status);
                   }
               });
           }
       </script>
   <?php } ?>
   <script>
google.maps.event.addDomListener(window, 'load', initialize);
//  $("#restMainForm").validate();
if ($("#city_ID").val() != "") {
selectcity();
}
</script>