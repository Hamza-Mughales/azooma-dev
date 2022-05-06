<?php
    $newmap = rand(1, 15); 
?>
<div id="rest-map-<?php echo $newmap; ?>" style="height: 200px"></div>
{{-- <script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXFAxSgXP7b5D25WEtjxkYqoWM2PjxaLg&callback=initialize&libraries=places">
</script> --}}

<script>
    function initialize() {
  initMap<?php echo $newmap; ?>();
}

function initMap<?php echo $newmap; ?>() {
    const myLatLng = {
        lat: <?php echo $restbranches[0] -> latitude ?> ,
        lng: <?php echo $restbranches[0] -> longitude ?>
    };
    const map = new google.maps.Map(document.getElementById("rest-map-<?php echo $newmap; ?>"), {
        zoom: 11,
        disableDefaultUI: true,
        mapTypeId: "roadmap",
        center: myLatLng,
    }); 
    <?php
    if (count($restbranches) > 0) {
        foreach($restbranches as $branch) {
            ?>
            var marker = new google.maps.Marker({
                position: {
                    lat: <?php echo $branch -> latitude; ?> ,
                    lng : <?php echo $branch -> longitude; ?>
                },
                map,
                url: "#<?php echo $restname; ?>",
                title: "<?php echo $restname; ?>",
                label: {
                    text: "<?php echo $restname; ?>",
                    color: "black",
                    fontSize: "8px"
                }
            });

            <?php
        }
    } ?>
}
</script>