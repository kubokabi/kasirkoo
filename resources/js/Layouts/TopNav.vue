<template>
  <div class="top_nav">
    <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <nav class="nav navbar-nav">
        <ul class="navbar-right">
          <li class="nav-item dropdown open" style="padding-left: 15px">
            <a
              href="javascript:;"
              class="user-profile dropdown-toggle"
              aria-haspopup="true"
              id="navbarDropdown"
              data-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                class="c-avatar-img"
                :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}&amp;background=4e73df&amp;color=ffffff&amp;size=100`"
              />
            </a>
            <div
              class="dropdown-menu dropdown-usermenu pull-right"
              aria-labelledby="navbarDropdown"
            >
              <!-- <a class="dropdown-item" href="javascript:;"> Profile</a>
              <a class="dropdown-item" href="javascript:;">
                <span class="badge bg-red pull-right">50%</span>
                <span>Settings</span>
              </a>
              <a class="dropdown-item" href="javascript:;">Help</a> -->
              <Link class="dropdown-item" @click="confirmLogout"
                ><i class="fa fa-sign-out pull-right"></i> Log Out</Link
              >
            </div>
          </li>

          <!-- <li role="presentation" class="nav-item dropdown open">
            <a
              href="javascript:;"
              class="dropdown-toggle info-number"
              id="navbarDropdown1"
              data-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-green">6</span>
            </a>
            <ul
              class="dropdown-menu list-unstyled msg_list"
              role="menu"
              aria-labelledby="navbarDropdown1"
            >
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"
                    ><img src="images/img.jpg" alt="Profile Image"
                  /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie
                    makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"
                    ><img src="images/img.jpg" alt="Profile Image"
                  /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie
                    makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"
                    ><img src="images/img.jpg" alt="Profile Image"
                  /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie
                    makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="dropdown-item">
                  <span class="image"
                    ><img src="images/img.jpg" alt="Profile Image"
                  /></span>
                  <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                  </span>
                  <span class="message">
                    Film festivals used to be do-or-die moments for movie
                    makers. They were where...
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <div class="text-center">
                  <a class="dropdown-item">
                    <strong>See All Alerts</strong>
                    <i class="fa fa-angle-right"></i>
                  </a>
                </div>
              </li>
            </ul>
          </li> -->
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
//import Link
import { Link } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

export default {
  components: {
    Link,
  },
  methods: {
    // Tambahkan metode untuk menampilkan konfirmasi saat logout
    confirmLogout() {
      Swal.fire({
        title: "Konfirmasi",
        text: "Apakah Anda yakin ingin logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Logout",
      }).then((result) => {
        if (result.isConfirmed) {
          // Jika pengguna menekan tombol "Ya", lakukan logout
          this.logout();
        }
      });
    },
    // Tambahkan metode untuk logout
    logout() {
      this.$inertia.post("/logout");
    },
  },
};
</script>

<style>
</style>
