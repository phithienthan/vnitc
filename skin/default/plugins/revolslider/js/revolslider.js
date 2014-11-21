var tpj = jQuery;

tpj.noConflict();

var revapi1;

tpj(document).ready(function () {

    if (tpj.fn.cssOriginal != undefined)
        tpj.fn.css = tpj.fn.cssOriginal;

    if (tpj('#rev_slider_1_1').revolution == undefined)
        revslider_showDoubleJqueryError('#rev_slider_1_1');
    else
        revapi1 = tpj('#rev_slider_1_1').show().revolution(
                {
                    delay: 5000,
                    startwidth: 730,
                    startheight: 190,
                    hideThumbs: 50,
                    thumbWidth: 100,
                    thumbHeight: 50,
                    thumbAmount: 3,
                    navigationType: "none",
                    navigationArrows: "none",
                    navigationStyle: "round-old",
                    touchenabled: "on",
                    onHoverStop: "on",
                    navOffsetHorizontal: 0,
                    navOffsetVertical: 20,
                    shadow: 0,
                    fullWidth: "off",
                    stopLoop: "off",
                    stopAfterLoops: -1,
                    stopAtSlide: -1,
                    shuffle: "off",
                    hideSliderAtLimit: 0,
                    hideCaptionAtLimit: 0,
                    hideAllCaptionAtLilmit: 0});

});	//ready