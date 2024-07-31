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
            border-radius: 5px;
            /* Adjust the height as needed */
            /* Adjust the padding as needed */
            padding: 12px;
            font-size: 12px;
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
            border: 1px solid red;
            border-radius: 4px;
            /* margin-right: 15px;
min-height: 102px;
width: 170px; */
        }

        .insight-card {
            border: 1px solid #ccc;
            border-radius: 5px;
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

        .legendtext {
            color: #778899;
            font-size: 12px;
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

            /* Adjust the width of the Date column as needed */
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
            color: white;


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

            /* background-color: #f0f0f0; */


            /* margin-left: 850px; */
            /* margin-top: -40px; */
            /* padding: 5.5px 6px; */
            /* Adjust padding as needed */
        }


        .toggle-box-attendance-info i {
            color: grey;
            /* Set the icon color */
            background-color: pink;
            /* Set the background color for icons */
            padding: 6px 6px;
            /* Set padding for icons */
            margin-right: 0px;
            /* Add spacing between icons if desired */
        }

        .toggle-box-attendance-info i.fas.fa-calendar {
            /* Initial icon color */
            /* Initial background color for icon */
            padding: 10px 10px;
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
            padding: 10px 10px;
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

        .attendance-legend-text {
            white-space: nowrap;
            font-size: 12px;
            color: #778899;
        }
    </style>
    @php
    $flag=0;
    $flag1=0;
    $leave=0;
    $todayDate = date('Y-m-d');

    @endphp

    <div>
        <div class="row m-0" style="text-align: end;">
            <div class="col-md-12">
                <a href="/regularisation" class="btn btn-primary mb-3 my-button-attendance-info" id="myButton">My Regularisations</a>
            </div>
        </div>

        <div class="row m-0 d-flex justify-content-center" style="text-align: center;">
            <div class="col-md-4">
                <div class="row m-0 topMsg-attendance-info d-flex align-items-center">

                    <div class="col-8 p-0">
                        <!-- Small box with the text -->
                        <div style="white-space:nowrap;text-align:center;margin-left:30px;">Access card details not available</div>

                    </div>

                    <!-- Blue info icon on the right -->
                    <div class="info-icon-container-attendance-info col-4">

                        <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:25px;font-size: 14px; color: blue;"></i>
                        <div class="info-box-attendance-info">
                            Contact administrator to get access card assigned.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="row m-0 mt-3">
            <div class="row m-0 d-flex justify-content-center" style="display:flex;justify-content:center;">
                <div class="col-md-3">
                    <div class="insight-card  bg-white pt-2 pb-2" style="height: 135px;">
                        <h6 class="text-secondary text-regular text-center" style="font-size:12px;border-bottom:1px solid #ccc;padding-bottom:5px;"> Penalty Days </h6>
                        <section class="text-center">
                            <p class="text-2" style="margin-top:30px;"> 0 </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="insight-card bg-white pt-2 pb-2">
                        <h6 class="text-secondary text-regular text-center" style="font-size:12px;border-bottom:1px solid #ccc;padding-bottom:5px;">
                            Avg.&nbsp;Actual&nbsp;Work&nbsp;Hrs</h6>
                        <section class="text-center">

                            <p class="text-2" style="margin-top:30px;">02:00</p>
                            <div>
                                <span class="text-success ng-star-inserted" style="font-size:10px;"> +233%
                                </span>
                                <span class="text-muted" style="font-size:10px;margin-left:0px;"> From August </span>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="insight-card bg-white pt-2 pb-2">
                        <h6 class="text-secondary text-regular text-center" style="font-size:12px;border-bottom:1px solid #ccc;padding-bottom:5px;">Avg. Work Hrs
                        </h6>
                        <section class="text-center">
                            <p class="text-2" style="margin-top:30px;">02:00</p>
                            <div>
                                <span _ngcontent-hbw-c670="" class="text-success ng-star-inserted" style="font-size:10px;">
                                    +233% </span>
                                <span _ngcontent-hbw-c670="" class="text-muted" style="font-size:10px;"> From August
                                </span>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-md-2 mt-5" style="text-align: center">
                    <a href="#" data-toggle="modal" data-target="#exampleModalCenter" style="text-transform:uppercase;margin-top:40px;color:rgb(2, 17, 79);">
                        +3 Insights
                    </a>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">




                <div class="modal-dialog custom-modal-lg centered-modal custom-modal" role="document">
                    <div class="modal-content">

                        <div class="modal-header" style="background-color: #eceff3;">

                            <h6 class="modal-title" id="exampleModalLabel">
                                {{$modalTitle}}
                            </h6>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true close-btn">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row" style="display: flex; justify-content: flex-end;">
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="fromDate" style="color: #778899; font-size: 12px; font-weight: 500;">From
                                        date</label>
                                    <input type="date" class="form-control" id="fromDate" wire:model="from_date" name="fromDate" wire:change="calculateTotalDays" style="color: #778899;">
                                </div>
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="toDate" style="color: #778899; font-size: 12px; font-weight: 500;">To
                                        date</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate" wire:model="to_date" wire:change="calculateTotalDays" style="color: #778899;">
                                </div>
                            </div>
                            <p style="font-size:12px;">Total Working Days:&nbsp;&nbsp;<span style="font-weight:bold;">{{$totalDays}}</span></p>

                            <div class="table-responsive">
                                <!-- <div class="chart-value"><span style="font-weight:bold;">0</span></div>
                                <div class="chart-column">AVG.&nbsp;WORK&nbsp;HRS</div>
                                <div class="chart-value"><span style="font-weight:bold;">-</span></div>
                                <div class="chart-column">AVG.&nbsp;ACTUAL&nbsp;WORK&nbsp;HRS</div>
                                <div class="chart-value"><span style="font-weight:bold;">0</span></div>
                                <div class="chart-column">PENALTY&nbsp;DAYS</div>
                                <div class="chart-value"><span style="font-weight:bold;">-</span></div>
                                <div class="chart-column">LATE&nbsp;IN</div>
                                <div class="chart-value"><span style="font-weight:bold;">-</span></div>
                                <div class="chart-column">EARLY&nbsp;OUT</div>
                                <div class="chart-value"><span style="font-weight:bold;">-</span></div>
                                <div class="chart-column">LEAVE&nbsp;TAKEN</div>
                                <div class="chart-value"><span style="font-weight:bold;">-</span></div>
                                <div class="chart-column">ABSENT&nbsp;DAYS</div>
                                <div class="chart-value"><span style="font-weight:bold;">-</span></div>
                                <div class="chart-column">EXCEPTION&nbsp;DAYS</div> -->

                                <table class="table" style="width: 100%;">
                                    <thead style="font-size: 12px;">
                                        <tr>
                                            <th scope="col">AVG. WORK HRS</th>
                                            <th scope="col">AVG. ACTUAL WORK HRS</th>
                                            <th scope="col">PENALTY DAYS</th>
                                            <th scope="col">LATE IN</th>
                                            <th scope="col">EARLY OUT</th>
                                            <th scope="col">LEAVE TAKEN</th>
                                            <th scope="col">ABSENT DAYS</th>
                                            <th scope="col">EXCEPTION DAYS</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size:12px;color:black;font-weight:500;">
                                        <tr>
                                            <td style="text-align: center;">0</td>
                                            <td style="text-align: center;">-</td>
                                            <td style="text-align: center;">0</td>
                                            <td style="text-align: center;">{{$avgLateIn}}</td>
                                            <td style="text-align: center;">{{$avgEarlyOut}}</td>
                                            <td style="text-align: center;">-</td>
                                            <td style="text-align: center;">-</td>
                                            <td style="text-align: center;">-</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="row m-0 mt-3">
                                <div class="col-md-3 col-sm-6 p-0">
                                    <p style="font-size:12px;color:#778899;">Avg First In Time:&nbsp;&nbsp;<span style="font-weight:600;color:black;">{{$avgSignInTime}}</span></p>
                                </div>
                                <div class="col-md-3 col-sm-6 p-0">
                                    <p style="font-size:12px;color:#778899;">Avg Last Out Time:&nbsp;&nbsp;<span style="font-weight:600;color:black;">{{$avgSignOutTime}}</span></p>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <div class="row m-0 mt-3">
                <div class="col-6" style="text-align: left">
                    <a href="#" id="toggleSidebar" class="gt-overlay-toggle" style="margin-top:69px;color:rgb(2, 17, 79); display: none">Legend</a>
                </div>
                <div class="col-6" style="text-align: -webkit-right;">
                    <div class="toggle-box-attendance-info">
                        <i class="fas fa-calendar" id="calendar-icon" style="cursor:pointer;padding:2px 2px;color: {{ ($defaultfaCalendar == 1 )? '#fff' : 'rgb(2,17,79)' }};background-color: {{ ($defaultfaCalendar == 1 )? 'rgb(2,17,79)' : '#fff' }}" wire:click="showBars"></i>
                        <i class="fas fa-bars" id="bars-icon" style="cursor:pointer;padding:2px 2px;color: {{ ($defaultfaCalendar == 0 )? '#fff' : 'rgb(2,17,79)' }};background-color: {{ ($defaultfaCalendar == 0 )? 'rgb(2,17,79)' : '#fff' }}" wire:click="showTable"></i>
                    </div>
                </div>
            </div>






            @php

            $presentCount = 0;
            $offCount = 0;
            $absentCount=0;
            $holidayCount = 0;
            $Regularised=false;
            @endphp




            <div class="row m-0 p-0">
                @if($defaultfaCalendar==1)
                <div class="col-md-7 m-0 p-1 custom-scrollbar">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="calendar-heading-container">
                            <button wire:click="beforeMonth" class="nav-btn">&lt; Prev</button>
                            <p style="font-size: 14px;color:black;font-weight:500;margin-bottom:0;">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</p>
                            <button wire:click="nextMonth" class="nav-btn">Next &gt;</button>
                        </div>
                    </div>
                    <!-- Calendar -->
                    <div>
                        <table class="table-1 table-bordered">
                            <thead class="calender-header bg-white">
                                <tr>
                                    <th class="text">Sun</th>
                                    <th class="text">Mon</th>
                                    <th class="text">Tue</th>
                                    <th class="text">Wed</th>
                                    <th class="text">Thu</th>
                                    <th class="text">Fri</th>
                                    <th class="text">Sat</th>
                                </tr>
                            </thead>
                            <tbody id="calendar-body">
                                @if(!empty($calendar))
                                @foreach($calendar as $week)
                                <tr>
                                    @foreach($week as $day)
                                    @php
                                    $carbonDate = \Carbon\Carbon::createFromDate($year, $month, $day['day']);

                                    $formattedDate = $carbonDate->format('Y-m-d');
                                    $formattedDate1 = $carbonDate->format('Y-m-d');
                                    $isCurrentMonth = $day['isCurrentMonth'];
                                    $isWeekend = in_array($carbonDate->dayOfWeek, [0, 6]); // 0 for Sunday, 6 for Saturday
                                    $isActiveDate = ($selectedDate === $carbonDate->toDateString());
                                    @endphp


                                    @if ($day)
                                    @if(strtotime($formattedDate) < strtotime(date('Y-m-d'))) @php $flag=1; @endphp @else @php $flag=0; @endphp @endif @if($day['status']=='CLP' ||$day['status']=='SL' ||$day['status']=='LOP' ) @php $leave=1; @endphp @else @php $leave=0; @endphp @endif <td wire:click="dateClicked('{{$formattedDate}}')" wire:model="dateclicked" class="attendance-calendar-date {{ $isCurrentMonth && !$isWeekend ? 'clickable-date' : '' }}" style="text-align:start;color: {{ $isCurrentMonth ? ($isWeekend ? '#c5cdd4' : 'black')  : '#c5cdd4'}};background-color:  @if($isCurrentMonth && !$isWeekend && $flag==1 ) @if($day['isPublicHoliday'] ) #f3faff @elseif($leave == 1) rgb(252, 242, 255) @elseif($day['status'] == 'A') #fcf0f0 @elseif($day['status'] == 'P') #edfaed @endif @elseif($isCurrentMonth && $isWeekend && $flag==1)rgb(247, 247, 247) @endif ;">
                                        <div>


                                            @if ($day['isToday'])
                                            <div style="background-color: #007bff; color: white; border-radius: 50%; width: 24px; height: 24px; text-align: center; line-height: 24px;">
                                                {{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                            @else
                                            {{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}
                                            @endif


                                            <div class="{{ $isWeekend ? '' : 'circle-grey' }}">
                                                <!-- Render your grey circle -->
                                                @if ($isWeekend&&$isCurrentMonth)
                                                <i class="fas fa-tv" style="float:right;padding-left:8px;margin-top:-15px;"></i>

                                                <span style="text-align:center;color: #7f8fa4; padding-left:21px;padding-right:26px;margin-left: 6px;white-space: nowrap;">
                                                    O
                                                </span>
                                                @elseif($isCurrentMonth)


                                                @if(strtotime($formattedDate) < strtotime(date('Y-m-d'))) <span style="display: flex; justify-content: center; align-items: center; width: 20px; height: 20px; border-radius: 50%; white-space: nowrap;">

                                                    @if($day['isPublicHoliday'])
                                                    <span style="background-color: #f3faff;text-align:center;color: #7f8fa4; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">H</span>
                                                    @elseif($day['status'] == 'CLP')
                                                    <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">CLP</span>
                                                    @elseif($day['status'] == 'SL')
                                                    <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">SL</span>
                                                    @elseif($day['status'] == 'LOP')
                                                    <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">LOP</span>
                                                    @elseif($day['status'] == 'A')
                                                    <span style="color:#ff6666; background-color: #fcf0f0;text-align:center;padding-left:30px;margin-left: 37px;white-space: nowrap;padding-top:5px">A</span>
                                                    @elseif($day['status'] == 'P')
                                                    <span style="background-color:#edfaed; text-align:center; color: #7f8fa4; padding-left:30px; margin-left: 37px;white-space: nowrap;padding-top:10px">P</span>
                                                    @endif


                                                    </span>
                                                    @endif
                                                    @if($day['isRegularised']==true)
                                                    @php
                                                    $Regularised=true;
                                                    @endphp
                                                    <span style="display:flex;text-align:start;width:10px;height:10px;border-radius:50%;padding-right: 10px; margin-right:25px;">
                                                        <p class="me-2 mb-0">
                                                        <div class="down-arrow-reg"></div>
                                                        </p>
                                                    </span>
                                                    @endif
                                                    @if(strtotime($formattedDate) >= strtotime(date('Y-m-d')))
                                                    <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px; margin-right:12px;white-space: nowrap;">
                                                        <p style="color: #a3b2c7;margin-top:30px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                    </span>
                                                    @elseif($isCurrentMonth)
                                                    <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px;margin-right:20px; white-space: nowrap;">
                                                        <p style="color: #a3b2c7;margin-top:15px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                    </span>
                                                    @endif
                                                    @endif
                                            </div>
                                        </div>
                                        @endif
                                        </td>

                                        @endforeach
                                </tr>
                                @endforeach
                                
                            </tbody>

                        </table>
                        @else
                        <p>No calendar data available</p>
                        @endif
                    </div>

                    <button class="accordion">Legends</button>
                    <div class="panel">
                        <div class="row m-0 mt-3 mb-3">
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon presentIcon">P</span>
                                </p>
                                <p class="legendtext m-0">Present</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon absentIcon">A</span>
                                </p>
                                <p class="legendtext m-0">Absent</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon offDayIcon">O</span>
                                </p>
                                <p class="legendtext m-0">Off Day</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon offDayIcon">R</span>
                                </p>
                                <p class="legendtext m-0">Rest Day</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon leaveIcon">L</span>
                                </p>
                                <p class="legendtext m-0">Leave</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon onDutyIcon">OD</span>
                                </p>
                                <p class="legendtext m-0">On Duty</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon holidayIcon">H</span>
                                </p>
                                <p class="legendtext m-0">Holiday</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon deductionIcon">&nbsp;&nbsp;</span>
                                </p>
                                <p class="legendtext m-0" style="word-break: break-all;"> Deduction</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon alertForDeIcon">&nbsp;&nbsp;</span>
                                </p>
                                <p class="legendtext m-0">Allert for Deduction</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <span class="legendsIcon absentIcon">?</span>
                                </p>
                                <p class="legendtext m-0">Status Unknown</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <i class="far fa-clock"></i>
                                </p>
                                <p class="legendtext m-0">Overtime</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                    <i class="far fa-edit"></i>
                                </p>
                                <p class="legendtext m-0">Override</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                <div class="down-arrow-ign-attendance-info"></div>
                                </p>
                                <p class="legendtext m-0">Ignored</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                <div class="down-arrow-gra"></div>
                                </p>
                                <p class="legendtext m-0">Grace</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="me-2 mb-0">
                                <div class="down-arrow-reg"></div>
                                </p>
                                <p class="legendtext m-0">Regularized</p>
                            </div>
                        </div>
                        <div class="row m-0 mb-3">
                            <h6 class="m-0 p-2 mb-2" style="background-color: #f1f4f7">Day Type</h6>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="mb-0">
                                    <i class="fas fa-mug-hot"></i>
                                </p>
                                <p class="m-1 attendance-legend-text">Rest Day</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="mb-0">
                                    <i class="fas fa-tv"></i>
                                </p>
                                <p class="m-1 attendance-legend-text">Off Day</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="mb-0">
                                    <i class="fas fa-umbrella"></i>
                                </p>
                                <p class="m-1 attendance-legend-text">Holiday</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="mb-0">
                                    <i class="fas fa-calendar-day"></i>
                                </p>
                                <p class="m-1 attendance-legend-text">Half Day</p>
                            </div>
                            <div class="col-md-3 mb-2 pe-0" style="display: flex">
                                <p class="mb-0">
                                    <i class="fas fa-battery-empty"></i>
                                </p>
                                <p class="m-1 attendance-legend-text">IT Maintanance</p>
                            </div>
                        </div>
                    </div>

                </div>
                @endif
                @if($defaultfaCalendar==0)
                @livewire('attendance-table')

                @endif
                <div class="col-md-5">
                    @if($defaultfaCalendar==1)
                    <div class="container1" style="background-color:white;">
                        <!-- Content goes here -->
                        <div class="row m-0">
                            <div class="col-2 pb-1 pt-1 p-0" style="border-right: 1px solid #ccc; text-align: center;">
                                <p class="mb-1" style="font-weight:bold;font-size:14px;color:#778899;">{{ \Carbon\Carbon::parse($CurrentDate)->format('d') }}</p>
                                <p class="m-0" style="font-weight:600;font-size:12px;color:#778899;">
                                    {{ \Carbon\Carbon::parse($CurrentDate)->format('D') }}
                                </p>
                            </div>
                            <div class="col-5 pb-1 pt-1">

                                <p class="text-overflow mb-1" style="font-size:12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;font-weight: 500;">
                                    10:00 am to 07:00 pm</p>
                                <p class="text-muted m-0" style="font-size:12px;">Shift:10:00 to
                                    19:00</p>
                            </div>
                            <div class="col-5 pb-1 pt-1">
                                <p class="mb-1" style="font-size:12px;overflow: hidden;font-weight: 500;text-overflow: ellipsis;white-space: nowrap;font-weight: 500;">
                                    10:00 am to 07:00 pm</p>
                                <p class="text-muted m-0" style="font-size:12px;">Attendance
                                    Scheme</p>

                            </div>
                        </div>


                        <div class="horizontal-line-attendance-info"></div>
                        @if($ChangeDate==1)
                        @php
                        $nextDayDate = \Carbon\Carbon::parse($CurrentDate)->addDay()->setTime(0, 0, 0);
                        @endphp
                        <div class="text-muted" style="margin-left:20px;font-weight: 400;font-size: 12px;">Processed On {{ $nextDayDate->format('jS M') }}</div>
                        @else
                        <div class="text-muted" style="margin-left:20px;font-weight: 400;font-size: 12px;">Processed On</div>
                        @endif
                        <div class="horizontal-line1-attendance-info"></div>
                        <div style=" overflow-x: auto; max-width: 100%;">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="font-weight:normal;font-size:12px;">First&nbsp;In</th>
                                        <th style="font-weight:normal;font-size:12px;">Last&nbsp;Out</th>
                                        <th style="font-weight:normal;font-size:12px;">Total&nbsp;Work&nbsp;Hrs</th>
                                        <th style="font-weight:normal;font-size:12px;">Break&nbsp;Hrs</th>
                                        <th style="font-weight:normal;font-size:12px;">Actual&nbsp;Work&nbsp;Hrs</th>
                                        <th style="font-weight:normal;font-size:12px;">
                                            Work&nbsp;Hours&nbsp;in&nbsp;Shift&nbsp;Time</th>
                                        <th style="font-weight:normal;font-size:12px;">Shortfall&nbsp;Hrs</th>
                                        <th style="font-weight:normal;font-size:12px;">Excess&nbsp;Hrs</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <tr>

                                        <td style="font-size:12px;">
                                            @if($ChangeDate==1)
                                            {{$this->first_in_time}}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td style="font-size:12px;">
                                            @if($ChangeDate==1)
                                            {{$this->last_out_time}}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>
                                            @if($this->first_in_time!=$this->last_out_time)
                                            {{str_pad($this->hours, 2, '0', STR_PAD_LEFT)}}:{{str_pad($this->minutesFormatted,2,'0',STR_PAD_LEFT)}}
                                            @else
                                            -
                                            @endif

                                        </td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{$this->work_hrs_in_shift_time}}</td>
                                        <td>{{$this->shortFallHrs}}</td>
                                        <td>-</td>

                                    </tr>


                                    <!-- Add more rows with dashes as needed -->
                                </tbody>
                                <!-- Add table rows (tbody) and data here if needed -->
                            </table>

                        </div>
                    </div>
                    @endif
                    @if($defaultfaCalendar==1)
                    <div class="container2">
                        <h3 style="padding-left:10px;margin-top:10px;color: #7f8fa4;font-size:14px;">Status Details</h3>

                        <div style=" overflow-x: auto; max-width: 100%;">
                            <table style="margin-top:-10px;">
                                <thead>
                                    <tr>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;">Status</th>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;">Remarks</th>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                        @php
                                             

                                               $CurrentDate = \Carbon\Carbon::now()->toDateString();
                                               $swiperecord = App\Models\SwipeRecord::where('emp_id', $employeeId)->get(); // Example query

                                                if ($swiperecord && is_iterable($swiperecord)) {
                                                    $swipeRecordExists = $swiperecord->contains(function ($record) use ($CurrentDate) {
                                                        return \Carbon\Carbon::parse($record->created_at)->toDateString() === $CurrentDate;
                                                    });
                                                } else {
                                                    $swipeRecordExists = false;
                                                }
                                            @endphp
                                            @if($swipeRecordExists==true)
                                            Regularisation
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>-</td>
                                        @if($swipeRecordExists==true)
                                        <td>
                                            <button type="button" style="font-size:12px;background-color:transparent;color:#24a7f8;border:none;text-decoration:underline;" wire:click="checkDateInRegularisationEntries('{{$CurrentDate}}')">
                                                Info
                                            </button>
                                            @if($showRegularisationDialog==true)

                                            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header" style="background-color: #eef7fa; height: 50px">
                                                            <h5 style="padding: 5px; color: #778899; font-size: 15px;" class="modal-title"><b>Regularisation&nbsp;&nbsp;Details</b></h5>
                                                            <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeRegularisationModal" style="background-color: white; height:10px;width:10px;">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                                            <div class="row m-0 mt-3">

                                                                <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Status : <br /><span style="color: #000000;">Regularization</span></div>
                                                                <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Regularized By: <br /><span style="color: #000000;">{{ucwords(strtolower($regularised_by))}}</span></div>
                                                            </div>
                                                            <div class="row m-0 mt-3">
                                                                <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Regularized Date : <br /><span style="color: #000000;">{{ date('jS M,Y', strtotime($regularised_date)) }}</span></div>
                                                                <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Regularized Time: <br /><span style="color: #000000;">{{ date('H:i:s', strtotime($regularised_date)) }}</span></div>
                                                            </div>
                                                            <div class="row m-0 mt-3">
                                                                <div class="col" style="font-size: 11px;color:#778899;font-weight:500;"> Reason:<br /> <span style="color: #000000;">{{$regularised_reason}}</span></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-backdrop fade show blurred-backdrop"></div>

                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    <!-- Add more rows with dashes as needed -->
                                </tbody>
                                <!-- Add table rows (tbody) and data here if needed -->
                            </table>
                        </div>
                    </div>
                    @endif
                    @if($defaultfaCalendar==1)
                    <div class="container3">
                        <h3 style="padding-left:10px;margin-top:20px;color: #7f8fa4;font-size:14px;">Session Details</h3>

                        <div style=" overflow-x: auto; max-width: 100%;">
                            <table style="margin-top:-10px">
                                <thead>
                                    <tr>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;">Session</th>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;">Session&nbsp;Timing</th>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;">First&nbsp;In</th>
                                        <th style="font-weight:normal;font-size:12px;padding-top:16px;">Last&nbsp;Out</th>

                                    </tr>
                                </thead>

                                <tbody>

                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td style="font-weight:normal;font-size:12px;">Session&nbsp;1</td>
                                        <td style="font-weight:normal;font-size:12px;">10:00 - 14:00</td>
                                        <td style="font-weight:normal;font-size:12px;">
                                            @if($ChangeDate==1)
                                            {{$this->first_in_time}}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td style="font-weight:normal;font-size:12px;">-</td>

                                    </tr>
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td style="font-weight:normal;font-size:12px;">Session&nbsp;2</td>
                                        <td style="font-weight:normal;font-size:12px;">14:01 - 19:00</td>
                                        <td style="font-weight:normal;font-size:12px;">-</td>
                                        <td style="font-weight:normal;font-size:12px;">
                                            @if($ChangeDate==1)
                                            {{$this->last_out_time}}
                                            @else
                                            -
                                            @endif
                                        </td>

                                    </tr>
                                    <!-- Add more rows with dashes as needed -->
                                </tbody>
                                <!-- Add table rows (tbody) and data here if needed -->
                            </table>
                        </div>

                    </div>
                    @endif
                    @if($defaultfaCalendar==1)
                    <div class="container6">
                        <h3 style="margin-left:20px;color: #7f8fa4;font-size:14px;margin-top:15px;align-items:center;">Swipe Details</h3>
                        <div class="arrow-button" style="float:right;margin-top:-30px;margin-right:20px;" id="toggleButton">
                        </div>

                        <div class="container-body" style="margin-top:2px;height:auto;" id="myContainerBody">
                            <!-- Content of the container body -->
                            <div style="max-width: 100%; text-align: center;">

                                <table>
                                    <thead>
                                        @if ($swipe_records_count > 0)
                                        <tr>
                                            <th style="font-weight:normal;font-size:12px;">In/Out</th>
                                            <th style="font-weight:normal;font-size:12px;">Swipe&nbsp;Time</th>
                                            <th style="font-weight:normal;font-size:12px;">Location</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($Swiperecords as $index =>$swiperecord)
                                        <tr>
                                            <td style="font-weight:normal;font-size:12px;">{{ $swiperecord->in_or_out }}</td>
                                            <td>
                                                <div style="display:flex;flex-direction:column;">
                                                    <p style="margin-bottom: 0;font-weight:normal;font-size:12px;white-space:nowrap;">
                                                        {{ date('h:i:s A', strtotime($swiperecord->swipe_time)) }}
                                                    </p>
                                                    <p style="margin-bottom: 0;font-size: 10px;color: #a3b2c7;">
                                                        {{ date('d M Y', strtotime($currentDate1)) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>-</td>

                                            <td><button class="info-button" style="background-color:#007bff; border: 2px solid #007bff;height:20px; color: white; border-radius: 5px;font-size:12px;margin-top:-10px" wire:click="viewDetails('{{$swiperecord->id}}')">Info</button></td>

                                        </tr>
                                        @if (($index + 1) % 2 == 0)
                                        <!-- Add a small container after every two records -->
                                        <tr>
                                            <td colspan="4" style="height:1px; background-color: #f0f0f0; text-align: left;font-size:10px;">
                                                Actual Hrs:{{ $actualHours[($index + 1) / 2 - 1] }}</td>
                                        </tr>
                                       
                                        @endif  
                                        @endforeach



                                        <!-- Add more rows with dashes as needed -->
                                    </tbody>
                                    <!-- Add table rows (tbody) and data here if needed -->
                                    @else
                                    <img src="https://linckia.cdn.greytip.com/static-ess-v6.3.0-prod-1543/attendace_swipe_empty.svg" style="margin-top:30px;">
                                    <div class="text-muted">No record Found</div>
                                    @endif
                                </table>

                            </div>

                        </div>
                        @endif
                        @if($showSR=="true")
                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #eef7fa; height: 50px">
                                        <h5 style="padding: 5px; color: #778899; font-size: 15px;" class="modal-title"><b>Swipe Details</b></h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeSWIPESR" style="background-color: #eef7fa; height:10px;width:10px;">
                                        </button>
                                    </div>
                                    <div class="modal-body" style="max-height:300px;">
                                        @if($swiperecord)
                                        <div class="row m-0 mt-3">

                                            @if ($data->isNotEmpty())
                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Employee&nbsp;Name:<br /><span style="color: #000000;">{{ $data[0]->first_name }} {{ $data[0]->last_name }}</span></div>
                                            @endif
                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Employee&nbsp;Id<br /><span style="color: #000000;">{{ $swiperecord->emp_id }}</span></div>

                                        </div>
                                        <div class="row m-0 mt-3">


                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Swipe&nbsp;Date:<br /><span style="color: #000000;">{{\Carbon\Carbon::parse($swiperecord->created_at)->format('jS F, Y')}}</span></div>

                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Swipe&nbsp;Time:<br /><span style="color: #000000;">{{ $view_student_swipe_time }}</span></div>

                                        </div>
                                        <div class="row m-0 mt-3">


                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">In/Out:<br /><span style="color: #000000;">{{ $view_student_in_or_out }}</span></div>

                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Access&nbsp;Card&nbsp;Number:<br /><span style="color: #000000;">-</span></div>

                                        </div>
                                        <div class="row m-0 mt-3">



                                            <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Location<br /><span style="color: #000000;">-</span></div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                        @endif

                    </div>
                </div>
            </div>



        </div>










        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }

            // September 2023
        </script>
        <script>
            document.getElementById("toggleButton").addEventListener("click", function() {
                var containerBody = document.getElementById("myContainerBody");
                if (containerBody.style.display === "none" || containerBody.style.display === "") {
                    containerBody.style.display = "block";
                } else {
                    containerBody.style.display = "none";
                }
            });
        </script>
        <script>
            const toggleButton = document.getElementById("toggleButton");
            const containerBody = document.getElementById("myContainerBody");

            toggleButton.addEventListener("click", function() {
                toggleButton.classList.toggle("rotate-arrow");
            });
        </script>

        <script>
            document.getElementById("myButton").onclick = function() {
                // Replace 'destination-page.html' with the URL of the page you want to navigate to
                window.location.href = 'das.html';
            };
        </script>



        <script>
            $(document).ready(function() {
                $('.toggle-box i.fas.fa-calendar').click(function() {
                    // Toggle the 'active' class on the calendar icon
                    $(this).toggleClass('active');

                    // Reset the bars icon to its initial styles
                    $('.toggle-box i.fas.fa-bars').removeClass('active');
                });

                $('.toggle-box i.fas.fa-bars').click(function() {
                    // Toggle the 'active' class on the bars icon
                    $(this).toggleClass('active');

                    // Reset the calendar icon to its initial styles
                    $('.toggle-box i.fas.fa-calendar').removeClass('active');
                });
            });
        </script>
        <script>
            function toggleBoxContainer() {
                const boxContainer = document.getElementById('box-container');
                if (boxContainer.style.display === 'none') {
                    boxContainer.style.display = 'block';
                } else {
                    boxContainer.style.display = 'none';
                }
            }

            function hideBoxContainer() {
                const boxContainer = document.getElementById('box-container');
                boxContainer.style.display = 'none';
            }

            // Event listener for the bars-icon click event
            const barsIcon = document.getElementById('bars-icon');
            barsIcon.addEventListener('click', toggleBoxContainer);

            // Event listener for the calendar-icon click event (to hide the box-container)
            const calendarIcon = document.getElementById('calendar-icon');
            calendarIcon.addEventListener('click', hideBoxContainer);
        </script>

        <script>
            $(document).ready(function() {
                $('.attendance-calendar-date').click(function() {
                    // Remove the 'clicked' class from all elements
                    $('.attendance-calendar-date').removeClass('clicked');

                    // Add the 'clicked' class to the clicked element
                    $(this).addClass('clicked');
                });
            });
        </script>



    </div>