$.notify.addStyle("metro", {
    html:
        "<div>" +
            "<div class='image' data-notify-html='image'/>" +
            "<div class='text-wrapper'>" +
                "<div class='title' data-notify-html='title'/>" +
                "<div class='text' data-notify-html='text'/>" +
            "</div>" +
        "</div>",
    classes: {
        error: {
            "color": "#fafafa !important",
            "background-color": "#F71919",
            "border": "1px solid #FF0026"
        },
        success: {
            "background-color": "#32CD32",
            "border": "1px solid #4DB149"
        },
        info: {
            "color": "#fafafa !important",
            "background-color": "#1E90FF",
            "border": "1px solid #1E90FF"
        },
        warning: {
            "background-color": "#FAFA47",
            "border": "1px solid #EEEE45"
        },
        black: {
            "color": "#fafafa !important",
            "background-color": "#333",
            "border": "1px solid #000"
        },
        white: {
            "background-color": "#f1f1f1",
            "border": "1px solid #ddd"
        }
    }
});

function notify(title,text,style) {
    var img = '';
    switch (style){
        default: img = '';
        case "error": img='<i class="fa fa-times-circle"></i>';   break;
        case "info": img='<i class="fa fa-info-circle"></i>'; break;
        case "success": img='<i class="fa fa-check"></i>'; break;
        case "warning": img='<i class="fa fa-warning"></i>'; break;
        case "black": img=''; break;
        case "white": img=''; break;
    }

    $.notify({title: title, text: text, image: img },
        {style: 'metro', className: style, autoHide: true, clickToHide: true });
}