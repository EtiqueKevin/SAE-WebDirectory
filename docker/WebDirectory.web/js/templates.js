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
<div>
    {{#each data.users}}
        <div id="{{id}}" class="entreeListe">
            <h2>{{nom}} {{prenom}}</h2>
            <p>Service / Département: {{#each departements}}{{this}}, {{/each}}</p>
        </div>
    {{/each}}
</div>
{{else}}
    <h1>Aucun résultat</h1>
{{/if}}
`;

export const entreeDetailTemplate = `
<br><hr><br>
<h1>{{nom}} {{prenom}}</h1>
<p>Service / Département: {{#each departements}}{{this}}, {{/each}}</p>
<p>Téléphone mobile: {{telephoneMobile}}</p>
<p>Téléphone fixe: {{telephoneFixe}}</p>
<p>Email: <a href="mailto:{{adresse}}">{{adresse}}</a></p>
`;

