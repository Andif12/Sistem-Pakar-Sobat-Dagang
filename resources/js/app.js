import Echo from "laravel-echo";
import "../../public/assets/js/chat";

document.addEventListener("DOMContentLoaded", () => {
    //hanya memanggil menu dropdown kelurahan jika kecamatan dipilih
    const kelurahanList = {
        bacukiki: ["Galung Maloang", "Lemoe", "Lompoe", "Watang Bacukiki"],
        bacukiki_barat: ["Bumi Harapan", "Cappa Galung", "Kampung Baru", "Lumpue", "Sumpang Minangae", "Tiro Sompe"],
        soreang: ["Bukit Harapan", "Bukit Indah", "Kampung Pisang", "Lakessi", "Ujung Baru", "Ujung Lare", "Watang Soreang"],
        ujung: ["Labukkang", "Lapadde", "Mallusetasi", "Ujung Bulu", "Ujung Sabbang"]
    };

    const kecamatanSelect = document.getElementById("kecamatan");
    const kelurahanSelect = document.getElementById("kelurahan");

    if (kecamatanSelect && kelurahanSelect) {
        kecamatanSelect.addEventListener("change", function () {
            const selected = this.value;
            kelurahanSelect.innerHTML =
                '<option value="">Pilih Kelurahan</option>';
            kelurahanSelect.disabled = true;

            if (kelurahanList[selected]) {
                kelurahanList[selected].forEach((kel) => {
                    const option = document.createElement("option");
                    option.value = kel.toLowerCase().replace(/\s+/g, "_");
                    option.textContent = kel;
                    kelurahanSelect.appendChild(option);
                });
                kelurahanSelect.disabled = false;
            }
        });
    }
    const btnAjukan = document.getElementById("btn-ajukan");
    const btnDraft = document.getElementById("draftPerdagangan"); // tombol draft baru
    const modalVerifikasi = document.getElementById("modal-verifikasi");
    const modalDraft = document.getElementById("modal-draft");

    // Buka modal Ajukan
    if (btnAjukan && modalVerifikasi) {
        btnAjukan.addEventListener("click", function () {
            modalVerifikasi.classList.remove("hidden");
        });
    }

    // Buka modal Draft
    if (btnDraft && modalDraft) {
        btnDraft.addEventListener("click", function () {
            modalDraft.classList.remove("hidden");
        });
    }

    // Fungsi untuk tutup semua modal (verifikasi + draft)
    window.closeModal = function () {
        modalVerifikasi.classList.add("hidden");
        modalDraft.classList.add("hidden");
    };

    // Modal untuk Balasan (Lihat / Unduh PDF) pada riwayat surat
    function openModal(url) {
        // Tampilkan modal
        const modal = document.getElementById("modal");
        const modalContent = document.getElementById("modalContent");
        const downloadBtn = document.getElementById("downloadBtn");

        // Ubah iframe untuk menampilkan URL PDF
        modalContent.src = url;
        downloadBtn.href = url;

        // Tampilkan modal
        modal.classList.remove("hidden");
    }

    // Tutup modal saat tombol close diklik (modal PDF)
    const closeBtn = document.getElementById("closeModal");
    const modal = document.getElementById("modal");

    if (closeBtn && modal) {
        closeBtn.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    }

    // Tutup modal jika pengguna mengklik di luar modal (modal PDF)
    document.getElementById("modal").addEventListener("click", function (e) {
        if (e.target === this) {
            this.classList.add("hidden");
        }
    });

    window.io = require("socket.io-client");

    window.Echo = new Echo({
        broadcaster: "socket.io",
        host: window.location.hostname + ":6001",
    });
});
