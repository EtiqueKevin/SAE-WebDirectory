import Handlebars from 'handlebars';
import * as templates from './templates.js';

function displayAnnuaire(entries) {
    const template = Handlebars.compile(templates.annuaireTemplate);
    document.querySelector('#annuaire').innerHTML = template(entries);
}

function displayEntreeDetail(entry) {
    const template = Handlebars.compile(templates.entreeDetailTemplate);
    document.getElementById("myModal").innerHTML = template(entry.entree);

    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function displayForm(departements) {
    const template = Handlebars.compile(templates.formTemplate);
    document.querySelector('#head').innerHTML = template(departements);
}

export { displayAnnuaire, displayEntreeDetail, displayForm };