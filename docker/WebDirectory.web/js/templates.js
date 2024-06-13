export const annuaireTemplate = `
<form id="filterForm">
    <input type="text" id="nameFilter" value="" placeholder="Nom">
    <select id="departmentFilter">
        <option value="">Tous les départements</option>
        {{#each data.departements}}
            <option value="{{this.id}}">{{this.nom}}</option>
        {{/each}}
    </select>
    <button id="formButton">Filtrer</button>
</form>

{{#if data.users.length}}
<ul>
    {{#each data.users}}
        <li>
            <h2>{{nom}} {{prenom}}</h2>
            <p>Service / Département: {{#each departements}}{{this}}, {{/each}}</p>
        </li>
    {{/each}}
</ul>
{{else}}
    <h1>Aucun résultat</h1>
{{/if}}
`;
