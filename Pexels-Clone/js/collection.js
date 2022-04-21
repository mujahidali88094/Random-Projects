function solvePic(a){
    a.src = "https://localhost/img/photos/userpic.png";
}
var currentAnimationDurationFactor = 1;
var entered = false;
// animateCrossToTick();
function animateCrossToTick(ct,tc) {

    if (true) {

        ct.animate([{
            "transform": "rotate(180deg)",
            offset: 0,
            easing: "cubic-bezier(0.4, 0, 0.2, 1)"
        }, {
            "transform": "rotate(360deg)",
            offset: 1
        }], {
            duration: 300 * currentAnimationDurationFactor,
            fill: "forwards"
        });
    }
    var duration = 300 * currentAnimationDurationFactor;
    var crossToTickPathAnimation = tc;
    crossToTickPathAnimation.setAttributeNS(null, 'dur', duration + 'ms');
    crossToTickPathAnimation.beginElement();
}

function animateTickToCross(ct,tc) {

    if (true) {
        ct.animate([{
            "transform": "rotate(0deg)",
            offset: 0,
            easing: "cubic-bezier(0.4, 0, 0.2, 1)"
        }, {
            "transform": "rotate(180deg)",
            offset: 1
        }], {
            duration: 300 * currentAnimationDurationFactor,
            fill: "forwards"
        });
    }
    var duration = 300 * currentAnimationDurationFactor;
    var tickToCrossPathAnimation = tc;
    tickToCrossPathAnimation.setAttributeNS(null, 'dur', duration + 'ms');
    tickToCrossPathAnimation.beginElement();
}

function toggleAnimation(ct,tc) {
    if (entered) {
        animateTickToCross(ct,tc);
    } else {
        animateCrossToTick(ct,tc);
    }
    //isIconTick = !isIconTick;
}

document.addEventListener("DOMContentLoaded", function(event) {

    ticks();
});

function ticks(){

    $(".check").on("mouseenter", function(e) {
        entered = true;
        toggleAnimation($(e.target).find(".cross_tick_container_rotate")[0],$(e.target).find(".tick_to_cross_path_animation")[0]);
        e.stopImmediatePropagation();
        e.stopPropagation();
    });

    $(".check").on("mouseleave", function(e) {
        entered = false;
        toggleAnimation($(e.target).find(".cross_tick_container_rotate")[0],$(e.target).find(".cross_to_tick_path_animation")[0]);
        e.stopImmediatePropagation();
        e.stopPropagation();
    });

    $( ".check" ).each(function( index ) {
        var k =$( this ).find("svg")[0];
        var j = k.dataset.traveresed;

        if(j!="true")
            toggleAnimation($(k).find(".cross_tick_container_rotate")[0],$(k).find(".cross_to_tick_path_animation")[0]) ;
        k.setAttribute("data-traveresed","true");
    });


    $(".ListInnerBigDiv").on("click",function(e){
        var c = $($(e.currentTarget).find(".check")[0]);



        var photo = $("#createCollectionButton").attr("data-id");
        var collection = e.currentTarget.dataset.id;
        $.ajax({
            type: "POST",
            url: "https://localhost/img/driver.php",
            data: "pid="+photo+"&collection="+collection+"&toggleCollection=",
        }).done(function (d) {
            if(d == "9e5dsftr6"){
                $(e.currentTarget).prepend("<i class='fa fa-camera fa-10x'></i>").css("background","#d3d3d35c");
            }  
            else{
                var k = $($(e.currentTarget).find(".fa-camera")[0]);
                k.remove();

                $(e.currentTarget).css("background","url(https://localhost/img/"+d+")");


            }


        });

        //$($(e.currentTarget).find("svg")[0]).toggle();
        e.stopImmediatePropagation();
        e.stopPropagation();
        if(c.hasClass("d-none")) c.removeClass("d-none");
        else c.addClass("d-none"); 
    });


}
function createC(){
    $('.dropCollection').toggle();
}

function collectButtons(){
    $(".collectButton").on("click",function(e){
        e.preventDefault();
        $("#createCollectionButton").attr("data-id",e.currentTarget.dataset.id);
        $("#CollectionsList").load("https://localhost/img/collection.php?i="+e.currentTarget.dataset.id,function(){
            $("#collectionModal").modal("show");
            $(".modal-backdrop").css("background","white");
            ticks();
        });
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    });

}

function followButtons(){
    $(".followButton").on("click",function(e){
        $.ajax({
            type: "POST",
            url: "https://localhost/img/driver.php",
            data: "user="+e.currentTarget.dataset.user+"&command="+e.currentTarget.dataset.command,
        }).done(function (data) {

            if(data.trim() == "success"){


                if(e.currentTarget.dataset.command == "follow"){
                    $(document.querySelectorAll("button[data-user='"+e.currentTarget.dataset.user+"']")).addClass("btn-primary").removeClass("rd__button--white button").text("Following").attr("data-command","unfollow");
                }
                else if(e.currentTarget.dataset.command == "unfollow"){
                    $(document.querySelectorAll("button[data-user='"+e.currentTarget.dataset.user+"']")).removeClass("btn-primary").addClass("rd__button--white").text("Follow").attr("data-command","follow");
                }
            } 
            else alert(data);

            $.ajax({
                type: "POST",
                url: "https://localhost/img/driver.php",
                data: "user="+e.currentTarget.dataset.user+"&getFollowers=56556453",
            }).done(function (d) {
                if(!isNaN(parseInt(d)))$(".F").text(d);
                else alert(d);
            });

        });
    });
}


function likeButtons(){
    $(".likeButton").on("click",function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "https://localhost/img/driver.php",
            data: "imgid="+e.currentTarget.dataset.imgid+"&command="+e.currentTarget.dataset.command,
        }).done(function (data) {

            if(data.trim() == "success"){


                if(e.currentTarget.dataset.command == "like"){
                    
                    $(document.querySelectorAll("button[data-imgid='"+e.currentTarget.dataset.imgid+"']")).addClass("likedbutton").removeClass("dislikedbutton").attr("data-command","dislike");
                    $(document.querySelectorAll("button[data-imgid='"+e.currentTarget.dataset.imgid+"']")).find(".icoHeart").removeClass("fa-heart-o text-white").addClass("fa-heart text-danger");
                }
                else if(e.currentTarget.dataset.command == "dislike"){
                   
                    
                    $(document.querySelectorAll("button[data-imgid='"+e.currentTarget.dataset.imgid+"']")).find(".icoHeart").addClass("fa-heart-o text-white").removeClass("fa-heart text-danger");
                    $(document.querySelectorAll("button[data-imgid='"+e.currentTarget.dataset.imgid+"']")).removeClass("likedbutton").addClass("dislikedbutton").attr("data-command","like");
                }
            } 
            else alert(data);

            $.ajax({
                type: "POST",
                url: "https://localhost/img/driver.php",
                data: "imgid="+e.currentTarget.dataset.imgid+"&getLikes=56556453",
            }).done(function (d) {
                if(!isNaN(parseInt(d)))$(".L").text(d);
                else alert(d);
            });

        });
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    });
}

var current ;
var picModal = "modal";
function nextSlide(){

    if($(current).next().length){
        current = $(current).next();
        window.history.back();
        $(current).click();
    }
}
function prevSlide(){

    if($(current).prev().length){
        window.history.back();
        current = $(current).prev();
        $(current).click();
    }

}
$(document).ready(function(){

    pI();
    followButtons();
    collectButtons();
    images();
    downloader();
    likeButtons();
    $("#createCollectionButton").on("click",function(e){
        var name = $("#createCollectionInput").val();
        if(name == ""){
            alert("Enter name for collection to create it.");
        }
        else{
            $.ajax({
                type: "POST",
                url: "https://localhost/img/driver.php",
                data: "id="+e.currentTarget.dataset.id+"&name="+name+"&createCollection=1435",
            }).done(function (d) {
                if(d == "error"){

                    alert("Some error occured creating collection.");



                }
                else {

                    $('.dropCollection').toggle();
                    $("#createCollectionInput").val("");
                    $("#CollectionsList").append(d);
                    $(".firstCollec").remove();
                    ticks();

                }
            });  
        }
    });
});

function images(){             
    $(".imgCard").on("click",showPic);  
}

function pI(){
    $(".photoItem").mouseenter(
        function(){
            $(this).find(".bottomThings").addClass("d-flex").removeClass("d-none");
        });
    $(".photoItem").mouseleave(
        function(){
            $(this).find(".bottomThings").removeClass("d-flex").addClass("d-none");
            //console.log("out");
        }
);
}

function downloader(){
    var width,height,type,link; 
    var a = document.querySelectorAll("input[type='radio']");
    $(a).on("click",function(){
        link = "";
        let s = document.querySelector("input:checked");
        type = s.dataset.type;
        if(type == "custom"){
            width = $("#customWidth").val();
            height = $("#customHeight").val();
        }
        else
        {
            width = s.dataset.width;
            height = s.dataset.height;
        }

        if(width == "" || height == "" /*|| isNan(parseInt(width)) == true || isNan(parseInt(height))*/){
            return;
            alert("Please Enter valid width and height.");
        }
        else
            link = $("#imageLink").attr("href")+"&w="+width+"&h="+height;
        if(link != ""){
            console.log(link);
            $("#downIT").attr("href",link.replace("http:","https:"));
        }

    });    
    $("#downIT, .downs, #imageLink").on("click",function(e){
        if($(e.target).attr("href") == "")         e.preventDefault();
        else
            download($(e.target).attr("data-id"));

    });       
    $("#customHeight,#customWidth").on("input",function(){
        if($("#customHeight").val() != "" && $("#customWidth").val() != "")
            $("#cusT").removeAttr("disabled").click();
        else{
            $("#cusT").attr("disabled"," ");
            $("#downIT").attr("href","");
            $("#cusT")[0].checked = false;
        }

    }) ;
}





function download(i){
console.log(i);
    $.ajax({
        type: "POST",
        url: "https://localhost/img/driver.php",
        data: "downloadimg="+i,
    }).done(function (d) { 
    });


}



function showPic(a){
    current = a.currentTarget;
    a.preventDefault();
    a.stopPropagation();
    a.stopImmediatePropagation();
    if($(a.currentTarget).hasClass("modalcard"))picModal = "";

    $("#profileLoadModal").load("https://localhost/img/showmodal.php?"+picModal+"=y&id="+a.currentTarget.dataset.target+" ",
                                function () {
        if(!$("#staticBackdrop").hasClass('show')) showM();

        window.history.pushState("", "", 'https://localhost/img/photo-'+a.currentTarget.dataset.target);
        $("#profileLoadModal")[0].scrollTop = 0
        images();
        pI();
        likeButtons();
        collectButtons();
        followButtons();

    });

}
function showM(){
    $("#staticBackdrop").modal("show");


}
function closeModal(){
    $("#staticBackdrop").modal("hide");
    window.history.back();
    picModal = "modal";

}

