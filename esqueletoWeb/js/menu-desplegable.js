$(document).ready(function()
{
$(".firstpane h3.menu_head").click(function()
{
$(this).css({backgroundImage:""}).next("ul.menu_body").slideToggle(300).siblings("ul.menu_body").slideUp("slow");
$(this).siblings().css({backgroundImage:""});
});

});
