<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category
            </h2>

            <button
                onclick="openCreateModal()"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                <span class="text-lg leading-none">+</span>
                Tambah Kategori
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ================= INCOME ================= --}}
            <div class="rounded-xl border bg-white p-6">
                <h3 class="mb-4 text-base font-semibold text-gray-800">
                    Kategori Pemasukan
                </h3>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($incomeCategories as $item)
                        <div class="flex items-center justify-between rounded-xl border p-4">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $item->name }}
                                </p>
                                <span
                                    class="inline-block rounded-full bg-green-100 px-3 py-0.5 text-xs font-medium text-green-700">
                                    Pemasukan
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <button
                                    onclick="openEditModal(
                                        {{ $item->id }},
                                        '{{ $item->name }}',
                                        '{{ $item->type }}'
                                    )"
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    ✏️
                                </button>

                                <form
                                    method="POST"
                                    action="{{ route('web.categories.destroy', $item->id) }}"
                                    onsubmit="return confirm('Yakin hapus kategori?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= EXPENSE ================= --}}
            <div class="rounded-xl border bg-white p-6">
                <h3 class="mb-4 text-base font-semibold text-gray-800">
                    Kategori Pengeluaran
                </h3>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($expenseCategories as $item)
                        <div class="flex items-center justify-between rounded-xl border p-4">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $item->name }}
                                </p>
                                <span
                                    class="inline-block rounded-full bg-red-100 px-3 py-0.5 text-xs font-medium text-red-700">
                                    Pengeluaran
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <button
                                    onclick="openEditModal(
                                        {{ $item->id }},
                                        '{{ $item->name }}',
                                        '{{ $item->type }}'
                                    )"
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    ✏️
                                </button>

                                <form
                                    method="POST"
                                    action="{{ route('web.categories.destroy', $item->id) }}"
                                    onsubmit="return confirm('Yakin hapus kategori?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ================= MODAL ================= --}}
    <div
        id="categoryModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-md rounded-xl bg-white p-6">

            <h3 id="modalTitle" class="mb-4 text-lg font-semibold text-gray-800">
                Tambah Kategori
            </h3>

            <form id="categoryForm" method="POST">
                @csrf
                <div id="methodField"></div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Kategori
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="categoryName"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Tipe
                    </label>
                    <select
                        name="type"
                        id="categoryType"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm"
                        required
                    >
                        <option value="">-- Pilih --</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        onclick="closeModal()"
                        class="rounded-lg bg-gray-200 px-4 py-2 text-sm"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        const modal = document.getElementById('categoryModal')
        const form = document.getElementById('categoryForm')
        const title = document.getElementById('modalTitle')
        const nameInput = document.getElementById('categoryName')
        const typeInput = document.getElementById('categoryType')
        const methodField = document.getElementById('methodField')

        function openCreateModal() {
            title.innerText = 'Tambah Kategori'
            form.action = "{{ route('web.categories.store') }}"
            methodField.innerHTML = ''
            nameInput.value = ''
            typeInput.value = ''
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function openEditModal(id, name, type) {
            title.innerText = 'Edit Kategori'
            form.action = `/categories/${id}`
            methodField.innerHTML = '@method("PUT")'
            nameInput.value = name
            typeInput.value = type
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeModal() {
            modal.classList.add('hidden')
            modal.classList.remove('flex')
        }
    </script>
</x-app-layout>
