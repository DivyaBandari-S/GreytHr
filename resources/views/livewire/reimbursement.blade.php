<div>
<div class="row  m-0 p-0 d-flex justify-content-end ">
<div class="dropdown-reim p-3 " style="width:300px;">
    <button class="dropdown-button " onclick="toggleDropdown()" id="selectedItem" style="border-radius:5px;border:1px solid silver;background:white;position:relative;">01 Apr, 2021 - 31 Mar, 2022</button>
    <div class="dropdown-content-reim" id="myDropdown" style="position: absolute;display: none; font-size: 0.855rem;border-radius: 5px;background-color: #fff;min-width: 150px;box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1; margin-top:10px;">
        <div class="dropdown-item" onclick="selectItem('01 Apr, 2021 - 31 Mar, 2022')">01 Apr, 2021 - 31 Mar, 2022</div>
        <div class="dropdown-item" onclick="selectItem('01 Apr, 2022 - 31 Mar, 2023')">01 Apr, 2022 - 31 Mar, 2023</div>
        <div class="dropdown-item" onclick="selectItem('01 Apr, 2023 - 31 Mar, 2024')">01 Apr, 2023 - 31 Mar, 2024</div>
        <!-- Add more dropdown items here as needed -->
    </div>
</div>
</div>
<div class="p-3">
    <div class="col">
        <a href="#" style="text-decoration: none !important;color: blue !important;font-size: 14px;font-weight: 500;padding: 7px;border-bottom:2px solid blue;">Overview</a>
    </div>
</div>
<script>
    function selectItem(item) {
        document.getElementById('selectedItem').textContent = item;
        toggleDropdown();
        // Perform any other actions you need when an item is selected
    }

    function toggleDropdown() {
        var dropdownContent = document.getElementById("myDropdown");
        dropdownContent.style.display === "none" ? dropdownContent.style.display = "block" : dropdownContent.style.display = "none";
    }
</script>