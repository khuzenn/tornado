<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Layout container -->
    <div class="layout-page">
      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
          <h3 class="mb-4 fw-bold">List Produk</h3>
          <div class="row">
            <!-- Hoverable Table rows -->
            <div class="card pb-3 px-4">
                <table id="kt-tabel" class="table table-hover">
                <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header fw-bold px-1 pt-3 pb-3">List Produk</h5>
                <div class="table-responsive text-nowrap">
                    <div class="pb-3 pt-4">
                    <a href="#">
                        <button class="btn btn-outline-primary justify-content-center" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                            <i class="bx bx-export me-sm-1 pb-1"></i>
                            <span class="d-none d-sm-inline-block">Export</span>
                        </button>
                    </a>
                    </div>
                </div>
                </div>
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Produk</th>
                      <th class="text-center">Stok</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <?php
                    $no = 1;
                    foreach ($listProduk->result() as $produk) {
                        ?>
                    <tr>
                        <td class="text-center"><?= $no; ?></td>
                        <td class="text-center"><?= $produk->produk; ?></td>
                        <td class="text-center"><?= $produk->stok; ?></td>
                        <td class="text-center">
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= site_url('Produk/update/' . $produk->id_produk); ?>"
                                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                >
                                <a class="dropdown-item" href="<?= site_url('Produk/delete/' . $produk->id_produk); ?>"
                                    ><i class="bx bx-trash-alt me-1"></i> Hapus</a
                                >
                            </div>
                        </div>
                        </td>
                    </tr>
                    <?php
                        $no++;
                    }
                    ?>
                  </tbody>
                </table>
                <center class="py-4">
                    <a href="<?= site_url('Produk/add'); ?>">
                        <button class="btn btn-outline-primary justify-content-center" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                            <i class="bx bx-plus-circle me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Tambah Produk</span>
                        </button>
                    </a>
                </center>
              </div>
            </div>
            <!--/ Hoverable Table rows -->
          </div>
        </div>
        <!-- / Content -->
      </div>
    </div>
  </div>
</div>