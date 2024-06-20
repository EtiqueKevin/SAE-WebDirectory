import Handlebars from 'handlebars';
import * as templates from './templates.js';
import { getDepartement } from './departement.js';
import { apiUrl } from "./data.js";

const marked = require('marked');

function displayAnnuaire(entries) {
    const template = Handlebars.compile(templates.annuaireTemplate);
    document.querySelector('#annuaire').innerHTML = template(entries);
}

function displayEntreeDetail(entry) {
    let data = {
        apiUrl: apiUrl,
        links: entry.links,
        entree: entry.entree
    };

    const template = Handlebars.compile(templates.entreeDetailTemplate);
    document.getElementById("myModal").innerHTML = template(data);
    document.getElementById("close-button").addEventListener('click', function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
        modal.innerHTML = '';
    });

    const departementElements = document.querySelectorAll('.departement');
    departementElements.forEach(element => {
        element.addEventListener('click', async () => {
            let departement = await getDepartement('/api/services/'+element.id);
            displayDepartement(departement);
        });
    });

    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function displayForm(departements) {
    const template = Handlebars.compile(templates.formTemplate);
    document.querySelector('#head-form').innerHTML = template(departements);
}

function displayDepartement(departement) {
    departement.departement.description = marked.parse(departement.departement.description);

    const template = Handlebars.compile(templates.departementDetailTemplate);
    document.getElementById("myModal").innerHTML = template(departement);

    document.getElementById("close-button").addEventListener('click', function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
        modal.innerHTML = '';
    });
}

export { displayAnnuaire, displayEntreeDetail, displayForm };