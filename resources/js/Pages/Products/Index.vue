<template>
  <div v-if="hasAnyPermission(['products.index'])">
    <Head>
      <title>Products - Aplikasi Kasir</title>
    </Head>
    <!-- Tambahkan modal untuk menampilkan gambar -->
    <div
      class="modal fade"
      id="imageModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="imageModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <img :src="selectedImage" class="img-fluid" alt="Selected Image" />
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Products</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <Link href="/products"><i class="fa fa-list"></i></Link>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <p class="text-muted font-13 m-b-30">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                  </p>
                  <form @submit.prevent="handleSearch">
                    <div class="p-2 d-flex flex-wrap justify-content-between">
                      <div class="mb-3 mb-md-0">
                        <Link
                          href="/products/create"
                          v-if="hasAnyPermission(['products.create'])"
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
                        <th>Barcode</th>
                        <th>Title</th>
                        <th>Buy Price</th>
                        <th>Sell Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr
                        v-for="(product, index) in products.data"
                        :key="index"
                      >
                        <td>{{ index + 1 }}</td>
                        <td>
                          <Barcode
                            :value="product.barcode"
                            :format="'CODE39'"
                            :lineColor="'#000'"
                            :width="1"
                            :height="20"
                          />
                        </td>
                        <td>{{ product.title }}</td>
                        <td>Rp. {{ formatPrice(product.buy_price) }}</td>
                        <td>Rp. {{ formatPrice(product.sell_price) }}</td>
                        <td>{{ product.stock }}</td>
                        <td>
                          <Link
                            :href="`/products/${product.id}/edit`"
                            v-if="hasAnyPermission(['products.edit'])"
                            class="btn btn-sm btn-info me-2"
                            ><i
                              class="fa fa-pencil-square-o"
                              aria-hidden="true"
                            ></i>
                            Edit
                          </Link>
                          <button
                            @click.prevent="deleteData(`${product.id}`)"
                            v-if="hasAnyPermission(['products.delete'])"
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

import Barcode from "../../Layouts/Barcode.vue";

export default {
  //layout
  layout: LayoutApp,

  //register Link di component
  components: {
    Link,
    Head,
    Barcode,
  },

  //props
  props: {
    products: Object, // <- nama props yang dibuat di controller saat parsing data
  },

  //define Composition Api
  setup() {
    //define state search
    const search = ref("" || new URL(document.location).searchParams.get("q"));

    //define method search
    const handleSearch = () => {
      Inertia.get("/products", {
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
          Inertia.delete(`/products/${id}`);
        }
      });
    }

    return {
      search,
      deleteData,
      handleSearch,
    };
  },

  data() {
    return {
      // Menyimpan URL gambar yang akan ditampilkan dalam modal
      selectedImage: "",
    };
  },

  methods: {
    // Method untuk membuka modal dengan gambar yang dipilih
    openImageModal(imageUrl) {
      this.selectedImage = imageUrl;
      $("#imageModal").modal("show"); // Menampilkan modal
    },
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
