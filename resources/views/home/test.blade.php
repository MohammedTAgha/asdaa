@extends('dashboard')

@section('styles')
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />


@endsection
@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">DataTables /</span> Basic</h4>

    <!-- DataTable with Buttons -->
    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Date</th>
              <th>Salary</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody >
            @foreach ($citizens as $citizen)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <!--begin::Checkbox-->
                    <td class="px-2 py-1">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="citizens[]"
                                value="{{ $citizen->id }}" />
                        </div>
                    </td>
                    <!--begin::Checkbox-->
                    <td class="px-2 py-1 bg-gray-50">
                        <a href="{{ route('citizens.show', $citizen->id) }}"
                            class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                            {{ $citizen->id }}
                        </a>
                    </td>
                    <td class="px-2 py-1">
                        <a href="{{ route('citizens.show', $citizen->id) }}"
                            class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                            {{ $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname }}
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
        </table>
      </div>
    </div>
    <!-- Modal to add new record -->
    <div class="offcanvas offcanvas-end" id="add-new-record">
      <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"></button>
      </div>
      <div class="offcanvas-body flex-grow-1">
        <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
          <div class="col-sm-12">
            <label class="form-label" for="basicFullname">Full Name</label>
            <div class="input-group input-group-merge">
              <span id="basicFullname2" class="input-group-text"><i class="ti ti-user"></i></span>
              <input
                type="text"
                id="basicFullname"
                class="form-control dt-full-name"
                name="basicFullname"
                placeholder="John Doe"
                aria-label="John Doe"
                aria-describedby="basicFullname2" />
            </div>
          </div>
          <div class="col-sm-12">
            <label class="form-label" for="basicPost">Post</label>
            <div class="input-group input-group-merge">
              <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
              <input
                type="text"
                id="basicPost"
                name="basicPost"
                class="form-control dt-post"
                placeholder="Web Developer"
                aria-label="Web Developer"
                aria-describedby="basicPost2" />
            </div>
          </div>
          <div class="col-sm-12">
            <label class="form-label" for="basicEmail">Email</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="ti ti-mail"></i></span>
              <input
                type="text"
                id="basicEmail"
                name="basicEmail"
                class="form-control dt-email"
                placeholder="john.doe@example.com"
                aria-label="john.doe@example.com" />
            </div>
            <div class="form-text">You can use letters, numbers & periods</div>
          </div>
          <div class="col-sm-12">
            <label class="form-label" for="basicDate">Joining Date</label>
            <div class="input-group input-group-merge">
              <span id="basicDate2" class="input-group-text"><i class="ti ti-calendar"></i></span>
              <input
                type="text"
                class="form-control dt-date"
                id="basicDate"
                name="basicDate"
                aria-describedby="basicDate2"
                placeholder="MM/DD/YYYY"
                aria-label="MM/DD/YYYY" />
            </div>
          </div>
          <div class="col-sm-12">
            <label class="form-label" for="basicSalary">Salary</label>
            <div class="input-group input-group-merge">
              <span id="basicSalary2" class="input-group-text"><i class="ti ti-currency-dollar"></i></span>
              <input
                type="number"
                id="basicSalary"
                name="basicSalary"
                class="form-control dt-salary"
                placeholder="12000"
                aria-label="12000"
                aria-describedby="basicSalary2" />
            </div>
          </div>
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!--/ DataTable with Buttons -->


  </div>



@endsection