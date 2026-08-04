<div class="xl:col-span-2 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 p-6">

        <div>

            <h2 class="text-lg font-semibold text-gray-900">
                Progress Bulanan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Perbandingan progress proyek setiap bulan.
            </p>

        </div>

        <div class="flex items-center gap-5">

            <div class="flex items-center gap-2">

                <span class="h-3 w-3 rounded-full bg-blue-600"></span>

                <span class="text-sm text-gray-500">
                    Tahun Ini
                </span>

            </div>

            <div class="flex items-center gap-2">

                <span class="h-3 w-3 rounded-full bg-blue-200"></span>

                <span class="text-sm text-gray-500">
                    Tahun Lalu
                </span>

            </div>

        </div>

    </div>

    {{-- Chart --}}
    <div class="p-6">

        <div class="relative h-[320px] w-full">

            <canvas id="monthlyProgressChart" class="h-full w-full"></canvas>

        </div>

    </div>

</div>

@once
    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', initChart);
            document.addEventListener('livewire:navigated', initChart);

            function initChart() {

                const canvas = document.getElementById('monthlyProgressChart');

                if (!canvas) return;

                const oldChart = Chart.getChart(canvas);

                if (oldChart) {
                    oldChart.destroy();
                }

                new Chart(canvas, {

                    type: 'bar',

                    data: {

                        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'],

                        datasets: [

                            {

                                label: 'Tahun Ini',

                                data: [8,12,10,15,14,17,12],

                                backgroundColor: '#2563eb',

                                borderRadius: 8,

                                borderSkipped: false,

                                categoryPercentage: 0.7,

                                barPercentage: 0.85,

                            },

                            {

                                label: 'Tahun Lalu',

                                data: [10,11,12,13,15,15,12],

                                backgroundColor: '#bfdbfe',

                                borderRadius: 8,

                                borderSkipped: false,

                                categoryPercentage: 0.7,

                                barPercentage: 0.85,

                            }

                        ]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                display: false

                            }

                        },

                        scales: {

                            x: {

                                grid: {

                                    display: false

                                }

                            },

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    stepSize: 5

                                },

                                grid: {

                                    color: '#f3f4f6'

                                }

                            }

                        }

                    }

                });

            }

        </script>

    @endpush
@endonce