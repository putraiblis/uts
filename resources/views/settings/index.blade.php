{{-- resources/views/settings/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Semester Aktif') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tampilkan pesan sukses -->
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="semester" :value="__('Pilih Semester yang Sedang Aktif Saat Ini')" />
                            
                            <select id="semester" name="semester" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Ganjil" {{ $currentSemester == 'Ganjil' ? 'selected' : '' }}>
                                    Ganjil
                                </option>
                                <option value="Genap" {{ $currentSemester == 'Genap' ? 'selected' : '' }}>
                                    Genap
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center mt-4">
                            <x-primary-button>
                                {{ __('Simpan Pengaturan') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <p class="mt-6 text-sm text-gray-600">
                        Semester yang Anda pilih di sini akan digunakan secara otomatis saat Anda (atau user lain) menginput data absensi baru.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>