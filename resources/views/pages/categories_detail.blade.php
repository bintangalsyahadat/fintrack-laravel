<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category / {{ $category->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border bg-white p-6">

                {{-- ERROR MESSAGE --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 p-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- FORM UPDATE --}}
                <form
                    method="POST"
                    action="{{ route('web.categories.update', $category->id) }}"
                    class="space-y-4"
                >
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nama Kategori
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="mt-1 w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>

                    {{-- TYPE --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tipe
                        </label>
                        <select
                            name="type"
                            class="mt-1 w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="income"
                                {{ $category->type === 'income' ? 'selected' : '' }}>
                                Pemasukan
                            </option>

                            <option value="expense"
                                {{ $category->type === 'expense' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex justify-end gap-2 pt-4">
                        <a
                            href="{{ route('web.categories.index') }}"
                            class="rounded-lg bg-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-300"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                        >
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
