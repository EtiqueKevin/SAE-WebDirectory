import { displayAnnuaire } from "./ui";
import * as annuaire from "./annuaire";
import * as departement from "./departement";

async function search(){
    const nameFilter = document.getElementById('nameFilter').value;
    const departmentFilter = document.getElementById('departmentFilter').value;

    let departements = await departement.getDepartement();
    let users = await annuaire.getEntries();

    if(departmentFilter !== ''){
        users = await annuaire.filterByDepartment(users, departmentFilter);
    }

    displayAnnuaire(users, departements);
    document.getElementById('formButton').addEventListener('click', function(event){
        event.preventDefault();
        search();
    });
}


async function init(){
    let departements = await departement.getDepartement();
    let users = await annuaire.getEntries();

    displayAnnuaire(users, departements);
    document.getElementById('formButton').addEventListener('click', function(event){
        event.preventDefault();
        search();
    });
}

window.addEventListener('load', init);
