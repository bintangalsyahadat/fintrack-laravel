<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category
            </h2>

            <button onclick="openCreateModal()"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
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
                                <button onclick="openEditModal(
                                                {{ $item->id }},
                                                '{{ $item->name }}',
                                                '{{ $item->type }}'
                                            )" class="text-blue-600 hover:text-blue-800">
                                    ✏️
                                </button>

                                <form method="POST" action="{{ route('web.categories.destroy', $item->id) }}"
                                    onsubmit="return confirm('Yakin hapus kategori?')">
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
                                <button onclick="openEditModal(
                                                {{ $item->id }},
                                                '{{ $item->name }}',
                                                '{{ $item->type }}'
                                            )" class="text-blue-600 hover:text-blue-800">
                                    ✏️
                                </button>

                                <form method="POST" action="{{ route('web.categories.destroy', $item->id) }}"
                                    onsubmit="return confirm('Yakin hapus kategori?')">
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
    <div id="categoryModal" class="fixed inset-0 z-50 hidden items-end sm:items-center justify-center bg-black/50">
        <div id="categoryModalContent" class="w-full sm:max-w-md rounded-t-2xl sm:rounded-2xl bg-white shadow-xl
               transform transition-all duration-300 translate-y-full sm:translate-y-0 sm:scale-95">

            {{-- HEADER --}}
            <div class="flex items-center justify-between rounded-t-2xl
                    bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 text-white">
                <div>
                    <h3 id="modalTitle" class="text-base font-semibold">
                        Tambah Kategori
                    </h3>
                    <p class="text-xs opacity-90">
                        Atur kategori pemasukan & pengeluaran
                    </p>
                </div>
                <button onclick="closeModal()" class="text-white/80 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- FORM --}}
            <form id="categoryForm" method="POST" class="px-5 py-4">
                @csrf
                <div id="methodField"></div>

                <div class="space-y-4">

                    {{-- NAMA --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">
                            Nama Kategori
                        </label>
                        <input type="text" name="name" id="categoryName" placeholder="Contoh: Gaji, Makan, Transport"
                            class="w-full rounded-xl border-gray-300 text-sm
                               focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    {{-- TIPE --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600">
                            Tipe Kategori
                        </label>
                        <select name="type" id="categoryType" class="w-full rounded-xl border-gray-300 text-sm
                               focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="income">💰 Pemasukan</option>
                            <option value="expense">💸 Pengeluaran</option>
                        </select>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button type="button" onclick="closeModal()"
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

    {{-- ================= SCRIPT ================= --}}
    <script>
        const modal = document.getElementById('categoryModal')
        const modalContent = document.getElementById('categoryModalContent')
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

            setTimeout(() => {
                modalContent.classList.remove('translate-y-full', 'sm:scale-95')
                modalContent.classList.add('translate-y-0', 'sm:scale-100')
            }, 50)
        }

        function openEditModal(id, name, type) {
            title.innerText = 'Edit Kategori'
            form.action = `/categories/${id}`
            methodField.innerHTML = '@method("PUT")'
            nameInput.value = name
            typeInput.value = type

            modal.classList.remove('hidden')
            modal.classList.add('flex')

            setTimeout(() => {
                modalContent.classList.remove('translate-y-full', 'sm:scale-95')
                modalContent.classList.add('translate-y-0', 'sm:scale-100')
            }, 50)
        }

        function closeModal() {
            modalContent.classList.add('translate-y-full', 'sm:scale-95')

            setTimeout(() => {
                modal.classList.add('hidden')
            }, 200)
        }
    </script>

</x-app-layout>