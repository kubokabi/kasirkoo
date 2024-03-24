<template>
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <ul class="nav side-menu">
        <li class="menu-item" v-if="hasAnyPermission(['dashboard.index'])" :class="{ 'active': $page.url.startsWith('/dashboard') }">
          <Link href="/dashboard">
            <i class="fa fa-tachometer"></i> Dashboard
          </Link>
        </li>
      </ul>
    </div>
    <div class="menu_section">
      <h3 v-if="hasAnyPermission(['categories.index']) || hasAnyPermission(['products.index'])">MASTER</h3>
      <ul class="nav side-menu">
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/categories') }" v-if="hasAnyPermission(['categories.index'])">
          <Link href="/categories" >
            <i class="fa fa-list"></i> Categories
          </Link>
        </li>
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/products') }" v-if="hasAnyPermission(['products.index'])">
          <Link href="/products" >
            <i class="fa fa-shopping-bag"></i> Products
          </Link>
        </li>
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/customers') }" v-if="hasAnyPermission(['customers.index'])">
          <Link href="/customers">
          <i class="fa fa-users"></i> Customers </Link>
        </li>
      </ul>
    </div>
    <div class="menu_section">
      <h3 v-if="hasAnyPermission(['transactions.index'])">Transactions</h3>
      <ul class="nav side-menu">
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/transactions') }" v-if="hasAnyPermission(['transactions.index'])">
          <Link href="/transactions">
            <i class="fa fa-shopping-cart"></i> Transactions
          </Link>
        </li>
      </ul>
    </div>
    <div class="menu_section">
      <h3 v-if="hasAnyPermission(['sales.index']) || hasAnyPermission(['profits.index'])">REPORTS</h3>
      <ul class="nav side-menu">
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/sales') }" v-if="hasAnyPermission(['sales.index'])">
          <Link href="/sales">
          <i class="fa fa-signal"></i> Report Sales </Link>
        </li>
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/profits') }" v-if="hasAnyPermission(['profits.index'])">
          <Link href="/profits">
            <i class="fa fa-line-chart"></i> Report Profits
          </Link>
        </li>
      </ul>
    </div>
    <div class="menu_section">
      <h3 v-if="hasAnyPermission(['roles.index']) || hasAnyPermission(['permissions.index']) || hasAnyPermission(['users.index'])">USERS MANAGEMENTS</h3>
      <ul class="nav side-menu">
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/roles') }" v-if="hasAnyPermission(['roles.index'])">
          <Link href="/roles">
          <i class="fa fa-shield"></i> Roles </Link>
        </li>
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/permissions') }" v-if="hasAnyPermission(['permissions.index'])">
          <Link href="/permissions">
            <i class="fa fa-lock"></i> Permissions
          </Link>
        </li>
        <li class="menu-item" :class="{ 'active': $page.url.startsWith('/users') }" v-if="hasAnyPermission(['users.index'])">
          <Link href="/users">
          <i class="fa fa-user"></i> Users </Link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
};
</script>

<style>
#sidebar-menu {
  overflow-x: auto; /* Menambahkan scroll horizontal */
  max-height: 79.5vh; /* Membatasi tinggi menu agar tidak lebih dari tinggi viewport */
}
/* Gaya untuk scroll bar */
#sidebar-menu::-webkit-scrollbar {
  width: 4px; /* Lebar scroll bar */
  height: 4px; /* Tinggi scroll bar (hanya untuk scroll vertical) */
}

/* Gaya untuk bagian pegangan scroll bar */
#sidebar-menu::-webkit-scrollbar-thumb {
  background-color: #1ABB9C; /* Warna pegangan scroll bar */
  border-radius: 4px; /* Bentuk bulatan pegangan */
}
</style>
