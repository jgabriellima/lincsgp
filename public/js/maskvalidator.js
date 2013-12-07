/**
 * jquery.maskedinput-1.3.min
 */
(function($) {
    var pasteEventName = ($.browser.msie ? 'paste' : 'input') + ".mask";
    var iPhone = (window.orientation != undefined);

    $.mask = {
        //Predefined character definitions
        definitions: {
            '9': "[0-9]",
            'a': "[A-Za-z]",
            '*': "[A-Za-z0-9]"
        },
        dataName:"rawMaskFn"
    };

    $.fn.extend({
        //Helper Function for Caret positioning
        caret: function(begin, end) {
            if (this.length == 0) return;
            if (typeof begin == 'number') {
                end = (typeof end == 'number') ? end : begin;
                return this.each(function() {
                    if (this.setSelectionRange) {
                        this.setSelectionRange(begin, end);
                    } else if (this.createTextRange) {
                        var range = this.createTextRange();
                        range.collapse(true);
                        range.moveEnd('character', end);
                        range.moveStart('character', begin);
                        range.select();
                    }
                });
            } else {
                if (this[0].setSelectionRange) {
                    begin = this[0].selectionStart;
                    end = this[0].selectionEnd;
                } else if (document.selection && document.selection.createRange) {
                    var range = document.selection.createRange();
                    begin = 0 - range.duplicate().moveStart('character', -100000);
                    end = begin + range.text.length;
                }
                return {
                    begin: begin, 
                    end: end
                };
            }
        },
        unmask: function() {
            return this.trigger("unmask");
        },
        mask: function(mask, settings) {
            if (!mask && this.length > 0) {
                var input = $(this[0]);
                return input.data($.mask.dataName)();
            }
            settings = $.extend({
                placeholder: "_",
                completed: null
            }, settings);

            var defs = $.mask.definitions;
            var tests = [];
            var partialPosition = mask.length;
            var firstNonMaskPos = null;
            var len = mask.length;

            $.each(mask.split(""), function(i, c) {
                if (c == '?') {
                    len--;
                    partialPosition = i;
                } else if (defs[c]) {
                    tests.push(new RegExp(defs[c]));
                    if(firstNonMaskPos==null)
                        firstNonMaskPos =  tests.length - 1;
                } else {
                    tests.push(null);
                }
            });

            return this.trigger("unmask").each(function() {
                var input = $(this);
                var buffer = $.map(mask.split(""), function(c, i) {
                    if (c != '?') return defs[c] ? settings.placeholder : c
                });
                var focusText = input.val();

                function seekNext(pos) {
                    while (++pos <= len && !tests[pos]);
                    return pos;
                };
                function seekPrev(pos) {
                    while (--pos >= 0 && !tests[pos]);
                    return pos;
                };

                function shiftL(begin,end) {
                    if(begin<0)
                        return;
                    for (var i = begin,j = seekNext(end); i < len; i++) {
                        if (tests[i]) {
                            if (j < len && tests[i].test(buffer[j])) {
                                buffer[i] = buffer[j];
                                buffer[j] = settings.placeholder;
                            } else
                                break;
                            j = seekNext(j);
                        }
                    }
                    writeBuffer();
                    input.caret(Math.max(firstNonMaskPos, begin));
                };

                function shiftR(pos) {
                    for (var i = pos, c = settings.placeholder; i < len; i++) {
                        if (tests[i]) {
                            var j = seekNext(i);
                            var t = buffer[i];
                            buffer[i] = c;
                            if (j < len && tests[j].test(t))
                                c = t;
                            else
                                break;
                        }
                    }
                };

                function keydownEvent(e) {
                    var k=e.which;

                    //backspace, delete, and escape get special treatment
                    if(k == 8 || k == 46 || (iPhone && k == 127)){
                        var pos = input.caret(),
                        begin = pos.begin,
                        end = pos.end;

                        if(end-begin==0){
                            begin=k!=46?seekPrev(begin):(end=seekNext(begin-1));
                            end=k==46?seekNext(end):end;
                        }
                        clearBuffer(begin, end);
                        shiftL(begin,end-1);

                        return false;
                    } else if (k == 27) {//escape
                        input.val(focusText);
                        input.caret(0, checkVal());
                        return false;
                    }
                };

                function keypressEvent(e) {
                    var k = e.which,
                    pos = input.caret();
                    if (e.ctrlKey || e.altKey || e.metaKey || k<32) {//Ignore
                        return true;
                    } else if (k) {
                        if(pos.end-pos.begin!=0){
                            clearBuffer(pos.begin, pos.end);
                            shiftL(pos.begin, pos.end-1);
                        }

                        var p = seekNext(pos.begin - 1);
                        if (p < len) {
                            var c = String.fromCharCode(k);
                            if (tests[p].test(c)) {
                                shiftR(p);
                                buffer[p] = c;
                                writeBuffer();
                                var next = seekNext(p);
                                input.caret(next);
                                if (settings.completed && next >= len)
                                    settings.completed.call(input);
                            }
                        }
                        return false;
                    }
                };

                function clearBuffer(start, end) {
                    for (var i = start; i < end && i < len; i++) {
                        if (tests[i])
                            buffer[i] = settings.placeholder;
                    }
                };

                function writeBuffer() {
                    return input.val(buffer.join('')).val();
                };

                function checkVal(allow) {
                    //try to place characters where they belong
                    var test = input.val();
                    var lastMatch = -1;
                    for (var i = 0, pos = 0; i < len; i++) {
                        if (tests[i]) {
                            buffer[i] = settings.placeholder;
                            while (pos++ < test.length) {
                                var c = test.charAt(pos - 1);
                                if (tests[i].test(c)) {
                                    buffer[i] = c;
                                    lastMatch = i;
                                    break;
                                }
                            }
                            if (pos > test.length)
                                break;
                        } else if (buffer[i] == test.charAt(pos) && i!=partialPosition) {
                            pos++;
                            lastMatch = i;
                        }
                    }
                    if (!allow && lastMatch + 1 < partialPosition) {
                        input.val("");
                        clearBuffer(0, len);
                    } else if (allow || lastMatch + 1 >= partialPosition) {
                        writeBuffer();
                        if (!allow) input.val(input.val().substring(0, lastMatch + 1));
                    }
                    return (partialPosition ? i : firstNonMaskPos);
                };

                input.data($.mask.dataName,function(){
                    return $.map(buffer, function(c, i) {
                        return tests[i]&&c!=settings.placeholder ? c : null;
                    }).join('');
                })

                if (!input.attr("readonly"))
                    input
                    .one("unmask", function() {
                        input
                        .unbind(".mask")
                        .removeData($.mask.dataName);
                    })
                    .bind("focus.mask", function() {
                        focusText = input.val();
                        var pos = checkVal();
                        writeBuffer();
                        var moveCaret=function(){
                            if (pos == mask.length)
                                input.caret(0, pos);
                            else
                                input.caret(pos);
                        };
                        ($.browser.msie ? moveCaret:function(){
                            setTimeout(moveCaret,0)
                        })();
                    })
                    .bind("blur.mask", function() {
                        checkVal();
                        if (input.val() != focusText)
                            input.change();
                    })
                    .bind("keydown.mask", keydownEvent)
                    .bind("keypress.mask", keypressEvent)
                    .bind(pasteEventName, function() {
                        setTimeout(function() {
                            input.caret(checkVal(true));
                        }, 0);
                    });

                checkVal(); //Perform initial check for existing values
            });
        }
    });
})(jQuery);



/**
 * Adicionando e mapeando validators
 */
//$(function() {
//    addMaskAndValidator(null);
//});


function addMaskAndValidatorObj(form){
    //    console.log(idform);
   
    var fieldsetCount = form.children().length;
    //console.log('fields: '+fieldsetCount);
    for(var i = 1; i <= fieldsetCount; ++i){
        form.children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            /**
             * Verifica se o campo possui mascara
             */
            var req = $(this).attr("req");
            if(req!=undefined)
            {
                $(this).blur(function(){
                    if($.trim($(this).val())==''){
                        $(this).addClass("alert-danger");
                    }else{
                        $(this).removeClass("alert-danger");
                    }
                });
            }
            //alert($(this).attr("id"));
            var mask = $(this).attr("mask");
            if(mask!=undefined&&mask!="")
            {
                //alert($(this).attr("id"));
                $("#"+$(this).attr("id")).mask(mask);
            }
            /**
             * Verifica se o campo precisa de uma validação especifica
             */
            var validator = $(this).attr("validator");
            if(validator!=undefined)
            {
                switch(validator){
                    case 'cnpj':
                        /**
                         * Verifica se o campo está preenchido
                         */
                        jq_cnpj($(this));
                        $(this).blur(function() {
                            jq_cnpj($(this));
                        });
                        break;
                        
                    case 'cpf':
                        /**
                         * Verifica se o campo está preenchido
                         */
                        jq_cpf($(this),false);
                        $(this).blur(function() {
                            jq_cpf($(this),true);
                        });
                        break;
                        
                    case 'email':
                        jq_email($(this),false);
                        $(this).blur(function() {
                            jq_email($(this));
                        });
                        break;
                        
                    case 'date':
                        jq_date($(this),false);
                        $(this).blur(function() {
                            jq_date($(this),true);
                        });
                        break;
                    case 'money':
                        $(this).keyup(function(){
                            $(this).val(MaskMonetario($(this).val()));
                        });
                        break;
                    case 'number':
                        //                        console.log($(this).attr('id'));
                        $(this).keyup(function(){
                            $(this).val(num( $(this).val()));
                        });
                        break;
                }
            }
        });
    }
}

function addMaskAndValidator(idform){
//    console.log(idform);
    var form;
    if(idform==null){
        form = "form";
    }else{
        form="#"+idform;
    }
    var fieldsetCount = $(form).children().length;
//    console.log('fields: '+fieldsetCount);
    for(var i = 1; i <= fieldsetCount; ++i){
        $(form).children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            /**
             * Verifica se o campo possui mascara
             */
            var req = $(this).attr("req");
            if(req!=undefined)
            {
                $(this).blur(function(){
                    if($.trim($(this).val())==''){
                        $(this).addClass("alert-danger");
                    }else{
                        $(this).removeClass("alert-danger");
                    }
                });
            }
            //alert($(this).attr("id"));
            var mask = $(this).attr("mask");
            if(mask!=undefined)
            {
                //alert($(this).attr("id"));
                $("#"+$(this).attr("id")).mask(mask);
            }
            /**
             * Verifica se o campo precisa de uma validação especifica
             */
            var validator = $(this).attr("validator");
            if(validator!=undefined)
            {
                switch(validator){
                    case 'cnpj':
                        /**
                         * Verifica se o campo está preenchido
                         */
                        jq_cnpj($(this));
                        $(this).blur(function() {
                            jq_cnpj($(this));
                        });
                        break;
                        
                    case 'cpf':
                        /**
                         * Verifica se o campo está preenchido
                         */
                        jq_cpf($(this),false);
                        $(this).blur(function() {
                            jq_cpf($(this),true);
                        });
                        break;
                        
                    case 'email':
                        jq_email($(this),false);
                        $(this).blur(function() {
                            jq_email($(this));
                        });
                        break;
                        
                    case 'date':
                        jq_date($(this),false);
                        $(this).blur(function() {
                            jq_date($(this),true);
                        });
                        break;
                    case 'money':
                        $(this).keyup(function(){
                            $(this).val(MaskMonetario($(this).val()));
                        });
                        break;
                    case 'number':
//                        console.log($(this).attr('id'));
                        $(this).keyup(function(){
                            $(this).val(num( $(this).val()));
                        });
                        break;
                }
            }
        });
    }
}

/**
* VALIDA CPF
*/
function valida_cpf(cpf){
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11){
        return false;
    }
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1))
        {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais)
    {
        numeros = cpf.substring(0,9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
            soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        numeros = cpf.substring(0,10);
        soma = 0;
        for (i = 11; i > 1; i--)
            soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}

function valida_cnpj(cnpj){
    /*remove ".", "-" e "/" utilizando expressão regular, assim
    * permite validar cnpj com ou sem pontos, barra e traço.*/
    cnpj = cnpj.replace(/[.\-\/]/g,"");
    if(cnpj.length != 14)
        return false;
    var dv = cnpj.substr(cnpj.length-2,cnpj.length);
    cnpj = cnpj.substr(0,12);
    /*calcular 1º dígito verificador*/
    var soma;
    soma = cnpj[0]*6;
    soma += cnpj[1]*7;
    soma += cnpj[2]*8;
    soma += cnpj[3]*9;
    soma += cnpj[4]*2;
    soma += cnpj[5]*3;
    soma += cnpj[6]*4;
    soma += cnpj[7]*5;
    soma += cnpj[8]*6;
    soma += cnpj[9]*7;
    soma += cnpj[10]*8;
    soma += cnpj[11]*9;
    var dv1 = soma%11;
    if (dv1 == 10){
        dv1 = 0;
    }
    /*calcular 2º dígito verificador*/
    soma = cnpj[0]*5;
    soma += cnpj[1]*6;
    soma += cnpj[2]*7;
    soma += cnpj[3]*8;
    soma += cnpj[4]*9;
    soma += cnpj[5]*2;
    soma += cnpj[6]*3;
    soma += cnpj[7]*4;
    soma += cnpj[8]*5;
    soma += cnpj[9]*6;
    soma += cnpj[10]*7;
    soma += cnpj[11]*8;
    soma += dv1*9;
    var dv2 = soma%11;
    if (dv2 == 10){
        dv2 = 0;
    }
    var digito = dv1+""+dv2;
    if(dv == digito){ /*compara o dv digitado ao dv calculado*/
        return true;
    }else{
        return false;
    }
}

function valida_data(digData) 
{
    var bissexto = 0;
    var data = digData; 
    var tam = data.length;
    if (tam == 10) 
    {
        var dia = data.substr(0,2)
        var mes = data.substr(3,2)
        var ano = data.substr(6,4)
        if ((ano > 1900)||(ano < 2100))
        {
            switch (mes) 
            {
                case '01':
                case '03':
                case '05':
                case '07':
                case '08':
                case '10':
                case '12':
                    if  (dia <= 31) 
                    {
                        return true;
                    }
                    break
                                
                case '04':              
                case '06':
                case '09':
                case '11':
                    if  (dia <= 30) 
                    {
                        return true;
                    }
                    break
                case '02':
                    /* Validando ano Bissexto / fevereiro / dia */ 
                    if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) 
                    { 
                        bissexto = 1; 
                    } 
                    if ((bissexto == 1) && (dia <= 29)) 
                    { 
                        return true;                             
                    } 
                    if ((bissexto != 1) && (dia <= 28)) 
                    { 
                        return true; 
                    }                       
                    break                                           
            }
        }
    }       
    return false;
}

function valida_email(email)
{
    var txt = email;
    if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 7)))
    {
        return false;
    }
    return  true;
}


function jq_email(comp,blur)
{
    if($.trim(comp.val())!=''){
        var email = comp.val();
        if(!valida_email(email)){
            comp.addClass("alert-danger");
        }else{
            comp.removeClass("alert-danger");
        }
    }else{
        /**
         * Caso ele não esteja preenchido, verifica se é obrigatório
         */
        if(blur){
            var req = comp.attr("req");
            if(req!=undefined)
            {
                if($.trim(comp.val())==''){
                    comp.addClass("alert-danger");
                }else{
                    comp.removeClass("alert-danger");
                }
            }else{
                comp.removeClass("alert-danger");
            }
        }
    }
}

function jq_date(comp,blur){
    if($.trim(comp.val())!=''){
        var data =comp.val();
//        console.log(data);
//        console.log(valida_data(data));
        if(!valida_data(data)){
            comp.addClass("alert-danger");
        }else{
            comp.removeClass("alert-danger");
        }
    }else{
        /**
                                 * Caso ele não esteja preenchido, verifica se é obrigatório
                                 */
        if(blur){
            var req = comp.attr("req");
            if(req!=undefined)
            {
                if($.trim(comp.val())==''){
                    comp.addClass("alert-danger");
                }else{
                    comp.removeClass("alert-danger");
                }
            }else{
                comp.removeClass("alert-danger");
            }
        }
    }
}

function jq_cnpj(comp)
{
    if($.trim(comp.val())!==''){
        var cnpj = comp.val();
        cnpj = cnpj.replace(".","").replace(".","").replace("-", "");
        if(!valida_cnpj(cnpj)){
            comp.addClass("alert-danger");
        }else{
            comp.removeClass("alert-danger");
        }
    }else{
        /**
         * Caso ele não esteja preenchido, verifica se é obrigatório
         */
        var req = comp.attr("req");
        if(req!=undefined)
        {
            if($.trim(comp.val())==''){
                comp.addClass("alert-danger");
            }else{
                comp.removeClass("alert-danger");
            }
        }else{
            comp.removeClass("alert-danger");
        }
    }
}
function jq_cpf(comp,blur)
{
    if($.trim(comp.val())!==''){
        var cpf = comp.val();
        cpf = cpf.replace(".","").replace(".","").replace("-", "");
        if(!valida_cpf(cpf)){
            comp.addClass("alert-danger");
        //$(this).focus();
        }else{
            comp.removeClass("alert-danger");
        }
    }else{
        /**
         * Caso ele não esteja preenchido, verifica se é obrigatório
         */
        if(blur){
            var req = comp.attr("req");
            if(req!=undefined)
            {
                if($.trim(comp.val())==''){
                    comp.addClass("alert-danger");
                }else{
                    comp.removeClass("alert-danger");
                }
            }else{
                comp.removeClass("alert-danger");
            }
        }
    }
}

/*========================================MASCARAS MONETARIAS========================================================*/
/*Fun��o Pai de Mascaras*/
function Mascara(o,f){
    v_obj=o
    v_fun=f
    //    setTimeout("execmascara()",1)
    v_obj.value=v_fun(v_obj.value);
}
/*Fun��o que Executa os objetos*/
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
/*Fun��o que Determina as express�es regulares dos objetos*/
function leech(v){
    v=v.replace(/o/gi,"0")
    v=v.replace(/i/gi,"1")
    v=v.replace(/z/gi,"2")
    v=v.replace(/e/gi,"3")
    v=v.replace(/a/gi,"4")
    v=v.replace(/s/gi,"5")
    v=v.replace(/t/gi,"7")
    return v
}
/*Fun��o que padroniza VALOR MONETARIO - R$*/
function MaskMonetario(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/(\d{2})$/,",$1");
    v=v.replace(/(\d+)(\d{3},\d{2})$/g,"$1.$2");
    var qtdLoop = (v.length-3)/3;
    var count = 0;
    while (qtdLoop > count){
        count++;
        v=v.replace(/(\d+)(\d{3}.*)/,"$1.$2");
    }
    v=v.replace(/^(0)(\d)/g,"$2");
    return v
}
function num(v){
    //    console.log(v);
    v=v.replace(/\D/g,"");
    return v
}

function validaForm(idform)
{
    var form;
    if(idform==null){
        form = "form";
    }else{
        form="#"+idform;
    }
    var  fieldsetCount  = $(form).children().length;
    var valido = true;
    for(var i = 1; i < fieldsetCount; ++i){
        $(form).children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
//            console.log($(this).attr("id"));
            var req = $(this).attr("req");
            if(req!=undefined)
            {
                if($.trim($(this).val())==''){
                    $(this).addClass("alert-danger");
                    valido = false;
                }else{
                    var val = $(this).attr("validator");
                    if(val==undefined){
                        $(this).removeClass("alert-danger");
                    }
                }
            }
            if($(this).hasClass('alert-danger')){
                valido = false;
//                console.log($(this).attr("validator")+" - "+$(this).attr("id"));
                val = $(this).attr("validator");
                if(val!=undefined){
                    //$(this).val('');
                }
            }
        });
    }
//    console.log('valido= '+valido);
    return valido;
}
function readForm(idform)
{
    var form;
    if(idform==null){
        form = "form";
    }else{
        form="#"+idform;
    }
    var fieldsetCount = $(form).children().length;
    var dataString='';
    for(var i = 1; i <= fieldsetCount; ++i){
        //    for(var i = 1; i < fieldsetCount; ++i){
        $(form).children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            if($(this).attr("type")=='checkbox'){
                if($(this).is(':checked')) {
                    dataString = dataString+'&'+$(this).attr("id")+'='+1;
                }else{
                    dataString = dataString+'&'+$(this).attr("id")+'='+'false';
                }
            }else{
                dataString = dataString+'&'+$(this).attr("id")+'='+$(this).val();
            }
        });
    }
    return dataString;
}
function readFormObj(idform)
{
    var form;
    if(idform==null){
        form = "form";
    }else{
        form="#"+idform;
    }
    var obj = {};
    var fieldsetCount = $(form).children().length;
    for(var i = 1; i <= fieldsetCount; ++i){
        $(form).children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            if($(this).attr("type")=='checkbox'){
                if($(this).is(':checked')) {
                    obj[$(this).attr("id")] = 1;
                }else{
                    obj[$(this).attr("id")] = false;
                }
            }else{
                obj[$(this).attr("id")] = $(this).val();
            }
        });
    }
    return obj;
}

function clearForm(idform)
{
    var form;
    if(idform==null){
        form = "form";
    }else{
        form="#"+idform;
    }
    var fieldsetCount = $(form).children().length;
    for(var i = 1; i <= fieldsetCount; ++i){
        $(form).children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            $(this).val('');
            $(this).removeClass('alert-danger');
        });
    }
}
function clearFormObj(form)
{
    var fieldsetCount = form.children().length;
    for(var i = 1; i <= fieldsetCount; ++i){
        form.children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            $(this).val('');
            $(this).removeClass('alert-danger');
        });
    }
}

function readStorage(iduser,idform)
{
    var fieldsetCount = $('form').children().length;
    for(var i = 1; i < fieldsetCount; ++i){
        $('form').children(':nth-child('+ parseInt(i) +')').find(':input:not(button)').each(function(){
            $(this).val(unescape(getValue_(iduser+'_'+$(this).attr("id")+'_'+idform)));
        });
    }
}

/**
 * START STORAGE
 */
function save(key,value)
{
    window.localStorage.setItem(key, value);
//    console.log('--> VALOR: '+window.localStorage.getItem(key));
}

function getValue(key,component)
{
    component.value = window.localStorage.getItem(key);
//    console.log('--> VALOR: '+key+" - "+component.value);
}
function getValue_(key)
{
    var value = window.localStorage.getItem(key);
    if(value == null)
    {
        return '';
    }else{
        return value;
    }
}