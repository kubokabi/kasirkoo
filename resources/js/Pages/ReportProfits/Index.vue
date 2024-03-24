<template>
  <Head>
    <title>Report Profits - Aplikasi Kasir</title>
  </Head>

  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Report Profits</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <Link href="/profits"><i class="fa fa-line-chart"></i></Link>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form @submit.prevent="filter">
            <div class="row">
              <div class="col-md-5">
                <div class="mb-3">
                  <label class="form-label fw-bold">START DATE</label>
                  <input
                    type="date"
                    v-model="start_date"
                    class="form-control"
                  />
                </div>
                <div v-if="errors.start_date" class="alert alert-danger">
                  {{ errors.start_date }}
                </div>
              </div>
              <div class="col-md-5">
                <div class="mb-3">
                  <label class="form-label fw-bold">END DATE</label>
                  <input type="date" v-model="end_date" class="form-control" />
                </div>
                <div v-if="errors.end_date" class="alert alert-danger">
                  {{ errors.end_date }}
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label class="form-label fw-bold text-white">*</label>
                  <button class="btn btn-md btn-purple border-0 shadow w-100">
                    <i class="fa fa-filter"></i> FILTER
                  </button>
                </div>
              </div>
            </div>
          </form>

          <div v-if="profits">
            <hr />
            <div class="export text-end mb-3">
              <a
                :href="`/profits/export?start_date=${start_date}&end_date=${end_date}`"
                target="_blank"
                class="btn btn-success btn-md border-0 shadow me-3"
                ><i class="fa fa-file-excel-o"></i> EXCEL</a
              >
              <a
                :href="`/profits/pdf?start_date=${start_date}&end_date=${end_date}`"
                target="_blank"
                class="btn btn-danger btn-md border-0 shadow"
                ><i class="fa fa-file-pdf-o"></i> PDF</a
              >
            </div>
            <table class="table table-bordered">
              <thead>
                <tr style="background-color: #e6e6e7">
                  <th scope="col">Date</th>
                  <th scope="col">Invoice</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="profit in profits" :key="profit.id">
                  <td>{{ profit.created_at }}</td>
                  <td class="text-center">{{ profit.transaction.invoice }}</td>
                  <td class="text-end">Rp. {{ formatPrice(profit.total) }}</td>
                </tr>
                <tr>
                  <td
                    colspan="2"
                    class="text-end fw-bold"
                    style="background-color: #e6e6e7"
                  >
                    TOTAL
                  </td>
                  <td
                    class="text-end fw-bold"
                    style="background-color: #e6e6e7"
                  >
                    Rp. {{ formatPrice(total) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//import layout
import LayoutApp from "../../Layouts/App.vue";

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
    errors: Object,
    profits: Array,
    total: Number,
  },
  //composition API
  setup() {
    //define state
    const start_date = ref(
      "" || new URL(document.location).searchParams.get("start_date")
    );
    const end_date = ref(
      "" || new URL(document.location).searchParams.get("end_date")
    );

    //define methods filter
    const filter = () => {
      //HTTP request
      Inertia.get("/profits/filter", {
        //send data to server
        start_date: start_date.value,
        end_date: end_date.value,
      });
    };

    return {
      start_date,
      end_date,
      filter,
    };
  },
};
</script>

<style></style>