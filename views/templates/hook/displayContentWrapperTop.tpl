<div class="container_menu_age">
    <h3>By Age</h3>
    <button class="scroll-btn left" onclick="scrollMenu('prev')">&#9664; Précédent</button>
    <ul class="menu_age">
      {assign var=currentAge value=1}
      {foreach from=$imgPath item=image}
          <a href="{$link->getModuleLink('productbyage','productage',['age' => $currentAge])}">
              <li class="item_menu_age"><img src="{$image}">{$currentAge}</li>
          </a>
          {assign var=currentAge value=$currentAge+1}
      {/foreach}
    </ul>
    <button class="scroll-btn right" onclick="scrollMenu('next')">Suivant &#9654;</button>
</div>


<script>
    const menu = document.querySelector('.menu_age');
    const scrollBtns = document.querySelectorAll('.scroll-btn');

    let scrollPosition = 0;
    const scrollStep = 5; // Vous pouvez ajuster la valeur selon votre besoin


    function scrollMenu(direction) {
      var items = document.querySelectorAll('.menu_age a');
      var lastIndex = items.length - 1;

      if (direction === 'next') {
          items.forEach(function(item, index) {
              if (index === 0) {
                  item.style.marginRight = '-10%'; // Cacher le premier élément en déplaçant vers la gauche
              } else if (index === lastIndex) {
                  item.style.marginRight = '10px'; // Réinitialiser la position du dernier élément
              }
          });
        } else if (direction === 'prev') {
          items.forEach(function(item, index) {
              if (index === 0) {
                  item.style.marginRight = '-400px'; // Réinitialiser la position du premier élément
              } else if (index === lastIndex) {
                  item.style.marginRight = '-400px'; // Cacher le dernier élément en déplaçant vers la gauche
              }
          });
      }
    }

    // Ajoutez des écouteurs d'événements aux boutons
    scrollBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const direction = btn.getAttribute('onclick').includes('prev') ? 'prev' : 'next';
            scrollMenu(direction);
        });
    });
</script>