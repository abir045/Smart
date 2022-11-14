const mbNav = document.getElementById("mbNav");
mbNav.style.display = "none";

function showNav(e) {
  // mbNav.style.display = "none";

  if (mbNav.style.display === "none") {
    mbNav.style.display = "block";
  } else {
    mbNav.style.display = "none";
  }
}
