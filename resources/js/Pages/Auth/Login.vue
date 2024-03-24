<template>
  <Head>
    <title>Login Account - Aplikasi Kasir</title>
  </Head>

  <div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
        <div v-if="session.status" class="alert alert-success mt-2">
          {{ session.status }}
        </div>
        <form @submit.prevent="submit">
          <h1>Login Account</h1>
          <div>
            <input
              v-model="form.email"
              :class="{ 'is-invalid': errors.email }"
              type="email"
              class="form-control"
              placeholder="Your Email"
            />
          </div>
          <div>
            <input
              v-model="form.password"
              :class="{ 'is-invalid': errors.password }"
              type="password"
              placeholder="Your Password"
              class="form-control"
            />
          </div>
          <p class="text-right">
            <Link class="reset_pass" href="/forgot-password"
              >Lost your password?</Link
            >
          </p>
          <button
            class="btn btn-dark shadow-sm rounded-sm px-4 w-100"
            type="submit"
          >
            LOGIN
          </button>

          <div class="clearfix"></div>

          <div class="separator">
            <div class="clearfix"></div>
            <br />

            <div>
              <h1><i class="fa fa-btc"></i> Point Of Sales</h1>
              <p>©2024 All Rights Reserved.</p>
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
</template>

<script>
//import reactive
import { reactive } from "vue";

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";

//import Heade and useForm from Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
  //register component
  components: {
    Head,
    Link,
  },

  props: {
    errors: Object,
    session: Object,
  },

  //define composition API
  setup() {
    //define form state
    const form = reactive({
      email: "",
      password: "",
    });

    //submit method
    const submit = () => {
      //send data to server
      Inertia.post("/login", {
        //data
        email: form.email,
        password: form.password,
      });
    };

    //return form state and submit method
    return {
      form,
      submit,
    };
  },
};
</script>

<style>
</style>