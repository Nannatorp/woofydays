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

<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <article id="singleview">
      <div class="billedecontainer"></div>
      <h2></h2>
      <p class="pris"></p>
      <p class="underoverskrift-1"></p>
      <p class="beskrivelse-1"></p>
      <p class="underoverskrift-2"></p>
      <p class="beskrivelse-2"></p>
      <p class="underoverskrift-3"></p>
      <p class="beskrivelse-3"></p>
      <video class="video1" src=""></video>
    </article>
  </main>
  <script>

      let produkt;

      //link til database med en php snippet med en function der gør vi kan få postens id.
      const url = "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/produkt/"+<?php echo get_the_ID() ?>;


      async function hentData() {
     console.log("hentData");

     const data = await fetch(url);
     produkt = await data.json();
     visProdukter();
      }
      function visProdukter() {
       console.log(produkt.billede.guid);

     document.querySelector("h2").textContent = produkt.title.rendered;
     document.querySelector(".pris").textContent = produkt.pris + " kr.";
    document.querySelector(".underoverskrift-1").textContent =
             produkt.underoverskriftet;
    document.querySelector(".underoverskrift-2").textContent =
             produkt.underoverskriftto;
    document.querySelector(".underoverskrift-3").textContent =
             produkt.underoverskrifttre;
    document.querySelector(".beskrivelse-1").textContent =
             produkt.beskrivelseet;
    document.querySelector(".beskrivelse-2").textContent =
             produkt.beskrivelseto;
    document.querySelector(".beskrivelse-3").textContent =
             produkt.beskrivelsetre;
    document.querySelector(".video1").src = produkt.video.guid;

           //et array af billder og det looper vi igennem  med en html streng vi kloner billede containeren
           //og sætter en inner html på med img så den løber igennem billederne til der ikke er flere med forEach
           produkt.billede.forEach((pic) => {
             let img = `<img class="billede1" src="${pic.guid}" alt="" />`;
             document.querySelector(".billedecontainer").innerHTML += img;
           });
      }
      hentData();
      
  </script>
</div>
<!-- #primary -->

<?php get_footer(); ?>
