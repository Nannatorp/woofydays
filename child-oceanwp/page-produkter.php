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
  <article id="produkt-article">
    <img class="billede1" src="" alt="" />
    <h2></h2>
    <p class="pris"></p>
  </article>
</template>

<div id="content" class="site-content clr">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">
      <img
        class="wp-block-cover__image-background"
        alt=""
        src="https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-content/uploads/2022/06/gåtur_v2-scaled.webp"
        style="object-position: 50% 54%"
      />

      <h1 class="produkttitel">Produkter</h1>

      <nav id="filtrering">
        <button data-produkt="alle">Alle produkter</button>
      </nav>

      <section class="produktcontainer"></section>

      <!-- footer -->
      <img
        class="wp-block-cover__image-background"
        alt="footer"
        src="https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-content/uploads/2022/05/footer-1.svg"
        style="object-position: 50% 100%"
      />
      <!-- footer slut -->
    </main>
    <!-- #main -->
    <script>
      let produkter;
      let categories;
      let filterProdukt = "alle";
      let h1 = document.querySelector(".produkttitel");

      // link til wp database alle produkter
      const dbUrl =
        "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/produkt?per_page=100";
      // link til wp database alle kategorier
      const catUrl =
        "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/categories";

      // Henter data ind
      async function hentData() {
        const data = await fetch(dbUrl);
        const catdata = await fetch(catUrl);
        //fylder data i variablerne
        produkter = await data.json();
        categories = await catdata.json();
        console.log(produkter);
        visProdukter();
        opretKnapper();
      }

      // function der opretter knapper med kategori id som data attribut
      function opretKnapper() {
        categories.forEach((cat) => {
          document.querySelector(
            "#filtrering"
          ).innerHTML += `<button class="filter" data-produkt="${cat.id}">${cat.name}</button>`;
        });
        addEventListenersToButton();
      }

      // funcktion der laver en click eventListener til knapperne
      // kigger på alle de knapper som er sat ind i nav

      function addEventListenersToButton() {
        document.querySelectorAll("#filtrering button").forEach((elm) => {
          elm.addEventListener("click", filtrering);
        });
      }

      // function der filtrere kanpperne når der klikkes (this = det der er klikket på)
      function filtrering() {
        filterProdukt = this.dataset.produkt;
        console.log(filterProdukt);

        //skrifter overskriften
        h1.textContent = this.textContent;

        visProdukter();
      }

      function visProdukter() {
        console.log(visProdukter);
        let temp = document.querySelector("template");
        let container = document.querySelector(".produktcontainer");

        //ryd visings container inden ny loop/visning
        container.innerHTML = "";

        produkter.forEach((produkt) => {
          //viser produkterne afhæning af hvilken knap der er trykket på
          // parseInt gør det bliver lavet om til et tal
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
</div>
<!-- #content -->

<?php get_footer(); ?>
