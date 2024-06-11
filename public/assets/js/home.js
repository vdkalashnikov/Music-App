// document.body.style.background = `linear-gradient(to right, rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}), rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}))`;

// const navbar = document.querySelector('.navbar');
// navbar.style.background = `linear-gradient(to right, rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}), rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}))`;

// const greeting = document.getElementById("greeting");
// const now = new Date();
// const hour = now.getHours();
// let message = "greeting";

// if (hour >= 0 && hour < 12) {
//   message = "Selamat pagi!";
// } else if (hour >= 12 && hour < 18) {
//   message = "Selamat siang!";
// } else {
//   message = "Selamat malam!";
// }

function updateGreeting() {
  const now = new Date();
  const hour = now.getHours();
  let greeting;

  if (hour < 11) {
      greeting = "Selamat Pagi";
  } else if (hour < 15) {
      greeting = "Selamat Siang";
  } else if (hour < 18) {
      greeting = "Selamat Sore";
  } else {
      greeting = "Selamat Malam";
  }

  document.getElementById('greeting').textContent = greeting;
}

// Update greeting on page load
window.onload = updateGreeting;
