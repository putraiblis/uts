<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Data Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- GANTI DIMULAI DI SINI --}}
                    @if(auth()->user()->role == 'admin')
                    <a href="{{ route('attendance.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Tambah Data Absensi
                    </a>
                    @endif
                    {{-- GANTI SELESAI DI SINI --}}


                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    
                                    {{-- GANTI DIMULAI DI SINI --}}
                                    @if(auth()->user()->role == 'admin')
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    @endif
                                    {{-- GANTI SELESAI DI SINI --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($attendances as $attendance)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $attendance->tanggal_absen->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $attendance->student->nis ?? 'Siswa Dihapus' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $attendance->student->name ?? 'Siswa Dihapus' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($attendance->keterangan == 'Sakit') bg-yellow-100 text-yellow-800
                                                @elseif($attendance->keterangan == 'Ijin') bg-blue-100 text-blue-800
                                                @elseif($attendance->keterangan == 'Alpha') bg-red-100 text-red-800
                                                @elseif($attendance->keterangan == 'Terlambat') bg-purple-100 text-purple-800
                                                @endif">
                                                {{ $attendance->keterangan }}
                                            </span>
                                        </td>

                                        {{-- GANTI DIMULAI DI SINI --}}
                                        @if(auth()->user()->role == 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            
                                            <a href="{{ route('attendance.edit', $attendance->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                        @endif
                                        {{-- GANTI SELESAI DI SINI --}}

                                    </tr>
                                @empty
                                    <tr>
                                        {{-- GANTI DIMULAI DI SINI: Sesuaikan colspan --}}
                                        <td colspan="{{ auth()->user()->role == 'admin' ? 5 : 4 }}" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada data absensi.
                                        </td>
                                        {{-- GANTI SELESAI DI SINI --}}
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>