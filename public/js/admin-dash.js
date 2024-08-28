// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');

allDropdown.forEach(item=> {
	const a = item.parentElement.querySelector('a:first-child');
	a.addEventListener('click', function (e) {
		e.preventDefault();

		if(!this.classList.contains('active')) {
			allDropdown.forEach(i=> {
				const aLink = i.parentElement.querySelector('a:first-child');

				aLink.classList.remove('active');
				i.classList.remove('show');
			})
		}

		this.classList.toggle('active');
		item.classList.toggle('show');
	})
})

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
document.addEventListener("DOMContentLoaded", function() {
	var currentPath = window.location.pathname;
	var links = document.querySelectorAll('a:first-child');

	links.forEach(function(link) {
		link.classList.remove('active-side-dropdown');
		if (link.getAttribute("href") === currentPath) {
			link.classList.add('active-side-dropdown');
			// link.parentNode.classList.add('active-side-dropdown');
		}
	});

	// Adding active class for dropdown parents
    var dropdownLinks = document.querySelectorAll('.side-dropdown a');

    dropdownLinks.forEach(function(link) {
        if (link.getAttribute("href") === currentPath) {
            var parentLink = link.closest('ul').previousElementSibling;
            if (parentLink) {
                parentLink.classList.add('active-side-dropdown');
                // parentLink.parentNode.classList.add('active-side-dropdown');
            }
        }
    });
});




// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if(sidebar.classList.contains('hide')) {
	allSideDivider.forEach(item=> {
		item.textContent = '-'
	})
	allDropdown.forEach(item=> {
		const a = item.parentElement.querySelector('a:first-child');
		a.classList.remove('active');
		item.classList.remove('show');
	})
} else {
	allSideDivider.forEach(item=> {
		item.textContent = item.dataset.text;
	})
}

toggleSidebar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
	const mainContent = document.getElementById('maincontent');

	if(sidebar.classList.contains('hide')) {
		mainContent.classList.add('active');
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})

		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
	} else {
		mainContent.classList.remove('active');
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




sidebar.addEventListener('mouseleave', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})
	}
})



sidebar.addEventListener('mouseenter', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




// PROFILE DROPDOWN
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
// const imgProfile2 = document.getElementsByClassName('brandLogoDiv');
const dropdownProfile = profile.querySelector('.profile-link');

// imgProfile2.addEventListener('click', function () {
// 	dropdownProfile.classList.toggle('show');
// })

function openProfile () {
	const profile = document.querySelector('nav .profile');
	const dropdownProfile = profile.querySelector('.profile-link');
	dropdownProfile.classList.toggle('show');
}




// MENU
const allMenu = document.querySelectorAll('main .content-data .head .menu');

allMenu.forEach(item=> {
	const icon = item.querySelector('.icon');
	const menuLink = item.querySelector('.menu-link');

	icon.addEventListener('click', function () {
		menuLink.classList.toggle('show');
	})
})



window.addEventListener('click', function (e) {
	// if(e.target !== imgProfile) {
	// 	if(e.target !== dropdownProfile) {
	// 		if(dropdownProfile.classList.contains('show')) {
	// 			dropdownProfile.classList.remove('show');
	// 		}
	// 	}
	// }

	allMenu.forEach(item=> {
		const icon = item.querySelector('.icon');
		const menuLink = item.querySelector('.menu-link');

		if(e.target !== icon) {
			if(e.target !== menuLink) {
				if (menuLink.classList.contains('show')) {
					menuLink.classList.remove('show')
				}
			}
		}
	})
})





// PROGRESSBAR
const allProgress = document.querySelectorAll('main .card .progress');

allProgress.forEach(item=> {
	item.style.setProperty('--value', item.dataset.value)
})






// APEXCHART
var options = {
  series: [{
  name: 'series1',
  data: [31, 40, 28, 51, 42, 109, 100]
}, {
  name: 'series2',
  data: [11, 32, 45, 32, 34, 52, 41]
}],
  chart: {
  height: 350,
  type: 'area'
},
dataLabels: {
  enabled: false
},
stroke: {
  curve: 'smooth'
},
xaxis: {
  type: 'datetime',
  categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
},
tooltip: {
  x: {
    format: 'dd/MM/yy HH:mm'
  },
},
};

// var chart = new ApexCharts(document.querySelector("#chart"), options);
// chart.render();