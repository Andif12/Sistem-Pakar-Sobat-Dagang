import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

document.addEventListener("DOMContentLoaded", function () {
    const kecamatanSelect = new TomSelect("#kecamatan", {
        create: false,
        sortField: { field: "text" },
    });
    const kelurahanSelect = new TomSelect("#kelurahan", {
        create: false,
        sortField: { field: "text" },
    });

    const kelurahanList = {
        bacukiki: ["Galung Maloang", "Lemoe", "Lompoe", "Watang Bacukiki"],
        bacukiki_barat: [
            "Bumi Harapan",
            "Cappa Galung",
            "Kampung Baru",
            "Lumpue",
            "Sumpang Minangae",
            "Tiro Sompe",
        ],
        soreang: [
            "Bukit Harapan",
            "Bukit Indah",
            "Kampung Pisang",
            "Lakessi",
            "Ujung Baru",
            "Ujung Lare",
            "Watang Soreang",
        ],
        ujung: [
            "Labukkang",
            "Lapadde",
            "Mallusetasi",
            "Ujung Bulu",
            "Ujung Sabbang",
        ],
    };

    const kecamatanElement = document.getElementById("kecamatan");
    const kelurahanElement = document.getElementById("kelurahan");

    if (kecamatanElement && kelurahanElement) {
        kecamatanElement.addEventListener("change", function () {
            const selectedKecamatan = this.value;
            kelurahanSelect.clearOptions();

            if (kelurahanList[selectedKecamatan]) {
                kelurahanList[selectedKecamatan].forEach(function (kelurahan) {
                    kelurahanSelect.addOption({
                        value: kelurahan.toLowerCase().replace(/\s+/g, "_"),
                        text: kelurahan,
                    });
                });
                kelurahanSelect.enable();
            } else {
                kelurahanSelect.disable();
            }
        });
    }
});
