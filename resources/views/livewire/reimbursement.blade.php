<div>
    <div class="row  m-0 p-0 d-flex justify-content-end ">
        <form method="GET" action="" class="m-0" style="width: fit-content;">
            <select name="financial_year" id="financial_year" class="form-control" wire:model="selectedFinancialYear" wire:change='SelectedFinancialYear' style=" width: fit-content;">
                @foreach ($financialYears as $year)
                <option value="{{ $year['start_date'] }}|{{ $year['end_date'] }}">
                {{ \Carbon\Carbon::parse($year['start_date'])->format('d M, Y') }} - {{ \Carbon\Carbon::parse($year['end_date'])->format('d M, Y') }}
                </option>
                @endforeach
            </select>
        </form>
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
</div>
