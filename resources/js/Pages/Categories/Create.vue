<template>
  <div class="row" v-if="hasAnyPermission(['categories.create'])">
    <Head>
      <title>Create Categories - Aplikasi Kasir</title>
    </Head>
    <!-- input form  -->
    <div class="col-md-7 col-sm-7">
      <div class="x_panel">
        <div class="x_title">
          <h2>Category</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <a class="collapse-link"><i class="fa fa-plus"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form @submit.prevent="storeKategori">
            <label for="name">Name * :</label>
            <p>
              <input
                type="text"
                id="name"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                v-model="form.name"
                placeholder="Enter a category name"
              />
            </p>
            <div v-if="errors.name" class="alert alert-danger">
              {{ errors.name }}
            </div>

            <label for="Description">Description * :</label>
            <p>
              <textarea
                type="text"
                id="Description"
                class="form-control"
                :class="{ 'is-invalid': errors.description }"
                data-parsley-trigger="change"
                rows="5"
                v-model="form.description"
                placeholder="Enter a category description"
              />
            </p>
            <div v-if="errors.description" class="alert alert-danger">
              {{ errors.description }}
            </div>

            <label for="heard">Picture *:</label>
            <div class="input-group">
              <div class="custom-file">
                <input
                  class="custom-file-input hidden"
                  @change="handleImageChange"
                  :class="{ 'is-invalid': errors.image }"
                  type="file"
                  id="inputGroupFile"
                />
                <label class="custom-file-label" for="inputGroupFile"
                  >Select an image</label
                >
              </div>
            </div>
            <div v-if="errors.image" class="alert alert-danger">
              {{ errors.image }}
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
                href="/categories"
                class="btn btn-secondary btn-md shadow-sm"
                >Cancel</Link
              >
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- image preview  -->
    <div class="col-md-5 col-sm-5">
      <div class="x_panel">
        <div class="x_title">
          <h6>Image Preview</h6>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <img
            v-if="form.imagePreview"
            :src="form.imagePreview"
            alt="Preview"
            class="mt-2 img-thumbnail"
            style="max-width: 100%; max-height: cover"
          />
        </div>
      </div>
    </div>
    <!-- end row  -->
  </div>
</template>

<script>
import { Link, Head } from "@inertiajs/inertia-vue3";

//import layout
import LayoutApp from "../../Layouts/App.vue";

import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

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

  //define Composition Api
  setup() {
    //state forms
    const form = reactive({
      image: "",
      name: "",
      description: "",
    });

    //function storeKategori
    function storeKategori() {
      // Menggunakan FormData untuk mengirim file gambar
      let image = form.image;
      let name = form.name;
      let description = form.description;

      // Menggunakan Content-Type 'multipart/form-data'
      Inertia.post("/categories/", {
        image: image,
        name: name,
        description: description,
      });
    }

    function handleImageChange(event) {
      form.image = event.target.files[0];

      // Membaca gambar untuk preview
      if (form.image) {
        const reader = new FileReader();
        reader.onload = (e) => {
          form.imagePreview = e.target.result;
        };
        reader.readAsDataURL(form.image);
      } else {
        form.imagePreview = null;
      }
    }

    return {
      form,
      storeKategori,
      handleImageChange,
    };
  },
};
</script>
