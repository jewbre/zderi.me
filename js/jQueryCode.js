/**
 * Created by Vilim Stubičan on 14.10.2014..
 */

/**
 * Setup startpoints for everything (listeners etc) after
 * document is finished with loading.
 */
$(document).ready(function() {
    // change to values from table (also, if not done, do CMS background for slider (VTAG)
    var sliderImages = ["res1.jpg", "res2.jpg", "res3.jpg", "res4.jpg" ];
    changeSlider( sliderImages , 0 );
})

/**
 *  Slider change function, do not touch !
 * @param data array of images names
 * @param step index of hidden image
 */
function changeSlider(data, step) {
    var size = data.length;
    var newStep = Math.round(Math.random()*93563,0) % size;
    while(newStep == step) {
        newStep = Math.round(Math.random()*93563,0) % size;
    }
    if($("#sliderImage1").css("display") == "none") {
        show = "#sliderImage1";
        hide = "#sliderImage2";
    } else {
        show = "#sliderImage2";
        hide = "#sliderImage1";
    }

    $(show).fadeIn("slow");
    $(hide).fadeOut("slow");

    setTimeout(function(){
        // wait until image is hidden to reload new one into frame
        $(hide).attr("src", "resources/images/"+data[newStep]+ "?" + new Date().getSeconds());
    },600);

    setTimeout(function(){
        changeSlider(data, newStep);
    },7000);
}
