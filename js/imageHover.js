$(function(){
    $('img[name=painting]').on('mouseover', preview);
    $('img[name=painting]').on("mouseleave", removePreview);
    $('img[name=painting]').on("mousemove", movePreview);
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
    .css("top", "5%")
    .css("left", "40%");
}

function removePreview(e){ 
    $("#preview").remove(); 
}