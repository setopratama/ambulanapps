@foreach($posts as $post)
    <div class="col-12 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-subtitle text-muted">{{ $post->user->name }}</h6>
                    <small class="text-muted">{{ $post->created_at->format('d M Y H:i') }}</small>
                </div>
                <div id="map-{{ $post->id }}" class="map-container mb-3" data-post-id="{{ $post->id }}" style="height: 200px;"></div>
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->content }}</p>
                <div class="mt-3">
                    <small class="text-muted">{{ $post->comments->count() }} komentar</small>
                </div>
                @foreach($post->comments->take(3) as $comment)
                    <div class="mt-2">
                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                    </div>
                @endforeach
                @if($post->comments->count() > 3)
                    <div class="mt-2">
                        <a href="#" class="show-more-comments" data-post-id="{{ $post->id }}">Tampilkan semua komentar</a>
                    </div>
                    <div id="all-comments-{{ $post->id }}" style="display: none;">
                        @foreach($post->comments->skip(3) as $comment)
                            <div class="mt-2">
                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                            </div>
                        @endforeach
                    </div>
                @endif
                @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="input-group">
                            <input type="text" name="content" class="form-control" placeholder="Tambahkan komentar...">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.show-more-comments').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var postId = this.getAttribute('data-post-id');
            var allComments = document.getElementById('all-comments-' + postId);
            if (allComments) {
                allComments.style.display = allComments.style.display === 'none' ? 'block' : 'none';
                this.textContent = allComments.style.display === 'none' ? 'Tampilkan semua komentar' : 'Sembunyikan komentar';
            }
        });
    });
});
</script>
