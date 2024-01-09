{* <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block" src="{$img}" alt="First slide" style="width: 15%; height:15%;">
    </div>
    <div class="carousel-item">
      <img class="d-block" src="{$img}" alt="Second slide" style="width: 15%; height:15%;">
    </div>
    <div class="carousel-item">
      <img class="d-block" src="{$img}" alt="Third slide" style="width: 15%; height:15%;">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> *}

<div class="container_menu_age">
    <h3>By Age</h3>
    <button class="scroll-btn" onclick="scrollMenu('prev')">Précédent</button>
    <ul class="menu_age">
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 1])}"><li class="item_menu_age"><img src="{$img}">1</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 2])}"><li class="item_menu_age"><img src="{$img}">2</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 3])}"><li class="item_menu_age"><img src="{$img}">3</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 4])}"><li class="item_menu_age"><img src="{$img}">4</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 5])}"><li class="item_menu_age"><img src="{$img}">5</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 6])}"><li class="item_menu_age"><img src="{$img}">6</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 7])}"><li class="item_menu_age"><img src="{$img}">7</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 8])}"><li class="item_menu_age"><img src="{$img}">8</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 9])}"><li class="item_menu_age"><img src="{$img}">9</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 10])}"><li class="item_menu_age"><img src="{$img}">10</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 11])}"><li class="item_menu_age"><img src="{$img}">11</li></a>
    <a href="{$link->getModuleLink('productbyage','productage',['age' => 12])}"><li class="item_menu_age"><img src="{$img}">12</li></a>

    </ul>
    <button class="scroll-btn" onclick="scrollMenu('next')">Suivant</button>
</div>

<script>
    const menu = document.querySelector('.menu_age');
    const scrollBtns = document.querySelectorAll('.scroll-btn');

    let scrollPosition = 0;
    const scrollStep = 100; // Vous pouvez ajuster la valeur selon votre besoin

    function scrollMenu(direction) {
        if (direction === 'next') {
            scrollPosition += scrollStep;
        } else if (direction === 'prev') {
            scrollPosition -= scrollStep;
        }
        menu.style.transform = "translateX(-" + scrollPosition + "%)";
    }

    // Ajoutez des écouteurs d'événements aux boutons
    scrollBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const direction = btn.getAttribute('onclick').includes('prev') ? 'prev' : 'next';
            scrollMenu(direction);
        });
    });
</script>