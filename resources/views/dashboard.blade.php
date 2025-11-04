<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @can('is-admin')
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Admin Panel: Manajemen User
                        </h3>
                        <livewire:admin-user-list />
                    @else
                        <div class="mb-6 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Galeri Foto Saya
                            </h3>
                            
                            <livewire:file-uploader /> 
                        </div>
                        
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                            <livewire:photo-gallery />
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</x-app-layout>