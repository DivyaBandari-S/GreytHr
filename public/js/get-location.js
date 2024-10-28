document.addEventListener("DOMContentLoaded", function () {
    console.log("Page loaded, requesting location...");

    // Call the getLocation function when the page loads
    getLocation();

    // Check if the openMapIcon exists before adding the event listener
    var openMapIcon = document.getElementById("openMapIcon");

    if (openMapIcon) {
        // Add event listener only if the element exists
        openMapIcon.addEventListener("click", openMap);
    } else {
        console.log("Element with ID 'openMapIcon' not found on this page.");
    }
});

var latitude, longitude;

function getLocation() {
    if (navigator.geolocation) {
        console.log("Requesting location...");

        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;

                // console.log("Latitude: " + latitude);
                // console.log("Longitude: " + longitude);
                // console.log("Coordinates: (" + latitude + ", " + longitude + ")");

                // Dispatch a Livewire event with the coordinates
                Livewire.dispatch("sendCoordinates", {
                    latitude: latitude,
                    longitude: longitude,
                });
            },
            function (error) {
                console.error("Error occurred. Error code: " + error.code);
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function openMap() {
    if (latitude && longitude) {
        var googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
        window.open(googleMapsUrl, "_blank");
    } else {
        alert("Location not available yet. Please try again.");
    }
}
