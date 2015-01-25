$( document ).ready(function() 
{
    $('.with-image-preview').each(function()
    {
        var $input = $(this);
        var path = $input.data('image-path');
        
        if(path != undefined) 
        {
            var $img = $('<img class="thumbnail" src="'+path+'" />');
            
            $img.css({
                'max-width': 100,
                'max-height': 100,
                'margin-top': 5,
                'margin-bottom': 0
            });
        
            $input.parent().append($img);
        }
    });
});