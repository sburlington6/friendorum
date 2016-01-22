$(document).ready(function(){
  
    $("div.subnav").parent().prepend("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)  

    $("ul.topnav li span").click(function(event) { //When trigger is clicked...  
  
        //Following events are applied to the subnav itself (moving subnav up and down)  
        $(this).parent().find("div.subnav").slideToggle('fast'); //toggle the subnav on click  
        $(this).toggleClass("subhover"); //On click toggle class "subhover"
        
        event.stopPropagation(); //stop clicking the span from triggering document.click   
    }); 
    
    $("div.subnav").click(function(event) { 
        event.stopPropagation(); //stop clicking the div from triggering document.click   
    }); 

    //when you clikc outside the span
    $(document).click(function() {
        $("ul.topnav li span").parent().find("div.subnav").slideUp('fast'); //toggle the subnav on click  
        $("ul.topnav li span").removeClass("subhover"); //On click toggle class "subhover"
    });
  
}); 
