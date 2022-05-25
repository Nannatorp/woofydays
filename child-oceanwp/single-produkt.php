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
      <img id="pic" src="" alt="" />
      <h2></h2>
      <p class="info"></p>
      <p class="info_3"></p>
      <p class="pris"></p>
    </article>
  </main>
  <script>

     let produkt;

     const url = "https://nannatorp.dk/kea/09_cms/babushka_wp/wordpress/wp-json/wp/v2/produkt/"+<?php echo get_the_ID() ?>;


     async function hentData() {
    console.log("hentData");

    const data = await fetch(url);
    produkt = await data.json();
    visProdukter();
     }
     function visProdukter() {
      console.log(produkt.billede.guid);

      document.querySelector("#pic").src = produkt.billede.guid;
    document.querySelector("h2").textContent = produkt.title.rendered;
    document.querySelector(".info").textContent = produkt.beskrivelse;
    document.querySelector(".info_3").textContent =
      "Oprindelsesregion: " + produkt.oprindelsesregion;
    document.querySelector(".pris").textContent =
      "Pris: " + produkt.pris + ",-";
     }
     hentData();

     document.querySelector("button").addEventListener("click", () => {
    history.back();
     });
  </script>
</div>
<!-- #primary -->

<?php get_footer(); ?>
