---
layout: home
title: "Accueil"
---

<section class="section">
  <div class="container">
    {% include home/hero.md %}
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="mb-3">Mes compétences principales</h2>
    {% include home/skills.html %}
  </div>
</section>

<section id="mon-parcours" class="section section-highlight">
  <div class="container">
    <h2>Mon parcours, mon <span class="text-primary">expertise</span>.</h2>
    {% include home/career.html %}
  </div>
</section>

<section id="confiance" class="section">
  <div class="container">
    <h2 class="mb-3">Ils m'ont fait <span class="text-primary">confiance</span>. Qu'attendez-vous ?</h2>
    {% include home/trusted.html %}
  </div>
</section>
