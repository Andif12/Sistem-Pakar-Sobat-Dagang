document.addEventListener("DOMContentLoaded", function () {
    // Tombol switch antar tab
    const ajukanBtn = document.querySelector("#btnForm");
    const riwayatBtn = document.querySelector("#btnRiwayat");
    const ajukanSection = document.querySelector("#formPermohonan");
    const riwayatSection = document.querySelector("#riwayatPermohonan");

    if (ajukanBtn && riwayatBtn) {
      ajukanBtn.addEventListener("click", function (e) {
        e.preventDefault();
        ajukanBtn.classList.add("bg-blue-600", "text-white");
        ajukanBtn.classList.remove("text-gray-700", "hover:bg-gray-100");
  
        riwayatBtn.classList.remove("bg-blue-600", "text-white");
        riwayatBtn.classList.add("text-gray-700", "hover:bg-gray-100");
  
        ajukanSection.classList.remove("hidden");
        riwayatSection.classList.add("hidden");
      });
  
      riwayatBtn.addEventListener("click", function (e) {
        e.preventDefault();
        riwayatBtn.classList.add("bg-blue-600", "text-white");
        riwayatBtn.classList.remove("text-gray-700", "hover:bg-gray-100");
  
        ajukanBtn.classList.remove("bg-blue-600", "text-white");
        ajukanBtn.classList.add("text-gray-700", "hover:bg-gray-100");
  
        riwayatSection.classList.remove("hidden");
        ajukanSection.classList.add("hidden");
      });
    }
  
    // Optional: fitur filter atau interaksi lainnya bisa ditambah di sini
  });
  