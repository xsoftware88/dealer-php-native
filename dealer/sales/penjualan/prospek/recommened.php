<?php

include __DIR__ . '/../../head.php';
include __DIR__ . '/../../menu.php';
?>

<div class="container">
    <form class="form-horizontal" action="simpan-spk.php" method="POST">
        <div class="row=fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" for="jenis">Jenis Penjualan</label>
                            <div class="controls">
                                <select name="jenis" class="jenis">
                                    <option>Tunai</option>
                                    <option>Kredit</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group leasing">
                            <label class="control-label" for="leasing">Leasing</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="leasing" name="leasing">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="nama">Nama Customer</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="nama" name="nama_cust">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="alamat">Alamat</label>
                            <div class="controls">
                                <textarea type="text" id="alamat" name="alamat"></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="kota">Kota</label>
                            <div class="controls">
                                <select name="kota">
                                    <option>Bangkalan</option>
                                    <option>Banyuwangi</option>
                                    <option>Kab.Blitar</option>
                                    <option>Bojonegoro</option>
                                    <option>Bondowoso</option>
                                    <option>Gresik</option>
                                    <option>Jember</option>
                                    <option>Jombang</option>
                                    <option>Kab.Kediri</option>
                                    <option>Lamongan</option>
                                    <option>Lumajang</option>
                                    <option>Kab.Madiun</option>
                                    <option>Magetan</option>
                                    <option>Kab.Malang</option>
                                    <option>Kab.Mojokerto</option>
                                    <option>Nganjuk</option>
                                    <option>Ngawi</option>
                                    <option>Pacitan</option>
                                    <option>Pamekasan</option>
                                    <option>Kab.Pasuruan</option>
                                    <option>Ponorogo</option>
                                    <option>Kab.Probolinggo</option>
                                    <option>Sampang</option>
                                    <option>Sidoarjo</option>
                                    <option>Situbondo</option>
                                    <option>Sumenep</option>
                                    <option>Trenggalek</option>
                                    <option>Tuban</option>
                                    <option>Tulungagung</option>
                                    <option>Batu</option>
                                    <option>Blitar</option>
                                    <option>Kediri</option>
                                    <option>Madiun</option>
                                    <option>Malang</option>
                                    <option>Mojokerto</option>
                                    <option>Pasuruan</option>
                                    <option>Probolinggo</option>
                                    <option>Surabaya</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="kota">Kecamatan / Desa</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="kecamatan" name="kecamatan">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email">Email Customer</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="email" name="email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="tipe">Tipe Unit</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="tipe" name="tipe">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="warna">Warna</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="warna" name="warna">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="tahun">Tahun</label>
                            <div class="controls">
                                <input type="text" class="input-large" id="tahun" name="tahun">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="submit" class="btn btn-primary" value="Simpan" name="simpan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
