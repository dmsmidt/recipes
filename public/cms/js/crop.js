// JavaScript Document
/**
 * By Patrick Zuurbier 2017
 * Revision 1.0.0.
 * Todo:
 */


$(function(){

    var data;
    var initialized = {};
    var origins = {};
    /**
     * OPEN DIALOG
     * @param data
     */
    showCrop = function(html)
    {
        var crop = $('#crop');
        crop.html(html);
        //find widest image of formats
        var dialog_width = 0;
        var dialog_height = 0;
        $('#crop .image_preview img').each(function(){
            var data = $(this).data();
            //dialog_width = data.width >= dialog_width ? data.width : dialog_width;
            //dialog_height = data.height >= dialog_height ? data.height : dialog_height;
            initialized[data.image_format] = false;
        });
        /*crop.css({
            width: dialog_width + 30,
            height: dialog_height + 200
        });*/
        data = $('#crop .image_preview.active img').data();
        crop.show('fast',function(){
            initCrop();
        });
        $('#dialogblocker').show();
    };

    /**
     * INIT CROP
     */
    initCrop = function(){
        var crop = $('#crop').find('.image_preview img.'+data.image_format);
        if(!initialized[data.image_format]){
            crop.Jcrop({
            onSelect:showCoords,
            onChange:showCoords,
            setSelect:[ 
                        data.x, 
                        data.y,
                        data.width + data.x,
                        data.height + data.y,
                        data.width,
                        data.height
                      ],
            aspectRatio: data.constraint ? data.width/data.height : 0
            },
            function(){
                //to prevent init jcrop element more than once
                initialized[data.image_format] = true;
            });
        }
    };

    /**
     * CLOSE DIALOG
     */
    closeCrop = function()
    {
        $('#crop').hide();
        $('#dialogblocker').hide();
        $('#dialog .buttons').empty();
    };

    //CANCEL CROP BUTTON
    $('body').on('click','#btnCropCancel',function(){
        closeCrop();
    });

    //SAVE CROP BUTTON
    $('body').on('click','#btnSaveCrop',function(){
        console.log('save crop');
    });

    //SWITCH FORMAT
    $('body').on('click','.btnImageFormat',function(){
        var btn_data = $(this).data();
        var format = btn_data.image_format;
        //switch active class
        $('.image_preview').removeClass('active');
        $('#'+format).addClass('active');
        //switch button active and set data
        $('.image_formats button').each(function(i, e){
            var format_data = $(e).data();
            $(e).removeClass('active');
            if( format == format_data.image_format){
                $(e).addClass('active');
                data = $('#'+format+' img').data();
                initCrop();
            }
        })
    });

    showCoords = function(c){
        console.log('coords: ', c, data.image_format);
        $('#crop').find('.'+data.image_format+'_x1').text(Math.round(c.x));
        $('#crop').find('.'+data.image_format+'_y1').text(Math.round(c.y));
        $('#crop').find('.'+data.image_format+'_x2').text(Math.round(c.x2));
        $('#crop').find('.'+data.image_format+'_y2').text(Math.round(c.y2));
        $('#crop').find('.'+data.image_format+'_width').text(Math.round(c.w));
        $('#crop').find('.'+data.image_format+'_height').text(Math.round(c.h));
    }
});
