const base_url = "http://127.0.0.1/chinook/";

$("#BtnTracks").on("click", function(e){
    $("#name").empty();
    
    

    //use to get info from html/php page via id of item
    //var keyword = $("#somethinhg").val();
    var url = base_url + "Backend/track.php";
    
    

    $.ajax({
        url: url,
        type: 'GET',
        //expect json data
        //contentType : 'text/json',
        dataType : 'json'
    })
    .done(function(data) {
        console.log(data);
        //table to append with results
        const table = $('#name');
        const div = $("<div></div>");
        //alert(typeof(data));
        //console.log(data);

        $.each(data, function(i, item){
            
            let row = $('<tr></tr>', {'id': 'text'});

            let cell = $('<td></td>', { 'text': "Name" });
            
            let ucell = $('<td></td>', { 'text': item.Name });
            cell.append(ucell);
            row.append(cell);
            
            cell = $('<td></td>', { 'text': 'Album' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Album });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'MediaType' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.MediaType });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Genre' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Genre });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Composer' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Composer });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Milliseconds' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Milliseconds });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Bytes' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Bytes });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'UnitPrice' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.UnitPrice });
            row.append(cell);

            div.append(row);

        });
        table.append(div);
        
    });
});

$("#BtnArtist").on("click", function(e){
        e.preventDefault();
        //location.reload();
        
         alert("in old");
        //use to get info from html/php page via id of item
        var keyword = $("#somethinhg").val();
        var url = base_url + "Backend/artists.php";

        $.ajax({
            url: url,
            type: 'GET',
            //expect json data
            //contentType : 'text/json',
            dataType : 'json'
        })
        .done(function(data) {
            //table to append with results
            const table = $('#name');
            const div = $("<div></div>");
            //alert(typeof(data));
            //console.log(data);

            $.each(data, function(i, item){
                
                let row = $('<tr></tr>', {'id': 'text'});

                let cell = $('<td></td>', { 'text': "ArtistId" });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.ArtistId });
                row.append(cell);
                
                cell = $('<td></td>', { 'text': 'Name' });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.Name });
                row.append(cell);
                div.append(row);

            });
            table.append(div);
            
        });
    });