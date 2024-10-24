document.addEventListener("livewire:initialized", () => {
    const loaderElement = document.getElementById("laravel-livewire-loader");
    let loaderTimeout = null;

    Livewire.hook(
        "request",
        ({ uri, options, payload, respond, succeed, fail }) => {
            // Log the URI when the request is initiated
            console.log("Livewire request initiated for URI:", uri);

            // Show the loader after a delay
            loaderTimeout = setTimeout(() => {
                loaderElement.classList.add("show");
            }, parseInt(loaderElement.dataset.showDelay));

            // Handle the response
            respond(({ status, response }) => {
                // Log the URI and response status when a response is received
                console.log(
                    "Response received for URI:",
                    uri,
                    "with status:",
                    status
                );

                // Hide the loader when the response is received
                loaderElement.classList.remove("show");
                clearTimeout(loaderTimeout);
                loaderTimeout = null;
            });

            // Handle successful response
            succeed(({ status, json }) => {
                // Log success information with the URI
                console.log(
                    "Successful response for URI:",
                    uri,
                    "with status:",
                    status
                );

                // Hide the loader when the response is successful
                loaderElement.classList.remove("show");
                clearTimeout(loaderTimeout);
                loaderTimeout = null;
            });

            // Handle failed requests
            fail(({ status, content, preventDefault }) => {
                // Log failure information with the URI
                console.log(
                    "Failed request for URI:",
                    uri,
                    "with status:",
                    status
                );

                // Hide the loader in case of failure
                loaderElement.classList.remove("show");
                clearTimeout(loaderTimeout);
                loaderTimeout = null;

                if (status === 419) {
                    // Custom handling for session expiration
                    if (
                        confirm(
                            "Your session has expired. Would you like to refresh the page?"
                        )
                    ) {
                        window.location.reload(); // Refresh the page if confirmed
                    }
                    preventDefault(); // Prevent Livewire's default behavior
                } else {
                    // Handle other error cases
                    alert("An error occurred: " + content);
                }
            });
        }
    );
    // Livewire.hook("commit", ({ component, commit, respond, succeed, fail }) => {
    //     // Show the loader after a delay
    //     loaderTimeout = setTimeout(() => {
    //         loaderElement.classList.add("show");
    //     }, parseInt(loaderElement.dataset.showDelay));

    //     // Handle successful responses
    //     succeed(({ snapshot, effect }) => {
    //         // Hide the loader after receiving the response
    //         loaderElement.classList.remove("show");
    //         clearTimeout(loaderTimeout);
    //         loaderTimeout = null;

    //         queueMicrotask(() => {
    //             // Additional actions after processing, if needed
    //         });
    //     });

    //     // Handle failed requests
    //     fail(() => {
    //         // Hide the loader in case of failure
    //         loaderElement.classList.remove("show");
    //         clearTimeout(loaderTimeout);
    //         loaderTimeout = null;

    //         // Custom handling for session expiration or other errors
    //         alert("An error occurred while processing your request.");
    //     });
    // });
});
