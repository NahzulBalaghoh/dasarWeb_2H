// Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
async function muatDaftarBuku() {
  const table = document.querySelector(".table-responsive table");
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");
  if (!tbody) return;

  loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    await new Promise((resolve) => setTimeout(resolve, 3000));

    const res = await fetch("../data/buku.json");
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    const daftarBuku = await res.json();

    daftarBuku.forEach(function (buku) {
      const badge = buku.stok > 0
        ? '<span class="badge text-bg-success">Tersedia</span>'
        : '<span class="badge text-bg-secondary">Kosong</span>';

      const tr = document.createElement("tr");
      tr.innerHTML =
        "<td>" + buku.judul + "</td>" +
        "<td>" + buku.pengarang + "</td>" +
        "<td>" + buku.tahun + "</td>" +
        "<td>" + buku.kategori + "</td>" +
        "<td>" + buku.stok + " " + badge + "</td>" +
        "<td>" +
            '<button type="button" class="btn btn-warning btn-sm text-white">Edit</button> ' +
            '<button type="button" class="btn btn-info btn-sm text-white">Detail</button> ' +
            '<button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button>' +
        "</td>";
      tbody.appendChild(tr);
    });
  } catch (err) {
    tbody.innerHTML =
      '<tr><td colspan="6">Gagal memuat data: ' + err.message + "</td></tr>";
  } finally {
    loading.style.display = "none";
    updateTableCount(table); 
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Muat data pertama kali saat halaman siap
  muatDaftarBuku();

  // Tombol Muat Ulang (latihan 1)
  const btnMuatUlang = document.getElementById("btn-muat-ulang");
  if (btnMuatUlang) {
    btnMuatUlang.addEventListener("click", muatDaftarBuku);
  }
});