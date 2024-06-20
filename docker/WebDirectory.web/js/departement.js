import { loadData } from "./loader";

let departement = [];

async function getDepartement(url) {
    departement = await loadData(url);
    return departement;
}

export { getDepartement };