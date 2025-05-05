<!--begin::Aside-->
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true"
data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
<!--begin::Brand-->

<div class="aside-logo flex-column-auto" id="kt_aside_logo">
	<!--begin::Logo-->
	<span>
		<a href="{{ route('home') }}">
			<img src="{{ asset('assets/img/asdaa.jpg') }}" alt="Logo" class="h-30px" />
		</a>
		{{-- <span class="menu-title">اصداء</span> --}}
	</span>
	<!--end::Logo-->
	<!--begin::Aside toggler-->
	<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
		data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
		data-kt-toggle-name="aside-minimize">
		<!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
		<span class="svg-icon svg-icon-1 rotate-180">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
				fill="none">
				<path opacity="0.5"
					d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
					fill="black" />
				<path
					d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
					fill="black" />
			</svg>
		</span>
		<!--end::Svg Icon-->
	</div>
	<!--end::Aside toggler-->
</div>
<!--end::Brand-->
<!--begin::Aside menu **** -->
<div class="aside-menu flex-column-fluid">
	<!--begin::Aside Menu-->
	<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
		data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
		data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
		data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
		<!--begin::Menu-->
		<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
			id="#kt_aside_menu" data-kt-menu="true">
			<!-- Brand -->
			<!-- Home -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}"
					href="{{ route('home') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-smart-home"></i>
						</span>
					</span>
					<span class="menu-title">الرئيسية</span>
				</a>
			</div>
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('queries') ? 'active' : '' }}"
					href="{{ route('queries') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-search"></i>
						</span>
					</span>
					<span class="menu-title">الاستعلامات</span>
				</a>
			</div>

			<!-- Records Search -->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('records.*') ? 'here show' : '' }}">
				<span class="menu-link">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-search"></i>
						</span>
					</span>
					<span class="menu-title">البحث في السجل المدني</span>
					<span class="menu-arrow"></span>
				</span>
				<div class="menu-sub menu-sub-accordion">
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('records.search') ? 'active' : '' }}" href="{{ route('records.search') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">بحث عام</span>
						</a>
					</div>
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('search.by.ids.form') ? 'active' : '' }}" href="{{ route('search.by.ids.form') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">بحث بالهوية</span>
						</a>
					</div>
				</div>
			</div>

			<!-- Citizens -->
			<div data-kt-menu-trigger="click"
				class="menu-item menu-accordion {{ request()->routeIs('citizens.*') ? 'here show' : '' }}">
				<span class="menu-link">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-users"></i>
						</span>
					</span>
					<span class="menu-title">النازحين</span>
					<span class="menu-arrow"></span>
				</span>
				<div class="menu-sub menu-sub-accordion">
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('citizens.index') ? 'active' : '' }}"
							href="{{ route('citizens.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">عرض الكل</span>
						</a>
					</div>
					<div class="menu-item">
						
						<a class="menu-link {{ request()->routeIs('citizens.create') ? 'active' : '' }}"
							href="{{ route('citizens.create') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">اضافة جديد</span>
						</a>
						
					</div>
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('citizens.import') ? 'active' : '' }}"
							href="{{ route('citizens.import') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">رفع كشف</span>
						</a>
					</div>

					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('actions') ? 'active' : '' }}"
							href="{{ route('actions') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">رفع كشف</span>
						</a>
					</div>
				</div>
			</div>

						<!-- Citizens -->
						<div data-kt-menu-trigger="click"
						class="menu-item menu-accordion {{ request()->routeIs('distributions.*') ? 'here show' : '' }}">
						<span class="menu-link">
							<span class="menu-icon">
								<i class="icon-xl fas fa-dice-d6"></i>
							</span>
							<span class="menu-title">المشاريع</span>
							<span class="menu-arrow"></span>
						</span>
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link {{ request()->routeIs('distributions.index') ? 'active' : '' }}"
									href="{{ route('distributions.index') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">عرض المشاريع</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link {{ request()->routeIs('distributions.create') ? 'active' : '' }}"
									href="{{ route('distributions.create') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">اضافة جديد</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link {{ request()->routeIs('upload.citizens') ? 'active' : '' }}"
									href="{{ route('upload.citizens') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">مستفيدين Excel</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link {{ request()->routeIs('distributions.exportDistributionStatistics') ? 'active' : '' }}"
									href="{{ route('distributions.exportDistributionStatistics') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title"> نصدير المشاريع</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link {{ request()->routeIs('reports.showStatistics') ? 'active' : '' }}"
									href="{{ route('reports.showStatistics') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">تقارير المشاريع</span>
								</a>
							</div>

							<div class="menu-item">
								<a class="menu-link {{ request()->routeIs('citizens.exportWithDistributions') ? 'active' : '' }}"
									href="{{ route('citizens.exportWithDistributions') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title"> المواطنين  مع المساعدات</span>
								</a>
							</div>
						</div>
					</div>
		
			<!-- Distributions -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('distributions.index') ? 'active' : '' }}"
					href="{{ route('distributions.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-list"></i>
						</span>
					</span>
					<span class="menu-title">كل الكشوفات</span>
				</a>
			</div>

			<!-- Representatives -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('representatives.index') ? 'active' : '' }}"
					href="{{ route('representatives.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-man"></i>
						</span>
					</span>
					<span class="menu-title">المناديب</span>
				</a>
			</div>

			<!-- Regions -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('regions.index') ? 'active' : '' }}"
					href="{{ route('regions.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-map"></i>
						</span>
					</span>
					<span class="menu-title">المناطق</span>
				</a>
			</div>
			<!-- big Regions -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('big-regions.index') ? 'active' : '' }}"
					href="{{ route('big-regions.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-map"></i>
						</span>
					</span>
					<span class="menu-title">المناطق الكبرى</span>
				</a>
			</div>
			<!-- Staff -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('staff.index') ? 'active' : '' }}"
					href="{{ route('staff.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-users"></i>
						</span>
					</span>
					<span class="menu-title">الاعضاء</span>
				</a>
			</div>

			<!-- Committees -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('committees.index') ? 'active' : '' }}"
					href="{{ route('committees.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-flag-3"></i>
						</span>
					</span>
					<span class="menu-title">اللجان</span>
				</a>
			</div>

			<!-- Users -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
					href="{{ route('users.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-users"></i>
						</span>
					</span>
					<span class="menu-title">المستخدمين</span>
				</a>
			</div>

			<!-- Files -->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('files.index') ? 'active' : '' }}"
					href="{{ route('files.index') }}">
					<span class="menu-icon">
						<span class="svg-icon svg-icon-2">
							<i class="ti ti-folder-plus"></i>
						</span>
					</span>
					<span class="menu-title">مدير الملفات</span>
				</a>
			</div>

		</div>
		<!--end::Menu-->
	</div>
	<!--end::Aside Menu-->
</div>
<!--end::Aside menu-->


</div>
<!--end::Aside-->