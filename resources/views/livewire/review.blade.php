<div>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Left Menu (Conditional)</title>
        <style>
            /* Add this CSS to your stylesheet or style tag */

            /* Container styles */
            .left-menu {
                width: 250px;
                background-color: #fff;
                padding-right: 30px;
                border-right: 1px solid #ccc; /* Add a vertical line to the right of the left menu */
            }

            /* Content styles */
            .content {
                padding: 20px;
            }
            #hidden-content {
                display: none; /* Initially hide the content */
            }
            .top-menu {
                width: 600px;

                background-color: #fff;
                padding-right: 30px;
                margin-bottom:120px;
           /* Add a vertical line to the right of the left menu */
            }
            .confirmation-modal {
          /* Add your styles here */
        }

        /* CSS for the like button */
        .like-button {
          display: flex;
          align-items: center;
          cursor: pointer;
          user-select: none;
        }

        .like-button .thumb-icon {
          margin-right: 5px;
          font-size: 16px;
        }
        .links:hover {
            color: #58DCE4;
            text-decoration:underline;
        }

        .comment-icon {
          -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
          tab-size: 4;
          -webkit-text-size-adjust: 100%;
          font-stretch: normal;
          letter-spacing: normal;
          text-align: left;
          color: #3b4452;
          visibility: inherit;
          --tw-bg-opacity: 1;
          --tw-border-opacity: 1;
          box-sizing: border-box;
          border: 0 solid;
          --tw-shadow: 0 0 transparent;
          --tw-ring-inset: var(--tw-empty,);
          --tw-ring-offset-width: 0px;
          --tw-ring-offset-color: #fff;
          --tw-ring-color: rgba(59,130,246,0.5);
          --tw-ring-offset-shadow: 0 0 transparent;
          --tw-ring-shadow: 0 0 transparent;
          cursor: pointer;
          font-size: 1.25rem;
          margin-right: 5px;
          padding-top: 5px;
          padding-bottom: 5px;
          font-weight: 400;
          font-style: normal;
          text-decoration: inherit;
          -webkit-font-smoothing: antialiased;
          font-family: Greytip;
          display: inline;
          width: auto;
          height: auto;
          line-height: normal;
          vertical-align: initial;
          background-image: none;
          background-position: 0 0;
          background-repeat: repeat;
          margin-top: 0;
        }

        /* Apply the CSS styles for the comment count text */
        .comment-count {
          -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
          tab-size: 4;
          -webkit-text-size-adjust: 100%;
          font-family: Open Sans, sans-serif;
          font-weight: 400;
          text-align: left;
          box-sizing: border-box;
          border: 0 solid;
          --tw-ring-offset-color: #fff;
          --tw-ring-color: rgba(59,130,246,0.5);
          --tw-ring-offset-shadow: 0 0 transparent;
          --tw-ring-shadow: 0 0 transparent;
          border-radius: .25rem;
          cursor: pointer;
          font-size: .75rem;
          line-height: 1rem;
          padding: 5px;
          --tw-text-opacity: 1;
          color: rgba(163,179,200,var(--tw-text-opacity));
        }
        .comment-icon {
          cursor: pointer;
        }

        .comment-box {
          display: none;
        }

        .comments {
          margin-top: 10px;
        }
        /* Define the default and active styles for the buttons */
    .btn-group.ng-star-inserted .btn {
        background-color: transparent;
        color: #3b4452;
        border: none;
        cursor: pointer;
    }

    .btn-group.ng-star-inserted .btn.active {
        background-color: #007BFF;
        color: #fff;
    }

        </style>
    </head>
    <body>
        <div class="content">

                    <div class="btn-group ng-star-inserted" style="border:1px solid silver;margin-left:250px">
                        <button class="btn btn-default active" id="activeButton">Active</button>
                        <button class="btn btn-default" id="closedButton">Closed</button>
                    </div>

                    <div class="form-group" style="margin-left:90px;margin-top:10px;display:flex">

                    <label class="form-label" style="width:200px" >selected date</label>
                    <input type="date" name="fromDate" class="form-control" style="height:30px;width:350px;margin-left:20px">
                    <input _ngcontent-esc-c352="" autocomplete="off" placeholder="Search Employee" name="searchKey" typeaheadoptionfield="name" typeaheadwaitms="300" class="form-control text-overflow ng-untouched ng-pristine ng-valid" aria-aria-expanded="false" aria-autocomplete="list" style="height:30px;margin-left:10px">
                </div>
                <div class="container" style="width:700px;height:320px;border:1px solid silver;border-radius:5px;margin-top:10px;background:white;">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/web-development-4019513-3324663.png" style="height:150px;width:250px;margin-left:200px;margin-top:50px">
                <div>
                <p style="color:silver;margin-left:200px">No Review Items for Restricted Holiday</p>
    </div>
    </div>
            </div>

    </body>
    <script>
        // Get references to the buttons
    const activeButton = document.getElementById('activeButton');
    const closedButton = document.getElementById('closedButton');

    // Add click event listeners to the buttons
    activeButton.addEventListener('click', function () {
        // Add the 'active' class to the clicked button and remove it from the other button
        activeButton.classList.add('active');
        closedButton.classList.remove('active');
    });

    closedButton.addEventListener('click', function () {
        // Add the 'active' class to the clicked button and remove it from the other button
        closedButton.classList.add('active');
        activeButton.classList.remove('active');
    });
    const calendarIcon = document.getElementById('calendarIcon');
            const dateInput = document.querySelector('.date-input');

            calendarIcon.addEventListener('click', () => {
                dateInput.click(); // Trigger the date input when the calendar icon is clicked
            });

        </script>
        </body>
    </html>
