<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category
            </h2>

            <button
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <span class="text-lg leading-none">+</span>
                Tambah Kategori
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= Income Kategori ================= --}}
            <div class="rounded-xl border bg-white p-6">
                <h3 class="mb-4 text-base font-semibold text-gray-800">
                    Kategori Pemasukan
                </h3>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="flex items-center justify-between rounded-xl border p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">💰</span>
                            <div>
                                <p class="font-medium text-gray-800">Gaji</p>
                                <span
                                    class="inline-block rounded-full bg-green-100 px-3 py-0.5 text-xs font-medium text-green-700">
                                    Pemasukan
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="text-blue-600 hover:text-blue-800">
                                ✏️
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                🗑️
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">💻</span>
                            <div>
                                <p class="font-medium text-gray-800">Freelance</p>
                                <span
                                    class="inline-block rounded-full bg-green-100 px-3 py-0.5 text-xs font-medium text-green-700">
                                    Pemasukan
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="text-blue-600 hover:text-blue-800">✏️</button>
                            <button class="text-red-600 hover:text-red-800">🗑️</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📈</span>
                            <div>
                                <p class="font-medium text-gray-800">Investasi</p>
                                <span
                                    class="inline-block rounded-full bg-green-100 px-3 py-0.5 text-xs font-medium text-green-700">
                                    Pemasukan
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="text-blue-600 hover:text-blue-800">✏️</button>
                            <button class="text-red-600 hover:text-red-800">🗑️</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= Expense Category ================= --}}
            <div class="rounded-xl border bg-white p-6">
                <h3 class="mb-4 text-base font-semibold text-gray-800">
                    Kategori Pengeluaran
                </h3>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @php
                    $expenses = [
                    ['🍔', 'Makanan'],
                    ['🚗', 'Transport'],
                    ['🛒', 'Belanja'],
                    ['🎬', 'Hiburan'],
                    ['📱', 'Tagihan'],
                    ['⚕️', 'Kesehatan'],
                    ];
                    @endphp

                    @foreach ($expenses as $item)
                    <div class="flex items-center justify-between rounded-xl border p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $item[0] }}</span>
                            <div>
                                <p class="font-medium text-gray-800">{{ $item[1] }}</p>
                                <span
                                    class="inline-block rounded-full bg-red-100 px-3 py-0.5 text-xs font-medium text-red-700">
                                    Pengeluaran
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="text-blue-600 hover:text-blue-800">✏️</button>
                            <button class="text-red-600 hover:text-red-800">🗑️</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
