<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>TravelGo Destinations</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f8f9fa; }
    .country-section { display: none; }
    .country-section.show { display: block; }
    .swiper { width: 100%; max-width: 900px; }
    .swiper-slide {
      background-position: center;
      background-size: cover;
      width: 300px;
      height: 400px;
      border-radius: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: bold;
      color: white;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
      transition: transform 0.4s ease, opacity 0.4s ease;
      opacity: 0.5;
      transform: scale(0.5);
      cursor: pointer;
    }
    .swiper-slide-active {
      opacity: 1;
      transform: scale(1.1);
      z-index: 10;
    }
    .list-group-item { margin-top: 40px; }
    .rating { color: gold; font-size: 1.2rem; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-transparent  navbar-overlay navbar-custom">
      <div class="container">
    <a class="navbar-brand fw-bold" href="#">TravelGo</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/travel-website">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
        <li class="nav-item"><a class="nav-link" href="/travel-website">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
<section class="py-5">
  <div class="container">
    <div class="dropdown mb-4">
      <button class="btn btn-outline-dark dropdown-toggle bg-primary text-white" type="button" data-bs-toggle="dropdown">Browse by Country</button>
      <ul class="dropdown-menu" id="countryDropdown"></ul>
    </div>
    <div id="countryContainer"></div>
  </div>
  <button class="btn btn-secondary position-fixed end-0 bottom-0 m-4" onclick="showMyList()">❤️ My List</button>

<div class="modal fade" id="myListModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Your Saved Places</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="myListContainer">
      </div>
    </div>
  </div>
</div>

</section>
<div class="modal fade" id="placeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="placeTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="placeImage" src="" alt="Place Image" class="img-fluid rounded mb-3" />
        <p id="placeDescription" class="text-muted"></p>
        <div class="rating mb-3" id="placeRating"></div>
        <button class="btn btn-outline-success" id="addToListBtn">➕ Add to My List</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="enquiryForm">
        <div class="modal-header">
          <h5 class="modal-title">Enquiry for <span id="enquiryPlaceName"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="placeData" />
          <div class="mb-3">
            <label for="userName" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="userName" required />
          </div>
          <div class="mb-3">
            <label for="userEmail" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="userEmail" required />
          </div>
          <div class="mb-3">
            <label for="userMessage" class="form-label">Message (Optional)</label>
            <textarea class="form-control" id="userMessage" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit Enquiry</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const countries = {
  "India": [
    { name: "Taj Mahal", img: "https://www.tajmahal.gov.in/images/banners/4.jpg", desc: "A symbol of love and Mughal architecture in Agra.", rating: 4.8 },
    { name: "Pink City", img: "https://static.toiimg.com/photo/115224744.cms", desc: "Jaipur’s vibrant architecture and historic forts.", rating: 4.6 },
    { name: "Kerala Backwaters", img: "https://cdn.audleytravel.com/300/214/79/524344-houseboat-kerala.webp", desc: "Serene houseboat cruises in Kerala.", rating: 4.7 },
    { name: "Varanasi Ghats", img: "https://www.savaari.com/blog/wp-content/uploads/2023/09/Varanasi_ghats1.webp", desc: "Spiritual riverfront steps.", rating: 4.5 }
  ],
  "Japan": [
    { name: "Tokyo", img: "https://res.cloudinary.com/aenetworks/image/upload/c_fill,ar_2,w_3840,h_1920,g_auto/dpr_auto/f_auto/q_auto:eco/v1/gettyimages-1390815938", desc: "A modern city with ancient culture.", rating: 4.8 },
    { name: "Kyoto", img: "https://www.pelago.com/img/destinations/kyoto/1129-0642_kyoto-xlarge.jpg", desc: "Temples and Geisha traditions.", rating: 4.6 },
    { name: "Osaka", img: "https://cdn.cheapoguides.com/wp-content/uploads/sites/3/2020/06/osaka-dotonbori-iStock-1138049211-1024x683.jpg", desc: "Vibrant city and street food.", rating: 4.7 },
    { name: "Mount Fuji", img: "https://cdn-imgix.headout.com/media/images/22fba69863f7d95408b199a4796db8e8-Fujinomiya%205th%20Station.jpg", desc: "Iconic volcanic peak.", rating: 4.5 }
  ],
  "France": [
  { name: "Eiffel Tower", img: "https://static.independent.co.uk/s3fs-public/thumbnails/image/2014/03/25/12/eiffel.jpg?width=1200", desc: "Iconic Paris landmark.", rating: 4.8 },
  { name: "Louvre Museum", img: "https://cdn.britannica.com/02/121002-050-92DB902F/Louvre-Museum-pyramid-Paris-Pei-IM.jpg", desc: "World’s largest art museum.", rating: 4.7 },
  { name: "Palace of Versailles", img: "https://cdn.britannica.com/63/256363-050-4334DD67/versailles-palace-facade-paris-france-chateau-de-versailles.jpg", desc: "Lavish royal château.", rating: 4.6 },
  { name: "Mont Saint-Michel", img: "https://myfrenchcountryhomemagazine.com/wp-content/uploads/2021/09/msm-featured.jpg", desc: "Tidal island commune.", rating: 4.5 }
],
"USA": [
  { name: "Statue of Liberty", img: "https://cdn-imgix.headout.com/tour/30357/TOUR-IMAGE/6cdcf542-452d-4897-beed-76cf68f154e4-1act-de005e04-05d9-4715-96b0-6a089d5c3460.jpg?auto=format&w=1222.3999999999999&h=687.6&q=90&fit=crop&ar=16%3A9&crop=faces", desc: "Symbol of freedom in NYC.", rating: 4.8 },
  { name: "Grand Canyon", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzCcaQFdoHOLqrXi1VKpC3nL0yb2NifXJZNQ&s", desc: "Stunning natural wonder.", rating: 4.9 },
  { name: "Yellowstone", img: "https://media.audleytravel.com/-/media/images/home/canada-and-the-usa/usa/places/gi_176679729_grand_prismatic_spring_yellowstone_national_park_3000x1000.jpg?q=79&w=1920&h=685", desc: "Famous geothermal park.", rating: 4.7 },
  { name: "Las Vegas Strip", img: "https://www.thestreet.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cg_faces:center%2Cq_auto:good%2Cw_640/MTkxNTY0MzY1MTQzNTQ5NjAz/las-vegas-strip3.jpg", desc: "Vibrant nightlife and casinos.", rating: 4.6 }
],
"Italy": [
  { name: "Colosseum", img: "https://cdn.mos.cms.futurecdn.net/BiNbcY5fXy9Lra47jqHKGK.jpg", desc: "Ancient Roman gladiator arena.", rating: 4.7 },
  { name: "Venice Canals", img: "https://i0.wp.com/www.ourpassionfortravel.com/wp-content/uploads/2018/11/Venice-Edits-138.jpg?fit=2640%2C3960&ssl=1", desc: "Romantic gondola rides.", rating: 4.6 },
  { name: "Leaning Tower of Pisa", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbCDB3yVmcvuXjXMwhgVFMZ0Qa8V_ICHvwGA&s", desc: "Iconic tilted bell tower.", rating: 4.5 },
  { name: "Florence Cathedral", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXEivIDcZaoXfgq69miSpR2RLbMmrI5g2AyQ&s", desc: "Stunning Renaissance architecture.", rating: 4.6 }
],
"Brazil": [
  { name: "Christ the Redeemer", img: "https://images.goway.com/production/styles/wide/s3/hero/iStock-458615673_1.jpg?VersionId=mgJB9fZrwvAIPklk4pQK.iHMlINpJ9Gp&itok=nUkHekw-", desc: "Famous statue in Rio.", rating: 4.8 },
  { name: "Sugarloaf Mountain", img: "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/8d/fc/12/foto-oficial.jpg?w=900&h=500&s=1", desc: "Granite peak with cable car.", rating: 4.6 },
  { name: "Iguazu Falls", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrd5WK8l5_fUcemSBlcc8H33eNvRy-TNdC8A&s", desc: "Massive waterfall system.", rating: 4.9 },
  { name: "Copacabana Beach", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0HkmuGKYBd6yJ_7RYei0JZUHVjFeesWUHJA&s", desc: "World-famous beach.", rating: 4.5 }
],
"Australia": [
  { name: "Sydney Opera House", img: "https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Sydneyoperahouse_at_night.jpg/1200px-Sydneyoperahouse_at_night.jpg", desc: "Architectural masterpiece.", rating: 4.8 },
  { name: "Great Barrier Reef", img: "https://cdn.britannica.com/64/155864-050-34FBD7A2/view-Great-Barrier-Reef-Australia-coast.jpg", desc: "Largest coral reef system.", rating: 4.9 },
  { name: "Uluru", img: "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/ULURU.jpg/960px-ULURU.jpg", desc: "Sacred red rock formation.", rating: 4.7 },
  { name: "Bondi Beach", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9PfBkJ1_Xy4PIxhydXUYwZGS6hYOvMhHbqA&s", desc: "Popular surf beach in Sydney.", rating: 4.5 }
],
"UK": [
  { name: "Big Ben", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5G_A7lSl5X9ha6Q-l7N6fjFi-Dp9XHDtOlQ&s", desc: "Famous clock tower.", rating: 4.7 },
  { name: "London Eye", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJGtt89H0KzUqgQJ107CW6aEGDzBHLaYY1Ow&s", desc: "Iconic riverside observation wheel.", rating: 4.6 },
  { name: "Stonehenge", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_6ZwsLK6EEFMCgZkJUiaAAeuVZJk-UkdoHA&s", desc: "Ancient stone circle.", rating: 4.5 },
  { name: "Tower Bridge", img: "https://cdn-imgix.headout.com/media/images/216f669b473d05d53f723407d894d886-london-city-01.jpg?auto=format&w=702.4499999999999&h=401.4&q=90&fit=crop&ar=7%3A4&crop=faces", desc: "Famous drawbridge over Thames.", rating: 4.6 }
],
"Thailand": [
  { name: "Phi Phi Islands", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5qjo2QZb7qXGhlkAjB1rlvsrcOyIYcPWlMw&s", desc: "Stunning island getaway.", rating: 4.7 },
  { name: "Grand Palace", img: "https://static.wixstatic.com/media/2cc94a_f41bf7cbf0d34a2faaf7f0e27aabb3b3~mv2.jpg/v1/fill/w_640,h_480,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/2cc94a_f41bf7cbf0d34a2faaf7f0e27aabb3b3~mv2.jpg", desc: "Bangkok’s royal complex.", rating: 4.6 },
  { name: "Chiang Mai Temples", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-jbAvcUozfHdHRi1belSbVYbGaRUqf-KUIA&s", desc: "Rich spiritual and cultural site.", rating: 4.5 },
  { name: "Railay Beach", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkzAEmPLpLbi9v74bZx1DlFOlMjfm3i7bSoA&s", desc: "Secluded paradise for climbers.", rating: 4.6 }
],
"Canada": [
  { name: "Niagara Falls", img: "https://cdn.britannica.com/41/129941-050-7A7D1027/Niagara-Falls-cities-River-Ontario-New-York.jpg", desc: "Powerful natural wonder.", rating: 4.9 },
  { name: "Banff National Park", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcakZYhCCLpVe2ST5OabEaY6XNTXfk0y9Yrw&s", desc: "Stunning alpine scenery.", rating: 4.8 },
  { name: "CN Tower", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcakZYhCCLpVe2ST5OabEaY6XNTXfk0y9Yrw&s", desc: "Toronto’s famous landmark.", rating: 4.6 },
  { name: "Old Quebec", img: "https://i.natgeofe.com/n/720ceef5-db9c-4531-b164-aa091c133b0f/upper-town-winter-old-quebec-city-canada.jpg", desc: "Historic French district.", rating: 4.5 }
],
"Egypt": [
  { name: "Great Pyramids of Giza", img: "https://www.planetware.com/photos-large/EGY/egypt-cairo-pyramids-of-giza.jpg", desc: "Ancient wonders of the world.", rating: 4.9 },
  { name: "Valley of the Kings", img: "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/30/1a/9f/6c/valley-og-the-kings.jpg?w=900&h=500&s=1", desc: "Pharaohs’ burial site.", rating: 4.7 },
  { name: "Abu Simbel", img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvxoBRkM63jEx75pHZQPfvhUxlGKozukwX-Q&s", desc: "Colossal twin temples.", rating: 4.6 },
  { name: "Karnak Temple", img: "https://images.memphistours.com/large/839487522_Karnak%20Temple.jpg", desc: "Massive ancient complex.", rating: 4.5 }
],
"China": [
  { name: "Great Wall", img: "https://whc.unesco.org/uploads/thumbs/site_0438_0035-750-750-20241024162522.jpg", desc: "Historic defensive wall.", rating: 4.8 },
  { name: "Forbidden City", img: "https://cdn.britannica.com/03/198203-050-138BB1C3/entrance-Gate-of-Divine-Might-Beijing-Forbidden.jpg", desc: "Imperial palace in Beijing.", rating: 4.6 },
  { name: "Terracotta Army", img: "https://www.chinadiscovery.com/assets/images/travel-guide/xian/2015-CD-Z-21772-768.jpg", desc: "Mausoleum army of Emperor Qin.", rating: 4.7 },
  { name: "Zhangjiajie Park", img: "https://sevennaturalwonders.org/wp-content/uploads/2024/02/Zhangjiajie-National-Park-landscape.jpg", desc: "Towering sandstone peaks.", rating: 4.5 }
]


};

function buildUI() {
  const dropdown = document.getElementById('countryDropdown');
  const container = document.getElementById('countryContainer');
  for (let country in countries) {
    const li = document.createElement('li');
    li.innerHTML = `<a class="dropdown-item" href="#" onclick="showCountry('${country}')">${country}</a>`;
    dropdown.appendChild(li);

    const section = document.createElement('div');
    section.className = 'country-section';
    section.id = `section-${country}`;
    section.innerHTML = `<h5 class="fw-bold">${country}</h5><div class="swiper mt-3"><div class="swiper-wrapper">${countries[country].map(place => `
      <div class="swiper-slide" style="background-image: url('${place.img}')" onclick="openModal('${place.name}', '${place.img}', '${place.desc}', ${place.rating}, '${country}')">${place.name}</div>
    `).join('')}</div><div class="swiper-button-next"></div><div class="swiper-button-prev"></div><div class="swiper-pagination"></div></div>`;
    container.appendChild(section);
  }
}

function showCountry(country) {
  document.querySelectorAll('.country-section').forEach(sec => sec.classList.remove('show'));
  document.getElementById(`section-${country}`).classList.add('show');
  setTimeout(() => {
    document.querySelectorAll(`#section-${country} .swiper`).forEach(swiperEl => {
      new Swiper(swiperEl, {
        slidesPerView: 'auto',
        centeredSlides: true,
        spaceBetween: 30,
        loop: true,
        pagination: { el: swiperEl.querySelector('.swiper-pagination'), clickable: true },
        navigation: { nextEl: swiperEl.querySelector('.swiper-button-next'), prevEl: swiperEl.querySelector('.swiper-button-prev') },
      });
    });
  }, 200);
}

function openModal(title, imageUrl, description, rating, country) {
  document.getElementById('placeTitle').textContent = title;
  document.getElementById('placeImage').src = imageUrl;
  document.getElementById('placeDescription').textContent = description;
  const ratingStars = Math.round(rating);
  document.getElementById('placeRating').innerHTML = '★'.repeat(ratingStars) + '☆'.repeat(5 - ratingStars) + ` <small class="text-muted">(${rating}/5)</small>`;
  document.getElementById('addToListBtn').onclick = () => addToList({ country, place: title, description, image: imageUrl, rating });
  const modal = new bootstrap.Modal(document.getElementById('placeModal'));
  modal.show();
}

function addToList(place) {
document.getElementById('enquiryPlaceName').textContent = place.name || place.place || 'Unknown Place';
  document.getElementById('placeData').value = JSON.stringify(place);
  const enquiryModal = new bootstrap.Modal(document.getElementById('enquiryModal'));
  enquiryModal.show();
}
function showMyList() {
  const listContainer = document.getElementById('myListContainer');
  listContainer.innerHTML = '<p class="text-muted">Loading your saved places...</p>';

  fetch('get_places.php')
    .then(response => response.json())
    .then(data => {
      listContainer.innerHTML = ''; 

      if (!data.length) {
        listContainer.innerHTML = '<p class="text-muted">No places saved yet.</p>';
        return;
      }

      data.forEach(place => {
        const div = document.createElement('div');
        div.className = 'card mb-3';
        div.innerHTML = `
          <div class="row g-0">
            <div class="col-md-4">
              <img src="${place.image}" class="img-fluid rounded-start" alt="${place.place}">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">${place.place}</h5>
                <p class="card-text">${place.description}</p>
                <p class="card-text"><small class="text-muted">Country: ${place.country}</small></p>
                <div class="rating">Rating: ★${place.rating}</div>
                <p class="card-text"><small class="text-muted">By: ${place.user_name} (${place.email})</small></p>
              </div>
            </div>
          </div>
        `;
        listContainer.appendChild(div);
      });
    })
    .catch(err => {
      listContainer.innerHTML = '<p class="text-danger">Failed to load saved places.</p>';
      console.error('Error:', err);
    });

  const modal = new bootstrap.Modal(document.getElementById('myListModal'));
  modal.show();
}



document.getElementById('enquiryForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const place = JSON.parse(document.getElementById('placeData').value);
  const userData = {
    name: document.getElementById('userName').value,
    email: document.getElementById('userEmail').value,
    message: document.getElementById('userMessage').value
  };

  const dataToSend = {
  ...place,
  place: place.place || place.name,  
  ...userData
};


  fetch('add_place.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(dataToSend)
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message || 'Enquiry submitted and place added!');
    bootstrap.Modal.getInstance(document.getElementById('enquiryModal')).hide();
  })
  .catch(err => alert('Error submitting enquiry'));
});

document.addEventListener('DOMContentLoaded', () => {
  buildUI();
  showCountry('India');
});
</script>
</body>
</html>
