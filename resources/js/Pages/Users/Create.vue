<template>
  <div v-if="hasAnyPermission(['users.create'])">
    <Head>
      <title>Create Users - Aplikasi Kasir</title>
    </Head>
    <div class="row">
      <!-- input form  -->
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Users</h2>
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
                    <label class="fw-bold">Email Address</label>
                    <input
                      class="form-control"
                      v-model="form.email"
                      :class="{ 'is-invalid': errors.email }"
                      type="email"
                      placeholder="Email Address"
                    />
                  </div>
                  <div v-if="errors.email" class="alert alert-danger">
                    {{ errors.email }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Password</label>
                    <input
                      class="form-control"
                      v-model="form.password"
                      :class="{ 'is-invalid': errors.password }"
                      type="password"
                      placeholder="Password"
                    />
                  </div>
                  <div v-if="errors.password" class="alert alert-danger">
                    {{ errors.password }}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="fw-bold">Password Confirmation</label>
                    <input
                      class="form-control"
                      v-model="form.password_confirmation"
                      type="password"
                      placeholder="Password Confirmation"
                    />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="fw-bold">Roles</label>
                    <br />
                    <div
                      class="form-check form-check-inline"
                      v-for="(role, index) in roles"
                      :key="index"
                    >
                      <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="form.roles"
                        :value="role.name"
                        :id="`check-${role.id}`"
                      />
                      <label
                        class="form-check-label"
                        :for="`check-${role.id}`"
                        >{{ role.name }}</label
                      >
                    </div>
                  </div>
                  <div v-if="errors.roles" class="alert alert-danger">
                    {{ errors.roles }}
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-between">
                <button
                  class="btn btn-success btn-md shadow-sm me-2"
                  type="submit"
                >
                  Save
                </button>
                <Link href="/users" class="btn btn-secondary btn-md shadow-sm"
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
    roles: Array,
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
      email: "",
      password: "",
      password_confirmation: "",
      roles: [],
    });

    //method "submit"
    const submit = () => {
      //send data to server
      Inertia.post(
        "/users",
        {
          //data
          name: form.name,
          email: form.email,
          password: form.password,
          password_confirmation: form.password_confirmation,
          roles: form.roles,
        },
        {
          onSuccess: () => {
            //show success alert
            Swal.fire({
              title: "Success!",
              text: "User saved successfully.",
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
