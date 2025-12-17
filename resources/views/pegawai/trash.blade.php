@extends('base')
@section('title','Recycle Bin - Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')
@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Recycle Bin - Pegawai</h1>
        <div class="mx-auto max-w-screen-xl">
            
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="mb-4 flex gap-3">
                <a href="{{ route('pegawai.index') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    ← Kembali ke Daftar Pegawai
                </a>
            </div>
            
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-x divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700" width="1">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Gender</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Pekerjaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Dihapus Pada</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700" width="1">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($data as $k => $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $data->firstItem() + $k }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->email }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                @if($d->gender == 'male')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Male</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-pink-100 text-pink-800 rounded">Female</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->pekerjaan->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->deleted_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-center text-gray-600">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <form action="{{ route('pegawai.restore', ['id' => $d->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="cursor-pointer rounded-l-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-green-600 hover:bg-green-50">
                                            Pulihkan
                                        </button>
                                    </form>
                                    <form action="{{ route('pegawai.force-delete', ['id' => $d->id]) }}" method="POST" onsubmit="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak dapat dipulihkan! Lanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer rounded-r-md border border-l-0 border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data di recycle bin</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-4">
                {{ $data->links() }}
            </div>

        </div>
    </section>
@endsection