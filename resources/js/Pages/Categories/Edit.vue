<template>
  <div v-if="hasAnyPermission(['categories.edit'])">
    <Head>
      <title>Edit Category</title>
    </Head>
    <!-- edit form  -->
    <div class="col-md-7 col-sm-7">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit Category</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <a><i class="fa fa-pencil-square-o"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form @submit.prevent="updateCategory">
            <label for="name">Name * :</label>
            <p>
              <input
                type="text"
                id="name"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                v-model="ktg.name"
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
                v-model="ktg.description"
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
            :src="ktg.imagePreview || '/images/' + ktg.image"
            alt="Image"
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

  //register Link di component
  components: {
    Link,
    Head,
  },

  //props
  props: {
    ktg: Object,
    errors: Object,
  },

  //define Composition Api
  setup(props) {
    //state categorys
    const ktg = reactive({
      name: props.ktg.name,
      description: props.ktg.description,
      image: props.ktg.image,
    });

    //function updatecategory
    function updateCategory() {
      // send category using Inertia.put()
      Inertia.post(`/categories/${props.ktg.id}`, {
        _method: "PUT",
        image: ktg.image,
        name: ktg.name,
        description: ktg.description,
      });
    }

    function handleImageChange(event) {
      ktg.image = event.target.files[0];

      // Membaca gambar untuk preview
      if (ktg.image) {
        const reader = new FileReader();
        reader.onload = (e) => {
          ktg.imagePreview = e.target.result;
        };
        reader.readAsDataURL(ktg.image);
      } else {
        ktg.imagePreview = null;
      }
    }

    return {
      ktg,
      updateCategory,
      handleImageChange,
    };
  },
};
</script>
