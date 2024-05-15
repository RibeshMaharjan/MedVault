var images = ["image/images.jpg","image/images2.jpg","image/images3.jpg"];


function nextImage(a){
    var i=0;
    i++; 
    document.getElementById(a).src = images[i];
}

function previousImage(a){
    i--;
    document.getElementById("productimg"+a+"").src = images[i];
}