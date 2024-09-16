@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Lihat Postingan</h2>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="text-muted">{{ $post->created_at->format('d M Y H:i') }}</p>
            </div>
            <div id="map" style="height: 300px; width: 100%; margin-bottom: 20px;"></div>
            <p class="card-text">{{ $post->content }}</p>
            <p>Penulis: {{ $post->user->name }}</p>
            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.posts') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIkK9j-xW2JAn0F6rF6Ve60CEmdPMJZrs"></script>
<script>
    var post = @json($post);
    var postsData = { [post.id]: post };

    function initMap() {
        if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
            var startPoint = typeof post.start_point === 'string' ? JSON.parse(post.start_point) : post.start_point;
            var endPoint = typeof post.end_point === 'string' ? JSON.parse(post.end_point) : post.end_point;

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: startPoint
            });

            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            var request = {
                origin: startPoint,
                destination: endPoint,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    console.error('Permintaan arah gagal karena ' + status);
                    $('#map').html('<p class="text-danger">Gagal memuat rute. Silakan coba lagi nanti.</p>');
                }
            });
        } else {
            console.error('Google Maps API is not loaded');
        }
    }

    // Tunggu sampai DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', initMap);
</script>
@endsection
