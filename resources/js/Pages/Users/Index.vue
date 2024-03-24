<template>
  <div v-if="hasAnyPermission(['users.index'])">
    <Head>
      <title>Users - Aplikasi Kasir</title>
    </Head>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Users</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <Link href="/users"><i class="fa fa-shield"></i></Link>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <form @submit.prevent="handleSearch">
                    <div class="p-2 d-flex flex-wrap justify-content-between">
                      <div class="mb-3 mb-md-0">
                        <Link
                          href="/users/create"
                          v-if="hasAnyPermission(['users.create'])"
                          class="btn btn-sm btn-success"
                        >
                          <i class="fa fa-plus me-2"></i> NEW</Link
                        >
                      </div>
                      <div
                        class="col-md-5 col-sm-5 form-group pull-right top_search"
                      >
                        <div class="input-group">
                          <input
                            type="text"
                            v-model="search"
                            class="form-control"
                            placeholder="Search by role name"
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
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Roles</th>
                        <th scope="col" style="width: 20%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(user, index) in users.data" :key="index">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                          <span
                            v-for="(role, index) in user.roles"
                            :key="index"
                            class="badge badge-warning text-uppercase shadow border-0 ms-2 mb-2"
                          >
                            {{ role.name }}
                          </span>
                        </td>
                        <td class="text-center">
                          <Link
                            :href="`/users/${user.id}/edit`"
                            v-if="hasAnyPermission(['users.edit'])"
                            class="btn btn-sm btn-info me-2"
                            ><i
                              class="fa fa-pencil-square-o"
                              aria-hidden="true"
                            ></i>
                            Edit</Link
                          >
                          <button
                            @click.prevent="destroy(user.id)"
                            v-if="hasAnyPermission(['users.delete'])"
                            class="btn btn-danger btn-sm"
                          >
                            <i class="fa fa-trash"></i> Delete
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
    users: Object, // <- nama props yang dibuat di controller saat parsing data
  },

  setup() {
    //define state search
    const search = ref("" || new URL(document.location).searchParams.get("q"));

    //define method search
    const handleSearch = () => {
      Inertia.get("/users", {
        //send params "q" with value from state "search"
        q: search.value,
      });
    };

    //method destroy
    const destroy = (id) => {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(`/users/${id}`);

          Swal.fire({
            title: "Deleted!",
            text: "User deleted successfully.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          });
        }
      });
    };

    //return
    return {
      search,
      handleSearch,
      destroy,
    };
  },
};
</script>

<style></style>
