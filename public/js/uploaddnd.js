
(function ( $, window, undefined ) {
    $.fn.fileupload = function(options) {
        var obj;
        var el;
        var divparent;
        var el_;
        var dropArea = document.getElementById('dropArea');
        var canvas = document.querySelector('canvas');
        var context = canvas.getContext('2d');
        var list = [];
        var totalSize = 0;
        var totalProgress = 0;
        var listafiles = null;
        
        var defaults = {
            url : './',
            loadurl : './',
            deleteurl : './',
            id: $(this).attr("id"),
            limit:'',
            dropArea:'',
            count:'countcount',
            result:'result',
            list:''
        };
        
        var settings = $.extend( {}, defaults, options );
        obj =  settings;
        
        return this.each(function() {
            el = $(this);
            obj.result = document.getElementById(obj.result);
            obj.count = document.getElementById(obj.count);
            //
            el_ = document.getElementById(el.attr('id'));
            el_.addEventListener('drop', handleDrop, false);
            el_.addEventListener('dragover', handleDragOver, false);
            actionlistafiles();
        });
        
        function handleDragOver(event) {
            try{
                event.stopPropagation();
                event.preventDefault();
                el_.className = 'hover';
            }catch(e){
                console.log(e);
            }
        }

        // drag drop
        function handleDrop(event) {
            try{
                event.stopPropagation();
                event.preventDefault();
                processFiles(event.dataTransfer.files);
            }catch(e){
                console.log(e);
            }
        }
        
        function processFiles(filelist) {
            try{
                if (!filelist || !filelist.length || list.length) return;
                totalSize = 0;
                totalProgress = 0;
                obj.result.textContent = '';

                for (var i = 0; i < filelist.length && i < 5; i++) {
                    list.push(filelist[i]);
                    totalSize += filelist[i].size;
                }
                uploadNext();
            }catch(e){
                console.log(e);
            }
        }

        // on complete - start next file
        function handleComplete(size) {
            totalProgress += size;
            drawProgress(totalProgress / totalSize);
            uploadNext();
        }

        // update progress
        function handleProgress(event) {
            
            var progress = totalProgress + event.loaded;
            drawProgress(progress / totalSize);
        }

        // upload file
        function uploadFile(file, status) {
            try{
                // prepare XMLHttpRequest
                var xhr = new XMLHttpRequest();
        
                xhr.open('POST', obj.url);
                xhr.onload = function() {
                    handleComplete(file.size);
                    try{
                        $.each(JSON.parse(this.responseText)['dados'],function(key,value){
                            obj.result.innerHTML += value+"<br/>";
                        });
                        actionlistafiles();
                    }catch(e){
                        console.log(e);
                    }
                    $("#prog").hide();
                };
                xhr.onerror = function() {
                    obj.result.textContent = this.responseText;
                    handleComplete(file.size);
                };
                xhr.upload.onprogress = function(event) {
                    handleProgress(event);
                }
                xhr.upload.onloadstart = function(event) {
                }

                // prepare FormData
                var formData = new FormData();  
                formData.append('myfile', file); 
                xhr.send(formData);
            }catch(e){
                console.log('uploadFile: '+e);
            }
        }
        // upload next file
        function uploadNext() {
            try{
                if (list.length) {
                    //                count.textContent = list.length - 1;
                    el_.className = 'uploading';
                    var nextFile = list.shift();
                    if(obj.limit !=''){
                        if (nextFile.size >= parseInt(obj.limit)) { // 256kb
                            //                            $("#"+obj.output).append('<div class="f">Arquivo muito grande</div>');
                            $("#"+obj.output).append('<div class="f">Arquivo muito grande</div>');
                            handleComplete(nextFile.size);
                        } else {
                            uploadFile(nextFile, status);
                        }
                    }else {
                        uploadFile(nextFile, status);
                    }
                } else {
                    el_.className = '';
                }
                
            }catch(e){
                console.log(e);
            }
        }
        
        function drawProgress(progress) {
            context.clearRect(0, 0, canvas.width, canvas.height); // clear context

            context.beginPath();
            context.strokeStyle = '#4B9500';
            context.fillStyle = '#4B9500';
            context.fillRect(0, 0, progress * 500, 20);
            context.closePath();

            // draw progress (as text)
            context.font = '16px Verdana';
            context.fillStyle = '#000';
            context.fillText('Progress: ' + Math.floor(progress*100) + '%', 50, 15);
        }
        
        function actionlistafiles()
        {
            try{
                if(listafiles==null){
                    createlistafiles();
                }else{
                    listafiles.fnDraw();
                }
            }catch(e){
                console.log(e);
            }
        }
        function createlistafiles(){
            try{
                console.log('table...');
                listafiles = $('#'+obj.list).dataTable({
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": obj.loadurl,   
                    "aoColumns": [
                    {
                        "mData": "filename"
                    },
                    {
                        "mData": "type"
                    },
                    {
                        "mData": "size"
                    },
                    {
                        "mData": null, 
                        "fnRender" : function(obj) {
                            var deletar ='<a href="javascript:;" class="btn btn-danger" onclick="delfiles('+obj.iDataRow+')" ><i  class="icon-trash"></i></a>';
                            return deletar;
                        }
                    }
                    ],
                    "bPaginate":false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": false,
                    "bDestroy":true,
                    "bAutoWidth": false,
                    "oLanguage": {
                        "sSearch": "Buscar:",
                        "sProcessing":"Processando...",
                        "sLoadingRecords":"Carregando...",
                        "sLengthMenu":"Mostrando _MENU_ registros",
                        "sInfoFiltered": "(Filtrado de _MAX_ registros)",
                        "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sZeroRecords":"Nenhum registro encontrado",
                        "oPaginate": {
                            "sFirst": "Primeira",
                            "sLast": "Última",
                            "sNext": "Próxima",
                            "sPrevious": "Anterior"
                        }
			
                    }
                });
            }catch(e){
                console.log(e);
            }
        }

    };
}(jQuery, window));