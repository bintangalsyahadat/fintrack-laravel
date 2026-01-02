<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Transactions</h2>
            <button onclick="openAddModal()"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <i class="fa-solid fa-plus"></i>
                Tambah Transaksi
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-xl border bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Deskripsi</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Tipe</th>
                                <th class="px-4 py-3 text-right">Jumlah</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $trx->description ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $trx->category?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($trx->type === 'income')
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-700">
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs text-red-700">
                                                Pengeluaran
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-right font-medium
                                                        {{ $trx->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $trx->type === 'income' ? '+' : '-' }}
                                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">

                                            {{-- EDIT --}}
                                            <button onclick="openEditModal(
                                                                    '{{ route('web.transactions.update', $trx->id) }}',
                                                                    '{{ $trx->description }}',
                                                                    '{{ $trx->type }}',
                                                                    '{{ $trx->amount }}',
                                                                    '{{ $trx->date }}',
                                                                    '{{ $trx->category_id }}'
                                                                )" class="text-blue-600">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            {{-- DELETE --}}
                                            <form method="POST" action="{{ route('web.transactions.destroy', $trx->id) }}"
                                                onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        Tidak ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div id="addModal" class="fixed inset-0 z-50 hidden items-end sm:items-center justify-center bg-black/50">

        <div id="addModalContent" class="w-full sm:max-w-md rounded-t-2xl sm:rounded-2xl bg-white shadow-xl
               transform transition-all duration-300 translate-y-full sm:translate-y-0 sm:scale-95">

            {{-- HEADER --}}
            <div
                class="flex items-center justify-between rounded-t-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 text-white">
                <div>
                    <h3 class="text-base font-semibold">Tambah Transaksi</h3>
                    <p class="text-xs opacity-90">Catat pemasukan / pengeluaran</p>
                </div>
                <button onclick="closeAddModal()" class="text-white/80 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('web.transactions.store') }}" class="px-5 py-4">
                @csrf

                <div class="space-y-4">

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">Deskripsi</label>
                        <input type="text" name="description" placeholder="Contoh: Gaji Bulanan"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">Kategori</label>
                        <select name="category_id"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TIPE --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">Tipe</label>
                        <select name="type"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="income">💰 Pemasukan</option>
                            <option value="expense">💸 Pengeluaran</option>
                        </select>
                    </div>

                    {{-- JUMLAH --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">Jumlah</label>
                        <input type="number" name="amount" placeholder="Rp 0"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    {{-- TANGGAL --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">Tanggal</label>
                        <input type="date" name="date"
                            class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button type="button" onclick="closeAddModal()"
                        class="rounded-xl bg-blue-600 py-3 text-sm font-medium text-white hover:bg-blue-700">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-blue-600 py-3 text-sm font-medium text-white hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= JAVASCRIPT ================= --}}
    <script>
        const addModal = document.getElementById('addModal');
        const addModalContent = document.getElementById('addModalContent');

        function openAddModal() {
            addModal.classList.remove('hidden');
            addModal.classList.add('flex');

            setTimeout(() => {
                addModalContent.classList.remove('translate-y-full', 'sm:scale-95');
                addModalContent.classList.add('translate-y-0', 'sm:scale-100');
            }, 50);
        }

        function closeAddModal() {
            addModalContent.classList.add('translate-y-full', 'sm:scale-95');

            setTimeout(() => {
                addModal.classList.add('hidden');
            }, 200);
        }
    </script>

</x-app-layout>