$(document).ready(function () {
    initialize();

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});
function initialize() {
    var input = document.getElementById("search");
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener("place_changed", function () {
        var place = autocomplete.getPlace();
        $("#lat").val(place.geometry["location"].lat());
        $("#lng").val(place.geometry["location"].lng());
    });
}

$(document).on("click", ".clear-search", function () {
    $("#search-advertisment")[0].reset();
    $(".table-view").html("");
});

$("#search-advertisment").on("submit", function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        var form = document.getElementById("search-advertisment");
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
                    $(".table-view").html(data.data.view);
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
