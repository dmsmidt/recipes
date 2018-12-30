// JavaScript Document

$(function(){
    //var changed = false;
    var atimer;
    var uri = $(location).attr('pathname');

    /**
     * PAGE BLOCKER AND AJAX PROGRESS INDICATOR
     */
    function startProgress()
    {
        $('#progress_cursor').show();
        // Set up a 30 Hz frame rate
        frameRate    =  30;
        timeInterval = Math.round( 1000 / frameRate );
        relMouseX    = 0;
        relMouseY    = 0;
        // get the stage offset
        offset = $('#pageblocker').offset();
        // start calling animateFollower at the 'timeInterval' we calculated above
        atimer = setInterval( "animateFollower()", timeInterval );
        // track and save the position of the mouse
        $('#pageblocker').mousemove( function(e) {
            mouseX = e.pageX;
            mouseY = e.pageY;
            relMouseX = mouseX - offset.left-15;
            relMouseY = mouseY - offset.top-15;
            // display the current mouse positions
            $('#mouse_x-trace').text( mouseX );
            $('#mouse_y-trace').text( mouseY );
        } );
        $('#pageblocker').show();
    }

    function stopProgress()
    {
        clearInterval(atimer);
        $('#pageblocker').hide();
        $('#progress_cursor').hide();
    }

    //AJAX SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    //progressindicator ajax
    $(document).ajaxStart(function()
    {
        startProgress();
    });
    $(document).ajaxStop(function()
    {
        stopProgress();
    });

    //DETECT CHANGING OF INPUT FIELDS
    $('input').change(function(){changed = true;});
    $('textarea').change(function(){changed = true;});
    $('select').change(function(){changed = true;});

    /**
     * EVENT LISTENERS
     */

    //EDIT BUTTON
    $('.btnEdit').click(function()
    {
        window.location.href = $(this).data('url');
    });

    //DELETE BUTTON
    $('.btnDelete').click(function()
    {
        /**
         * PHP: CmsController->dialog
         * @var $data ['url'], ['module'], ['id'], ['dialog']
         */
        ajaxRequest(
            {
                method: 'dialog',
                params: $(this).data(),
                callback: 'openDialog'
            }
        );
    });

    //DELETE IMAGE BUTTON
    $('.input .thumbs').on('click','.btnImageDelete', function()
    {
        /**
         * PHP: CmsController->dialog
         * @var $data ['id'], ['module'], ['dialog']
         */
        ajaxRequest(
            {
                method: 'dialog',
                params: $(this).data(),
                callback: 'openDialog'
            }
        );
    });

    $('form').on('click', '.btnCrop', function(){
        /**
         * PHP: CmsController->crop
         * @var $data ['id'], ['module'], ['dialog']
         */
        ajaxRequest(
            {
                method: 'crop',
                params: $(this).data(),
                callback: 'showCrop'
            }
        );
    });

    //ACTIVATE BUTTON
    $('.btnActivatable').click(function()
    {
        ajaxRequest(
            {
                method: 'toggleActivate',
                params: $(this).data(),
                callback: 'refreshWindow'
            }
        );
    });

    //PROTECT BUTTON
    $('.btnProtectable').click(function()
    {
        ajaxRequest(
            {
                method: 'toggleProtect',
                params: $(this).data(),
                callback: 'refreshWindow'
            }
        );
    });

    //LANGUAGE BUTTON
    $('.btnLang').click(function()
    {
        ajaxRequest(
            {
                method: 'switchLanguage',
                params: $(this).data(),
                callback: 'switchLanguage'
            }
        );
    });

    //GROUP TOGGLE EXPAND BUTTON
    $('.btnGroupExpand').click(function(){
        var $button = $(this);
        var group = $button.data('group');
        if($button.find('div').hasClass('far fa-plus-square')){
            $('.group[data-group="'+group+'"]').slideDown('fast',function(){
                $button.find('div').removeClass('far fa-plus-square');
                $button.find('div').addClass('far fa-minus-square');
            });
        }else{
            $('.group[data-group="'+group+'"]').slideUp('fast',function(){
                $button.find('div').removeClass('far fa-minus-square');
                $button.find('div').addClass('far fa-plus-square');
            });
        }
    });

    redirectToUrl = function(url){
        window.location = url;
    };

    switchLanguage = function(new_lang){
        //get the active language
        var current_lang = $('.flags .active').data('lang');
        var languages = [];
        //remove active class from flag buttons and build the languages array
        $('.flags').find('button').each(function(){
            var $button = $(this);
            $button.removeClass('active');
            var lang = $button.data('lang');
            if($.inArray(lang,languages) == -1){
                languages.push(lang);
            }
        });
        //add active class to clicked flag button
        $('.flags').find("[data-lang='"+new_lang+"']").addClass('active');
        //switch flag at default input field
        $('.lang_attr').removeClass('flag-'+current_lang)
            .addClass('flag-'+new_lang);
        //exchange language field values, loop through language fields in form
        $('input.language').each(function(key,field){
            var name = $(this).prop('name');
            //Determine if the input field name has an array format
                //If normal field name
                if(name.indexOf(current_lang) > 0){
                    var fieldName = extractLanguageField(name);
                    var $main_input = $('input[name="'+fieldName+'"], textarea[name="'+fieldName+'"]');
                    if($main_input.parent().hasClass('html')){
                        var current_val = tinyMCE.get(fieldName).getContent();
                        tinyMCE.get(fieldName).setContent($('input[name='+fieldName+'_'+new_lang+']').val());
                    }else{
                        var current_val = $main_input.val();
                        $main_input.val($('input[name='+fieldName+'_'+new_lang+']').val());
                    }
                    $('input[name='+fieldName+'_'+current_lang+']').val(current_val);
                }
            //}
        });
    };

    /**
     * update hidden language fields on change of default language field
     */
    if($('.translation').length){
        $('.translation').change(function(){
            var $this = $(this);
            var field_name = $this.attr('name');
            var current_lang = $('.flags .active').data('lang');
            if(field_name.indexOf('[') > 0){
                //the field name is an array type
                //@TODO array field name type
            }else{
                if($this.parent().hasClass('html')){
                    var value = tinyMCE.get(field_name).getContent();
                }else{
                    var value = $this.val();
                }
                $('input[name="'+field_name+'_'+current_lang+'"]').val(value);
            }
        });
    }

    /**
     * returns main input name of language field (ex. 'titel_en' or sub_titel_en)
     * assuming last underscore in string separates the language abbr.
     * @param field
     * @returns string
     */
    extractLanguageField = function(field){
        arrFieldParts = field.split('_');
        if(arrFieldParts.length > 2){
            var fieldName = '';
            for(var i = 0; i < arrFieldParts.length -1; i++){
                fieldName += arrFieldParts[i]+'_';
            }
            return fieldName.substring(0, fieldName.length - 1);
        }
        return arrFieldParts[0];
    };

    /**
     * CALL AJAX REQUEST
     * @param data
     */
    ajaxRequest = function(data){
        var method = data.method;
        var params = data.params;
        var callback = data.callback;
        var args = {'method':method,'params':params, 'callback':callback};
        $.ajax({
            type:'post',
            url: uri+'/ajax',
            data: args,
            dataType: 'json'
        }).done(function(data){
        if(data.error)
        {
            console.log(data);
            alert('Ajax request failed');
        }else{
            //console.log(data);
            if(data.callback != '' && data.callback != null){
                window[data.callback](data.args);
            }else{
                //
            }
        }
        }).fail(function(data){
            console.log(data);
            alert('Ajax request failed');
        });
    };

    /**
     * REFRESH BROWSER WINDOW
     */
    refreshWindow = function(){
        window.location = window.location;
    };

    /**
     * NESTABLE/SORTABLE
     */
    if($('#nestable').length){
        $('#nestable').nestable({
            group: 1,
            maxDepth: $('#nestable').data('levels')
        })
            .on('dragEnd', function(event, item, source, destination, position) {

                var parent_id = $(item).parent().parent().data('id');
                var actual_id = $(item).data('id');
                var prev_id   = position > 0 ? $(item).prev("li").data('id') : null;

                //console.log("id "+ actual_id + "\nparent_id: "+ parent_id +"\nposition:" + position + "\nprev_id : " +  prev_id);

                var params = {
                    id: actual_id,
                    parent_id: parent_id,
                    prev_id: prev_id,
                    position: position
                };
                ajaxRequest(
                    {
                        method: 'nestableUpdate',
                        params: params,
                        callback: ''
                    }
                );
            });
        // output initial serialised data
        $('#nestable').data('output', $('#nestable-output'));
    }


});

/**
 * OPEN ICON SELECT DIALOG
 */
iconSelectDialog = function(btn_id,current,source)
{
    ajaxRequest(
        {
            method: 'iconSelectDialog',
            params: {
                btn_id: btn_id,
                current: current,
                source: source
            }
        }
    );
}

/**
 * SELECT ICON
 */
selectIcon = function(elem, btn_id, current, source){

    if(source == 'frame'){
        $('#'+btn_id, $('iframe').contents()).removeClass(current).addClass($(elem).attr('data-icon'));
        $('#'+btn_id, $('iframe').contents()).attr('data-current',$(elem).attr('data-icon'));
        var input_id = btn_id.replace('Btn','');
        $('#'+input_id, $('iframe').contents()).val($(elem).attr('data-icon'));
    }else{
        $('#'+btn_id).removeClass(current).addClass($(elem).attr('data-icon'));
        $('#'+btn_id).attr('data-current',$(elem).attr('data-icon'));
        var input_id = btn_id.replace('Btn','');
        $('#'+input_id).val($(elem).attr('data-icon'));
    }

    closeDialog();
}

/**
 * HELPER FOR RESIZABLE
 * resizable plugin extension
 * to reverse resize an element
 */
$.ui.plugin.add("resizable", "alsoResizeReverse", {

    start: function () {
        var that = $(this).data("ui-resizable"),
            o = that.options,
            _store = function (exp) {
                $(exp).each(function() {
                    var el = $(this);
                    el.data("ui-resizable-alsoresize-reverse", {
                        width: parseInt(el.width(), 10), height: parseInt(el.height(), 10),
                        left: parseInt(el.css("left"), 10), top: parseInt(el.css("top"), 10)
                    });
                });
            };

        if (typeof(o.alsoResizeReverse) === "object" && !o.alsoResizeReverse.parentNode) {
            if (o.alsoResizeReverse.length) { o.alsoResizeReverse = o.alsoResizeReverse[0]; _store(o.alsoResizeReverse); }
            else { $.each(o.alsoResizeReverse, function (exp) { _store(exp); }); }
        }else{
            _store(o.alsoResizeReverse);
        }
    },

    resize: function (event, ui) {
        var that = $(this).data("ui-resizable"),
            o = that.options,
            os = that.originalSize,
            op = that.originalPosition,
            delta = {
                height: (that.size.height - os.height) || 0, width: (that.size.width - os.width) || 0,
                top: (that.position.top - op.top) || 0, left: (that.position.left - op.left) || 0
            },

            _alsoResizeReverse = function (exp, c) {
                $(exp).each(function() {
                    var el = $(this), start = $(this).data("ui-resizable-alsoresize-reverse"), style = {},
                        css = c && c.length ? c : el.parents(ui.originalElement[0]).length ? ["width", "height", "top", "left"] : ["width", "height", "top", "left"];

                    $.each(css, function (i, prop) {
                        var sum = (start[prop]||0) - (delta[prop]||0);
                        if (sum && sum >= 0) {
                            style[prop] = sum || null;
                        }
                    });

                    el.css(style);
                });
            };

        if (typeof(o.alsoResizeReverse) === "object" && !o.alsoResizeReverse.nodeType) {
            $.each(o.alsoResizeReverse, function (exp, c) { _alsoResizeReverse(exp, c); });
        }else{
            _alsoResizeReverse(o.alsoResizeReverse);
        }
    },

    stop: function () {
        $(this).removeData("resizable-alsoresize-reverse");
    }
});


animateFollower = function()
{
    $('#progress_cursor').css('left', relMouseX);
    $('#progress_cursor').css('top', relMouseY);
}