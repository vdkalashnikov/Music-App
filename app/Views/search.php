<?= $this->extend('/layout/search_layout'); ?>
<?= $this->section('content'); ?>

<div class="contain1">
    <h3>Cari Lagu, Artis, Album, Playlist Dari Spotify</h3>
    <h3>Kolom Pencarian</h3>
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="search-input" placeholder="Masukkan apa yang ingin kamu cari" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <button class="btn btn-outline-primary" id="search-button">Cari</button>
    </div>
</div>

<div class="row1" id="search-results">

</div>


<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
function displayResults(result) {
    $('#search-results').html('');

    <!-- Display Local Tracks -->
    if (result.local.tracks.length > 0) {
       
        $.each(result.local.tracks, function(i, track) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture2">
                        <a href="<?= route_to('user.lagu.track', '') ?>${track.id}">
                            <img src="<?= base_url('image/' . '') ?>${track.gambar}" alt="${track.nama_lagu}">
                        </a>
                    </div>
                    <div class="namealbum">${track.nama_lagu}</div>
                </div>
            `);
        });
    }

   
    if (result.local.artists.length > 0) {
       
        $.each(result.local.artists, function(i, artist) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture">
                        <a href="<?= route_to('user.artis', '') ?>${artist.id_artis}">
                            <img src="<?= base_url('image/' . '') ?>${artist.picture}" alt="${artist.nama}">
                        </a>
                    </div>
                    <div class="namealbum">${artist.nama}</div>
                </div>
            `);
        });
    }

 
    if (result.local.albums.length > 0) {
    
        $.each(result.local.albums, function(i, album) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture2">
                        <a href="<?= route_to('user.album', '') ?>${album.id_album}">
                            <img src="<?= base_url('img_album/' . '') ?>${album.gambar_album}" alt="${album.nama_album}">
                        </a>
                    </div>
                    <div class="namealbum">${album.nama_album}</div>
                </div>
            `);
        });
    }


    if (result.spotify.tracks.length > 0) {

        $.each(result.spotify.tracks, function(i, track) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture2">
                        <a href="<?= route_to('user.spotifyTrack', '') ?>${track.id}">
                            ${track.album.images.length > 0 ? `<img src="${track.album.images[0].url}" alt="${track.name}">` : ''}
                        </a>
                    </div>
                    <div class="namealbum">${track.name}</div>
                    <div class="namealbum">${track.artists.length > 0 ? track.artists[0].name : 'Unknown'}</div>
                </div>
            `);
        });
    } else {
        $('#search-results').append('<h3>No tracks found</h3>');
    }

    if (result.spotify.artists.length > 0) {
        
        let artists = result.spotify.artists;
        $.each(artists, function(i, artist) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture">
                        <a href="<?= route_to('user.spotifyArtist', '') ?>${artist.id}">
                            ${artist.images.length > 0 ? `<img src="${artist.images[0].url}" alt="${artist.name}">` : ''}
                        </a>
                    </div>
                    <div class="namealbum">${artist.name}</div>
                </div>
            `);
        });
    } else {
        $('#search-results').append('<h3>No artists found</h3>');
    }


    if (result.spotify.albums.length > 0) {
       
        let albums = result.spotify.albums;
        $.each(albums, function(i, album) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture2">
                        <a href="<?= route_to('user.spotifyAlbum', '') ?>${album.id}">
                            ${album.images.length > 0 ? `<img src="${album.images[0].url}" alt="${album.name}">` : ''}
                        </a>
                    </div>
                    <div class="namealbum">${album.name}</div>
                    <div class="namealbum">${album.artists.length > 0 ? album.artists[0].name : 'Unknown'}</div>
                </div>
            `);
        });
    } else {
        $('#search-results').append('<h3>No albums found</h3>');
    }

    if (result.spotify.playlists.length > 0) {
  
        let playlists = result.spotify.playlists;
        $.each(playlists, function(i, playlist) {
            $('#search-results').append(`
                <div class="cardo">
                    <div class="cardpicture2">
                        <a href="<?= route_to('user.spotifyPlaylist', '') ?>${playlist.id}">
                            ${playlist.images.length > 0 ? `<img src="${playlist.images[0].url}" alt="${playlist.name}">` : ''}
                        </a>
                    </div>
                    <div class="namealbum">${playlist.name}</div>
                    <div class="namealbum">${playlist.owner.display_name}</div>
                </div>
            `);
        });
    } else {
        $('#search-results').append('<h3>No playlists found</h3>');
    }
}

function searchSpotify() {
    const query = $('#search-input').val();
    if (query === '') {
        $('#search-results').html('');
        localStorage.removeItem('searchResults');
        localStorage.removeItem('searchQuery');
        return;
    }

    $.ajax({
        url: '<?= route_to('user.searchSpotify') ?>',
        type: 'post',
        dataType: 'json',
        data: {
            'query': query
        },
        success: function(result) {
  
            localStorage.setItem('searchResults', JSON.stringify(result));
            localStorage.setItem('searchQuery', query);
            displayResults(result);
        }
    });
}

$('#search-button').on('click', function() {
    searchSpotify();
});

$('#search-input').on('keyup', function(e) {
    if (e.keyCode == 13) {
        searchSpotify();
    } else if ($(this).val() === '') {
        $('#search-results').html('');
        localStorage.removeItem('searchResults');
        localStorage.removeItem('searchQuery');
    }
});


$(document).ready(function() {
    const savedQuery = localStorage.getItem('searchQuery');
    const savedResults = localStorage.getItem('searchResults');
    if (savedQuery) {
        $('#search-input').val(savedQuery);
    }
    if (savedResults) {
        const result = JSON.parse(savedResults);
        displayResults(result);
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
        const logoutLink = document.getElementById('logout');

        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari sesi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = logoutLink.href;
                }
            });
        });
    });

</script>

<?= $this->endSection(); ?>

 