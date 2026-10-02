// Fungsi generik: ambil data JSON lalu render ke tabel
// urlJson = alamat file JSON, kunci = daftar nama kunci yang jadi kolom
async function muatDaftar(urlJson, kunci) {
  const table = document.querySelector(".table-responsive table");
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");
  if (!tbody) return;

  loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    await new Promise((resolve) => setTimeout(resolve, 600));

    const res = await fetch(urlJson);
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    const daftar = await res.json();

    daftar.forEach(function (item) {
      const tr = document.createElement("tr");

      kunci.forEach(function (k) {
        const td = document.createElement("td");
        td.textContent = item[k];
        tr.appendChild(td);
      });

      const tdAksi = document.createElement("td");
      tdAksi.innerHTML =
        '<button type="button" class="btn btn-warning btn-sm text-white">Edit</button> ' +
        '<button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button>';
      tr.appendChild(tdAksi);

      tbody.appendChild(tr);
    });
  } catch (err) {
    const jumlahKolom = kunci.length + 1;
    tbody.innerHTML =
      '<tr><td colspan="' + jumlahKolom + '">Gagal memuat data: ' + err.message + "</td></tr>";
  } finally {
    loading.style.display = "none";
    updateTableCount(table);
  }
}