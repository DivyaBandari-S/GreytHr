function initialize() {
    console.log("Page loaded, requesting location...");

    // Call the getLocation function when the page loads
    getLocation();

    // Check if the element exists before adding the event listener
    var openMapButton = document.getElementById("openMap");
    if (openMapButton) {
        openMapButton.addEventListener("click", openGoogleMaps);
    } else {
        console.error("Button with ID 'openMap' not found.");
    }
}

document.addEventListener("DOMContentLoaded", initialize);
window.addEventListener("load", initialize);

var latitude, longitude;

function getLocation() {
    if (navigator.geolocation) {
        console.log("Requesting location...");

        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;

                // Log the latitude and longitude to the console
                console.log("Latitude: " + latitude);
                console.log("Longitude: " + longitude);
                console.log(
                    "Coordinates: (" + latitude + ", " + longitude + ")"
                );

                // Dispatch a Livewire event with the coordinates
                Livewire.dispatch("sendCoordinates", {
                    latitude: latitude,
                    longitude: longitude,
                });
            },
            function (error) {
                console.error("Error occurred. Error code: " + error.code);
                // Handle geolocation errors
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function openGoogleMaps() {
    if (latitude && longitude) {
        // Build the Google Maps URL
        var googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;

        // Open the Google Maps URL in a new tab
        window.open(googleMapsUrl, "_blank");
    } else {
        alert("Location not available yet. Please try again.");
    }
}
