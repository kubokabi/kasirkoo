<template>
  <div v-if="hasAnyPermission(['customers.edit'])">
    <Head>
      <title>Edit Customers</title>
    </Head>
    <!-- edit form  -->
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit Customers</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <a><i class="fa fa-pencil-square-o"></i></a>
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
                  <input
                    class="form-control"
                    v-model="form.no_telp"
                    :class="{ 'is-invalid': errors.no_telp }"
                    type="int"
                    placeholder="Maximum 15 numbers"
                  />
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
              <Link href="/customers" class="btn btn-secondary btn-md shadow-sm"
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
    customer: Object,
    errors: Object,
  },

  //define Composition Api
  setup(props) {
    const form = reactive({
      name: props.customer.name,
      no_telp: props.customer.no_telp,
      address: props.customer.address,
    });

    //function updatecategory
    function submit() {
      // send category using Inertia.put()
      Inertia.put(`/customers/${props.customer.id}`, {
        //data
        name: form.name,
        no_telp: form.no_telp,
        address: form.address,
      });
    }

    return {
      form,
      submit,
    };
  },
};
</script>
