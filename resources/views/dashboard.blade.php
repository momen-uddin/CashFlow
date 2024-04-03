<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 row">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row d-flex justify-content-evenly">
                    {{-- Card 1 --}}
                    <div class="card bg-blue-800 ml-0 sm:ml-5 mt-4 mb-4 w-9/12 sm:w-3/12">
                        <div class="p-3 ml-3 mt-2 bg-white bg-opacity-50" style="border-radius: 50%; width:4em;">
                            <img src="{{ url('storage/images/money-bag.png') }}" class="card-img-top" alt=""
                                title="">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-slate-300">Agent Money</h5>
                            <p class="card-text text-slate-50 float-end">{{ number_format($Agent, 0, '.', ',') }} Bdt
                            </p>

                        </div>
                    </div>
                    {{-- Card 2 --}}
                    <div class="card bg-slate-800 ml-0 sm:ml-5 mt-4 mb-4 w-9/12 sm:w-3/12">
                        <div class="p-3 ml-3 mt-2 bg-white bg-opacity-50" style="border-radius: 50%; width:4em;">
                            <img src="{{ url('storage/images/money-send.png') }}" class="card-img-top" alt=""
                                title="">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-slate-300">Sent to Customer</h5>
                            <p class="card-text text-slate-50 float-end">{{ number_format($CustSent, 0, '.', ',') }} Bdt
                            </p>

                        </div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="card bg-emerald-900 ml-0 sm:ml-5 mt-4 mb-4 w-9/12 sm:w-3/12">
                        <div class="p-3 ml-3 mt-2 bg-white bg-opacity-50" style="border-radius: 50%; width:4em;">
                            <img src="{{ url('storage/images/money-receive.png') }}" class="card-img-top" alt=""
                                title="">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-slate-300">Received from Customer</h5>
                            <p class="card-text text-slate-50 float-end">{{ number_format($CustReceive, 0, '.', ',') }}
                                Bdt</p>

                        </div>
                    </div>



                </div>

            </div>


            <div class="flex flex-col sm:flex-row gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3 w-full sm:w-3/4">
                    <div class="p-6 row justify-center">
                        <div class="card bg-slate-100">
                            <canvas id="myChart" height="350px"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3 w-full sm:w-1/4">
                    <div class="p-1">
                        <h4 class="card-title fw-bold">Recent Transactions</h4>
                        <hr>
                        <!-- Add your recent transactions here -->
                        <ul class="mt-2">
                            @foreach ($transactions as $item)
                                <li class="mt-1 mb-1">
                                    <div class="flex justify-between" style="font-size: 0.9em;">
                                        <div>
                                            <span class="font-semibold">{{ $item->cust_name }}</span><br>
                                            <span>{{ custom_date($item->transDate) }}</span>
                                        </div>
                                        <span class="font-semibold">{{ $item->amount }} ৳</span>
                                    </div>
                                </li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>




        </div>
    </div>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {!! json_encode($chartData) !!},
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Monthly Financial Data',
                    fontSize: 18,
                    fontColor: '#333',
                    fontFamily: 'Arial, sans-serif',
                    padding: 20
                },
                legend: {
                    display: true,
                    labels: {
                        fontColor: '#333',
                        fontSize: 14,
                        fontFamily: 'Arial, sans-serif'
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            fontColor: '#333',
                            fontSize: 12,
                            fontFamily: 'Arial, sans-serif'
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            zeroLineColor: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            fontColor: '#333',
                            fontSize: 12,
                            fontFamily: 'Arial, sans-serif',
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return '$' + value; // Add currency symbol or any other formatting
                            }
                        }
                    }]
                },
                tooltips: {
                    backgroundColor: '#555',
                    titleFontSize: 14,
                    titleFontColor: '#fff',
                    bodyFontSize: 12,
                    bodyFontColor: '#fff',
                    displayColors: false,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + tooltipItem.yLabel.toFixed(2);
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },

            },

        });
    </script>


</x-app-layout>
