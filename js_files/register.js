let selectedCategory = "";
const categoriesContainer = document.getElementById("categoriesContainer");

// Fetch members dynamically
fetch("php_files/members.php")
  .then(res => res.json())
  .then(data => renderCategories(data))
  .catch(err => console.error(err));

function renderCategories(members) {
  const categories = ["Supporter", "Mentor", "Leader", "Member"];
  categoriesContainer.innerHTML = "";

  categories.forEach(cat => {
    const catMembers = members.filter(m => m.category === cat);

    // Category container
    const catDiv = document.createElement("div");
    catDiv.className = "category";
    catDiv.innerHTML = `<h2>${cat}</h2>`;

    // Members inside category
    const membersDiv = document.createElement("div");
    membersDiv.className = "members";

    catMembers.forEach(member => {
      const card = document.createElement("div");
      card.className = "member-card";
      card.innerHTML = `
        <img src="${member.image_url || 'images/default.png'}" alt="${member.username}">
        <p>${member.username}</p>
      `;
      membersDiv.appendChild(card);
    });

    // Join button
    const joinBtn = document.createElement("button");
    joinBtn.textContent = "Join " + cat;
    joinBtn.onclick = () => openForm(cat);

    catDiv.appendChild(membersDiv);
    catDiv.appendChild(joinBtn);
    categoriesContainer.appendChild(catDiv);
  });
}

// Modal open/close
function openForm(category) {
  selectedCategory = category;
  document.getElementById("selectedCategory").textContent = category;
  document.getElementById("registerModal").style.display = "flex";
}

function closeForm() {
  document.getElementById("registerModal").style.display = "none";
}

// Registration
const regForm = document.getElementById("regForm");
regForm.addEventListener("submit", function(e){
  e.preventDefault();
  register();
});

function register() {
  const username = document.getElementById("username").value.trim();
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const image = document.getElementById("image").files[0];

  if (!username || !name || !email || !password) {
    alert("Please fill all fields! Image is optional.");
    return;
  }

  const formData = new FormData();
  formData.append("username", username);
  formData.append("Name", name);
  formData.append("email", email);
  formData.append("password", password);
  formData.append("category", selectedCategory);
  formData.append("image", image);

  fetch("php_files/registerMember.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      alert("Registered successfully!");
      window.location.reload();
    } else {
      alert("Error: " + data.message);
    }
  });
}

// Close popup
function closePopup() {
  document.getElementById("successPopup").style.display = "none";
}
