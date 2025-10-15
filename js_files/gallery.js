// List of gallery images (replace with real paths or URLs)
const images = [
  "/JURC/images/gallery1.jpg",
  "/JURC/images/gallery2.jpg",
  "/JURC/images/gallery3.jpg",
  "/JURC/images/gallery4.jpg",
  "/JURC/images/gallery5.jpg",
  "/JURC/images/gallery6.jpg",
];

const galleryContainer = document.getElementById("galleryContainer");
const showMoreBtn = document.getElementById("showMoreBtn");

let imagesToShow = 4; // Show 4 initially

function renderGallery() {
  galleryContainer.innerHTML = "";

  for (let i = 0; i < imagesToShow && i < images.length; i++) {
    const imgDiv = document.createElement("div");
    imgDiv.className = "gallery-item";
    imgDiv.innerHTML = `<img src="${images[i]}" alt="Gallery Image ${i + 1}">`;
    galleryContainer.appendChild(imgDiv);
  }

  // Hide button if all images are shown
  if (imagesToShow >= images.length) {
    showMoreBtn.style.display = "none";
  } else {
    showMoreBtn.style.display = "block";
  }
}

showMoreBtn.addEventListener("click", () => {
  imagesToShow += 4; // Show 4 more each click
  renderGallery();
});

// Initial render
renderGallery();
