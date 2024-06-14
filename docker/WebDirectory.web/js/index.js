import * as ui from "./ui";
import * as annuaire from "./annuaire";
import * as departement from "./departement";

function getAnnuaire(users){
    ui.displayAnnuaire(users);
    document.querySelectorAll('.entreeListe').forEach(function(element){
        element.addEventListener('click', async function(){
            let entry = await annuaire.getEntry(element.getAttribute('data-entreeUrl'));
            ui.displayEntreeDetail(entry);
        });
    });
}

function getForm(departements){
    ui.displayForm(departements);
    document.getElementById('formButton').addEventListener('click', async function (event){
        event.preventDefault();
        
        const nameFilter = document.getElementById('nameFilter').value;
        const departmentFilter = document.getElementById('departmentFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;

        let entrees = await annuaire.search(departmentFilter, nameFilter, sortFilter);
        getAnnuaire(entrees);
    });
}

async function init(){
    let departements = await departement.getDepartement('/api/services');
    let users = await annuaire.getEntries('/api/entrees/?sort=nom-asc');

    getAnnuaire(users);
    getForm(departements);

    // Add event listener to close modal
    var modal = document.getElementById("myModal");
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
        modal.innerHTML = '';
      }
    }

    document.getElementById('theme-toggle-button').addEventListener('click', function(){
        const root = document.documentElement;
        const currentTheme = root.getAttribute('data-theme');
        root.setAttribute('data-theme', currentTheme === 'dark' ? 'light' : 'dark');
    });

    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
    if (prefersDarkScheme) {
        document.getElementById('theme-toggle-button').checked = true;
        const root = document.documentElement;
        const currentTheme = root.getAttribute('data-theme');
        root.setAttribute('data-theme', currentTheme === 'dark' ? 'light' : 'dark');
    }
}

window.addEventListener('load', init);