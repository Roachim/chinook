$("#LoginBtn").on("click", function(e){
    e.preventDefault();
    //location.reload();
    
    //use to get info from html/php page via id of item
    var keyword = $("#somethinhg").val();
    var url = base_url + "API/artists.php";

    // Search movie
    $("#frmSearchFilm").on("submit", function(e) {
        e.preventDefault();

        loadingStart();

        $.ajax({
            url: "src/api.php",
            type: "POST",
            data: {
                entity: "movie",
                action: "search",
                searchText: $("#txtFilm").val()
            },
            success: function(data) {
                data = JSON.parse(data);

                if (userAuthenticated(data)) {
                    displayMovies(data);
                    loadingEnd();
                }
            }
        });
    });
});