// Use the variable defined in Blade
const imageSources = window.imageSources || [];
const changeInterval = 6000;

// === Core Elements ===
const carousel = document.querySelector(".carousel");
if (!carousel) throw new Error("Carousel element not found!");

const imgContainer = carousel.querySelector(".carousel-img");
const dotsContainer = carousel.querySelector(".carousel-progress");

let currentIndex = 0;
let interval;

const imgElement = document.createElement("img");
imgElement.src = imageSources[0]?.src || imageSources[0];
imgElement.alt = "carousel image";
imgElement.style.transition = "opacity 0.5s ease";
imgElement.style.width = "100%";
imgElement.style.height = "auto";
imgElement.style.cursor = "pointer";  // show it's clickable
imgContainer.appendChild(imgElement);

// Make image clickable
imgElement.addEventListener("click", () => {
  const item = imageSources[currentIndex];
  const productId = item?.id || item;
  if (productId) {
    window.location.href = `/products/${productId}`;
  }
});

dotsContainer.innerHTML = "";
imageSources.forEach((_, i) => {
  const dot = document.createElement("div");
  dot.classList.add("carousel-dot");
  if (i === 0) dot.classList.add("active");
  dot.addEventListener("click", () => goToSlide(i));
  dotsContainer.appendChild(dot);
});

const dots = dotsContainer.querySelectorAll(".carousel-dot");

function updateCarousel() {
  imgElement.style.opacity = 0;
  setTimeout(() => {
    const item = imageSources[currentIndex];
    imgElement.src = item?.src || item;
    imgElement.style.opacity = 1;
  }, 200);
  dots.forEach((dot, i) => dot.classList.toggle("active", i === currentIndex));
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % imageSources.length;
  updateCarousel();
}

function goToSlide(index) {
  currentIndex = index;
  updateCarousel();
  resetInterval();
}

function resetInterval() {
  clearInterval(interval);
  interval = setInterval(nextSlide, changeInterval);
}

updateCarousel();
resetInterval();
