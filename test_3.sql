INSERT INTO mst_department (id_dept, nama_dept) 
VALUES (1, 'Department IT'),(4, 'Department Exim'), (5, 'Department Legal');

INSERT INTO mst_jabatan (id_jabatan, nama_jabatan, id_level) 
VALUES (1, 'Staff IT Developer', 4),(6, 'Admin Exim', 7),(7, 'Admin Legal', 4);

INSERT INTO mst_level (id_level, nama_level) 
VALUES (4, 'IT Officer 1'),(7, 'Junior Associate 5'),(8, 'Junior Associate 3');

INSERT INTO mst_karyawan (id_karyawan, nik, nama, tgl_lahir, alamat, id_jabatan, id_dept) 
VALUES 
(1, '1234567', 'Dwi Sulistyo Nugroho', '1997-05-25', 'Bekasi Timur', 1, 1),
(3, '1234569', 'Firmawan Adi', '1995-01-22', 'Bintaro', 6, 4),
(7, '12471847', 'Agung Gumelar', '2024-06-04', 'Bekasi Timur', 7, 5);

SELECT
k.nama as nama_karyawan,
j.nama_jabatan,
d.nama_dept,
l.nama_level
FROM
mst_karyawan as k
INNER JOIN mst_jabatan as j
ON k.id_jabatan = j.id_jabatan
INNER JOIN mst_department as d
ON k.id_dept = d.id_dept
INNER JOIN mst_level as l
ON j.id_level = l.id_level;

UPDATE mst_karyawan
set nama = 'Dwi'
where
nik = '1234567';

DELETE from mst_karyawan where nik = '12471847';