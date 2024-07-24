<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzbVo-3B81-_eIIQHZKPDEm4DLjo0LCFU&libraries=places&callback=initMap" async defer></script>
{{-- Key gg api: AIzaSyDdLXVBp-Q-bb4yZjIb-mAKVvPCi9PamRM --}}


<script>
    
</script>



<script>
    var directionsService = new google.maps.DirectionsService();
var setDataPrice = [0, 8500, 20000, 14500, 40000, 45000, 85000, 9000, 32000, 9000];
// xe máy, xe hơi riêng, xe taxi, xe hợp đồng du lịch, xe taxi tải, giao hàng, tài xế riêng, lái xe hộ người say, đặt phòng khách sạn
var options = {
	style: 'decimal',
	minimumFractionDigits: 0,
	maximumFractionDigits: 0
};
function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
jQuery(document).ready(function($) {
    var placeFrom = document.getElementById("placeFrom");
    var placeTo = document.getElementById("placeTo");
    var autocomplete1 = new google.maps.places.Autocomplete(placeFrom);
    var autocomplete2 = new google.maps.places.Autocomplete(placeTo);
	var price = 0;
	var distance = 0;
    
    $("select#listDichVu option").each(function(i, obj) {
        $(obj).data('price', setDataPrice[i]);
    });
	$("select#listDichVu").change(function(e){
		if(price && distance){
			price = parseInt($(this).find(":selected").data('price'));
			$("#inpPrice").val(number_format(distance * price) + 'đ');
		}
	});
    autocomplete1.addListener('place_changed', function() {
        place = autocomplete1.getPlace();
        if (place.formatted_address) {
            $("#placeFrom").val(place.formatted_address);
            if($("#placeFrom").val() != '' && $("#placeTo").val() != ''){
                calcRoute();
            }
        } else {
            $("#khoangCachKM").val('');
            console.log("Không tìm thấy địa điểm");
        }
    });
    autocomplete2.addListener('place_changed', function() {
        place = autocomplete2.getPlace();
        if (place.formatted_address) {
            $("#placeTo").val(place.formatted_address);
            if($("#placeFrom").val() != '' && $("#placeTo").val() != ''){
                calcRoute();
            }
        } else {
            $("#khoangCachKM").val('');
            console.log("Không tìm thấy địa điểm");
        }
    });
    function calcRoute(){
		var request = {
			origin: placeFrom.value,
			destination: placeTo.value,
			travelMode: google.maps.TravelMode.DRIVING, //WALKING, BYCYCLING, TRANSIT
			unitSystem: google.maps.UnitSystem.METRIC,
		};
		// console.log(request);
		directionsService.route(request, function (result, status) {

			if(status == google.maps.DirectionsStatus.OK){
				var distanceText = result.routes[0].legs[0].distance.text;
				distance = parseInt((result.routes[0].legs[0].distance.value / 1000).toLocaleString('en-US', options).replace(',', ''));

				price = parseInt($("select#listDichVu").find(":selected").data('price'));

				// console.log(distance, $("select#listDichVu").find(":selected").data('price'));
				$("#khoangCachKM").val(distanceText);
				$("#inpPrice").val(number_format(distance * price) + 'đ');
			}else{
				$("#khoangCachKM").val('');
			}
		});
	}
});
</script>