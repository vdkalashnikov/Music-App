<?= $this->extend('/layout/search_layout'); ?>
<?= $this->section('content'); ?>

<div class="contain1">
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
function searchSpotify() {
    $('#search-results').html('');
    $.ajax({
        url: '<?= route_to('user.searchSpotify') ?>',
        type: 'post',
        dataType: 'json',
        data: {
            'query': $('#search-input').val()
        },
        success: function(result) {
            if (result.artists.items.length > 0) {
                let artists = result.artists.items;
                $.each(artists, function(i, artist) {
                    $('#search-results').append(`
                        
                            <div class="cardo">
                                <div class="cardpicture">
                                    <a href="<?= route_to('user.spotifyArtist', '') ?>${artist.id}">
                                        ${artist.images.length > 0 ? `<img src="${artist.images[0].url}" alt="${artist.name}">` : ''}
                                    </a>
                                </div>
                                <div class="namealbum">${artist.name}</div>
                                <div class="namealbum">${artist.genres.length > 0 ? artist.genres[0] : 'Unknown'}</div>
                            </div>
                      
                    `);
                });
            } else {
                $('#search-results').html('<h3 style="color:white;" align="center">No results found</h3>');
            }
        }
    });
}

$('#search-button').on('click', function() {
    searchSpotify();
});

$('#search-input').on('keyup', function(e) {
    if (e.keyCode == 13) {
        searchSpotify();
    }
});
</script>

<?= $this->endSection(); ?>
