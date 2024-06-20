import { loadData } from "./loader.js";

let  entries = [];

async function getEntries(url) {
    entries = await loadData(url);
    return entries;
}

async function getEntry(url) {
    return await loadData(url);
}

function getStoredEntries() {
    return entries;
}

async function search(depId, name, sort) {
    let url = '';
    if (depId && name) {
        url = `/api/services/${depId}/entrees/search/?q=${name}&sort=${sort}`;
    } else if (name) {
        url = `/api/entrees/search/?q=${name}&sort=${sort}`;
    } else if (depId) {
        url = `/api/services/${depId}/entrees/?sort=${sort}`;
    } else {
        url = `/api/entrees/?sort=${sort}`;
    }

    return await getEntries(url);
}

export { getEntries, search, getEntry, getStoredEntries };
