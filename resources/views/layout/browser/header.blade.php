<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
        </div><a class="navbar-brand" href="index.html">
            <div class="d-flex align-items-center py-3"><img class="me-2" src="/icon.png" alt="" width="20" /><span
                    class="font-sans-serif text-primary">E-Absensi</span></div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard_admin') ? 'active' : '' }}" href="/dashboard_admin">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><i class="fas fa-tachometer-alt"></i></span><span
                                class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                </li>
                <a class="nav-link dropdown-indicator" href="#email" role="button" data-bs-toggle="collapse"
                    aria-expanded="false" aria-controls="email">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                class="fab fa-trello"></span></span><span class="nav-link-text ps-1">Master
                            Data</span>
                    </div>
                </a>
                <ul class="nav collapse {{ request()->is(patterns: 'karyawan') || request()->is(patterns: 'departemen') ? 'show' : '' }}"
                    id="email">
                    <li class="nav-item"><a class="nav-link {{ request()->is(patterns: 'karyawan') ? 'active' : '' }}"
                            href="/karyawan">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Karyawan</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->is(patterns: 'departemen') ? 'active' : '' }}"
                            href="/departemen">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Departemen</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('monitoring') ? 'active' : '' }}" href="/monitoring">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><i class="fas fa-desktop"></i></span><span
                                class="nav-link-text ps-1">Monitoring</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('aprove_izin') ? 'active' : '' }}" href="/aprove_izin">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><i class="far fa-file-alt"></i></span><span
                                class="nav-link-text ps-1">Data Izin</span>
                        </div>
                    </a>
                </li>
                <a class="nav-link dropdown-indicator" href="#laporan" role="button" data-bs-toggle="collapse"
                    aria-expanded="false" aria-controls="laporan">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                class="far fa-folder-open"></span></span><span class="nav-link-text ps-1">Laporan</span>
                    </div>
                </a>
                <ul class="nav collapse {{ request()->is(patterns: 'laporan_presensi') || request()->is(patterns: 'rekap_presensi') ? 'show' : '' }}"
                    id="laporan">
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is(patterns: 'laporan_presensi') ? 'active' : '' }}"
                            href="/laporan_presensi">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Presensi</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is(patterns: 'rekap_presensi') ? 'active' : '' }}"
                            href="/rekap_presensi">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Rekap
                                    Presensi</span>
                            </div>
                        </a>
                    </li>

                </ul>
                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Setting</div>
                    <div class="col ps-0">
                        <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profil_perusahaan') ? 'active' : '' }}"
                        href="/profil_perusahaan">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><i class="fas fa-house-user"></i></span><span
                                class="nav-link-text ps-1">Profil</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user') ? 'active' : '' }}" href="/user">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><i class="fas fa-user-cog"></i></span><span
                                class="nav-link-text ps-1">User</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg" style="display: block;">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
        data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false"
        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="index.html">
        <div class="d-flex align-items-center"><img class="me-2" src="assets/img/icons/spot-illustrations/falcon.png"
                alt="" width="40" /><span class="font-sans-serif text-primary">falcon</span></div>
    </a>
    <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
        <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards">Dashboard</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
                    <div class="bg-white dark__bg-1000 rounded-3 py-2"><a class="dropdown-item link-600 fw-medium"
                            href="index.html">Default</a><a class="dropdown-item link-600 fw-medium"
                            href="dashboard/analytics.html">Analytics</a><a class="dropdown-item link-600 fw-medium"
                            href="dashboard/crm.html">CRM</a><a class="dropdown-item link-600 fw-medium"
                            href="dashboard/e-commerce.html">E
                            commerce</a><a class="dropdown-item link-600 fw-medium" href="dashboard/lms.html">LMS<span
                                class="badge rounded-pill ms-2 badge-subtle-success">New</span></a><a
                            class="dropdown-item link-600 fw-medium"
                            href="dashboard/project-management.html">Management</a><a
                            class="dropdown-item link-600 fw-medium" href="dashboard/saas.html">SaaS</a><a
                            class="dropdown-item link-600 fw-medium" href="dashboard/support-desk.html">Support
                            desk<span class="badge rounded-pill ms-2 badge-subtle-success">New</span></a></div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="apps">App</a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="apps">
                    <div class="card navbar-card-app shadow-none dark__bg-1000">
                        <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown"
                                src="assets/img/icons/spot-illustrations/authentication-corner.png" width="130"
                                alt="" />
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/calendar.html">Calendar</a><a
                                            class="nav-link py-1 link-600 fw-medium" href="app/chat.html">Chat</a><a
                                            class="nav-link py-1 link-600 fw-medium" href="app/kanban.html">Kanban</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Social</p><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/social/feed.html">Feed</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/social/activity-log.html">Activity log</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/social/notifications.html">Notifications</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/social/followers.html">Followers</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Support Desk</p><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/support-desk/table-view.html">Table view</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/support-desk/card-view.html">Card view</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/support-desk/contacts.html">Contacts</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/support-desk/contact-details.html">Contact
                                            details</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/support-desk/tickets-preview.html">Tickets
                                            preview</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/support-desk/quick-links.html">Quick links</a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">E-Learning</p><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-learning/course/course-list.html">Course list</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-learning/course/course-grid.html">Course grid</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-learning/course/course-details.html">Course
                                            details</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-learning/course/create-a-course.html">Create a
                                            course</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-learning/student-overview.html">Student
                                            overview</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-learning/trainer-profile.html">Trainer profile</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Events</p><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/events/create-an-event.html">Create an event</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/events/event-detail.html">Event detail</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/events/event-list.html">Event list</a>
                                        <p class="nav-link text-700 mb-0 fw-bold">Email</p><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/email/inbox.html">Inbox</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/email/email-detail.html">Email detail</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/email/compose.html">Compose</a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="nav flex-column">
                                        <p class="nav-link text-700 mb-0 fw-bold">E-Commerce</p><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/product/product-list.html">Product
                                            list</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/product/product-grid.html">Product
                                            grid</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/product/product-details.html">Product
                                            details</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/product/add-product.html">Add product</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/orders/order-list.html">Order list</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/orders/order-details.html">Order
                                            details</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/customers.html">Customers</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/customer-details.html">Customer
                                            details</a><a class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/shopping-cart.html">Shopping cart</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/checkout.html">Checkout</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/billing.html">Billing</a><a
                                            class="nav-link py-1 link-600 fw-medium"
                                            href="app/e-commerce/invoice.html">Invoice</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
        <li class="nav-item ps-2 pe-0">
            <div class="dropdown theme-control-dropdown"><a
                    class="nav-link d-flex align-items-center dropdown-toggle fa-icon-wait fs-9 pe-1 py-0" href="#"
                    role="button" id="themeSwitchDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><span class="fas fa-sun fs-7" data-fa-transform="shrink-2"
                        data-theme-dropdown-toggle-icon="light"></span><span class="fas fa-moon fs-7"
                        data-fa-transform="shrink-3" data-theme-dropdown-toggle-icon="dark"></span><span
                        class="fas fa-adjust fs-7" data-fa-transform="shrink-2"
                        data-theme-dropdown-toggle-icon="auto"></span></a>
                <div class="dropdown-menu dropdown-menu-end dropdown-caret border py-0 mt-3"
                    aria-labelledby="themeSwitchDropdown">
                    <div class="bg-white dark__bg-1000 rounded-2 py-2"><button
                            class="dropdown-item d-flex align-items-center gap-2" type="button" value="light"
                            data-theme-control="theme"><span class="fas fa-sun"></span>Light<span
                                class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button><button
                            class="dropdown-item d-flex align-items-center gap-2" type="button" value="dark"
                            data-theme-control="theme"><span class="fas fa-moon" data-fa-transform=""></span>Dark<span
                                class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button><button
                            class="dropdown-item d-flex align-items-center gap-2" type="button" value="auto"
                            data-theme-control="theme"><span class="fas fa-adjust" data-fa-transform=""></span>Auto<span
                                class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item d-none d-sm-block">
            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait"
                href="app/e-commerce/shopping-cart.html"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7"
                    style="font-size: 33px;"></span><span class="notification-indicator-number">1</span></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait"
                id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-bell"
                    data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg"
                aria-labelledby="navbarDropdownNotification">
                <div class="card card-notification shadow-none">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h6 class="card-header-title mb-0">Notifications</h6>
                            </div>
                            <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark
                                    all as read</a></div>
                        </div>
                    </div>
                    <div class="scrollbar-overlay" style="max-height:19rem">
                        <div class="list-group list-group-flush fw-normal fs-10">
                            <div class="list-group-title border-bottom">NEW</div>
                            <div class="list-group-item">
                                <a class="notification notification-flush notification-unread" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <img class="rounded-circle" src="assets/img/team/1-thumb.png" alt="" />
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>Emma Watson</strong> replied to your comment
                                            : "Hello world 😍"</p>
                                        <span class="notification-time"><span class="me-2" role="img"
                                                aria-label="Emoji">💬</span>Just now</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item">
                                <a class="notification notification-flush notification-unread" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <div class="avatar-name rounded-circle"><span>AB</span></div>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>Albert Brooks</strong> reacted to
                                            <strong>Mia Khalifa's</strong> status
                                        </p>
                                        <span class="notification-time"><span
                                                class="me-2 fab fa-gratipay text-danger"></span>9hr</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-title border-bottom">EARLIER</div>
                            <div class="list-group-item">
                                <a class="notification notification-flush" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                            <img class="rounded-circle" src="assets/img/icons/weather-sm.jpg" alt="" />
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1">The forecast today shows a low of 20&#8451; in
                                            California. See today's weather.</p>
                                        <span class="notification-time"><span class="me-2" role="img"
                                                aria-label="Emoji">🌤️</span>1d</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item">
                                <a class="border-bottom-0 notification-unread  notification notification-flush"
                                    href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                            <img class="rounded-circle" src="assets/img/logos/oxford.png" alt="" />
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>University of Oxford</strong> created an
                                            event : "Causal Inference Hilary 2019"</p>
                                        <span class="notification-time"><span class="me-2" role="img"
                                                aria-label="Emoji">✌️</span>1w</span>
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item">
                                <a class="border-bottom-0 notification notification-flush" href="#!">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                            <img class="rounded-circle" src="assets/img/team/10.jpg" alt="" />
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>James Cameron</strong> invited to join the
                                            group: United Nations International Children's Fund</p>
                                        <span class="notification-time"><span class="me-2" role="img"
                                                aria-label="Emoji">🙋‍</span>2d</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center border-top"><a class="card-link d-block"
                            href="app/social/notifications.html">View all</a></div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown px-1">
            <a class="nav-link fa-icon-wait nine-dots p-1" id="navbarDropdownMenu" role="button"
                data-hide-on-body-scroll="data-hide-on-body-scroll" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="43" viewBox="0 0 16 16"
                    fill="none">
                    <circle cx="2" cy="2" r="2" fill="#6C6E71"></circle>
                    <circle cx="2" cy="8" r="2" fill="#6C6E71"></circle>
                    <circle cx="2" cy="14" r="2" fill="#6C6E71"></circle>
                    <circle cx="8" cy="8" r="2" fill="#6C6E71"></circle>
                    <circle cx="8" cy="14" r="2" fill="#6C6E71"></circle>
                    <circle cx="14" cy="8" r="2" fill="#6C6E71"></circle>
                    <circle cx="14" cy="14" r="2" fill="#6C6E71"></circle>
                    <circle cx="8" cy="2" r="2" fill="#6C6E71"></circle>
                    <circle cx="14" cy="2" r="2" fill="#6C6E71"></circle>
                </svg></a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-caret-bg"
                aria-labelledby="navbarDropdownMenu">
                <div class="card shadow-none">
                    <div class="scrollbar-overlay nine-dots-dropdown">
                        <div class="card-body px-3">
                            <div class="row text-center gx-0 gy-0">
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="pages/user/profile.html" target="_blank">
                                        <div class="avatar avatar-2xl"> <img class="rounded-circle"
                                                src="assets/img/team/3.jpg" alt="" /></div>
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11">Account</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="https://themewagon.com/" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/themewagon.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                            Themewagon</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="https://mailbluster.com/" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/mailbluster.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                            Mailbluster</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/google.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Google
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/spotify.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Spotify
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/steam.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Steam
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/github-light.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Github
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/discord.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Discord
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/xbox.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">xbox</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/trello.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Kanban
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded" src="assets/img/nav-icons/hp.png"
                                            alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Hp</p>
                                    </a></div>
                                <div class="col-12">
                                    <hr class="my-3 mx-n3 bg-200" />
                                </div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/linkedin.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Linkedin
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/twitter.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Twitter
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/facebook.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Facebook
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/instagram.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                            Instagram</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/pinterest.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                            Pinterest</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/slack.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Slack
                                        </p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="#!" target="_blank"><img class="rounded"
                                            src="assets/img/nav-icons/deviantart.png" alt="" width="40" height="40" />
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                            Deviantart</p>
                                    </a></div>
                                <div class="col-4"><a
                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                        href="app/events/event-detail.html" target="_blank">
                                        <div class="avatar avatar-2xl">
                                            <div class="avatar-name rounded-circle bg-primary-subtle text-primary">
                                                <span class="fs-7">E</span>
                                            </div>
                                        </div>
                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11">Events</p>
                                    </a></div>
                                <div class="col-12"><a class="btn btn-outline-primary btn-sm mt-4" href="#!">Show
                                        more</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="assets/img/team/3-thumb.png" alt="" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="pages/user/settings.html">Settings</a>
                    <a class="dropdown-item" href="pages/authentication/card/logout.html">Logout</a>
                </div>
            </div>
        </li>
    </ul>
</nav>