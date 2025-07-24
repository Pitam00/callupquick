$(document).ready(function(){
    $(".sidenav_li").click(function(){
        $(".sidenav_li").removeClass("active_menu");
        $(this).addClass("active_menu");
    })
    $(".sidenav_navlink").click(function(){
      $(".sidenav_navlink").removeClass("activeItem");
      $(this).addClass("activeItem");
    })
})


$(".sidenav_navlink").click(function(){
    // $("#page_wrapper").find();
  
    let myid = $(this).attr("id");
    console.log($(this).attr("id"));
    let mnn = $("#page_wrapper").find('.'+myid);
    console.log(mnn);
  
    $(".main-content").removeClass("active_content")
    mnn.addClass("active_content")
  })