const nav = document.querySelector(".sidebar");
const toggleBtn = document.querySelector(".humberg");
toggleBtn.addEventListener("click", () => {
    nav.classList.toggle("open-nav");
})
