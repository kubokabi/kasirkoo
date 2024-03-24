<template>
  <div v-if="hasAnyPermission(['products.create'])">
    <Head>
      <title>Create Products - Aplikasi Kasir</title>
    </Head>
    <div class="row">
      <!-- input form  -->
      <div class="col-md-12 col-sm-12">
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
            <form @submit.prevent="storeProducts">
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

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Barcode</label>
                    <input
                      class="form-control"
                      v-model="form.barcode"
                      :class="{ 'is-invalid': errors.barcode }"
                      type="text"
                      placeholder="Barcode / Code Product"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Category</label>
                    <select
                      class="form-control"
                      :class="{ 'is-invalid': errors.category_id }"
                      v-model="form.category_id"
                    >
                      <option value="" disabled selected>
                        Choose Category
                      </option>
                      <option
                        v-for="(category, index) in categories"
                        :key="index"
                        :value="category.id"
                      >
                        {{ category.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Title Product</label>
                    <input
                      class="form-control"
                      v-model="form.title"
                      :class="{ 'is-invalid': errors.title }"
                      type="text"
                      placeholder="Title Product"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Stock</label>
                    <input
                      class="form-control"
                      v-model="form.stock"
                      :class="{ 'is-invalid': errors.stock }"
                      type="number"
                      placeholder="Stock"
                    />
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="fw-bold">Description</label>
                <textarea
                  class="form-control"
                  v-model="form.description"
                  :class="{ 'is-invalid': errors.description }"
                  type="text"
                  rows="4"
                  placeholder="Description"
                ></textarea>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Buy Price</label>
                    <input
                      class="form-control"
                      v-model="form.buy_price"
                      :class="{ 'is-invalid': errors.buy_price }"
                      type="number"
                      placeholder="Buy Price"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Sell Price</label>
                    <input
                      class="form-control"
                      v-model="form.sell_price"
                      :class="{ 'is-invalid': errors.sell_price }"
                      type="number"
                      placeholder="Sell Price"
                    />
                  </div>
                </div>
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
                  href="/products"
                  class="btn btn-secondary btn-md shadow-sm"
                  >Cancel</Link
                >
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- image preview  -->
      <div class="col-md-12 col-sm-12">
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
    categories: Array,
  },

  //register Link di component
  components: {
    Link,
    Head,
  },

  //define Composition Api
  setup() {
    //define form with reactive
    const form = reactive({
      image: "",
      barcode: "",
      category_id: "",
      title: "",
      description: "",
      buy_price: "",
      sell_price: "",
      stock: "",
    });

    //function storeKategori
    function storeProducts() {
      //send data to server
      Inertia.post(
        "/products",
        {
          //data
          image: form.image,
          barcode: form.barcode,
          category_id: form.category_id,
          title: form.title,
          description: form.description,
          buy_price: form.buy_price,
          sell_price: form.sell_price,
          stock: form.stock,
        },
        {
          onSuccess: () => {
            //show success alert
            Swal.fire({
              title: "Success!",
              text: "Product saved successfully.",
              icon: "success",
              showConfirmButton: false,
              timer: 2000,
            });
          },
        }
      );
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
      storeProducts,
      handleImageChange,
    };
  },
};
</script>
