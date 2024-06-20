export const annuaireTemplate = `
{{#if entrees.length}}
<div class="cardContainer">
    {{#each entrees}}
        <div data-entreeUrl="{{links.self.href}}" class="entreeListe">
            <h2>{{entree.nom}} {{entree.prenom}}</h2> 
            <p>
                {{#each entree.departements}}
                    {{this.departement.nom}}{{#if @last}}{{else}},{{/if}}
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
    <input type="text" id="nameFilter" value="" placeholder="Nom/Prénom">
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
    <button id="downloadButton" class="formButton">Exporter CSV</button>
</form>
`;

export const entreeDetailTemplate = `
<div class="modal-content">
    <span id="close-button">&times;</span>
    <header id="detail-header">
      {{#if links.image.href}}
        <img src="{{apiUrl}}/img/{{links.image.href}}" class="round-image" alt="Profile Picture"/>
      {{else}}
        <img src="/public/no-image.png" class="round-image" alt="No Image Available"/>
      {{/if}}
      <h1>{{entree.nom}} {{entree.prenom}}</h1>
    </header>
    <article>
      <h2>Departements : </h2>
      <ul>
        {{#each entree.departements}}
          <li class="departement" id="{{this.departement.id}}">{{this.departement.nom}}</li>
        {{/each}}
      </ul>
      <p>Adresse : {{entree.adresse}}</p>
      <p>Numéro de bureau : {{entree.num_bureau}}</p>
      <p>Téléphone mobile: {{entree.tel_mobile}}</p>
      <p>Téléphone fixe: {{entree.tel_fixe}}</p>
      <p>Email: <a href="mailto:{{entree.email}}">{{entree.email}}</a></p>
    </article>
</div>
`;

export const departementDetailTemplate = `
<div class="modal-content">
    <span id="close-button">&times;</span>
    <header id="detail-header">
      <h1>{{departement.nom}}</h1>
    </header>
    <article>
      <p>Etage : {{departement.etage}}</p>
      <p>Description :</p>
      {{{departement.description}}}
    </article>
</div>
`;