const eventsGrid = document.getElementById("eventsGrid");
const statusFilter = document.getElementById("statusFilter");
const typeButtons = document.querySelectorAll(".type-btn");

let events = [];
let selectedType = "all";
let selectedStatus = "upcoming";

// Fetch events from backend
fetch("php_files/getEvents.php")
  .then((res) => {
    if (!res.ok) throw new Error("Failed to fetch events from server");
    return res.json();
  })
  .then((data) => {
    events = data;
    renderEvents();
  })
  .catch((err) => {
    console.error(err);
    eventsGrid.innerHTML =
      "<p style='color:red; text-align:center;'>Failed to load events. Please try again later.</p>";
  });

// Utility: Determine event status
function getStatus(event) {
  const today = new Date().toISOString().split("T")[0];
  if (event.start_date > today) return "upcoming";
  if (event.start_date <= today && event.end_date >= today) return "ongoing";
  return "past";
}

// Render events in the grid
function renderEvents() {
  eventsGrid.innerHTML = "";

  const filtered = events.filter((ev) => {
    const status = getStatus(ev);
    if (status !== selectedStatus) return false;
    if (selectedType === "all") return true;
    return ev.type === selectedType;
  });

  if (filtered.length === 0) {
    eventsGrid.innerHTML = "<p style='text-align:center;'>No events found.</p>";
    return;
  }

  filtered.forEach((ev) => {
    const status = getStatus(ev);
    const card = document.createElement("div");
    card.className = "event-card";

    // Image or gradient background
    card.style.backgroundImage = ev.image_url
      ? `url(${ev.image_url})`
      : `linear-gradient(135deg, #7da5f4, #ffffff)`;

    // Card content
    card.innerHTML = `
      <div class="event-type ${ev.type === "competition" ? "competition" : ""}">
        ${ev.type.charAt(0).toUpperCase() + ev.type.slice(1)}
      </div>
      <div class="event-info">
        <h3>${ev.name}</h3>
        <p>${ev.start_date} to ${ev.end_date}</p>
        <p>${ev.description}</p>
        ${
          status === "upcoming"
            ? `<button class="join-btn" onclick="joinEvent('${ev.id}', '${ev.name}')">Join</button>`
            : ""
        }
      </div>
    `;

    eventsGrid.appendChild(card);
  });
}
setTimeout(() => {
  document.querySelectorAll(".event-card").forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
    card.classList.add("show");
  });
}, 100);

// Handle join button click
function joinEvent(id, name) {
  // Redirect to registration form (change link if needed)
  window.location.href = `/JURC/event_register.html?event_id=${id}&event_name=${encodeURIComponent(name)}`;
}

// Event listeners
statusFilter.addEventListener("change", (e) => {
  selectedStatus = e.target.value;
  renderEvents();
});

typeButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    typeButtons.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
    selectedType = btn.dataset.type;
    renderEvents();
  });
});
