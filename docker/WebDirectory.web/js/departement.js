import { loadData } from "./loader";

let departement = [];

async function getDepartement(url) {
    if(departement.length === 0) {
        departement = await loadData(url);
    }

    return departement;
}

export { getDepartement };