$(document).on("click", ".clear-search", function () {
    $("#save-advertisment")[0].reset();
    $(".table-view").html("");
});

$("#save-advertisment").on("submit", function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        var form = document.getElementById("save-advertisment");
        var formData = new FormData(form);
        // showloading();

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formData,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data, textStatus, xhr) {
                if (xhr.status == 200) {
                    toastr.success(data.message);
                    setTimeout(function () {
                        location.href = redirectURL;
                    }, 1500);
                    return false;
                } else {
                    toastr.error(data.message);
                    return false;
                }
            },
            error: function (data, textStatus, xhr) {
                // hideloading();
                var errors = data.responseJSON.errors;
                if (errors) {
                    for (const key in errors) {
                        if (Object.hasOwnProperty.call(errors, key)) {
                            toastr.error(errors[key][0]);
                        }
                    }
                } else {
                    toastr.error(data.responseJSON.message);
                }
            },
        });
        e.stopImmediatePropagation();
    }
});

var lat = 23.033863;
var lng = 72.585022;

$(document).ready(function () {
    $("#lat").val(lat);
    $("#lng").val(lng);
});

function initMap() {
    const myLatLng = { lat: lat, lng: lng };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: myLatLng,
    });

    marker = new google.maps.Marker({
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: myLatLng,
        map,
    });

    google.maps.event.addListener(marker, "dragend", function () {
        geocodePosition(marker.getPosition());
    });
}

function geocodePosition(pos) {
    geocoder = new google.maps.Geocoder();
    geocoder.geocode(
        {
            latLng: pos,
        },
        function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $("#lat").val(pos.lat());
                $("#lng").val(pos.lng());
            } else {
                toast.error(
                    "Cannot determine address at this location." + status
                );
            }
        }
    );
}

window.initMap = initMap;
