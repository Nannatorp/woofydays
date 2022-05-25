<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package OceanWP WordPress theme
 */

get_header(); ?>

<template>
  <article>
  <img class="billede1" src="" alt="" />
    <h2></h2>
    <p class="pris"></p>
    
  </article>
</template>

<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <nav id="filtrering">
      <button data-produkt="alle">Alle produkter</button>
    </nav>
    <section class="produktcontainer"></section>
  </main>
  <!-- #main -->
  <script>
    let produkter;
    let categories;
    let filterProdukt = "alle";

    // link til wp database alle produkter
    const dbUrl =
      "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/produkt?per_page=100";
    // link til wp database alle kategorier
    const catUrl =
      "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/categories";

    // Henter data
    async function hentData() {
      const data = await fetch(dbUrl);
      const catdata = await fetch(catUrl);
      produkter = await data.json();
      categories = await catdata.json();
      console.log(produkter);
      visProdukter();
      opretKnapper();
    }

    function opretKnapper() {
      categories.forEach((cat) => {
        document.querySelector(
          "#filtrering"
        ).innerHTML += `<button class="filter" data-produkt="${cat.id}">${cat.name}</button>`;
      });
      addEventListenersToButton();
    }
    function addEventListenersToButton() {
      document.querySelectorAll("#filtrering button").forEach((elm) => {
        elm.addEventListener("click", filtrering);
      });
    }

    function filtrering() {
      filterProdukt = this.dataset.produkt;
      console.log(filterProdukt);

      visProdukter();
    }

    function visProdukter() {
      console.log(visProdukter);
      let temp = document.querySelector("template");
      let container = document.querySelector(".produktcontainer");
      //ryd container inden ny loop
      container.innerHTML = "";

      produkter.forEach((produkt) => {
        if (
          filterProdukt == "alle" ||
          produkt.categories.includes(parseInt(filterProdukt))
        ) {
          //klon template og indsæt data fra JSON
          let klon = temp.cloneNode(true).content;
          klon.querySelector("h2").textContent = produkt.title.rendered;
          klon.querySelector(".pris").textContent = produkt.pris + " kr.";
          klon.querySelector("img").src = produkt.billede[0].guid;

          // gør man kan klikke på et produkt og den åbner singleview.
          // produkt.link tager fat i linket til singleview siden
          klon.querySelector("article").addEventListener("click", () => {
            location.href = produkt.link;
          });

          //viser det i dommen
          container.appendChild(klon);
        }
      });
    }
    hentData();
  </script>
</div>
<!-- #primary -->

<?php get_footer(); ?>
