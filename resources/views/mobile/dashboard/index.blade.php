<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6 text-gray-900 dark:text-gray-100 text-2xl font-medium text-center text-body divide-x divide-default rounded-base sm:flex rtl:divide-x-reverse">
                {{ __("Welcome back, :name!", ['name' => auth()->user()->name]) }}
            </div>

            <div class="space-y-2">
                <div class="bg-neutral-primary-soft dark:bg-gray-800 block max-w-sm p-6 border border-default rounded-base shadow-xs">
                    <h5 class="mb-3 text-center text-2xl font-semibold tracking-tight text-heading leading-8">{{ $active ?? 0 }}
                        <i
                                class="ml-2 text-[#3B82F6] fas fa-person-walking"></i></h5>
                    <p class="text-body text-center mb-6">In Progress</p>
                </div>
                <div class="bg-neutral-primary-soft dark:bg-gray-800 block max-w-sm p-6 border border-default rounded-base shadow-xs">
                    <h5 class="mb-3 text-center text-2xl font-semibold tracking-tight text-heading leading-8">{{ $dueToday ?? 0 }}
                        <i class="ml-2 text-[#F97316] fas fa-bolt"></i></h5>
                    <p class="text-body text-center mb-6">Focus Today</p>
                </div>
                <div class="bg-neutral-primary-soft dark:bg-gray-800 block max-w-sm p-6 border border-default rounded-base shadow-xs">
                    <h5 class="mb-3 text-center text-2xl font-semibold tracking-tight text-heading leading-8">{{ $complete ?? 0 }}
                        <i class="ml-2 text-[#10B981] fas fa-trophy"></i></h5>
                    <p class="text-body text-center mb-6">Completed</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
