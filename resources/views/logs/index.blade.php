<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            سجل النشاطات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="activity-logs-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>المستخدم</th>
                                <th>نوع النشاط</th>
                                <th>الوصف</th>
                                <th>التفاصيل</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#activity-logs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('logs.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'event_type', name: 'event_type' },
                    { data: 'description', name: 'description' },
                    { data: 'details', name: 'details' },
                    { data: 'created_at_formatted', name: 'created_at' }
                ],
                order: [[0, 'desc']]
            });
        });
    </script>
    @endpush
</x-app-layout>
