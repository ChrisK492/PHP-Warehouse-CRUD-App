
// dropdown countries

const dropdownBtn = document.getElementById("dropdownBtn"); // dropdown knop
const menu = document.getElementById("dropdownMenu"); // menu (lijst)
const dropdownValue = document.getElementById("dropdownValue");


if (dropdownBtn) {
    dropdownBtn.onclick = () => { // bij een klik op de knop

        if (menu.classList.contains("visible")) { // als het menu al zichbaar is
            menu.classList.remove("visible"); // maak hem onzichtbaar (sluit hem)
        } else { // anders (hij is nog gesloten)
            menu.classList.add("visible") // maak hem open
        }

        // bij een klik buiten de knop
        document.addEventListener("click", (e) => {
            if (!dropdownBtn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove("visible");
            }

            // als menu geen class zichtbaar heeft (hij is nog gesloten)
            if (!menu.classList.contains("visible")) {
             // geen outline
            }
            // maar als hij weer open is, wel een uitline
            else {  }
        })

        // loop door elke li uit dropdown en noem het item
        document.querySelectorAll("#dropdownMenu li").forEach(item => {
            // bij een klik op zo'n item (Li)
            item.addEventListener("click", () => {
                // dropdown value wordt dataset value van die li (staat in HTML)
                dropdownValue.value = item.dataset.value;
                // ook de value (dus wat er zichtbaar staat in de input) wordt die data uit HTML
                dropdownBtn.value = item.textContent;
                // sluit ook het dropdown menu weer
                menu.classList.remove("visible");
            });
        });

        dropdownBtn.addEventListener("input", () => { // als er zelf getypt wordt
            dropdownValue.value = dropdownBtn.value // dan wordt de value van de dropdown, wat er in de input staat (dropdownBtn)
        })
    }
}
