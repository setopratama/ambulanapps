@extends('layouts.admin')

@section('title', 'Tambah Postingan Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Postingan Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.posts.store') }}" method="POST" id="postForm">
            @csrf
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Konten</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Titik Awal</label>
                <div id="start-map" style="height: 300px; width: 100%;"></div>
                <input type="hidden" id="start_point" name="start_point" required>
                <div id="start_point_error" class="text-danger" style="display: none;">Harap geser penanda untuk menentukan titik awal.</div>
            </div>
            <div class="form-group">
                <label>Titik Akhir</label>
                <div id="end-map" style="height: 300px; width: 100%;"></div>
                <input type="hidden" id="end_point" name="end_point" required>
                <div id="end_point_error" class="text-danger" style="display: none;">Harap geser penanda untuk menentukan titik akhir.</div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
let startMap, endMap, startMarker, endMarker;
let startPointChanged = false;
let endPointChanged = false;

window.initGoogleMaps = function() {
    const defaultLocation = { lat: -6.200000, lng: 106.816666 }; // Jakarta

    startMap = new google.maps.Map(document.getElementById('start-map'), {
        center: defaultLocation,
        zoom: 13
    });

    endMap = new google.maps.Map(document.getElementById('end-map'), {
        center: defaultLocation,
        zoom: 13
    });

    startMarker = new google.maps.Marker({
        position: defaultLocation,
        map: startMap,
        draggable: true
    });

    endMarker = new google.maps.Marker({
        position: defaultLocation,
        map: endMap,
        draggable: true
    });

    google.maps.event.addListener(startMarker, 'dragend', function() {
        updatePointInput('start_point', startMarker.getPosition());
        startPointChanged = true;
        document.getElementById('start_point_error').style.display = 'none';
    });

    google.maps.event.addListener(endMarker, 'dragend', function() {
        updatePointInput('end_point', endMarker.getPosition());
        endPointChanged = true;
        document.getElementById('end_point_error').style.display = 'none';
    });

    updatePointInput('start_point', defaultLocation);
    updatePointInput('end_point', defaultLocation);
} 

function updatePointInput(inputId, position) {
    const input = document.getElementById(inputId);
    input.value = JSON.stringify(positionToJSON(position));
}

function positionToJSON(position) {
    return {
        lat: position.lat(),
        lng: position.lng()
    };
}

document.getElementById('postForm').addEventListener('submit', function(e) {
    if (!startPointChanged) {
        e.preventDefault();
        document.getElementById('start_point_error').style.display = 'block';
    }
    if (!endPointChanged) {
        e.preventDefault();
        document.getElementById('end_point_error').style.display = 'block';
    }
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIkK9j-xW2JAn0F6rF6Ve60CEmdPMJZrs&callback=initGoogleMaps" async defer></script>
@endsection