function initSparkline() {
    $(".sparkline").each(function () {
        var e = $(this);
        e.sparkline("html", e.data())
    })
}

function skinChanger() {
    $(".choose-skin li").on("click", function () {
        var e = $("body"), t = $(this), a = $(".choose-skin li.active").data("theme");
        $(".choose-skin li").removeClass("active"), e.removeClass("theme-" + a), t.addClass("active"), e.addClass("theme-" + t.data("theme"))
    })
}

$(function () {
    "use strict";
    skinChanger(), initSparkline(), setTimeout(function () {
        $(".page-loader-wrapper").fadeOut()
    }, 50)
}), $(document).ready(function () {
    $("#main-menu").metisMenu({preventDefault: !1}), $(".btn-toggle-fullwidth").on("click", function () {
        $("body").hasClass("layout-fullwidth") ? $("body").removeClass("layout-fullwidth") : $("body").addClass("layout-fullwidth"), $(this).find(".fa").toggleClass("fa-arrow-left fa-arrow-right")
    }), $(".dropdown").on("show.bs.dropdown", function () {
        $(this).find(".dropdown-menu").first().stop(!0, !0).animate({top: "100%"}, 200)
    }), $(".dropdown").on("hide.bs.dropdown", function () {
        $(this).find(".dropdown-menu").first().stop(!0, !0).animate({top: "80%"}, 200)
    }), $('.navbar-form.search-form input[type="text"]').on("focus", function () {
        $(this).animate({width: "+=50px"}, 300)
    }).on("focusout", function () {
        $(this).animate({width: "-=50px"}, 300)
    }), 0 < $('[data-toggle="tooltip"]').length && $('[data-toggle="tooltip"]').tooltip(), 0 < $('[data-toggle="popover"]').length && $('[data-toggle="popover"]').popover(), $(window).on("load", function () {
        $("#main-content").height() < $("#left-sidebar").height() && $("#main-content").css("min-height", $("#left-sidebar").innerHeight() - $("footer").innerHeight())
    }), $(window).on("load resize", function () {
        $(window).innerWidth() < 420 ? $(".navbar-brand logo.svg").attr("src", "../assets/images/logo-icon.svg") : $(".navbar-brand logo-icon.svg").attr("src", "../assets/images/logo.svg")
    })
}), $.fn.clickToggle = function (t, a) {
    return this.each(function () {
        var e = !1;
        $(this).bind("click", function () {
            return e ? (e = !1, a.apply(this, arguments)) : (e = !0, t.apply(this, arguments))
        })
    })
}, $(".select-all").on("click", function () {
    this.checked ? $(this).parents("table").find(".checkbox-tick").each(function () {
        this.checked = !0
    }) : $(this).parents("table").find(".checkbox-tick").each(function () {
        this.checked = !1
    })
}), $(".checkbox-tick").on("click", function () {
    $(this).parents("table").find(".checkbox-tick:checked").length == $(this).parents("table").find(".checkbox-tick").length ? $(this).parents("table").find(".select-all").prop("checked", !0) : $(this).parents("table").find(".select-all").prop("checked", !1)
}), window.lucid = {
    colors: {
        blue: "#467fcf",
        "blue-darkest": "#0e1929",
        "blue-darker": "#1c3353",
        "blue-dark": "#3866a6",
        "blue-light": "#7ea5dd",
        "blue-lighter": "#c8d9f1",
        "blue-lightest": "#edf2fa",
        azure: "#45aaf2",
        "azure-darkest": "#0e2230",
        "azure-darker": "#1c4461",
        "azure-dark": "#3788c2",
        "azure-light": "#7dc4f6",
        "azure-lighter": "#c7e6fb",
        "azure-lightest": "#ecf7fe",
        indigo: "#6574cd",
        "indigo-darkest": "#141729",
        "indigo-darker": "#282e52",
        "indigo-dark": "#515da4",
        "indigo-light": "#939edc",
        "indigo-lighter": "#d1d5f0",
        "indigo-lightest": "#f0f1fa",
        purple: "#a55eea",
        "purple-darkest": "#21132f",
        "purple-darker": "#42265e",
        "purple-dark": "#844bbb",
        "purple-light": "#c08ef0",
        "purple-lighter": "#e4cff9",
        "purple-lightest": "#f6effd",
        pink: "#f66d9b",
        "pink-darkest": "#31161f",
        "pink-darker": "#622c3e",
        "pink-dark": "#c5577c",
        "pink-light": "#f999b9",
        "pink-lighter": "#fcd3e1",
        "pink-lightest": "#fef0f5",
        red: "#e74c3c",
        "red-darkest": "#2e0f0c",
        "red-darker": "#5c1e18",
        "red-dark": "#b93d30",
        "red-light": "#ee8277",
        "red-lighter": "#f8c9c5",
        "red-lightest": "#fdedec",
        orange: "#fd9644",
        "orange-darkest": "#331e0e",
        "orange-darker": "#653c1b",
        "orange-dark": "#ca7836",
        "orange-light": "#feb67c",
        "orange-lighter": "#fee0c7",
        "orange-lightest": "#fff5ec",
        yellow: "#f1c40f",
        "yellow-darkest": "#302703",
        "yellow-darker": "#604e06",
        "yellow-dark": "#c19d0c",
        "yellow-light": "#f5d657",
        "yellow-lighter": "#fbedb7",
        "yellow-lightest": "#fef9e7",
        lime: "#7bd235",
        "lime-darkest": "#192a0b",
        "lime-darker": "#315415",
        "lime-dark": "#62a82a",
        "lime-light": "#a3e072",
        "lime-lighter": "#d7f2c2",
        "lime-lightest": "#f2fbeb",
        green: "#5eba00",
        "green-darkest": "#132500",
        "green-darker": "#264a00",
        "green-dark": "#4b9500",
        "green-light": "#8ecf4d",
        "green-lighter": "#cfeab3",
        "green-lightest": "#eff8e6",
        teal: "#2bcbba",
        "teal-darkest": "#092925",
        "teal-darker": "#11514a",
        "teal-dark": "#22a295",
        "teal-light": "#6bdbcf",
        "teal-lighter": "#bfefea",
        "teal-lightest": "#eafaf8",
        cyan: "#17a2b8",
        "cyan-darkest": "#052025",
        "cyan-darker": "#09414a",
        "cyan-dark": "#128293",
        "cyan-light": "#5dbecd",
        "cyan-lighter": "#b9e3ea",
        "cyan-lightest": "#e8f6f8",
        gray: "#868e96",
        "gray-darkest": "#1b1c1e",
        "gray-darker": "#36393c",
        "gray-dark": "#6b7278",
        "gray-light": "#aab0b6",
        "gray-lighter": "#dbdde0",
        "gray-lightest": "#f3f4f5",
        "gray-dark": "#343a40",
        "gray-dark-darkest": "#0a0c0d",
        "gray-dark-darker": "#15171a",
        "gray-dark-dark": "#2a2e33",
        "gray-dark-light": "#717579",
        "gray-dark-lighter": "#c2c4c6",
        "gray-dark-lightest": "#ebebec"
    }
};
var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date;
!function () {
    var e = document.createElement("script"), t = document.getElementsByTagName("script")[0];
    e.async = !0, e.src = "https://embed.tawk.to/5c6d4867f324050cfe342c69/default", e.charset = "UTF-8", e.setAttribute("crossorigin", "*"), t.parentNode.insertBefore(e, t)
}();
