CREATE TABLE IF NOT EXISTS peminjaman (
    id                  SERIAL PRIMARY KEY,
    buku_id             INT  NOT NULL REFERENCES buku(id)    ON DELETE CASCADE,
    anggota_id          INT  NOT NULL REFERENCES anggota(id) ON DELETE CASCADE,
    tanggal_pinjam      DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_jatuh_tempo DATE NOT NULL,
    tanggal_kembali     DATE
);

INSERT INTO peminjaman (buku_id, anggota_id, tanggal_pinjam, tanggal_jatuh_tempo, tanggal_kembali) VALUES
-- sedang dipinjam, belum jatuh tempo
((SELECT id FROM buku ORDER BY id LIMIT 1 OFFSET 0), (SELECT id FROM anggota ORDER BY id LIMIT 1 OFFSET 0), CURRENT_DATE - 3,  CURRENT_DATE + 4,  NULL),
-- terlambat
((SELECT id FROM buku ORDER BY id LIMIT 1 OFFSET 1), (SELECT id FROM anggota ORDER BY id LIMIT 1 OFFSET 1), CURRENT_DATE - 20, CURRENT_DATE - 6,  NULL),
((SELECT id FROM buku ORDER BY id LIMIT 1 OFFSET 2), (SELECT id FROM anggota ORDER BY id LIMIT 1 OFFSET 2), CURRENT_DATE - 12, CURRENT_DATE - 2,  NULL),
-- sudah dikembalikan (tidak ikut dihitung)
((SELECT id FROM buku ORDER BY id LIMIT 1 OFFSET 3), (SELECT id FROM anggota ORDER BY id LIMIT 1 OFFSET 3), CURRENT_DATE - 10, CURRENT_DATE - 3,  CURRENT_DATE - 5);