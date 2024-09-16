@extends('layouts.app')

@section('content')
<div class="container">
    <div id="posts-container" class="row">
        @include('partials._post_list')
    </div>
    
    @if($posts->hasMorePages())
        <div id="load-more-container" class="text-center mt-4">
            <button id="load-more" class="btn btn-primary" data-page="2">Muat Lebih Banyak</button>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    var postsData = @json($postsData);

    function initMap() {
        if (typeof initMaps === 'function') {
            initMaps();
        } else {
            console.error('initMaps function is not defined');
        }
    }

    function initGoogleMaps() {
        if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
            initMap();
        } else {
            setTimeout(initGoogleMaps, 100);
        }
    }

    // Tunggu sampai DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Muat script map-init.js
        var script = document.createElement('script');
        script.src = "{{ asset('js/map-init.js') }}";
        script.onload = function() {
            // Setelah map-init.js dimuat, inisialisasi Google Maps
            initGoogleMaps();
        };
        document.head.appendChild(script);
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIkK9j-xW2JAn0F6rF6Ve60CEmdPMJZrs&callback=initGoogleMaps" async defer></script>
@endsection