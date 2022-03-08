<template>
  <div class="row">
    <div class="col-xl-12">
      <!-- card -->
      <div class="card">
        <!-- card body -->
        <div class="card-body">
          <table class="table table-stripped">
            <thead>
            <tr>
              <th>#</th>
              <th>Business Name</th>
              <th>Phone</th>
              <th>Date Incorp</th>
              <th>Address</th>
              <th>RC Number</th>
              <th>Business Type</th>
              <th>Date Registered</th>
              <th>View Account Details</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="( customerKYCs, index) in customerKYCs">
              <td>{{index+1}}</td>
              <td>{{customerKYCs.business_name}}</td>
              <td>{{customerKYCs.phone}}</td>
              <td>{{customerKYCs.date_of_incorporation}}</td>
              <td>{{customerKYCs.address}}</td>
              <td>{{customerKYCs.rc_number}}</td>
              <td>{{customerKYCs.business_type}}</td>
              <td>{{customerKYCs.created_at}}</td>
              <td><Link class="btn btn-warning" :href="'/customer/'+customerKYCs.id">View Account Details</Link></td>
            </tr>
            </tbody>
          </table>

        </div>
        <!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end row-->


    <!-- end col -->
  </div>
  <!-- end row-->
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
  components: {
    Link
  },
  props: {
    customerKYCs: Object
  },
  method: {
    customerKycDetails($id){

    }
  },
  mounted(){
    // console.log(this.customerKYCs)
  }

}
</script>