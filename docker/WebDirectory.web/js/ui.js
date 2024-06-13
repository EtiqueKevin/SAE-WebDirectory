import Handlebars from 'handlebars';
import * as templates from './templates.js';

function displayAnnuaire(users, departements) {
    let data = {
        users: users,
        departements: departements
    };

    const template = Handlebars.compile(templates.annuaireTemplate);
    document.querySelector('#annuaire').innerHTML = template({data});
    document.querySelector('#entree').innerHTML = '';
}

function displayEntreeDetail(user) {
    console.log(user);
    const template = Handlebars.compile(templates.entreeDetailTemplate);
    document.querySelector('#entree').innerHTML = template(user);
}

export { displayAnnuaire, displayEntreeDetail };