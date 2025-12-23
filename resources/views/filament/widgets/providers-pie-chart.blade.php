<div class="filament-widget">
    <div class="mb-4" style="max-width:520px;margin:0 auto;">
        <div class="flex items-center justify-between mb-3">
            <div class="text-sm text-gray-500">Total Providers</div>
            <div class="text-sm text-gray-500">Paid</div>
            <div class="text-sm text-gray-500">Unpaid</div>
        </div>
        <div class="flex items-center justify-between mb-4">
            <div class="text-2xl font-semibold">{{ $total }}</div>
            <div class="text-2xl font-semibold text-green-600">{{ $paid }}</div>
            <div class="text-2xl font-semibold text-red-600">{{ $unpaid }}</div>
        </div>

        <div style="text-align:center;">
            <canvas id="providersPieChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script>
        (function () {
            const ctx = document.getElementById('providersPieChart');
            if (!ctx) return;

            const labels = @json($labels);
            const data = @json($data);
            const labelsWithCounts = labels.map((l, i) => `${l} (${data[i] ?? 0})`);

            // Register plugin
            if (Chart && Chart.register) {
                Chart.register(ChartDataLabels);
            }

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labelsWithCounts,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#10B981', // green for paid
                            '#EF4444', // red for unpaid
                        ],
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#ffffff',
                            formatter: function (value, ctx) {
                                return value;
                            },
                            font: { weight: '600' }
                        }
                    },
                },
            });
        })();
    </script>
</div>
