function selectcity(){
    var city=$("#city_ID").val();
    $(".district").addClass('invisible');
    $("#district_"+city).removeClass('invisible');
    $("#cityCode option[data-city='"+city+"']").attr('selected', true);
}
function selecthotel(){
    var type=$("#branch_type").val();
    if(type=="Hotel Restaurant"){
        $("#hotel_value").removeClass('invisible');
    }else{
        $("#hotel_value").addClass('invisible');
    }
}
function showMarker(){
    $('#map').show();
    $('#addMap').hide();
    $('#removeMap').show();
    $("#mapbool").val(1);
}
function hideMarker(){
    $('#map').hide();
    $('#addMap').show();
    $('#removeMap').hide();
    $("#mapbool").val(0);
    document.getElementById("latitude").value = "";
    document.getElementById("longitude").value = "";
    document.getElementById("zoom").value = "";
}
