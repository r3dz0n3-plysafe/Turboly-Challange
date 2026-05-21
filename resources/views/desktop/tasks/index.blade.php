<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12 flex-1 p-6 lg:p-8 space-y-6 max-h-screen w-full">

        <div class="bg-neutral-secondary-medium border border-neutral-800 p-6 rounded-2xl shadow-xl space-y-4">
            <h2 class="text-xs font-bold uppercase tracking-wider text-neutral-400">Tambah Tugas Baru</h2>
            <form id="add-task-form" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="space-y-1 md:col-span-2">
                    <label class="text-xs font-semibold text-neutral-400">Deskripsi Tugas</label>
                    <input type="text" id="input-desc" required placeholder="Tulis rencana tugas Anda..."
                           class="w-full text-sm px-3 py-2 border border-neutral-800 rounded-xl bg-neutral-950 text-neutral-100 placeholder-neutral-600 focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-neutral-400">Jatuh Tempo</label>
                    <input type="date" id="input-date" required
                           class="w-full text-sm px-3 py-2 border border-neutral-800 rounded-xl bg-neutral-950 text-neutral-100 focus:outline-none focus:border-indigo-500 transition [color-scheme:dark]">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-neutral-400">Prioritas</label>
                    <select id="input-priority"
                            class="w-full text-sm px-3 py-2 border border-neutral-800 rounded-xl bg-neutral-950 text-neutral-200 focus:outline-none focus:border-indigo-500 transition">
                        <option value="high">🔴 Tinggi</option>
                        <option value="medium">🟡 Sedang</option>
                        <option value="low">🔵 Rendah</option>
                    </select>
                </div>
                <button type="submit"
                        class="w-full md:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md transition cursor-pointer">
                    Simpan
                </button>
            </form>
        </div>

        <!-- UTALITAS BAR FILTER (SEARCH & SORT) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-800 pb-4">
            <div class="flex-1 max-w-md relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-neutral-500">
          <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </span>
                <input type="text" id="search-input" placeholder="Cari deskripsi tugas..."
                       class="w-full text-xs pl-9 pr-3 py-2 border border-neutral-800 rounded-xl bg-neutral-secondary-medium text-neutral-200 placeholder-neutral-500 focus:outline-none focus:border-indigo-500 transition">
            </div>
            <div class="flex items-center gap-2">
                <label class="text-xs font-medium text-neutral-400 whitespace-nowrap"><i
                            class="fa-solid fa-arrow-down-short-wide text-neutral-500"></i> Sort By:</label>
                <select id="sort-select"
                        class="text-xs px-3 py-1.5 border border-neutral-800 rounded-lg bg-neutral-secondary-medium text-neutral-200 font-medium focus:outline-none focus:border-indigo-500 transition">
                    <option value="due_date">📅 Tanggal Tempo</option>
                    <option value="description">🔤 Deskripsi (A-Z)</option>
                    <option value="priority">🔥 Prioritas Utama</option>
                </select>
            </div>
        </div>

        <!-- PANEL AREA 2 KOLOM UTAMA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            <!-- KOLOM KIRI: TUGAS AKTIF -->
            <div class="bg-neutral-secondary-medium border border-neutral-800 p-5 rounded-2xl shadow-md space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                    <h3 class="font-bold text-sm md:text-base text-neutral-100 flex items-center gap-2">
                        <i class="fa-regular fa-clipboard text-indigo-400"></i> Tugas Aktif
                    </h3>
                    <!-- Tempat Paging Inline Aktif (< Halaman >) -->
                    <div id="active-pagination" class="flex items-center gap-1.5 text-xs"></div>
                </div>
                <div id="active-tasks-container" class="space-y-3 min-h-[150px]"></div>
            </div>

            <!-- KOLOM KANAN: TUGAS SELESAI -->
            <div class="bg-neutral-secondary-medium/40 border border-neutral-800/80 p-5 rounded-2xl shadow-inner space-y-4">
                <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                    <h3 class="font-bold text-sm md:text-base text-neutral-400 flex items-center gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-400"></i> Selesai
                    </h3>
                    <!-- Tempat Paging Inline Selesai (< Halaman >) -->
                    <div id="completed-pagination" class="flex items-center gap-1.5 text-xs"></div>
                </div>
                <div id="completed-tasks-container" class="space-y-3 min-h-[150px]"></div>
            </div>

        </div>

    </div>
</x-app-layout>


<!-- SCRIPT UTAMA UNTUK MENANGANI REQ AJAX & BIG DATA -->
<script>
    $(document).ready(function () {
        // Inisialisasi token pengaman CSRF global untuk AJAX jQuery
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        // State virtual aplikasi
        let currentSearch = '';
        let currentSortBy = 'due_date';
        let pageActive = 1;
        let pageCompleted = 1;
        let searchTimeout = null;

        // Sinkronisasi data utama dari database laravel
        function fetchDashboardData() {
            $('#active-tasks-container, #completed-tasks-container').html(
                '<div class="text-center py-8 text-neutral-500 text-xs animate-pulse">Sinkronisasi data server...</div>'
            );

            $.ajax({
                url: '/tasks',
                method: 'GET',
                data: {
                    search: currentSearch,
                    sortBy: currentSortBy,
                    page_active: pageActive,
                    page_completed: pageCompleted
                },
                success: function (response) {
                    renderColumn(response.active, '#active-tasks-container', '#active-pagination', 'active');
                    renderColumn(response.completed, '#completed-tasks-container', '#completed-pagination', 'completed');
                },
                error: function () {
                    alert('Gagal memuat data dari server. Silakan muat ulang halaman.');
                }
            });
        }

        // Fungsi modular render antarmuka per kolom beserta paginasi inline-nya
        function renderColumn(dataObject, containerSelector, paginationSelector, type) {
            let tasks = dataObject.data;
            let container = $(containerSelector);
            let paginationContainer = $(paginationSelector);

            // 1. Render data kedalam bentuk Card List
            if (tasks.length === 0) {
                container.html('<div class="text-center py-10 text-neutral-600 text-xs bg-neutral-950/30 border border-dashed border-neutral-800 rounded-xl">Belum ada daftar tugas.</div>');
            } else {
                let html = '';
                tasks.forEach(function (task) {
                    // Pemformatan warna badge prioritas dinamis gaya Dark Mode (Text cerah, bg redup)
                    let badgeColor = 'bg-blue-500/10 text-blue-400 border border-blue-500/20';
                    if (task.priority === 'high') badgeColor = 'bg-red-500/10 text-red-400 border border-red-500/20';
                    if (task.priority === 'medium') badgeColor = 'bg-amber-500/10 text-amber-400 border border-amber-500/20';

                    let rawDate = new Date(task.due_date);
                    let formattedDate = rawDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });

                    html += `
              <div class="bg-neutral-primary/35 p-3.5 rounded-xl border border-neutral-800/60 shadow-xs flex items-start justify-between gap-2 hover:border-neutral-700 transition">
                <div class="flex items-start gap-2.5">
                  <input type="checkbox" ${task.is_completed ? 'checked' : ''} data-id="${task.id}" class="btn-toggle mt-1 h-4 w-4 rounded dark:bg-neutral-900 border-neutral-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-neutral-950 cursor-pointer">
                  <div>
                    <h4 class="text-xs font-semibold ${task.is_completed ? 'line-through text-neutral-600 font-normal' : 'text-neutral-200'}">${task.description}</h4>
                    <div class="flex items-center gap-2 mt-1">
                      <span class="text-[10px] text-neutral-500 font-medium"><i class="fa-regular fa-calendar mr-1"></i> ${formattedDate}</span>
                      <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider ${badgeColor}">${task.priority}</span>
                    </div>
                  </div>
                </div>
                <!--<button data-id="${task.id}" class="btn-delete text-red-400 text-xs p-1 transition cursor-pointer"><i class="fa-regular fa-trash-can"></i></button>-->
              </div>
            `;
                });
                container.html(html);
            }

            // 2. Render Mekanisme Paging Horizontal (< Halaman >)
            paginationContainer.empty();
            if (dataObject.last_page > 1) {
                // Tombol Prev (<)
                let prevBtn = dataObject.prev_page_url
                    ? `<button data-type="${type}" data-page="${dataObject.current_page - 1}" class="btn-page px-2 py-0.5 bg-neutral-secondary-medium/25 border border-neutral-700 rounded-md hover:bg-neutral-700 font-black text-neutral-200 shadow-xs cursor-pointer transition">&lt;</button>`
                    : `<span class="px-2 py-0.5 bg-neutral-secondary-medium/35 border border-neutral-800 rounded-md text-neutral-700 select-none">&lt;</span>`;

                // Label Tengah (Halaman aktif / Total halaman)
                let pageInfo = `<span class="font-bold text-neutral-400 px-2 bg-neutral-secondary-medium/35 rounded-md text-[10px] py-0.5 border border-neutral-800">${dataObject.current_page}/${dataObject.last_page}</span>`;

                // Tombol Next (>)
                let nextBtn = dataObject.next_page_url
                    ? `<button data-type="${type}" data-page="${dataObject.current_page + 1}" class="btn-page px-2 py-0.5 bg-neutral-secondary-medium/25 border border-neutral-700 rounded-md hover:bg-neutral-700 font-black text-neutral-200 shadow-xs cursor-pointer transition">&gt;</button>`
                    : `<span class="px-2 py-0.5 bg-neutral-secondary-medium/35 border border-neutral-800 rounded-md text-neutral-700 select-none">&gt;</span>`;

                paginationContainer.append(prevBtn).append(pageInfo).append(nextBtn);
            } else {
                paginationContainer.html('<span class="text-neutral-600 text-[10px] font-normal italic">Semua data termuat</span>');
            }
        }

        // ================= INTERAKSI EVENT LISTENER JQUERY =================

        // Eksekusi Paging Klik
        $(document).on('click', '.btn-page', function () {
            let type = $(this).data('type');
            let targetPage = $(this).data('page');

            if (type === 'active') {
                pageActive = targetPage;
            } else {
                pageCompleted = targetPage;
            }
            fetchDashboardData();
        });

        // Fitur Pencarian Debounce
        $('#search-input').on('input', function () {
            clearTimeout(searchTimeout);
            currentSearch = $(this).val();
            pageActive = 1;
            pageCompleted = 1;

            searchTimeout = setTimeout(function () {
                fetchDashboardData();
            }, 400);
        });

        // Eksekusi Dropdown Sorting
        $('#sort-select').on('change', function () {
            currentSortBy = $(this).val();
            fetchDashboardData();
        });

        // Aksi Submit Tambah Tugas Baru via AJAX
        $('#add-task-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/tasks',
                method: 'POST',
                data: {
                    description: $('#input-desc').val(),
                    due_date: $('#input-date').val(),
                    priority: $('#input-priority').val()
                },
                success: function () {
                    $('#add-task-form')[0].reset();
                    pageActive = 1;
                    fetchDashboardData();
                }
            });
        });

        // Aksi Klik Checkbox (Ubah Status Is Completed)
        $(document).on('click', '.btn-toggle', function () {
            let id = $(this).data('id');
            $.ajax({
                url: `/tasks/${id}/toggle`,
                method: 'POST',
                success: function () {
                    fetchDashboardData();
                }
            });
        });

        // Aksi Hapus Permanen
        $(document).on('click', '.btn-delete', function () {
            if (!confirm("Hapus data tugas ini secara permanen?")) return;
            let id = $(this).data('id');
            $.ajax({
                url: `/tasks/${id}`,
                method: 'DELETE',
                success: function () {
                    fetchDashboardData();
                }
            });
        });

        // Render pertama kali saat dokumen siap diakses browser
        fetchDashboardData();
    });
</script>