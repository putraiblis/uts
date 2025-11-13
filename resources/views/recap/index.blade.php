{{-- resources/views/recap/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekap Absensi Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- FORM FILTER --}}
                    <form action="{{ route('recap.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            
                            {{-- Filter Kelas --}}
                            <div>
                                <x-input-label for="kelas_id" :value="__('Kelas')" />
                                {{-- GANTI DARI <x-select> KE <select> DENGAN CLASS BREEZE --}}
                                <select id="kelas_id" name="kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($daftar_kelas as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $selected_kelas_id == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }} ({{ $kelas->kode_kelas }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Semester --}}
                            <div>
                                <x-input-label for="semester" :value="__('Semester')" />
                                {{-- GANTI DARI <x-select> KE <select> DENGAN CLASS BREEZE --}}
                                <select id="semester" name="semester" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil" {{ $selected_semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ $selected_semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>

                            {{-- Tombol Submit --}}
                            <div class="flex items-end">
                                <x-primary-button>
                                    {{ __('Tampilkan Rekap') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>

                    {{-- TABEL HASIL REKAP --}}
                    {{-- Muncul hanya jika filter sudah diisi lengkap --}}
                    @if($selected_kelas_id && $selected_semester)
                        
                        {{-- Logika untuk mendapatkan nama kelas dari hasil query --}}
                        @php
                            $nama_kelas_terpilih = $daftar_kelas->firstWhere('id', $selected_kelas_id)->nama_kelas ?? '';
                        @endphp

                        <h3 class="text-lg font-semibold mb-4">
                            Hasil Rekapitulasi - Kelas {{ $nama_kelas_terpilih }} (Semester {{ $selected_semester }})
                        </h3>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">No</th>
                                        <th scope="col" class="py-3 px-6">NIS</th>
                                        <th scope="col" class="py-3 px-6">Nama Siswa</th>
                                        <th scope="col" class="py-3 px-6 text-center">Sakit (S)</th>
                                        <th scope="col" class="py-3 px-6 text-center">Ijin (I)</th>
                                        <th scope="col" class="py-3 px-6 text-center">Alpha (A)</th>
                                        <th scope="col" class="py-3 px-6 text-center">Terlambat (T)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $index => $student)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                            <td class="py-4 px-6">{{ $student->nis }}</td>
                                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $student->name }}
                                            </td>
                                            <td class="py-4 px-6 text-center">{{ $student->total_sakit }}</td>
                                            <td class="py-4 px-6 text-center">{{ $student->total_ijin }}</td>
                                            <td class="py-4 px-6 text-center">{{ $student->total_alpha }}</td>
                                            <td class="py-4 px-6 text-center">{{ $student->total_terlambat }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white border-b">
                                            <td colspan="7" class="py-4 px-6 text-center">
                                                @if($students->isEmpty() && $selected_kelas_id)
                                                    Tidak ada siswa di kelas ini.
                                                @else
                                                    Data tidak ditemukan.
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500">
                            Silakan pilih Kelas dan Semester untuk menampilkan data rekapitulasi.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>