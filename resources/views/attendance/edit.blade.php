<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- NIS -->
                        <div class="mt-4">
                            <x-input-label for="nis" :value="__('NIS Siswa')" />
                            <x-text-input id="nis" class="block mt-1 w-full" type="text" name="nis" :value="old('nis', $attendance->student->nis)" required autofocus />
                            <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                        </div>

                        <!-- Tanggal Absen -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_absen" :value="__('Tanggal Absen')" />
                            <x-text-input id="tanggal_absen" class="block mt-1 w-full" type="date" name="tanggal_absen" :value="old('tanggal_absen', $attendance->tanggal_absen->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_absen')" class="mt-2" />
                        </div>

                        <!-- Semester (BARU: Read-only) -->
                        <div class="mt-4">
                            <x-input-label for="semester" :value="__('Semester Aktif')" />
                            {{-- 
                                Catatan: Data absensi ini mungkin dibuat di semester lalu.
                                Tapi saat diedit, kita asumsikan diedit di semester aktif.
                                Jika Anda ingin menampilkan semester asli data, gunakan $attendance->semester
                                Tapi $semester_aktif (dari controller) memastikan update-nya konsisten.
                            --}}
                            <x-text-input id="semester_display" class="block mt-1 w-full bg-gray-100" type="text" name="semester_display" :value="$semester_aktif" disabled readonly />
                            <p class="text-sm text-gray-500 mt-1">Semester akan di-update ke semester yang aktif saat ini.</p>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="mt-4">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <select id="keterangan" name="keterangan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Sakit" {{ old('keterangan', $attendance->keterangan) == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Ijin" {{ old('keterangan', $attendance->keterangan) == 'Ijin' ? 'selected' : '' }}>Ijin</option>
                                <option value="Alpha" {{ old('keterangan', $attendance->keterangan) == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                                <option value="Terlambat" {{ old('keterangan', $attendance->keterangan) == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>