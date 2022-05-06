$(document).ready(function(){
    require(['async!http://maps.google.com/maps/api/js?key=AIzaSyDlBwn7IHKMc9fTsdoACBRidhjfGESyYO0&sensor=true!callback'],function(){
        if(typeof longitude!="undefined"&&typeof latitude!="undefined"){
            var zoom=14;
            if(typeof zoomorig!="undefined"){
                zoom=zoomorig;
            }
            var LatLng=new google.maps.LatLng(latitude,longitude);
            var mapOptions = {
                center: LatLng,
                zoom: zoom
            };
            var map = new google.maps.Map(document.getElementById("branch-map-container"),mapOptions);
            var marker = new google.maps.Marker({
                position: LatLng,
                map: map,
                title:title
            });
        }
    });
});