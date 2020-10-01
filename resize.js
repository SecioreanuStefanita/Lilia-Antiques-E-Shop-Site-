var img=document.getElementById('img');
var img_zoom=document.getElementById('pop_image');

function popUpImage() {
  img_zoom.style.display="block";
}

function closePopUp() {
  img_zoom.style.display="none";
}

function resizeImage() {
  var l=document.body.scrollWidth;
  var x=0.28*l;
  var y=0.31*l;
  img.style.width=x+"px";
  img.style.height=x+"px";
  img.style.marginTop=(y-x)/2+"px";
  imagine.style.height=y+"px";
  specificatii.style.height=y+"px";
}

window.onload=resizeImage;
window.onresize=resizeImage;
