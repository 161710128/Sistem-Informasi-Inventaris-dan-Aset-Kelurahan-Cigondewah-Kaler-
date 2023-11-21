<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
          <li class="nav-item">
            @php
            $role = Auth::user()->role;
            $url = ($role === 'lurah') ? '/lurah/dashboard' : '/admin/dashboard';
            @endphp
              <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : ''}}" aria-current="page" href="{{ $url }}" style="font-size:17px; margin-left:-5px;">
                  <span data-feather="home" class="align-text-bottom" style="margin-bottom:2px;"></span>
                  Dashboard
              </a>
          </li>
          <li class="border-top my-3"></li>

          {{-- Tampilkan hanya jika pengguna memiliki peran 'admin' --}}
          @if(Auth::check() && Auth::user()->role === 'admin')
              <li class="mb-1">
                  <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                      Data Master
                  </button>
                  <div class="collapse" id="dashboard-collapse">
                      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="/admin/pegawai" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="users" class="align-text-bottom" style="margin-right: 5px;"></span>Pegawai</a></li>
                          <li><a href="/admin/kategoribarang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="package" class="align-text-bottom" style="margin-right: 5px;"></span>Kategori Barang</a></li>
                          <li><a href="/admin/supplier" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="truck" class="align-text-bottom" style="margin-right: 5px;"></span>Supplier</a></li>
                          {{-- <li><a href="/admin/penempatan" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="map-pin" class="align-text-bottom" style="margin-right: 5px;"></span>Penempatan</a></li> --}}
                      </ul>
                  </div>
              </li>
          @endif
          @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'lurah'))
            <li class="mb-1">
              
                <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                    Pencarian Barang
                </button>
                <div class="collapse" id="orders-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @php
                        $role = Auth::user()->role;
                        $url = ($role === 'lurah') ? '/lurah/pencarian/barang' : '/admin/pencarian/barang';
                        @endphp
                        <li><a href="{{ $url }}" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="box" class="align-text-bottom" style="margin-right: 5px;"></span> Barang</a></li>
                        @php
                        $role = Auth::user()->role;
                        $url = ($role === 'lurah') ? '/lurah/inventaris' : '/admin/inventaris';
                        @endphp
                        <li><a href="{{ $url }}" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="briefcase" class="align-text-bottom" style="margin-right: 5px;"></span> Inventaris</a></li>
                        {{-- <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="archive" class="align-text-bottom" style="margin-right: 5px;"></span> Stok Barang</a></li> --}}
                    </ul>
                </div>
            </li>
          @endif
          @if(Auth::check() && Auth::user()->role === 'admin')
              <li class="mb-1">
                  <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                      Data Transaksi
                  </button>
                  <div class="collapse" id="home-collapse">
                      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="/admin/transaksi/pengadaan-barang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span>Transaksi Pengadaan Barang</a></li>
                          <li><a href="/admin/transaksi/penempatan-barang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span>Transaksi Penempatan Barang</a></li>
                          <li><a href="/admin/transaksi/peminjaman-barang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span>Transaksi Peminjaman Barang</a></li>
                          <li><a href="/admin/transaksi/pemeliharaan-barang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span>Transaksi Pemeliharaan Barang</a></li>
                          <li><a href="/admin/transaksi/pengembalian-barang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span>Transaksi Pengembalian Barang</a></li>
                          <li><a href="/admin/transaksi/pemakaian-barang" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span>Transaksi Pemakaian Barang</a></li>
                          <li><a href="/admin/transaksi/pemakaian-barangHabisPakai" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="circle" class="align-text-bottom" style="margin-right: 5px;"></span> Pemakaian Barang Habis Pakai</a></li>
                      </ul>
                  </div>
              </li>
          @endif

          <li class="border-top my-3"></li>

          {{-- Tampilkan hanya jika pengguna memiliki peran 'lurah' --}}
          @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'lurah'))
              <li class="mb-1">
                  <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                      Laporan
                  </button>
                  <div class="collapse" id="account-collapse">
                      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          @php
                            $role = Auth::user()->role;
                            $url = ($role === 'lurah') ? '/lurah/laporan/barang' : '/admin/laporan/barang';
                          @endphp
                          <li><a href="{{ $url }}" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Barang</a></li>
                          @php
                            $role = Auth::user()->role;
                            $url = ($role === 'lurah') ? '/lurah/laporan/pengadaan' : '/admin/laporan/pengadaan';
                          @endphp
                          <li><a href="{{ $url }}" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Pengadaan</a></li>
                          @if(Auth::check() && Auth::user()->role === 'admin')
                            <li><a href="/admin/laporan/supplier" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Supplier</a></li>
                            <li><a href="/admin/laporan/pegawai" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Pegawai</a></li>
                            <li><a href="/admin/laporan/peminjaman" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Peminjaman</a></li>
                            <li><a href="/admin/laporan/pengembalian" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Pengembalian</a></li>
                            <li><a href="/admin/laporan/pemeliharaan" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Pemeliharaan</a></li>
                            <li><a href="/admin/laporan/pemakaian" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Laporan Data Pemakaian</a></li>
                            <li><a href="/admin/laporan/barangHabisPakai" class="link-dark d-inline-flex text-decoration-none rounded"><span data-feather="file-text" class="align-text-bottom" style="margin-right: 5px;"></span>Data Barang Habis Pakai</a></li>
                          @endif
                      </ul>
                  </div>
              </li>
          @endif

          <hr>
      </ul>
  </div>
</nav>
