// Pastikan initMaps dapat diakses secara global
window.initMaps = function() {
    $('.map-container').each(function() {
        var postId = $(this).data('post-id');
        var mapElement = this;
        var post = postsData[postId];

        if (post) {
            var startPoint = typeof post.start_point === 'string' ? JSON.parse(post.start_point) : post.start_point;
            var endPoint = typeof post.end_point === 'string' ? JSON.parse(post.end_point) : post.end_point;

            var map = new google.maps.Map(mapElement, {
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
                    $(mapElement).html('<p class="text-danger">Gagal memuat rute. Silakan coba lagi nanti.</p>');
                }
            });

            // Simpan referensi map jika diperlukan
            if (typeof maps !== 'undefined') {
                maps[postId] = map;
            }
        }
    });
};

// Fungsi untuk memuat lebih banyak posting
function loadMorePosts(page) {
    // Kode load more Anda
    $.ajax({
        url: '?page=' + page,
        type: 'get',
        beforeSend: function() {
            $('#load-more').text('Memuat...');
        }
    }).done(function(response) {
        $('#load-more').text('Muat Lebih Banyak');
        $('#posts-container').append(response.html);
        $('#load-more').data('page', page + 1);

        if (!response.hasMorePages) {
            $('#load-more-container').remove();
        }
        
        // Perbarui postsData dengan data baru
        $.extend(postsData, response.postsData);

        // Setelah memuat postingan baru
        initMaps();
    }).fail(function() {
        $('#load-more').text('Muat Lebih Banyak');
        alert('Postingan tidak dapat dimuat.');
    });
}

// Event listener untuk tombol "load more"
$(document).ready(function() {
    $('#load-more').click(function() {
        var page = $(this).data('page');
        loadMorePosts(page);
    });
});