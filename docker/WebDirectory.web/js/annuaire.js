import { generateUsers } from "./loader";

let  entries = [];

async function getEntries() {
    if (entries.length === 0) {
        entries = await generateUsers();
    }
    return entries;
}

export { getEntries, filterByDepartment, filterByName };
