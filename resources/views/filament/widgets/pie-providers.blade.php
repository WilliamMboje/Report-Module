<div class="filament-widget">
    <div style="max-width:420px;margin:0 auto;">
        <canvas id="providersPieChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const ctx = document.getElementById('providersPieChart');
            if (!ctx) return;

            const labels = @json($labels);
            const data = @json($data);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            getComputedStyle(document.documentElement).getPropertyValue('--color-success') || '#10B981',
                            getComputedStyle(document.documentElement).getPropertyValue('--color-danger') || '#EF4444',
                        ],
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                },
            });
        })();
    </script>
</div>
