<template>
  <div v-if="hasAnyPermission(['customers.index'])">
    <Head>
      <title>Customers - Aplikasi Kasir</title>
    </Head>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Customers</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <Link href="/customers"><i class="fa fa-users"></i></Link>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <p class="text-muted font-13 m-b-30">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </p>
                  <form @submit.prevent="handleSearch">
                    <div class="p-2 d-flex flex-wrap justify-content-between">
                      <div class="mb-3 mb-md-0">
                        <Link
                          href="/customers/create"
                          v-if="hasAnyPermission(['customers.create'])"
                          class="btn btn-sm btn-success"
                        >
                          <i class="fa fa-plus me-2"></i> NEW
                        </Link>
                      </div>
                      <div
                        class="col-md-5 col-sm-5 form-group pull-right top_search"
                      >
                        <div class="input-group">
                          <input
                            type="text"
                            v-model="search"
                            class="form-control"
                            placeholder="Search by name"
                          />
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                              <i class="fa fa-search"></i>
                            </button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </form>
                  <table
                    id="datatable"
                    class="table table-striped table-bordered"
                    style="width: 100%"
                  >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>No. Telp</th>
                        <th>Address</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      <!-- <tr v-for="(customer, index) in customers" :key="customer.id"> -->
                      <tr
                        v-for="(customer, index) in customers.data"
                        :key="index"
                      >
                        <td>{{ index + 1 }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.no_telp }}</td>
                        <td>{{ customer.address }}</td>
                        <td>
                          <Link
                            :href="`/customers/${customer.id}/edit`"
                            v-if="hasAnyPermission(['customers.edit'])"
                            class="btn btn-sm btn-info me-2"
                            ><i
                              class="fa fa-pencil-square-o"
                              aria-hidden="true"
                            ></i>
                            Edit
                          </Link>
                          <button
                            @click.prevent="deleteData(`${customer.id}`)"
                            v-if="hasAnyPermission(['customers.delete'])"
                            class="btn btn-sm btn-danger"
                          >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    F
  </div>
</template>

<script>
//import layout
import LayoutApp from "../../Layouts/App.vue";

import Swal from "sweetalert2";

//import ref from vue
import { ref } from "vue";

//import Link dari inertia
import { Link, Head } from "@inertiajs/inertia-vue3";

import { Inertia } from "@inertiajs/inertia";

export default {
  //layout
  layout: LayoutApp,

  //register Link di component
  components: {
    Link,
    Head,
  },

  //props
  props: {
    customers: Object, // <- nama props yang dibuat di controller saat parsing data
  },

  //define Composition Api
  setup() {
    //define state search
    const search = ref("" || new URL(document.location).searchParams.get("q"));

    //define method search
    const handleSearch = () => {
      Inertia.get("/customers", {
        //send params "q" with value from state "search"
        q: search.value,
      });
    };

    //method deletePost
    function deleteData(id) {
      // Tampilkan konfirmasi SweetAlert2 sebelum menghapus data
      Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data akan dihapus permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
      }).then((result) => {
        if (result.isConfirmed) {
          // Jika pengguna menekan tombol "Ya", maka hapus data
          Inertia.delete(`/customers/${id}`);
        }
      });
    }

    return {
      search,
      deleteData,
      handleSearch,
    };
  },

  mounted() {
    // Periksa apakah ada pesan Flash
    if (this.$page.props.flash.message) {
      // Tampilkan SweetAlert
      this.showSuccessAlert(this.$page.props.flash.message);
    }
  },
  methods: {
    showSuccessAlert(message) {
      Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
        showConfirmButton: false,
        timer: 2000,
      });
    },
  },
};
</script>

<style></style>
