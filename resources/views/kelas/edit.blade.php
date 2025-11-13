<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kelas: ') . $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Formulir -->
                    <form method="POST" action="{{ route('kelas.update', $kelas->id) }}">
                        @csrf
                        @method('PUT') <!-- Method untuk update -->

                        <!-- Kode Kelas -->
                        <div>
                            <x-input-label for="kode_kelas" :value="__('Kode Kelas (Contoh: X-RPL1)')" />
                            <!-- Isi value dengan data lama -->
                            <x-text-input id="kode_kelas" class="block mt-1 w-full" type="text" name="kode_kelas" :value="old('kode_kelas', $kelas->kode_kelas)" required autofocus />
                            <x-input-error :messages="$errors->get('kode_kelas')" class="mt-2" />
                        </div>

                        <!-- Nama Kelas -->
                        <div class="mt-4">
                            <x-input-label for="nama_kelas" :value="__('Nama Kelas (Contoh: Kelas 10 RPL 1)')" />
                            <!-- Isi value dengan data lama -->
                            <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas" :value="old('nama_kelas', $kelas->nama_kelas)" required />
                            <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('kelas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Perbarui') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>