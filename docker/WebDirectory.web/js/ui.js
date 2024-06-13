import Handlebars from 'handlebars';
import * as templates from './templates.js';

function displayAnnuaire(users, departements) {
    let data = {
        users: users,
        departements: departements
    };

    const template = Handlebars.compile(templates.annuaireTemplate);
    document.querySelector('#annuaire').innerHTML = template({data});
}

export { displayAnnuaire };