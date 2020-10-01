var cart=document.getElementsByClassName('produs-cos');
var container=document.getElementById('container');
var empty_message=document.getElementById('empty');
var livr=document.getElementById('livrare');
var card=document.getElementById('card');
var form=document.getElementsByClassName('col-100');

function isEmptyCart() {
    if (cart.length==0) {
        container.style.display="none";
        empty_message.style.display="block";
    }
    else {
        container.style.display="block";
        empty_message.style.display="none";
    }
}

function showLivrare() {
    form[0].style.display="block";
    form[0].style.marginTop="5%";
    form[0].style.marginBottom="5%";
    form[1].style.display="none";
    form[1].style.marginTop="0";
    form[1].style.marginBottom="0";
}

function showCard() {
    form[0].style.display="none";
    form[0].style.marginTop="0";
    form[0].style.marginBottom="0";
    form[1].style.display="block";
    form[1].style.marginTop="5%";
    form[1].style.marginBottom="5%";
}

window.onload=isEmptyCart;
livr.addEventListener('click', showLivrare);
card.addEventListener('click', showCard);