import { displayAnnuaire } from "./ui";
import * as annuaire from "./annuaire";
import * as departement from "./departement";

async function init(){
    let departements = await departement.getDepartement();
    let users = await annuaire.getEntries();

    displayAnnuaire(users, departements);
}

window.addEventListener('load', init);
