<x-app-layout>
    @php
    // ================= DUMMY DATA =================
    $totalSaldo = 19804000;
    $totalIncome = 21500000;
    $totalExpense = 1696000;

    $labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
    $income = [8000000, 5000000, 3500000, 7000000];
    $expense = [2500000, 3200000, 1800000, 2100000];
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Dashboard
            </h2>

            <button
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <i class="fa-solid fa-plus"></i>
                Tambah Transaksi
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ================= SUMMARY ================= --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="flex items-center justify-between rounded-xl border bg-white p-5">
                    <div>
                        <p class="text-sm text-gray-500">Total Saldo</p>
                        <p class="mt-1 text-lg font-semibold">
                            Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-blue-100 p-3 text-blue-600">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-xl border bg-white p-5">
                    <div>
                        <p class="text-sm text-gray-500">Total Pemasukan</p>
                        <p class="mt-1 text-lg font-semibold text-green-600">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-green-100 p-3 text-green-600">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-xl border bg-white p-5">
                    <div>
                        <p class="text-sm text-gray-500">Total Pengeluaran</p>
                        <p class="mt-1 text-lg font-semibold text-red-600">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-red-100 p-3 text-red-600">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                </div>
            </div>

            {{-- ================= CHART ================= --}}
            <div class="rounded-xl border bg-white p-6">
                <h3 class="mb-4 text-base font-semibold">
                    Arus Kas Bulanan
                </h3>

                <div class="relative h-[320px]">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= CHART SCRIPT ================= --}}
    <script>
        const labels = @json($labels);
        const incomeData = @json($income);
        const expenseData = @json($expense);

        const ctx = document.getElementById('cashFlowChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                        label: 'Pemasukan',
                        data: incomeData,
                        backgroundColor: '#22c55e',
                        borderRadius: 8,
                    },
                    {
                        label: 'Pengeluaran',
                        data: expenseData,
                        backgroundColor: '#ef4444',
                        borderRadius: 8,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value / 1000000 + 'jt'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
