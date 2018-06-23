$(function(){
    $('.sort th').click('click', function(e){
        var iconArrowUp = '<i class="fas fa-arrow-up icon-sort"></i>',
            iconArrowDown = '<i class="fas fa-arrow-down icon-sort"></i>',
            currentIcon = $(this).children('.icon-sort'),
            field = $(this).attr('id'),
            sortType;
            
        if(field !== '' && field != 'icon') {
            if(currentIcon.length == 0) {
                $('.icon-sort').remove();
                $('.sort-active').removeClass();
                sortType = 'ascending';
                $(iconArrowDown).prependTo($(this));
                $(this).addClass('sort-active');
            } else {
                if(currentIcon.hasClass('fas fa-arrow-down icon-sort')) {
                    sortType = 'descendingly';
                    $(currentIcon).replaceWith(iconArrowUp);
                } else {
                    sortType = 'ascending';
                    $(currentIcon).replaceWith(iconArrowDown);
                }
            }

            $.ajax({ 
                type: 'POST', 
                url: 'src/ajax.php',
                data: {action: 'sort', field: field, sortType: sortType},
                dataType: 'json', 
                success: function(result){ 
                    $('.folder').remove();
                    $('.file').remove();
                    
                    $.each(result['folders'], function(indx, elmt){
                        var tr = '<tr class="folder"><td class="icon">';
                    
                        if(elmt['name'] == '..') {
                            tr += '<i class="fas fa-reply"></td>';
                        } else {
                            tr += '<i class="fas fa-folder icon-folder"></td>';
                        }

                        tr += '<td>' + elmt['name'] + '</td>' +  '<td></td>' +'<td><Папка></td>' +
                                '<td>' + elmt['time'] + '</td></tr>';

                        $(tr).appendTo('.table-dir');
                    });
                    
                
                    $.each(result['files'], function(indx, elmt){
                        var tr = '<tr class="file"><td class="icon"><i class="fas fa-file icon-file"></td>' +
                            '<td>' + elmt['name'] + '</td>' + '<td>' + elmt['type'] + '</td>' + '<td>' + elmt['size'] + '</td>' +
                            '<td>' + elmt['time'] + '</td></tr>';
                    
                        $(tr).appendTo('.table-dir');
                    });
                }
            });
        } 
    });
});


