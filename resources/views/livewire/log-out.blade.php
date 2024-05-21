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
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            top: 3  0px;
            margin-left:-30px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .logout-icon-container:hover i {
            color: orange;
        }

        .logout-icon-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        .tooltip {
            margin-left: 10px;
            color: orange;
        }
    </style>

    <div class="logout-icon-container">
        <i wire:click="handleLogout" class="fas fa-sign-out-alt"></i>
        <div class="tooltip">Logout</div>
    </div>
</div>