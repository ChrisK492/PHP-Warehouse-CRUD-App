let MaxCards = 9;
let cardoppagina = 0;
let Cardsamount = 0;
let Bladerknopamount = 0;
let huidigebladzijde = 0;
let Maxknoppenachter = 2;
let Maxknoppenvoor = 2;

const Bladerknoppenlijst = document.getElementById("Bladerknoppenlijst");
const productdivs = document.querySelectorAll(".productdiv");
const productbox = document.getElementById("productbox");

productdivs.forEach(productdiv => {
    Cardsamount += 1;
});


// productdivs laten verdwijnen en terugkomen
function updatebladzijdes(productdiv) {

    const start = huidigebladzijde * MaxCards;
    const eind = start + MaxCards;

    if (cardoppagina >= start && cardoppagina < eind) {
        productdiv.style.display = "flex";
    }
    else {
        productdiv.style.display = "none";
    }

    cardoppagina += 1;
}


// bladerknoppen maken
function bladeren() {
if(Cardsamount <= MaxCards){
    Bladerknoppenlijst.style.display = "none";
}

if(Cardsamount === 0){
    productbox.innerHTML = "Geen articelen gevonden"
}
    Bladerknoppenlijst.innerHTML = "";

    if (Cardsamount > MaxCards) {

        Bladerknopamount = Math.ceil(Cardsamount / MaxCards);

        Maxknoppenachter = 2;
        Maxknoppenvoor = 2;

        let Knoppenachter = Math.min(
            Maxknoppenachter,
            huidigebladzijde
        );

        let Knoppenvoor = Math.min(
            Maxknoppenvoor,
            Bladerknopamount - huidigebladzijde - 1
        );

        let verschilAchter = Maxknoppenachter - Knoppenachter;
        let verschilVoor = Maxknoppenvoor - Knoppenvoor;


        if (verschilAchter > 0) {
            Maxknoppenvoor += verschilAchter;
        }

        if (verschilVoor > 0) {
            Maxknoppenachter += verschilVoor;
        }


        for (let i = 0; i < Bladerknopamount; i++) {

            if (
                i >= huidigebladzijde - Maxknoppenachter &&
                i <= huidigebladzijde + Maxknoppenvoor
            ) {

                const Bladerknop = document.createElement("div");

                Bladerknop.classList.add("Bladerknop");

                Bladerknop.textContent = i + 1;


                if (i == huidigebladzijde) {
                    Bladerknop.classList.add("active");
                }


                Bladerknopfunctie(Bladerknop, i);

                Bladerknoppenlijst.appendChild(Bladerknop);
            }
        }


        // laatste pagina
        if (
            Bladerknopamount >
            huidigebladzijde + 1 + Maxknoppenvoor
        ) {

            const Bladerknop = document.createElement("div");

            Bladerknop.classList.add("Bladerknop");

            const puntjes = document.createElement("div");

            puntjes.classList.add("Bladerknop");

            puntjes.textContent = "...";

            Bladerknop.textContent = Bladerknopamount;


            Bladerknopfunctie(
                Bladerknop,
                Bladerknopamount - 1
            );

            Bladerknoppenlijst.appendChild(puntjes);

            Bladerknoppenlijst.appendChild(Bladerknop);
        }


        // eerste pagina
        if (huidigebladzijde - Maxknoppenachter > 0) {

            const puntjes = document.createElement("div");

            puntjes.classList.add("Bladerknop");

            puntjes.textContent = "...";


            const Bladerknop = document.createElement("div");

            Bladerknop.classList.add("Bladerknop");

            Bladerknop.textContent = 1;


            Bladerknopfunctie(
                Bladerknop,
                0
            );

            Bladerknoppenlijst.prepend(puntjes);

            Bladerknoppenlijst.prepend(Bladerknop);
        }
    }
}


// klikken op een bladerknop
function Bladerknopfunctie(Bladerknop, i) {

    Bladerknop.addEventListener("click", () => {

        huidigebladzijde = i;

        cardoppagina = 0;


        document.querySelectorAll(".Bladerknop").forEach(knop => {
            knop.classList.remove("active");
        });


        Bladerknop.classList.add("active");


        window.scrollTo({
            top: 0
        });


        // productdivs opnieuw controleren
        productdivs.forEach(productdiv => {
            updatebladzijdes(productdiv);
        });


        // bladerknoppen opnieuw maken
        bladeren();
    });
}


// eerste pagina laden
cardoppagina = 0;

productdivs.forEach(productdiv => {
    updatebladzijdes(productdiv);
});

bladeren();