
const bestandfile = document.getElementById("Product_picture");
const gekozenfile = document.getElementById("gekozenbestand");
const afbeelding = document.getElementById("afbeelding");
const geenAfbeelding = document.getElementById("geenafbeelding")


bestandfile.addEventListener("change", () => {
    if (bestandfile.files.length) {
        gekozenfile.src = URL.createObjectURL(bestandfile.files[0]);
        gekozenfile.style.display = "flex";

geenAfbeelding.style.display = "none";
      
    } 
    
    
    
   
});

if(gekozenfile.dataset.exsists){
     gekozenfile.style.display = "flex";
    geenAfbeelding.style.display = "none";
}

else  {
    gekozenfile.style.display = "none";
 
    geenAfbeelding.style.display = "block";
}