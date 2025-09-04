<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="m-5 text-2xl">Market Sales</div>
                    <canvas id="myLineChart" width="200" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get the canvas element
        var ctx = document.getElementById('myLineChart').getContext('2d');

            // Create the line chart
            var myLineChart = new Chart(ctx, {
                type: 'line',  // Chart type: 'line'
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],  // X-axis labels
                    datasets: [{
                        label: 'Market Sales',   // Label for the line
                        data: [65, 59, 80, 81, 56, 55, 40],  // Y-axis data values
                        fill: true,  // Don't fill the area under the line
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(75, 192, 192)',  // Line color
                        tension: 0  // Smoothness of the line
                    }]
                },
                options: {
                    responsive: true,  // Make the chart responsive
                    plugins: {
                        legend: {
                            display: false  // Disable the legend (label above the chart)
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true  // Start Y-axis at zero
                        }
                    }
                }
            });
            var ctx = document.getElementById('myLineChart1').getContext('2d');

            // Create the line chart
            var myLineChart = new Chart(ctx, {
                type: 'line',  // Chart type: 'line'
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],  // X-axis labels
                    datasets: [{
                        label: 'Market Sales',   // Label for the line
                        data: [65, 59, 80, 81, 56, 55, 40],  // Y-axis data values
                        fill: true,  // Don't fill the area under the line
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(75, 192, 192)',  // Line color
                        tension: 0  // Smoothness of the line
                    }]
                },
                options: {
                    responsive: true,  // Make the chart responsive
                    plugins: {
                        legend: {
                            display: false  // Disable the legend (label above the chart)
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true  // Start Y-axis at zero
                        }
                    }
                }
            });
    </script>
</x-app-layout>
