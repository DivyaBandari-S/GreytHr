<div>
    <style>
        .logout-icon-container {
            display: inline-block;
            position: relative;
        }

        /* Style the logout icon */
        .logout-icon-container i {
            color: #fff;
            font-size: 15px;
            transition: color 0.3s ease;
        }

        /* Style the tooltip */
        .logout-icon-container .tooltip {
            visibility: hidden;
            width: 90px;
            background-color: #333;
            color: orange;
            /* Set default color to red */
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            top: 3  0px;
            /* Position the tooltip below the icon */
          margin-left:-30px;
            /* Center the tooltip horizontally */
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Show the tooltip on hover */
        .logout-icon-container:hover i {
            color: orange;
            /* Change the color on hover to red */
        }

        .logout-icon-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        .tooltip {
            margin-left: 10px;
            color: orange;
            /* Adjust the margin to move the tooltip to the right */
        }
    </style>

    <div class="logout-icon-container">
        <i wire:click="handleLogout" class="fas fa-sign-out-alt"></i>
        <div class="tooltip">Logout</div>
    </div>
    <script src="{{ asset('vendor/livewire/livewire.js') }}" defer></script>
</div>