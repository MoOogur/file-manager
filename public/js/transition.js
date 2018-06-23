$(function(){
   $('body').on('dblclick', '.folder', function(e){
       e.preventDefault;
       
        var dir = $(this).children().first().next().text(),
            field = $('.sort-active').attr('id'),
            currentIcon = $(this).children('.icon-sort'),
            sortType;
            
        if($(currentIcon).hasClass('fa-arrow-down')) {
            sortType = 'ascending';
        } else {
            sortType = 'descendingly';
        }    
        console.log(dir)
        $.ajax({ 
            type: 'POST', 
            url: 'src/ajax.php',
            data: {action: 'transition', dir: dir, field: field, sortType: sortType},
            dataType: 'json', 
            success: function(result){ 
                $('.folder').remove();
                $('.file').remove();
                
                $.each(result['folders'], function(indx, elmt){
                    var tr = '<tr class="folder"><td>';
                    
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
                    var tr = '<tr class="file"><td><i class="fas fa-file icon-file"></td>' +
                            '<td>' + elmt['name'] + '</td>' + '<td>' + elmt['type'] + '</td>' + '<td>' + elmt['size'] + '</td>' +
                            '<td>' + elmt['time'] + '</td></tr>';
                    
                    $(tr).appendTo('.table-dir');
                });
            }
        });
   }); 
});