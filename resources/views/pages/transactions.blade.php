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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-xl border bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
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
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $trx->description ?? '-' }}</div>
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $trx->category?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($trx->type === 'income')
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
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
                                            <button
                                                onclick="openEditModal(
                                                    '{{ $trx->id }}',
                                                    '{{ $trx->description }}',
                                                    '{{ $trx->type }}',
                                                    '{{ $trx->amount }}',
                                                    '{{ $trx->date }}'
                                                )"
                                                class="text-blue-600 hover:text-blue-800">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            {{-- DELETE --}}
                                            <form method="POST"
                                                action="{{ route('web.transactions.destroy', $trx->id) }}"
                                                onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-800">
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
    <div id="addModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-xl bg-white p-6">
            <h3 class="mb-4 text-lg font-semibold">Tambah Transaksi</h3>

            <form method="POST" action="{{ route('web.transactions.store') }}">
                @csrf
                <div class="space-y-3">
                    <input type="text" name="description" placeholder="Deskripsi"
                        class="w-full rounded-lg border-gray-300 text-sm" required>

                    <select name="type" class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="income">income</option>
                        <option value="expense">Pengeluaran</option>
                    </select>

                    <input type="number" name="amount" placeholder="Jumlah"
                        class="w-full rounded-lg border-gray-300 text-sm" required>

                    <input type="date" name="date"
                        class="w-full rounded-lg border-gray-300 text-sm" required>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeAddModal()"
                        class="rounded-lg bg-gray-200 px-4 py-2 text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL EDIT ================= --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-xl bg-white p-6">
            <h3 class="mb-4 text-lg font-semibold">Edit Transaksi</h3>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <input id="editDescription" name="description"
                        class="w-full rounded-lg border-gray-300 text-sm">

                    <select id="editType" name="type"
                        class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="income">income</option>
                        <option value="expense">Pengeluaran</option>
                    </select>

                    <input id="editAmount" type="number" name="amount"
                        class="w-full rounded-lg border-gray-300 text-sm">

                    <input id="editDate" type="date" name="date"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="rounded-lg bg-gray-200 px-4 py-2 text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= JAVASCRIPT ================= --}}
    @push('scripts')
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(id, description, type, amount, date) {
            document.getElementById('editDescription').value = description;
            document.getElementById('editType').value = type;
            document.getElementById('editAmount').value = amount;
            document.getElementById('editDate').value = date;

            document.getElementById('editForm').action = `/transactions/${id}`;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
    @endpush

</x-app-layout>
