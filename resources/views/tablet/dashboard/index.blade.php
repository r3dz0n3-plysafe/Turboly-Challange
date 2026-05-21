<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 w-full overflow-hidden border border-default shadow-xs sm:rounded-base">
                <div class="p-6 justify-center text-gray-900 dark:text-gray-100 text-2xl font-medium text-center text-body divide-x divide-default rounded-base sm:flex rtl:divide-x-reverse">
                    {{ __("Welcome back, :name!", ['name' => auth()->user()->name]) }}
                </div>
                <div class="border-t border-default">
                    <div class="p-4 rounded-base md:p-8">
                        <dl class="grid max-w-screen-xl grid-cols-1 gap-8 p-4 mx-auto text-heading sm:grid-cols-3 xl:grid-cols-3 sm:p-8">
                            <div class="flex flex-col text-center">
                                <dt class="mb-2 text-2xl font-semibold tracking-tight text-heading">{{ $active ?? 0 }}
                                    <i class="ml-2 text-[#3B82F6] fas fa-person-walking"></i></dt>
                                <dd class="text-body">In Progress</dd>
                            </div>
                            <div class="flex flex-col text-center">
                                <dt class="mb-2 text-2xl font-semibold tracking-tight text-heading">{{ $dueToday ?? 0 }}
                                    <i class="ml-2 text-[#F97316] fas fa-bolt"></i></dt>
                                <dd class="text-body">Focus Today</dd>
                            </div>
                            <div class="flex flex-col text-center">
                                <dt class="mb-2 text-2xl font-semibold tracking-tight text-heading">{{ $complete ?? 0 }}
                                    <i class="ml-2 text-[#10B981] fas fa-trophy"></i></dt>
                                <dd class="text-body">Completed</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="p-4 md:p-8 text-body text-center">
                        <i class="fa-solid fa-coffee fa-8x"></i>
                        <h4 class="mt-2">Coffee</h4>
                        <p>
                            "It is inhumane, in
                            <a
                                    href="https://www.washingtonpost.com/archive/lifestyle/magazine/1997/11/09/grounds-for-suspicion/075c7cfe-d5cf-4443-ae42-a95e6e46fed7"
                            >my opinion</a>, to force people who have a genuine medical need for coffee to wait in line
                            behind people who apparently view it
                            as some kind of recreational activity."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
