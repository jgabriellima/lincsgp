
(function ( $, window, undefined ) {
    $.fn.selecteditor = function(options) {
        var obj;
        var el;
        var divparent;
        var defaults = {
            dataurl : './',
            inserturl : './',
            id: $(this).attr("id"),
            primarykey:'',
            params:'?',
            field:'value',
            outros:'Outros',
            outrosbool:true,
            selecione:'Selecione...',
            placeholder:'Insira um novo valor',
            debug:false,
            seleciona:''
        };
        var settings = $.extend( {}, defaults, options );
        obj =  settings;
        return this.each(function() {
            el = $(this);
            el.bind('change',function(){
                outros();
            });
            load();
        });
        function load(){
            try{
                if(localStorage.getItem(obj.dataurl)==null){
                $.getJSON(
                    obj.dataurl+obj.params,
                    function(json){
                        localStorage.setItem(obj.dataurl,JSON.stringify(json));
                        create(json,'');
                        if(obj.debug){
                            console.log(json)
                        }
                    });
                }else{
                    create(JSON.parse(localStorage.getItem(obj.dataurl)),'');
                }
            }catch(e){
                console.log(e);
            }
        }
    
        function create(json,value_){
            var options = "";

            options += '<option value="">Selecione...</option>';
            try{
                $.each(json, function(key, value){
                    if(value[obj.field] == value_){
                        options += '<option value="' + value[obj.primarykey] + '" selected="true" >' + value[obj.field] + '</option>';
                    }else if(obj.seleciona!='' && (obj.seleciona==value[obj.field]||obj.seleciona==value[obj.primarykey] )){
                        options += '<option value="' + value[obj.primarykey] + '" selected="true" >' + value[obj.field] + '</option>';
                    }else{
                        options += '<option value="' + value[obj.primarykey] + '">' + value[obj.field] + '</option>';
                    }
                });
            }catch(e){
                console.log(e);
            }
            
            if(obj.outrosbool){
                options += '<option value="'+obj.outros+'">'+obj.outros+'</option>';
            }
            if(obj.debug){
                console.log(options);
            }
            el.bind('change',function(){
                outros(el.val());
            });
            el.html(options);
            divparent.html(el);
        }

        function outros(val)
        {
            if(val == obj.outros){
                var inputfield = '<input id="'+obj.id+'" style="width: 100%;" placeholder="'+obj.placeholder+'" />';
                divparent = el.parent();
                //divparent.css('width','100%');
                divparent.html(inputfield);
                $('input#'+obj.id).focus();
                $('input#'+obj.id).bind('blur',function(){
                    insertselctvalue($(this));
                });
            }
        }
        function insertselctvalue(comp)
        {
            var val = comp.val();
            if(val == ""){
                el.val(obj.selecione);
                el.bind('change',function(){
                    outros(el.val());
                });
                divparent.html(el);
            }else{
                var dataString=obj.field+"="+comp.val();
                $.ajax({
                    type: "POST",
                    url: obj.inserturl+obj.params,
                    data: dataString,
                    dataType: "json",
                    success: function(json){
                        localStorage.setItem(obj.dataurl,JSON.stringify(json));
                        create(json,comp.val());
                    }
                });
            }
        }
    
    };
}(jQuery, window));