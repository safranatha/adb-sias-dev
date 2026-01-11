<div class="">
    <flux:heading size="lg" class="bg-green-50 p-3 text-accent-content text-center">Rekap Tender</flux:heading>
    <div class="flex items-center justify-center">
    <div class="w-120 h-120 mt-5 mb-5">
        <canvas id="tenderChart"></canvas>
    </div>
</div>

</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', initChart);
    document.addEventListener('DOMContentLoaded', initChart);

    function initChart() {
        const ctx = document.getElementById('tenderChart');
        if (!ctx) return;

        // Hindari double render
        if (ctx.chart) {
            ctx.chart.destroy();
        }

        ctx.chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah',
                    data: @json($values),
                    backgroundColor: [
                        '#B31919',
                        '#057A55',
                        '#C97E04',
                                 
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    
                    legend: {
                        display:true,
                        position:'right',
                    }
                },
                maintainAspectRatio: true,
                aspectRatio:2,
                responsive: true,
            }
        });
    }
</script>
@endpush
