// JavaScript Document
/**
 * By Patrick Zuurbier 2014
 * Revision 1.0.0.
 * Todo:
 */


$(function(){

    /**
     * OPEN DIALOG
     * @param data
     */
    openDialog = function(html)
    {
        $('#dialog').html(html);
        $('#dialog').show('fast',function(){
            $(this).find('#btnDialogCancel').focus();
        });
        $('#dialogblocker').show();
    }

    /**
     * CLOSE DIALOG
     */
    closeDialog = function()
    {
        $('#dialog').hide();
        $('#dialogblocker').hide();
        $('#dialog .buttons').empty();
    }

    //DIALOG OK BUTTON
    $('body').on('click','#btnDialogOk',function(){
        closeDialog();
    });

    //DIALOG CANCEL BUTTON
    $('body').on('click','#btnDialogCancel',function(){
        closeDialog();
    });

    //DIALOG CLOSE AND REFRESH PAGE BUTTON
    $('body').on('click','#btnDialogCloseRefresh',function(){
        closeDialog();
        window.location = window.location;
    });

    //DIALOG CLOSE BUTTON
    $('body').on('click','#btnDialogClose',function(){
        closeDialog();
    });
});
