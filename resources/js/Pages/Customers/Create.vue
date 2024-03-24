<template>
  <div v-if="hasAnyPermission(['customers.create'])">
    <Head>
      <title>Create Customers - Aplikasi Kasir</title>
    </Head>
    <div class="row">
      <!-- input form  -->
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Customers</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link"><i class="fa fa-plus"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form @submit.prevent="submit">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Full Name</label>
                    <input
                      class="form-control"
                      v-model="form.name"
                      :class="{ 'is-invalid': errors.name }"
                      type="text"
                      placeholder="Full Name"
                    />
                  </div>
                  <div v-if="errors.name" class="alert alert-danger">
                    {{ errors.name }}
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Phone Number</label>
                    <div class="input-group mb-3">
                      <input
                        class="form-control"
                        v-model="form.no_telp"
                        :class="{ 'is-invalid': errors.no_telp }"
                        type="number"
                        placeholder="Maximum 15 numbers"
                        @input="checkPhoneNumberLength"
                      />
                    </div>
                  </div>
                  <div v-if="errors.no_telp" class="alert alert-danger">
                    {{ errors.no_telp }}
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="fw-bold">Address</label>
                <textarea
                  class="form-control"
                  v-model="form.address"
                  :class="{ 'is-invalid': errors.address }"
                  type="text"
                  rows="4"
                  placeholder="Address"
                ></textarea>
              </div>
              <div v-if="errors.address" class="alert alert-danger">
                {{ errors.address }}
              </div>
              <div class="ln_solid"></div>

              <div class="d-flex justify-content-between">
                <button
                  type="submit"
                  class="btn btn-success btn-md shadow-sm me-2"
                >
                  Save
                </button>
                <Link
                  href="/customers"
                  class="btn btn-secondary btn-md shadow-sm"
                  >Cancel</Link
                >
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- end row  -->
    </div>
  </div>
</template>

<script>
import { Link, Head } from "@inertiajs/inertia-vue3";

//import layout
import LayoutApp from "../../Layouts/App.vue";

import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";

export default {
  //layout
  layout: LayoutApp,

  //props
  props: {
    errors: Object,
  },

  //register Link di component
  components: {
    Link,
    Head,
  },

  data() {
    return {
      form: {
        no_telp: "", // Inisialisasi nomor telepon
      },
      errors: {}, // Inisialisasi objek errors
    };
  },
  methods: {
    checkPhoneNumberLength() {
      // Memeriksa panjang nomor telepon
      if (this.form.no_telp && this.form.no_telp.toString().length > 15) {
        // Menampilkan pesan peringatan menggunakan SweetAlert
        Swal.fire({
          icon: "warning",
          title: "Oops...",
          text: "Max length for phone number is 15 characters!",
        });
        // Mengosongkan nomor telepon jika melebihi 15 karakter
        this.form.no_telp = "";
      }
    },
  },

  //define Composition Api
  setup() {
    //state forms
    const form = reactive({
      name: "",
      no_telp: "",
      address: "",
    });

    function submit() {
      // Menggunakan FormData untuk mengirim file gambar
      let name = form.name;
      let no_telp = form.no_telp;
      let address = form.address;

      Inertia.post("/customers/", {
        name: name,
        no_telp: no_telp,
        address: address,
      });
    }
    return {
      form,
      submit,
    };
  },
};
</script>
