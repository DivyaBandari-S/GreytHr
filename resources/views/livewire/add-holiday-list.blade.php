<div class="w-50 p-3 bg-white border rounded" style="margin: 0 auto;">
    <form wire:submit.prevent="saveHoliday">
        <div class="form-group">
            <label for="day">Day :</label>
            <input type="text" class="form-control" id="day" wire:model="day">
            @error('day') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" class="form-control" id="date" wire:model="date">
            @error('date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="month">Month :</label>
            <select class="form-control" id="month" wire:model="month">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                @endforeach
            </select>
            @error('month') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="year">Year :</label>
            <select class="form-control" id="year" wire:model="year">
                @php
                    $currentYear = date('Y');
                    $endYear = $currentYear + 2;
                @endphp
                @for ($y = $currentYear; $y <= $endYear; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
            @error('year') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="festivals">Festivals :</label>
            <textarea class="form-control" id="festivals" rows="3" wire:model="festivals"></textarea>
            @error('festivals') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
