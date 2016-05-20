      $(document).on('ready pjax:success', function(){
    $('[name*="selection_all"]').bind('click', function (data) {
        selection_all = this.checked;
        if (selection_all) {
            $('[name$="selection[]"]').each(function (key, value) {
                if ($.cookie(cookieName)) {
                    selected = rangeDeCompress(JSON.parse($.cookie(cookieName)));
                    if ((selected.indexOf(parseInt($(this).attr("value"))) == -1)) {
                        selected.push(parseInt($(this).attr("value")));
                    }
                }
                else {
                    selected = [parseInt($(this).attr("value"))];
                }
                    $.cookie(cookieName,  null,{ useLocalStorage: false, path: "/",raw:true });
                    $.cookie(cookieName,  JSON.stringify(rangeCompress(selected)), { useLocalStorage: false, path: "/",raw:true});
            }
            )
        } else {
                $('[name$="selection[]"]').each(function (key, value) {
            if ($.cookie(cookieName)) {
                val=$(this).attr("value");
                selected = rangeDeCompress(JSON.parse($.cookie(cookieName)));
                index=selected.indexOf(parseInt(val));
                selected.splice(index, 1);
                 $.cookie(cookieName,  null,{ useLocalStorage: false, path: "/" ,raw:true});
                 $.cookie(cookieName,  JSON.stringify(rangeCompress(selected)), { useLocalStorage: false, path: "/" ,raw:true});
            }
                });

        }
    });
    $('[name$="selection[]"]').bind('click', function (data) {
                if ($.cookie(cookieName)){
                selected=rangeDeCompress(JSON.parse($.cookie(cookieName)));
                if (this.checked){
                    selected.push(parseInt($(this).attr("value")));
                } else {
                    selected.splice(selected.indexOf(parseInt($(this).attr("value"))), 1);
                    }
                } else {
                selected=[parseInt($(this).attr("value"))];
                    };
         $.cookie(cookieName,  null,{ useLocalStorage: false, path: "/" ,raw:true});
         $.cookie(cookieName,  JSON.stringify(rangeCompress(selected)), {useLocalStorage: false,  path: "/",raw:true });
    });
    });