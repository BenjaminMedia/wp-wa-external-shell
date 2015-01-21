function EAS_load_fif(divId, fifSrc, easSrc, width, height, fixedSrc) {
   var d = document;
   var fif = d.createElement("iframe");
   var div = d.getElementById(divId);

   fif.src = fifSrc;
   fif.style.width = width + "px";
   fif.style.height = height + "px";
   fif.style.margin = "0px";
   fif.style.borderWidth = "0px";
   fif.style.padding = "0px";
   fif.scrolling = "no";
   fif.frameBorder = "0";
   fif.allowTransparency = "true";
   fif.EAS_src = (fixedSrc) ? easSrc : easSrc + ";fif=y";
   div.appendChild(fif);
}
