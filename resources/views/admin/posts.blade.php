@extends('layouts.admin')

@section('title', 'Kelola Postingan')

@section('page-title', 'Kelola Postingan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Postingan</h3>
        <div class="card-tools">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Postingan
            </a>
            <select id="postLimit" class="form-control d-inline-block ml-2" style="width: auto;">
                <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10 Postingan</option>
                <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100 Postingan</option>
                <option value="1000" {{ $limit == 1000 ? 'selected' : '' }}>1000 Postingan</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Dibuat Pada</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $post->is_suspended ? 'Suspended' : 'Aktif' }}</td>
                    <td>
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.post.toggle-suspension', $post->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $post->is_suspended ? 'btn-success' : 'btn-danger' }}">
                                {{ $post->is_suspended ? 'Aktifkan' : 'Suspend' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 custom-pagination">
            {{ $posts->appends(['limit' => $limit])->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('postLimit').addEventListener('change', function() {
        window.location.href = '{{ route('admin.posts') }}?limit=' + this.value;
    });
</script>
@endpush
