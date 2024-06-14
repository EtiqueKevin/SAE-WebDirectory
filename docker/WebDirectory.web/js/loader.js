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

export { loadData };