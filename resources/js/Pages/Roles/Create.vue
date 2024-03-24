<template>
  <Head>
    <title>Create Roles - Aplikasi Kasir</title>
  </Head>
  <div class="row">
    <!-- input form  -->
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Roles</h2>
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
            <div class="mb-3">
              <label class="fw-bold">Role Name</label>
              <input
                class="form-control"
                v-model="form.name"
                :class="{ 'is-invalid': errors.name }"
                type="text"
                placeholder="Role Name"
              />

              <div v-if="errors.name" class="alert alert-danger">
                {{ errors.name }}
              </div>
            </div>

            <hr />
            <div class="mb-3">
              <label class="fw-bold">Permissions</label>
              <br />
              <div
                class="form-check form-check-inline"
                v-for="(permission, index) in permissions"
                :key="index"
              >
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="form.permissions"
                  :value="permission.name"
                  :id="`check-${permission.id}`"
                />
                <label
                  class="form-check-label"
                  :for="`check-${permission.id}`"
                  >{{ permission.name }}</label
                >
              </div>
            </div>

            <div class="d-flex justify-content-between">
              <button
                class="btn btn-success btn-md shadow-sm me-2"
                type="submit"
              >
                Save
              </button>
              <Link href="/roles" class="btn btn-secondary btn-md shadow-sm"
                >Cancel</Link
              >
            </div>
          </form>
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
import Swal from "sweetalert2";

export default {
  //layout
  layout: LayoutApp,

  //props
  props: {
    errors: Object,
    permissions: Array,
  },

  //register Link di component
  components: {
    Link,
    Head,
  },

  //composition API
  setup() {
    //define form with reactive
    const form = reactive({
      name: "",
      permissions: [],
    });

    //method "submit"
    const submit = () => {
      //send data to server
      Inertia.post(
        "/roles",
        {
          //data
          name: form.name,
          permissions: form.permissions,
        },
        {
          onSuccess: () => {
            //show success alert
            Swal.fire({
              title: "Success!",
              text: "Role saved successfully.",
              icon: "success",
              showConfirmButton: false,
              timer: 2000,
            });
          },
        }
      );
    };

    return {
      form,
      submit,
    };
  },
};
</script>