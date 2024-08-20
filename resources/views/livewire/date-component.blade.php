<div>
    <div id="drp"
         class="form-control"
         style="background: #fff; cursor: pointer; padding: 3px 10px; border: 1px solid #ccc; width: 100%; height: 33px;"
         x-data="{start: $wire.start, end: $wire.end}"
         x-init="
            let startDate = moment(start || '{{ now()->startOfYear()->format('Y-m-d') }}');
            let endDate = moment(end || '{{ now()->endOfYear()->format('Y-m-d') }}');
            let drp = $('#drp').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                 minDate: moment().subtract(5, 'years'), 
                 maxDate: moment().add(5, 'years'), 
            }, function(s, e) {
                $('span', this.element).html(s.format('DD/MM/YYYY') + ' &rarr; ' + e.format('DD/MM/YYYY'));
                $wire.dispatch('update', [s.format('YYYY-MM-DD'), e.format('YYYY-MM-DD')]);
            });

            $('span', drp).html(startDate.format('DD/MM/YYYY') + ' &rarr; ' + endDate.format('DD/MM/YYYY'));
        ">
        <i class="fa fa-calendar" style="margin-right: 10px;"></i>&nbsp;
        <span style="font-size: 0.75rem;  margin-right: 5px;"></span> <i class="fa fa-caret-down"></i>
    </div>
</div>
