<script>
    let currentStartLat, currentStartLng, currentEndLat, currentEndLng;
    let isEditPage = $('input[name="editPage"]').val() === 'true';
    let isInitialLoad = true;
    let storeAddress='';

    $(document).ready(function () {
        $('#resultMap').addClass('hidden');
    });
    $(document).ready(function() {
        $('#driver-assignment').change(function() {
            if ($(this).val() === "2") {
                $('#driver').removeClass('hidden');
            } else {
                $('#driver').addClass('hidden');
            }
        });

        $('#store-select').on('change', function () {
            updateStoreCoordinates($(this).val());
        });
    });


    function areCoordinatesValid() {
        return !isNaN(currentStartLat) && !isNaN(currentStartLng) && !isNaN(currentEndLat) && !isNaN(currentEndLng);
    }

    $(document).ready(function () {
        currentStartLat = parseFloat($('input[name="lat"]').val());
        currentStartLng = parseFloat($('input[name="lng"]').val());
        currentEndLat = parseFloat($('input[name="destination_lat"]').val());
        currentEndLng = parseFloat($('input[name="destination_lng"]').val());


        if (isEditPage && areCoordinatesValid()) {
            displayRoute();
        } else {
            $('#resultMap').addClass('hidden');
            $('#directions-panel').empty();
        }
    });

    function updateStoreCoordinates(storeId) {
        if (storeId) {
            $.ajax({
                url: `${urlHome}/admin/stores/${storeId}`,
                type: 'GET',
                success: function (response) {
                    console.log(response)
                    currentEndLat = parseFloat(response.data.lat);
                    currentEndLng = parseFloat(response.data.lng);
                    $("#destination_address").val(response.data.address);
                    if (areCoordinatesValid()) {
                        displayRoute();
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    }



    function displayRoute() {
        const map = new google.maps.Map(document.getElementById('resultMap'), {
            zoom: 7,
            center: {lat: 10.8231, lng: 106.6297}
        });

        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map
        });

        directionsRenderer.setMap(map);
        $('#resultMap').removeClass('hidden');
        calculateAndDisplayRoute(directionsService, directionsRenderer);
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        currentStartLat = parseFloat(lat);
        currentStartLng = parseFloat(lng);
        destinationLat = currentEndLat;
        destinationLng = currentEndLng;
            // currentEndLat = parseFloat(destinationLat);
            // currentEndLng = parseFloat(destinationLng);
        if (areCoordinatesValid()) {

            directionsService.route({
                origin: {lat: currentStartLat, lng: currentStartLng},
                destination: {lat: currentEndLat, lng: currentEndLng},
                travelMode: google.maps.TravelMode.DRIVING
            }, function (response, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                    renderDirections(response);
                } else {
                    window.alert('Yêu cầu chỉ đường thất bại vì ' + status);
                }
            });
        }
    }

    function renderDirections(response) {
        const route = response.routes[0];
        const summaryPanel = $('#directions-panel');
        summaryPanel.empty();
        const leg = route.legs[0];
        const routeSegment = 1;
        const detailsId = 'details-' + routeSegment;
        const segmentHtml = createSegmentHtml(routeSegment, leg, detailsId);
        summaryPanel.append(segmentHtml);
        const currentDistance = leg.distance.text;
        checkAddressesAndSendAjax(currentDistance)
    }

    function createSegmentHtml(routeSegment, leg, detailsId) {
        var html = `<div class="d-flex align-items-center mt-3 mb-3">`;
        html += `<b class="me-3">Đoạn đường: ${routeSegment}</b>`;
        html += `<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#${detailsId}" aria-expanded="false" aria-controls="${detailsId}">
                Chi tiết
             </button></div>`;
        html += `<div class="collapse" id="${detailsId}">
                <div class="card card-body">
                    <strong>Các chặng:</strong>${leg.start_address} → ${leg.end_address}<br>
                     <strong>Khoảng cách:</strong> ${leg.distance.text}<br>
                    <strong>Thời gian dự kiến:</strong> ${leg.duration.text}
                </div>
             </div>`;
        return html;
    }

    function checkAddressesAndSendAjax(distance) {
        const selectedMode = $('#travelMode').val();
        const paymentMethod = $('#payment_method').val();
        const shippingMethod = $('#shipping_method').val();
        let subTotal = $('#sub_total').val();
        subTotal = subTotal && !isNaN(subTotal) ? parseFloat(subTotal) : 0;

        if (isInitialLoad && isEditPage) {
            isInitialLoad = false;
            console.log("Lần đầu tiên trang chỉnh sửa được tải, không gửi AJAX, sử dụng dữ liệu sẵn có");
        } else if (!isEditPage && areCoordinatesValid() && distance) {
            console.log("Trang tạo mới, gửi AJAX để lấy thông tin mới nhất");
            sendAjaxRequest(distance, selectedMode, paymentMethod, shippingMethod, subTotal);
        } else if (!isInitialLoad && isEditPage && areCoordinatesValid() && distance) {
            console.log("Trang chỉnh sửa, gửi AJAX để cập nhật thông tin dựa trên sự thay đổi");
            sendAjaxRequest(distance, selectedMode, paymentMethod, shippingMethod, subTotal);
        } else {
            console.log("Chưa đủ dữ liệu, không gửi AJAX");
            $('#resultMap').addClass('hidden');
        }
    }


    function sendAjaxRequest(distance, mode, paymentMethod, shippingMethod, subTotal) {
        $.ajax({
            url: `${urlHome}/admin/orders/get-info?distance=${distance}&payment_method=${paymentMethod}&shipping_method=${shippingMethod}&sub_total=${subTotal}`,
            type: 'GET',
            success: function (response) {
                console.log(response);
                $('#total').val(response.totalPrice);
                $('#transport_fee').val(response.transport_fee);
                $('#system_revenue').val(response.systemRevenue);
            },
            error: function (error) {
                console.error(error);
            }
        });
    }


    $(document).on("mychangeAddressChanged destinationAddressChanged", function () {
        displayRoute();

    });

    $(document).on('change', '#sub_total', function () {
        if (areCoordinatesValid()) {
            displayRoute();
        }
    });
</script>
