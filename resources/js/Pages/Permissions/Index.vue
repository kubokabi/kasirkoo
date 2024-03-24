<template>
  <Head>
    <title>Permissions - Aplikasi Kasir</title>
  </Head>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Permissions</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <Link href="/permissions"><i class="fa fa-lock"></i></Link>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-sm-12">
              <div class="card-box table-responsive">
                <form @submit.prevent="handleSearch">
                  <div
                    class="col-md-12 col-sm-12 form-group pull-right top_search"
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
                </form>

                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Permission Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(permission, index) in permissions.data"
                      :key="index"
                    >
                      <td>{{ permission.name }}</td>
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
    permissions: Object, // <- nama props yang dibuat di controller saat parsing data
  },

  setup() {
    //define state search
    const search = ref("" || new URL(document.location).searchParams.get("q"));

    //define method search
    const handleSearch = () => {
      Inertia.get("/permissions", {
        //send params "q" with value from state "search"
        q: search.value,
      });
    };

    //return
    return {
      search,
      handleSearch,
    };
  },
};
</script>

<style></style>
