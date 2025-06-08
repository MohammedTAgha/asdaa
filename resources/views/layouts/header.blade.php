<!--begin::Header-->
<div id="kt_header" style="" class="header align-items-stretch">
	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		<!--begin::Aside mobile toggle-->
		<div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
			<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
				id="kt_aside_mobile_toggle">
				<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
				<span class="svg-icon svg-icon-2x mt-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
						viewBox="0 0 24 24" fill="none">
						<path
							d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
							fill="black" />
						<path opacity="0.3"
							d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
							fill="black" />
					</svg>
				</span>
				<!--end::Svg Icon-->
			</div>
		</div>
		<!--end::Aside mobile toggle-->
		<!--begin::Mobile logo-->
		<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<a href="{{ route('home') }}" class="d-lg-none">
				<img alt="Logo" src="{{ asset('assets/media/logos/logo-2.svg') }}" class="h-30px" />
			</a>
		</div>
		<!--end::Mobile logo-->
		<!--begin::Wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
			<!--begin::Navbar-->
			<div class="d-flex align-items-stretch" id="kt_header_nav">
				<!--begin::Menu wrapper-->
				<div class="header-menu align-items-stretch" data-kt-drawer="true"
					data-kt-drawer-name="header-menu"
					data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
					data-kt-drawer-width="{default:'200px', '300px': '250px'}"
					data-kt-drawer-direction="end"
					data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
					data-kt-swapper-mode="prepend"
					data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
					<!--begin::Menu-->
					<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
						id="#kt_header_menu" data-kt-menu="true">
						<!--begin:Menu item-->
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="{{ route('citizens.index') }}">
								<span class="menu-icon">
									<i class="fas fa-users fs-2"></i>
								</span>
								<span class="menu-title">المواطنين</span>
							</a>
						</div>
						<!--end:Menu item-->

						<!--begin:Menu item-->
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="{{ route('categories.index') }}">
								<span class="menu-icon">
									<i class="fas fa-layer-group fs-2"></i>
								</span>
								<span class="menu-title">الفئات</span>
							</a>
						</div>
						<!--end:Menu item-->

						<!--begin:Menu item-->
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="{{ route('distributions.index') }}">
								<span class="menu-icon">
									<i class="fas fa-box fs-2"></i>
								</span>
								<span class="menu-title">التوزيعات</span>
							</a>
						</div>
						<!--end:Menu item-->

						<!--begin:Menu item-->
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="{{ route('regions.index') }}">
								<span class="menu-icon">
									<i class="fas fa-map-marker-alt fs-2"></i>
								</span>
								<span class="menu-title">المناطق</span>
							</a>
						</div>
						<!--end:Menu item-->

						<!--begin:Menu item-->
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="{{ route('records.home') }}">
								<span class="menu-icon">
									<i class="fas fa-file-alt fs-2"></i>
								</span>
								<span class="menu-title">السجلات</span>
							</a>
						</div>
						<!--end:Menu item-->
					</div>
					<!--end::Menu-->
				</div>
				<!--end::Menu wrapper-->
			</div>
			<!--end::Navbar-->
			<!--begin::Topbar-->
			<div class="d-flex align-items-stretch flex-shrink-0">
				<!--begin::Toolbar wrapper-->
				<div class="d-flex align-items-stretch flex-shrink-0">
					<!--begin::Quick Actions-->
					<div class="d-flex align-items-center ms-1 ms-lg-3">
						<!--begin::New Citizen-->
						<a href="{{ route('citizens.create') }}" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="إضافة مواطن جديد">
							<i class="fas fa-plus fs-2"></i>
						</a>
						<!--end::New Citizen-->

						<!--begin::Search Records-->
						<a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px me-2" data-bs-toggle="modal" data-bs-target="#recordsSearchModal" data-bs-placement="bottom" title="البحث في السجلات">
							<i class="fas fa-search fs-2"></i>
						</a>
						<!--end::Search Records-->

						<!--begin::Export Citizens-->
						<a href="{{ route('citizens.export') }}" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="تصدير المواطنين">
							<i class="fas fa-download fs-2"></i>
						</a>
						<!--end::Export Citizens-->
					</div>
					<!--end::Quick Actions-->

					<!--begin::Recent Categories Dropdown-->
					<div class="d-flex align-items-center ms-1 ms-lg-3">
						<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-bs-toggle="tooltip" data-bs-placement="bottom" title="الفئات الأخيرة">
							<i class="fas fa-layer-group fs-2"></i>
						</div>
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 w-275px" data-kt-menu="true">
							<div class="menu-item px-3">
								<div class="menu-content d-flex align-items-center px-3">
									<span class="fw-bold text-muted">الفئات الأخيرة</span>
								</div>
							</div>
							<div class="separator my-2"></div>
							@php
								$recentCategories = \App\Models\Category::latest()->take(5)->get();
							@endphp
							@foreach($recentCategories as $category)
							<div class="menu-item px-5">
								<a href="{{ route('categories.show', $category) }}" class="menu-link px-5">
									<span class="menu-icon">
										<i class="fas fa-tag fs-2"></i>
									</span>
									<span class="menu-title">{{ $category->name }}</span>
								</a>
							</div>
							@endforeach
						</div>
					</div>
					<!--end::Recent Categories Dropdown-->

					<!--begin::User-->
					<div class="d-flex align-items-center ms-1 ms-lg-3"
						id="kt_header_user_menu_toggle">
						<!--begin::Menu wrapper-->
						<div class="cursor-pointer symbol symbol-30px symbol-md-40px"
							data-kt-menu-trigger="click" data-kt-menu-attach="parent"
							data-kt-menu-placement="bottom-end">
							@php
								$imgPath = isset(auth()->user()->staff->image) ? auth()->user()->staff->image : 'asdaa.jpg';
							@endphp
							<img src="{{ asset('storage/' . $imgPath) }}" alt="user" />
						</div>
						<!--begin::Menu-->
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
							data-kt-menu="true">
							<!--begin::Menu item-->
							<div class="menu-item px-3">
								<div class="menu-content d-flex align-items-center px-3">
									<!--begin::Avatar-->
									<div class="symbol symbol-50px me-5">
										<img src="{{ asset('storage/' . $imgPath) }}" alt="user" />
									</div>
									<!--end::Avatar-->
									<!--begin::Username-->
									<div class="d-flex flex-column">
										<div class="fw-bolder d-flex align-items-center fs-5">
											{{ auth()->user()->staff->name ?? auth()->user()->name }}
											<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">{{ auth()->user()->role->name }}</span>
										</div>
										<a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
									</div>
									<!--end::Username-->
								</div>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<a href="{{ route('profile.edit') }}" class="menu-link px-5">
									<i class="fas fa-user fs-2 me-2"></i>
									الملف الشخصي
								</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<a class="menu-link px-5" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									<i class="fas fa-sign-out-alt fs-2 me-2"></i>
									تسجيل الخروج
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>
							<!--end::Menu item-->
						</div>
						<!--end::Menu-->
						<!--end::Menu wrapper-->
					</div>
					<!--end::User -->
					<!--begin::Heaeder menu toggle-->
					<div class="d-flex align-items-center d-lg-none ms-2 me-n3"
						title="Show header menu">
						<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
							id="kt_header_menu_mobile_toggle">
							<!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									viewBox="0 0 24 24" fill="none">
									<path
										d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z"
										fill="black" />
									<path opacity="0.3"
										d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z"
										fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
					</div>
					<!--end::Heaeder menu toggle-->
				</div>
				<!--end::Toolbar wrapper-->
			</div>
			<!--end::Topbar-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->
@include('components.records-search-modal')