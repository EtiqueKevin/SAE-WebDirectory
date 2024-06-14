export const annuaireTemplate = `
{{#if entrees.length}}
<div class="cardContainer">
    {{#each entrees}}
        <div data-entreeUrl="{{links.self.href}}" class="entreeListe">
            <h2>{{entree.nom}} {{entree.prenom}}</h2> 
            <p>
                {{#each entree.departements}}
                    {{this.departement.nom}},
                {{/each}}
            </p>
        </div>
    {{/each}}
</div>
{{else}}
    <h1 class='error'>&#9888; Aucun résultat &#9888;</h1>
{{/if}}
`;

export const formTemplate = `
<form id="filterForm">
    <input type="text" id="nameFilter" value="" placeholder="Nom">
    <select id="departmentFilter">
        <option value="">Tous les départements</option>
        {{#each departements}}
            <option value="{{this.departement.id}}">{{this.departement.nom}}</option>
        {{/each}}
    </select>
    <select id="sortFilter">
        <option value="nom-asc" selected>Nom (A-Z)</option>
        <option value="nom-desc">Nom (Z-A)</option>
    </select>
    <button id="formButton">Filtrer</button>
</form>
`;

export const entreeDetailTemplate = `
<div class="modal-content">
    <header>
      <h1>{{nom}} {{prenom}}</h1>
    </header>
    <article>
      <h2>Departements : </h2>
      <ul>
        {{#each departements}}
          <li>{{this.departement.nom}}</li>
        {{/each}}
      </ul>
      <p>Numéro de bureau : {{num_bureau}}</p>
      <p>Téléphone mobile: {{tel_mobile}}</p>
      <p>Téléphone fixe: {{tel_fixe}}</p>
      <p>Email: <a href="mailto:{{email}}">{{email}}</a></p>
    </article>
  </div>
`;