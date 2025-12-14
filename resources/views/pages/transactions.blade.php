<x-app-layout>
    @php
    $transactions = [
    [
    'date' => '12 Des 2024',
    'title' => 'Gaji Bulanan',
    'subtitle' => 'Gaji bulan Desember',
    'category' => 'Gaji',
    'type' => 'Pemasukan',
    'amount' => 15000000,
    ],
    [
    'date' => '11 Des 2024',
    'title' => 'Belanja Groceries',
    'subtitle' => 'Supermarket',
    'category' => 'Belanja',
    'type' => 'Pengeluaran',
    'amount' => -450000,
    ],
    [
    'date' => '10 Des 2024',
    'title' => 'Project Website',
    'subtitle' => 'Pembuatan website klien',
    'category' => 'Freelance',
    'type' => 'Pemasukan',
    'amount' => 5000000,
    ],
    [
    'date' => '10 Des 2024',
    'title' => 'Bensin',
    'subtitle' => null,
    'category' => 'Transport',
    'type' => 'Pengeluaran',
    'amount' => -200000,
    ],
    [
    'date' => '09 Des 2024',
    'title' => 'Makan Siang',
    'subtitle' => null,
    'category' => 'Makanan',
    'type' => 'Pengeluaran',
    'amount' => -85000,
    ],
    [
    'date' => '08 Des 2024',
    'title' => 'Tagihan Listrik',
    'subtitle' => null,
    'category' => 'Tagihan',
    'type' => 'Pengeluaran',
    'amount' => -350000,
    ],
    [
    'date' => '07 Des 2024',
    'title' => 'Netflix Subscription',
    'subtitle' => null,
    'category' => 'Hiburan',
    'type' => 'Pengeluaran',
    'amount' => -186000,
    ],
    [
    'date' => '06 Des 2024',
    'title' => 'Konsultasi Dokter',
    'subtitle' => null,
    'category' => 'Kesehatan',
    'type' => 'Pengeluaran',
    'amount' => -250000,
    ],
    [
    'date' => '05 Des 2024',
    'title' => 'Dividen Saham',
    'subtitle' => null,
    'category' => 'Investasi',
    'type' => 'Pemasukan',
    'amount' => 1500000,
    ],
    [
    'date' => '04 Des 2024',
    'title' => 'Makan Malam',
    'subtitle' => null,
    'category' => 'Makanan',
    'type' => 'Pengeluaran',
    'amount' => -175000,
    ],
    ];
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Transactions</h2>
            <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <i class="fa-solid fa-plus"></i>
                Tambah Transaksi
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- FILTER --}}
            <div class="rounded-xl border bg-white p-4">
                <div class="mb-3 flex items-center gap-2 text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-filter"></i>
                    Filter & Pencarian
                </div>

                <div class="grid gap-3 md:grid-cols-4">
                    <input type="text" placeholder="Cari transaksi..." class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" />
                    <select class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option>Semua Tipe</option>
                        <option>Pemasukan</option>
                        <option>Pengeluaran</option>
                    </select>
                    <select class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option>Semua Kategori</option>
                    </select>
                    <input type="date" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" />
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-xl border bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Nama Transaksi</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Tipe</th>
                                <th class="px-4 py-3 text-right">Jumlah</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($transactions as $trx)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-600">{{ $trx['date'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $trx['title'] }}</div>
                                    @if ($trx['subtitle'])
                                    <div class="text-xs text-gray-500">{{ $trx['subtitle'] }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $trx['category'] }}</td>
                                <td class="px-4 py-3">
                                    @if ($trx['type'] === 'Pemasukan')
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Pemasukan</span>
                                    @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-medium {{ $trx['amount'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trx['amount'] > 0 ? '+' : '-' }} Rp {{ number_format(abs($trx['amount']), 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <button class="text-blue-600 hover:text-blue-800"><i class="fa-solid fa-pen"></i></button>
                                        <button class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-between border-t px-4 py-3 text-xs text-gray-600">
                    <span>Menampilkan 1 - 10 dari 10 transaksi</span>
                    <div class="flex gap-2">
                        <button class="rounded-md bg-gray-100 px-3 py-1">Sebelumnya</button>
                        <button class="rounded-md bg-gray-100 px-3 py-1">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
