$(function() {
    
    $('<h2></h2>').attr({'class': 'ui sub header','id': 'subHeader'}).html('ALL PAINTINGS [TOP 20]').appendTo('div#paintings');
    var table = $('<table></table>').attr('class', 'ui very basic table').insertAfter('h2#subHeader');
    $('<tbody></tbody>').attr('id', 'tbody').appendTo(table);
    
    $('<div></div>').attr({'class': 'ui active centered inline loader', 'id': 'loader'}).appendTo('#tbody');
    
    var url = "../service-painting.php";
    $.get(url)
    .done(function(data)
    {
        
        $.each(data, function(index, value)
        {
            printRow(index,value);
        });
        
        $('#artists').change(function()
        {
            $('#tbody').transition('slide left');
            $('#loader').attr('class', 'ui active centered inline loader');
            var url = "../service-painting.php?ArtistID="+$(this).val();
            $.get(url)
            .done(function(data)
            {
                $('#tbody').empty();
                $.each(data, function(index,value)
                {
                    printRow(index,value);
                });
            })
            .always(function(data)
            {
                $('#loader').attr('class', 'ui disabled loader');
                $('#tbody').transition('slide right');
            });
        })
        $('#museums').change(function()
        {
            $('#tbody').transition('slide left');
            $('#loader').attr('class', 'ui active centered inline loader');
            var url = "../service-painting.php?GalleryID="+$(this).val();
            $.get(url)
            .done(function(data)
            {
                $('#tbody').empty();
                $.each(data, function(index,value)
                {
                    printRow(index,value);
                });
            })
            .always(function(data)
            {
                $('#loader').attr('class', 'ui disabled loader');
                $('#tbody').transition('slide right');
            });
        });
        
        $('#shapes').change(function()
        {
            $('#tbody').transition('slide left');
            $('#loader').attr('class', 'ui active centered inline loader');
            var url = "../service-painting.php?ShapeID="+$(this).val();
            $.get(url)
            .done(function(data)
            {
                $('#tbody').empty();
                $.each(data, function(index,value)
                {
                    printRow(index,value);
                });
            })
            .always(function(data)
            {
                $('#loader').attr('class', 'ui disabled loader');
                $('#tbody').transition('slide right');
            });
        });
        
        $('img[name=painting]').on('mouseover', preview);
        $('img[name=painting]').on("mouseleave", removePreview);
        $('img[name=painting]').on("mousemove", movePreview);
        
        function printRow(index, value)
        {
            var row = $('<tr></tr>').appendTo('#tbody');
            var singleLink = $('<a>').attr('href', 'single-painting.php?id='+value.PaintingID);
            var image = $('<img>').attr({
                    'name': 'painting',
                    'src': 'images/art/works/square-medium/'+value.ImageFileName+'.jpg',
                    'alt': '...',
                    'id': 'artwork'});
            var imageData = $('<td></td>');
                    
            $(image).appendTo(singleLink);
            $(singleLink).appendTo(imageData);
            $(imageData).appendTo(row);
            
            var mainData = $('<td></td>').appendTo(row);
            
            var paintingTitle = $('<h3></h3>').attr('class', 'ui large header').append($('<a></a>').attr('href', 'single-painting.php?id='+value.PaintingID).html(value.Title));
            paintingTitle.appendTo(mainData);
            
            if(value.FirstName!=null)
            {
                var artistName = $('<h2></h2>').attr('class', 'ui sub header').append($('<a></a>').attr('href', 'single-artist.php?id='+value.ArtistID).html(value.FirstName+' '+value.LastName));
                artistName.appendTo(mainData);
            }
            else
            {
                var artistName = $('<h2></h2>').attr('class', 'ui sub header').append($('<a></a>').attr('href', 'single-artist.php?id='+value.ArtistID).html(value.LastName));
                artistName.appendTo(mainData);
            }
            
            var description = $('<p></p>').html(value.Description);
            description.appendTo(mainData);
            
            var msrp = $('<p></p>').html('$'+ Math.floor(value.MSRP));
            msrp.appendTo(mainData);
            
            var cartLink = $('<a></a>').attr('href', 'cart.php?id='+value.PaintingID+'&from=browse');
            var cartButton = $('<button></button>').attr('class', 'ui orange button');
            var cartIcon = $('<i></i>').attr('class', 'shop icon');
            $(cartIcon).appendTo(cartButton);
            $(cartButton).appendTo(cartLink);
            $(cartLink).appendTo(mainData);
            
            var favoriteLink = $('<a></a>').attr('href', 'favorites.php?type=painting&id='+value.PaintingID);
            var favoriteButton = $('<button></button>').attr('class', 'ui button')
            var favoriteIcon = $('<i></i>').attr('class', 'heart icon');
            $(favoriteIcon).appendTo(favoriteButton);
            $(favoriteButton).appendTo(favoriteLink);
            $(favoriteLink).appendTo(mainData);
        }
    })
    .always(function(data)
    {
        $('#loader').attr('class', 'ui disabled loader');
    });
});

function preview(e){
    var src = $(e.target).attr('src');
    var newSrc = src.replace("square-medium", "average");
    var preview = $('<div id="preview" class="ui floating message"></div>').css({"display":"block","position":"fixed"});
    var image = $('<img src="' + newSrc + '">');
    
    preview.append(image);
    $('body').append(preview);
    $("#preview").fadeIn(1000);
}

function movePreview(e){
    $("#preview")
    .css("top", "10%")
    .css("left", "50%");
}

function removePreview(e){ 
    $("#preview").remove(); 
}