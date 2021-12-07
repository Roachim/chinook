
    const base_url = "http://127.0.0.1/chinook/";


    $("#Btn").on("click", function(e){
        e.preventDefault();
        //location.reload();
        

        //use to get info from html/php page via id of item
        var keyword = $("#somethinhg").val();
        var url = base_url + "Backend/artists.php";

        $.ajax({
            url: url,
            type: 'GET',
            //origin: "*",
            //expect json data
            //contentType : 'application/json',
            dataType : 'json'
        })
        .done(function(data) {
            //table to append with results
            const table = $('#name');
            alert(typeof(data));
            $.each(data.results, function(i, item){
                
                let row = $('<tr></tr>', {'id': 'text'});

                let cell = $('<td></td>', { 'text': "ArtistId" });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.ArtistId });
                row.append(cell);
                
                alert("adding table");
                cell = $('<td></td>', { 'text': 'Name' });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.Name });

                div.append(row);
                table.append(row);
            
            });
            
        });
    });
