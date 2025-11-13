<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">
                        Selamat Datang, {{ Auth::user()->name }} 👋
                    </h1>

                    <p class="text-gray-700 mb-4">
                        Anda login sebagai: <strong>{{ Auth::user()->role }}</strong>
                    </p>

                    <div class="flex flex-wrap gap-4"> {{-- Saya tambahkan 'flex-wrap' agar rapi di layar kecil --}}
                        
                        @if(Auth::user()->role == 'admin')
                            {{-- Tombol Admin yang Sudah Ada --}}
                            <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Manajemen User</a>
                            <a href="{{ route('students.index') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Data Siswa</a>
                            <a href="{{ route('attendance.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Data Absensi</a>
                            
                            <!-- ▼▼ TOMBOL BARU YANG DITAMBAHKAN ▼▼ -->
                            <!-- (Saya pilihkan warna Indigo agar serasi tapi berbeda) -->
                            <a href="{{ route('settings.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Atur Semester</a>

                        @else
                            {{-- Ini untuk user biasa (bukan admin) --}}
                            <a href="{{ route('attendance.index') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Lihat Absensi</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>