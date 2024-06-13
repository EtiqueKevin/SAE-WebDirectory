import { generateUsers } from "./loader";

let  entries = [];

async function getEntries() {
    if (entries.length === 0) {
        entries = await generateUsers();
    }
    return entries;
}

async function getEntry(id) {
    return entries.find(user => user.id == id);
}

async function filterByDepartment(users, departementId) {
    departementId = parseInt(departementId);
    return users.filter(user => user.departements.includes(departementId));
}

async function filterByName(users, name) {
    return users.filter(user => user.nom.toLowerCase().includes(name.toLowerCase()) || user.prenom.toLowerCase().includes(name.toLowerCase()));
}

export { getEntries, filterByDepartment, filterByName, getEntry };
