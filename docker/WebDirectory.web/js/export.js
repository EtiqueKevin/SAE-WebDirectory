import { loadData } from './loader.js';

async function createCSVFromUsers(users) {
    let csvContent = "Nom,Prenom,Email,Num Bureau,Tel Fixe,Tel Mobile,Departements\n";

    for (let user of users.entrees) {
        const entryUrl = user.links.self.href;
        const entryData = await loadData(entryUrl);

        const nom = entryData.entree.nom;
        const prenom = entryData.entree.prenom;
        const departements = entryData.entree.departements.map(dep => dep.departement.nom).join(',');
        const email = entryData.entree.email;
        const numBureau = entryData.entree.num_bureau;
        const telFixe = entryData.entree.tel_fixe;
        const telMobile = entryData.entree.tel_mobile;

        csvContent += `${nom},${prenom},${email},${numBureau},${telFixe},${telMobile},${departements}\n`;
    }

    return csvContent;
}

async function downloadCSV(data, filename) {
    let csvData = await createCSVFromUsers(data);
    let blob = new Blob(['\ufeff' + csvData], { type: 'text/csv;charset=utf-8;' });
    let dwldLink = document.createElement("a");
    let url = URL.createObjectURL(blob);
    dwldLink.setAttribute("href", url);
    dwldLink.setAttribute("download", filename);
    dwldLink.style.visibility = "hidden";
    document.body.appendChild(dwldLink);
    dwldLink.click();
    document.body.removeChild(dwldLink);
}

export { createCSVFromUsers, downloadCSV };