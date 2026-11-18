"use strict"


const cookieabfrage=document.createElement("div");
const cookietext=document.createElement("div");
cookietext.textContent="Wollen Sie die Cookies akzeptieren?";

cookieabfrage.style.position="absolute";
cookieabfrage.style.bottom="0px";
cookieabfrage.style.background="yellow";
cookieabfrage.style.width="100%";
cookieabfrage.style.height="10%";
cookieabfrage.style.textAlign="center";

const acceptcookies= document.createElement("button");
const denycookies= document.createElement("button");

acceptcookies.innerText="Akzeptieren";
denycookies.innerText="Ablehnen";

cookieabfrage.appendChild(cookietext);
cookieabfrage.appendChild(acceptcookies);
cookieabfrage.appendChild(denycookies);

document.body.appendChild(cookieabfrage);

acceptcookies.addEventListener("click",function(){
    document.cookie ="setCookie=true";
    cookieabfrage.style.display="none";
});
denycookies.addEventListener("click",function (){
    document.cookie= "setCookie=false";
    cookieabfrage.style.display="none";
});

if(document.cookie.includes("setCookie")){
    cookieabfrage.style.display="none";
}
