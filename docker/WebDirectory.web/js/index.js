import * as ui from "./ui";
import * as annuaire from "./annuaire";
import * as departement from "./departement";

async function search(){
    const nameFilter = document.getElementById('nameFilter').value;
    const departmentFilter = document.getElementById('departmentFilter').value;

    let departements = await departement.getDepartement();
    let users = await annuaire.getEntries();

    if(nameFilter !== ''){
        users = await annuaire.filterByName(users, nameFilter);
    }

    if(departmentFilter !== ''){
        users = await annuaire.filterByDepartment(users, departmentFilter);
    }

    showAnnuaire(users, departements);
}

function showAnnuaire(users, departements){
    ui.displayAnnuaire(users, departements);
    document.getElementById('formButton').addEventListener('click', function(event){
        event.preventDefault();
        search();
    });
    document.querySelectorAll('.entreeListe').forEach(function(element){
        element.addEventListener('click', async function(){
            let user = await annuaire.getEntry(element.id);
            ui.displayEntreeDetail(user);
        });
    });
}

async function init(){
    let departements = await departement.getDepartement();
    let users = await annuaire.getEntries();

    console.log(users);
    
    showAnnuaire(users, departements);
}

window.addEventListener('load', init);
