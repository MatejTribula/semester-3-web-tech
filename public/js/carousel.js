// === Configuration ===
const imageSources = [
  "/images/grey.png",   // moved from /resources/ to /public/images/
  "/images/orange.png"
];
const changeInterval = 3000; // ms between slides

// === Core Elements ===
const carousel = document.querySelector(".carousel");
if (!carousel) throw new Error("Carousel element not found!");

const imgContainer = carousel.querySelector(".carousel-img");
const dotsContainer = carousel.querySelector(".carousel-progress");

let currentIndex = 0;
let interval;

// === Dynamically add image element ===
const imgElement = document.createElement("img");
imgElement.src = imageSources[0];
imgElement.alt = "carousel image";
imgElement.style.transition = "opacity 0.5s ease";
imgElement.style.width = "100%";
imgElement.style.height = "auto";
imgContainer.appendChild(imgElement);

// === Dynamically generate dots ===
dotsContainer.innerHTML = ""; // clear any placeholder dots
imageSources.forEach((_, i) => {
  const dot = document.createElement("div");
  dot.classList.add("carousel-dot");
  if (i === 0) dot.classList.add("active");
  dot.addEventListener("click", () => goToSlide(i));
  dotsContainer.appendChild(dot);
});

const dots = dotsContainer.querySelectorAll(".carousel-dot");

// === Core Functions ===
function updateCarousel() {
  // Fade out, change image, fade in
  imgElement.style.opacity = 0;
  setTimeout(() => {
    imgElement.src = imageSources[currentIndex];
    imgElement.style.opacity = 1;
  }, 200);

  // Update dots
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

// === Init ===
updateCarousel();
resetInterval();
