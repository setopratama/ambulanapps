@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Post</h2>
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <label>Start Point</label>
            <div id="start-map" style="height: 300px; width: 100%;"></div>
            <input type="hidden" id="start_point" name="start_point" value="{{ json_encode($post->start_point) }}" required>
        </div>
        <div class="form-group">
            <label>End Point</label>
            <div id="end-map" style="height: 300px; width: 100%;"></div>
            <input type="hidden" id="end_point" name="end_point" value="{{ json_encode($post->end_point) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
let startMap, endMap, startMarker, endMarker;

window.initGoogleMaps = function() {
    const startPoint = JSON.parse(document.getElementById('start_point').value) || { lat: 0, lng: 0 };
    const endPoint = JSON.parse(document.getElementById('end_point').value) || { lat: 0, lng: 0 };

    startMap = new google.maps.Map(document.getElementById('start-map'), {
        center: startPoint,
        zoom: 13
    });

    endMap = new google.maps.Map(document.getElementById('end-map'), {
        center: endPoint,
        zoom: 13
    });

    startMarker = new google.maps.Marker({
        position: startPoint,
        map: startMap,
        draggable: true
    });

    endMarker = new google.maps.Marker({
        position: endPoint,
        map: endMap,
        draggable: true
    });

    google.maps.event.addListener(startMarker, 'dragend', function() {
        updatePointInput('start_point', startMarker.getPosition());
    });

    google.maps.event.addListener(endMarker, 'dragend', function() {
        updatePointInput('end_point', endMarker.getPosition());
    });
} 

function updatePointInput(inputId, position) {
    const input = document.getElementById(inputId);
    input.value = JSON.stringify({
        lat: position.lat(),
        lng: position.lng()
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIkK9j-xW2JAn0F6rF6Ve60CEmdPMJZrs&callback=initGoogleMaps" async defer></script>
@endsection
