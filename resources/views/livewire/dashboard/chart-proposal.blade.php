<div class="">
    <flux:heading size="lg" class="bg-green-50 p-3 text-accent-content text-center">Rekap Proposal</flux:heading>
    <div class="flex items-center justify-center">
        <div class="w-120 h-120 mt-5 mb-5">
            <canvas id="proposalChart"></canvas>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', initChart);
        document.addEventListener('DOMContentLoaded', initChart);

        function initChart() {
            const ctx = document.getElementById('proposalChart');
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
                            '#FFF44F',
                            '#C97E04',
                            '#050A55',
                            '#057A55',
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {

                        legend: {
                            display: true,
                            position: 'right',
                        }
                    },
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    responsive: true,
                }
            });
        }
    </script>
@endpush
