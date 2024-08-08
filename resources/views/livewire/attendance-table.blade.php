<div>
    <style>
        .date-range-container12-attendance-info {
            margin-right: 62px;
        }

        .custom-scrollbar {
            overflow-y: scroll;
            overflow-x: hidden;
            padding-right: 10px;
            max-height: 600px;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            margin-right: 15px;

        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #888;
            margin-left: 15px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .my-button-attendance-info {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            border-color: rgb(2, 17, 79);
            background: rgb(2, 17, 79);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;

        }

        .my-button-attendance-info:hover {
            /* Styles for hover state */
            text-decoration: none;
            background-color: #24a7f8 !important;
            color: #fff !important;
            /* Remove underline on hover */
        }

        .my-button-attendance-info:active {
            /* Styles for active/clicked state */
            text-decoration: none;
            /* Remove underline when clicked */
        }

        .topMsg-attendance-info {
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 14px;
            background-color: #FFFFFF;
        }

        .container-attendance-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 500px;
            /* Adjust the total width as needed */
            height: 40px;
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* Border style for the container */
            padding: 10px;
            /* Padding inside the container */
            font-size: 14px;
            margin-left: 170px;
            margin-bottom: -100px;
            background-color: #FFFFFF;
            /* Font size for the text */
        }

        .insight-card[_ngcontent-hbw-c670] {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            /* margin-right: 15px;
min-height: 102px;
width: 170px; */
        }

        .insight-card[_ngcontent-hbw-c670] h6[_ngcontent-hbw-c670] {
            border-bottom: 1px solid #cbd5e1;
            margin: 0;
            padding: 7px 20px;
            text-transform: uppercase;
        }

        .text-regular {
            font-weight: 400;
        }

        .text {
            color: #000;
        }

        .arrow-icon-attendance-info {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 5px;
            /* Adjust the margin as needed */
        }

        .arrow-icon-attendance-info::after {
            content: '\2192';
            /* Unicode right arrow character */
            margin-left: 5px;
            /* Adjust the margin as needed */
        }

        .text-secondary {
            color: #7f8fa4;
        }

        .text-center {
            text-align: center;
        }

        .info-icon-container-attendance-info {
            position: relative;
            display: inline-block;
        }

        .info-icon-attendance-info {
            font-size: 14px;
            color: blue;
        }

        .info-box-attendance-info {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            color: #fff;
            transform: translateX(-50%);
            background-color: #808080;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            Z-index: 1
        }

        .info-icon-container-attendance-info:hover .info-box-attendance-info {
            display: block;
        }

        .text-2 {
            font-size: 18px;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
        }

        .text-success {
            color: #5bc67e;
        }

        .text-muted {
            color: #a3b2c7;
        }

        a {
            color: #24a7f8;
        }

        .text-5 {
            font-size: 12px;
            margin-top: 50px;
            margin-bottom: 0;
        }

        .btn-group {
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }

        .btn-group>.btn:first-child:not(:last-child):not(.dropdown-toggle) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .btn-group .btn.icon-btn {
            min-width: 30px;
            padding: 0;
        }

        .btn-group .btn.active {
            background-color: #24a7f8;
            border: 1px solid #24a7f8;
            color: #fff;
        }

        .btn-group>.btn:first-child {
            margin-left: 0;
        }

        [_nghost-exg-c673] .details[_ngcontent-exg-c673] {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
        }

        .calendar-attendance-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* width: 700px;
    margin-left: 20px;
    margin-top: 10px; */
        }

        .large-box-attendance-info {
            max-width: 900px;
            height: 220px;
            margin: 0 auto;

            margin-left: 10px;
            margin-top: 10px;
            border: 1px solid #cbd5e1;


        }

        /* Month header */
        .calendar-header-attendance-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }


        #calendar-icon-attendance-info {
            border-top-left-radius: 5px;
            /* Adjust the value as needed */
            border-bottom-left-radius: 5px;
            /* Adjust the value as needed */
        }

        #bars-icon-attendance-info {
            border-top-right-radius: 5px;
            /* Adjust the value as needed */
            border-bottom-right-radius: 5px;
            /* Adjust the value as needed */
        }

        .calendar-weekdays-attendance-info {
            display: flex;
            justify-content: space-around;
            color: #02114f;
            gap: 5px;
            padding: 5px 10px;
            /* margin-bottom: 10px; */
            border: 1px solid #dedede;
        }

        .container-leave {
            padding: 0;
            margin: 0;
        }

        .table thead {
            border: none;
        }

        .table th {
            text-align: center;
            height: 15px;
            border: none;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            font-weight: normal;
            color: #778899;
        }

        .table td:hover {
            background-color: #ecf7fe;
            /* Hover background color */
            cursor: pointer;
        }

        /* Add styles for the navigation buttons */
        .nav-btn {
            background: none;
            border: none;
            color: #778899;
            font-size: 12px;
            margin-top: -6px;
            cursor: pointer;
        }

        .nav-btn:hover {
            color: blue;
        }

        /* Increase the size of tbody cells and align text to top-left */
        .table-1 tbody td {
            width: 75px;
            height: 80px;
            border-color: #c5cdd4;
            font-weight: 500;
            font-size: 13px;
            /* Adjust font size as needed */
            vertical-align: top;
            position: relative;
            text-align: left;
        }

        .table-1 thead {
            border: none;
        }

        .table-1 th {
            text-align: center;
            /* Center days of the week */
            height: 15px;
            border: none;
            color: #778899;
            font-size: 12px;
        }

        .table-1 {
            overflow-x: hidden;
        }

        /* Add style for the current date cell */
        .current-date {
            background-color: #ff0000;
            /* Highlight color for the current date */
            color: #fff;
            /* Text color for the current date */
            font-weight: bold;
        }

        .calendar-heading-container {
            background: #fff;
            padding: 10px 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            /* Add spacing between heading and icons */
        }

        .calendar-heading-container h5 {
            font-size: 0.975rem;
            color: black;
            font-weight: 500;
        }

        .table {
            overflow-x: hidden;
            /* Add horizontal scrolling if the table overflows the container */
        }

        .tol-calendar-legend {
            display: flex;
            font-size: 0.875rem;
            width: 100%;
            justify-content: space-between;
            font-weight: 500;
            color: #778899;
        }

        /* CSS for legend circles */
        .legend-circle {
            display: inline-block;
            width: 15px;
            /* Adjust the width as needed */
            height: 15px;
            /* Adjust the height as needed */
            border-radius: 50%;
            text-align: center;
            line-height: 15px;
            /* Vertically center the text */
            margin-right: 2px;
            /* Add some spacing between the circle and text */
            font-weight: bold;
            /* Make the text bold */
            color: white;
            /* Text color */
        }

        .circle-pale-yellow {
            background-color: #ffeb3b;
            /* Define the yellow color */
        }

        /* CSS for the pink circle */
        .circle-pale-pink {
            background-color: #d29be1;
            /* Define the pink color */
        }

        .accordion {
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            /* Adjust the width as needed */
            top: 100px;
            overflow-x: auto;
            left: 0;
            /* Adjust the top position as needed */
            /* Adjust the right position as needed */
        }

        .accordion-heading {
            background-color: #fff;
            cursor: pointer;
        }

        .accordion-body {
            background-color: #fff;
            padding: 0;
            display: block;
            width: 100%;
            overflow: auto;
        }

        .accordion-content {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .accordion-title {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .active .leave-container {
            border-color: #3a9efd;
            /* Blue border when active */
        }

        .accordion-button {
            color: #DCDCDC;
            border: 1px solid #DCDCDC;
        }

        .active .accordion-button {
            color: #3a9efd;
            border: 1px solid #3a9efd;
        }

        @media (max-width: 760px) {


            .accordion {
                width: 65%;
                top: auto;
                right: auto;
                margin-top: 20px;
            }
        }

        .centered-modal {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Calendar days */
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            /* gap: 5px; */
            justify-items: center;
            padding: 0px;
        }

        .calendar-date {
            width: 100%;
            height: 4em;
            font-weight: normal;
            font-size: 12px;
            /* border-radius: 50%; */
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* padding: 14px; */
        }



        .attendance-calendar-date:hover {
            background-color: #f3faff;
        }

        .attendance-calendar-date.clicked {
            background-color: #f3faff;
            border-color: blue;
            border: 2px solid #24a7f8;

        }

        .clickable-date:active {
            background-color: #f3faff;
            /* Set the desired background color when clicked */
            border: 1px solid #c5cdd4;
            /* Set the desired border color */
        }

        .clickable-date1 {
            background-color: pink;
            /* Set the desired background color when clicked */
            /* Set the desired border color */
        }

        .calendar-day {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: white;
        }

        #prevMonth,
        #nextMonth {
            /* background-color: rgb(2, 17, 79);
    color: white; */
            border: none;
            padding: 2px 5px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;

        }

        #currentMonth {
            font-size: 12px;
            margin: 0;
        }

        .today {
            background-color: rgb(2, 17, 79);
            color: white;
        }

        /* Today's date */
        .calendar-day.today {
            background-color: #0099cc;
            color: white;
        }

        .container1 {
            /* width: 600px;  */
            /* height: 200px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 15px;
            /* margin-top: 420px; */
            border-radius: 10px;
            /* float: right; */
            border: 1px solid #ccc;
        }

        .container2 {
            /* width: 600px;
    /* Adjust the width as needed */
            /* height: 140px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 40px;
            border-radius: 10px;
            /* padding-bottom: -70px; */
            /* float: right; */
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* Border style for the container */
        }

        .container1,
        .container2,
        .container3,
        .container6 {
            display: block;
        }

        .container6 {
            /* width: 600px; */
            /* Adjust the width as needed */
            /* height: 45px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 30px;
            border-radius: 10px;
            /* float: right; */
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* Border style for the container */
        }

        .container-body {
            /* width: 600px; */
            /* Adjust the width as needed */
            /* height: 105px; */
            /* margin-right: 0px; */
            /* margin-bottom: 30px; */
            background-color: #FFFFFF;
            border-radius: 10px;
            display: none;
            /* border-radius:10px; */
            /* float: right; */
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
        }

        /* Basic styles for the input container */
        .date-range-container {
            display: flex;
            align-items: center;
            width: 300px;
            /* Adjust the width as needed */
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-left: 198px;

            margin-top: -80px;
        }

        .chart-range-container {
            display: flex;
            align-items: center;
            /* width: 600px; */
            /* Adjust the width as needed */
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            /* margin-left: -98px; */
            overflow-x: auto;
            height: 120px;
            /* margin-top: 40px; */
        }

        /* Style for the calendar icon */
        .calendar-icon {
            margin-right: 10px;
            color: #888;
        }

        /* Style for the input field */
        .date-range-input {
            border: none;
            outline: none;
            width: 100%;
        }

        .container3 {
            /* width: 600px; */
            /* Adjust the width as needed */
            /* height: 180px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 30px;
            border-radius: 10px;
            /* float: right; */
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* Border style for the container */
        }

        /* CSS for the table */
        .large-box-attendance-info {
            width: 100%;
            overflow-x: auto;
        }

        .second-header-row th.date {
            background-color: #ebf5ff;
            color: #778899;
            /* Adjust the width of the Date column as needed */
        }

        .second-header-row th.date {

            /* Adjust the width of the Date column as needed */
        }

        .scrollable-container {
            overflow-x: auto;
            /* Enables horizontal scrolling */
            white-space: nowrap;
            /* Prevents the text from wrapping */
            padding: 10px;
            /* Adds some padding */
            border: 1px solid #ddd;
            /* Optional: Adds a border */
            background-color: #f9f9f9;
            /* Optional: Adds a background color */
            height: auto;
        }

        .second-header-row th:not(.date) {

            /* Adjust the width of the Shift and Shift Timings columns as needed */
        }

        .large-box-attendance-info table {

            max-width: 100%;
            margin-top: -20px;
            table-layout: fixed;
            /* Fix the table layout */
            width: auto;
            /* Set the table to an appropriate width or it will expand to the container's full width */
            white-space: nowrap;
            /* Prevent table cell content from wrapping */
            border-collapse: collapse;

        }

        .large-box-attendance-info td {
            padding: 10px;


        }

        .date {

            border-bottom: 1px solid #cbd5e1;
            margin-left: 10px;

        }

        .large-box-attendance-info {

            height: 200px;
        }

        .large-box-attendance-info th {
            background-color: rgb(2, 17, 79);
            color: white;
            width: 600px;
            /* Adjust the width as needed */
            padding-right: 50px;
        }

        /* CSS for the second header row */
        .large-box-attendance-info .second-header-row {

            background-color: rgb(2, 17, 79);
            color: white;
        }

        .large-box-attendance-info .third-header-row {

            color: black;
        }

        .large-box-attendance-info .first-header-row {
            background-color: rgb(2, 17, 79);
            color: #778899;


        }

        .large-box-attendance-info .fourth-header-row {
            background-color: #fff;
            color: black;
        }

        .vertical-line-attendance-info {
            border-left: 1px solid black;
            /* Adjust the width and color as needed */
            /* Adjust the height as needed */
            margin-top: -68px;
            height: 70px;
            padding: 0;
            margin-left: 70px;
        }


        .chart-column-attendance-info {
            flex: 1;
            /* Distribute available space equally among columns */
            padding: 70px;
            margin-top: -40px;
            text-align: center;
            border-right: 1px solid #ccc;
        }

        /* Remove the right border for the last column */
        .chart-column-attendance-info:last-child {
            border-right: none;
            margin-top: -40px;
        }

        .horizontal-line-attendance-info {
            width: 100%;
            /* Set the width to the desired value */
            border-top: 1px solid #ccc;
            /* You can adjust the color and thickness */
            margin: 0px 0;
            /* Adjust the margin as needed */
        }


        .horizontal-line2-attendance-info {
            width: 100%;
            /* Set the width to the desired value */
            border-top: 1px solid #000;
            /* You can adjust the color and thickness */
            margin: -10px 0;
            /* Adjust the margin as needed */
        }

        table {
            border-collapse: collapse;
            width: 100%;

        }

        /* CSS for the table header (thead) */
        thead {
            background-color: #eef7fa;
            color: #778899;
            border-top: 1px solid #ccc;
        }

        /* CSS for the table header cells (th) */
        th {
            padding: 10px;
            text-align: left;
        }

        td {
            /* Add borders to separate cells */
            padding: 10px;
            text-align: left;
        }

        .toggle-box-attendance-info {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;

            width: 73px;
            /* margin-left: 850px; */
            /* margin-top: -40px; */
            padding: 5.5px 6px;
            /* Adjust padding as needed */
        }


        .toggle-box-attendance-info i {
            color: grey;
            /* Set the icon color */
            background-color: white;
            /* Set the background color for icons */
            padding: 7px 7px;
            /* Set padding for icons */
            margin-right: 0px;
            /* Add spacing between icons if desired */
        }

        .toggle-box-attendance-info i.fas.fa-calendar {
            /* Initial icon color */
            /* Initial background color for icon */
            padding: 7px 7px;
            /* Initial padding for icon */
            margin-right: 0px;
            /* Initial spacing between icons */
            border: 2px solid transparent;

            /* Initial border color (transparent) */
        }


        .toggle-box-attendance-info i.fas.fa-calendar:hover {
            color: rgb(2, 17, 79);
            /* Icon color on hover */
            /* Background color for icon on hover */
            border-color: rgb(2, 17, 79);
            /* Border color on hover */
        }

        .toggle-box-attendance-info i.fas.fa-bars {
            color: grey;
            /* Initial icon color */
            /* Initial background color for icon */
            padding: 7px 7px;
            /* Initial padding for icon */
            margin-right: 0px;
            /* Initial spacing between icons */
            border: 2px solid transparent;
            /* Initial border color (transparent) */
        }

        .toggle-box-attendance-info i.fas.fa-bars:hover {
            color: rgb(2, 17, 79);
            /* Icon color on hover */
            /* Background color for icon on hover */
            border-color: rgb(2, 17, 79);
            /* Border color on hover */
        }

        .toggle-box-attendance-info i.fas.fa-calendar.active {
            color: white;
            /* Icon color when active (clicked) */
            background-color: rgb(2, 17, 79);
            /* Background color when active (clicked) */
        }

        .toggle-box-attendance-info i.fas.fa-bars.active {
            color: white;
            /* Icon color when active (clicked) */
            background-color: rgb(2, 17, 79);
            /* Background color when active (clicked) */
        }

        .box-attendance-info {
            width: 160px;
            height: 30px;
            /* You can change the border color here */
            text-align: center;
            display: inline-block;
            margin-top: 14px;
            margin-left: 8px;


        }





        .custom-modal .modal-header {
            padding: 10px;
            background-color: #e9edf1;
            /* Decrease header padding */
        }

        .date-picker-container {
            position: relative;
            display: none;

        }

        .date-input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .calendar-icon1 {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #calendar4 {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
        }

        #calendar4 .calendar {
            display: inline-block;
            margin: 10px;
        }


        /* .custom-modal .modal-body {
    padding: 100px;
} */

        /* CSS for the icons */
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }

        /* Style for the row container */


        /* Style for individual values */

        /* Style for individual values */
        .chart-value {
            flex: 1;
            /* Distribute available space equally among values */
            text-align: center;
            margin-top: 40px;
            padding: 10px;


        }

        .chart-column-attendance-info>div {
            margin: 0 auto;
        }

        /* CSS for the lines icon */
        .lines-icon::before {
            content: "\2630";
            background-color: white;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 7px;
            margin-left: -10px;
            /* Unicode character for the three lines icon */
        }

        .rotate-arrow {
            transform: rotate(90deg);
            transition: transform 0.3s ease;
            /* Add a smooth transition effect */
        }

        /* CSS for the calendar icon */
        .calendar-icon::before {
            content: "\1F4C5";
            background-color: white;
            /* Add a blue background color */
            color: white;
            /* Set the text color to white */
            padding-top: 5px;
            padding-right: 6px;
            padding-bottom: 6px;
            /* Add padding for spacing */
            /* Unicode character for the calendar icon */
        }

        .arrow-button::after {
            content: "\25B6";
            /* Unicode character for right-pointing triangle (arrow) */
            font-size: 18px;

        }

        .modal-box-attendance-info {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            /* Adjust as needed for spacing */
        }

        .attendance-calendar-date {
            cursor: pointer;
            padding: 3px;
            margin: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }


        .custom-modal-lg {
            max-width: 90%;

        }

        .modal-content-attendance-info {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .fa-info-circle:hover {
            text-decoration: underline;
        }

        .circle.IRIS {
            background-color: #d29be1;
        }

        .container11 {
            display: flex;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            /* Initially, hide the sidebar off-screen */
            width: 250px;
            height: 100%;
            background-color: #fff;
            color: #fff;
            transition: right 0.3s ease-in-out;
        }

        .close-sidebar {
            margin-left: 205px;
            margin-bottom: -50px;
        }

        .content {
            margin-right: 20px;

        }

        /* Existing styles for sidebar */


        /* Styles for sidebar header */
        .sidebar .sidebar-header {
            background-color: #e9edf1;
            padding: 10px;
            text-align: center;
        }

        .sidebar .sidebar-header h2 {
            color: #7f8fa4;
            font-size: 24px;
            margin: 0;
        }

        .sidebar-content h3 {
            color: #7f8fa4;
            margin-left: 30px;
        }

        .sidebar-content p {
            color: #7f8fa4;
            font-size: 12px;
            margin-left: 30px;
        }

        /* Hover styles */

        .text-overflow {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .accordion {
            background-color: #dae0f7;
            color: #444;
            cursor: pointer;
            padding: 21px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            margin-top: 10px;
            border: 1px solid #cecece;
        }

        /* .active, .accordion:hover {
background-color: #02114f;
color: #fff;
} */

        .panel {
            /* padding: 0 18px; */
            display: none;
            background-color: white;
            overflow: hidden;
            border: 1px solid #cecece;
            font-size: 14px;
        }

        .accordion:after {
            content: '\02795';
            /* Unicode character for "plus" sign (+) */
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2796";
            /* Unicode character for "minus" sign (-) */
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
        }

        .presentIcon {
            background-color: #edfaed;
        }

        .absentIcon {
            background-color: #fcf0f0;
            color: #ff6666;
        }

        .offDayIcon {
            background-color: #f7f7f7;
        }

        .leaveIcon {
            background-color: #fcf2ff;
        }

        .onDutyIcon {
            background-color: #fff7eb;
        }

        .holidayIcon {
            background-color: #f2feff;
        }

        .alertForDeIcon {
            background-color: #edf3ff;
        }

        .deductionIcon {
            background-color: #fcd2ca;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #f09541;
            margin-right: 5px;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ign-attendance-info {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #677a8e;
            margin-right: 5px;
        }

        .emptyday {
            color: #aeadad;
            pointer-events: none;
        }

        .scrollable-table {
            display: block;
            max-height: 400px;
            /* Adjust as needed */
            overflow-y: auto;
            border: 1px solid #cbd5e1;
        }

        .info-button {
            background-color: transparent;
            color: rgb(2, 17, 79);
            font-size: 12px;
            font-weight: 500;
            margin-top: -10px;
            border: none;
            cursor: pointer;
            padding: 0;
            text-decoration: none;
        }

        .info-button:hover {
            text-decoration: underline;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #f09541;
            margin-right: 5px;
        }
    </style>
    @php
    $currentYear = date('Y');
    $currentMonth=date('n');
    $currentMonthRep=date('F');
    $holidayNote=false;
    $currentMonthRep = DateTime::createFromFormat('F', $currentMonthRep)->format('M');
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    @endphp

    <div class="m-auto">
        <div class="table-container scrollable-table" style=" width: 100%;
    overflow-x: auto;">
            <table>
                <tr class="first-header-row" style="background-color:#ebf5ff;border-bottom: 1px solid #cbd5e1;">
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px; position: relative;color:#778899;border-right:1px solid #cbd5e1;">General&nbsp;Details</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="font-weight:normal;font-size:12px;padding-top:16px;color:#778899;">Session&nbsp;1<i class="fa fa-caret-{{ $this->moveCaretLeftSession1 ? 'left' : 'right' }}" style="cursor:pointer;" wire:click="toggleCaretDirectionForSession1"></i></th>
                    @if($this->moveCaretLeftSession1==true)
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    @endif
                    <th style="font-weight:normal;font-size:12px;padding-top:16px;color:#778899;">Session&nbsp;2<i class="fa fa-caret-{{ $this->moveCaretLeftSession2 ? 'left' : 'right' }}" style="cursor:pointer;" wire:click="toggleCaretDirectionForSession2"></i></th>
                    @if($this->moveCaretLeftSession2==true)
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    @endif


                </tr>
                <tr class="second-header-row" style="border-bottom: 1px solid #cbd5e1;">
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;border-right:1px solid #cbd5e1;">Date</th>

                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Shift</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Attendance&nbsp;Scheme</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">First&nbsp;In</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Last&nbsp;Out</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Work&nbsp;Hrs</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Actual&nbsp;Hrs</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Status</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Swipe&nbsp;Details</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Exception</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Shortfall/Excess&nbsp;Hrs.</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Shift&nbsp;Timings</th>
                    @if($this->moveCaretLeftSession1==true)
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Start&nbsp;Time</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Late&nbsp;In</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">End&nbsp;Time</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Early&nbsp;Out</th>
                    @endif
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Shift&nbsp;Timings</th>
                    @if($this->moveCaretLeftSession2==true)
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Start&nbsp;Time</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Late&nbsp;In</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">End&nbsp;Time</th>
                    <th class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Early&nbsp;Out</th>
                    @endif

                </tr>

                @for($i = 1; $i <= $daysInMonth; $i++) @php $dateKey=str_pad($i, 2, '0' , STR_PAD_LEFT) . " " . $currentMonthRep . " " . $currentYear; $dateKeyForLookup=$currentYear . '-' .str_pad($currentMonth, 2, '0' , STR_PAD_LEFT) . '-' . str_pad($i, 2, '0' , STR_PAD_LEFT); if (in_array($dateKeyForLookup, $holiday)) { $holidayNote=true; } $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); $dayName=date('D', $timestamp); $isWeekend=($dayName=='Sat' || $dayName=='Sun' ); $isPresent=$distinctDates->has($dateKeyForLookup);
                    $isDate=($dateKeyForLookup<$todaysDate); $swipeRecordExists=$swiperecord->contains(function ($record) use ($dateKeyForLookup) {
                        return \Carbon\Carbon::parse($record->created_at)->toDateString() === $dateKeyForLookup;
                        });
                        @endphp

                        <tr style="border-bottom: 1px solid #cbd5e1;background-color:{{$isDate? ( $isWeekend ? '#f8f8f8' : ($holidayNote ? '#f3faff' : ($isPresent|| $swipeRecordExists?  '#edfaed':'#fcf0f0'))) :'white'}};">


                            <td class="date" style="font-weight:normal;font-size:12px;padding-top:16px;border-right:1px solid #cbd5e1;">
                                <p style="white-space:nowrap;">
                                    {{str_pad($i, 2, '0', STR_PAD_LEFT) }}&nbsp;&nbsp;{{$currentMonthRep}}&nbsp;{{$currentYear}}({{$dayName}})
                                    @if($swipeRecordExists==true)
                                <div class="down-arrow-reg"></div>
                                @endif
                                </p>
                            </td>

                            <td style="font-weight:normal;font-size:12px;padding-top:16px;white-space:nowrap;">10:(GS)</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;white-space:nowrap;">10:00 Am to 07:00Pm</td>


                            @if($distinctDates->has($dateKeyForLookup))
                            @php
                            $record = $distinctDates[$dateKeyForLookup];
                            $firstInTimestamp = strtotime($record['first_in_time']);
                            $lastOutTimestamp = strtotime($record['last_out_time']);
                            // Calculate difference in seconds
                            $differenceInSeconds = $lastOutTimestamp - $firstInTimestamp;
                            // Calculate hours and minutes
                            $hours = floor($differenceInSeconds / 3600);
                            $minutes = floor(($differenceInSeconds % 3600) / 60);
                            @endphp

                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">

                                {{ date('H:i', strtotime($record['first_in_time'])) }}

                            </td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">
                                @if(empty($record['last_out_time']))
                                @php
                                $record['last_out_time']=$record['first_in_time'];
                                @endphp
                                {{ date('H:i', strtotime($record['last_out_time'])) }}
                                @else
                                {{ date('H:i', strtotime($record['last_out_time'])) }}
                                @endif
                            </td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">
                                @if($record['first_in_time']==$record['last_out_time'])
                                00:00
                                @else
                                {{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}
                                @endif
                            </td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">
                                @if($record['first_in_time']==$record['last_out_time'])
                                00:00
                                @else
                                {{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}
                                @endif
                            </td>
                            @else
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            @endif




                            <td style="margin-left:10px; margin-top:20px; font-size:12px;color: {{ $isDate ? ($isWeekend ? 'black' : ($holidayNote ? 'black' : ($distinctDates->has($dateKeyForLookup) ? 'black' : '#ff6666')) ):'black'}}">
                                @if($isDate==true)
                                @if($isWeekend==true)
                                O
                                @elseif($holidayNote==true)
                                H
                                @elseif($distinctDates->has($dateKeyForLookup))
                                P

                                @else
                                A
                                @endif
                                @else
                                -
                                @endif
                            </td>

                            <td>
                                <button type="button" style="font-size:12px;background-color:transparent;color:#24a7f8;border:none;text-decoration:underline;" wire:click="viewDetails('{{$dateKeyForLookup}}')">
                                    Info
                                </button>
                            </td>

                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">No&nbsp;attention&nbsp;required</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">-</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">10:00-14:00</td>
                            @if($this->moveCaretLeftSession1==true)
                            @if($distinctDates->has($dateKeyForLookup))
                            @php
                            $record = $distinctDates[$dateKeyForLookup];
                            $firstInTime = \Carbon\Carbon::parse($record['first_in_time']);
                            $lateArrivalTime = $firstInTime->diff(\Carbon\Carbon::parse('10:00'))->format('%H:%I');
                            $isLateBy10AM = $firstInTime->format('H:i') > '10:00';
                            @endphp
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">{{ date('H:i', strtotime($record['first_in_time'])) }}</td>
                            @if($isLateBy10AM)
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">{{$lateArrivalTime}}</td>
                            @else
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            @endif
                            @else
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            @endif

                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>

                            @endif
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">14:01-19:00</td>
                            @if($this->moveCaretLeftSession2==true)


                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            @if($distinctDates->has($dateKeyForLookup))
                            @php
                            $record = $distinctDates[$dateKeyForLookup];
                            $firstInTime = \Carbon\Carbon::parse($record['last_out_time']);
                            $lateArrivalTime = $firstInTime->diff(\Carbon\Carbon::parse('19:00'))->format('%H:%I');
                            $isEarlyBy07PM = $firstInTime->format('H:i') < '19:00' ; @endphp @if(empty($record['last_out_time'])) @php $record['last_out_time']=$record['first_in_time']; $firstInTime=\Carbon\Carbon::parse($record['last_out_time']); $lateArrivalTime=$firstInTime->diff(\Carbon\Carbon::parse('19:00'))->format('%H:%I');
                                $isEarlyBy07PM = $firstInTime->format('H:i') < '19:00' ; @endphp <td style="font-weight:normal;font-size:12px;padding-top:16px;">{{ date('H:i', strtotime($record['last_out_time'])) }}</td>
                                    @else
                                    <td style="font-weight:normal;font-size:12px;padding-top:16px;">{{ date('H:i', strtotime($record['last_out_time'])) }}</td>
                                    @endif
                                    @if($isEarlyBy07PM)
                                    <td style="font-weight:normal;font-size:12px;padding-top:16px;">{{$lateArrivalTime}}</td>
                                    @else
                                    <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                                    @endif

                                    @else
                                    <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                                    <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                                    @endif
                                    @endif
                                    @php
                                    $holidayNote=false;
                                    @endphp
                        </tr>

                        @endfor


                        <tr style="border-bottom: 1px solid #cbd5e1;background-color:white;">
                            <td class="date" style="font-weight:normal;font-size:12px;padding-top:16px;">Total </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="font-weight:normal;font-size:12px;padding-top:16px;">00:00</td>
                            <td></td>
                            @if($this->moveCaretLeftSession1==true)
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                            <td></td>
                            @if($this->moveCaretLeftSession2==true)
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>

        </div>
        @if ($showAlertDialog)
    @php
    $formattedDate = \Carbon\Carbon::parse($date)->format('d M');
    @endphp
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Swipes</b></h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="row">
                        <div class="col" style="font-size: 12px;color:#778899;font-weight:500;">Date : <span style="color: #333;">$currentDate </span></div>
                        <div class="col" style="font-size: 12px;color:#778899;font-weight:500;">Shift Time : <span style="color: #333;">10:00 to 19:00</span></div>
                    </div>
                    <table class="swipes-table mt-2 border" style="width: 100%;">
                        <tr style="background-color: #f6fbfc;">
                            <th style="width:50%;font-size: 12px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;">Swipe Time</th>
                            <th style="width:50%;font-size: 12px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;">Sign-In / Sign-Out</th>
                        </tr>

                      
                            <tr style="border:1px solid #ccc;">
                                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px"> $swipe->swipe_time </td>
                                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px"> $swipe->in_or_out </td>
                            </tr>
                        
                            <tr>
                                <td class="homeText" colspan="2">No swipe records found for today.</td>
                            </tr>
                       

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
@endif

    </div>
    
</div>