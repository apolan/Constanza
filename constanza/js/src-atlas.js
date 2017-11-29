/*
 To change this license header, choose License Headers in Project Properties.
 To change this template file, choose Tools | Templates
 and open the template in the editor.
 */
/* 
 Created on : Nov 13, 2017, 8:05:34 AM
 Author     : apolan
 */
var xp = 0;

var offSet = 200;
var name = "aaaa";
var type = "";
var size = "";
var profesion = "";
var lugar = "";
var idRelation = 0;
var lightState = false;
var section;

//var soundBKG = new Audio(urlcanonical + "/sound/on-off.wav");
var noiseNeon_1 = new Audio(urlcanonical + "/sound/neon-noise.mp3");
init();
function init() {
    loadFont("KaufmannStd-Bold", "kf-b");
    loadFont("KaufmannStd", "kf-n");
    loadFont("Neoneon", "neon");
    loadFont("MyriadPro-Bold", "mp-b");
    loadFont("MyriadPro-Regular", "mp-n");
    loadFont("Adelle-SansLight", "as-l");
    loadFont("NeonTubes2", "nt-n");
    loadFont("cambria_bold", "cm-b");
// - - - - - - Page
    lightsOff("off");
    fillPhotos("#section-ad-1", 500);
    checkPage(page);

    if (page === "index" || page === "") {
        hideSection("", "INIT");
    }
    section = "home";
}

function loadFont(name, family) {
    var newStyle = document.createElement('style');
    newStyle.appendChild(document.createTextNode("\
    @font-face {\
        font-family: " + family + ";\
        src: url(" + urlcanonical + '/fonts/' + name + '.otf)' + ";\
    }\
    "));
    document.head.appendChild(newStyle);
}



function validateForm1() {
    actividad = $("#actividadNode").val();
    dueno = $("#duenoNode").val();
    lugar = $("#lugarNode").val();
    if (actividad === "" || dueno === "" || lugar === "") {
        alert("¡Hay que llenar toda la información!");
        return false;
    } else if (isNaN(size)) {
        alert("El tamaño debe ser un numero");
        return false;
    } else {
        console.log("ok");
        //cleanRelations();

        var text = "";
        var i = 0;
        $('.person').each(function () {
            text += $('#profesion_' + i).val() + "|";
            text += $('#nombre_' + i).val();
            text += "_"; // "this" is the current element in the loop
            i++;
        });
        console.log(text);
        var input = document.createElement('input');
        input.setAttribute("name", "relationNode");
        input.setAttribute("type", "text");
        input.setAttribute("class", "form-control");
        input.setAttribute("id", "relationNode");
        $("#menuBtn").prepend(input);
        $("#relationNode").val(text.substring(0, text.length - 1));
    }
}



$(document).ready(function () {
    $('a').novacancy({
        'reblinkProbability': (1 / 3),
        'blinkMin': 0.21,
        'blinkMax': 0.5,
        'loopMin': 0.5,
        'loopMax': 10,
        'color': 'White',
        'glow': ['0 0 80px White', '0 0 5px White', '0 0 2px white'],
        'off': 0,
        'blink': 0,
        'classOn': 'on',
        'classOff': 'off',
        'autoOn': true

    });
});

function randome(x, y) {
    var l = Math.floor(Math.random() * y) + x;
    return l;
}




function lightsOff(action) {
    console.log("action. " + action);
    var soundOn = new Audio(urlcanonical + "/sound/on-off.wav");
    if (action === "off") {
        soundOn.play();
        $("#on").css('background-color', 'rgba(26,26,26,' + 0.2 + ')');
        $("#off").css('background-color', 'rgba(26,26,26,' + 0.0 + ')');
        $(".lights").addClass("black80").removeClass("white40").removeClass("neonwhite");
        $(".lights-1").addClass("black80").removeClass("white").removeClass("neon-1");
        $(".lights-2").addClass("black80").removeClass("white").removeClass("neonwhite");
        lightState = false;

    } else if (action === "on") {
        soundOn.play();
        if (lightState === true) {
            return;
        }

        soundOn = new Audio(urlcanonical + "/sound/lights-on.wav");
        soundOn.play();

        //lightsOffAction();
        lightsOffAction();
        lightState = true;
        $("#on").css('background-color', 'rgba(26,26,26,' + 0.0 + ')');
        $("#off").css('background-color', 'rgba(26,26,26,' + 0.2 + ')');


        nextPage();
    } else {
        $("#on").css('background-color', 'rgba(26,26,26,' + 0.0 + ')');
        $("#off").css('background-color', 'rgba(26,26,26,' + 0.2 + ')');
    }
}

function lightsOffAction() {
    if (section === "home") {
        lightsONBySection("section-home");
        lightsONBySection("section-msj");
    }
}


function lightsONBySection(sectionOn) {

    $("#" + sectionOn + " .lights").addClass("white40").removeClass("black80");
    $("#" + sectionOn + " .lights-1").addClass("neon-1").addClass("white").removeClass("black80");
    $("#" + sectionOn + " .lights-2").addClass("neonwhite").addClass("white").removeClass("black80");
    $("#" + sectionOn + " .lights-3").addClass("neon-2").addClass("white").removeClass("black80");
    $("#" + sectionOn + " .lights-4").addClass("neon-3").addClass("white").removeClass("black80");

}

function lightsOFFBySection(sectionOn) {
    $("#" + sectionOn + " .lights").removeClass("white40").removeClass("neonwhite");
    $("#" + sectionOn + " .lights-1").removeClass("white").removeClass("neon-1");
    $("#" + sectionOn + " .lights-2").removeClass("white").removeClass("neonwhite");
    $("#" + sectionOn + " .lights-3").removeClass("white").removeClass("neon-2");
    $("#" + sectionOn + " .lights-4").removeClass("white").removeClass("neon-3");


}


function offLabel(id) {
    if ($("#" + id).text() === "On") {
        $("#" + id).text("Off");
    } else if ($("#" + id).text() === "Off") {
        $("#" + id).text("On");
    }
}







function hideSection(idSection, type) {
    if (type === "INIT") {
        $("#section-msj").hide();
        $("#btnLeer").hide();
        $("#section-title").hide();
        $("#btnQuien").hide();
        $("#section-publicidad").hide();
        $("#section-constanza").hide();
        $("#section-definicion").hide();
        $("#section-footer").hide();

    } else if (type === "ITEM") {
        $(idSection).hide();
    }
}




/**
 * Fill photos
 * @param {type} id
 * @param {type} max
 * @returns {undefined}
 */
function fillPhotos(id, max) {
    var i;
    for (i = 0; i < max; i++) {
        var photos = new Array();
        photos[i] = new Image();
        photos[i].src = urlcanonical + '/img/recibos/publicidad_' + rnd(1, 258) + '.jpg';
        //console.log(photos[i]);
        $(id).prepend(photos[i]);
    }
}

//Add people to an activity
function addRelation() {

    var iDiv = document.createElement('div');
    iDiv.className = 'person';
    iDiv.setAttribute("id", "person_" + idRelation);
    var label = document.createElement('label');
    var input = document.createElement('input');
    var label2 = document.createElement('label');
    var input2 = document.createElement('input');
    var label3 = document.createElement('label');
    var input3 = document.createElement('input');

    label.innerHTML = "Profesión: ";
    input.setAttribute("name", "relation_" + idRelation);
    input.setAttribute("type", "text");
    input.setAttribute("class", "form-control");
    input.setAttribute("id", "profesion_" + idRelation);
    label2.innerHTML = "Nombre:";
    input2.setAttribute("name", "nombre_" + idRelation);
    input2.setAttribute("type", "text");
    input2.setAttribute("class", "form-control");
    input2.setAttribute("id", "nombre_" + idRelation);
    iDiv.appendChild(label2);
    iDiv.appendChild(input2);
    iDiv.appendChild(label);
    iDiv.appendChild(input);
    $("#personas").append(iDiv);
    iDiv = document.createElement('div');
    iDiv.className = 'square';
    iDiv.setAttribute("id", "square" + idRelation);
    $("#relacionesImg").append(iDiv);
    // $('#square' + idRelation).prepend('<img id="theImg" src="' + urlcanonical + '/img/draw--' + randome(1,4) + '.png" />');

    idRelation++;
    $("#tag-rel").text("Relación #: " + idRelation);
}

function cleanRelations() {
    $("#personas").empty();
    idRelation = 0;
}



function scrollToAnchor(aid) {
    var aTag = $("a[name='" + aid + "']");
    $('html,body').animate({scrollTop: aTag.offset().top}, 'slow');
}


function rnd(min, max) {
    return Math.floor(Math.random() * max) + min;
}







$(window).on("scroll touchmove", function () {
    var position = $(document).scrollTop();
    //console.log("Scroll Page: " + position);
    console.log("section: " + section);

    if (page === "graph" || page === "recibos") {
        return;
    }

// Find what section 
    if (position > $("#section-home").position().top - offSet && position < $("#section-home").offset().top + $("#section-home").outerHeight(true) - offSet) {
//    lightsOff("off");
        section = "home";
    } else if (position >= $("#section-msj").position().top - offSet && position < $("#section-msj").offset().top + $("#section-msj").outerHeight(true) - offSet) {
        section = "mensaje";
    } else if (position >= $("#section-title").position().top - offSet && position < $("#section-title").offset().top + $("#section-title").outerHeight(true) - offSet) {
        section = "titulo";
    } else if (position >= $("#section-publicidad").position().top - offSet && position < $("#section-publicidad").offset().top + $("#section-publicidad").outerHeight(true) - offSet) {
        section = "publicidad-0";
        if (position >= ($("#0_preg").position().top + $("#0_preg").offsetParent().offset().top)
                && position < ($("#0_preg").position().top + $("#0_preg").offsetParent().offset().top) + $("#0_preg").outerHeight(true)) {
            section = "publicidad-1";
        } else if (position >= ($("#1_preg").position().top + $("#1_preg").offsetParent().offset().top)
                && position < ($("#1_preg").position().top + $("#1_preg").offsetParent().offset().top) + $("#1_preg").outerHeight(true)) {
            section = "publicidad-2";
        } else if (position >= ($("#2_preg").position().top + $("#2_preg").offsetParent().offset().top)
                && position < ($("#2_preg").position().top + $("#2_preg").offsetParent().offset().top) + $("#2_preg").outerHeight(true)) {
            section = "publicidad-3";
        } else if (position >= ($("#3_preg").position().top + $("#3_preg").offsetParent().offset().top)
                && position < ($("#3_preg").position().top + $("#3_preg").offsetParent().offset().top) + $("#3_preg").outerHeight(true)) {
            section = "publicidad-4";
        }
    } else if (position >= $("#section-constanza").position().top - offSet && position < $("#section-constanza").offset().top + $("#section-constanza").outerHeight(true) - offSet) {
        section = "constanza";

    } else if (position >= $("#section-definicion").position().top - offSet && position < $("#section-definicion").offset().top + $("#section-definicion").outerHeight(true) - offSet) {
        section = "recibo";
    }

//checkPage(page);
    optimizer("section");

});


/**
 * 
 * @param {type} type (section|)
 * @returns {undefined}
 */
function optimizer(type) {
    if (type === "section") {
        if (section === "home" && lightState) {

        } else if (section === "mensaje" && lightState) {

            lightsONBySection("section-title");
        } else if (section === "titulo" && lightState) {
            lightsOFFBySection("section-msj");
            lightsONBySection("0_preg");
            lightsONBySection("section-title");
        } else if (section === "publicidad-1" && lightState) {
            lightsOFFBySection("section-title");
            lightsONBySection("0_preg");
        } else if (section === "publicidad-2" && lightState) {
            lightsOFFBySection("0_preg");
            lightsONBySection("1_preg");
        } else if (section === "publicidad-3" && lightState) {
            lightsOFFBySection("1_preg");
            lightsONBySection("2_preg");
        } else if (section === "publicidad-4" && lightState) {
            lightsOFFBySection("2_preg");
            lightsONBySection("3_preg");
            lightsONBySection("section-constanza");
        } else if (section === "constanza" && lightState) {
            lightsOFFBySection("3_preg");
            lightsONBySection("section-constanza");
            lightsONBySection("section-definicion");
            nextPage();
        } else if (section === "recibo" && lightState) {
            lightsOFFBySection("section-constanza");
            nextPage();
        }
    } else if (type === "other") {

    }
}

function nextPage() {
    if (xp === 0) {
        $("#section-msj").show();
        $("#btnLeer").show();
        // document.querySelector('#section-msj').scrollIntoView({behavior: 'smooth'});
        $('html, body').animate({
            scrollTop: $("#section-msj").offset().top - offSet
        }, 2000);
        xp++;
    } else if (xp === 1) {
        hideSection("#btnLeer", "ITEM");

        $("#section-title").show();
        $("#btnQuien").show();
        $('html, body').animate({
            scrollTop: $("#section-title").offset().top + offSet
        }, 2000);
        xp++;
    } else if (xp === 2) {
        hideSection("#btnQuien", "ITEM");

        $("#section-publicidad").show();
        $("#section-constanza").show();

        $('html, body').animate({
            scrollTop: $("#0_preg").offset().top - (offSet / 2)
        }, 8000);
        xp++;
        /*} else if (xp === 3) {
         $('html, body').animate({
         scrollTop: $("#1_preg").offset().top - (offSet / 2)
         }, 6000);
         } else if (xp === 4) {
         $('html, body').animate({
         scrollTop: $("#2_preg").offset().top - (offSet / 2)
         }, 6000);
         } else if (xp === 5) {
         $('html, body').animate({
         scrollTop: $("#3_preg").offset().top - (offSet / 2)
         }, 6000);
         */
    } else if (xp === 3) {
        $("#section-definicion").show();
        $("#section-footer").show();
        xp++;
    } else {
        resultado = "Not find " + nextPage + " on " + "";
    }

}


function checkPage(pageName) {
    console.log("Page: " + pageName + " Section: " + section);
    if (pageName === "" || pageName === "index") { // home

        page = "index";
    } else if (pageName === "who") {
        lightsOff("on");
        page = "title";
    } else if (pageName === "img") {
    } else if (pageName === "recibos") {
        lightsONBySection("section-navegar");
        $("#section-footer").show();

    } else if (pageName === "graph") {
        lightsONBySection("section-surecibo");
        $("#section-footer").show();
    } else {
        resultado = "Not find " + pageName;
    }
}


function answer(pos, answ) {
    $("#" + pos + "_preg .rta h1").removeClass("clickable");
    if (answ === "yes") {
        $("#" + pos + "_preg .rta .no").removeClass("lights-3").removeClass("neon-2").addClass("black80");
    } else {
        $("#" + pos + "_preg .rta .yes").removeClass("lights-3").removeClass("neon-2").addClass("black80");
    }

    if (pos === 0) {
        $('html, body').animate({
            scrollTop: $("#1_preg").offset().top - (offSet / 2)
        }, 4000);
    } else if (pos === 1) {
        $('html, body').animate({
            scrollTop: $("#2_preg").offset().top - (offSet / 2)
        }, 4000);
    } else if (pos === 2) {
        $('html, body').animate({
            scrollTop: $("#3_preg").offset().top - (offSet / 2)
        }, 4000);
    } else if (pos === 3) {
        $('html, body').animate({
            scrollTop: $("#section-constanza").offset().top - (offSet / 2)
        }, 4000);
    }

}