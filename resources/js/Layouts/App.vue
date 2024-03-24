<template>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0">
                        <a href="/" class="site_title"
                            ><i class="fa fa-btc"></i>
                            <span>Point Of Sales</span></a
                        >
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img
                                src="https://cdn-icons-png.flaticon.com/128/10467/10467123.png"
                                alt="..."
                                class="img-circle profile_img"
                            />
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ $page.props.auth.user.name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <Sidebar />
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <TopNav />
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <slot />
            </div>

            <!-- /page content -->

            <!-- footer content -->
            <Footer />
            <!-- /footer content -->
        </div>
    </div>
</template>

<style>
.right_col {
    overflow: hidden; /* Hindari tampilan scrollbar saat konten masih dalam batas tinggi */
    max-height: 85vh;
    overflow-y: auto;
    padding: 3px;
}

/* Gaya untuk scrollbar */
.right_col::-webkit-scrollbar {
    width: 4px; /* Lebar scrollbar */
}

.right_col::-webkit-scrollbar-thumb {
    background-color: #1ABB9C; /* Warna latar belakang thumb scrollbar */
    border-radius: 4px; /* Membuat sudut thumb scrollbar sedikit melengkung */
}
</style>

<script>
import Sidebar from "../Layouts/Sidebar.vue";
import TopNav from "../Layouts/TopNav.vue";
import Footer from "../Layouts/Footer.vue";

//import Link dari inertia
import { Link } from "@inertiajs/inertia-vue3";
import $ from "jquery";

export default {
    //register Link di component
    components: {
        Link,
        Sidebar,
        TopNav,
        Footer,
    },
    mounted() {
        // Fungsi ini akan dijalankan setelah komponen atau halaman selesai dimuat

        // Menangani dropdown pada elemen dengan kelas menu-item
        $(".menu-item > a").on("click", function () {
            // Menghapus kelas active dari semua elemen dengan kelas menu-item
            $(".menu-item").removeClass("active");

            // Menambahkan kelas active pada elemen yang diklik
            $(this).parent(".menu-item").addClass("active");

            // Jika terdapat submenu, kita dapat menampilkan atau menyembunyikannya
            $(this).next(".child_menu").slideToggle();
        });

        // Menangani tombol toggle menu
        $("#menu_toggle").on("click", function () {
            // Toggle class nav-md dan nav-sm pada elemen body
            $("body").toggleClass("nav-md nav-sm");

            // Jika terdapat submenu, kita dapat menampilkan atau menyembunyikannya
            $(this).next(".child_menu").slideToggle();
        });
    },
};
</script>
