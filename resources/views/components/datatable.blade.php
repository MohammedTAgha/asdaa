<div class="card card-flush mt-6 mt-xl-9">
    <!--begin::Card header-->
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <!--begin::Head-->
                <thead class="fs-7 text-gray-400 text-uppercase">
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-15px">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" />
                            </div>
                        </th>
                        <th class="min-w-90px">الهوية</th>
                        <th class="min-w-180px">الاسم</th>
                        <th class="min-w-90px">تاريخ الميلاد</th>
                        <th class="min-w-40px">الجنس</th>
                        <th class="min-w-100px ">اسم الزوجة</th>
                        <th class="min-w-50px ">الحالة الاجتماعية</th>
                        <th class="min-w-50px ">المنطقة</th>
                        <th class="min-w-50px ">ملاحظة</th>
                        <th class="min-w-50px "> -  </th>
                    </tr>
                </thead>
                <!--end::Head-->
                <!--begin::Body-->
                <tbody class="fw-bold text-gray-600">
                @foreach ($citizens as $citizen)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <!--begin::Checkbox-->
                        <td class="px-2 py-1">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <!--begin::Checkbox-->
                        <td class="px-2 py-1 bg-gray-50">
                        <a href="{{ route('citizens.show',$citizen->id) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                            {{ $citizen->id }}
                            </a>
                        </td>
                        <td class="px-2 py-1">
                            <a href="{{ route('citizens.show',$citizen->id) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                                {{ $citizen->name }}
                            </a>
                        </td>
                        <td class="px-2 py-1 bg-gray-50">{{ $citizen->date_of_birth }}</td>
                        <td class="px-2 py-1">{{ $citizen->gender }}</td>
                        <td class="px-2 py-1 bg-gray-50">{{ $citizen->wife_name }}</td>
                        <td class="px-2 py-1">{{ $citizen->social_status }}</td>
                        <td class="px-2 py-1 bg-gray-50">{{ $citizen->region->name ?? 'N/A' }}</td>
                        <td class="px-2 py-1">{{ $citizen->note }}</td>
                        <td class="px-2 py-1 bg-gray-50">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <!--end::Body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->
    </div>
    <!--end::Card body-->
</div>

<!--begin::Page Vendors Javascript(used by this page)-->
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="assets/js/custom/apps/customers/list/export.js"></script>
<script src="assets/js/custom/apps/customers/list/list.js"></script>
<script src="assets/js/custom/apps/customers/add.js"></script>
<script src="assets/js/custom/widgets.js"></script>
<script src="assets/js/custom/apps/chat/chat.js"></script>
<script src="assets/js/custom/modals/create-app.js"></script>
<script src="assets/js/custom/modals/upgrade-plan.js"></script>
<!-- <script src="assets/js/custom/apps/chat/chat.js"></script> -->
<!-- <script src="assets/js/custom/modals/create-app.js"></script> -->
<!-- <script src="assets/js/custom/modals/upgrade-plan.js"></script> -->
<!--end::Page Custom Javascript-->