// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll("#sidebar .side-dropdown");
const sidebar = document.getElementById("sidebar");

allDropdown.forEach((item) => {
    const a = item.parentElement.querySelector("a:first-child");
    a.addEventListener("click", function (e) {
        e.preventDefault();

        if (!this.classList.contains("active")) {
            allDropdown.forEach((i) => {
                const aLink = i.parentElement.querySelector("a:first-child");

                aLink.classList.remove("active");
                i.classList.remove("show");
            });
        }

        this.classList.toggle("active");
        item.classList.toggle("show");
    });
});

// function setActiveLink(link, targetUrl) {
// 	var currentUrl = window.location.pathname;

// 	// Check if the target URL is the same as the current URL
// 	if (currentUrl !== targetUrl) {
// 		// openModal();
// 		// Remove active class from all links
// 		var links = document.querySelectorAll('a:first-child');
// 		links.forEach(function(element) {
// 			element.classList.remove('active');
// 		});

// 		// Add active class to the clicked link
// 		link.classList.add('active');

// 	} else {
// 		// If target URL is same as current URL, prevent modal opening
// 		event.preventDefault();
// 		console.log("Already on the same page.");
// 	}
// }

// Check and set active link on page load
document.addEventListener("DOMContentLoaded", function () {
    var currentPath = window.location.pathname;
    console.log(currentPath);
    var pathSegments = currentPath
        .split("/")
        .filter((segment) => segment !== "");
    var firstSegment = "/" + pathSegments[0];
    console.log(firstSegment);
    var links = document.querySelectorAll("a:first-child");

    links.forEach(function (link) {
        link.classList.remove("active-side-dropdown");
        if (link.getAttribute("href") === firstSegment) {
            link.classList.add("active-side-dropdown");
            // link.parentNode.classList.add('active-side-dropdown');
        }
    });

    // Adding active class for dropdown parents
    var dropdownLinks = document.querySelectorAll(".side-dropdown a");

    dropdownLinks.forEach(function (link) {
        if (link.getAttribute("href") === firstSegment) {
            var parentLink = link.closest("ul").previousElementSibling;
            if (parentLink) {
                parentLink.classList.add("active-side-dropdown");
                // parentLink.parentNode.classList.add('active-side-dropdown');
            }
        }
    });
});

// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector("nav .toggle-sidebar");
const allSideDivider = document.querySelectorAll("#sidebar .divider");

if (sidebar) {
    if (sidebar.classList.contains("hide")) {
        allSideDivider.forEach((item) => {
            item.textContent = "-";
        });
        allDropdown.forEach((item) => {
            const a = item.parentElement.querySelector("a:first-child");
            a.classList.remove("active");
            item.classList.remove("show");
        });
    } else {
        allSideDivider.forEach((item) => {
            item.textContent = item.dataset.text;
        });
    }
}

// if (toggleSidebar) {
//     toggleSidebar.addEventListener("click", function () {
//         sidebar.classList.toggle("hide");
//         const mainContent = document.getElementById("maincontent");

//         if (sidebar.classList.contains("hide")) {
//             mainContent.classList.add("active");
//             allSideDivider.forEach((item) => {
//                 item.textContent = "-";
//             });

//             allDropdown.forEach((item) => {
//                 const a = item.parentElement.querySelector("a:first-child");
//                 a.classList.remove("active");
//                 item.classList.remove("show");
//             });
//         } else {
//             mainContent.classList.remove("active");
//             allSideDivider.forEach((item) => {
//                 item.textContent = item.dataset.text;
//             });
//         }
//     });
// }

if (toggleSidebar) {
    // Function to handle the sidebar toggle logic
    function toggleSidebarHandler() {
        sidebar.classList.toggle("hide");
        const mainContent = document.getElementById("maincontent");

        if (sidebar.classList.contains("hide")) {
            mainContent.classList.add("active");
            allSideDivider.forEach((item) => {
                item.textContent = "-";
            });

            allDropdown.forEach((item) => {
                const a = item.parentElement.querySelector("a:first-child");
                a.classList.remove("active");
                item.classList.remove("show");
            });
        } else {
            mainContent.classList.remove("active");
            allSideDivider.forEach((item) => {
                item.textContent = item.dataset.text;
            });
        }
    }

    // Add event listener to the toggle button
    toggleSidebar.addEventListener("click", toggleSidebarHandler);

    // Check if the screen is a mobile size and trigger the sidebar toggle
    if (window.innerWidth <= 968) {
        // Adjust the width as needed for mobile screens
        toggleSidebarHandler();
    }

    // Optional: Listen for window resize events to toggle based on resizing to/from mobile size
    window.addEventListener("resize", function () {
        if (window.innerWidth <= 968 && !sidebar.classList.contains("hide")) {
            toggleSidebarHandler();
        } else if (
            window.innerWidth > 968 &&
            sidebar.classList.contains("hide")
        ) {
            toggleSidebarHandler();
        }
    });
}

if (sidebar) {
    sidebar.addEventListener("mouseleave", function () {
        if (this.classList.contains("hide")) {
            allDropdown.forEach((item) => {
                const a = item.parentElement.querySelector("a:first-child");
                a.classList.remove("active");
                item.classList.remove("show");
            });
            allSideDivider.forEach((item) => {
                item.textContent = "-";
            });
        }
    });

    sidebar.addEventListener("mouseenter", function () {
        if (this.classList.contains("hide")) {
            allDropdown.forEach((item) => {
                const a = item.parentElement.querySelector("a:first-child");
                a.classList.remove("active");
                item.classList.remove("show");
            });
            allSideDivider.forEach((item) => {
                item.textContent = item.dataset.text;
            });
        }
    });
}

// PROFILE DROPDOWN
const profile = document.querySelector("nav .profile");
if (profile) {
    const imgProfile = profile.querySelector("img");
    // const imgProfile2 = document.getElementsByClassName('brandLogoDiv');
    const dropdownProfile = profile.querySelector(".profile-link");

    // imgProfile2.addEventListener('click', function () {
    // 	dropdownProfile.classList.toggle('show');
    // })

    function openProfile() {
        const profile = document.querySelector("nav .profile");
        const dropdownProfile = profile.querySelector(".profile-link");
        dropdownProfile.classList.toggle("show");
    }
}

// MENU
const allMenu = document.querySelectorAll("main .content-data .head .menu");

allMenu.forEach((item) => {
    const icon = item.querySelector(".icon");
    const menuLink = item.querySelector(".menu-link");

    icon.addEventListener("click", function () {
        menuLink.classList.toggle("show");
    });
});

window.addEventListener("click", function (e) {
    // if(e.target !== imgProfile) {
    // 	if(e.target !== dropdownProfile) {
    // 		if(dropdownProfile.classList.contains('show')) {
    // 			dropdownProfile.classList.remove('show');
    // 		}
    // 	}
    // }

    allMenu.forEach((item) => {
        const icon = item.querySelector(".icon");
        const menuLink = item.querySelector(".menu-link");

        if (e.target !== icon) {
            if (e.target !== menuLink) {
                if (menuLink.classList.contains("show")) {
                    menuLink.classList.remove("show");
                }
            }
        }
    });
});

// PROGRESSBAR
const allProgress = document.querySelectorAll("main .card .progress");

allProgress.forEach((item) => {
    item.style.setProperty("--value", item.dataset.value);
});

// APEXCHART
var options = {
    series: [
        {
            name: "series1",
            data: [31, 40, 28, 51, 42, 109, 100],
        },
        {
            name: "series2",
            data: [11, 32, 45, 32, 34, 52, 41],
        },
    ],
    chart: {
        height: 350,
        type: "area",
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
    },
    xaxis: {
        type: "datetime",
        categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
        ],
    },
    tooltip: {
        x: {
            format: "dd/MM/yy HH:mm",
        },
    },
};

// var chart = new ApexCharts(document.querySelector("#chart"), options);
// chart.render();

// // chat screen js
function openChatScreen() {
    // $(this).parents("#contacts").addClass("hidden");
    $("#content-chart").addClass("active");
    $("#listCOntactDiv").addClass("hidden");
}

function closeChatScreen(e) {
    // e.preventDefault();
    $("#listCOntactDiv").removeClass("hidden");
    $("#content-chart").removeClass("active");
}

// function openMsgDiv() {
//     $("#chatScreen").show();
//     $(".bio-div").hide();
//     $("#chatScreen input.form-control").focus();
// }

// // Hide chat screen when close button is clicked
// $("#closeChat").click(function (e) {
//     e.preventDefault();
//     $("#chatScreen").hide();
//     $(".bio-div").show();
// });

// function openSetting() {
//     $("#settings").show();
//     $("#contacts").hide();
//     $("#content-chart").hide();
//     $("#people-link").removeClass("active");
//     $("#settings-link").addClass("active");
// }
// function openPeopleList() {
//     $("#settings").hide();
//     $("#contacts").show();
//     $("#content-chart").show();
//     $("#settings-link").removeClass("active");
//     $("#people-link").addClass("active");
// }

document.addEventListener("DOMContentLoaded", function () {
    if (
        window.location.pathname === "/chat" ||
        window.location.pathname === "/chat/" ||
        window.location.pathname === "/users" ||
        window.location.pathname === "/calendar" ||
        window.location.pathname === "/Settings"
    ) {
        document.body.id = "userPage";
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname; // Get the current path
    const menuLinks = document.querySelectorAll(".sidebar .menus a"); // Select all menu links

    menuLinks.forEach((link) => {
        const linkHref = link.getAttribute("href");

        if (currentPath === linkHref) {
            link.classList.add("active");
            link.classList.add("active-side-dropdown");
        } else {
            link.classList.remove("active");
            link.classList.remove("active-side-dropdown");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname; // Get the current path
    const menuLinks = document.querySelectorAll(".sidebar .menus a"); // Select all menu links

    menuLinks.forEach((link) => {
        const linkHref = link.getAttribute("href");

        if (currentPath === linkHref) {
            link.classList.add("active");
            link.classList.add("active-side-dropdown");
        } else {
            link.classList.remove("active");
            link.classList.remove("active-side-dropdown");
        }
    });
});

function openAIAssist() {
    $(".reqModal").addClass("modal-lg");
    $(".reqForm").addClass("col-md-7").removeClass("col-md-12");
    $(".reqAssist").addClass("d-block").removeClass("d-none");
}

// document.addEventListener("DOMContentLoaded", () => {
//     const emojiPicker = document.getElementById("emojiPicker");
//     const emojiButton = document.getElementById("emojiButton");
//     const messageInput = document.getElementById("messageInput");
//     const fileInput = document.getElementById("fileInput");

//     // Toggle emoji picker visibility when emoji button is clicked
//     emojiButton.addEventListener("click", () => {
//         emojiPickerOpen(); // Toggle emoji picker visibility
//     });

//     // Add emoji to input when selected
//     emojiPicker.addEventListener("emoji-click", function (event) {
//         console.log("Selected Emoji:", event.detail.unicode);
//         const emoji = event.detail.unicode; // Get the selected emoji

//         // Insert emoji at cursor position
//         const cursorPos = messageInput.selectionStart; // Get cursor position
//         const textBefore = messageInput.value.substring(0, cursorPos); // Text before cursor
//         const textAfter = messageInput.value.substring(cursorPos); // Text after cursor

//         // Set new value with emoji inserted at cursor position
//         messageInput.value = textBefore + emoji + textAfter;

//         // Move the cursor to the end of the text after inserting the emoji
//         messageInput.selectionStart = messageInput.selectionEnd =
//             cursorPos + emoji.length;

//         emojiPicker.style.display = "none"; // Hide emoji picker after selection
//     });

//     // Handle file attachment
//     fileInput.addEventListener("change", (event) => {
//         const file = event.target.files[0];
//         if (file) {
//             console.log("Attached file:", file.name);
//             // Add your file upload logic here
//         }
//     });
// });

// Function to toggle emoji picker visibility
// function emojiPickerOpen() {
//     const emojiPicker = document.getElementById("emojiPicker");
//     emojiPicker.style.display =
//         emojiPicker.style.display === "none" || !emojiPicker.style.display
//             ? "block"
//             : "none";
// }

document.addEventListener('DOMContentLoaded', function() {
    const welcomeSectionDiv = document.querySelector('.home1'); // Select the main container

    if (!welcomeSectionDiv) return;

    const originalContent = welcomeSectionDiv.innerHTML;

    const skeletonHTML = `
        <div class="col-12 col-md-8 mb-3">
            <div class="row m-0 welcomeContainer hover-card">
                <div class="card-content row p-0 m-0">
                    <div class="col-md-4 p-0 ps-3 pt-4">
                        <p class="morning-city skeleton-loader" style="height: 20px; width: 150px;"></p>
                        <p class="morning-city skeleton-loader" style="padding-top: 2.5em; height: 30px; width: 200px;"></p>
                    </div>
                    <div class="col-md-8 px-3 pt-4">
                        <div class="mb-4 homeBaneerCard row m-0">
                            <div class="col-md-5 pe-0">
                                <div class="bigCircle skeleton-loader" style="width: 100px; height: 100px; border-radius: 50%;">
                                    <div class="smallCircle skeleton-loader" style="width: 50px; height: 50px; border-radius: 50%; margin: 25px;"></div>
                                </div>
                                <div class="d-flex" style="margin-top: 3em; margin-left: 5px;">
                                    <span class="skeleton-loader" style="width: 80px; height: 20px;"></span>
                                    <span class="skeleton-loader" style="width: 2.5em; height: 2.5em; border-radius: 50%; margin-left: 10px;"></span>
                                </div>
                            </div>
                            <div class="col-md-7 ps-0 pt-2 text-end">
                                <p class="normalText skeleton-loader" style="height: 20px; width: 180px; margin-top: 25px;"></p>
                                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 120px;"></p>
                                 <div class="locationGlobe m-0 mt-4 pe-0 mb-2 row">
                                    <div class="col-11 p-0" style="text-align: end;">
                                        <p class="mb-1 skeleton-loader" style="height: 20px; width: 150px;"></p>
                                    </div>
                                    <div class="col-1 p-0" style="text-align: end;">
                                         <span class="skeleton-loader" style="width: 1em; height: 1em;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="A d-flex justify-content-between align-items-center flex-row mb-3">
                            <span class="viewSwipesList skeleton-loader" style="height: 30px; width: 100px;"></span>
                            <span  class="signInButton skeleton-loader" style="height: 30px; width: 100px;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="cardReport">
                <div class="mail">
                    <span class="rounded-pill home-reportTo skeleton-loader" style="height: 30px; width: 120px; border-radius: 1rem;"></span>
                </div>
                <div class="profile-pic">
                    <span class="skeleton-loader" style="width: 50px; height: 50px; border-radius: 50%;"></span>
                </div>
                <div class="bottom">
                    <div class="content">
                         <p class="name skeleton-loader" style="height: 20px; width: 150px;"></p>
                         <p class="about-me skeleton-loader" style="height: 18px; width: 100px;"></p>
                         <p class="managerOtherDetails skeleton-loader" style="height: 18px; width: 120px;"></p>
                         <p class="managerOtherDetails skeleton-loader" style="height: 18px; width: 120px;"></p>
                    </div>
                </div>
            </div>
        </div>
    `;

    welcomeSectionDiv.innerHTML = skeletonHTML;

    setTimeout(function() {
        welcomeSectionDiv.innerHTML = originalContent;
    }, 3000);
});

const style = document.createElement('style');
style.textContent = `
.skeleton-loader {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite linear;
    border-radius: 4px;
    margin: 4px 0;
}

@keyframes shimmer {
    0% {
        background-position: 100% 0;
    }
    100% {
        background-position: -100% 0;
    }
}
`;
document.head.appendChild(style);

document.addEventListener('DOMContentLoaded', function() {
    const dashboardCardsDiv = document.querySelector('.home2');
    if (!dashboardCardsDiv) return;

    const originalContent = dashboardCardsDiv.innerHTML;

    const skeletonHTML = `
        <div class="col-md-3">
            <div class="payslip-card mb-4" style="height: 195px;">
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 150px;"></p>
                
                <div class="row m-0" >
                    <div class="col-12 p-0">
                        <p class="payslip-small-desc mt-3 skeleton-loader" style="height: 20px; width: 90%;"></p>
                        <p class="payslip-small-desc mt-2 skeleton-loader" style="height: 20px; width: 80%;"></p>
                     </div>
                 </div>
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="payslip-card mb-4" style="height: 195px;">
                <div class="avatarImgDiv" style="display:flex; gap: 5px;">
                    <span class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></span>
                    <span class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></span>
                    <span class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></span>
                    <span class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></span>
                </div>
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 100px;"></p>
                <p class="payslip-small-desc skeleton-loader" style="height: 20px; width: 90%;"></p>
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="payslip-card mb-4" style="height: 195px;">
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 100px;"></p>
                <p class="payslip-small-desc skeleton-loader" style="height: 20px; width: 90%;"></p>
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="payslip-card mb-4" style="height: 195px;">
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 130px;"></p>
                <p class="payslip-small-desc skeleton-loader" style="height: 20px; width: 90%;"></p>
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                </div>
            </div>
        </div>
    `;

    dashboardCardsDiv.innerHTML = skeletonHTML;

    setTimeout(function() {
        dashboardCardsDiv.innerHTML = originalContent;
    }, 3000);
});

document.addEventListener('DOMContentLoaded', function() {
    const dashboardCardsDiv = document.querySelector('.home3');
    if (!dashboardCardsDiv) return;

    const originalContent = dashboardCardsDiv.innerHTML;

    const skeletonHTML = `
        <div class="col-md-3">
            <div class="payslip-card mb-4" style="height: 195px;">
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 150px;"></p>
                <div class="notify d-flex justify-content-between">
                    <p class="payslip-small-desc skeleton-loader" style="height: 40px; width: 80%;"></p>
                    <div  style="width: 40px; height: 40px;"></div>
                </div>
                <div class="leave-display d-flex align-items-center border-top pt-3 gap-3">
                    <div class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></div>
                    <div class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></div>
                    <div class="skeleton-loader" style="width: 40px; height: 40px; border-radius: 50%;"></div>
                </div>
                <a href="/employees-review">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="payslip-card mb-4" style="height: 195px;">
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 150px;"></p>
                <p class="payslip-small-desc skeleton-loader" style="height: 20px; width: 90%;"></p>
                <a href="/formdeclaration">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="payslip-card mb-3" style="height: 195px;">
                <p class="payslip-card-title skeleton-loader" style="height: 24px; width: 100px;"></p>
                <p class="payslip-small-desc skeleton-loader" style="height: 20px; width: 90%;"></p>
                <a href="#">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow skeleton-loader" style="width: 30px; height: 30px;"></div>
                    </div>
                </a>
            </div>
        </div>
    `;

    dashboardCardsDiv.innerHTML = skeletonHTML;

    setTimeout(function() {
        dashboardCardsDiv.innerHTML = originalContent;
    }, 3000);
});


