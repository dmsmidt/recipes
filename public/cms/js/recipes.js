/**
 * Created by pazuur on 20-2-16.
 */
$(function(){
    $('#sortable').on('click',function(){
        $(this).addLevelFields($(this));
    });
    $(document).ready(function(){
        $(this).addLevelFields(null);
    });

    $('.recipe .fields').on('click','.table_btn',function(){
        $btn = $(this);
        var name = $btn.data('rowname');
        if($btn.find('div').hasClass('icon-tree-expand')){
            $('.'+name).slideDown();
            $btn.find('div').removeClass('icon-tree-expand').addClass('icon-tree-collapse');
            if($btn.data('rowname') == 'row'){
                $('.table_btn').find('div').removeClass('icon-tree-expand').addClass('icon-tree-collapse');
            }
        }else{
            $('.'+name).slideUp();
            $btn.find('div').removeClass('icon-tree-collapse').addClass('icon-tree-expand');
            if($btn.data('rowname') == 'row'){
                $('.table_btn').find('div').removeClass('icon-tree-collapse').addClass('icon-tree-expand');
            }
        }
    });

    $('#btnAddField').click(function(){
        var $fields_table = $('#fields_table');
        var num_fields = $fields_table.find('> tbody > tr').length - 1;
        ajaxRequest(
            {
                method: 'newFieldRow',
                params: {'num_fields':num_fields},
                callback: 'appendFieldRow'
            }
        );
    });

    $('.recipe').on('click',' .btnDeleteFieldRow',function(){
        $button = $(this);
       $button.parent().parent().remove();
    });

    $.fn.addLevelFields = function(){
        if($('#sortable').is(':checked')){
            $('.sortable_levels').slideDown();
        }else{
            $('.sortable_levels').slideUp();
        }
    };

    appendFieldRow = function(html){
        $('#fields_table > tbody').append(html);
    };

    var $fields_table = $('#fields_table');

    $fields_table.on('change','.type_select',function(){
        var $this = $(this);
        var row = $this.data('row');
        var type = $this.val();
        ajaxRequest(
            {
                method: 'selectTypeOptions',
                params: {
                    'row':row,
                    'type':type},
                callback: 'addTypeOptions'
            }
        );
    });

    $fields_table.on('change','.input_select',function(){
        var $this = $(this);
        var row = $this.data('row');
        var input = $this.val();
        var $inputoptions_selector = $('#field_inputoptions_'+row);
        if(input == 'select' || input == 'checkbox' || input == 'radio'){
            $inputoptions_selector.prop('disabled',false);
        }else{
            $inputoptions_selector.prop('disabled',true);
            $('.inputoptionrow_'+row+' input').val('');
            $('.inputoptionrow_'+row).hide();
            $inputoptions_selector.val('');
        }
    });

    $fields_table.on('change','.field_inputoptions',function(){
        var $this = $(this);
        var row = $this.data('row');
        var input = $this.val();
        if(input == 'db_table'){
            $('.table_input_'+row).show();
            $('.array_input_'+row).hide();
        }
        else if(input == 'array'){
            $('.table_input_'+row).hide();
            $('.array_input_'+row).show();
        }else{
            $('.table_input_'+row).hide();
            $('.array_input_'+row).hide();
        }
    });

    $fields_table.on('click', '.btnAddArrayOption', function(){
        var $this = $(this);
        var parentrow = $this.data('row');
        var $table = $('.array_input_'+parentrow+' > table');
        var row = $table.find('> tbody > tr').length -2;
        console.log(row);
        var html = '<tr>'+
            '<td><input type="text" name="field['+parentrow+'][inputoptionslabel_array]['+row+']" id="field_'+parentrow+'_inputoptionslabel_array_'+row+'" value=""></td>'+
            '<td><input type="text" name="field['+parentrow+'][inputoptionsvalue_array]['+row+']" id="field_'+parentrow+'_inputoptionsvalue_array_'+row+'" value=""></td>'+
            '</tr>';
        $table.find('tr:last').after(html);
    });

    $('#btnAddRelation').click(function(){
       var relation =  $('#relationtype').val();
        switch(relation){
            case'has_one':
                addHasOne();
                break;
            case'has_many':
                addHasMany();
                break;
            case'many_many':
                addManyMany();
                break;
        }
    });

    /**
     * real time check on change name field if recipe class exists
     * @param string name
     */
    $('input[name=name]').change(function(){
        $input = $(this);
        value = $input.val();
        if(value.length && value != ''){
            ajaxRequest(
                {
                    method: 'recipeExists',
                    params: {
                        'name':value
                    },
                    callback: 'nameExistsMsg'
                }
            );
        }
    });

    $('input[name=table]').change(function(){
        $input = $(this);
        value = $input.val();
        if(value.length && value != ''){
            ajaxRequest(
                {
                    method: 'tableExists',
                    params: {
                        'table':value
                    },
                    callback: 'tableExistsMsg'
                }
            );
        }
    });

    nameExistsMsg = function(data){
       if(data.exists){
           $('.error_msg.name').text('This recipe already exists!');
       }else{
           $('.error_msg.name').text('');
       }
    };

    tableExistsMsg = function(data){
        if(data.exists){
            $('.error_msg.table').text('This table already exists!');
        }else{
            $('.error_msg.table').text('');
        }
    };

    $fields_table.on('click','.btnAddRule',function(){
        var row = $(this).data('row');
        var rule = $('#relationtype_'+row).val();
        $('.input_'+rule+'_'+row).slideDown();
    });

    addHasOne = function(){
        var $table = $('.hasone_table');
        var row = $table.find('> tbody > tr').length -1;
        var html = '<tr>'+
            '<td></td>'+
            '<td><input type="text" name="has_one['+row+'][table]" id="has_one_table_'+row+'" value=""></td>'+
            '<td><input type="checkbox" name="has_one['+row+'][inverse]" id="has_one_inverse_'+row+'" value="1"></td>'+
            '</tr>';
        $table.find('tbody > tr:last').after(html);
    };

    addHasMany = function(){
        var $table = $('.hasmany_table');
        var row = $table.find('> tbody > tr').length -1;
        var html = '<tr>'+
            '<td></td>'+
            '<td><input type="text" name="has_many['+row+'][table]" id="has_many_table_'+row+'" value=""></td>'+
            '<td><input type="checkbox" name="has_many['+row+'][inverse]" id="has_many_inverse_'+row+'" value="1"></td>'+
            '<td><input type="checkbox" name="has_many['+row+'][cascade]" id="has_many_cascade_'+row+'" value="1"></td>'+
            '</tr>';
        $table.find('tbody > tr:last').after(html);
    };

    addManyMany = function(){
        var $table = $('.manymany_table');
        var row = $table.find('> tbody > tr').length -1;
        var html = '<tr>'+
        '<td></td>'+
        '<td><input type="text" name="many_many['+row+'][table]" id="many_many_table_'+row+'" value=""></td>'+
        '<td>&nbsp;</td>'+
        '<td><input type="checkbox" name="many_many['+row+'][cascade]" id="many_many_cascade_'+row+'" value="1"></td>'+
        '</tr>';
        $table.find('tbody > tr:last').after(html);
    };

    addTypeOptions = function(data){
        var $container = $('#field_type_'+data.row);
        $container.parent().find('.row').remove();
        $container.after(data.html);
        $container.parent().find('.row').show();
    };

    /**
     * Backup recipe and classes
     */
    $('.btnBackupRecipe').click(function(){
        var $elem = $(this);
        var recipe = $elem.data('recipe');
        ajaxRequest(
            {
                method: 'backupRecipe',
                params: {
                    'recipe':recipe
                },
                callback: 'refreshWindow'
            }
        );
    });

    /**
     * Create/Remove recipes model class
     */
    $('.btnModelUpdate').click(function(){
        var $elem = $(this);
        var recipe = $elem.data('recipe');
        ajaxRequest(
            {
                method: 'createModel',
                params: {
                    'recipe':recipe
                },
                callback: 'refreshWindow'
            }
        );
    });

    /**
     * Create recipes controller class
     */
    $('.btnControllerUpdate').click(function(){
        var $elem = $(this);
        var recipe = $elem.data('recipe');
        ajaxRequest(
            {
                method: 'createController',
                params: {
                    'recipe':recipe
                },
                callback: 'refreshWindow'
            }
        );
    });

    /**
     * Create recipes repository class
     */
    $('.btnRepositoryUpdate').click(function(){
        var $elem = $(this);
        var recipe = $elem.data('recipe');
        ajaxRequest(
            {
                method: 'createRepository',
                params: {
                    'recipe':recipe
                },
                callback: 'refreshWindow'
            }
        );
    });

    /**
     * Create language resource files
     */
    $('.btnTranslationsUpdate').click(function(){
        var $elem = $(this);
        var recipe = $elem.data('recipe');
        ajaxRequest(
            {
                method: 'createTranslations',
                params: {
                    'recipe':recipe
                },
                callback: 'refreshWindow'
            }
        );
    });

    /**
     * Deletes all backup files of classes except for recipe
     */
    $('.btnDeleteBackups').click(function(){
        ajaxRequest(
            {
                method: 'deleteAllBackups',
                callback: ''
            }
        );
    });

    /**
     * Deletes all corresponding classes
     */
    $('.btnDeleteClasses').click(function(){
        ajaxRequest(
            {
                method: 'deleteClasses',
                params: $(this).data(),
                callback: 'refreshWindow'
            }
        );
    });

    /**
     * Deletes all backup files of classes except for recipe
     */
    $('.btnMigrate').click(function(){
        ajaxRequest(
            {
                method: 'migrateSchemas',
                callback: 'refreshWindow'
            }
        );
    });

});



