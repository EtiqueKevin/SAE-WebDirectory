import * as ui from "./ui.js";
import * as annuaire from "./annuaire.js";
import * as departement from "./departement.js";
import * as exporting from "./export.js";

let timer = null;

function getAnnuaire(users){
    ui.displayAnnuaire(users);
    document.querySelectorAll('.entreeListe').forEach(function(element){
        element.addEventListener('click', async function(){
            let entry = await annuaire.getEntry(element.getAttribute('data-entreeUrl'));
            console.log(entry);
            ui.displayEntreeDetail(entry);
        });
    });
}

function getForm(departements){
    ui.displayForm(departements);

    document.getElementById('nameFilter').addEventListener('input', function(e) {
        clearTimeout(timer); // enlève le timer précédent
        timer = setTimeout(async function() {
            const nameFilter = document.getElementById('nameFilter').value;
            const departmentFilter = document.getElementById('departmentFilter').value;
            const sortFilter = document.getElementById('sortFilter').value;

            let entrees = await annuaire.search(departmentFilter, nameFilter, sortFilter);
            getAnnuaire(entrees);
        }, 300); // délai de 200ms avant de lancer la recherche pour éviter de surcharger le serveur
    });

    document.getElementById('departmentFilter').addEventListener('change', async function(e) {
        const nameFilter = document.getElementById('nameFilter').value;
        const departmentFilter = document.getElementById('departmentFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;

        let entrees = await annuaire.search(departmentFilter, nameFilter, sortFilter);
        getAnnuaire(entrees);
    });

    document.getElementById('sortFilter').addEventListener('change', async function(e) {
        const nameFilter = document.getElementById('nameFilter').value;
        const departmentFilter = document.getElementById('departmentFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;

        let entrees = await annuaire.search(departmentFilter, nameFilter, sortFilter);
        getAnnuaire(entrees);
    });

    document.getElementById('downloadButton').addEventListener('click', function (event){
        event.preventDefault();

        let entrees = annuaire.getStoredEntries();
        exporting.downloadCSV(entrees, 'annuaire.csv');
    });
}

async function init(){
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

    let departements = await departement.getDepartement('/api/services');
    let users = await annuaire.getEntries('/api/entrees/?sort=nom-asc');

    getAnnuaire(users);
    getForm(departements);

    // Add event listener to close modal
    document.getElementById("myModal").addEventListener('click', function(event) {
        event.preventDefault();
        if (event.target === this) {
            this.style.display = "none";
            this.innerHTML = '';
        }
    });
}

window.addEventListener('load', init);