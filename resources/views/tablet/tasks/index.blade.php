<x-app-layout>
    {{--<div id="toast-top-right"
         class="fixed flex items-center w-full max-w-xs p-4 text-body bg-success-soft rounded-base shadow-xs border border-default top-20 end-5 z-[100]"
         role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-7 h-7 text-fg-success bg-success-soft rounded">
            <i class="fas fa-check"></i>
        </div>
        <div class="ms-3 text-sm font-normal">Mark as completed successfully.</div>
        <button type="button"
                class="ms-auto flex items-center justify-center text-body hover:text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded text-sm h-8 w-8 focus:outline-none"
                data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18 17.94 6M18 18 6.06 6"/>
            </svg>
        </button>
    </div>--}}
    <!-- Mengirim data ke slot bernama tasktotal -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="lg:p-8 space-y-6 w-full">

        {{--<div class="bg-neutral-secondary-medium border border-neutral-800 p-6 rounded-2xl shadow-xl space-y-4">
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
        </div>--}}

        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                type="button">
            Add Task
        </button>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b dark:border-neutral-800 pb-4">
            <div class="flex-1 relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-neutral-500">
          <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </span>
                <input type="text" id="search-input" placeholder="Search..."
                       class="w-full text-xs pl-9 pr-3 py-2 border border-neutral-300 dark:border-neutral-800 rounded-xl bg-neutral-secondary-medium dark:text-neutral-200 placeholder-neutral-500 focus:outline-none focus:border-indigo-500 transition">
            </div>
            <div class="flex items-center justify-end gap-2">
                <label class="text-xs font-medium dark:text-neutral-400 whitespace-nowrap"><i
                            class="fa-solid fa-arrow-down-short-wide text-neutral-500"></i> Sort By:</label>
                <select id="sort-select"
                        class="text-xs px-3 py-1.5 border border-neutral-300 dark:border-neutral-800 rounded-lg bg-neutral-secondary-medium dark:text-neutral-200 font-medium focus:outline-none focus:border-indigo-500 transition">
                    <option value="due_date">📅 Due Date</option>
                    <option value="description">🔤 Description (A-Z)</option>
                    <option value="priority">🔥 Highest Priority</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            <div class="bg-neutral-secondary-medium border dark:border-neutral-800 p-5 rounded-2xl shadow-md space-y-4">
                <div class="flex items-center justify-between border-b dark:border-neutral-800 pb-3">
                    <h3 class="font-bold text-sm md:text-base text-body dark:text-neutral-100 flex items-center gap-2">
                        <i class="fa-regular fa-clipboard text-indigo-400"></i> You need To-Do
                    </h3>
                    <div id="active-pagination" class="flex items-center gap-1.5 text-xs"></div>
                </div>
                <div id="active-tasks-container" class="space-y-3 min-h-[150px]"></div>
            </div>

            <div class="bg-neutral-secondary-medium/40 border dark:border-neutral-800/80 p-5 rounded-2xl shadow-md dark:shadow-inner space-y-4">
                <div class="flex items-center justify-between border-b dark:border-neutral-800 pb-3">
                    <h3 class="font-bold text-sm md:text-base text-body dark:text-neutral-400 flex items-center gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-400"></i> Completed
                    </h3>
                    <div id="completed-pagination" class="flex items-center gap-1.5 text-xs"></div>
                </div>
                <div id="completed-tasks-container" class="space-y-3 min-h-[150px]"></div>
            </div>

        </div>

    </div>
</x-app-layout>

<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    Create new task
                </h3>
                <button type="button"
                        class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="crud-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="add-task-form">
                <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                    <div class="col-span-2">
                        <label for="input-desc"
                               class="block mb-2.5 text-sm font-medium text-heading">Description</label>
                        <input type="text" maxlength="200" name="description" id="input-desc"
                               class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                               placeholder="Type task name" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="input-date" class="block mb-2.5 text-sm font-medium text-heading">Due Date</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                </svg>
                            </div>
                            <input id="input-date" datepicker datepicker-buttons datepicker-autoselect-today
                                   datepicker-orientation="top" datepicker-autohide type="text" name="date" required=""
                                   class="block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body"
                                   placeholder="Select date">
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="input-priority"
                               class="block mb-2.5 text-sm font-medium text-heading">Priority</label>
                        <select id="input-priority" name="priority"
                                class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body">
                            <option selected="">Select priority</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-between space-x-4 border-t border-default pt-4 md:pt-6">
                    <button type="submit"
                            class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 12h14m-7 7V5"/>
                        </svg>
                        Add new task
                    </button>
                    <button data-modal-hide="crud-modal" type="button"
                            class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        let currentSearch = '';
        let currentSortBy = 'due_date';
        let pageActive = 1;
        let pageCompleted = 1;
        let searchTimeout = null;

        function fetchDashboardData() {
            $('#active-tasks-container, #completed-tasks-container').html(
                `<div class="text-center py-5">
    <div role="status">
        <svg aria-hidden="true" class="inline w-8 h-8 w-8 h-8 text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
    </div>
</div>`
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
                    alert('Failed to load data.');
                }
            });
        }

        function renderColumn(dataObject, containerSelector, paginationSelector, type) {
            let tasks = dataObject.data;
            let container = $(containerSelector);
            let paginationContainer = $(paginationSelector);

            if (tasks.length === 0) {
                container.html('<div class="text-center py-10 text-body dark:text-neutral-600 text-xs bg-fg-brand/40 dark:bg-neutral-950/30 border border-dashed dark:border-neutral-800 rounded-xl">You are free!</div>');
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
              <div class="bg-neutral-primary/35 p-3.5 rounded-xl border dark:border-neutral-800/60 shadow-xs flex items-start justify-between gap-2 hover:border-brand transition">
                <div class="flex items-start gap-2.5">
                  <input type="checkbox" ${task.is_completed ? 'checked' : ''} data-id="${task.id}" class="btn-toggle mt-1 h-4 w-4 rounded dark:bg-neutral-900 border-neutral-400 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-neutral-950 cursor-pointer">
                  <div>
                    <h4 class="text-xs font-semibold ${task.is_completed ? 'line-through text-neutral-600 font-normal' : 'dark:text-neutral-200'}">${task.description}</h4>
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

            paginationContainer.empty();
            if (dataObject.last_page > 1) {
                let prevBtn = dataObject.prev_page_url
                    ? `<button data-type="${type}" data-page="${dataObject.current_page - 1}" class="btn-page px-2 py-0.5 bg-neutral-secondary-medium/25 border dark:border-neutral-700 rounded-md hover:text-fg-brand font-black text-neutral-700 dark:text-neutral-200 shadow-xs cursor-pointer transition"><i class="fa-solid fa-chevron-left"></i></button>`
                    : `<span class="px-2 py-0.5 bg-neutral-secondary-medium/35 border border-default dark:border-neutral-800 rounded-md text-neutral-200 dark:text-neutral-700 select-none"><i class="fa-solid fa-chevron-left"></i></span>`;

                // Label Tengah (Halaman aktif / Total halaman)
                let pageInfo = `<span class="font-bold text-neutral-400 px-2 bg-neutral-secondary-medium/35 rounded-md text-[10px] py-0.5 border dark:border-neutral-800">${dataObject.current_page} / ${dataObject.last_page}</span>`;

                // Tombol Next (>)
                let nextBtn = dataObject.next_page_url
                    ? `<button data-type="${type}" data-page="${dataObject.current_page + 1}" class="btn-page px-2 py-0.5 bg-neutral-secondary-medium/25 border dark:border-neutral-700 rounded-md hover:text-fg-brand font-black text-neutral-700 dark:text-neutral-200 shadow-xs cursor-pointer transition"><i class="fa-solid fa-chevron-right"></i></button>`
                    : `<span class="px-2 py-0.5 bg-neutral-secondary-medium/35 border border-default dark:border-neutral-800 rounded-md text-neutral-200 dark:text-neutral-700 select-none"><i class="fa-solid fa-chevron-right"></i></span>`;

                paginationContainer.append(prevBtn).append(pageInfo).append(nextBtn);
            } else {
                paginationContainer.html('');
            }
        }

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

        $('#search-input').on('input', function () {
            clearTimeout(searchTimeout);
            currentSearch = $(this).val();
            pageActive = 1;
            pageCompleted = 1;

            searchTimeout = setTimeout(function () {
                fetchDashboardData();
            }, 400);
        });

        $('#sort-select').on('change', function () {
            currentSortBy = $(this).val();
            fetchDashboardData();
        });

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
                    (new Modal(document.getElementById('crud-modal'))).hide()
                    pageActive = 1;
                    fetchDashboardData();
                }
            });
        });

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

        /*$(document).on('click', '.btn-delete', function () {
            if (!confirm("Delete this task?")) return;
            let id = $(this).data('id');
            $.ajax({
                url: `/tasks/${id}`,
                method: 'DELETE',
                success: function () {
                    fetchDashboardData();
                }
            });
        });*/

        fetchDashboardData();
    });
</script>