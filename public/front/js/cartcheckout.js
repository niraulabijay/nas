//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
    // if(animating) return false;
    // animating = true;
    // current_fs = $(this).parent().parent().parent().parent().parent();
    // next_fs = $(this).parent().parent().parent().parent().parent().next();
    current_fs = $(this).parents('fieldset');
    next_fs=$(this).parents('fieldset').next();

    //activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("actively");

    //show the next fieldset
    // next_fs.show();
    next_fs.show();
    current_fs.hide();

});

$(".submit").click(function(){
    return false;
});