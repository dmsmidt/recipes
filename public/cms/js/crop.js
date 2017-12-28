// JavaScript Document
/**
 * By Patrick Zuurbier 2017
 * Revision 1.0.0.
 * Todo:
 */


$(function(){

    /**
     * OPEN DIALOG
     * @param data
     */
    showCrop = function(html)
    {
        var crop = $('#crop');
        crop.html(html);
        crop.show('fast',function(){
            initCrop();
        });
        $('#dialogblocker').show();
    }

    /**
     * INIT CROP
     */
    initCrop = function(){
        $('#crop').find('.image_preview img').Jcrop({

            //boxWidth: 500,
            //boxheight: 250
        });
    }

    /**
     * CLOSE DIALOG
     */
    closeCrop = function()
    {
        $('#crop').hide();
        $('#dialogblocker').hide();
        $('#dialog .buttons').empty();
    }

    //CANCEL CROP BUTTON
    $('body').on('click','#btnCropCancel',function(){
        closeCrop();
    });

    //SAVE CROP BUTTON
    $('body').on('click','#btnSaveCrop',function(){
        console.log('save crop');
    });
});
