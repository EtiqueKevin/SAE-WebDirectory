import { generateUsers } from "./loader";

let  entries = [];

async function getEntries() {
    if (entries.length === 0) {
        entries = await generateUsers();
    }
    return entries;
}

async function filterByDepartment(users, departementId) {
    departementId = parseInt(departementId);
    return users.filter(user => user.departements.includes(departementId));
}

export { getEntries, filterByDepartment, filterByName };
