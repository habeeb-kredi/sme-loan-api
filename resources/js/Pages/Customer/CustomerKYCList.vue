<template>

  <Menu></Menu>
  <div class="main-content">

    <div class="page-content">
      <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Customers</h4>

              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                  <li class="breadcrumb-item active">Customers</li>
                </ol>
              </div>

            </div>
          </div>
        </div>
        <!-- end page title -->

      <CustomerKYCList :customerKYCs="this.$props.customerKYCs"/>






        <!-- end row -->
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <Footer></Footer>
  </div>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Footer from '@/Layouts/Admin/Footer.vue'
import Menu from '@/Layouts/Admin/Menu.vue'
import { Link } from '@inertiajs/inertia-vue3'
import CustomerKYCList from '../../Components/Customer/CustomerKYCList'

export default {
  components: {
    CustomerKYCList,
    Link,
    Footer,
    Menu
    // BreezeAuthenticatedLayout,
    // Head,
  },
  props: {
    customerKYCs: Object
  },
  methods: {

  },
  mounted(){

  }

}
</script>
