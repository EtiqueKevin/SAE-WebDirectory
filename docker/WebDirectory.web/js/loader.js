import { apiUrl } from "./data.js";

async function loadData(url) {
    try {
        const response = await fetch(apiUrl+url);
        if (!response.ok) {
            throw new Error(`Erreur HTTP, status: ${response.status}, message: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error(error);
    }
};

async function generateUsers() {
    await new Promise(resolve => setTimeout(resolve, 500));

    const users = [];
    for(let i = 0; i < 5; i++) {
        const user = {
            id : i,
            nom: `Nom ${i}`,
            prenom: `Prenom ${i}`,
            fonction: `Fonction ${i}`,
            departements: [i, i+1, i+2],
            bureau: `Bureau$ {i}`,
            telephoneFixe: `012345678${i}`,
            telephoneMobile: `987654321${i}`,
            adresse: `Adresse${i}@mail.com`
        };
        users.push(user);
    }
    return users;
}

async function generateDepartements() {
    await new Promise(resolve => setTimeout(resolve, 500));

    const departements = [];
    for(let i = 0; i < 5; i++) {
        const departement = {
            id : i,
            nom: `Departement ${i}`,
            description: `Description ${i}`,
        };
        departements.push(departement);
    }
    return departements;
}


export { loadData, generateUsers, generateDepartements };