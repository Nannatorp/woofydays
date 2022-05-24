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
          
          <h2></h2>
		  <p class="pris"></p>
          <p class="underoverskrift-1"></p>
          <p class="beskrivelse-1"></p>
          <p class="underoverskrift-2"></p>
          <p class="beskrivelse-2"></p>
          <p class="underoverskrift-3"></p>
          <p class="beskrivelse-3"></p>
		  <img class="billede1" src="" alt="" />
		  <video class="video1" src=""> </video>
          
        </article>
      </template>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
      <nav id="filtrering"> <button data-produkt="alle">Alle produkter</button> </nav>
      <section class="produktcontainer" ></section>
	  </main><!-- #main -->
<script>
  let produkter;
  let categories;
  let filterProdukt = "alle";

	// link til wp database alle produkter
	const dbUrl = "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/produkt?per_page=100";
	// link til wp database alle kategorier
	const catUrl = "https://nannatorp.dk/kea/10_eksamensprojekt/woofydays/wp-json/wp/v2/categories";

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
  categories.forEach(cat =>{
    document.querySelector("#filtrering").innerHTML += `<button class="filter" data-produkt="${cat.id}">${cat.name}</button>`
  })
  addEventListenersToButton();
}
function addEventListenersToButton() {
  document.querySelectorAll("#filtrering button").forEach(elm =>{
    elm.addEventListener("click", filtrering);
  })
  
};

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

  produkter.forEach(produkt => {
	  //loop igennem produkter
    if ( filterProdukt == "alle" || produkt.categories.includes(parseInt(filterProdukt))){
      let klon = temp.cloneNode(true).content;
      klon.querySelector("h2").textContent = produkt.title.rendered;
      klon.querySelector(".underoverskrift-1").textContent = produkt.underoverskriftet;
      klon.querySelector(".underoverskrift-2").textContent = produkt.underoverskriftto;
      klon.querySelector(".underoverskrift-3").textContent = produkt.underoverskrifttre;
      klon.querySelector(".beskrivelse-1").textContent = produkt.beskrivelseet;
      klon.querySelector(".beskrivelse-2").textContent = produkt.beskrivelseto;
      klon.querySelector(".beskrivelse-3").textContent = produkt.beskrivelsetre;
      klon.querySelector(".pris").textContent = produkt.pris;
      klon.querySelector(".billede1").src = produkt.billede.guid;
      klon.querySelector(".video1").src = produkt.video.guid;

      klon.querySelector("article").addEventListener("click", () => {
        location.href = produkt.link;
        });

      container.appendChild(klon);
    }
  });
}
hentData();

</script>
		
	</div><!-- #primary --> 

	
	

<?php get_footer(); ?>
