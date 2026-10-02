// Validasi form (client-side) 
function tampilkanError(input, pesan) {
  hapusError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initValidasiForm() {
  const form = document.getElementById("form-tambah");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    // Cek semua field yang wajib diisi (atribut "required" di HTML)
    const requiredFields = form.querySelectorAll("[required]");
    requiredFields.forEach(function (field) {
      if (field.value.trim() === "") {
        tampilkanError(field, "Field ini wajib diisi.");
        valid = false;
      } else {
        hapusError(field);
      }
    });

    const aturanKhusus = [
      {
        name: "tahun",
        cek: function (v) {
          const n = parseInt(v, 10);
          return !isNaN(n) && n >= 1900 && n <= new Date().getFullYear();
        },
        pesan: "Tahun harus di antara 1900-" + new Date().getFullYear() + "."
      },
      {
        name: "stok",
        cek: function (v) {
          const n = parseInt(v, 10);
          return !isNaN(n) && n >= 0;
        },
        pesan: "Stok tidak boleh negatif."
      }
    ];

    aturanKhusus.forEach(function (aturan) {
      const field = form.querySelector("[name='" + aturan.name + "']");
      if (field && field.value.trim() !== "" && !aturan.cek(field.value)) {
        tampilkanError(field, aturan.pesan);
        valid = false;
      }
    });

    const isbn = form.querySelector("[name='isbn']");
    if (isbn && isbn.value.trim() !== "") {
        const pola = /^[0-9-]+$/;
        if (!pola.test(isbn.value.trim())) {
            tampilkanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung.");
            valid = false;
        } else {
            hapusError(isbn);
        }
    }

    if (!valid) {
      e.preventDefault();
    }
  });
}

// Konfirmasi hapus (front-end only, belum ke server)
function initHapusConfirm() {
  document.querySelectorAll(".btn-hapus").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const nama = row ? row.querySelector("td")?.textContent : "data ini";
      const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
      if (yakin && row) {
        row.remove();
        updateTableCount(document.querySelector(".table-responsive table"));
      }
    });
  });
}

// Filter/pencarian tabel real-time 
function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table");
  if (!input || !table) return;

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach(function (row) {
        const kolomPertama = row.querySelector("td")?.textContent.toLowerCase() || "";
        row.style.display = kolomPertama.includes(keyword) ? "" : "none";
    });
  });
}

// tambah fungsi toggle animasi hamburger menu
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.getElementById("navMenu");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

function updateTableCount(table) {
  const counter = document.getElementById("table-count");
  if (!counter) return;
  const rows = table.querySelectorAll("tbody tr");
  let tampil = 0;
  rows.forEach(function (row) {
    if (row.style.display !== "none") tampil++;
  });
  counter.textContent = "Menampilkan " + tampil + " dari " + rows.length + " data.";
}

document.addEventListener("DOMContentLoaded", function () {
  initValidasiForm();
  initHapusConfirm();
  initTableFilter();
  initNavToggle();
  updateTableCount(document.querySelector(".table-responsive table"));
});
