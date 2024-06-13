import { generateDepartements } from "./loader";

let departement = [];

async function getDepartement() {
    if(departement.length === 0) {
        departement = await generateDepartements();
    }

    return departement;
}

export { getDepartement };